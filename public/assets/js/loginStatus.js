import { initializeApp } from "firebase/app";
import { getAuth, onAuthStateChanged, setPersistence, browserSessionPersistence } from "firebase/auth";
import { getFirestore } from "firebase/firestore";

const firebaseConfig = {
    apiKey: "AIzaSyB5IBiji1ZVN5Sx3ae7xj_3xY0WNLTW7gg",
    authDomain: "heliocam-dad8f.firebaseapp.com",
    databaseURL: "https://heliocam-dad8f-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "heliocam-dad8f",
    storageBucket: "heliocam-dad8f.firebasestorage.app",
    messagingSenderId: "393709127499",
    appId: "1:393709127499:android:68012f120209bb08738ace"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);

setPersistence(auth, browserSessionPersistence)
    .then(() => {
        console.log("Session persistence set");
    })
    .catch((error) => {
        console.error("Error setting persistence:", error);
    });

onAuthStateChanged(auth, (user) => {
    if (user) {
        document.cookie = `firebaseUser=${user.uid}; path=/;`; 
        console.log("User is signed in:", user);
    } else {
        document.cookie = "firebaseUser=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"; 
        console.log("No user signed in");
        window.location.href = "/login.php"; 
    }
});
