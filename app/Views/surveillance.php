<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">
<head>
<title>Surveillance Session</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<!-- Main Content - Surveillance Session -->
<div class="flex flex-grow flex-col h-screen">
    <!-- Camera Grid -->
    <div class="grid grid-flow-row grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 h-full overflow-hidden" id="cameraGrid">
        <div class="bg-[#1a1a1a]
                    flex
                    flex-col
                    h-full
                    overflow-hidden
                    active:border-solid
                    active:border-4
                    active:border-orange-600
                    border-solid
                    border-2
                    border-gray-600
                    grid-rows-1"
             id="camera1Container">
            <div class="w-full relative h-full video-container">
                <video id="remoteVideo1" autoplay playsinline class="w-full h-full bg-black"></video>
                <div class="flex flex-col text-gray-500 absolute right-0 w-auto p-5 m-3 top-1/2 gap-4">
                    <button onclick="zoomIn(1)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                        <i class="fas fa-magnifying-glass-plus"></i>
                    </button>
                    <button onclick="zoomOut(1)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                        <i class="fas fa-magnifying-glass-minus"></i>
                    </button>
                </div>
                <div class="flex flex-row justify-between text-gray-500 absolute top-0 w-full p-5 m-3 items-center">
                    <div class="text-sm text-gray-300" id="timestamp1">--:--:--</div>
                    <div class="text-2x1">Camera 1</div>
                    <div>
                        <button onclick="exitSession(1)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full"><i class="fas fa-xmark"></i></button>
                    </div>
                </div>
                <div class="flex flex-row z-1 bottom-0 absolute w-full justify-center items-center p-5 gap-5 font-light">
                    <div>
                        <button class="border-none text-gray-500 text-3xl px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full" onclick="prevCamera(activeCamera)">
                            <i class="fas fa-angle-left"></i>
                        </button>
                    </div>
                    <div class="flex justify-center items-center">
                        <i class="text-gray-500 text-2x1 fas fa-ellipsis"></i>
                    </div>
                    <div>
                        <button class="border-none text-gray-500 text-3xl px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full" onclick="nextCamera(activeCamera)">
                            <i class="fas fa-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-[#1a1a1a]
                    flex
                    flex-col
                    h-full
                    overflow-hidden
                    active:border-solid
                    active:border-4
                    active:border-orange-600
                    border-solid
                    border-2
                    border-gray-600
                    grid-rows-2"
             id="camera2Container">
            <div class="w-full relative h-full video-container">
                <video id="remoteVideo2" autoplay playsinline class="w-full h-full bg-black"></video>
                <div class="flex flex-col text-gray-500 absolute right-0 w-auto p-5 m-3 top-1/2 gap-4">
                    <button onclick="zoomIn(2)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                        <i class="fas fa-magnifying-glass-plus"></i>
                    </button>
                    <button onclick="zoomOut(2)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                        <i class="fas fa-magnifying-glass-minus"></i>
                    </button>
                </div>
                <div class="flex flex-row justify-between text-gray-500 absolute top-0 w-full p-5 m-3 items-center">
                    <div class="text-sm text-gray-300" id="timestamp2">--:--:--</div>
                    <div class="text-2x1">Camera 2</div>
                    <div>
                        <button onclick="exitSession(2)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full"><i class="fas fa-xmark"></i></button>
                    </div>
                </div>
                <div class="flex flex-row z-1 bottom-0 absolute w-full justify-center items-center p-5 gap-5 font-light">
                    <div>
                        <button class="border-none text-gray-500 text-3xl px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full" onclick="prevCamera(activeCamera)">
                            <i class="fas fa-angle-left"></i>
                        </button>
                    </div>
                    <div class="flex justify-center items-center">
                        <i class="text-gray-500 text-2x1 fas fa-ellipsis"></i>
                    </div>
                    <div>
                        <button class="border-none text-gray-500 text-3xl px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full" onclick="nextCamera(activeCamera)">
                            <i class="fas fa-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-[#1a1a1a]
                    flex
                    flex-col
                    h-full
                    overflow-hidden
                    active:border-solid
                    active:border-4
                    active:border-orange-600
                    border-solid
                    border-2
                    border-gray-600
                    grid-rows-3"
             id="camera3Container">
            <div class="w-full relative h-full video-container">
                <video id="remoteVideo3" autoplay playsinline class="w-full h-full bg-black"></video>
                <div class="flex flex-col text-gray-500 absolute right-0 w-auto p-5 m-3 top-1/2 gap-4">
                    <button onclick="zoomIn(3)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                        <i class="fas fa-magnifying-glass-plus"></i>
                    </button>
                    <button onclick="zoomOut(3)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                        <i class="fas fa-magnifying-glass-minus"></i>
                    </button>
                </div>
                <div class="flex flex-row justify-between text-gray-500 absolute top-0 w-full p-5 m-3 items-center">
                    <div class="text-sm text-gray-300" id="timestamp3">--:--:--</div>
                    <div class="text-2x1">Camera 3</div>
                    <div>
                        <button onclick="exitSession(3)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full"><i class="fas fa-xmark"></i></button>
                    </div>
                </div>
                <div class="flex flex-row z-1 bottom-0 absolute w-full justify-center items-center p-5 gap-5 font-light">
                    <div>
                        <button class="border-none text-gray-500 text-3xl px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full" onclick="prevCamera(activeCamera)">
                            <i class="fas fa-angle-left"></i>
                        </button>
                    </div>
                    <div class="flex justify-center items-center">
                        <i class="text-gray-500 text-2x1 fas fa-ellipsis"></i>
                    </div>
                    <div>
                        <button class="border-none text-gray-500 text-3xl px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full" onclick="nextCamera(activeCamera)">
                            <i class="fas fa-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-[#1a1a1a]
                    flex
                    flex-col
                    h-full
                    overflow-hidden
                    active:border-solid
                    active:border-4
                    active:border-orange-600
                    border-solid
                    border-2
                    border-gray-600
                    grid-rows-4"
             id="camera4Container">
            <div class="w-full relative h-full video-container">
                <video id="remoteVideo4" autoplay playsinline class="w-full h-full bg-black"></video>
                <div class="flex flex-col text-gray-500 absolute right-0 w-auto p-5 m-3 top-1/2 gap-4">
                    <button onclick="zoomIn(4)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                        <i class="fas fa-magnifying-glass-plus"></i>
                    </button>
                    <button onclick="zoomOut(4)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                        <i class="fas fa-magnifying-glass-minus"></i>
                    </button>
                </div>
                <div class="flex flex-row justify-between text-gray-500 absolute top-0 w-full p-5 m-3 items-center">
                    <div class="text-sm text-gray-300" id="timestamp4">--:--:--</div>
                    <div class="text-2x1">Camera 4</div>
                    <div>
                        <button onclick="exitSession(4)" class="border-none text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full"><i class="fas fa-xmark"></i></button>
                    </div>
                </div>
                <div class="flex flex-row z-1 bottom-0 absolute w-full justify-center items-center p-5 gap-5 font-light">
                    <div>
                        <button class="border-none text-gray-500 text-3xl px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full" onclick="prevCamera(activeCamera)">
                            <i class="fas fa-angle-left"></i>
                        </button>
                    </div>
                    <div class="flex justify-center items-center">
                        <i class="text-gray-500 text-2x1 fas fa-ellipsis"></i>
                    </div>
                    <div>
                        <button class="border-none text-gray-500 text-3xl px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full" onclick="nextCamera(activeCamera)">
                            <i class="fas fa-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container for removed camera container -->
        <div class="hidden
                        bg-gray-800 
                        flex-col
                        h-full
                        overflow-hidden
                        justify-center
                        items-center
                        border-solid
                        border-2
                        border-gray-600
                        grid-rows-5" 
                        id="removedCameraContainer">
            <div class="flex flex-col w-full h-full p-4 justify-center items-center bg-gray-900 text-gray-200">
                <h2 class="text-2xl text-gray-200">Camera Removed</h2>
                <p class="text-gray-500">The camera has been removed from the session.</p>
                <button class="mt-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-gray-400 hover:text-orange-400" onclick="addCamera()">
                    <i class="fas fa-camera pr-1.5"></i>Add Camera
                </button>
            </div>
    </div>
    </div>
    <!-- End of Camera Grid -->

    <!-- No Cameras Connected Message -->
    <div class="flex flex-col w-full h-full p-4 justify-center items-center bg-gray-900 text-gray-200"  id="noCamerasMessage" style="display: none;">
        <h2 class="text-2xl">No Cameras Connected</h2>
        <p>Please connect a camera to start the session.</p>
        <div class="flex flex-row justify-center items-center mt-4 gap-2">   
            <button class="mt-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-gray-400 hover:text-orange-400" onclick="addCamera()">
                <i class="fas fa-camera pr-1.5"></i>Add Camera
            </button>
            <button class="mt-4 bg-orange-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 hover:text-orange-400" onclick="exitSession()">
                <i class="fas fa-xmark pr-1.5"></i>Cancel
            </button>
        </div>
        <button class="mt-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-gray-400 hover:text-orange-400">
            <a href="/home"><i class="fas fa-house pr-4"></i>Home</a>
        </button>
    </div>

    <!-- Popup Add camera view stream passkey -->
    <div class="hidden fixed w-full h-full bg-black bg-opacity-50 z-50" id="passkeyPopup">
        <div class="flex flex-grow justify-center items-center h-full">
            <div class="flex flex-col bg-gray-800 rounded-lg shadow-lg p-4 w-1/3">
                <div class="w-full flex flex-row justify-between items-center">
                    <h2 class="text-xl text-gray-200 font-semibold">Add Camera</h2>
                    <button class="w-auto h-auto text-gray-100 p-2 hover:bg-gray-600 hover:text-orange-500 hover:rounded-full hover:p-2" id="close">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
                <div class="flex flex-row justify-center items-center mt-4">
                    <p class="text-gray-500 
                                text-md px-2.5 
                                cursor-pointer 
                                hover:rounded-full">Enter the passkey to add a camera.</p>
                </div>

                <hr class="w-full border-gray-500 my-3">

                <div class="w-full h-auto">
                    <label for="passkey" class="text-gray-300">Enter Camera Passkey:</label>
                    <input type="text" id="passkey" class="w-full p-2 bg-gray-700 text-gray-200 rounded mt-2" placeholder="Camera Passkey">
                    <button class="mt-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-gray-400 hover:text-orange-400" id="addCameraBtn">
                        <i class="fas fa-camera pr-1.5"></i>Add Camera
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup for Settings -->
    <div class="hidden fixed w-full h-full bg-black bg-opacity-50 z-50" id="settingsPopup">
        <div class="flex flex-grow justify-center items-center h-full">
            <div class="flex flex-col bg-gray-800 rounded-lg shadow-lg p-4 w-1/3">
                <div class="w-full flex flex-row justify-between items-center">
                    <h2 class="text-xl text-gray-200 font-semibold">Settings</h2>
                    <button class="w-auto h-auto text-gray-100 p-2 hover:bg-gray-600 hover:text-orange-500 hover:rounded-full hover:p-2" id="close">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>

                <hr class="w-full border-gray-500 my-3">

                <div class="w-full h-auto">
                    <ul>
                        <li class="text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full"
                            onclick="addCamera()">
                            <i class="fas fa-plus text-sm pr-2"></i>Add Camera
                        </li>
                        <li class="text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                            <i class="fas fa-sliders text-sm pr-2"></i>Audio Settings
                        </li>
                        <li class="text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                            <i class="fas fa-sliders text-sm pr-2"></i>Quality
                        </li>
                        <li class="text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                            <i class="fas fa-record-vinyl text-sm pr-2"></i>Recording Settings
                        </li>
                        <li class="text-gray-500 text-md px-2.5 cursor-pointer hover:text-orange-500 hover:bg-gray-600 hover:rounded-full">
                            <i class="fas fa-bell text-sm pr-2"></i>Notification Settings
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Popup for Settings -->

    <!-- Control Bar -->
    <div class="flex flex-row justify-center items-center p-6 gap-5 bg-[#2a2a2a] text-white bottom-0 z-1 w-full h-16">
        <button class="flex justify-center items-center bg-[#404040] rounded-full hover:bg-gray-500 hover:text-orange-500 px-2 py-3 mx-1 w-11 h-11" id="muteMic">
            <i class="fas fa-microphone"></i>
        </button>
        <button data-btn="Record" class="flex justify-center items-center text-red-600 bg-[#404040] hover:text-orange-700 rounded-full px-2 py-3 mx-1 w-11 h-11" id="recordButton">
            <i class="fas fa-circle"></i>
        </button>
        <button data-btn="Volume" class="flex justify-center items-center bg-[#404040] rounded-full hover:bg-gray-500 hover:text-orange-500 px-2 py-3 mx-1 w-11 h-11" id="volumeButton">
            <i class="fas fa-volume-up"></i>
        </button>
        <button data-btn="Multi-Camera" onclick="toggleView()" class="flex justify-center items-center bg-[#404040] rounded-full hover:bg-gray-500 hover:text-orange-500 px-2 py-3 mx-1 w-11 h-11" id="viewToggle">
            <i class="fab fa-microsoft"></i>
        </button>
        <button data-btn="Settings" class="flex justify-center items-center bg-[#404040] rounded-full hover:bg-gray-500 hover:text-orange-500 px-2 py-3 mx-1 w-11 h-11" id="settingsButton">
            <i class="fas fa-cog"></i>
        </button>
        <button data-btn="Fullscreen" class="flex justify-center items-center bg-[#404040] rounded-full hover:bg-gray-500 hover:text-orange-500 px-2 py-3 mx-1 w-11 h-11" id="fullscreenButton">
            <i class="fas fa-expand"></i>
        </button>
    </div>
    <!-- End of Control Bar -->
