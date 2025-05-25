import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";
import { getDatabase, ref, get, set } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

const firebaseConfig = {
    apiKey: "AIzaSyB5IBiji1ZVN5Sx3ae7xj_3xY0WNLTW7gg",
    authDomain: "heliocam-dad8f.firebaseapp.com",
    databaseURL: "https://heliocam-dad8f-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "heliocam-dad8f",
    storageBucket: "heliocam-dad8f.appspot.com",
    messagingSenderId: "393709127499",
    appId: "1:393709127499:web:68012f120209bb08738ace",
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getDatabase(app);

let existingSessions = {};

window.onload = () => {
    onAuthStateChanged(auth, async (user) => {
        if (!user || !user.email) return;

        const formattedEmail = user.email.replace(/\./g, "_");
        const loginInfoIndex = getCookie(`logininfo_${formattedEmail}`);
        if (!loginInfoIndex) return;

        const sessionsAddedRef = ref(db, `users/${formattedEmail}/${loginInfoIndex}/sessions_added`);

        try {
            const addedSessionsSnapshot = await get(sessionsAddedRef);
            if (addedSessionsSnapshot.exists()) {
                existingSessions = addedSessionsSnapshot.val();
                console.log("Preloaded existing sessions:", existingSessions);
            } else {
                existingSessions = {}; 
                console.log("No existing sessions preloaded.");
            }
        } catch (error) {
            console.error("Error fetching existing sessions:", error);
        }
    });
};

document.getElementById("submit").addEventListener("click", async () => {
    const passkeyInput = document.getElementById("passkey");
    if (!passkeyInput) {
        console.error("Passkey input field not found!");
        return;
    }

    const passkey = passkeyInput.value.trim();
    if (!passkey) {
        console.warn("Passkey is empty");
        return;
    }

    const user = auth.currentUser;
    if (!user || !user.email) {
        console.warn("User not logged in");
        return;
    }

    const formattedEmail = user.email.replace(/\./g, "_");
    const loginInfoIndex = getCookie(`logininfo_${formattedEmail}`);
    if (!loginInfoIndex) {
        console.warn("No login info index found in cookies");
        return;
    }

    const userSessionsRef = ref(db, `users/${formattedEmail}/sessions`);

    try {
        const sessionsSnapshot = await get(userSessionsRef);
        if (!sessionsSnapshot.exists()) {
            showModal("sessionNotFoundModal");
            return;
        }

        const sessions = sessionsSnapshot.val();

        for (const sessionKey in sessions) {
            if (sessions[sessionKey]?.passkey === passkey) {
        
                if (existingSessions && existingSessions[sessionKey]) {
                    console.warn("Session already exists:", sessionKey);
                    showModal("sessionExistsModal");
                    return;
                }

              
                await set(ref(db, `users/${formattedEmail}/${loginInfoIndex}/sessions_added/${sessionKey}`), sessions[sessionKey]);
                existingSessions[sessionKey] = sessions[sessionKey];
                showModal("sessionAddedModal");
                return;
            }
        }

        showModal("sessionNotFoundModal");
    } catch (error) {
        console.error("Error retrieving or storing session data:", error);
    }
});


function showModal(modalId) {
    var modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
}

function getCookie(name) {
    const match = document.cookie.match(new RegExp(`(^| )${name}=([^;]+)`));
    return match ? decodeURIComponent(match[2]) : null;
}
