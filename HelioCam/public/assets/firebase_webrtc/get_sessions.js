import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";
import { getDatabase, ref, get, remove, update, onValue } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

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

function getCookie(name) {
    let match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
    return match ? match[2] : null;
}

// Format date function
function formatDate(timestamp) {
    if (!timestamp) return 'Unknown date';
    
    const date = new Date(timestamp);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

async function fetchSessions(user, filters = {}) {
    if (!user || !user.email) {
        console.log("No authenticated user found.");
        return;
    }

    // Check if sessions-holder exists in DOM before proceeding
    const sessionsHolder = document.querySelector(".sessions-holder");
    if (!sessionsHolder) {
        console.error("Sessions holder element (.sessions-holder) not found in DOM");
        // Create a temporary notification instead of trying to modify non-existent elements
        showNotification("Page layout error: Session container not found", "error");
        return;
    }

    // Add filter and delete all UI if not already present
    addFilterAndDeleteUI();

    const formattedEmail = user.email.replace(/\./g, "_");
    const cookieName = `logininfo_${formattedEmail}`;
    const loginInfoN = getCookie(cookieName);

    if (!loginInfoN) {
        console.error("No logininfo_n cookie found for user:", formattedEmail);
        showNotification("Session data error: Missing authentication information", "error");
        return;
    }

    // Show loading state
    sessionsHolder.innerHTML = "<div class='text-center py-6'><i class='fas fa-spinner fa-spin text-orange-500 text-2xl'></i><p class='mt-2 text-gray-600'>Loading sessions...</p></div>";

    try {
        console.log(`Fetching sessions for user: ${formattedEmail}, login info: ${loginInfoN}`);
        
        // First fetch sessions from sessions_added
        const sessionsAddedRef = ref(db, `users/${formattedEmail}/${loginInfoN}/sessions_added`);
        console.log("Fetching from path:", `users/${formattedEmail}/${loginInfoN}/sessions_added`);
        const sessionsAddedSnap = await get(sessionsAddedRef);
        
        // Then fetch sessions from the user's main sessions path
        const userSessionsRef = ref(db, `users/${formattedEmail}/sessions`);
        console.log("Fetching from path:", `users/${formattedEmail}/sessions`);
        const userSessionsSnap = await get(userSessionsRef);
        
        const sessions = new Map();
        
        // Process sessions from sessions_added
        if (sessionsAddedSnap.exists()) {
            sessionsAddedSnap.forEach(sessionSnap => {
                const sessionKey = sessionSnap.key;
                const sessionData = sessionSnap.val();
                sessions.set(sessionKey, {
                    ...sessionData,
                    sessionKey: sessionKey,
                    source: 'sessions_added'
                });
            });
        }
        
        // Process sessions from user's sessions collection, merging with sessions_added if needed
        if (userSessionsSnap.exists()) {
            userSessionsSnap.forEach(sessionSnap => {
                const sessionKey = sessionSnap.key;
                const sessionData = sessionSnap.val();
                
                if (sessions.has(sessionKey)) {
                    // If session exists in both places, merge, prioritizing user's sessions data
                    const existingData = sessions.get(sessionKey);
                    sessions.set(sessionKey, { 
                        ...existingData, 
                        ...sessionData,
                        sessionKey: sessionKey
                    });
                } else {
                    // Add if it's not in sessions_added
                    sessions.set(sessionKey, { 
                        ...sessionData, 
                        sessionKey: sessionKey,
                        source: 'user_sessions'
                    });
                }
            });
        }
        
        const noSessionMessage = document.querySelector(".no-session");
        
        if (!sessionsHolder) {
            console.log("Sessions holder element not found in DOM");
            return;
        }
        
        sessionsHolder.innerHTML = ""; 
        
        // Apply filters if they exist
        let filteredSessions = Array.from(sessions.entries());
        
        // Filter by name if search term is provided
        if (filters.searchTerm) {
            const searchTermLower = filters.searchTerm.toLowerCase();
            filteredSessions = filteredSessions.filter(([_, sessionData]) => {
                const sessionName = (sessionData.session_name || "").toLowerCase();
                const location = (sessionData.location || "").toLowerCase();
                const description = (sessionData.description || "").toLowerCase();
                return sessionName.includes(searchTermLower) || 
                       location.includes(searchTermLower) || 
                       description.includes(searchTermLower);
            });
        }
        
        // Filter by date range if provided
        if (filters.startDate) {
            const startDate = new Date(filters.startDate).getTime();
            filteredSessions = filteredSessions.filter(([_, sessionData]) => {
                const createdAt = sessionData.created_at || 0;
                return createdAt >= startDate;
            });
        }
        
        if (filters.endDate) {
            const endDate = new Date(filters.endDate).setHours(23, 59, 59, 999); // End of the selected day
            filteredSessions = filteredSessions.filter(([_, sessionData]) => {
                const createdAt = sessionData.created_at || 0;
                return createdAt <= endDate;
            });
        }
        
        // Apply sorting
        if (filters.sortBy === 'name') {
            // Sort alphabetically by name
            filteredSessions.sort((a, b) => {
                const nameA = (a[1].session_name || "").toLowerCase();
                const nameB = (b[1].session_name || "").toLowerCase();
                return nameA.localeCompare(nameB);
            });
        } else {
            // Sort by date (default)
            filteredSessions.sort((a, b) => {
                const dateA = a[1].created_at || 0;
                const dateB = b[1].created_at || 0;
                return dateB - dateA; // Most recent first
            });
        }
        
        // Check if we have any filtered sessions
        if (filteredSessions.length === 0) {
            // Update filter stats
            updateFilterStats(filteredSessions.length, sessions.size);
            
            // Show no results message
            sessionsHolder.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-search text-gray-400 text-3xl"></i>
                    <p class="mt-3 text-gray-700">No matching sessions found</p>
                    <p class="text-sm text-gray-500 mt-1">Try adjusting your filters</p>
                    <button id="clear-filters" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        <i class="fas fa-times mr-2"></i>Clear Filters
                    </button>
                </div>
            `;
            
            // Add clear filters functionality
            const clearFiltersBtn = document.getElementById("clear-filters");
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener("click", () => {
                    resetFilters();
                    fetchSessions(user);
                });
            }

            if (sessions.size === 0 && noSessionMessage) {
                noSessionMessage.style.display = "block";
            }
            return;
        }
        
        // Update filter stats
        updateFilterStats(filteredSessions.length, sessions.size, filters.sortBy);
        
        // Hide the "No sessions" message when we have sessions
        if (noSessionMessage) {
            noSessionMessage.style.display = "none";
        }

        // Display all filtered sessions
        filteredSessions.forEach(([sessionKey, sessionData]) => {
            const passkey = sessionData.passkey || ""; 
            const createdAt = sessionData.created_at || Date.now();
            const location = sessionData.location || "No location";
            const description = sessionData.description || "No description";
            const sessionName = sessionData.session_name || "Unnamed Session";
            // Keep tracking active status internally but don't display it
            const isActive = sessionData.active === true || sessionData.status === "waiting" || sessionData.status === "active";
            
            const sessionContainer = document.createElement("div");
            sessionContainer.classList.add(
                "sessions-container", 
                "bg-gradient-to-r", 
                "from-orange-400",
                "to-amber-500",
                "rounded-xl", 
                "p-4", 
                "shadow-md", 
                "hover:shadow-lg", 
                "transition-all", 
                "duration-200",
                "cursor-pointer"
            );
            
            sessionContainer.dataset.passkey = passkey;
            sessionContainer.dataset.sessionKey = sessionKey;
            sessionContainer.dataset.active = isActive;

            sessionContainer.innerHTML = `
                <div class="flex flex-col space-y-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 rounded-full p-2">
                                <i class="fas fa-video text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl text-white font-semibold">${sessionName}</h3>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <!-- Only keep delete button -->
                            <button class="delete-btn p-2 bg-white bg-opacity-20 rounded-full hover:bg-opacity-30 transition" title="Delete Session">
                                <i class="fas fa-trash text-white"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="pt-2 border-t border-white border-opacity-20">
                        <div class="text-white text-opacity-90 text-sm">
                            <p><i class="fas fa-map-marker-alt mr-2"></i>${location}</p>
                            <p class="mt-1"><i class="fas fa-calendar-alt mr-2"></i>Created: ${formatDate(createdAt)}</p>
                            <p class="mt-1 opacity-80">${description}</p>
                            <p class="mt-1"><i class="fas fa-key mr-2"></i>Access Key: <span class="font-mono bg-white bg-opacity-20 px-2 py-0.5 rounded text-white">${passkey}</span></p>
                        </div>
                    </div>
                </div>
            `;

            // Modify delete button behavior
            const deleteBtn = sessionContainer.querySelector('.delete-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    
                    // First prompt about deletion
                    if (confirm('Are you sure you want to delete this session? This action cannot be undone.')) {
                        // After confirmed deletion, prompt about recreation
                        deleteSession(user, formattedEmail, loginInfoN, sessionKey, passkey).then(() => {
                            if (confirm('Would you like to create your session again?')) {
                                // Redirect to hostsession page with pre-filled information
                                window.location.href = `/hostsession?recreate=true&session_name=${encodeURIComponent(sessionName)}&passkey=${encodeURIComponent(passkey)}&location=${encodeURIComponent(location)}`;
                            }
                        });
                    }
                });
            }
            
            // Add click handler for the whole card to open recreation page
            sessionContainer.addEventListener("click", (e) => {
                if (!e.target.closest('button')) {
                    window.location.href = `/hostsession?recreate=true&session_name=${encodeURIComponent(sessionName)}&passkey=${encodeURIComponent(passkey)}&location=${encodeURIComponent(location)}`;
                }
            });

            sessionsHolder.appendChild(sessionContainer);
        });

    } catch (error) {
        console.error("Error fetching sessions:", error);
        
        // More detailed error message
        let errorMessage = "Error loading sessions";
        
        if (error.code) {
            // If Firebase error code exists
            switch(error.code) {
                case 'permission-denied':
                    errorMessage += ": Access denied";
                    break;
                case 'unavailable':
                    errorMessage += ": Database unavailable";
                    break;
                default:
                    errorMessage += `: ${error.message || "Unknown error"}`;
            }
        }
        
        showNotification(errorMessage, "error");
        
        // Reset sessions holder to empty state with error message
        sessionsHolder.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-exclamation-circle text-red-500 text-3xl"></i>
                <p class="mt-3 text-gray-700">Unable to load sessions</p>
                <p class="text-sm text-gray-500 mt-1">${error.message || "Unknown error"}</p>
                <button id="retry-sessions" class="mt-4 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                    <i class="fas fa-sync-alt mr-2"></i> Retry
                </button>
            </div>
        `;
        
        // Add retry functionality
        const retryBtn = document.getElementById("retry-sessions");
        if (retryBtn) {
            retryBtn.addEventListener("click", () => {
                fetchSessions(user);
            });
        }
    }
}

// Function to restart or host an existing session
async function restartSession(user, sessionKey, sessionData) {
    if (!user || !user.email) return;
    
    const sessionName = sessionData.session_name || "Unnamed Session";
    const passkey = sessionData.passkey;
    
    if (!sessionKey || !passkey) {
        showNotification("Could not restart session: missing data", "error");
        return;
    }
    
    try {
        // Redirect to the streaming page with the session info
        window.location.href = `/streaming?session_n=${sessionKey}&session_name=${encodeURIComponent(sessionName)}&passkey=${passkey}&restart=true`;
    } catch (error) {
        console.error("Error restarting session:", error);
        showNotification("Error restarting session", "error");
    }
}

// Function to delete a session
async function deleteSession(user, formattedEmail, loginInfoN, sessionKey, passkey) {
    try {
        // Remove from all possible locations to ensure complete removal
        
        // 1. Remove from sessions_added
        const sessionAddedRef = ref(db, `users/${formattedEmail}/${loginInfoN}/sessions_added/${sessionKey}`);
        await remove(sessionAddedRef);
        
        // 2. Remove from user's sessions
        const userSessionRef = ref(db, `users/${formattedEmail}/sessions/${sessionKey}`);
        await remove(userSessionRef);
        
        // 3. Remove from global sessions collection
        const globalSessionRef = ref(db, `sessions/${sessionKey}`);
        await remove(globalSessionRef);
        
        // 4. Remove from session_codes if passkey exists
        if (passkey) {
            const sessionCodeRef = ref(db, `session_codes/${passkey}`);
            await remove(sessionCodeRef);
        }
        
        // Show success message
        showNotification('Session deleted successfully', 'success');
        
        // Refresh sessions list
        fetchSessions(user);
        
        return true; // Return success
        
    } catch (error) {
        console.error("Error deleting session:", error);
        showNotification('Failed to delete session: ' + error.message, 'error');
        return false; // Return failure
    }
}

// Function to show notifications
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg ${
        type === 'success' 
            ? 'bg-green-600 text-white' 
            : type === 'error' 
                ? 'bg-red-600 text-white'
                : 'bg-blue-600 text-white'
    } transition-all duration-300 transform translate-y-0 opacity-100`;
    
    // Add content
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${
                type === 'success' ? 'check-circle' : 
                type === 'error' ? 'exclamation-circle' : 
                'info-circle'
            } mr-2"></i>
            <p>${message}</p>
        </div>
    `;
    
    // Add to DOM
    document.body.appendChild(notification);
    
    // Remove after delay
    setTimeout(() => {
        notification.classList.replace('opacity-100', 'opacity-0');
        notification.classList.replace('translate-y-0', '-translate-y-4');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

async function querySessionByPasskey(user, passkey) {
    if (!user || !user.email || !passkey) {
        console.error("Invalid user or passkey.");
        return;
    }

    const formattedEmail = user.email.replace(/\./g, "_");
    const sessionsRef = ref(db, `users/${formattedEmail}/sessions`);

    try {
        const sessionsSnap = await get(sessionsRef);
        if (!sessionsSnap.exists()) {
            console.log("No sessions found.");
            showNotification("No sessions found", "error");
            return;
        }

        let session_n = null;
        sessionsSnap.forEach(sessionSnap => {
            if (sessionSnap.val().passkey === passkey) {
                session_n = sessionSnap.key;
            }
        });

        if (session_n) {
            window.location.href = `/surveillance?${session_n}`;
        } else {
            console.log("No matching session found.");
            showNotification("This session is no longer available", "error");
        }

    } catch (error) {
        console.error("Error querying session:", error);
        showNotification("Error accessing session", "error");
    }
}

// Initialize and periodically refresh sessions
let refreshInterval;
function startPeriodicRefresh() {
    if (refreshInterval) clearInterval(refreshInterval);
    const user = auth.currentUser;
    if (user) {
        fetchSessions(user);
        refreshInterval = setInterval(() => fetchSessions(user), 30000); // Refresh every 30 seconds
    }
}

// Listen for auth state changes
onAuthStateChanged(auth, (user) => {
    if (user) {
        fetchSessions(user);
        startPeriodicRefresh();
    } else {
        if (refreshInterval) clearInterval(refreshInterval);
        console.log("User not logged in.");
    }
});

// Add better initialization sequence
document.addEventListener('DOMContentLoaded', () => {
    // Check Firebase connection status
    const connectedRef = ref(db, '.info/connected');
    
    onValue(connectedRef, (snap) => {
        if (snap.val() === true) {
            console.log("Connected to Firebase");
        } else {
            console.log("Disconnected from Firebase");
        }
    });

    // Add event listener to refresh button if it exists
    const refreshBtn = document.getElementById("refresh-sessions");
    if (refreshBtn) {
        refreshBtn.addEventListener("click", () => {
            const user = auth.currentUser;
            if (user) {
                showNotification("Refreshing sessions...", "info");
                fetchSessions(user);
            } else {
                showNotification("Please login to view sessions", "error");
            }
        });
    }
});

// Function to add filter UI and Delete All button
function addFilterAndDeleteUI() {
    // Check if container already exists
    if (document.getElementById('session-filters-container')) {
        return; // Filter UI already exists
    }
    
    const sessionsContainer = document.getElementById('sessionsContainer');
    if (!sessionsContainer) return;
    
    // Create filter container
    const filterContainer = document.createElement('div');
    filterContainer.id = 'session-filters-container';
    filterContainer.className = 'mb-6 pb-6 border-b border-gray-200';
    
    filterContainer.innerHTML = `
        <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-4">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" id="session-search" placeholder="Search by name or location..." 
                           class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 bg-white">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Sort by:</label>
                <select id="sort-sessions" class="px-2 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="date">Date (Recent first)</option>
                    <option value="name">Name (A-Z)</option>
                </select>
                <button id="apply-filters" class="px-4 py-1.5 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button id="reset-filters" class="px-4 py-1.5 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                    <i class="fas fa-times mr-1"></i> Reset
                </button>
            </div>
        </div>
        <div class="flex justify-between items-center">
            <div id="filter-stats" class="text-sm text-gray-500">
                Showing all sessions
            </div>
            <button id="delete-all-sessions" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash-alt mr-1"></i> Delete All Sessions
            </button>
        </div>
    `;
    
    // Insert filter container at the top of sessions container
    sessionsContainer.insertBefore(filterContainer, sessionsContainer.firstChild);
    
    // Add event listeners for filter controls
    document.getElementById('apply-filters').addEventListener('click', applyFilters);
    document.getElementById('reset-filters').addEventListener('click', resetFilters);
    document.getElementById('delete-all-sessions').addEventListener('click', deleteAllSessions);
    
    // Add instant search functionality with debounce
    const searchInput = document.getElementById('session-search');
    let debounceTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(applyFilters, 300);
    });
}

// Function to apply filters
function applyFilters() {
    const searchTerm = document.getElementById('session-search')?.value || '';
    const sortBy = document.getElementById('sort-sessions')?.value || 'date';
    
    const filters = {
        searchTerm,
        sortBy
    };
    
    // Re-fetch sessions with filters
    const user = auth.currentUser;
    if (user) {
        fetchSessions(user, filters);
    }
}

// Function to reset filters
function resetFilters() {
    const searchInput = document.getElementById('session-search');
    const sortSelect = document.getElementById('sort-sessions');
    
    if (searchInput) searchInput.value = '';
    if (sortSelect) sortSelect.value = 'date'; // Reset to default sort
    
    // Re-fetch sessions without filters
    const user = auth.currentUser;
    if (user) {
        fetchSessions(user);
    }
}

// Function to update filter stats
function updateFilterStats(filteredCount, totalCount, sortBy = 'date') {
    const statsEl = document.getElementById('filter-stats');
    if (statsEl) {
        let message = '';
        
        if (filteredCount === totalCount) {
            message = `Showing all ${totalCount} session${totalCount !== 1 ? 's' : ''}`;
        } else {
            message = `Showing ${filteredCount} of ${totalCount} session${totalCount !== 1 ? 's' : ''}`;
        }
        
        // Add sort information
        message += ` • Sorted by ${sortBy === 'name' ? 'name (A-Z)' : 'date (recent first)'}`;
        
        statsEl.textContent = message;
    }
}

// Function to delete all sessions
async function deleteAllSessions() {
    const user = auth.currentUser;
    if (!user || !user.email) {
        showNotification("You must be logged in to delete sessions", "error");
        return;
    }
    
    // Show a serious confirmation dialog
    if (!confirm('⚠️ WARNING: You are about to delete ALL of your sessions. This action cannot be undone. Are you absolutely sure?')) {
        return;
    }
    
    // Double-check with an additional confirmation
    if (!confirm('Please confirm once more that you want to delete all your sessions permanently.')) {
        return;
    }
    
    const formattedEmail = user.email.replace(/\./g, "_");
    const cookieName = `logininfo_${formattedEmail}`;
    const loginInfoN = getCookie(cookieName);
    
    if (!loginInfoN) {
        showNotification("Authentication information missing", "error");
        return;
    }
    
    // Show loading overlay
    showLoadingOverlay("Deleting all sessions...");
    
    try {
        // 1. First get all user's sessions
        const sessionsAddedRef = ref(db, `users/${formattedEmail}/${loginInfoN}/sessions_added`);
        const userSessionsRef = ref(db, `users/${formattedEmail}/sessions`);
        
        const [sessionsAddedSnap, userSessionsSnap] = await Promise.all([
            get(sessionsAddedRef),
            get(userSessionsRef)
        ]);
        
        const deletionPromises = [];
        const passkeys = [];
        
        // 2. Process sessions from sessions_added
        if (sessionsAddedSnap.exists()) {
            sessionsAddedSnap.forEach(sessionSnap => {
                const sessionKey = sessionSnap.key;
                const passkey = sessionSnap.val().passkey;
                if (passkey) passkeys.push(passkey);
                
                const sessionAddedRef = ref(db, `users/${formattedEmail}/${loginInfoN}/sessions_added/${sessionKey}`);
                deletionPromises.push(remove(sessionAddedRef));
            });
        }
        
        // 3. Process sessions from user's sessions
        if (userSessionsSnap.exists()) {
            userSessionsSnap.forEach(sessionSnap => {
                const sessionKey = sessionSnap.key;
                const passkey = sessionSnap.val().passkey;
                if (passkey && !passkeys.includes(passkey)) passkeys.push(passkey);
                
                const userSessionRef = ref(db, `users/${formattedEmail}/sessions/${sessionKey}`);
                const globalSessionRef = ref(db, `sessions/${sessionKey}`);
                
                deletionPromises.push(remove(userSessionRef));
                deletionPromises.push(remove(globalSessionRef));
            });
        }
        
        // 4. Delete all passkey references
        passkeys.forEach(passkey => {
            const sessionCodeRef = ref(db, `session_codes/${passkey}`);
            deletionPromises.push(remove(sessionCodeRef));
        });
        
        // Wait for all deletion operations to complete
        await Promise.all(deletionPromises);
        
        // Remove the loading overlay
        removeLoadingOverlay();
        
        // Show success message
        showNotification(`Successfully deleted all sessions (${deletionPromises.length / 2} total)`, 'success');
        
        // Refresh the sessions view
        fetchSessions(user);
        
    } catch (error) {
        console.error("Error deleting all sessions:", error);
        removeLoadingOverlay();
        showNotification('Failed to delete all sessions: ' + error.message, 'error');
    }
}

// Function to show loading overlay
function showLoadingOverlay(message = "Processing...") {
    // Remove any existing overlay first
    removeLoadingOverlay();
    
    const overlay = document.createElement('div');
    overlay.id = 'loading-overlay';
    overlay.className = 'fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50';
    
    overlay.innerHTML = `
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
            <div class="mb-4">
                <i class="fas fa-spinner fa-spin text-orange-500 text-4xl"></i>
            </div>
            <p class="text-gray-800 text-lg">${message}</p>
        </div>
    `;
    
    document.body.appendChild(overlay);
}

// Function to remove loading overlay
function removeLoadingOverlay() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
        overlay.remove();
    }
}