</div>
<!-- End of Main Content -->

<!-- Included internal style design -->
<style>
    /* Fullscreen without scrolling - improved */
    html, body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        height: 100%;
        width: 100%;
    }
    
    /* Ensure content fills the fullscreen mode properly */
    body.fullscreen-mode,
    body.fullscreen-mode .surveillance-container {
        height: 100vh;
        width: 100vw;
        overflow: hidden;
    }

    /* When in fullscreen mode, adjust container height */
    :fullscreen .surveillance-container,
    :-webkit-full-screen .surveillance-container,
    :-ms-fullscreen .surveillance-container {
        height: 100vh;
    }
    
    :fullscreen .video-container,
    :-webkit-full-screen .video-container,
    :-ms-fullscreen .video-container {
        height: calc(100vh - 60px);
    }
    
    /* Control bar in fullscreen */
    :fullscreen .control-bar,
    :-webkit-full-screen .control-bar,
    :-ms-fullscreen .control-bar {
        position: fixed;
        bottom: 0;
        width: 100%;
    }


/* Waiting for connection state */
.waiting-connection {
    position: relative;
}

.waiting-connection::after {
    content: "Connecting...";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    background-color: rgba(0, 0, 0, 0.7);
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 14px;
}

/* Video Aspect Ratio Handling */
video {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Changed from cover to contain */
    background: #000;
    transition: transform 0.2s ease-out; /* Smooth zoom transition */
}


