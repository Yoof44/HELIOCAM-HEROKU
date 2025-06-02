<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">
<head>
    <title>HelioCam Host Session</title>
    <meta charset="utf-8">
    <meta name="viewport"="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable"="yes">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#1a1a1a] text-white">
<!-- Header -->
<div class="fixed top-0 left-0 right-0 z-20 bg-[#2a2a2a] shadow-lg">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="text-lg font-semibold text-white">
            <span id="session_title">HelioCam Live Session</span>
        </div>
        <div class="flex items-center">
            <div id="participants_count" class="px-3 py-1 bg-[#404040] rounded-full text-sm cursor-pointer">
                <span id="activeCamerasCount">0</span> active / <span id="totalCamerasCount">0</span> connected (max 4)
            </div>
            <div id="join_request_notification" class="hidden ml-3 relative">
                <button class="p-2 bg-orange-500 rounded-full text-white">
                    <i class="fas fa-bell"></i>
                    <span id="notification_count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Main Content - Camera Grid -->
<div class="pt-16 pb-16 h-screen">
    <div id="grid_layout" class="relative h-full w-full">
        <!-- Camera feeds will be arranged here -->
        <div id="feed_container_1" class="absolute border-2 border-gray-600 rounded-lg overflow-hidden transition-all duration-300 bg-[#1a1a1a]">
            <div class="w-full h-full relative video-container">
                <video id="remoteVideo1" autoplay playsinline class="w-full h-full bg-black"></video>
                
                <!-- Camera off message -->
                <div id="camera_off_message_1" class="hidden absolute inset-0 flex items-center justify-center bg-black bg-opacity-70">
                    <div class="text-center">
                        <i class="fas fa-video-slash text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-400">Camera turned off</p>
                    </div>
                </div>
                
                <!-- Mic status -->
                <div id="mic_status_1" class="hidden absolute bottom-4 left-4 bg-black bg-opacity-50 rounded p-2">
                    <i class="fas fa-microphone-slash text-red-500"></i>
                </div>
                
                <!-- Camera info bar -->
                <div class="absolute top-0 left-0 right-0 p-4 flex justify-between items-center bg-gradient-to-b from-black to-transparent">
                    <div id="camera_timestamp_1" class="text-sm text-gray-300">--:--:--</div>
                    <div id="camera_number_1" class="text-sm text-white px-2 py-1 bg-black bg-opacity-50 rounded-full">Camera 1</div>
                </div>
                
                <!-- Improved camera controls that appear on hover -->
                <div class="camera-controls flex justify-between items-center">
                    <div class="flex space-x-2">
                        <button onclick="openSettings(1)" class="p-2 bg-black bg-opacity-60 rounded-full text-white hover:bg-gray-800">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="feed_container_2" class="absolute border-2 border-gray-600 rounded-lg overflow-hidden transition-all duration-300 bg-[#1a1a1a]">
            <div class="w-full h-full relative video-container">
                <video id="remoteVideo2" autoplay playsinline class="w-full h-full bg-black"></video>
                <div id="camera_off_message_2" class="hidden absolute inset-0 flex items-center justify-center bg-black bg-opacity-70">
                    <div class="text-center">
                        <i class="fas fa-video-slash text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-400">Camera turned off</p>
                    </div>
                </div>
                <div id="mic_status_2" class="hidden absolute bottom-4 left-4 bg-black bg-opacity-50 rounded p-1">
                    <i class="fas fa-microphone-slash text-red-500"></i>
                </div>
                <div class="absolute top-0 left-0 right-0 p-4 flex justify-between items-center">
                    <div id="camera_timestamp_2" class="text-sm text-gray-300">--:--:--</div>
                    <div id="camera_number_2" class="text-md text-white px-2 py-1 bg-black bg-opacity-50 rounded">Camera 2</div>
                </div>
            </div>
        </div>
        
        <div id="feed_container_3" class="absolute border-2 border-gray-600 rounded-lg overflow-hidden transition-all duration-300 bg-[#1a1a1a]">
            <div class="w-full h-full relative video-container">
                <video id="remoteVideo3" autoplay playsinline class="w-full h-full bg-black"></video>
                <div id="camera_off_message_3" class="hidden absolute inset-0 flex items-center justify-center bg-black bg-opacity-70">
                    <div class="text-center">
                        <i class="fas fa-video-slash text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-400">Camera turned off</p>
                    </div>
                </div>
                <div id="mic_status_3" class="hidden absolute bottom-4 left-4 bg-black bg-opacity-50 rounded p-1">
                    <i class="fas fa-microphone-slash text-red-500"></i>
                </div>
                <div class="absolute top-0 left-0 right-0 p-4 flex justify-between items-center">
                    <div id="camera_timestamp_3" class="text-sm text-gray-300">--:--:--</div>
                    <div id="camera_number_3" class="text-md text-white px-2 py-1 bg-black bg-opacity-50 rounded">Camera 3</div>
                </div>
            </div>
        </div>
        
        <div id="feed_container_4" class="absolute border-2 border-gray-600 rounded-lg overflow-hidden transition-all duration-300 bg-[#1a1a1a]">
            <div class="w-full h-full relative video-container">
                <video id="remoteVideo4" autoplay playsinline class="w-full h-full bg-black"></video>
                <div id="camera_off_message_4" class="hidden absolute inset-0 flex items-center justify-center bg-black bg-opacity-70">
                    <div class="text-center">
                        <i class="fas fa-video-slash text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-400">Camera turned off</p>
                    </div>
                </div>
                <div id="mic_status_4" class="hidden absolute bottom-4 left-4 bg-black bg-opacity-50 rounded p-1">
                    <i class="fas fa-microphone-slash text-red-500"></i>
                </div>
                <div class="absolute top-0 left-0 right-0 p-4 flex justify-between items-center">
                    <div id="camera_timestamp_4" class="text-sm text-gray-300">--:--:--</div>
                    <div id="camera_number_4" class="text-md text-white px-2 py-1 bg-black bg-opacity-50 rounded">Camera 4</div>
                </div>
            </div>
        </div>
        
        <!-- Back to grid button (visible in focus mode) -->
        <button id="back_to_grid_button" class="hidden fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-full shadow-lg z-20">
            <i class="fas fa-th"></i>
        </button>
    </div>
