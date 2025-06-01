import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
import { getDatabase, ref, onValue, get, set, push, serverTimestamp, update } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";

// Firebase configuration - matches your existing config
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
const db = getDatabase(app);

// Device login manager
class DeviceLoginManager {
    constructor() {
        this.currentDeviceContainer = document.getElementById("currentDeviceContainer");
        this.otherDevicesContainer = document.getElementById("otherDevicesContainer");
        this.currentUser = null;
        this.currentDeviceId = this.generateDeviceId();
        this.deviceInfo = this.getCurrentDeviceInfo();
    }

    // Generate a unique device ID for the current browser
    generateDeviceId() {
        let deviceId = localStorage.getItem('heliocam_device_id');
        if (!deviceId) {
            deviceId = 'web_' + Math.random().toString(36).substring(2, 15);
            localStorage.setItem('heliocam_device_id', deviceId);
        }
        return deviceId;
    }

    // Get current device information
    getCurrentDeviceInfo() {
        const userAgent = navigator.userAgent;
        let deviceName = "Web Browser";
        
        // Try to extract browser name and OS
        if (userAgent.includes("Chrome")) deviceName = "Chrome Browser";
        else if (userAgent.includes("Firefox")) deviceName = "Firefox Browser";
        else if (userAgent.includes("Safari")) deviceName = "Safari Browser";
        else if (userAgent.includes("Edge")) deviceName = "Edge Browser";
        
        // Add OS info if available
        if (userAgent.includes("Windows")) deviceName += " (Windows)";
        else if (userAgent.includes("Mac")) deviceName += " (Mac)";
        else if (userAgent.includes("Linux")) deviceName += " (Linux)";
        else if (userAgent.includes("Android")) deviceName += " (Android)";
        else if (userAgent.includes("iPhone") || userAgent.includes("iPad")) deviceName += " (iOS)";
        
        return {
            deviceName: deviceName,
            deviceId: this.currentDeviceId
        };
    }
    
    // Initialize the device login manager
    init() {
        onAuthStateChanged(auth, (user) => {
            if (user) {
                this.currentUser = user;
                this.registerCurrentDevice(); // Add this line
                this.fetchDevices();
            } else {
                console.log("User not logged in");
            }
        });
    }
    
    // Fetch devices from Firebase
    fetchDevices() {
        if (!this.currentUser || !this.currentUser.email) return;
        
        const sanitizedEmail = this.currentUser.email.replace(/\./g, "_");
        const userRef = ref(db, `users/${sanitizedEmail}`);
        
        onValue(userRef, (snapshot) => {
            if (snapshot.exists()) {
                // Clear containers
                this.clearContainers();
                
                // Process devices
                const devices = [];
                const data = snapshot.val();
                
                for (const key in data) {
                    if (key.startsWith("logininfo_")) {
                        const device = data[key];
                        
                        // Ensure we have the required data
                        if (device) {
                            // Handle different data formats (similar to Android app)
                            let deviceName = "Unknown Device";
                            let location = "Unknown Location";
                            let lastActive = Date.now();
                            
                            // Extract device name
                            if (typeof device.deviceName === "string") {
                                deviceName = device.deviceName;
                            } else if (typeof device.deviceName === "object" && device.deviceName) {
                                if (device.deviceName.model) {
                                    deviceName = device.deviceName.model;
                                } else if (device.deviceName.name) {
                                    deviceName = device.deviceName.name;
                                }
                            }
                            
                            // Extract location
                            if (typeof device.location === "string") {
                                location = device.location;
                            } else if (typeof device.location === "object" && device.location) {
                                if (device.location.latitude && device.location.longitude) {
                                    location = `${device.location.latitude}, ${device.location.longitude}`;
                                    // For web, we'll display raw coordinates instead of geocoding
                                }
                            }
                            
                            // Extract timestamp
                            if (device.lastActive) {
                                if (typeof device.lastActive === "number") {
                                    lastActive = device.lastActive;
                                } else if (typeof device.lastActive === "object") {
                                    // Sometimes Firebase timestamps are objects
                                    lastActive = Date.now(); // Fallback
                                }
                            }
                            
                            // Add to devices array
                            devices.push({
                                deviceName: deviceName,
                                location: location,
                                lastActive: lastActive,
                                deviceKey: key,
                                // Check if this is the current device
                                isCurrentDevice: this.isCurrentDevice(device)
                            });
                        }
                    }
                }
                
                // Sort by last active time (newest first)
                devices.sort((a, b) => b.lastActive - a.lastActive);
                
                // Process devices
                this.renderDevices(devices);
            }
        });
    }
    
