import { initializeApp, getApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";
import { getDatabase, ref, set, get, remove, onValue, onChildAdded, child } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";
import "https://webrtc.github.io/adapter/adapter-latest.js";

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

// Initialize Firebase - fix duplicate app error
let app;
try {
    // Try to get existing app
    app = getApp();
    console.log("Using existing Firebase app");
} catch (e) {
    // Initialize new app if none exists
    app = initializeApp(firebaseConfig);
    console.log("Initialized new Firebase app");
}

const auth = getAuth(app);
const db = getDatabase(app);

// WebRTC configuration
const peerConnectionConfig = {
    iceServers: [
        { urls: "stun:stun.relay.metered.ca:80" },
        {
            urls: "turn:asia.relay.metered.ca:80?transport=tcp",
            username: "08a10b202c595304495012c2",
            credential: "JnsH2+jc2q3/uGon"
        }
    ]
};

// Global variables
let sessionId = null;
let userEmail = null;
let formattedEmail = null;
let peerConnections = {};
let activeJoiners = [];
let pendingJoinRequests = [];
let audioEnabled = true;
let ignoreJoinRequests = false;

// Add at the end of your global variables section (around line 40)
window.getPendingRequests = function() {
    console.log("Pending requests accessed:", pendingJoinRequests);
    return pendingJoinRequests;
};

// Add this function near the other exposed window functions (around line 40)

window.getActiveJoiners = function() {
    return activeJoiners;
};

// Get session info from URL
const urlParams = new URLSearchParams(window.location.search);
sessionId = urlParams.get("session_n");
const sessionPasskey = urlParams.get("passkey");
const sessionName = urlParams.get("session_name");

// Set session name in title if available
if (sessionName) {
    document.getElementById("session_title").textContent = sessionName;
}

// Display passkey for joiners
if (sessionPasskey) {
    document.getElementById("sessionPasskeyDisplay").textContent = sessionPasskey;
}

// Initialize the host
function initializeHost(user) {
    if (!user || !user.email || !sessionId) {
        console.error("Missing user email or session ID");
        return;
    }

    userEmail = user.email;
    formattedEmail = userEmail.replace(/\./g, "_");

    // Listen for join requests
    listenForJoinRequests();
    
    // Set this session as active
    updateSessionStatus(true);
    
    console.log("Host initialized for session:", sessionId);
    
    // IMPORTANT: Make sure this line is executed
    console.log("Setting up detection event listener for:", 
        `users/${formattedEmail}/sessions/${sessionId}/detection_events`);
    listenForDetectionEvents();
}

// Update session status (active/inactive)
async function updateSessionStatus(active) {
    if (!formattedEmail || !sessionId) return;
    
    try {
        await set(ref(db, `users/${formattedEmail}/sessions/${sessionId}/active`), active);
        console.log(`Session status set to ${active ? 'active' : 'inactive'}`);
    } catch (error) {
        console.error("Error updating session status:", error);
    }
}

// Update the listenForJoinRequests function
function listenForJoinRequests() {
    if (!formattedEmail || !sessionId) {
        console.error("Missing email or session ID, can't listen for join requests");
        return;
    }
    
    console.log(`Setting up join request listener for ${formattedEmail}/sessions/${sessionId}/join_requests`);
    
    // Log the exact path for debugging
    const joinRequestsPath = `users/${formattedEmail}/sessions/${sessionId}/join_requests`;
    console.log(`Full join requests path: ${joinRequestsPath}`);
    
    const joinRequestsRef = ref(db, joinRequestsPath);
    
    // Initialize pendingJoinRequests to empty array to prevent showing notifications for existing requests
    pendingJoinRequests = [];
    
    // Add a one-time value listener to check if there are any requests already
    get(joinRequestsRef).then((snapshot) => {
        if (snapshot.exists()) {
            console.log("Existing join requests found:", snapshot.val());
        } else {
            console.log("No existing join requests found");
        }
    }).catch(error => {
        console.error("Error checking for existing join requests:", error);
    });
    
    // Continue with your existing code for onChildAdded...
    onChildAdded(joinRequestsRef, (snapshot) => {
        const requestId = snapshot.key;
        const requestData = snapshot.val();
        
        console.log("Join request data received:", requestId, requestData);
        
        if (requestData && requestData.email) {
            // Create a unique identifier using email + deviceId (if available)
            const deviceId = requestData.deviceId || 'unknown';
            const deviceName = requestData.deviceName || 'Unknown Device';
            const uniqueRequestId = `${requestData.email}_${deviceId}`;
            
            // Check if this device is already connected as an active joiner
            const isAlreadyActive = activeJoiners.some(joiner => 
                joiner.email === requestData.email && joiner.deviceId === deviceId);
            
            if (isAlreadyActive) {
                console.log(`Device ${deviceName} (${requestData.email}) is already connected, ignoring request`);
                return;
            }
            
            // Check if we already have a pending request from this device
            const existingRequestIndex = pendingJoinRequests.findIndex(req => req.uniqueId === uniqueRequestId);
            
            if (existingRequestIndex >= 0) {
                // Update the existing request with the new request ID
                console.log(`Updating existing request for ${uniqueRequestId} with new ID ${requestId}`);
                pendingJoinRequests[existingRequestIndex].id = requestId;
                pendingJoinRequests[existingRequestIndex].timestamp = requestData.timestamp || Date.now();
            } else {
                // This is a new unique request
                console.log("New join request:", requestId, requestData.email, deviceName);
                
                // Add to pending requests with device info
                pendingJoinRequests.push({
                    id: requestId,
                    uniqueId: uniqueRequestId,
                    email: requestData.email,
                    deviceId: deviceId,
                    deviceName: deviceName,
                    timestamp: requestData.timestamp || Date.now()
                });
                
                // Show notification
                if (!ignoreJoinRequests) {
                    showToast("info", `Join request from ${requestData.email} (${deviceName})`);
                    
                    // Trigger join request notification
                    if (window.onJoinRequest) {
                        window.onJoinRequest(requestId, requestData.email, deviceName);
                    } else {
                        console.error("window.onJoinRequest is not defined");
                    }
                }
            }
            
            // Update notification count after processing the request
            updateNotificationCount();
        } else {
            console.warn("Received invalid join request data:", requestData);
        }
    });
}

// Update notification count
function updateNotificationCount() {
    // Deduplicate requests by uniqueId before counting
    const uniqueRequests = [];
    const uniqueIds = new Set();
    
    pendingJoinRequests.forEach(req => {
        if (!uniqueIds.has(req.uniqueId)) {
            uniqueIds.add(req.uniqueId);
            uniqueRequests.push(req);
        }
    });
    
    const count = uniqueRequests.length;
    
    // Update notification count in UI
    const notificationCount = document.getElementById("notification_count");
    if (notificationCount) {
        // Only show count if there are actual pending requests
        if (count > 0) {
            notificationCount.textContent = count;
            notificationCount.style.display = "inline";
        } else {
            notificationCount.textContent = "";
            notificationCount.style.display = "none";
        }
    }
    
    // Show/hide notification icon
    const notificationIcon = document.getElementById("join_request_notification");
    if (notificationIcon) {
        notificationIcon.classList.toggle("hidden", count === 0);
    }
    
    console.log(`Updated notification count: ${count} unique requests`);
}

// Accept a join request
async function acceptJoinRequest(requestId, email, deviceName = 'Unknown Device') {
    if (!formattedEmail || !sessionId) {
        console.error("Missing email or session ID, can't accept join request");
        return;
    }
    
    try {
        console.log(`Accepting join request ${requestId} from ${email} (${deviceName})`);
        
        // Get the request data to retrieve device ID if available
        const requestRef = ref(db, `users/${formattedEmail}/sessions/${sessionId}/join_requests/${requestId}`);
        const requestSnapshot = await get(requestRef);
        const requestData = requestSnapshot.exists() ? requestSnapshot.val() : null;
        const deviceId = requestData?.deviceId || 'unknown';
        
        // Update request status to accepted in Firebase
        await set(ref(db, `users/${formattedEmail}/sessions/${sessionId}/join_requests/${requestId}/status`), "accepted");
        
        // Update current joiners count
        const joinersRef = ref(db, `users/${formattedEmail}/sessions/${sessionId}/current_joiners`);
        const snapshot = await get(joinersRef);
        const currentCount = snapshot.exists() ? snapshot.val() : 0;
        await set(joinersRef, currentCount + 1);
        
        // Create unique identifier for this request
        const uniqueId = `${email}_${deviceId}`;
        
        // Remove ALL requests with this uniqueId from pendingRequests
        pendingJoinRequests = pendingJoinRequests.filter(req => req.uniqueId !== uniqueId);
        updateNotificationCount();
        
        // Check if this joiner is already active (prevent duplicates)
        const existingJoiner = activeJoiners.find(j => j.email === email && j.deviceId === deviceId);
        if (existingJoiner) {
            console.log(`Joiner ${email} (${deviceName}) is already active as camera ${existingJoiner.cameraNumber}`);
            return;
        }
        
        // Add to active joiners array with camera number assignment and device info
        const cameraNumber = activeJoiners.length + 1;
        activeJoiners.push({
            id: requestId,
            email: email,
            deviceId: deviceId,
            deviceName: deviceName,
            cameraNumber: cameraNumber
        });
        
        // Create peer connection for this joiner
        createPeerConnectionForJoiner(requestId, email, cameraNumber);
        
        console.log(`Accepted join request from ${email} (${deviceName}) as camera ${cameraNumber}`);
        showToast("success", `Accepted join request from ${email} (${deviceName})`);
        
        // Update cameras count in UI
        document.getElementById("activeCamerasCount").textContent = activeJoiners.length;
        document.getElementById("totalCamerasCount").textContent = activeJoiners.length;
    } catch (error) {
        console.error("Error accepting join request:", error);
        showToast("error", "Failed to accept join request");
    }
}

// Reject a join request
async function rejectJoinRequest(requestId) {
    if (!formattedEmail || !sessionId) return;
    
    try {
        // Remove the request
        await remove(ref(db, `users/${formattedEmail}/sessions/${sessionId}/join_requests/${requestId}`));
        
        // Remove from pending requests
        pendingJoinRequests = pendingJoinRequests.filter(req => req.id !== requestId);
        updateNotificationCount();
        
        console.log(`Rejected join request ${requestId}`);
        showToast("info", "Join request rejected");
    } catch (error) {
        console.error("Error rejecting join request:", error);
    }
}

// Replace your createPeerConnectionForJoiner function with this version:
function createPeerConnectionForJoiner(joinerId, joinerEmail, cameraNumber) {
    // If already have connection for this joiner, close it first
    if (peerConnections[joinerId]) {
        console.log(`Closing existing peer connection for joiner ${joinerId}`);
        peerConnections[joinerId].close();
    }
    
    console.log(`Creating new peer connection for joiner ${joinerId} with camera ${cameraNumber}`);
    
    // Create a new peer connection with the exact config that matches Android
    const peerConnection = new RTCPeerConnection(peerConnectionConfig);
    peerConnections[joinerId] = peerConnection;
    
    // IMPORTANT: Add transceivers to match Android expectations
    console.log("Adding transceivers for audio/video - recvonly");
    peerConnection.addTransceiver('audio', {direction: 'recvonly'});
    peerConnection.addTransceiver('video', {direction: 'recvonly'});
    
    // Debug connection state changes
    peerConnection.onconnectionstatechange = () => {
        console.log(`Connection state for joiner ${joinerId}: ${peerConnection.connectionState}`);
        updateConnectionStatus(cameraNumber, `Connection: ${peerConnection.connectionState}`);
        
        if (peerConnection.connectionState === 'connected') {
            console.log(`Peer connection ${joinerId} successfully connected`);
        } else if (peerConnection.connectionState === 'failed' || 
                  peerConnection.connectionState === 'disconnected' || 
                  peerConnection.connectionState === 'closed') {
            console.error(`Peer connection ${joinerId} ${peerConnection.connectionState}`);
        }
    };
    
    // Set up other event handlers
    peerConnection.onicegatheringstatechange = () => {
        console.log(`ICE gathering state for joiner ${joinerId}: ${peerConnection.iceGatheringState}`);
    };
    
    peerConnection.onsignalingstatechange = () => {
        console.log(`Signaling state for joiner ${joinerId}: ${peerConnection.signalingState}`);
    };
    
    // Set up event handlers for ICE candidates
    peerConnection.onicecandidate = event => {
        if (event.candidate) {
            console.log(`Generated ICE candidate for joiner ${joinerId}`);
            sendIceCandidateToJoiner(joinerId, joinerEmail, event.candidate);
        }
    };
    
    // Update the ontrack event handler
    peerConnection.ontrack = event => {
        console.log(`✅ ontrack triggered for joiner ${joinerId}:`, event.track.kind, event.track.readyState);
        console.log(`Detailed track info: ID=${event.track.id}, enabled=${event.track.enabled}, muted=${event.track.muted}`);
        
        // Log streams information
        if (event.streams && event.streams.length > 0) {
            console.log(`Event has ${event.streams.length} streams with first stream ID: ${event.streams[0].id}`);
            event.streams[0].getTracks().forEach(track => {
                console.log(`Stream track: kind=${track.kind}, ID=${track.id}, enabled=${track.enabled}`);
            });
        } else {
            console.log("Event has no streams, creating synthetic one");
        }
        
        // Create a new MediaStream if none is provided (to match Android behavior)
        let stream;
        if (event.streams && event.streams.length > 0) {
            stream = event.streams[0];
        } else {
            stream = new MediaStream();
            stream.addTrack(event.track);
        }
        
        // This matches Android's approach where it immediately attaches tracks to renderers
        if (event.track.kind === 'video') {
            console.log(`Received VIDEO track from joiner ${joinerId} - handling immediately`);
            // Process the stream appropriately
            handleRemoteStream(stream, cameraNumber);
            
            // Notify UI that camera is connected - matches Android's showCameraConnected
            window.onCameraConnected?.(cameraNumber, `Remote Camera ${cameraNumber}`);
        } else {
            console.log(`Received ${event.track.kind} track from joiner ${joinerId}`);
        }
    };
    
    // IMPORTANT: Create and send offer to joiner (matching Android implementation)
    createAndSendOfferToJoiner(joinerId, joinerEmail, peerConnection);
    
    // Listen for answer from joiner, not offer (this is the key change)
    listenForJoinerAnswer(joinerId, joinerEmail, peerConnection);
    
    return peerConnection;
}

// Add this new function to create and send offer like Android does
async function createAndSendOfferToJoiner(joinerId, joinerEmail, peerConnection) {
    const joinerFormattedEmail = joinerEmail.replace(/\./g, "_");
    
    try {
        console.log(`Creating offer for joiner ${joinerId}`);
        
        // Create offer with constraints matching Android
        const constraints = {
            offerToReceiveAudio: true,
            offerToReceiveVideo: true
        };
        
        const offer = await peerConnection.createOffer(constraints);
        await peerConnection.setLocalDescription(offer);
        console.log(`Set local description (offer) for joiner ${joinerId}`);
        
        // Send offer to joiner via Firebase (just like Android)
        const offerPath = `users/${joinerFormattedEmail}/sessions/${sessionId}/Offer`;
        await set(ref(db, offerPath), offer.sdp);
        console.log(`Offer sent to joiner ${joinerId}`);
    } catch (error) {
        console.error(`Error creating/sending offer to joiner ${joinerId}:`, error);
    }
}

// Replace listenForJoinerOffer with listenForJoinerAnswer
function listenForJoinerAnswer(joinerId, joinerEmail, peerConnection) {
    const joinerFormattedEmail = joinerEmail.replace(/\./g, "_");
    
    // Listen for Answer from joiner (matches Android SFUManager.java)
    const answerRef = ref(db, `users/${joinerFormattedEmail}/sessions/${sessionId}/Answer`);
    console.log(`Listening for answer from joiner at ${joinerFormattedEmail}/sessions/${sessionId}/Answer`);
    
    onValue(answerRef, async (snapshot) => {
        if (snapshot.exists()) {
            const answerSDP = snapshot.val();
            if (answerSDP) {
                console.log(`Received answer from joiner ${joinerId}, length: ${answerSDP.length}`);
                
                try {
                    // Set the remote description with the answer
                    await peerConnection.setRemoteDescription(
                        new RTCSessionDescription({ 
                            type: "answer", 
                            sdp: answerSDP 
                        })
                    );
                    console.log(`✅ Set remote description (answer) for joiner ${joinerId}`);
                    
                    // Listen for ICE candidates from this joiner
                    listenForJoinerIceCandidates(joinerId, joinerEmail, peerConnection);
                } catch (error) {
                    console.error(`❌ Error processing answer from joiner ${joinerId}:`, error);
                }
            }
        }
    });
}

// Listen for ICE candidates from a joiner
function listenForJoinerIceCandidates(joinerId, joinerEmail, peerConnection) {
    const joinerFormattedEmail = joinerEmail.replace(/\./g, "_");
    const iceCandidatesRef = ref(db, `users/${joinerFormattedEmail}/sessions/${sessionId}/ice_candidates`);
    
    onChildAdded(iceCandidatesRef, (snapshot) => {
        const candidateData = snapshot.val();
        if (candidateData) {
            const iceCandidate = new RTCIceCandidate(candidateData);
            peerConnection.addIceCandidate(iceCandidate)
                .then(() => console.log(`Added ICE candidate from joiner ${joinerId}`))
                .catch(error => console.error("Error adding ICE candidate:", error));
        }
    });
}

// Send ICE candidate to joiner
async function sendIceCandidateToJoiner(joinerId, joinerEmail, candidate) {
    const joinerFormattedEmail = joinerEmail.replace(/\./g, "_");
    const hostCandidatesRef = ref(db, `users/${joinerFormattedEmail}/sessions/${sessionId}/host_candidates`);
    
    try {
        const candidateKey = `candidate_${Date.now()}`;
        await set(child(hostCandidatesRef, candidateKey), candidate.toJSON());
    } catch (error) {
        console.error("Error sending ICE candidate to joiner:", error);
    }
}

// Handle remote stream from a joiner
// Replace your handleRemoteStream function
function handleRemoteStream(stream, cameraNumber) {
    console.log(`🔴 handleRemoteStream called for camera ${cameraNumber} with stream:`, stream.id);
    
    // Check if the stream has video tracks
    const videoTracks = stream.getVideoTracks();
    if (videoTracks.length > 0) {
        console.log(`Stream has ${videoTracks.length} video tracks`);
        videoTracks.forEach(track => {
            console.log(`Video track: ID=${track.id}, enabled=${track.enabled}, readyState=${track.readyState}`);
        });
    } else {
        console.warn(`Stream has NO video tracks!`);
    }
    
    const videoElement = document.getElementById(`remoteVideo${cameraNumber}`);
    if (!videoElement) {
        console.error(`Video element remoteVideo${cameraNumber} not found!`);
        return;
    }
    
    // First try - use the standard approach
    try {
        // Ensure old streams are properly cleaned up
        if (videoElement.srcObject) {
            const oldStream = videoElement.srcObject;
            oldStream.getTracks().forEach(track => track.stop());
        }
        
        // Set the new stream
        videoElement.srcObject = stream;
        console.log(`Set srcObject for video${cameraNumber} to stream ${stream.id}`);
        
        // Force play the video with error handling
        const playPromise = videoElement.play();
        if (playPromise !== undefined) {
            playPromise.catch(error => {
                console.error(`Error playing video: ${error}`);
                // Try playing again after a delay (autoplay restrictions)
                setTimeout(() => {
                    videoElement.play()
                        .then(() => console.log(`Video ${cameraNumber} playing after delay`))
                        .catch(e => console.error(`Still can't play video ${cameraNumber}:`, e));
                }, 1000);
            });
        }
        
        // Monitor video state
        videoElement.onloadedmetadata = () => {
            console.log(`Video ${cameraNumber} metadata loaded: ${videoElement.videoWidth}x${videoElement.videoHeight}`);
        };
        
        videoElement.oncanplay = () => {
            console.log(`Video ${cameraNumber} can now play`);
            updateConnectionStatus(cameraNumber, "Stream ready");
        };
    } catch (e) {
        console.error(`Error handling remote stream for camera ${cameraNumber}:`, e);
        
        // Fallback approach - try attaching tracks directly
        try {
            console.log("Trying alternative attachment method...");
            const videoTrack = stream.getVideoTracks()[0];
            if (videoTrack) {
                // For Safari compatibility
                if ('srcObject' in videoElement) {
                    const newStream = new MediaStream([videoTrack]);
                    videoElement.srcObject = newStream;
                    console.log("Attached video track via new stream");
                }
            }
        } catch (fallbackError) {
            console.error("Fallback attachment also failed:", fallbackError);
        }
    }
}

// Add this right after handleRemoteStream function
// Force refresh of all video elements - sometimes helps with rendering issues
function refreshVideoElements() {
    for (let i = 1; i <= 4; i++) {
        const videoElement = document.getElementById(`remoteVideo${i}`);
        if (videoElement && videoElement.srcObject) {
            const stream = videoElement.srcObject;
            videoElement.srcObject = null;
            setTimeout(() => {
                videoElement.srcObject = stream;
                videoElement.play().catch(e => console.error(`Error playing video ${i}:`, e));
            }, 100);
        }
    }
}

// Call this function if videos aren't showing up
window.refreshVideoElements = refreshVideoElements;

// Add a global refresh button for emergencies
if (document.getElementById('refreshVideosBtn')) {
    document.getElementById('refreshVideosBtn').addEventListener('click', refreshVideoElements);
}

// Show camera as connected in the UI
function showCameraConnected(cameraNumber) {
    // Make the container visible
    const container = document.getElementById(`feed_container_${cameraNumber}`);
    if (container) {
        container.classList.add("connected");
        // Add a visual indicator that connection is established
        container.style.borderColor = "#4CAF50";
    }
    
    // Hide the "camera off" message if it exists
    const offMessage = document.getElementById(`camera_off_message_${cameraNumber}`);
    if (offMessage) {
        offMessage.classList.add("hidden");
    }
    
    // Update UI with connection status
    if (window.onCameraConnected) {
        window.onCameraConnected(cameraNumber, `Remote Camera ${cameraNumber}`);
    }
    
    // Add an explicit success message
    showToast("success", `Camera ${cameraNumber} connected and streaming`);
}

// Toggle audio mute/unmute
function toggleAudio() {
    audioEnabled = !audioEnabled;
    
    // Update all peer connections
    Object.values(peerConnections).forEach(pc => {
        const senders = pc.getSenders();
        senders.forEach(sender => {
            if (sender.track && sender.track.kind === 'audio') {
                sender.track.enabled = audioEnabled;
            }
        });
    });
    
    console.log(`Audio ${audioEnabled ? 'enabled' : 'disabled'}`);
    showToast("info", `Microphone ${audioEnabled ? 'unmuted' : 'muted'}`);
}

// Handle camera status changes
function handleCameraStatusChange(cameraNumber, isCameraOff, isMicOff) {
    const cameraOffMessage = document.getElementById(`camera_off_message_${cameraNumber}`);
    const micStatus = document.getElementById(`mic_status_${cameraNumber}`);
    
    if (cameraOffMessage) {
        cameraOffMessage.classList.toggle("hidden", !isCameraOff);
    }
    
    if (micStatus) {
        micStatus.classList.toggle("hidden", !isMicOff);
    }
    
    // Update UI through callback
    if (window.onCameraStatusChange) {
        window.onCameraStatusChange(cameraNumber, isCameraOff, isMicOff);
    }
}

// End the session
async function endSession() {
    // Close all peer connections
    Object.values(peerConnections).forEach(pc => pc.close());
    peerConnections = {};
    
    // Set session as inactive
    await updateSessionStatus(false);
    
    // Redirect to home
    window.location.href = "/home";
}

// Expose functions to the window
window.acceptJoinRequest = acceptJoinRequest;
window.rejectJoinRequest = rejectJoinRequest;
window.toggleAudio = toggleAudio;
window.endSession = endSession;
window.handleRemoteStream = handleRemoteStream;
window.muteMic = () => { audioEnabled = false; toggleAudio(); };
window.unmuteMic = () => { audioEnabled = true; toggleAudio(); };
window.disconnectCamera = async (cameraNumber) => {
    const joiner = activeJoiners.find(j => j.cameraNumber === cameraNumber);
    if (joiner) {
        // Close peer connection
        if (peerConnections[joiner.id]) {
            peerConnections[joiner.id].close();
            delete peerConnections[joiner.id];
        }
        
        // Remove from active joiners
        activeJoiners = activeJoiners.filter(j => j.id !== joiner.id);
        
        // Update UI
        if (window.onCameraDisconnected) {
            window.onCameraDisconnected(cameraNumber);
        }
        
        // Update cameras count in UI
        document.getElementById("activeCamerasCount").textContent = activeJoiners.length;
        
        showToast("info", `Camera ${cameraNumber} disconnected`);
    }
};
window.getPendingRequests = () => pendingJoinRequests;

// Authenticate and initialize when the page loads
onAuthStateChanged(auth, (user) => {
    if (user) {
        console.log("User is authenticated:", user.email);
        initializeHost(user);
        
        // Make sure passkey is displayed
        if (sessionPasskey) {
            console.log("Setting session passkey display:", sessionPasskey);
            const passkeyDisplay = document.getElementById("sessionPasskeyDisplay");
            if (passkeyDisplay) {
                passkeyDisplay.textContent = sessionPasskey;
            }
        }
    } else {
        console.log("User not authenticated, redirecting to login");
        window.location.href = "/login";
    }
});

// Clean up resources when leaving the page
window.addEventListener("beforeunload", async (event) => {
    // Close all peer connections
    Object.values(peerConnections).forEach(pc => pc.close());
    
    // Set session as inactive
    if (formattedEmail && sessionId) {
        try {
            await updateSessionStatus(false);
        } catch (error) {
            console.error("Error updating session status:", error);
        }
    }
});

// Functions for UI interaction
document.addEventListener("DOMContentLoaded", () => {
    // Session info button
    const sessionInfoBtn = document.getElementById("session_info_btn");
    if (sessionInfoBtn) {
        sessionInfoBtn.addEventListener("click", toggleSessionInfoPanel);
    }
    
    // Copy session button
    const copySessionBtn = document.getElementById("copySessionBtn");
    if (copySessionBtn) {
        copySessionBtn.addEventListener("click", copySessionPasskey);
    }
    
    // Close info panel button
    const closeInfoPanelBtn = document.getElementById("closeInfoPanelBtn");
    if (closeInfoPanelBtn) {
        closeInfoPanelBtn.addEventListener("click", hideSessionInfoPanel);
    }
    
    // Configure video elements
    for (let i = 1; i <= 4; i++) {
        const video = document.getElementById(`remoteVideo${i}`);
        if (video) {
            // Set important attributes
            video.autoplay = true;
            video.playsInline = true;
            video.muted = false;
            
            // Set important styles
            video.style.width = "100%";
            video.style.height = "100%";
            video.style.objectFit = "contain";
            
            // Force play on click (helps on some browsers)
            video.addEventListener('click', () => {
                if (video.paused) {
                    video.play().catch(e => console.error(`Error playing video ${i}:`, e));
                }
            });
            
            console.log(`Video element ${i} initialized`);
        } else {
            console.error(`Video element ${i} not found`);
        }
    }
    
    // Debug video elements
    console.log("Looking for video elements:");
    for (let i = 1; i <= 4; i++) {
        const videoElement = document.getElementById(`remoteVideo${i}`);
        if (videoElement) {
            console.log(`✅ remoteVideo${i} found`);
        } else {
            console.error(`❌ remoteVideo${i} NOT FOUND - this will prevent videos from showing`);
        }
    }
    
    // Call debug function after a short delay to ensure DOM is fully loaded
    setTimeout(debugVideoElements, 1000);
});

// Toggle session info panel
function toggleSessionInfoPanel() {
    const panel = document.getElementById("sessionInfoPanel");
    if (panel) {
        panel.classList.toggle("hidden");
    }
}

// Hide session info panel
function hideSessionInfoPanel() {
    const panel = document.getElementById("sessionInfoPanel");
    if (panel) {
        panel.classList.add("hidden");
    }
}

// Copy session passkey to clipboard
function copySessionPasskey() {
    if (sessionPasskey) {
        navigator.clipboard.writeText(sessionPasskey)
            .then(() => {
                showToast("success", "Session code copied to clipboard");
            })
            .catch(err => {
                console.error("Could not copy text: ", err);
                showToast("error", "Failed to copy session code");
            });
    }
}

// Show toast notification
function showToast(type, message) {
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

// Add this to host_stream.js
function updateConnectionStatus(cameraNumber, status) {
    console.log(`Camera ${cameraNumber} status: ${status}`);
    
    const container = document.getElementById(`feed_container_${cameraNumber}`);
    if (!container) return;
    
    let statusElement = container.querySelector('.connection-status');
    if (!statusElement) {
        statusElement = document.createElement('div');
        statusElement.className = 'connection-status absolute top-4 right-20 bg-black bg-opacity-60 text-white text-sm py-1 px-2 rounded z-10';
        container.appendChild(statusElement);
    }
    
    statusElement.textContent = status;
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        statusElement.style.opacity = '0';
        statusElement.style.transition = 'opacity 1s';
        setTimeout(() => {
            if (statusElement.parentNode) {
                statusElement.parentNode.removeChild(statusElement);
            }
        }, 1000);
    }, 5000);
}