/* Portrait mode detection and handling */
.portrait-mode video {
    max-height: 100%;
    max-width: 80%; /* Limit width for portrait videos */
    margin: 0 auto; /* Center horizontally */
}

/* Zoom indicator styling */
.zoom-indicator {
    position: absolute;
    bottom: 120px;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
    transition: opacity 0.5s;
    opacity: 0;
    z-index: 10;
}
</style>


<!-- Include Firebase and other necessary scripts -->
<script src="public/assets/js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-peer@9.11.1/simplepeer.min.js"></script>
<script type="module" src="<?= base_url('/assets/firebase_webrtc/load_session.js'); ?>"></script>
<script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>


<!-- Script for handling camera streams and UI interactions -->
<script>


// Store camera states globally
const cameras = {
    1: { active: true, zoom: 1 },
    2: { active: true, zoom: 1 },
    3: { active: true, zoom: 1 },
    4: { active: true, zoom: 1 }
};

document.addEventListener('DOMContentLoaded', () => {
    // Attach event listeners for exit buttons (optional: replace inline onclick)
    // On first load, show only the first camera in full screen
    // Hide all cameras except the first one
        for (let i = 2; i <= 4; i++) {
            const cameraContainer = document.getElementById(`camera${i}Container`);
            if (cameraContainer) {
                cameraContainer.style.display = 'none';
            }
            cameras[i].active = false;
        }

        // Ensure the first camera is in full screen
        const firstCameraContainer = document.getElementById('camera1Container');
        if (firstCameraContainer) {
            firstCameraContainer.classList.add('grid-cols-1');
            firstCameraContainer.classList.remove('md:grid-cols-2', 'lg:grid-cols-2', 'xl:grid-cols-2');
        }


        // Disable adding cameras unless settingsPopup is opened
        const settingsButton = document.getElementById('settingsButton');
        settingsButton.addEventListener('click', () => {
            const settingsPopup = document.getElementById('settingsPopup');
            if (settingsPopup) {
                settingsPopup.style.display = 'flex';
            }if (settingsButton) {
                settingsButton.style.active = 'text-color=""'; // Hide settings button when popup is open
            }

            const closeBtn = document.getElementById('close');
            closeBtn.addEventListener('click', () => {
                settingsPopup.classList.remove('flex');
                settingsPopup.classList.add('hidden');
            });

        });
 
 
    // Example for event delegation:
    document.getElementById('cameraGrid').addEventListener('click', (e) => {
        const exitBtn = e.target.closest('button');
        if (exitBtn && exitBtn.getAttribute('onclick')?.startsWith('exitSession')) {
            // Extract cameraId from onclick attribute, e.g. exitSession(1)
            const match = exitBtn.getAttribute('onclick').match(/exitSession\((\d+)\)/);
            if (match) {
                exitSession(parseInt(match[1], 10));
                e.preventDefault();
            }
        }
    });

    // Initialize timestamps update
    updateTimestamps();
    setInterval(updateTimestamps, 1000);
});

