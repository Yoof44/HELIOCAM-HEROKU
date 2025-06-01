import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth, sendPasswordResetEmail } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

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

function setCookie(name, value, minutes) {
    const d = new Date();
    d.setTime(d.getTime() + (minutes * 60 * 1000));
    document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/`;
}

function getCookie(name) {
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    name = name + "=";
    for (let c of ca) {
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function updateResetAttempts() {
    const now = Date.now();
    let attempts = getCookie("resetAttempts");
    attempts = attempts ? JSON.parse(attempts) : [];

    attempts = attempts.filter(timestamp => now - timestamp < 60000);

    attempts.push(now);
    setCookie("resetAttempts", JSON.stringify(attempts), 5); 
    return attempts.length;
}

document.getElementById("requestBtn").addEventListener("click", () => {
    const email = document.getElementById("email").value.trim();

    if (!email) {
        alert("Please enter your email.");
        return;
    }

    const cooldownTimestamp = getCookie("resetCooldown");
    const now = Date.now();

    if (cooldownTimestamp && now < parseInt(cooldownTimestamp)) {
        const secondsLeft = Math.ceil((parseInt(cooldownTimestamp) - now) / 1000);
        alert(`Too many requests. Please wait ${secondsLeft} seconds before trying again.`);
        return;
    }

    const attemptCount = updateResetAttempts();

    if (attemptCount > 3) {
        setCookie("resetCooldown", now + 180000, 3);
        alert("Too many requests. You're on cooldown for 3 minutes.");
        return;
    }

    sendPasswordResetEmail(auth, email)
        .then(() => {
            alert("Password reset email sent! Check your inbox or spam.");
        })
        .catch((error) => {
            console.error("Error sending reset email:", error.message);
            alert("Error: " + error.message);
        });
});

document.getElementById("cancelBtn").addEventListener("click", () => {
    window.location.href = "/";
});
