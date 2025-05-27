<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">

<head>
    <title>Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
    <!-- Alternative formats for better browser compatibility -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/assets/images/Helio-Logo-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/assets/images/Helio-Logo-16x16.png'); ?>">
    <link rel="apple-touch-icon" href="<?= base_url('/assets/images/Helio-Logo-180x180.png'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-amber-50">
     <!-- Navigation Bar -->
     <nav class="bg-[#FF8C42] shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/home" class="flex items-center">
                <img src="/assets/images/Helio-Logo.png" class="h-10 w-auto" alt="HelioCam Logo">
            </a>
            
            <ul class="flex items-center space-x-6">
                <li>
                    <a href="/home" class="text-orange-100 bg-gray-800 p-2 rounded-full">
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
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="max-w-2xl mx-auto">
            <!-- Welcome Header -->
            <div class="flex flex-col md:flex-row items-center mb-8 gap-6">
                <div class="bg-orange-200 rounded-full w-32 h-32 flex items-center justify-center shadow-lg">
                    <i class="fas fa-home text-gray-800 text-5xl"></i>
                </div>
                
                <div class="text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-800">Welcome to HelioCam</h1>
                    <p class="text-gray-600 mt-1">Your smart home monitoring solution</p>
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Quick Actions</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="/hostsession" class="bg-gradient-to-r from-orange-400 to-amber-500 rounded-xl p-6 text-white hover:shadow-lg transition transform hover:-translate-y-1">
                        <div class="flex flex-col items-center text-center">
                            <i class="fas fa-video text-4xl mb-3"></i>
                            <h3 class="text-xl font-bold">Start New Session</h3>
                            <p class="mt-2 text-sm">Create a new camera broadcast</p>
                        </div>
                    </a>
                    
                    <a href="/history" class="bg-gradient-to-r from-orange-400 to-amber-500 rounded-xl p-6 text-white hover:shadow-lg transition transform hover:-translate-y-1">
                        <div class="flex flex-col items-center text-center">
                            <i class="fas fa-clock text-4xl mb-3"></i>
                            <h3 class="text-xl font-bold">View Sessions</h3>
                            <p class="mt-2 text-sm">Access your recorded sessions</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Dashboard Widgets (replacing Recent Activity) -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard</h2>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Introduction Widget (now full width) -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-5 border border-amber-200">
                        <div class="flex items-center mb-3">
                            <div class="bg-amber-500 rounded-full p-2 mr-3">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Welcome to HelioCam</h3>
                        </div>
                        <p class="text-gray-600 mb-3">HelioCam transforms your device into a versatile home monitoring system that's easy to use and secure.</p>
                        
                        <!-- Fixed feature grid layout -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="text-gray-600 text-sm flex items-start">
                                <i class="fas fa-lock text-amber-500 mt-0.5 mr-2"></i>
                                <span>Private peer-to-peer video streaming</span>
                            </div>
                            <div class="text-gray-600 text-sm flex items-start">
                                <i class="fas fa-bell text-amber-500 mt-0.5 mr-2"></i>
                                <span>Real-time motion and sound notifications</span>
                            </div>
                            <div class="text-gray-600 text-sm flex items-start">
                                <i class="fas fa-mobile-alt text-amber-500 mt-0.5 mr-2"></i>
                                <span>Monitor from anywhere, on any device</span>
                            </div>
                            <div class="text-gray-600 text-sm flex items-start">
                                <i class="fas fa-shield-alt text-amber-500 mt-0.5 mr-2"></i>
                                <span>No third-party servers store your footage</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tips Widget (still in its own section) -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200 flex flex-col">
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-500 rounded-full p-2 mr-3">
                                <i class="fas fa-lightbulb text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">HelioCam Tips</h3>
                        </div>
                        <div id="tip-container" class="text-gray-600 flex-grow">
                            <p class="tip-text">Enable motion detection to receive alerts when movement is detected in your camera view.</p>
                        </div>
                        <button id="next-tip-btn" class="self-end text-blue-600 hover:text-blue-800 text-sm font-medium mt-3">Next Tip</button>
                    </div>
                    
                    <!-- Getting Started -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-5 border border-orange-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-orange-500 rounded-full p-2 mr-3">
                                <i class="fas fa-rocket text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Getting Started</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="bg-orange-400 rounded-full h-6 w-6 flex items-center justify-center text-white text-sm mr-3">1</div>
                                <p class="text-gray-600">Create your first monitoring session</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-orange-400 rounded-full h-6 w-6 flex items-center justify-center text-white text-sm mr-3">2</div>
                                <p class="text-gray-600">Set up your session name and passkey</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-orange-400 rounded-full h-6 w-6 flex items-center justify-center text-white text-sm mr-3">3</div>
                                <p class="text-gray-600">Share the session link with trusted joiners </p>
                            </div>
                        </div>
                        <a href="/hostsession" class="mt-4 inline-block text-orange-600 hover:text-orange-800 font-medium">Start Monitoring →</a>
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

    <!-- Scripts -->
    <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
    <script type="module" src="<?= base_url(relativePath: '/assets/firebase_auth/verification_status.js'); ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Array of helpful HelioCam tips
        const helioCamTips = [
            "Enable motion detection to receive alerts when movement is detected in your camera view.",
            "Position your camera in a well-lit area for better image quality and clearer recordings.",
            "Use a strong, unique passkey for each session to enhance security and control access.",
            "Check your internet connection speed before starting a session for optimal streaming quality.",
            "Angle your camera away from windows to avoid glare and backlight issues in your recordings."
        ];
        
        // Variables to track current tip
        let currentTipIndex = 0;
        const tipContainer = document.getElementById('tip-container');
        const nextTipBtn = document.getElementById('next-tip-btn');
        
        // Function to show the next tip
        function showNextTip() {
            // Fade out current tip
            tipContainer.style.opacity = '0';
            
            setTimeout(() => {
                // Update to next tip
                currentTipIndex = (currentTipIndex + 1) % helioCamTips.length;
                
                // Update the tip text
                tipContainer.innerHTML = `<p class="tip-text">${helioCamTips[currentTipIndex]}</p>`;
                
                // Fade in the new tip
                tipContainer.style.opacity = '1';
            }, 300);
        }
        
        // Add transition effect to the tip container
        tipContainer.style.transition = 'opacity 0.3s ease';
        
        // Add click event listener to the Next Tip button
        if (nextTipBtn) {
            nextTipBtn.addEventListener('click', showNextTip);
        }
        
        // Initialize with first tip
        tipContainer.innerHTML = `<p class="tip-text">${helioCamTips[0]}</p>`;
    });
    </script>
</body>
</html>