</div>

<!-- Control Bar -->
<div class="fixed bottom-0 left-0 right-0 z-20 bg-gradient-to-t from-[#1a1a1a] to-transparent pt-10 pb-4">
    <div class="container mx-auto px-4 flex justify-center items-center space-x-4">
        <button id="session_info_btn" class="control-button bg-[#404040] text-white hover:bg-[#505050] hover:text-[#ff6600]">
            <i class="fas fa-key"></i>
        </button>
        <button id="microphone_button" class="control-button bg-[#404040] text-white hover:bg-[#505050] hover:text-[#ff6600]">
            <i class="fas fa-microphone"></i>
        </button>
        <button id="volume_button" class="control-button bg-[#404040] text-white hover:bg-[#505050] hover:text-[#ff6600]">
            <i class="fas fa-volume-up"></i>
        </button>
        <button id="view_toggle" class="control-button bg-[#404040] text-white hover:bg-[#505050] hover:text-[#ff6600]">
            <i class="fas fa-th-large"></i>
        </button>
        <button id="end_session_button" class="control-button bg-red-600 text-white hover:bg-red-700">
            <i class="fas fa-phone-slash"></i>
        </button>
    </div>
</div>

<!-- Session Info Panel -->
<div id="sessionInfoPanel" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-95 text-white p-6 rounded-lg shadow-lg z-50 w-80 hidden">
    <div class="flex flex-col items-center justify-center">
        <div class="bg-[#ff6600] text-white p-3 rounded-full mb-4">
            <i class="fas fa-broadcast-tower text-2xl"></i>
        </div>
        <h2 class="text-xl font-bold mb-4">Session Active</h2>
        <div class="bg-gray-800 p-4 rounded-lg mb-4 w-full text-center">
            <p class="text-sm text-gray-400 mb-1">Share this code with camera users</p>
            <div class="flex items-center justify-center space-x-2">
                <p class="text-2xl font-mono tracking-wider" id="sessionPasskeyDisplay"><?= $passkey ?? 'Loading...' ?></p>
                <button id="refreshPasskeyBtn" class="text-gray-400 hover:text-white p-1">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
        
        <div class="flex flex-col w-full space-y-3">
            <button id="copySessionBtn" class="bg-[#ff6600] hover:bg-[#ff8533] text-white py-2 px-4 rounded-lg flex items-center w-full justify-center">
                <i class="fas fa-copy mr-2"></i> Copy Session Code
            </button>
            
            <button id="qrCodeBtn" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg flex items-center w-full justify-center">
                <i class="fas fa-qrcode mr-2"></i> Show QR Code
            </button>
            
            <button id="closeInfoPanelBtn" class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-lg w-full">
                <i class="fas fa-times mr-2"></i> Close
            </button>
        </div>
    </div>
</div>

<!-- Join Request Dialog -->
<div id="joinRequestDialog" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-90 text-white p-6 rounded-lg shadow-lg z-50 w-96 hidden">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Join Requests</h2>
        <button id="closeJoinRequestBtn" class="text-gray-400 hover:text-white">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div id="requestsContainer" class="max-h-80 overflow-y-auto">
        <!-- Join requests will be added here dynamically -->
    </div>
    
    <div class="mt-4 pt-3 border-t border-gray-700">
        <label class="flex items-center text-sm">
            <input type="checkbox" id="ignoreCheckbox" class="mr-2 rounded">
            Ignore future join requests
        </label>
    </div>
</div>

<!-- Participant List Dialog -->
<div id="participantListDialog" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-90 text-white p-6 rounded-lg shadow-lg z-50 w-96 hidden">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Connected Participants</h2>
        <button class="text-gray-400 hover:text-white" id="closeParticipantListBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div id="participantsList" class="max-h-80 overflow-y-auto">
        <!-- Participants will be added here dynamically -->
    </div>
    
    <button id="closeParticipantListBtnBottom" class="mt-4 bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg w-full">
        Close
    </button>
</div>

<!-- Camera Settings Modal -->
<div id="cameraSettingsModal" class="hidden fixed w-full h-full bg-black bg-opacity-70 z-50">
    <div class="flex flex-grow justify-center items-center h-full">
        <div class="flex flex-col bg-gray-800 rounded-lg shadow-lg p-4 w-80 max-w-md">
            <div class="w-full flex flex-row justify-between items-center">
                <h5 class="text-xl text-gray-200 font-semibold">Camera Settings</h5>
                <button class="w-auto h-auto text-gray-100 p-2 hover:bg-gray-600 hover:text-orange-500 hover:rounded-full" id="closeSettingsBtn">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <hr class="w-full border-gray-500 my-3">
            <div class="w-full h-auto">
                <div class="mt-3">
                    <label for="zoomSlider" class="text-gray-300" id="zoomValueLabel">Zoom: N/A</label>
                    <input type="range" class="w-full bg-gray-700" id="zoomSlider" min="1" max="3" step="0.1" value="1" disabled>
                </div>
                
                <div class="mt-4">
                    <label class="text-gray-300 block mb-2">Camera Info</label>
                    <div class="bg-gray-700 p-3 rounded">
                        <p class="text-gray-400 text-sm" id="cameraDeviceInfo">No camera connected</p>
                    </div>
                </div>
                
                <div class="mt-4 pt-3 border-t border-gray-700">
                    <button id="disconnectCameraBtn" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded w-full disabled:opacity-50 disabled:cursor-not-allowed">
                        Disconnect Camera
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Updated styling for improved visual design */
    :root {
        --primary-color: #ff6600; /* HelioCam orange */
        --primary-hover: #ff8533;
        --dark-bg: #1a1a1a;
        --dark-secondary: #2a2a2a;
        --dark-tertiary: #404040;
    }
    
    /* Improved feed container styles */
    .feed-container-connected {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 8px rgba(255, 102, 0, 0.3);
    }
    
    /* Control button styling */
    .control-button {
        transition: all 0.2s ease;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .control-button:hover {
        transform: scale(1.1);
    }
    
    .control-button:active {
        transform: scale(0.95);
    }
    
    /* Improved toast */
    .toast-notification {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        border-radius: 6px;
    }
    
    /* Camera controls overlay */
    .camera-controls {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
        padding: 30px 15px 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .video-container:hover .camera-controls {
        opacity: 1;
    }
    
    /* Pulsing record button */
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(255, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0); }
    }
    
    .pulse-red {
        animation: pulse-red 2s infinite;
    }
    
    /* Improved focus mode indicator */
    .focus-mode-indicator {
        position: fixed;
        top: 70px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        z-index: 30;
    }
    
    /* Base styles */
    html, body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        height: 100%;
        width: 100%;
        background-color: #1a1a1a;
    }
    
    /* Video styling */
    video {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #000;
        transition: transform 0.2s ease-out;
    }
    
    /* Toast notification */
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 16px;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        border-radius: 4px;
        z-index: 1000;
        display: flex;
        align-items: center;
        font-size: 14px;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s, transform 0.3s;
    }
    
    .toast-notification.show {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Focus mode transition */
    .camera-feed-focusing {
        transition: all 0.3s ease-in-out;
    }
    
    /* Join request item */
    .join-request-item {
        background-color: #2a2a2a;
        border-radius: 8px;
        margin-bottom: 8px;
        padding: 12px;
    }
    
    .join-request-item:last-child {
        margin-bottom: 0;
    }

    /* Grid layout spacing */
    #feed_container_1, #feed_container_2, #feed_container_3, #feed_container_4 {
        margin: 4px;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    /* Adjust the grid container to account for margins */
    #grid_layout {
        padding: 4px;
        box-sizing: border-box;
    }