// Add this function to the file
function debugVideoElements() {
    for (let i = 1; i <= 4; i++) {
        const videoElement = document.getElementById(`remoteVideo${i}`);
        if (videoElement) {
            console.log(`Video element ${i} properties:`, {
                id: videoElement.id,
                width: videoElement.width,
                height: videoElement.height,
                autoplay: videoElement.autoplay,
                playsInline: videoElement.playsInline,
                muted: videoElement.muted,
                srcObject: videoElement.srcObject ? "Set" : "Not set",
                style: {
                    width: videoElement.style.width,
                    height: videoElement.style.height,
                    objectFit: videoElement.style.objectFit
                }
            });
            
            // Check if contained in DOM
            const isInDOM = document.body.contains(videoElement);
            console.log(`Video element ${i} is ${isInDOM ? '' : 'NOT'} in the DOM`);
        } else {
            console.error(`Video element ${i} not found!`);
        }
    }
}

// Add this at the end of your file
window.debugRTCConnection = function() {
    console.log("DEBUG: Current active joiners:", activeJoiners);
    console.log("DEBUG: Current peer connections:", Object.keys(peerConnections));
    
    // Log connection states
    for (const [id, pc] of Object.entries(peerConnections)) {
        console.log(`Connection ${id} state:`, {
            connectionState: pc.connectionState,
            signalingState: pc.signalingState,
            iceConnectionState: pc.iceConnectionState,
            iceGatheringState: pc.iceGatheringState
        });
    }
    
    // Force refresh button
    const debugBtn = document.createElement('button');
    debugBtn.textContent = 'Force Refresh Video';
    debugBtn.style = 'position:fixed; bottom:100px; left:20px; z-index:9999; background:#f00; color:white; padding:10px;';
    debugBtn.onclick = refreshVideoElements;
    document.body.appendChild(debugBtn);
}

