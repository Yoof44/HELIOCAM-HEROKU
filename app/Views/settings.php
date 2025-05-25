<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">
<head>
    <title>Settings | HelioCam</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#FFF7ED',
                            100: '#FFEDD5',
                            200: '#FED7AA',
                            300: '#FDBA74',
                            400: '#FB923C',
                            500: '#FF8C42', // HelioCam Primary
                            600: '#EA580C',
                            700: '#C2410C', // Darker shade
                            800: '#9A3412',
                            900: '#7C2D12',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="flex flex-col min-h-screen bg-amber-50">
    <!-- Navigation Bar -->
    <nav class="bg-primary-500 shadow-md sticky top-0 z-50">
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
                    <a href="/settings" class="text-orange-300 bg-gray-800 p-2 rounded-full">
                        <i class="fas fa-cog text-2xl"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Settings Container -->
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <div class="md:w-1/4 bg-white rounded-2xl shadow-md p-4">
                <nav class="space-y-2">
                    <a href="#" onclick="showSection('deviceLog-section')" data-section="deviceLog-section"
                        class="nav-item-settings flex items-center px-4 py-3 text-gray-700 hover:bg-orange-100 rounded-lg transition">
                        <i class="fas fa-laptop mr-3 text-primary-500"></i>
                        <span class="font-medium">Devices Log-In</span>
                    </a>
                    <a href="#" onclick="showSection('notification_settings-section')" data-section="notification_settings-section"
                        class="nav-item-settings flex items-center px-4 py-3 text-gray-700 hover:bg-orange-100 rounded-lg transition">
                        <i class="fas fa-bell mr-3 text-primary-500"></i>
                        <span class="font-medium">Notification Settings</span>
                    </a>
                    <a href="#" onclick="showSection('about-section')" data-section="about-section"
                        class="nav-item-settings flex items-center px-4 py-3 text-gray-700 hover:bg-orange-100 rounded-lg transition">
                        <i class="fas fa-info-circle mr-3 text-primary-500"></i>
                        <span class="font-medium">About</span>
                    </a>
                    <hr class="my-3 border-gray-200">
                    <a href="#" id="logoutButton"
                        class="nav-item-settings flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition">
                        <i class="fas fa-door-open mr-3"></i>
                        <span class="font-medium">Logout</span>
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="md:w-3/4 bg-white rounded-2xl shadow-md p-6">
                <!-- Devices Logged-In Section -->
                <div id="deviceLog-section" class="content-section h-[500px] overflow-y-auto">
                    <h2 class="text-2xl font-bold text-gray-700 mb-4">Devices Logged-In</h2>
                    <p class="text-gray-600 text-lg mb-6">You're currently logged in on these devices:</p>

                    <!-- Current Device Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Current Device</h3>
                        <div id="currentDeviceContainer" class="space-y-4">
                            <!-- Device cards will be added here by JavaScript -->
                            <div class="text-center py-6 text-gray-400">
                                <i class="fas fa-spinner fa-spin text-2xl"></i>
                                <p>Loading device information...</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Other Devices Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Other Devices</h3>
                        <div id="otherDevicesContainer" class="space-y-4">
                            <!-- Device cards will be added here by JavaScript -->
                            <div class="text-center py-6 text-gray-400">
                                <i class="fas fa-spinner fa-spin text-2xl"></i>
                                <p>Loading device information...</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Notification Settings Section -->
                <div id="notification_settings-section" class="content-section hidden h-[500px] overflow-y-auto">
                    <h2 class="text-2xl font-bold text-gray-700 mb-4">Notification Settings</h2>
                    <p class="text-gray-600 mb-6">Manage your notification preferences</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <div>
                                <h3 class="font-medium text-gray-800 text-lg">All Notifications</h3>
                                <p class="text-gray-500 text-sm mt-1">Enable or disable all notifications</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="all-notifications-toggle" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-300 peer-checked:bg-primary-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>
                        
                        <div class="pl-4">
                            <h4 class="font-medium text-gray-700 mb-3">Manage individual notifications:</h4>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-2">
                                    <div>
                                        <h5 class="text-gray-700">Sound Detection</h5>
                                        <p class="text-gray-500 text-sm">Get alerts when sound is detected</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="sound-detection-toggle" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-300 peer-checked:bg-primary-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between py-2">
                                    <div>
                                        <h5 class="text-gray-700">Person Detection</h5>
                                        <p class="text-gray-500 text-sm">Get alerts when people are detected in view</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="person-detection-toggle" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-300 peer-checked:bg-primary-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Session Settings Section -->
                <div id="session_settings-section" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-gray-700 mb-4">Session Settings</h2>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Video Quality</h3>
                        <hr class="border-gray-200 mb-4">
                        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input id="1080p" name="video_quality" type="radio" value="1080p" class="w-4 h-4 text-primary-500 focus:ring-orange-400">
                                <label for="1080p" class="ml-3 text-gray-700">1080p (Full HD)</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input id="720p" name="video_quality" type="radio" value="720p" class="w-4 h-4 text-primary-500 focus:ring-orange-400">
                                <label for="720p" class="ml-3 text-gray-700">720p (HD)</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input id="480p" name="video_quality" type="radio" value="480p" class="w-4 h-4 text-primary-500 focus:ring-orange-400">
                                <label for="480p" class="ml-3 text-gray-700">480p (SD)</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input id="360p" name="video_quality" type="radio" value="360p" class="w-4 h-4 text-primary-500 focus:ring-orange-400">
                                <label for="360p" class="ml-3 text-gray-700">360p</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input id="144p" name="video_quality" type="radio" value="144p" class="w-4 h-4 text-primary-500 focus:ring-orange-400">
                                <label for="144p" class="ml-3 text-gray-700">144p</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input id="auto" name="video_quality" type="radio" value="Auto" checked class="w-4 h-4 text-primary-500 focus:ring-orange-400">
                                <label for="auto" class="ml-3 text-gray-700">Auto (Recommended)</label>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button class="bg-primary-500 hover:bg-primary-600 text-white font-medium py-2 px-6 rounded-lg transition transform hover:-translate-y-0.5">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- About Section -->
                <div id="about-section" class="content-section hidden h-[500px] overflow-y-auto">
                    <h2 class="text-2xl font-bold text-gray-700 mb-6">About</h2>
                    
                    <div class="flex items-center mb-6">
                        <div class="mr-4">
                            <img src="/assets/images/Helio-Logo.png" alt="HelioCam Logo" class="w-20 h-auto bg-gray-200 rounded-full shadow-lg items-center">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Helio<span class="text-primary-500">Cam</span></h3>
                            <p class="text-gray-500 text-sm">Version 1.0.1</p>
                        </div>
                    </div>
                    
                    <hr class="border-gray-200 my-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="about_us" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-center transition hover:shadow-md">
                            <i class="fas fa-info-circle text-primary-500 text-xl mb-2"></i>
                            <p class="font-medium text-gray-700">About Us</p>
                        </a>
                        
                        <a href="contact_us" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-center transition hover:shadow-md">
                            <i class="fas fa-envelope text-primary-500 text-xl mb-2"></i>
                            <p class="font-medium text-gray-700">Contact Us</p>
                        </a>
                        
                        <a href="policy" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-center transition hover:shadow-md">
                            <i class="fas fa-shield-alt text-primary-500 text-xl mb-2"></i>
                            <p class="font-medium text-gray-700">Privacy Policy</p>
                        </a>
                        
                        <a href="terms" class="bg-white hover:bg-gray-50 border border-gray-200 rounded-lg p-4 text-center transition hover:shadow-md">
                            <i class="fas fa-file-contract text-primary-500 text-xl mb-2"></i>
                            <p class="font-medium text-gray-700">Terms of Service</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-primary-500 to-primary-400 text-white py-6 px-4 bottom-0 z-1">
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

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Remove active class from all nav items
            document.querySelectorAll('.nav-item-settings').forEach(item => {
                item.classList.remove('bg-primary-100', 'text-primary-500');
                item.classList.add('text-gray-700');
            });
            
            // Show selected section
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.classList.remove('hidden');
            }
            
            // Highlight nav item
            const navItem = document.querySelector(`[data-section="${sectionId}"]`);
            if (navItem) {
                navItem.classList.remove('text-gray-700');
                navItem.classList.add('bg-primary-100', 'text-primary-500');
            }
        }

        // Show deviceLog section by default
        window.onload = function() {
            showSection('deviceLog-section');
        };
    </script>
    
    <script type="module" src="<?= base_url('/assets/firebase_auth/logout.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/verification_status.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_notif/notification-settings.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/device-login-manager.js'); ?>"></script>

    <!-- Add toast styles for notifications -->
    <style>
        .toast-notification {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: white;
            padding: 12px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 9999;
        }
        
        .toast-notification.show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</body>
</html>