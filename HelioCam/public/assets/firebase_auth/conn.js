import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getDatabase } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";

const firebaseConfig = {
  apiKey: "AIzaSyB5IBiji1ZVN5Sx3ae7xj_3xY0WNLTW7gg", // Replace with your actual API key
  authDomain: "heliocam-dad8f.firebaseapp.com",
  databaseURL: "https://heliocam-dad8f-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "heliocam-dad8f",
  storageBucket: "heliocam-dad8f.appspot.com",
  messagingSenderId: "393709127499",
  appId: "1:393709127499:web:68012f120209bb08738ace",
};

export const app = initializeApp(firebaseConfig);
export const database = getDatabase(app);