function exitSession(cameraId) {
    if (!cameraId || !cameras[cameraId]) {
        console.error('Invalid cameraId passed to exitSession:', cameraId);
        return;
    }

    const cameraContainer = document.getElementById(`camera${cameraId}Container`);
    const removedContainer = document.getElementById('removedCameraContainer');
    const videoElement = document.getElementById(`remoteVideo${cameraId}`);

    if (!cameraContainer) {
        console.error(`Camera container not found: camera${cameraId}Container`);
        return;
    }
    if (!removedContainer) {
        console.error('Removed camera container not found');
        return;
    }

    // Stop video stream if any
    if (videoElement && videoElement.srcObject) {
        videoElement.srcObject.getTracks().forEach(track => track.stop());
        videoElement.srcObject = null;
    }

    // Hide the camera container
    cameraContainer.style.display = 'none';

    // Show the removed camera container in place of the removed camera container
    // Insert the removed container after the hidden camera container
    if (!removedContainer.parentNode || removedContainer.parentNode !== cameraContainer.parentNode) {
        cameraContainer.parentNode.insertBefore(removedContainer, cameraContainer.nextSibling);
    }
    removedContainer.style.display = 'flex';

    cameras[cameraId].active = false;
    cameras[cameraId].zoom = 1;

    checkNoCamerasMessage();
}