// Call this from your browser console when needed: window.debugRTCConnection()

// Add this function to check all possible paths
function monitorAllPossibleOfferPaths(joinerId, joinerEmail) {
    const joinerFormattedEmail = joinerEmail.replace(/\./g, "_");
    
    console.log("Monitoring paths for joiner:", joinerId, joinerEmail);
    
    // Create and listen path where Android client sends the offer
    const mobileOfferPath = `users/${joinerFormattedEmail}/sessions/${sessionId}`;
    console.log(`Setting up path monitor for: ${mobileOfferPath}`);
    
    // Add this to createPeerConnectionForJoiner right before listenForJoinerOffer
    get(ref(db, mobileOfferPath))
        .then(snapshot => {
            if (snapshot.exists()) {
                console.log(`Found data at ${mobileOfferPath}:`, snapshot.val());
                // Check for Answer, Offer
                if (snapshot.child('Offer').exists()) {
                    console.log("✅ Found Offer node already!");
                }
            } else {
                console.log(`Path ${mobileOfferPath} doesn't exist yet`);
            }
        });
}

// Add to your host_stream.js file
// Force a connection renegotiation if needed
window.renegotiateConnection = async function(joinerId) {
    const connection = peerConnections[joinerId];
    if (!connection) {
        console.log(`No connection found for joiner ${joinerId}`);
        return;
    }
    
    console.log(`Renegotiating connection for joiner ${joinerId}`);
    
    try {
        const joiner = activeJoiners.find(j => j.id === joinerId);
        if (joiner) {
            await createAndSendOfferToJoiner(joinerId, joiner.email, connection);
        }
    } catch (error) {
        console.error(`Error renegotiating connection:`, error);
    }
};

