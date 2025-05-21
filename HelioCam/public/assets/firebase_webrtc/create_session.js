import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";
import { getDatabase, ref, push, set, get, child, serverTimestamp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

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

// Helper function to generate random passkeys
function generateRandomPasskey(length = 6) {
    const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    let passkey = "";
    for (let i = 0; i < length; i++) {
        passkey += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return passkey;
}

// Add event listener for auto-generating passkeys if button exists
const generatePasskeyBtn = document.getElementById("generate-passkey");
if (generatePasskeyBtn) {
    generatePasskeyBtn.addEventListener("click", function() {
        const passkey = generateRandomPasskey();
        document.getElementById("session-passkey").value = passkey;
    });
}

document.getElementById("addContentBtn").addEventListener("click", async function () {
    let sessionName = document.getElementById("session-name").value.trim();
    let sessionPasskey = document.getElementById("session-passkey").value.trim();
    let location = document.getElementById("session-location")?.value.trim() || "No location";

    if (!sessionName || !sessionPasskey) {
        alert("Please enter both session name and passkey.");
        return;
    }

    // Get current authenticated user
    const user = auth.currentUser;
    if (!user) {
        alert("You must be logged in to create a session.");
        return;
    }

    try {
        // Generate a unique session ID
        const sessionId = `session_${Math.floor(Date.now() / 1000)}_PC`;
        const userEmail = user.email.replace(/\./g, "_");
        
        // Get browser and platform info
        const deviceInfo = {
            browser: navigator.userAgent,
            platform: navigator.platform
        };

        // Create the session data (more aligned with Java version)
        const sessionData = {
            session_name: sessionName,
            passkey: sessionPasskey,
            location: location,
            host_email: user.email,
            created_at: Date.now(),
            active: true,  // Match the Java implementation
            status: "waiting", // Session status: waiting for joiner
            device_info: deviceInfo,
            max_joiners: 4,   // Match the Java implementation - max 4 cameras
            current_joiners: 0 // Start with 0 joiners
        };

        // 1. Store the session in the user's sessions
        await set(ref(db, `users/${userEmail}/sessions/${sessionId}`), sessionData);

        // 2. Create a passkey lookup entry like in the Java implementation
        const sessionCodeData = {
            session_id: sessionId,
            host_email: user.email
        };
        await set(ref(db, `session_codes/${sessionPasskey}`), sessionCodeData);

        // 3. Store minimal info in the global sessions collection (keeping backward compatibility)
        await set(ref(db, `sessions/${sessionId}`), {
            passkey: sessionPasskey,
            host_email: user.email
        });

        // 4. Also store in the user's sessions_added for compatibility if needed
        const loginInfoN = getCookie(`logininfo_${userEmail}`);
        if (loginInfoN) {
            await set(ref(db, `users/${userEmail}/${loginInfoN}/sessions_added/${sessionId}`), sessionData);
        }

        // Redirect to the streaming page to host the session
        window.location.href = `/streaming?session_n=${sessionId}&session_name=${encodeURIComponent(sessionName)}&passkey=${sessionPasskey}`;
    } catch (error) {
        console.error("Error creating session:", error);
        alert("Failed to create session: " + error.message);
    }
});

// Helper function to get cookies
function getCookie(name) {
    const match = document.cookie.match(new RegExp(`(^| )${name}=([^;]+)`));
    return match ? decodeURIComponent(match[2]) : null;
}