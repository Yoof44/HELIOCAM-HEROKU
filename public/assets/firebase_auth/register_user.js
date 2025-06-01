import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword, sendEmailVerification, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
import { getDatabase, ref, set } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";


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
    const registrationMessage = document.getElementById('registrationMessage');

    registrationMessage.textContent = ''; // Clear previous messages
    registrationMessage.className = 'mb-4 text-sm'; // Reset classes

    if (password !== conPass) {
        registrationMessage.textContent = "Passwords do not match!";
        registrationMessage.classList.add('text-red-600');
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

        registrationMessage.textContent = "Registration successful! A verification email has been sent. Please check your inbox.";
        registrationMessage.classList.remove('text-red-600');
        registrationMessage.classList.add('text-green-600');

        // Set a flag in sessionStorage to indicate successful registration
        sessionStorage.setItem('justRegistered', 'true');

        // Clear form fields
        document.getElementById('fname').value = '';
        document.getElementById('uname').value = '';
        document.getElementById('contact').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('con_pass').value = '';

        // login_status.js will handle redirection based on email verification status

    } catch (error) {
        console.error("Error: ", error.code, error.message); // Log code for debugging
        if (error.code === 'auth/email-already-in-use') {
            registrationMessage.textContent = "This email address is already registered. Please try logging in, or check your email for a verification link if you haven't verified yet.";
        } else if (error.code === 'auth/invalid-email') {
            registrationMessage.textContent = "The email address is not valid. Please enter a valid email.";
        } else if (error.code === 'auth/weak-password') {
            registrationMessage.textContent = "The password is too weak. Please choose a stronger password.";
        }
        else {
            registrationMessage.textContent = "Error: " + error.message;
        }
        registrationMessage.classList.remove('text-green-600');
        registrationMessage.classList.add('text-red-600');
    }
}

document.getElementById('submit').addEventListener('click', async function (event) {
    event.preventDefault(); // Prevent default form submission
    const button = document.getElementById('submit');
    const spinner = document.getElementById('spinner');
    const loginText = document.getElementById('loginText');

    loginText.style.display = "none";
    spinner.style.display = "inline-block";
    button.disabled = true; // Disable button during processing

    try {
        await registerUser();
    } finally {
        spinner.style.display = "none";
        loginText.style.display = "inline";
        button.disabled = false; // Re-enable button
    }
});