// Add this helper function for debugging
window.debugMediaStreams = function() {
    console.log("🎥 ACTIVE MEDIA STREAMS REPORT:");
    
    // Report on peer connections
    console.log(`Active peer connections: ${Object.keys(peerConnections).length}`);
    for (const [joinerId, pc] of Object.entries(peerConnections)) {
        console.log(`Connection ${joinerId}:`, {
            state: pc.connectionState,
            iceState: pc.iceConnectionState,
            signalingState: pc.signalingState,
            receivers: pc.getReceivers().length
        });
        
        // Log receivers (incoming tracks)
        pc.getReceivers().forEach(receiver => {
            console.log(`Receiver track:`, {
                kind: receiver.track?.kind,
                enabled: receiver.track?.enabled,
                readyState: receiver.track?.readyState,
                id: receiver.track?.id
            });
        });
    }
    
    // Check all video elements
    for (let i = 1; i <= 4; i++) {
        const video = document.getElementById(`remoteVideo${i}`);
        if (video) {
            console.log(`Video ${i} status:`, {
                hasStream: video.srcObject ? true : false,
                videoWidth: video.videoWidth,
                videoHeight: video.videoHeight,
                paused: video.paused,
                ended: video.ended,
                readyState: video.readyState,
                networkState: video.networkState
            });
            
            // Count tracks in the stream
            if (video.srcObject) {
                const videoTracks = video.srcObject.getVideoTracks();
                const audioTracks = video.srcObject.getAudioTracks();
                console.log(`Stream has ${videoTracks.length} video tracks and ${audioTracks.length} audio tracks`);
                videoTracks.forEach(track => console.log(`Video track:`, track));
            }
        }
    }
    
    // Show debug controls
    const debugPanel = document.createElement('div');
    debugPanel.style = 'position:fixed; top:80px; right:20px; z-index:9999; background:#000; color:#fff; padding:10px; border-radius:5px;';
    debugPanel.innerHTML = '<h3>Stream Debug</h3>';
    
    const refreshBtn = document.createElement('button');
    refreshBtn.textContent = 'Refresh All Videos';
    refreshBtn.style = 'display:block; margin:5px 0; padding:8px; background:#f00; color:#fff; border:none; border-radius:5px;';
    refreshBtn.onclick = forceRefreshVideoElements;
    debugPanel.appendChild(refreshBtn);
    
    document.body.appendChild(debugPanel);
    
    return "Debug panel added";
};

