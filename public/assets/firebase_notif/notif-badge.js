// Notification Badge Manager for HelioCam
// Displays notification badges on the bell icon across all pages

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";
import { getDatabase, ref, onValue, get } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-database.js";

// Firebase configuration - same as other files
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

// Constants for storage
const PREFS_NAME = "NotificationPrefs";
const DELETED_NOTIFICATIONS_KEY = "deleted_notifs";

class NotificationBadgeManager {
    constructor() {
        this.sessionKeys = [];
        this.notificationCount = 0;
        this.deletedNotifications = new Set();
        this.initialize();
    }

    initialize() {
        // Get saved deleted notifications from localStorage
        this.loadDeletedNotificationsFromStorage();

        // Listen for auth state changes
        onAuthStateChanged(auth, (user) => {
            if (user) {
                this.currentUser = user;
                this.fetchSessionKeys().then(() => {
                    this.setupRealTimeListeners();
                });
            } else {
                // Clear badge if no user is logged in
                this.updateBadge(0);
            }
        });

        // Listen for notification deletion events from notification-manager.js
        document.addEventListener('notification-deleted', () => {
            this.updateNotificationCount();
        });

        document.addEventListener('notifications-cleared', () => {
            this.updateBadge(0);
        });
    }

    loadDeletedNotificationsFromStorage() {
        try {
            const storedData = localStorage.getItem(PREFS_NAME);
            if (storedData) {
                const parsed = JSON.parse(storedData);
                if (parsed && parsed[DELETED_NOTIFICATIONS_KEY]) {
                    this.deletedNotifications = new Set(parsed[DELETED_NOTIFICATIONS_KEY]);
                }
            }
        } catch (error) {
            console.error("Error loading deleted notifications:", error);
            this.deletedNotifications = new Set();
        }
    }

    async fetchSessionKeys() {
        if (!this.currentUser || !this.currentUser.email) {
            return;
        }

        const formattedEmail = this.currentUser.email.replace(/\./g, '_');
        const userRef = ref(database, `users/${formattedEmail}`);
        
        try {
            const userSnapshot = await get(userRef);
            
            if (!userSnapshot.exists()) {
                return;
            }
            
            this.sessionKeys = [];
            const userData = userSnapshot.val();
            
            // Check login info nodes for sessions
            Object.keys(userData).forEach(key => {
                if (key.startsWith('logininfo_')) {
                    const loginInfo = userData[key];
                    if (loginInfo.sessions_added) {
                        Object.keys(loginInfo.sessions_added).forEach(sessionKey => {
                            if (!this.sessionKeys.includes(sessionKey)) {
                                this.sessionKeys.push(sessionKey);
                            }
                        });
                    }
                }
            });
            
            // Also check directly in sessions node
            if (userData.sessions) {
                Object.keys(userData.sessions).forEach(sessionKey => {
                    if (!this.sessionKeys.includes(sessionKey)) {
                        this.sessionKeys.push(sessionKey);
                    }
                });
            }
        } catch (error) {
            console.error("Error fetching session keys:", error);
        }
    }

    setupRealTimeListeners() {
        if (!this.currentUser || !this.currentUser.email) {
            return;
        }

        const formattedEmail = this.currentUser.email.replace(/\./g, '_');
        
        // Listen for universal notifications
        const universalRef = ref(database, `users/${formattedEmail}/universal_notifications`);
        onValue(universalRef, snapshot => {
            this.updateNotificationCount();
        });
        
        // Listen for session-specific notifications
        for (const sessionKey of this.sessionKeys) {
            const sessionNotifRef = ref(database, `users/${formattedEmail}/sessions/${sessionKey}/notifications`);
            onValue(sessionNotifRef, snapshot => {
                this.updateNotificationCount();
            });
        }
    }

    async updateNotificationCount() {
        if (!this.currentUser || !this.currentUser.email) {
            this.updateBadge(0);
            return;
        }

        const formattedEmail = this.currentUser.email.replace(/\./g, '_');
        let count = 0;
        
        try {
            // Count universal notifications
            const universalRef = ref(database, `users/${formattedEmail}/universal_notifications`);
            const universalSnapshot = await get(universalRef);
            
            if (universalSnapshot.exists()) {
                const universalData = universalSnapshot.val();
                Object.keys(universalData).forEach(notificationId => {
                    if (!this.deletedNotifications.has(notificationId)) {
                        count++;
                    }
                });
            }
            
            // Count session notifications
            for (const sessionKey of this.sessionKeys) {
                const sessionNotifRef = ref(database, `users/${formattedEmail}/sessions/${sessionKey}/notifications`);
                const sessionSnapshot = await get(sessionNotifRef);
                
                if (sessionSnapshot.exists()) {
                    const sessionData = sessionSnapshot.val();
                    Object.keys(sessionData).forEach(notificationId => {
                        if (!this.deletedNotifications.has(notificationId)) {
                            count++;
                        }
                    });
                }
            }
            
            // Update the badge with the new count
            this.updateBadge(count);
            
        } catch (error) {
            console.error("Error counting notifications:", error);
            this.updateBadge(0);
        }
    }

    updateBadge(count) {
        // Find all notification bell icons across the site
        const navBellIcons = document.querySelectorAll('a[href="/notification"] i.fa-bell');
        
        navBellIcons.forEach(navBellIcon => {
            // Find existing badge or create a new one
            const parentLink = navBellIcon.closest('a');
            if (!parentLink) return;

            let badge = parentLink.querySelector('.notification-badge');
            
            if (count > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'notification-badge absolute bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center';
                    parentLink.style.position = 'relative';
                    parentLink.appendChild(badge);
                }
                badge.textContent = count > 9 ? '9+' : count;
            } else if (badge) {
                badge.remove();
            }
        });
    }
}

// Create and start the notification badge manager when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const badgeManager = new NotificationBadgeManager();
});