</style>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    let focusedCamera = -1; // -1 means no focus (grid view)
    const cameras = {
        1: { connected: false, zoom: 1.0, info: null, cameraOff: false, micOff: false },
        2: { connected: false, zoom: 1.0, info: null, cameraOff: false, micOff: false },
        3: { connected: false, zoom: 1.0, info: null, cameraOff: false, micOff: false },
        4: { connected: false, zoom: 1.0, info: null, cameraOff: false, micOff: false }
    };
    let selectedCameraId = 1;
    let activeCamerasCount = 0;
    let totalConnectedCameras = 0;
    let isFullscreen = false; // Tracks browser fullscreen state
    let sessionPasskey = '<?= $passkey ?? "UNKNWN" ?>';
    let isMuted = false; // For the main volume/mute button
    
    // Get session name and set title
    const urlParams = new URLSearchParams(window.location.search);
    const sessionName = urlParams.get('session_name') || 'HelioCam Session';
    document.getElementById('session_title').textContent = sessionName;
    
    // Set up the camera grid initially
    updateGridLayout(0);
    
    // Set up event listeners
    document.getElementById('session_info_btn').addEventListener('click', toggleSessionInfoPanel);
    document.getElementById('closeInfoPanelBtn').addEventListener('click', hideSessionInfoPanel);
    document.getElementById('copySessionBtn').addEventListener('click', copySessionPasskey);
    document.getElementById('view_toggle').addEventListener('click', toggleView);
    document.getElementById('back_to_grid_button').addEventListener('click', exitFocusMode);
    document.getElementById('participants_count').addEventListener('click', showParticipantListDialog);
    document.getElementById('closeParticipantListBtn').addEventListener('click', hideParticipantListDialog);
    document.getElementById('closeParticipantListBtnBottom').addEventListener('click', hideParticipantListDialog);
    document.getElementById('microphone_button').addEventListener('click', toggleAudio);
    document.getElementById('join_request_notification').addEventListener('click', showJoinRequestDialog);
    document.getElementById('closeJoinRequestBtn').addEventListener('click', hideJoinRequestDialog);
    document.getElementById('closeSettingsBtn').addEventListener('click', closeSettings);
    document.getElementById('disconnectCameraBtn').addEventListener('click', disconnectSelectedCamera);
    document.getElementById('volume_button').addEventListener('click', toggleVolume);
    
    // --- Fullscreen Helper Functions ---
    function enterBrowserFullscreen() {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen().catch(err => console.error(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`));
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.mozRequestFullScreen) { /* Firefox */
            elem.mozRequestFullScreen();
        } else if (elem.msRequestFullscreen) { /* IE/Edge */
            elem.msRequestFullscreen();
        }
    }

    function exitBrowserFullscreen() {
        if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
            if (document.exitFullscreen) {
                document.exitFullscreen().catch(err => console.error(`Error attempting to disable full-screen mode: ${err.message} (${err.name})`));
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) { /* Firefox */
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) { /* IE/Edge */
                document.msExitFullscreen();
            }
        }
    }
    // --- End Fullscreen Helper Functions ---

    // --- Re-added End Session Button Logic ---
    document.getElementById('end_session_button').addEventListener('click', function() {
        const confirmDialog = document.createElement('div');
        confirmDialog.className = 'fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50';
        confirmDialog.innerHTML = `
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm mx-auto">
                <h3 class="text-xl font-bold mb-4 text-white">End Session</h3>
                <p class="text-gray-300 mb-6">Are you sure you want to end this session? All connections will be terminated.</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelEndSession" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                        Cancel
                    </button>
                    <button id="confirmEndSession" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        End Session
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(confirmDialog);
        
        document.getElementById('cancelEndSession').onclick = () => {
            confirmDialog.remove();
        };
        
        document.getElementById('confirmEndSession').onclick = () => {
            if (window.endSession) { // This calls the function in host_stream.js
                window.endSession();
            } else {
                showToast('info', 'Ending session (fallback)...');
                setTimeout(() => {
                    window.location.href = "<?= site_url('/dashboard') ?>"; // Fallback redirect
                }, 1000);
            }
            confirmDialog.remove();
        };
    });
    // --- End of Re-added End Session Button Logic ---
    
    // Add settings button to each camera
    for (let i = 1; i <= 4; i++) {
        const container = document.getElementById(`feed_container_${i}`);
        const settingsBtn = document.createElement('button');
        settingsBtn.className = 'absolute bottom-4 right-4 p-2 bg-black bg-opacity-50 rounded-full text-white hover:bg-gray-800';
        settingsBtn.innerHTML = '<i class="fas fa-cog"></i>';
        settingsBtn.onclick = (e) => {
            e.stopPropagation(); // Prevent triggering container click (focus mode)
            openSettings(i);
        };
        container.querySelector('.video-container').appendChild(settingsBtn);
    }
    
    // Function to toggle audio mute
    function toggleAudio() {
        const micButton = document.getElementById('microphone_button');
        const isMuted = micButton.querySelector('i').classList.contains('fa-microphone-slash');
        
        if (isMuted) {
            micButton.querySelector('i').classList.remove('fa-microphone-slash');
            micButton.querySelector('i').classList.add('fa-microphone');
            // Call your WebRTC function to unmute
            if (window.unmuteMic) window.unmuteMic();
        } else {
            micButton.querySelector('i').classList.remove('fa-microphone');
            micButton.querySelector('i').classList.add('fa-microphone-slash');
            // Call your WebRTC function to mute
            if (window.muteMic) window.muteMic();
        }
    }
    
    // Function to update camera grid layout
    function updateGridLayout(cameraCount) {
        const grid = document.getElementById('grid_layout');
        const container1 = document.getElementById('feed_container_1');
        const container2 = document.getElementById('feed_container_2');
        const container3 = document.getElementById('feed_container_3');
        const container4 = document.getElementById('feed_container_4');
        const backButton = document.getElementById('back_to_grid_button');
        
        // Reset click handlers
        container1.onclick = null;
        container2.onclick = null;
        container3.onclick = null;
        container4.onclick = null;
        
        // First, handle focus mode
        if (focusedCamera !== -1) {
            // Hide all containers except the focused one
            [container1, container2, container3, container4].forEach((container, index) => {
                if (index === focusedCamera) {
                    container.style.top = '0';
                    container.style.left = '0';
                    container.style.width = '100%';
                    container.style.height = '100%';
                    container.style.zIndex = '10';
                    container.style.display = 'block';
                    // Add click handler to show hint but remain in focus mode
                    container.onclick = showFocusHint;
                } else {
                    container.style.display = 'none';
                }
            });
            
            // Show back button
            backButton.classList.remove('hidden');
            return;
        }
        
        // Hide back button in grid mode
        backButton.classList.add('hidden');
        
        // Set visibility based on camera count
        container1.style.display = cameraCount >= 1 ? 'block' : 'none';
        container2.style.display = cameraCount >= 2 ? 'block' : 'none';
        container3.style.display = cameraCount >= 3 ? 'block' : 'none';
        container4.style.display = cameraCount >= 4 ? 'block' : 'none';
        
        // Position containers based on camera count
        switch (cameraCount) {
            case 0:
            case 1:
                // Single camera centered
                container1.style.top = '0';
                container1.style.left = '0';
                container1.style.width = '100%';
                container1.style.height = '100%';
                container1.style.zIndex = '1';
                // Add click handler for focus mode
                container1.onclick = () => enterFocusMode(0);
                break;
            case 2:
                // Two cameras stacked vertically
                container1.style.top = '0';
                container1.style.left = '0';
                container1.style.width = '100%';
                container1.style.height = '50%';
                
                container2.style.top = '50%';
                container2.style.left = '0';
                container2.style.width = '100%';
                container2.style.height = '50%';
                
                // Add click handlers
                container1.onclick = () => enterFocusMode(0);
                container2.onclick = () => enterFocusMode(1);
                break;
            case 3:
                // L-shaped layout for 3 cameras (more balanced)
                container1.style.top = '0';
                container1.style.left = '0';
                container1.style.width = '50%';
                container1.style.height = '50%';
                container1.style.zIndex = '1';
                
                container2.style.top = '50%';
                container2.style.left = '0';
                container2.style.width = '50%';
                container2.style.height = '50%';
                container2.style.zIndex = '1';
                
                // Camera 3 takes full height on right side
                container3.style.top = '0';
                container3.style.left = '50%';
                container3.style.width = '50%';
                container3.style.height = '100%';
                container3.style.zIndex = '1';
                
                // Add click handlers
                container1.onclick = () => enterFocusMode(0);
                container2.onclick = () => enterFocusMode(1);
                container3.onclick = () => enterFocusMode(2);
                break;

            case 4:
                // 2x2 grid layout
                container1.style.top = '0';
                container1.style.left = '0';
                container1.style.width = '50%';
                container1.style.height = '50%';
                container1.style.zIndex = '1';
                
                container2.style.top = '0';
                container2.style.left = '50%';
                container2.style.width = '50%';
                container2.style.height = '50%';
                container2.style.zIndex = '1';
                
                container3.style.top = '50%';
                container3.style.left = '0';
                container3.style.width = '50%';
                container3.style.height = '50%';
                container3.style.zIndex = '1';
                
                container4.style.top = '50%';
                container4.style.left = '50%';
                container4.style.width = '50%';
                container4.style.height = '50%';
                container4.style.zIndex = '1';
                
                // Add click handlers
                container1.onclick = () => enterFocusMode(0);
                container2.onclick = () => enterFocusMode(1);
                container3.onclick = () => enterFocusMode(2);
                container4.onclick = () => enterFocusMode(3);
                break;
        }
        updateGridPositioning();
        updateCameraControlsPosition();
    }
    
    function enterFocusMode(cameraIndex) {
        focusedCamera = cameraIndex;
        updateGridLayout(activeCamerasCount);
        
        let indicator = document.getElementById('focus_mode_indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'focus_mode_indicator';
            indicator.className = 'focus-mode-indicator';
            document.body.appendChild(indicator);
        }
        indicator.innerHTML = `<i class="fas fa-eye mr-2"></i> Camera ${cameraIndex + 1} Focused`; // Changed icon for focus
        updateViewToggleIcon();
    }
    
    function exitFocusMode() {
        focusedCamera = -1;
        updateGridLayout(activeCamerasCount);
        const indicator = document.getElementById('focus_mode_indicator');
        if (indicator) indicator.remove();
        updateViewToggleIcon();
    }
    
    function showFocusHint() {
        // Optional: show a visual hint that the user is in focus mode
        const overlay = document.createElement('div');
        overlay.className = 'absolute inset-0 bg-white bg-opacity-20 z-20 pointer-events-none';
        
        const currentContainer = document.getElementById(`feed_container_${focusedCamera + 1}`);
        currentContainer.appendChild(overlay);
        
        // Fade out and remove
        setTimeout(() => {
            overlay.style.opacity = '0';
            overlay.style.transition = 'opacity 300ms';
            setTimeout(() => overlay.remove(), 300);
        }, 100);
    }
    
    function updateAllTimestamps() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        
        for (let i = 1; i <= 4; i++) {
            const timestampElement = document.getElementById(`camera_timestamp_${i}`);
            if (timestampElement) {
                timestampElement.textContent = timeString;
            }
        }
    }
    
    function toggleView() {
        if (focusedCamera !== -1) { // Currently in focus mode, so exit to grid
            exitFocusMode(); // Handles visual layout change first
            if (isFullscreen) { // If browser is fullscreen, attempt to exit it
                exitBrowserFullscreen();
            }
            // Actual isFullscreen state update will be handled by the 'fullscreenchange' event listener
        } else { // Currently in grid mode, so enter focus & fullscreen
            let firstActiveCameraIndex = -1;
            for (let i = 0; i < 4; i++) {
                if (cameras[i+1].connected) {
                    firstActiveCameraIndex = i;
                    break;
                }
            }
            if (firstActiveCameraIndex !== -1) {
                enterFocusMode(firstActiveCameraIndex); // Handles visual layout change first
                enterBrowserFullscreen();
                // Actual isFullscreen state update will be handled by the 'fullscreenchange' event listener
            } else {
                showToast('info', 'No active cameras to focus on.');
            }
        }
        // updateViewToggleIcon() is called by enterFocusMode/exitFocusMode and handleFullscreenChange
    }
    
    function updateViewToggleIcon() {
        const viewToggleBtn = document.getElementById('view_toggle');
        if (!viewToggleBtn) return;

        // The icon should primarily reflect ability to enter/exit focus+fullscreen combo
        if (focusedCamera !== -1 || isFullscreen) { 
            viewToggleBtn.innerHTML = '<i class="fas fa-compress-arrows-alt"></i>'; 
            viewToggleBtn.title = 'Exit Fullscreen & Focus Mode';
        } else { 
            viewToggleBtn.innerHTML = '<i class="fas fa-expand-arrows-alt"></i>'; 
            viewToggleBtn.title = 'Enter Fullscreen & Focus Mode';
        }
    }
    
    function showEndSessionConfirmation() {
        const confirmDialog = document.createElement('div');
        confirmDialog.className = 'fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50';
        confirmDialog.innerHTML = `
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm mx-auto">
                <h3 class="text-xl font-bold mb-4 text-white">End Session</h3>
                <p class="text-gray-300 mb-6">Are you sure you want to end this session? All connections will be terminated.</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelEndSession" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                        Cancel
                    </button>
                    <button id="confirmEndSession" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        End Session
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(confirmDialog);
        
        document.getElementById('cancelEndSession').onclick = () => {
            confirmDialog.remove();
        };
        
        document.getElementById('confirmEndSession').onclick = () => {
            endSession();
            confirmDialog.remove();
        };
    }
    
    function endSession() {
        // Make API call to end the session
        showToast('info', 'Ending session...');
        
        // Navigate back after a brief delay
        setTimeout(() => {
            window.location.href = "<?= site_url('/dashboard') ?>";
        }, 1000);
    }
    
    function toggleSessionInfoPanel() {
        const panel = document.getElementById('sessionInfoPanel');
        
        // If panel is hidden, show it with animation for the passkey
        if (panel.classList.contains('hidden')) {
            // First show the panel
            panel.classList.remove('hidden');
            
            // Add entrance animation
            panel.style.opacity = '0';
            panel.style.transform = 'scale(0.9)';
            
            setTimeout(() => {
                panel.style.opacity = '1';
                panel.style.transform = 'scale(1)';
                panel.style.transition = 'all 0.3s ease';
                
                // Now highlight the passkey
                const passkeyDisplay = document.getElementById('sessionPasskeyDisplay');
                if (passkeyDisplay) {
                    // Save original styling
                    const originalStyle = {
                        background: passkeyDisplay.style.background,
                        color: passkeyDisplay.style.color,
                        padding: passkeyDisplay.style.padding,
                        transform: passkeyDisplay.style.transform
                    };
                    
                    // Apply highlight styling
                    passkeyDisplay.style.background = '#ff6600';
                    passkeyDisplay.style.color = 'white';
                    passkeyDisplay.style.padding = '6px 12px';
                    passkeyDisplay.style.borderRadius = '4px';
                    passkeyDisplay.style.transform = 'scale(1.1)';
                    passkeyDisplay.style.transition = 'all 0.3s ease';
                    
                    // Add pulsing effect
                    const pulseAnimation = document.createElement('style');
                    pulseAnimation.innerHTML = `
                        @keyframes passkey-pulse {
                            0% { box-shadow: 0 0 0 0 rgba(255, 102, 0, 0.7); }
                            70% { box-shadow: 0 0 0 10px rgba(255, 102, 0, 0); }
                            100% { box-shadow: 0 0 0 0 rgba(255, 102, 0, 0); }
                        }
                    `;
                    document.head.appendChild(pulseAnimation);
                    passkeyDisplay.style.animation = 'passkey-pulse 1.5s ease-in-out 2';
                    
                    // Return to normal styling after the animation
                    setTimeout(() => {
                        passkeyDisplay.style.background = '#333';
                        passkeyDisplay.style.color = 'white';
                        passkeyDisplay.style.transform = 'scale(1)';
                    }, 3000);
                }
            }, 10);
        } else {
            // Hide with animation
            panel.style.opacity = '0';
            panel.style.transform = 'scale(0.9)';
            panel.style.transition = 'all 0.2s ease';
            
            setTimeout(() => {
                panel.classList.add('hidden');
            }, 200);
        }
    }
    
    function hideSessionInfoPanel() {
        document.getElementById('sessionInfoPanel').classList.add('hidden');
    }
    
    function copySessionPasskey() {
        // Get passkey from the display element
        const passkeyDisplay = document.getElementById('sessionPasskeyDisplay');
        if (passkeyDisplay) {
            const passkey = passkeyDisplay.textContent.trim();
            if (passkey && passkey !== 'Loading...' && passkey !== 'UNKNWN') {
                // Copy passkey to clipboard
                const tempInput = document.createElement('input');
                tempInput.value = passkey;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                
                showToast('success', 'Session code copied to clipboard');
            } else {
                showToast('error', 'Session code not available for copying');
            }
        }
    }
    
    function openSettings(cameraId) {
        selectedCameraId = cameraId;

        // Update zoom slider value - adjust to show zoom is not available
        const zoomValueLabel = document.getElementById('zoomValueLabel');
        const zoomSlider = document.getElementById('zoomSlider');
        if (zoomValueLabel) zoomValueLabel.textContent = "Zoom: N/A";
        if (zoomSlider) zoomSlider.disabled = true;

        // Update camera info
        const infoElement = document.getElementById('cameraDeviceInfo');
        const disconnectBtn = document.getElementById('disconnectCameraBtn');
        
        if (cameras[cameraId].connected) {
            infoElement.textContent = cameras[cameraId].info || 'Unknown device';
            disconnectBtn.disabled = false;
        } else {
            infoElement.textContent = 'No camera connected';
            disconnectBtn.disabled = true;
        }
        
        // Show the modal
        document.getElementById('cameraSettingsModal').classList.remove('hidden');
    }
    
    function closeSettings() {
        document.getElementById('cameraSettingsModal').classList.add('hidden');
    }
    
    function disconnectSelectedCamera() {
        if (cameras[selectedCameraId].connected) {
            // This function should trigger the WebRTC module to disconnect the camera
            if (window.disconnectCamera) {
                window.disconnectCamera(selectedCameraId);
            }
            closeSettings();
        }
    }
    
    function showJoinRequestDialog() {
        document.getElementById('joinRequestDialog').classList.remove('hidden');
        
        // Show actual pending requests
        const requestsContainer = document.getElementById('requestsContainer');
        requestsContainer.innerHTML = ''; // Clear existing content
        
        console.log("Showing join requests dialog, pending requests:", window.getPendingRequests());
        
        // Get pending requests from host_stream.js
        if (window.getPendingRequests) {
            const pendingRequests = window.getPendingRequests();
            if (pendingRequests.length === 0) {
                requestsContainer.innerHTML = '<div class="text-center p-4 text-gray-400">No pending requests</div>';
            } else {
                pendingRequests.forEach(request => {
                    console.log("Adding request to UI:", request);
                    // Now pass device name as well
                    addJoinRequest(request.email, request.id, request.deviceName || 'Unknown Device');
                });
            }
        } else {
            console.error("window.getPendingRequests is not defined");
            requestsContainer.innerHTML = '<div class="text-center p-4 text-gray-400">Error loading requests</div>';
        }
    }
    
    function hideJoinRequestDialog() {
        document.getElementById('joinRequestDialog').classList.add('hidden');
    }
    
    function addJoinRequest(email, requestId, deviceName = 'Unknown Device') {
        const requestsContainer = document.getElementById('requestsContainer');
        
        const requestItem = document.createElement('div');
        requestItem.className = 'join-request-item flex flex-col';
        
        requestItem.innerHTML = `
            <div class="flex items-center mb-2">
                <i class="fas fa-user-circle text-gray-400 text-2xl mr-3"></i>
                <div class="flex-grow">
                    <span class="text-sm font-medium block">${email}</span>
                    <span class="text-xs text-gray-400 block">${deviceName}</span>
                </div>
            </div>
            <div class="flex space-x-2">
                <button class="accept-btn flex-grow bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded text-sm">
                    <i class="fas fa-check mr-1"></i> Accept
                </button>
                <button class="reject-btn flex-grow bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                    <i class="fas fa-times mr-1"></i> Reject
                </button>
            </div>
        `;
        
        // Add event listeners
        requestItem.querySelector('.accept-btn').addEventListener('click', () => {
            acceptJoinRequest(requestId, email, deviceName);
            requestItem.remove();
        });
        
        requestItem.querySelector('.reject-btn').addEventListener('click', () => {
            rejectJoinRequest(requestId);
            requestItem.remove();
        });
        
        requestsContainer.appendChild(requestItem);
    }
    
    function acceptJoinRequest(requestId, email, deviceName = 'Unknown Device') {
        // Call the WebRTC function to accept join request
        if (window.acceptJoinRequest) {
            window.acceptJoinRequest(requestId, email, deviceName);
        }
        
        // Update UI (will be handled by the callback when camera connects)
        showToast('success', `Accepted join request from ${email} (${deviceName})`);
    }
    
    function rejectJoinRequest(requestId) {
        // Call API to reject join request
        showToast('info', 'Request rejected');
    }
    
    function showParticipantListDialog() {
        document.getElementById('participantListDialog').classList.remove('hidden');
        
        // Populate participant list
        const participantsList = document.getElementById('participantsList');
        participantsList.innerHTML = ''; // Clear existing content
        
        // Get active joiners from host_stream.js
        let activeJoiners = [];
        if (window.getActiveJoiners) {
            activeJoiners = window.getActiveJoiners();
        }
        
        // Show connected cameras with more details
        Object.entries(cameras).forEach(([id, data]) => {
            if (data.connected) {
                // Find the joiner details for this camera
                const joiner = activeJoiners.find(j => j.cameraNumber === parseInt(id));
                const deviceName = joiner ? joiner.deviceName : 'Unknown Device';
                const userEmail = joiner ? joiner.email : '';
                
                const participantItem = document.createElement('div');
                participantItem.className = 'flex items-center p-3 border-b border-gray-700 hover:bg-gray-800 rounded-lg mb-1';
                participantItem.innerHTML = `
                    <div class="mr-3 ${data.cameraOff ? 'text-red-500' : 'text-green-500'} text-xl">
                        <i class="fas ${data.cameraOff ? 'fa-video-slash' : 'fa-video'}"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="text-sm font-semibold flex items-center">
                            <span>Camera ${id}</span>
                            <span class="ml-2 px-2 py-0.5 bg-orange-600 text-xs rounded-full">Active</span>
                        </div>
                        <div class="text-xs text-gray-400">${data.info || deviceName}</div>
                        ${userEmail ? `<div class="text-xs text-gray-400"><i class="fas fa-user mr-1"></i> ${userEmail}</div>` : ''}
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="text-gray-400">
                            <i class="fas ${data.micOff ? 'fa-microphone-slash' : 'fa-microphone'}"></i>
                        </div>
                        <button onclick="openSettings(${id})" class="text-xs px-2 py-1 bg-gray-700 hover:bg-gray-600 rounded">
                            Settings
                        </button>
                    </div>
                `;
                participantsList.appendChild(participantItem);
            }
        });
        
        // If no participants
        if (participantsList.children.length === 0) {
            const emptyMessage = document.createElement('div');
            emptyMessage.className = 'flex flex-col items-center justify-center p-8 text-gray-400';
            emptyMessage.innerHTML = `
                <i class="fas fa-video-slash text-4xl mb-3"></i>
                <p>No cameras connected</p>
                <p class="text-xs mt-2">Share the session code to allow cameras to join</p>
            `;
            participantsList.appendChild(emptyMessage);
        }
    }
    
    function hideParticipantListDialog() {
        document.getElementById('participantListDialog').classList.add('hidden');
    }
    
    function updateParticipantCount() {
        document.getElementById('activeCamerasCount').textContent = activeCamerasCount;
        document.getElementById('totalCamerasCount').textContent = totalConnectedCameras;
    }
    
    function showToast(type, message) {
        // Remove any existing toasts
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Create new toast
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        
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
    
    // Expose global functions for external scripts to use
    window.onCameraConnected = function(cameraId, deviceInfo) {
        cameras[cameraId].connected = true;
        cameras[cameraId].info = deviceInfo || 'Unknown device';
        totalConnectedCameras++;
        activeCamerasCount++;
        
        // Show the camera feed with enhanced styling
        const container = document.getElementById(`feed_container_${cameraId}`);
        container.classList.add('connected');
        container.classList.add('feed-container-connected');
        
        // Add a connection animation
        const overlay = document.createElement('div');
        overlay.className = 'absolute inset-0 bg-[#ff6600] bg-opacity-30 z-10 pointer-events-none';
        container.appendChild(overlay);
        
        // Fade out the connection animation
        setTimeout(() => {
            overlay.style.opacity = '0';
            overlay.style.transition = 'opacity 1s ease';
            setTimeout(() => overlay.remove(), 1000);
        }, 500);
        
        // Update UI
        updateParticipantCount();
        updateGridLayout(activeCamerasCount);
        
        showToast('success', `Camera ${cameraId} connected`);
    };
    
    window.onCameraDisconnected = function(cameraId) {
        if (cameras[cameraId].connected) {
            cameras[cameraId].connected = false;
            totalConnectedCameras--;
            activeCamerasCount--;
            
            // Update UI
            document.getElementById(`feed_container_${cameraId}`).classList.remove('connected');
            updateParticipantCount();
            updateGridLayout(activeCamerasCount);
            
            showToast('warning', `Camera ${cameraId} disconnected`);
        }
    };
    
    window.onCameraStatusChange = function(cameraId, isCameraOff, isMicOff) {
        cameras[cameraId].cameraOff = isCameraOff;
        cameras[cameraId].micOff = isMicOff;
        
        // Update camera off message visibility
        document.getElementById(`camera_off_message_${cameraId}`).classList.toggle('hidden', !isCameraOff);
        
        // Update mic status visibility
        document.getElementById(`mic_status_${cameraId}`).classList.toggle('hidden', !isMicOff);
    };
    
    window.onJoinRequest = function(requestId, email, deviceName = 'Unknown Device') {
        // Update notification badge
        const notification = document.getElementById('join_request_notification');
        notification.classList.remove('hidden');
        
        const countElement = document.getElementById('notification_count');
        countElement.textContent = parseInt(countElement.textContent || '0') + 1;
        
        // If dialog is open, add the request
        if (!document.getElementById('joinRequestDialog').classList.contains('hidden')) {
            addJoinRequest(email, requestId, deviceName);
        }
        
        showToast('info', `Join request from ${email} (${deviceName})`);
    };
    
    // Add QR code generation for session code
    document.getElementById('qrCodeBtn').addEventListener('click', showQRCode);
    
    function showQRCode() {
        const passkey = document.getElementById('sessionPasskeyDisplay').textContent.trim();
        if (!passkey || passkey === 'Loading...' || passkey === 'UNKNWN') {
            showToast('error', 'Session code not available for QR generation');
            return;
        }
        
        // Create QR code modal
        const qrModal = document.createElement('div');
        qrModal.className = 'fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50';
        qrModal.innerHTML = `
            <div class="bg-white p-6 rounded-lg max-w-sm mx-auto text-center">
                <h3 class="text-gray-800 text-xl font-bold mb-4">Session QR Code</h3>
                <div class="qr-code-container bg-white p-4 mb-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(passkey)}" 
                         alt="Session QR Code" class="mx-auto">
                </div>
                <p class="text-gray-600 mb-4">Scan with a mobile device to join this session</p>
                <button id="closeQrBtn" class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-lg w-full">
                    Close
                </button>
            </div>
        `;
        
        document.body.appendChild(qrModal);
        
        // Close button functionality
        document.getElementById('closeQrBtn').onclick = () => {
            qrModal.remove();
        };
    }
    
    // Apply the enhanced connection styles to already connected cameras
    Object.entries(cameras).forEach(([id, data]) => {
        if (data.connected) {
            document.getElementById(`feed_container_${id}`).classList.add('feed-container-connected');
        }
    });
    
    // Initialize the view toggle button with the correct icon
    updateViewToggleIcon();
    
    function updateGridPositioning() {
        // Get the actual width and height of the grid
        const gridWidth = document.getElementById('grid_layout').offsetWidth - 16; // Account for 8px margins
        const gridHeight = document.getElementById('grid_layout').offsetHeight - 16;
        
        const container1 = document.getElementById('feed_container_1');
        const container2 = document.getElementById('feed_container_2');
        const container3 = document.getElementById('feed_container_3');
        const container4 = document.getElementById('feed_container_4');
        
        switch (activeCamerasCount) {
            case 1:
                container1.style.width = `calc(100% - 8px)`;
                container1.style.height = `calc(100% - 8px)`;
                break;
            case 2:
                container1.style.width = `calc(100% - 8px)`;
                container1.style.height = `calc(50% - 8px)`;
                
                container2.style.width = `calc(100% - 8px)`;
                container2.style.height = `calc(50% - 8px)`;
                break;
            case 3:
                container1.style.width = `calc(50% - 8px)`;
                container1.style.height = `calc(50% - 8px)`;
                
                container2.style.width = `calc(50% - 8px)`;
                container2.style.height = `calc(50% - 8px)`;
                
                container3.style.width = `calc(50% - 8px)`;
                container3.style.height = `calc(100% - 8px)`;
                break;
            case 4:
                container1.style.width = `calc(50% - 8px)`;
                container1.style.height = `calc(50% - 8px)`;
                
                container2.style.width = `calc(50% - 8px)`;
                container2.style.height = `calc(50% - 8px)`;
                
                container3.style.width = `calc(50% - 8px)`;
                container3.style.height = `calc(50% - 8px)`;
                
                container4.style.width = `calc(50% - 8px)`;
                container4.style.height = `calc(50% - 8px)`;
                break;
        }
        
        // Call this function whenever the window is resized
        window.addEventListener('resize', updateGridPositioning);
    }

    function updateCameraControlsPosition() {
        // For each camera container, adjust the control positions based on the current layout
        for (let i = 1; i <= 4; i++) {
            const container = document.getElementById(`feed_container_${i}`);
            if (!container) continue;
            
            // Get container dimensions
            const width = container.offsetWidth;
            const height = container.offsetHeight;
            
            // Adjust controls based on dimensions - this helps with responsive layouts
            if (width < 300 || height < 200) {
                // Smaller container - optimize control layout
                const zoomControls = container.querySelectorAll('.camera-controls button');
                zoomControls.forEach(btn => {
                    btn.classList.add('p-1');
                    btn.classList.remove('p-2');
                });
            } else {
                // Larger container - standard layout
                const zoomControls = container.querySelectorAll('.camera-controls button');
                zoomControls.forEach(btn => {
                    btn.classList.add('p-2');
                    btn.classList.remove('p-1');
                });
            }
        }
    }

    // Add this at the end of the DOMContentLoaded event handler (around line 1050)

    // Handle window resize events to adjust layout
    window.addEventListener('resize', function() {
        updateGridLayout(activeCamerasCount);
        updateCameraControlsPosition();
    });

    // Initial setup
    updateGridLayout(activeCamerasCount);
    updateCameraControlsPosition();

    // Set up a timer to update timestamps every second
    setInterval(updateAllTimestamps, 1000);

    // Initial timestamp update
    updateAllTimestamps();

    // --- Start of Corrected Session Info Panel Logic ---
    const sessionInfoBtn = document.getElementById('session_info_btn');
    const closeInfoPanelBtn = document.getElementById('closeInfoPanelBtn');
    const sessionInfoPanel = document.getElementById('sessionInfoPanel');

    if (sessionInfoBtn && closeInfoPanelBtn && sessionInfoPanel) {
        sessionInfoBtn.addEventListener('click', function() {
            sessionInfoPanel.classList.remove('hidden');
            // Ensure panel is styled to be visible (Tailwind's 'hidden' usually sets display:none)
            // The following direct style changes are for robustness if class toggling is not enough
            sessionInfoPanel.style.display = 'block'; // Or 'flex' depending on its layout
            sessionInfoPanel.style.opacity = '1';
            sessionInfoPanel.style.transform = 'scale(1)';
            
            const passkeyDisplay = document.getElementById('sessionPasskeyDisplay');
            if (passkeyDisplay) {
                passkeyDisplay.style.backgroundColor = '#ff6600';
                passkeyDisplay.style.color = 'white';
                passkeyDisplay.style.padding = '8px 12px';
                passkeyDisplay.style.borderRadius = '4px';
                passkeyDisplay.style.boxShadow = '0 0 10px rgba(255, 102, 0, 0.5)';
            }
        });

        closeInfoPanelBtn.addEventListener('click', function() {
            sessionInfoPanel.style.opacity = '0';
            sessionInfoPanel.style.transform = 'scale(0.95)';
            setTimeout(() => {
                sessionInfoPanel.classList.add('hidden');
                sessionInfoPanel.style.display = ''; // Reset display style if 'hidden' class handles it
            }, 200);
        });
    } else {
        console.error('Session info panel buttons or panel itself not found!');
    }
    // --- End of Corrected Session Info Panel Logic ---

    // Volume control (re-added)
    function toggleVolume() {
        const volumeButton = document.getElementById('volume_button');
        isMuted = !isMuted;
        
        if (isMuted) {
            volumeButton.querySelector('i').classList.remove('fa-volume-up');
            volumeButton.querySelector('i').classList.add('fa-volume-mute');
            for (let i = 1; i <= 4; i++) {
                const video = document.getElementById(`remoteVideo${i}`);
                if (video) video.muted = true;
            }
            showToast('info', 'All incoming audio muted');
        } else {
            volumeButton.querySelector('i').classList.remove('fa-volume-mute');
            volumeButton.querySelector('i').classList.add('fa-volume-up');
            for (let i = 1; i <= 4; i++) {
                const video = document.getElementById(`remoteVideo${i}`);
                if (video) video.muted = false;
            }
            showToast('info', 'All incoming audio unmuted');
        }
    }

}); // This closes the main DOMContentLoaded listener

// All other script tags and their content below this main script block should be removed
// if they solely deal with the session info panel, as it's now handled above.
</script>

<script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
<script type="module" src="<?= base_url('/assets/firebase_webrtc/host_stream.js'); ?>"></script>

</body>
</html>