// Add function to force refresh all video elements
function forceRefreshVideoElements() {
    for (const [joinerId, pc] of Object.entries(peerConnections)) {
        // Get joiner info from activeJoiners
        const joiner = activeJoiners.find(j => j.id === joinerId);
        if (!joiner) continue;
        
        const cameraNumber = joiner.cameraNumber;
        const video = document.getElementById(`remoteVideo${cameraNumber}`);
        if (!video) continue;
        
        console.log(`Force refreshing video ${cameraNumber} for joiner ${joinerId}`);
        
        // Get all received tracks from this peer connection
        const receivers = pc.getReceivers();
        const videoReceivers = receivers.filter(r => r.track?.kind === 'video');
        
        if (videoReceivers.length > 0) {
            // Create a new MediaStream with the video track
            const newStream = new MediaStream();
            newStream.addTrack(videoReceivers[0].track);
            
            // Replace the srcObject
            video.srcObject = newStream;
            video.play().catch(e => console.warn(`Couldn't autoplay: ${e}`));
            
            console.log(`Manually attached video track to video${cameraNumber}`);
        } else {
            console.warn(`No video receivers found for joiner ${joinerId}`);
        }
    }
}

// Add this to host_stream.js to handle incoming detection events

// Map to track camera details for notification attribution
const cameraDetailsMap = {};