    // Check if a device is the current device
    isCurrentDevice(device) {
        // If device has deviceId field and it matches our current device ID
        if (device.deviceId && device.deviceId === this.currentDeviceId) {
            return true;
        }
        return false;
    }
    
    // Clear the device containers
    clearContainers() {
        if (this.currentDeviceContainer) this.currentDeviceContainer.innerHTML = '';
        if (this.otherDevicesContainer) this.otherDevicesContainer.innerHTML = '';
    }
    
    // Render devices to the UI
    renderDevices(devices) {
        let currentDeviceFound = false;
        
        devices.forEach((device, index) => {
            const isLastDevice = index === devices.length - 1;
            
            if (device.isCurrentDevice) {
                currentDeviceFound = true;
                this.addDeviceCard(device, this.currentDeviceContainer, true, isLastDevice);
            } else {
                this.addDeviceCard(device, this.otherDevicesContainer, false, isLastDevice);
            }
        });
        
        // If current device not found in the list
        if (!currentDeviceFound && this.currentDeviceContainer) {
            this.showEmptyState(this.currentDeviceContainer, "This device is not logged in");
        }
        
        // If no other devices
        if (devices.filter(d => !d.isCurrentDevice).length === 0 && this.otherDevicesContainer) {
            this.showEmptyState(this.otherDevicesContainer, "No other devices found");
        }
    }
    
