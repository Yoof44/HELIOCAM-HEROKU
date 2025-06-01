import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

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

document.getElementById("loginForm").addEventListener("submit", async function (event) {
    event.preventDefault();
    
    const loginBtn = document.getElementById("loginBtn");
    const loginText = document.getElementById("loginText");
    const spinner = document.getElementById("spinner");

    loginBtn.disabled = true;
    loginText.style.display = "none";
    spinner.style.display = "inline-block";

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    try {
        const userCredential = await signInWithEmailAndPassword(auth, email, password);
        const user = userCredential.user;

        if (user && !user.emailVerified) {
            alert("Your email is not verified. Please check your email and verify your account before logging in.");
            // Optionally, sign out the user if you don't want them to be in a partially logged-in state
            // await signOut(auth); // You'll need to import signOut from firebase/auth
        } else if (user && user.emailVerified) {
            window.location.href = "/home";
        } else {
            // This case should ideally not be reached if signInWithEmailAndPassword was successful
            alert("Login failed. Please try again.");
        }
    } catch (error) {
        if (error.code === 'auth/user-not-found') {
            alert("Login failed: No account found with this email address.");
        } else if (error.code === 'auth/wrong-password') {
            alert("Login failed: Incorrect password.");
        } else {
            alert("Login failed: " + error.message);
        }
    } finally {
        loginBtn.disabled = false;
        loginText.style.display = "inline";
        spinner.style.display = "none";
    }
});