// Handle detection events from cameras
function handleCameraDetectionEvent(cameraNumber, detectionType, detectionData) {
    console.log(`Processing detection event: ${detectionType} from camera ${cameraNumber}`);
    
    // Get camera details for attribution
    const joiner = activeJoiners.find(j => j.cameraNumber === parseInt(cameraNumber));
    
    // Use available data even if joiner metadata isn't complete
    const deviceInfo = joiner?.deviceName || 'Unknown Device';
    const userEmail = joiner?.email || 'Unknown User';
    
    // Create notification data
    const timestamp = Date.now().toString();
    const date = new Date().toISOString().split('T')[0];
    const time = new Date().toLocaleTimeString();
    
    // Determine notification reason based on detection type
    let reason;
    switch(detectionType) {
        case 'sound':
            reason = `Sound detected by Camera ${cameraNumber}`;
            break;
        case 'motion':
            reason = `Motion detected by Camera ${cameraNumber}`;
            break;
        case 'person':
            reason = `Person detected by Camera ${cameraNumber}`;
            break;
        default:
            reason = `${detectionType} detected by Camera ${cameraNumber}`;
    }
    
    console.log(`Creating notification: "${reason}" for device: ${deviceInfo}`);
    
    // Save notification to Firebase
    saveDetectionNotification(reason, date, time, timestamp, {
        cameraNumber,
        deviceInfo,
        userEmail,
        detectionType,
        sessionId
    });
    
    // Show toast notification to host
    showToast("info", reason);
}

