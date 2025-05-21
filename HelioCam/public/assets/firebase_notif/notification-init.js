import NotificationManager from './notification-manager.js';

let notificationManager = null;

document.addEventListener('DOMContentLoaded', () => {
    // Find the notification container
    const notificationContainer = document.querySelector('.space-y-4');
    
    if (notificationContainer) {
        // Initialize the notification manager with real-time updates
        notificationManager = new NotificationManager();
        notificationManager.init(notificationContainer, true); // Enable real-time updates
        
        // Make it globally accessible for debugging if needed
        window.notificationManager = notificationManager;
    } else {
        console.error('Notification container not found');
    }
});

// Clean up when leaving the page
window.addEventListener('beforeunload', () => {
    if (notificationManager) {
        notificationManager.cleanup();
    }
});