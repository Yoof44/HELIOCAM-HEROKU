// Notification Manager for HelioCam Web
// Handles fetching and displaying notifications from Firebase

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";
import { getDatabase, ref, get, onValue, off, remove } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-database.js";

// Firebase configuration
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

export default class NotificationManager {
    constructor() {
        this.sessionKeys = [];
        this.notificationMap = new Map();
        this.container = null;
        this.realTimeListeners = [];
    }

    // Initialize and start notification loading
    init(container, realTime = false) {
        this.container = container;
        this.realTime = realTime;
        this.showLoadingState(true);
        
        // Get saved deleted notifications from localStorage
        this.deletedNotifications = this.getDeletedNotificationsFromStorage();
        
        // Check if user is authenticated
        onAuthStateChanged(auth, (user) => {
            if (user) {
                this.currentUser = user;
                this.fetchSessionKeys().then(() => {
                    if (this.sessionKeys.length === 0) {
                        this.showEmptyState();
                    } else {
                        if (this.realTime) {
                            this.setupRealTimeListeners();
                        } else {
                            this.fetchNotificationsForSessions();
                        }
                    }
                });
            } else {
                this.showEmptyState("Please log in to view notifications");
            }
        });

        // Set up clear all button
        const clearAllBtn = document.querySelector('button.bg-orange-500');
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', () => this.clearAllNotifications());
        }
    }

    // Show loading state while fetching notifications
    showLoadingState(isLoading) {
        if (isLoading) {
            this.container.innerHTML = `
                <div class="bg-amber-50 rounded-lg p-4 flex justify-center items-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
                    <span class="ml-2">Loading notifications...</span>
                </div>
            `;
        }
    }

    // Show empty state when no notifications
    showEmptyState(message = "You don't have any notifications yet") {
        this.showLoadingState(false);
        this.container.innerHTML = `
            <div class="bg-amber-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div class="flex items-start space-x-3">
                        <div class="bg-gray-100 rounded-full p-3">
                            <i class="fas fa-bell-slash text-gray-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">No Notifications</h3>
                            <p class="text-sm text-gray-600">
                                ${message}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Fetch session keys for the current user
    async fetchSessionKeys() {
        if (!this.currentUser || !this.currentUser.email) {
            console.warn("No user logged in");
            return;
        }

        const formattedEmail = this.currentUser.email.replace(/\./g, '_');
        const userRef = ref(database, `users/${formattedEmail}`);
        
        try {
            const userSnapshot = await get(userRef);
            
            if (!userSnapshot.exists()) {
                console.warn("No data found for user.");
                return;
            }
            
            this.sessionKeys = [];
            const userData = userSnapshot.val();
            
            // First check login info nodes for sessions
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
            
            console.log(`Fetched ${this.sessionKeys.length} session keys`);
        } catch (error) {
            console.error("Error fetching session keys:", error);
        }
    }

    // Fetch notifications for all sessions and universal
    async fetchNotificationsForSessions() {
        if (!this.currentUser || !this.currentUser.email) {
            this.showEmptyState("Please log in to view notifications");
            return;
        }

        const formattedEmail = this.currentUser.email.replace(/\./g, '_');
        this.notificationMap.clear();
        
        try {
            // First fetch universal notifications
            const universalRef = ref(database, `users/${formattedEmail}/universal_notifications`);
            const universalSnapshot = await get(universalRef);
            
            if (universalSnapshot.exists()) {
                const universalData = universalSnapshot.val();
                Object.keys(universalData).forEach(notificationId => {
                    if (!this.deletedNotifications.has(notificationId)) {
                        const notification = universalData[notificationId];
                        this.notificationMap.set(notificationId, {
                            id: notificationId,
                            title: notification.reason,
                            date: notification.date,
                            time: notification.time,
                            type: this.getNotificationType(notification.reason)
                        });
                    }
                });
            }
            
            // Then fetch session-specific notifications
            for (const sessionKey of this.sessionKeys) {
                const sessionRef = ref(database, `users/${formattedEmail}/sessions/${sessionKey}`);
                const sessionSnapshot = await get(sessionRef);
                
                if (sessionSnapshot.exists()) {
                    const sessionData = sessionSnapshot.val();
                    const sessionName = sessionData.session_name || "Default Session";
                    
                    if (sessionData.notifications) {
                        Object.keys(sessionData.notifications).forEach(notificationId => {
                            if (!this.deletedNotifications.has(notificationId)) {
                                const notification = sessionData.notifications[notificationId];
                                this.notificationMap.set(notificationId, {
                                    id: notificationId,
                                    title: `${notification.reason} at ${sessionName}`,
                                    date: notification.date,
                                    time: notification.time,
                                    type: this.getNotificationType(notification.reason)
                                });
                            }
                        });
                    }
                }
            }
            
            this.displayNotifications();
        } catch (error) {
            console.error("Error fetching notifications:", error);
            this.showEmptyState("Error loading notifications");
        }
    }

    // Determine notification type to display appropriate icon
    getNotificationType(reason) {
        const reasonLower = reason.toLowerCase();
        if (reasonLower.includes("sound")) return "sound";
        if (reasonLower.includes("motion") || reasonLower.includes("person") || reasonLower.includes("detected")) return "motion";
        if (reasonLower.includes("log") || reasonLower.includes("sign")) return "login";
        if (reasonLower.includes("password")) return "password";
        return "default";
    }

    // Display notifications in the UI
    displayNotifications() {
        this.showLoadingState(false);
        this.container.innerHTML = "";
        
        if (this.notificationMap.size === 0) {
            this.showEmptyState();
            return;
        }
        
        // DEDUPLICATE NOTIFICATIONS BY CONTENT AND TIMESTAMP
        const deduplicatedNotifications = this.deduplicateNotifications(
            Array.from(this.notificationMap.values())
        );
        
        // Sort notifications by id (newest first) after deduplication
        const sortedNotifications = deduplicatedNotifications
            .sort((a, b) => b.id.localeCompare(a.id));
        
        for (const notification of sortedNotifications) {
            const notificationElement = this.createNotificationElement(notification);
            this.container.appendChild(notificationElement);
        }
        
        // Update notification badge
        this.updateNotificationBadge();
    }

    // Add this new deduplication method
    deduplicateNotifications(notifications) {
        // Group by similar content and close timestamps (within 2 minutes)
        const uniqueNotifications = [];
        const processedKeys = new Set();
        
        notifications.forEach(notification => {
            // Create a key based on detection type, time (within 2 min window), and camera if available
            let notifTime = new Date(`${notification.date} ${notification.time}`).getTime();
            let roundedTime = Math.floor(notifTime / (2 * 60 * 1000)); // Round to 2-minute window
            
            let cameraInfo = '';
            if (notification.metadata?.cameraNumber) {
                cameraInfo = `cam${notification.metadata.cameraNumber}`;
            }
            
            let detectionType = '';
            if (notification.metadata?.detectionType) {
                detectionType = notification.metadata.detectionType;
            } else if (notification.title.toLowerCase().includes('sound')) {
                detectionType = 'sound';
            } else if (notification.title.toLowerCase().includes('motion') || 
                       notification.title.toLowerCase().includes('person')) {
                detectionType = 'motion';
            }
            
            const dedupeKey = `${detectionType}_${roundedTime}_${cameraInfo}`;
            
            // If we haven't processed this notification type+time+camera combo yet
            if (!processedKeys.has(dedupeKey)) {
                processedKeys.add(dedupeKey);
                
                // Choose the most detailed notification if we have multiple versions
                const relatedNotifs = notifications.filter(n => {
                    let nTime = new Date(`${n.date} ${n.time}`).getTime();
                    let nRoundedTime = Math.floor(nTime / (2 * 60 * 1000));
                    
                    let nCameraInfo = n.metadata?.cameraNumber ? `cam${n.metadata.cameraNumber}` : '';
                    
                    let nDetectionType = '';
                    if (n.metadata?.detectionType) {
                        nDetectionType = n.metadata.detectionType;
                    } else if (n.title.toLowerCase().includes('sound')) {
                        nDetectionType = 'sound';
                    } else if (n.title.toLowerCase().includes('motion') || 
                               n.title.toLowerCase().includes('person')) {
                        nDetectionType = 'motion';
                    }
                    
                    return `${nDetectionType}_${nRoundedTime}_${nCameraInfo}` === dedupeKey;
                });
                
                // Choose the notification with the most metadata
                const bestNotification = relatedNotifs.reduce((best, current) => {
                    // Prefer notifications with metadata
                    const currentMetadataCount = current.metadata ? 
                        Object.keys(current.metadata).length : 0;
                    const bestMetadataCount = best.metadata ? 
                        Object.keys(best.metadata).length : 0;
                    
                    return currentMetadataCount > bestMetadataCount ? current : best;
                }, relatedNotifs[0]);
                
                uniqueNotifications.push(bestNotification);
            }
        });
        
        return uniqueNotifications;
    }

    // Create notification element based on type
    createNotificationElement(notification) {
        // Determine icon class and background based on type
        let iconClass = "fas fa-bell";
        let bgClass = "bg-orange-100";
        let iconColor = "text-orange-600";
        
        switch(notification.type) {
            case "sound":
                iconClass = "fas fa-volume-up";
                bgClass = "bg-red-100";
                iconColor = "text-red-600";
                break;
            case "motion":
                iconClass = "fas fa-running";
                bgClass = "bg-green-100";
                iconColor = "text-green-600";
                break;
            case "login":
                iconClass = "fas fa-sign-in-alt";
                bgClass = "bg-blue-100";
                iconColor = "text-blue-600";
                break;
            case "password":
                iconClass = "fas fa-key";
                bgClass = "bg-purple-100";
                iconColor = "text-purple-600";
                break;
        }
        
        // Extract camera and session info with improved formatting
        let detailsInfo = '';
        if (notification.metadata) {
            // Get camera details
            const cameraNumber = notification.metadata.cameraNumber || 'Unknown';
            const deviceInfo = notification.metadata.deviceInfo || 'Unknown Device';
            const userEmail = notification.metadata.userEmail || '';
            const sessionName = notification.metadata.sessionName || '';
            const detectionType = notification.metadata.detectionType || 'activity';
            
            // Create enhanced information display with session name highlight
            detailsInfo = `
                <div class="mt-3 p-3 bg-gray-50 rounded-md border-l-4 border-orange-400">
                    <div class="mb-2">
                        <span class="font-semibold text-orange-700">Session:</span> 
                        <span class="bg-orange-50 px-2 py-0.5 rounded text-orange-800">${sessionName}</span>
                    </div>
                    <p class="text-xs text-gray-600">
                        <span class="font-medium">Camera:</span> ${cameraNumber} 
                        <span class="bg-blue-50 px-1 py-0.5 rounded text-blue-700 text-xs ml-1">${deviceInfo}</span>
                    </p>
                    ${userEmail ? `<p class="text-xs text-gray-600 mt-1"><span class="font-medium">User:</span> ${userEmail}</p>` : ''}
                    <p class="text-xs text-gray-600 mt-1">
                        <span class="font-medium">Type:</span> 
                        <span class="px-1.5 py-0.5 bg-${detectionType === 'sound' ? 'red' : 'green'}-100 text-${detectionType === 'sound' ? 'red' : 'green'}-700 rounded-full">
                            ${detectionType.charAt(0).toUpperCase() + detectionType.slice(1)}
                        </span>
                    </p>
                </div>
            `;
        }
        
        // Create notification card
        const notifDiv = document.createElement('div');
        notifDiv.className = "bg-amber-50 rounded-lg p-4 hover:shadow-md transition duration-300";
        notifDiv.innerHTML = `
            <div class="flex justify-between items-start">
                <div class="flex items-start space-x-3">
                    <div class="${bgClass} rounded-full p-3">
                        <i class="${iconClass} ${iconColor}"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">${notification.title}</h3>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Date:</span> ${notification.date}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Time:</span> ${notification.time}
                        </p>
                        ${detailsInfo}
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="#" class="text-gray-500 hover:text-orange-500 p-1" title="View Details">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-red-500 p-1 delete-notification" title="Delete" data-id="${notification.id}">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        `;
        
        // Add event listener to the delete button
        const deleteBtn = notifDiv.querySelector('.delete-notification');
        deleteBtn.addEventListener('click', (e) => {
            e.preventDefault();
            this.deleteNotification(notification.id);
        });
        
        return notifDiv;
    }

    // Delete a specific notification
    deleteNotification(notificationId) {
        // Add to deleted notifications list in local storage
        this.deletedNotifications.add(notificationId);
        localStorage.setItem(
            PREFS_NAME, 
            JSON.stringify({
                [DELETED_NOTIFICATIONS_KEY]: Array.from(this.deletedNotifications)
            })
        );
        
        // Remove from our map
        this.notificationMap.delete(notificationId);
        
        // Refresh UI
        this.displayNotifications();

        // Update the notification badge system
        document.dispatchEvent(new CustomEvent('notification-deleted', { 
            detail: { notificationId } 
        }));
    }

    // Clear all notifications
    clearAllNotifications() {
        if (this.notificationMap.size === 0) return;
        
        if (confirm("Are you sure you want to clear all notifications?")) {
            // Add all current notification IDs to deleted list
            this.notificationMap.forEach((notification, id) => {
                this.deletedNotifications.add(id);
            });
            
            // Save to local storage
            localStorage.setItem(
                PREFS_NAME, 
                JSON.stringify({
                    [DELETED_NOTIFICATIONS_KEY]: Array.from(this.deletedNotifications)
                })
            );
            
            // Clear current notifications map
            this.notificationMap.clear();
            
            // Refresh UI
            this.displayNotifications();

            // Update the notification badge system
            document.dispatchEvent(new CustomEvent('notifications-cleared'));
        }
    }

    // Get deleted notifications from local storage
    getDeletedNotificationsFromStorage() {
        const storedData = localStorage.getItem(PREFS_NAME);
        if (storedData) {
            try {
                const parsed = JSON.parse(storedData);
                if (parsed && parsed[DELETED_NOTIFICATIONS_KEY]) {
                    return new Set(parsed[DELETED_NOTIFICATIONS_KEY]);
                }
            } catch (e) {
                console.error("Error parsing stored notifications data:", e);
            }
        }
        return new Set();
    }

    // New method to set up real-time listeners
    setupRealTimeListeners() {
        if (!this.currentUser || !this.currentUser.email) {
            return;
        }

        // Remove any existing listeners
        this.removeRealTimeListeners();
        
        const formattedEmail = this.currentUser.email.replace(/\./g, '_');
        
        // Listen for universal notifications
        const universalRef = ref(database, `users/${formattedEmail}/universal_notifications`);
        
        onValue(universalRef, (snapshot) => {
            this.handleUniversalNotifications(snapshot);
            this.displayNotifications();
        });
        
        this.realTimeListeners.push({ ref: universalRef, event: 'value' });
        
        // Listen for session-specific notifications
        for (const sessionKey of this.sessionKeys) {
            const sessionNotifRef = ref(database, `users/${formattedEmail}/sessions/${sessionKey}/notifications`);
            
            // Initialize sessionNames object if it doesn't exist
            this.sessionNames = this.sessionNames || {};
            
            // First get session name with Promise before setting up notification listener
            const sessionNameRef = ref(database, `users/${formattedEmail}/sessions/${sessionKey}/session_name`);
            get(sessionNameRef).then((snapshot) => {
                this.sessionNames[sessionKey] = snapshot.exists() ? snapshot.val() : "Default Session";
                
                // Only set up notification listener after getting the name
                onValue(sessionNotifRef, (snapshot) => {
                    this.handleSessionNotifications(sessionKey, snapshot);
                    this.displayNotifications();
                });
                
                this.realTimeListeners.push({ ref: sessionNotifRef, event: 'value' });
            });
        }
        
        // Initial load
        this.showLoadingState(false);
    }

    // Handle universal notifications data
    handleUniversalNotifications(snapshot) {
        if (!snapshot.exists()) return;
        
        const universalData = snapshot.val();
        Object.keys(universalData).forEach(notificationId => {
            if (!this.deletedNotifications.has(notificationId)) {
                const notification = universalData[notificationId];
                const notificationType = this.getNotificationType(notification.reason);
                
                // Skip if notifications of this type are disabled
                if (!this.checkNotificationSettings(notificationType)) return;
                
                // Include session name in title if available in metadata
                let title = notification.reason;
                if (notification.metadata && notification.metadata.sessionName) {
                    title += ` at ${notification.metadata.sessionName}`;
                }
                
                this.notificationMap.set(notificationId, {
                    id: notificationId,
                    title: title,
                    date: notification.date,
                    time: notification.time,
                    type: notificationType,
                    metadata: notification.metadata || null
                });
            }
        });
    }

    // Handle session notifications data
    handleSessionNotifications(sessionKey, snapshot) {
        if (!snapshot.exists()) return;
        
        const sessionName = this.sessionNames?.[sessionKey] || "Default Session";
        const notificationsData = snapshot.val();
        
        Object.keys(notificationsData).forEach(notificationId => {
            if (!this.deletedNotifications.has(notificationId)) {
                const notification = notificationsData[notificationId];
                const notificationType = this.getNotificationType(notification.reason);
                
                // Skip if notifications of this type are disabled
                if (!this.checkNotificationSettings(notificationType)) return;
                
                this.notificationMap.set(notificationId, {
                    id: notificationId,
                    title: `${notification.reason} at ${sessionName}`,
                    date: notification.date,
                    time: notification.time,
                    type: notificationType,
                    metadata: notification.metadata || null
                });
            }
        });
    }

    // Remove all real-time listeners when needed
    removeRealTimeListeners() {
        this.realTimeListeners.forEach(listener => {
            off(listener.ref, listener.event);
        });
        this.realTimeListeners = [];
    }
    
    // Clean up when leaving the page
    cleanup() {
        this.removeRealTimeListeners();
    }
    
    // Method to create a notification badge on the bell icon
    updateNotificationBadge() {
        const count = this.notificationMap.size;
        
        // Find notification icon in navbar
        const navBellIcon = document.querySelector('a[href="/notification"] i.fa-bell');
        if (!navBellIcon) return;
        
        // Find existing badge or create a new one
        let badge = navBellIcon.parentElement.querySelector('.notification-badge');
        
        if (count > 0) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center';
                navBellIcon.parentElement.style.position = 'relative';
                navBellIcon.parentElement.appendChild(badge);
            }
            badge.textContent = count > 9 ? '9+' : count;
        } else if (badge) {
            badge.remove();
        }
    }

    // Check if notifications are enabled based on user preferences
    checkNotificationSettings(notificationType) {
        try {
            const storedData = localStorage.getItem(PREFS_NAME);
            if (storedData) {
                const prefs = JSON.parse(storedData);
                if (prefs && prefs["notification_settings"]) {
                    const settings = prefs["notification_settings"];
                    
                    // If all notifications are turned off, don't show any
                    if (!settings.allNotifications) return false;
                    
                    // Check specific notification types
                    if (notificationType === "sound" && !settings.soundDetection) return false;
                    if ((notificationType === "motion" || notificationType === "person") && 
                        !settings.personDetection) return false;
                }
            }
            return true; // Default to showing if settings aren't found
        } catch (e) {
            console.error("Error checking notification settings:", e);
            return true; // Default to showing notifications if there's an error
        }
    }
}