function addCamera() {
    const removedContainer = document.getElementById('removedCameraContainer');
    const cameraGrid = document.getElementById('cameraGrid');
    const passkeyPopup = document.getElementById('passkeyPopup');
    const closeBtn = document.getElementById('close');
    const addCameraBtn = document.getElementById('addCameraBtn');
    const passkeyInput = document.getElementById('passkey');


    // Find first inactive camera slot
    const inactiveCameraEntry = Object.entries(cameras).find(([id, cam]) => !cam.active);
    if (!inactiveCameraEntry) {
        console.log('No inactive cameras to add');
        return;
    }
    const [cameraId] = inactiveCameraEntry;

    const cameraContainer = document.getElementById(`camera${cameraId}Container`);
    if (!cameraContainer) {
        console.error(`Camera container not found: camera${cameraId}Container`);
        return;
    }

    // Hide removed container if no more inactive cameras remain after this addition
    cameras[cameraId].active = true;
    cameraContainer.style.display = 'flex';

    // If no more inactive cameras, hide removed container
    const anyInactive = Object.values(cameras).some(cam => !cam.active);
    if (!anyInactive) {
        removedContainer.style.display = 'none';
    }

    // Show passkey popup before starting video stream
    passkeyPopup.style.display = 'flex';

    // Close popup on close button click
    closeBtn.addEventListener('click', () => {
        passkeyPopup.style.display = 'none';
    });

    // Add camera on valid passkey
    addCameraBtn.addEventListener('click', () => {
        const passkey = passkeyInput.value.trim();
        if (passkey === '1234') { // Replace '1234' with your actual passkey logic
            passkeyPopup.style.display = 'none';
            startVideoStream(cameraId);
        } else {
            alert('Invalid passkey. Please try again.');
        }
    });


    checkNoCamerasMessage();
}

