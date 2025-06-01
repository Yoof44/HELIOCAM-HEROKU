import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
import { getDatabase, ref, get, update } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";

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

function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + "; path=/" + expires;
}

function getCookie(name) {
    let match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
    return match ? match[2] : null;
}

function getDeviceInfo() {
    return {
        deviceName: navigator.userAgent,
        deviceOs: navigator.platform,
        lastActive: Date.now(),
    };
}

async function storeLoginInfo(user) {
    if (!user || !user.email) return;

    const formattedEmail = user.email.replace(/\./g, "_");
    const cookieName = `logininfo_${formattedEmail}`;
    let loginInfoIndex = getCookie(cookieName);

    if (!loginInfoIndex) {
     
        const userRef = ref(db, `users/${formattedEmail}/`);
        try {
            const snapshot = await get(userRef);
            let nextIndex = 0;

            if (snapshot.exists()) {
                const keys = Object.keys(snapshot.val());
                const lastIndex = keys
                    .filter(k => k.startsWith("logininfo_"))
                    .map(k => parseInt(k.replace("logininfo_", ""), 10))
                    .filter(num => !isNaN(num))
                    .sort((a, b) => b - a)[0]; 

                nextIndex = lastIndex !== undefined ? lastIndex + 1 : 0;
            }

            loginInfoIndex = `logininfo_${nextIndex}`;
            setCookie(cookieName, loginInfoIndex, 365);
        } catch (error) {
            console.error("Error fetching login info index:", error);
            return;
        }
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const { latitude, longitude } = position.coords;
            const deviceInfo = { ...getDeviceInfo(), location: { latitude, longitude } };

            update(ref(db, `users/${formattedEmail}/${loginInfoIndex}`), deviceInfo);
        },
        (error) => {
            console.warn("Geolocation not available:", error);
            const deviceInfo = { ...getDeviceInfo(), location: "Unknown" };

       
            update(ref(db, `users/${formattedEmail}/${loginInfoIndex}`), deviceInfo);
        }
    );
}

onAuthStateChanged(auth, async (user) => {
    // Define path suffixes at the beginning of the function scope
    const loginPathSuffix = "/"; // Assuming root is login
    const registerPathSuffix = "/register";
    const registerPhpPathSuffix = "/register.php";
    const forgotPassPathSuffix = "/forgot_pass";
    const forgotPassPhpPathSuffix = "/forgot_pass.php";
    const verifyPathSuffix = "/verify";
    const verifyPhpPathSuffix = "/verify.php";
    const homePath = "/home";

    if (user) {
        await user.reload();
        storeLoginInfo(user);

        const justRegistered = sessionStorage.getItem('justRegistered');
        const currentPath = window.location.pathname;

        // Check if on the registration page (for the "just registered" scenario)
        const onRegisterPage = currentPath.endsWith(registerPathSuffix) || 
                             currentPath.endsWith(registerPhpPathSuffix) || 
                             (currentPath.endsWith(loginPathSuffix) && justRegistered && currentPath === loginPathSuffix);


        if (!user.emailVerified) {
            if (justRegistered && onRegisterPage) {
                // User just registered and is on the registration page.
                // register_user.js has displayed its message. Do not redirect.
                console.log("Login_status.js: User just registered, email not verified. Staying on current page to show registration message.");
                sessionStorage.removeItem('justRegistered'); // Clear the flag
            } else {
                // User is logged in, email not verified, and it's NOT the "just registered on register page" scenario.
                // Per user request, do not redirect to /verify.php or any verification page.
                // They remain on the current page.
                // A site-wide banner for "email not verified" could be implemented separately if needed.
                if (!currentPath.endsWith(verifyPathSuffix) && !currentPath.endsWith(verifyPhpPathSuffix)) {
                    console.log(`Login_status.js: User logged in, email not verified (${user.email}). Current page: ${currentPath}. Not redirecting to a verify page.`);
                    alert("Your email is not verified. Please check your email to verify your account.");
                    window.location.href = "/"; // Redirect to login.php
                }
            }
        } else { // User IS emailVerified
            sessionStorage.removeItem('justRegistered'); // Clean up flag if it exists

            // Paths that, if a verified user lands on them, should trigger a redirect to homePath.
            // The login page (root "/") is NOT in this list.
            const authPagesToLeaveWhenVerifiedSuffixes = [
                registerPathSuffix, registerPhpPathSuffix,
                forgotPassPathSuffix, forgotPassPhpPathSuffix,
                verifyPathSuffix, verifyPhpPathSuffix
            ];

            let redirectToHome = false;
            for (const pathSuffix of authPagesToLeaveWhenVerifiedSuffixes) {
                if (currentPath.endsWith(pathSuffix)) {
                    // Ensure it's not just a partial match if paths are like /path and /path-something
                    // This check is basic; for complex routing, more robust checks might be needed.
                    if (currentPath === pathSuffix || currentPath.endsWith(pathSuffix)) {
                         redirectToHome = true;
                         break;
                    }
                }
            }

            if (redirectToHome) {
                console.log(`Login_status.js: User verified. On auth page ${currentPath}. Redirecting to ${homePath}.`);
                window.location.href = homePath;
            } else if (currentPath.endsWith(loginPathSuffix) && currentPath === loginPathSuffix) { // Explicitly check for the root/login page
                // User is verified and on the login page. They must log in manually.
                console.log(`Login_status.js: User verified. On login page (${currentPath}). Staying.`);
                // login_user.js will handle the actual login and then redirect to homePath.
            }
            // If user is verified and on any other page (e.g., already on /home, or /profile), they stay.
        }
    } else { // User is not logged in
        sessionStorage.removeItem('justRegistered'); // Clean up flag

        const currentPath = window.location.pathname;

        // Allowed guest page suffixes (user can be on these if not logged in)
        const allowedGuestSuffixes = [
            registerPathSuffix, registerPhpPathSuffix,
            forgotPassPathSuffix, forgotPassPhpPathSuffix,
            verifyPathSuffix, verifyPhpPathSuffix
            // loginPathSuffix ("/") is handled by an explicit check below
        ];

        let onAllowedGuestPage = false;
        if (currentPath.endsWith(loginPathSuffix) && currentPath === loginPathSuffix) { // Explicitly check for root
            onAllowedGuestPage = true;
        } else {
            for (const suffix of allowedGuestSuffixes) {
                if (currentPath.endsWith(suffix)) {
                     // Basic check, ensure it's a full match for the suffix part
                    if (currentPath === suffix || currentPath.endsWith(suffix)) {
                        onAllowedGuestPage = true;
                        break;
                    }
                }
            }
        }

        if (!onAllowedGuestPage) {
            console.log(`Login_status.js: User not logged in. Current path ${currentPath}. Redirecting to login page (${loginPathSuffix}).`);
            window.location.href = loginPathSuffix; // Redirect to login page
        }
    }
});
