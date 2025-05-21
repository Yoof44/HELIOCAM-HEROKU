import { initializeApp } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-auth.js";
import { getDatabase, ref, onValue, update } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-database.js";

// Your web app's Firebase configuration
// Replace with your actual Firebase config
const firebaseConfig = {
    apiKey: "AIzaSyB5IBiji1ZVN5Sx3ae7xj_3xY0WNLTW7gg",
    authDomain: "heliocam-dad8f.firebaseapp.com",
    databaseURL: "https://heliocam-dad8f-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "heliocam-dad8f",
    storageBucket: "heliocam-dad8f.appspot.com",
    messagingSenderId: "393709127499",
    appId: "1:393709127499:web:68012f120209bb08738ace",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const database = getDatabase(app);

document.addEventListener('DOMContentLoaded', function() {
  // Get the form element
  const profileForm = document.getElementById('edit-profile-form');
  
  // Listen for authentication state changes
  onAuthStateChanged(auth, (user) => {
    if (user) {
      // User is signed in
      const userEmail = user.email.replace('.', '_');
      const userRef = ref(database, `users/${userEmail}`);
      
      // Fill the form with user data
      onValue(userRef, (snapshot) => {
        const userData = snapshot.val();
        
        if (userData) {
          document.getElementById('fname').value = userData.fullname || '';
          document.getElementById('email').value = userData.email || user.email;
          document.getElementById('uname').value = userData.username || '';
          document.getElementById('contact').value = userData.contact || '';
        } else {
          document.getElementById('email').value = user.email;
        }
        
        // Hide loading indicator and show form
        document.getElementById('loading-indicator').style.display = 'none';
        document.getElementById('edit-profile-form').style.display = 'block';
      }, {
        onlyOnce: true
      });
      
      // Handle form submission
      profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show saving indicator
        const submitBtn = document.getElementById('update-btn');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
        submitBtn.disabled = true;
        
        // Get form values
        const fullname = document.getElementById('fname').value;
        const username = document.getElementById('uname').value;
        const contact = document.getElementById('contact').value;
        
        // Prepare data to update
        const updates = {
          fullname: fullname,
          username: username,
          contact: contact,
          email: user.email
        };
        
        // Update user data in Firebase
        update(ref(database, `users/${userEmail}`), updates)
          .then(() => {
            // Success message
            alert('Profile updated successfully!');
            // Redirect back to profile page
            window.location.href = '/profile';
          })
          .catch((error) => {
            // Error message
            alert('Failed to update profile: ' + error.message);
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
          });
      });
    } else {
      // User is signed out
      window.location.href = "/login";
    }
  });
});