    // Add a device card to a container
    addDeviceCard(device, container, isCurrentDevice, isLastDevice) {
        if (!container) return;
        
        // Create device card
        const card = document.createElement('div');
        card.className = 'bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition';
        
        // Format the last active time
        const lastActiveFormatted = this.formatTimestamp(device.lastActive);
        
        // Format location
        let locationText = device.location;
        if (locationText.includes(',')) {
            // If it's coordinates, just show "Location data available"
            locationText = "Location data available";
        }
        
        card.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="bg-orange-100 rounded-full p-2 mr-3">
                        <i class="fas ${isCurrentDevice ? 'fa-laptop' : 'fa-mobile-alt'} text-primary-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 ${isCurrentDevice ? 'text-green-600' : ''}">
                            ${isCurrentDevice ? 'This Device' : device.deviceName}
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">
                            <i class="fas fa-map-marker-alt mr-1"></i> ${locationText}
                        </p>
                        <p class="text-gray-500 text-sm">
                            <i class="fas fa-clock mr-1"></i> ${lastActiveFormatted}
                        </p>
                    </div>
                </div>
                
                <button class="text-red-500 hover:text-red-700 logout-device" data-device="${device.deviceKey}" 
                    ${isCurrentDevice ? 'disabled' : ''}>
                    <i class="fas fa-sign-out-alt text-xl"></i>
                </button>
            </div>
            ${!isLastDevice ? '<hr class="my-3 border-gray-200">' : ''}
        `;
        
        // Add to container
        container.appendChild(card);
        
        // Add event listener for logout button
        const logoutBtn = card.querySelector('.logout-device');
        if (logoutBtn && !isCurrentDevice) {
            logoutBtn.addEventListener('click', () => {
                this.confirmLogoutDevice(device);
            });
        }
    }
    
    // Show empty state in a container
    showEmptyState(container, message) {
        const emptyState = document.createElement('div');
        emptyState.className = 'text-center py-8 text-gray-500';
        emptyState.innerHTML = `
            <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
            <p>${message}</p>
        `;
        container.appendChild(emptyState);
    }
    
    // Format timestamp to human-readable format (similar to Android implementation)
    formatTimestamp(timestamp) {
        if (!timestamp) return "Unknown";
        
        const now = Date.now();
        const diff = now - timestamp;
        
        // If less than a minute ago
        if (diff < 60 * 1000) {
            return "Just now";
        }
        // If less than an hour ago
        else if (diff < 60 * 60 * 1000) {
            const minutes = Math.floor(diff / (60 * 1000));
            return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
        }
        // If less than a day ago
        else if (diff < 24 * 60 * 60 * 1000) {
            const hours = Math.floor(diff / (60 * 60 * 1000));
            return `${hours} hour${hours > 1 ? 's' : ''} ago`;
        }
        // Otherwise show the date
        else {
            const date = new Date(timestamp);
            return `${date.toLocaleDateString()} • ${date.toLocaleTimeString()}`;
        }
    }
    
    // Confirm and log out a device
    confirmLogoutDevice(device) {
        if (confirm(`Are you sure you want to log out this device?\n\n${device.deviceName}`)) {
            const sanitizedEmail = this.currentUser.email.replace(/\./g, "_");
            
            // Remove the device login info
            remove(ref(db, `users/${sanitizedEmail}/${device.deviceKey}`))
                .then(() => {
                    this.showToast("Device logged out successfully", "success");
                })
                .catch(error => {
                    console.error("Error logging out device:", error);
                    this.showToast("Failed to log out device", "error");
                });
        }
    }
    
    // Show toast notification
    showToast(message, type = 'info') {
        // Remove any existing toasts
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Create new toast
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        
        // Set icon and color based on type
        let icon;
        switch (type) {
            case 'success':
                icon = 'fa-check-circle';
                toast.style.borderLeft = '4px solid #10b981';
                break;
            case 'error':
                icon = 'fa-times-circle';
                toast.style.borderLeft = '4px solid #ef4444';
                break;
            case 'warning':
                icon = 'fa-exclamation-circle';
                toast.style.borderLeft = '4px solid #f59e0b';
                break;
            default:
                icon = 'fa-info-circle';
                toast.style.borderLeft = '4px solid #3b82f6';
        }
        
        toast.innerHTML = `<i class="fas ${icon}"></i> <span class="ml-2">${message}</span>`;
        document.body.appendChild(toast);
        
        // Show the toast
        setTimeout(() => {
            toast.classList.add('show');
            
            // Hide after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }, 10);
    }
    
    // Add this function to register the current device
    registerCurrentDevice() {
        if (!this.currentUser || !this.currentUser.email) return;
        
        const sanitizedEmail = this.currentUser.email.replace(/\./g, "_");
        const deviceId = this.currentDeviceId;
        const devicePath = `users/${sanitizedEmail}/logininfo_${deviceId}`;
        
        // Get current location (coordinates only)
        let locationString = "Unknown Location";
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    locationString = `latitude: ${position.coords.latitude}, longitude: ${position.coords.longitude}`;
                    this.saveDeviceInfo(sanitizedEmail, deviceId, locationString);
                },
                error => {
                    console.log("Location error or denied:", error);
                    this.saveDeviceInfo(sanitizedEmail, deviceId, locationString);
                }
            );
        } else {
            this.saveDeviceInfo(sanitizedEmail, deviceId, locationString);
        }
    }

    saveDeviceInfo(sanitizedEmail, deviceId, locationString) {
        const devicePath = `users/${sanitizedEmail}/logininfo_${deviceId}`;
        const deviceData = {
            deviceName: this.deviceInfo.deviceName,
            deviceId: deviceId,
            location: locationString,
            lastActive: Date.now()
        };
        
        // Save to Firebase
        set(ref(db, devicePath), deviceData)
            .then(() => {
                console.log("Device registered successfully!");
                this.fetchDevices(); // Refresh the device list
            })
            .catch(error => {
                console.error("Error registering device:", error);
            });
    }
}

// Initialize the device login manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const deviceManager = new DeviceLoginManager();
    deviceManager.init();
    
    // Expose to window for debugging
    window.deviceManager = deviceManager;
});