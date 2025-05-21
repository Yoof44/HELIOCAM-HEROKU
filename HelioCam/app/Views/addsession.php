<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">
    <head>
        <title>Add Session | HelioCam</title>
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
        <!-- Modals -->
        <div class="modal fade" id="sessionAddedModal" tabindex="-1" aria-labelledby="sessionAddedLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-xl border-0 shadow-lg">
                    <div class="modal-header bg-green-50 text-green-700 border-b-0">
                        <h5 class="modal-title text-xl" id="sessionAddedLabel">
                            <i class="fas fa-check-circle mr-2 text-green-500"></i>Success
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4 text-lg">
                        Session has been added successfully!
                    </div>
                    <div class="modal-footer border-t-0">
                        <button type="button" class="btn bg-green-500 text-white hover:bg-green-600" data-bs-dismiss="modal">OK</button>
                        <button type="button" class="btn bg-orange-500 text-white hover:bg-orange-600" data-bs-dismiss="modal" onclick="window.location.href='/home';">Return to Home</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="sessionExistsModal" tabindex="-1" aria-labelledby="sessionExistsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-xl border-0 shadow-lg">
                    <div class="modal-header bg-yellow-50 text-yellow-700 border-b-0">
                        <h5 class="modal-title text-xl" id="sessionExistsLabel">
                            <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>Warning
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4 text-lg">
                        This session already exists.
                    </div>
                    <div class="modal-footer border-t-0">
                        <button type="button" class="btn bg-yellow-500 text-white hover:bg-yellow-600" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="sessionNotFoundModal" tabindex="-1" aria-labelledby="sessionNotFoundLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-xl border-0 shadow-lg">
                    <div class="modal-header bg-red-50 text-red-700 border-b-0">
                        <h5 class="modal-title text-xl" id="sessionNotFoundLabel">
                            <i class="fas fa-times-circle mr-2 text-red-500"></i>Error
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4 text-lg">
                        No session found with the provided passkey.
                    </div>
                    <div class="modal-footer border-t-0">
                        <button type="button" class="btn bg-red-500 text-white hover:bg-red-600" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

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
                <!-- Add Session Header -->
                <div class="flex flex-col md:flex-row items-center justify-center md:justify-start mb-12 gap-8 bg-white bg-opacity-70 p-6 rounded-3xl shadow-lg">
                    <div class="bg-gradient-to-br from-orange-300 to-orange-100 rounded-full w-40 h-40 flex items-center justify-center shadow-xl pulse-effect">
                        <i class="fas fa-plus-circle text-gray-800 text-6xl"></i>
                    </div>
                    
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">Add Session</h1>
                        <p class="text-gray-600 text-lg">Connect to an existing camera or start a new session</p>
                        <div class="mt-4 flex flex-wrap gap-3 justify-center md:justify-start">
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-video mr-1"></i> Camera Control
                            </span>
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-lock mr-1"></i> Secure Connection
                            </span>
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-link mr-1"></i> Easy Setup
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Session Options Cards Container -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Join Existing Card -->
                    <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 mb-8 hover-lift border border-orange-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-semibold text-gray-800">Join Session</h2>
                            <div class="bg-orange-100 p-3 rounded-full">
                                <i class="fas fa-sign-in-alt text-orange-500 text-xl"></i>
                            </div>
                        </div>
                        
                        <hr class="border-gray-200 mb-6">
                        
                        <div class="space-y-6">
                            <div>
                                <label for="passkey" class="block text-gray-700 font-medium mb-2">
                                    <i class="fas fa-key mr-2 text-orange-500"></i>Session Passkey
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="passkey" 
                                        name="passkey" 
                                        placeholder="Enter Session Passkey" 
                                        class="w-full bg-gray-50 border border-gray-300 rounded-xl py-4 px-5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                                    >
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Enter the unique passkey provided by the camera owner</p>
                            </div>
                            
                            <div class="flex justify-center mt-8">
                                <button 
                                    id="submit" 
                                    type="submit" 
                                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-medium py-3 px-8 rounded-xl transition transform hover:-translate-y-1 shadow-lg w-full"
                                >
                                    <i class="fas fa-plus-circle mr-2"></i>Add Session
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Start New Session Card -->
                    <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 mb-8 hover-lift border border-orange-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-semibold text-gray-800">Start New Session</h2>
                            <div class="bg-orange-100 p-3 rounded-full">
                                <i class="fas fa-desktop text-orange-500 text-xl"></i>
                            </div>
                        </div>
                        
                        <hr class="border-gray-200 mb-6">
                        
                        <div class="text-center px-4">
                            <a href="startsession" class="inline-block mb-6">
                                <div class="bg-gradient-to-r from-orange-100 to-orange-200 hover:from-orange-200 hover:to-orange-300 rounded-full w-28 h-28 flex items-center justify-center transition shadow-md mx-auto">
                                    <i class="fas fa-desktop text-orange-700 text-5xl"></i>
                                </div>
                            </a>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Use This Device As Camera</h3>
                            <p class="text-gray-600 mb-8">
                                Start broadcasting from this device and create a new session others can join
                            </p>
                            
                            <div class="flex justify-center">
                                <a href="startsession" class="bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 text-white font-medium py-3 px-8 rounded-xl transition transform hover:-translate-y-1 shadow-lg">Start Session</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Footer -->
    <footer class="bg-gradient-to-r from-[#FF8C42] to-[#FF9A5A] text-white py-6 px-4 bottom-0 z-1">
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
        <script type="module" src="<?= base_url('/assets/firebase_webrtc/add_session.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
    </body>
</html>