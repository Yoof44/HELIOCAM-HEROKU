/**
 * Notification Settings Manager
 * Handles saving and loading notification preferences for HelioCam
 */

document.addEventListener('DOMContentLoaded', () => {
    // Constants
    const PREFS_NAME = "NotificationPrefs";
    const NOTIFICATION_SETTINGS_KEY = "notification_settings";
    
    // Get toggle elements
    const allNotificationsToggle = document.querySelector('#all-notifications-toggle');
    const soundDetectionToggle = document.querySelector('#sound-detection-toggle');
    const personDetectionToggle = document.querySelector('#person-detection-toggle');
    
    // If we're not on the settings page, don't continue
    if (!allNotificationsToggle) return;
    
    // Set initial state from localStorage
    loadNotificationPreferences();
    
    // Event listener for all notifications toggle
    allNotificationsToggle.addEventListener('change', () => {
        const isEnabled = allNotificationsToggle.checked;
        
        // Update other toggles based on main toggle
        soundDetectionToggle.checked = isEnabled;
        personDetectionToggle.checked = isEnabled;
        
        // If main toggle is off, disable individual toggles
        if (!isEnabled) {
            soundDetectionToggle.disabled = true;
            personDetectionToggle.disabled = true;
        } else {
            soundDetectionToggle.disabled = false;
            personDetectionToggle.disabled = false;
        }
        
        // Save preferences
        saveNotificationPreferences();
    });
    
    // Event listeners for individual toggles
    soundDetectionToggle.addEventListener('change', () => {
        updateMainToggleState();
        saveNotificationPreferences();
    });
    
    personDetectionToggle.addEventListener('change', () => {
        updateMainToggleState();
        saveNotificationPreferences();
    });
    
    // Update the main toggle state based on individual toggles
    function updateMainToggleState() {
        allNotificationsToggle.checked = soundDetectionToggle.checked || personDetectionToggle.checked;
    }
    
    // Save current notification preferences to localStorage
    function saveNotificationPreferences() {
        const preferences = {
            allNotifications: allNotificationsToggle.checked,
            soundDetection: soundDetectionToggle.checked,
            personDetection: personDetectionToggle.checked
        };
        
        try {
            // Get existing preferences to avoid overwriting deleted notifications
            const existingData = localStorage.getItem(PREFS_NAME);
            const existingPrefs = existingData ? JSON.parse(existingData) : {};
            
            localStorage.setItem(
                PREFS_NAME, 
                JSON.stringify({
                    ...existingPrefs,
                    [NOTIFICATION_SETTINGS_KEY]: preferences
                })
            );
            
            // Show save indicator
            showSaveIndicator();
        } catch (e) {
            console.error("Error saving notification preferences:", e);
        }
    }
    
    // Load notification preferences from localStorage
    function loadNotificationPreferences() {
        try {
            const storedData = localStorage.getItem(PREFS_NAME);
            if (storedData) {
                const prefs = JSON.parse(storedData);
                if (prefs && prefs[NOTIFICATION_SETTINGS_KEY]) {
                    const settings = prefs[NOTIFICATION_SETTINGS_KEY];
                    
                    // Apply settings to toggles
                    allNotificationsToggle.checked = settings.allNotifications;
                    soundDetectionToggle.checked = settings.soundDetection;
                    personDetectionToggle.checked = settings.personDetection;
                    
                    // If main toggle is off, disable individual toggles
                    if (!settings.allNotifications) {
                        soundDetectionToggle.disabled = true;
                        personDetectionToggle.disabled = true;
                    }
                }
            }
        } catch (e) {
            console.error("Error loading notification preferences:", e);
        }
    }
    
    // Show a temporary save indicator
    function showSaveIndicator() {
        // Create or get the save indicator
        let saveIndicator = document.getElementById('save-indicator');
        if (!saveIndicator) {
            saveIndicator = document.createElement('div');
            saveIndicator.id = 'save-indicator';
            saveIndicator.className = 'fixed bottom-4 right-4 bg-green-100 text-green-800 px-4 py-2 rounded shadow-md transition-opacity duration-300';
            document.body.appendChild(saveIndicator);
        }
        
        // Show the indicator with message
        saveIndicator.textContent = 'Notification settings saved!';
        saveIndicator.style.opacity = '1';
        
        // Hide after 2 seconds
        setTimeout(() => {
            saveIndicator.style.opacity = '0';
        }, 2000);
    }
});