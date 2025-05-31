import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword, sendEmailVerification, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-auth.js";
import { getDatabase, ref, set } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-database.js";


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
const database = getDatabase(app);

async function registerUser() {
    const fname = document.getElementById('fname').value;
    const uname = document.getElementById('uname').value;
    const contact = document.getElementById('contact').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const conPass = document.getElementById('con_pass').value;

    if (password !== conPass) {
        alert("Passwords do not match!");
        return;
    }

    try {
        const userCredential = await createUserWithEmailAndPassword(auth, email, password);
        const user = userCredential.user;

        const sanitizedEmail = email.replace(/\./g, '_');

        // Save user data to realtime database
        await set(ref(database, 'users/' + sanitizedEmail), {
            fullname: fname,
            username: uname,
            contact: contact,
            email: email,
            emailVerified: user.emailVerified
        });

        // Send verification email
        await sendEmailVerification(user);

        alert("A verification email has been sent. Please check your inbox.");

        // DO NOT redirect here; let onAuthStateChanged handle page routing

    } catch (error) {
        console.error("Error: ", error.message);
        alert("Error: " + error.message);
    }
}

// Listen to auth state changes and redirect accordingly
onAuthStateChanged(auth, async (user) => {
    if (user) {
        await user.reload(); // Refresh user info from Firebase

        if (!user.emailVerified) {
            // Redirect to /verify if user email not verified and not already there
            if (window.location.pathname !== "/verify") {
                window.location.href = "/verify";
            }
        } else {
            // Email verified, redirect away from /verify and auth pages to /home
            if (window.location.pathname === "/verify" || ["/", "/register", "/forgot_pass"].includes(window.location.pathname)) {
                window.location.href = "/home";
            }
        }
    } else {
        // No user logged in, redirect to login page if not already there
        if (!["/", "/register", "/forgot_pass"].includes(window.location.pathname)) {
            window.location.href = "/";
        }
    }
});

document.getElementById('submit').addEventListener('click', async function () {
    const button = document.getElementById('submit');
    const spinner = document.getElementById('spinner');
    const loginText = document.getElementById('loginText');

    loginText.style.display = "none";
    spinner.style.display = "inline-block";

    try {
        await registerUser();
    } finally {
        spinner.style.display = "none";
        loginText.style.display = "inline";
    }
});
