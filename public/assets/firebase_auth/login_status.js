import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";
import { getDatabase, ref, get, update } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

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

function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + "; path=/" + expires;
}

function getCookie(name) {
    let match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
    return match ? match[2] : null;
}

function getDeviceInfo() {
    return {
        deviceName: navigator.userAgent,
        deviceOs: navigator.platform,
        lastActive: Date.now(),
    };
}

async function storeLoginInfo(user) {
    if (!user || !user.email) return;

    const formattedEmail = user.email.replace(/\./g, "_");
    const cookieName = `logininfo_${formattedEmail}`;
    let loginInfoIndex = getCookie(cookieName);

    if (!loginInfoIndex) {
     
        const userRef = ref(db, `users/${formattedEmail}/`);
        try {
            const snapshot = await get(userRef);
            let nextIndex = 0;

            if (snapshot.exists()) {
                const keys = Object.keys(snapshot.val());
                const lastIndex = keys
                    .filter(k => k.startsWith("logininfo_"))
                    .map(k => parseInt(k.replace("logininfo_", ""), 10))
                    .filter(num => !isNaN(num))
                    .sort((a, b) => b - a)[0]; 

                nextIndex = lastIndex !== undefined ? lastIndex + 1 : 0;
            }

            loginInfoIndex = `logininfo_${nextIndex}`;
            setCookie(cookieName, loginInfoIndex, 365);
        } catch (error) {
            console.error("Error fetching login info index:", error);
            return;
        }
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const { latitude, longitude } = position.coords;
            const deviceInfo = { ...getDeviceInfo(), location: { latitude, longitude } };

            update(ref(db, `users/${formattedEmail}/${loginInfoIndex}`), deviceInfo);
        },
        (error) => {
            console.warn("Geolocation not available:", error);
            const deviceInfo = { ...getDeviceInfo(), location: "Unknown" };

       
            update(ref(db, `users/${formattedEmail}/${loginInfoIndex}`), deviceInfo);
        }
    );
}

onAuthStateChanged(auth, async (user) => {
    if (user) {
        await user.reload();  // make sure we get updated emailVerified status
        if (!user.emailVerified) {
            console.log("User email not verified. Redirecting to /verify");
            window.location.href = "/verify"; 
            return;
        }

        // If user is verified, then proceed with "User is logged in" redirect
        console.log("User is logged in");
        window.location.href = "/home";  // or wherever logged-in users go
    } else {
        console.log("No user logged in");
        // optionally stay on page or redirect to login
    }
});
