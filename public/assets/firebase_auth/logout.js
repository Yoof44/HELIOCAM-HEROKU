import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, signOut } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";

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

function logoutUser() {
    signOut(auth)
        .then(() => {
            console.log("User signed out.");
            window.location.href = "/"; 
        })
        .catch((error) => {
            console.error("Error signing out:", error);
        });
}


document.getElementById("logoutButton")?.addEventListener("click", logoutUser);
