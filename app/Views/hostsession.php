<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">
    <head>
        <title>Start Session | HelioCam</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Updated favicon with proper path using base_url -->
        <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Bootstrap is needed for modals -->
        <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.css'); ?>">
        <style>
            .pulse-effect {
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(255, 140, 66, 0.7); }
                70% { box-shadow: 0 0 0 15px rgba(255, 140, 66, 0); }
                100% { box-shadow: 0 0 0 0 rgba(255, 140, 66, 0); }
            }
            .hover-lift {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
            }
        </style>
    </head>

    <body class="flex flex-col min-h-screen bg-gradient-to-b from-amber-50 to-orange-50">
        <!-- Navigation Bar -->
    <nav class="bg-[#FF8C42] shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/home" class="flex items-center">
                <img src="/assets/images/Helio-Logo.png" class="h-10 w-auto" alt="HelioCam Logo">
            </a>
            
            <ul class="flex items-center space-x-6">
                <li>
                    <a href="/home" class="text-orange-100 hover:text-orange-300 transition">
                        <i class="fas fa-home text-2xl"></i>
                    </a>
                </li>
                <li>
                    <a href="/history" class="text-orange-100 hover:text-orange-300 transition">
                        <i class="fas fa-clock text-2xl"></i>
                    </a>
                </li>
                <li>
                    <a href="/notification" class="text-orange-100 hover:text-orange-300 transition">
                        <i class="fas fa-bell text-2xl"></i>
                    </a>
                </li>
            </ul>
            
            <ul class="flex items-center space-x-6">
                <li>
                    <a href="/profile" class="text-orange-100 hover:text-orange-300 transition">
                        <i class="fas fa-user text-2xl"></i>
                    </a>
                </li>
                <li>
                    <a href="/settings" class="text-orange-100 hover:text-orange-300 transition">
                        <i class="fas fa-cog text-2xl"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>


        <!-- Main Content -->
        <div class="container mx-auto px-4 py-10 flex-grow">
            <div class="max-w-3xl mx-auto">
                <!-- Start Session Header -->
                <div class="flex flex-col md:flex-row items-center justify-center md:justify-start mb-12 gap-8 bg-white bg-opacity-70 p-6 rounded-3xl shadow-lg">
                    <div class="bg-gradient-to-br from-orange-300 to-orange-100 rounded-full w-40 h-40 flex items-center justify-center shadow-xl pulse-effect">
                        <i class="fas fa-video text-gray-800 text-6xl"></i>
                    </div>
                    
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">Host a Live Session</h1>
                        <p class="text-gray-600 text-lg">Create a camera broadcast for others to view</p>
                        <div class="mt-4 flex justify-center md:justify-start space-x-3">
                            <span class="bg-orange-100 rounded-full px-3 py-1 flex items-center text-orange-800 text-sm font-medium whitespace-nowrap">
                                <i class="fas fa-broadcast-tower mr-1"></i> Host Broadcasting
                            </span>
                            <span class="bg-orange-100 rounded-full px-3 py-1 flex items-center text-orange-800 text-sm font-medium whitespace-nowrap">
                                <i class="fas fa-shield-alt mr-1"></i> Access Control
                            </span>
                            <span class="bg-orange-100 rounded-full px-3 py-1 flex items-center text-orange-800 text-sm font-medium whitespace-nowrap">
                                <i class="fas fa-users mr-1"></i> Viewer Management
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Create Session Card -->
                <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 mb-8 hover-lift border border-orange-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Host Session Details</h2>
                        <div class="bg-orange-100 p-3 rounded-full">
                            <i class="fas fa-cog text-orange-500 text-xl"></i>
                        </div>
                    </div>
                    
                    <hr class="border-gray-200 mb-6">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="session-name" class="block text-gray-700 font-medium mb-2">
                                <i class="fas fa-tag mr-2 text-orange-500"></i>Session Name
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="session-name" 
                                    name="session-name" 
                                    placeholder="Enter Broadcast Name (e.g. Kitchen, Bedroom...)" 
                                    class="w-full bg-gray-50 border border-gray-300 rounded-xl py-4 px-5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                                >
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                    <i class="fas fa-home"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Choose a descriptive name for your broadcast location</p>
                        </div>
                        
                        <div>
                            <label for="session-passkey" class="block text-gray-700 font-medium mb-2">
                                <i class="fas fa-key mr-2 text-orange-500"></i>Session Passkey
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="session-passkey" 
                                    name="session-passkey" 
                                    placeholder="Create Access Key for Viewers" 
                                    class="w-full bg-gray-50 border border-gray-300 rounded-xl py-4 px-5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                                >
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Create a unique access key that viewers will need to join your broadcast</p>
                        </div>

                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100 mb-6">
                            <div class="flex items-start">
                                <div class="text-orange-500 mr-3">
                                    <i class="fas fa-info-circle text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Host Information</h4>
                                    <p class="text-sm text-gray-600">Your camera will begin broadcasting once the session is created. Make sure to allow camera permissions when prompted by your browser.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col md:flex-row gap-4 pt-4">
                            <button 
                                id="addContentBtn" 
                                type="submit" 
                                class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-medium py-3 px-8 rounded-xl transition transform hover:-translate-y-1 shadow-lg flex-1 flex items-center justify-center"
                            >
                                <i class="fas fa-broadcast-tower mr-2"></i>Start Hosting
                            </button>
                            
                            <a href="/home" class="bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white font-medium py-3 px-8 rounded-xl transition transform hover:-translate-y-1 shadow-lg flex-1 flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Return to Add Session Button -->
                <div class="flex justify-center mt-2 mb-6">
                    <a href="/home" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Return to Home
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-[#FF8C42] to-[#FF9A5A] text-white py-6 px-4 mt-10">
            <div class="container mx-auto max-w-4xl">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Left side content -->
                    <div class="self-start md:self-center mb-4 md:mb-0">
                        <p class="mb-1">&copy; 2025 HelioCam. All Rights Reserved.</p>
                        <p class="text-xs">Made with <span class="text-red-300">♥</span> | <a href="" class="text-white hover:underline">Summersoft</a></p>
                    </div>
                    
                    <!-- Right side content -->
                    <div class="self-end md:self-center">
                        <p class="text-sm mb-2 text-right">Follow us:</p>
                        <ul class="flex justify-end space-x-4">
                            <li><a href="" class="text-xl text-white hover:text-orange-200 transition"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="" class="text-xl text-white hover:text-orange-200 transition"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="" class="text-xl text-white hover:text-orange-200 transition"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="" class="text-xl text-white hover:text-orange-200 transition"><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <script src="<?= base_url('/assets/js/bootstrap.bundle.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_auth/verification_status.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_webrtc/create_session.js'); ?>"></script>
        <script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const isRecreate = urlParams.get('recreate') === 'true';
    
    if (isRecreate) {
        // Get session details from URL
        const sessionName = urlParams.get('session_name');
        const passkey = urlParams.get('passkey');
        const location = urlParams.get('location');
        
        // Prefill the form fields
        const sessionNameInput = document.getElementById('session-name');
        const passkeyInput = document.getElementById('session-passkey');
        
        if (sessionNameInput && sessionName) {
            sessionNameInput.value = sessionName;
        }
        
        if (passkeyInput && passkey) {
            passkeyInput.value = passkey;
        }
        
        // Show a notification that we're recreating a session
        const notificationElement = document.createElement('div');
        notificationElement.className = 'bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-6';
        notificationElement.innerHTML = `
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                <div>
                    <h4 class="font-semibold">Recreating Session</h4>
                    <p class="text-sm">You are recreating a previous session. Feel free to modify any details before starting.</p>
                </div>
            </div>
        `;
        
        // Insert the notification at the top of the form
        const sessionDetailsCard = document.querySelector('.hover-lift');
        if (sessionDetailsCard) {
            sessionDetailsCard.insertBefore(notificationElement, sessionDetailsCard.firstChild);
        }
    }
});
</script>
    </body>
</html>