// Modify the saveDetectionNotification function around line 1186

async function saveDetectionNotification(reason, date, time, timestamp, metadata) {
    if (!formattedEmail || !sessionId) return;
    
    try {
        // Get session name for better context
        let sessionName = "Unknown Session";
        try {
            const sessionRef = ref(db, `users/${formattedEmail}/sessions/${sessionId}/session_name`);
            const snapshot = await get(sessionRef);
            if (snapshot.exists()) {
                sessionName = snapshot.val();
            }
        } catch (err) {
            console.warn("Couldn't get session name:", err);
        }
        
        // Create notification object with enhanced metadata
        const notification = {
            reason: reason,
            date: date,
            time: time,
            metadata: {
                ...metadata,
                sessionName: sessionName
            }
        };
        
        // 1. Save to session host's notifications
        const hostNotifPath = `users/${formattedEmail}/sessions/${sessionId}/notifications/${timestamp}`;
        await set(ref(db, hostNotifPath), notification);
        
        // 2. Also save to camera joiner's universal notifications if email is available
        if (metadata.userEmail && metadata.userEmail !== 'Unknown User') {
            const joinerEmail = metadata.userEmail.replace(/\./g, '_');
            const joinerNotifPath = `users/${joinerEmail}/universal_notifications/${timestamp}`;
            await set(ref(db, joinerNotifPath), notification);
        }
        
        console.log(`Detection notification saved for ${reason}`);
    } catch (error) {
        console.error("Error saving detection notification:", error);
    }
}