function startVideoStream(cameraId) {
    const videoElement = document.getElementById(`remoteVideo${cameraId}`);
    if (!videoElement) {
        console.error(`Video element not found: remoteVideo${cameraId}`);
        return;
    }

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            videoElement.srcObject = stream;
        })
        .catch(err => {
            console.error(`Error accessing camera ${cameraId}`, err);
        });
}

function zoomIn(cameraId) {
    const video = document.getElementById(`remoteVideo${cameraId}`);
    if (!video) return;
    cameras[cameraId].zoom = Math.min(cameras[cameraId].zoom + 0.1, 3);
    video.style.transform = `scale(${cameras[cameraId].zoom})`;
}

function zoomOut(cameraId) {
    const video = document.getElementById(`remoteVideo${cameraId}`);
    if (!video) return;
    cameras[cameraId].zoom = Math.max(cameras[cameraId].zoom - 0.1, 1.0);
    video.style.transform = `scale(${cameras[cameraId].zoom})`;
}

function prevCamera(cameraId) {
    // Implement camera cycling logic if needed
    console.log(`Prev camera clicked for camera ${cameraId}`);
}

function nextCamera(cameraId) {
    // Implement camera cycling logic if needed
    console.log(`Next camera clicked for camera ${cameraId}`);
}

function checkNoCamerasMessage() {
    const noCamerasMessage = document.getElementById('noCamerasMessage');
    const anyActive = Object.values(cameras).some(cam => cam.active);
    noCamerasMessage.style.display = anyActive ? 'none' : 'flex';
}

function updateTimestamps() {
    const now = new Date();
    const timeString = now.toLocaleTimeString();

    for (let i = 1; i <= 4; i++) {
        const timestamp = document.getElementById(`timestamp${i}`);
        if (timestamp) {
            timestamp.textContent = timeString;
        }
    }
}


</script>



</body>
</html>
