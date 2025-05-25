import { initializeApp } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-auth.js";
import { getDatabase, ref, onValue, update } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-database.js";

// Make sure your Firebase config has the correct values
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

// Wait for the DOM to load
document.addEventListener('DOMContentLoaded', function() {
  // Determine which page we're on
  const isEditProfilePage = document.getElementById('edit-profile-form') !== null;
  const isProfilePage = document.getElementById('profile-form') !== null;
  
  console.log("Auth state check starting...");
  
  // Listen for authentication state changes
  onAuthStateChanged(auth, (user) => {
    console.log("Auth state changed:", user ? "User logged in" : "No user");
    
    if (user) {
      // User is signed in
      console.log("User is signed in:", user.email);
      
      try {
        // Get the user's email and format it for Firebase path
        const userEmail = user.email.replace(/\./g, '_'); // Replace ALL dots with underscores
        
        // Reference to the user's data in the database
        const userRef = ref(database, `users/${userEmail}`);
        
        console.log("Fetching data for:", userEmail);
        
        // Listen for data from the database
        onValue(userRef, (snapshot) => {
          console.log("Data received:", snapshot.exists() ? "Yes" : "No");
          const userData = snapshot.val();
          
          if (userData) {
            console.log("User data found:", Object.keys(userData));
            // Populate form fields with user data
            const fields = ['fname', 'email', 'uname', 'contact'];
            fields.forEach(field => {
              const element = document.getElementById(field);
              if (element) {
                if (field === 'email') {
                  element.value = userData.email || user.email;
                } else {
                  const fieldMapping = {
                    'fname': 'fullname',
                    'uname': 'username',
                    'contact': 'contact'
                  };
                  element.value = userData[fieldMapping[field]] || 'Not set';
                }
              }
            });
            
            // If on profile page, update the username at the top
            if (isProfilePage) {
              const usernameElement = document.getElementById('profile-username');
              if (usernameElement && userData.username) {
                usernameElement.textContent = userData.username;
              }
            }
          } else {
            console.log("No user data found, setting defaults");
            // No user data found, set defaults
            const emailElement = document.getElementById('email');
            if (emailElement) emailElement.value = user.email;
            
            ['fname', 'uname', 'contact'].forEach(field => {
              const element = document.getElementById(field);
              if (element) element.value = 'Not set';
            });
          }
          
          // Hide loading indicator and show appropriate form
          const loadingIndicator = document.getElementById('loading-indicator');
          if (loadingIndicator) loadingIndicator.style.display = 'none';
          
          if (isEditProfilePage) {
            const form = document.getElementById('edit-profile-form');
            if (form) form.style.display = 'block';
          } else if (isProfilePage) {
            const form = document.getElementById('profile-form');
            if (form) form.style.display = 'block';
          }
          
          if (isProfilePage) {
            console.log("Handling profile page display");
            const userData = snapshot.val();
            
            if (userData) {
              // For each field, update both the hidden input and the display div
              const fields = ['fname', 'email', 'uname', 'contact'];
              fields.forEach(field => {
                const inputElement = document.getElementById(field);
                const displayElement = document.getElementById(field + '-display');
                
                if (inputElement && displayElement) {
                  let value;
                  
                  if (field === 'email') {
                    value = userData.email || user.email;
                  } else {
                    const fieldMapping = {
                      'fname': 'fullname',
                      'uname': 'username',
                      'contact': 'contact'
                    };
                    value = userData[fieldMapping[field]] || 'Not set';
                  }
                  
                  // Set the hidden input value for any JavaScript that needs it
                  inputElement.value = value;
                  
                  // Set the text content of the display div
                  displayElement.textContent = value;
                  
                  // Add a placeholder style if the value is 'Not set'
                  if (value === 'Not set') {
                    displayElement.classList.add('text-gray-500', 'italic');
                  } else {
                    displayElement.classList.remove('text-gray-500', 'italic');
                  }
                  
                  console.log(`Updated ${field} display with: ${value}`);
                }
              });
              
              // Update the username at the top if available
              const usernameElement = document.getElementById('profile-username');
              if (usernameElement && userData.username) {
                usernameElement.textContent = userData.username;
              }
            } else {
              console.log("No user data found, setting defaults");
              // No user data found, set defaults
              const fields = ['fname', 'uname', 'contact'];
              fields.forEach(field => {
                const inputElement = document.getElementById(field);
                const displayElement = document.getElementById(field + '-display');
                
                if (inputElement) inputElement.value = 'Not set';
                if (displayElement) {
                  displayElement.textContent = 'Not set';
                  displayElement.classList.add('text-gray-500', 'italic');
                }
              });
              
              // Email is special case
              const emailElement = document.getElementById('email');
              const emailDisplayElement = document.getElementById('email-display');
              if (emailElement) emailElement.value = user.email;
              if (emailDisplayElement) emailDisplayElement.textContent = user.email;
            }
          }
        }, {
          onlyOnce: true
        });
      } catch (error) {
        console.error("Error fetching user data:", error);
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
          loadingIndicator.innerHTML = '<p class="text-red-500">Error loading profile: ' + error.message + '</p>';
        }
      }
      
      // Handle edit profile form submission if on edit page
      if (isEditProfilePage) {
        const editProfileForm = document.getElementById('edit-profile-form');
        if (editProfileForm) {
          editProfileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show saving indicator
            const submitBtn = document.getElementById('update-btn');
            if (submitBtn) {
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
              
              try {
                const userEmail = user.email.replace(/\./g, '_');
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
                    console.error("Update failed:", error);
                    alert('Failed to update profile: ' + error.message);
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                  });
              } catch (error) {
                console.error("Update error:", error);
                alert('Error updating profile: ' + error.message);
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
              }
            }
          });
        }
      }
      
      // If on profile page, add display text to non-interactive divs
      if (isProfilePage) {
        const fields = ['fname', 'email', 'uname', 'contact'];
        
        fields.forEach(field => {
            const inputElement = document.getElementById(field);
            const displayElement = document.getElementById(field + '-display');
            
            if (inputElement && displayElement) {
                // Set the text content of the display div
                displayElement.textContent = inputElement.value || 'Not set';
                
                // Handle empty/Not set values with placeholder style
                if (inputElement.value === '' || inputElement.value === 'Not set') {
                    displayElement.classList.add('text-gray-500');
                    displayElement.textContent = 'Not set';
                }
            }
        });
        
        // Also update the username at the top if available
        const usernameElement = document.getElementById('profile-username');
        const username = document.getElementById('uname').value;
        if (usernameElement && username && username !== 'Not set') {
            usernameElement.textContent = username;
        }
      }
    } else {
      // User is signed out
      console.log("No user is signed in, redirecting to login");
      // Redirect to login page
      window.location.href = "/login";
    }
  }, (error) => {
    console.error("Auth state error:", error);
    const loadingIndicator = document.getElementById('loading-indicator');
    if (loadingIndicator) {
      loadingIndicator.innerHTML = '<p class="text-red-500">Authentication error: ' + error.message + '</p>';
    }
  });
});