// Expose the function to be called from outside
window.onCameraDetection = handleCameraDetectionEvent;

// Add this to host_stream.js to listen for detection events

function listenForDetectionEvents() {
    if (!formattedEmail || !sessionId) {
        console.error("❌ Missing email or session ID, can't listen for detection events");
        return;
    }
    
    const detectionEventsPath = `users/${formattedEmail}/sessions/${sessionId}/detection_events`;
    console.log(`🎧 Setting up detection events listener at path: ${detectionEventsPath}`);
    
    const eventsRef = ref(db, detectionEventsPath);
    
    // First check if there are any existing events
    get(eventsRef).then(snapshot => {
        if (snapshot.exists()) {
            console.log("Found existing detection events:", Object.keys(snapshot.val()).length);
        } else {
            console.log("No existing detection events found");
        }
    }).catch(err => {
        console.error("Error checking for existing detection events:", err);
    });
    
    // Set up real-time listener
    onChildAdded(eventsRef, (snapshot) => {
        const eventId = snapshot.key;
        const eventData = snapshot.val();
        
        console.log("📢 DETECTION EVENT RECEIVED:", eventData);
        
        if (eventData && eventData.type) {
            console.log(`Processing ${eventData.type} detection from camera ${eventData.cameraNumber}`);
            
            try {
                // Process the detection event
                handleCameraDetectionEvent(
                    eventData.cameraNumber, 
                    eventData.type, 
                    eventData.data
                );
                
                // Remove the event once processed
                remove(ref(db, `${detectionEventsPath}/${eventId}`))
                    .then(() => console.log("Event removed after processing"))
                    .catch(err => console.error("Error removing event:", err));
                    
            } catch (error) {
                console.error("Error processing detection event:", error);
            }
        }
    }, (error) => {
        console.error("❌ Error setting up detection events listener:", error);
    });
    
    console.log("✅ Listening for camera detection events - setup complete");
}