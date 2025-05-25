<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">
    <head>
        <title>History | HelioCam</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Updated favicon with proper path using base_url -->
        <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
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
                        <a href="/home" class="text-orange-100 hover:text-orange-300 transition">
                            <i class="fas fa-home text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/history" class="text-orange-100 bg-gray-800 p-2 rounded-full">
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
            <div class="max-w-3xl mx-auto">
                <!-- History Header -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Session History</h1>
                        <p class="text-gray-600 mt-1">View and manage your recorded sessions</p>
                    </div>
                    <div class="bg-orange-200 rounded-full w-12 h-12 flex items-center justify-center shadow-md">
                        <i class="fas fa-clock text-gray-800 text-xl"></i>
                    </div>
                </div>
                
                <!-- Sessions Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-semibold text-gray-800">All Sessions</h2>
                        <a href="/hostsession" id="addSessionBtn" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition transform hover:-translate-y-0.5">
                            <i class="fas fa-plus mr-2"></i>New Session
                        </a>
                    </div>
                    
                    <hr class="border-gray-200 mb-6">
                    
                    <div id="sessionsContainer">
                        <!-- No Sessions Message -->
                        <div class="no-session text-center py-8">
                            <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-video-slash text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-gray-500 text-xl font-medium">No Sessions Available</h3>
                            <p class="text-gray-400 mt-2">You haven't created any monitoring sessions yet</p>
                            <a href="/hostsession" class="mt-4 bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-6 rounded-lg transition inline-block">
                                Create Your First Session
                            </a>
                        </div>
                        
                        <!-- Sessions holder - this will be populated by get_sessions.js -->
                        <div class="sessions-holder space-y-4">
                            <!-- Dynamic sessions will appear here -->
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

        <script src="public/assets/js/bootstrap.js"></script>
        <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_auth/verification_status.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_webrtc/get_sessions.js'); ?>"></script>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to check if sessions exist and toggle visibility
            function toggleNoSessionsMessage() {
                const sessionsHolder = document.querySelector('.sessions-holder');
                const noSessionMessage = document.querySelector('.no-session');
                
                // Show "No sessions" message only when sessions holder is empty
                if (sessionsHolder && noSessionMessage) {
                    const hasSessionItems = sessionsHolder.children.length > 0;
                    noSessionMessage.style.display = hasSessionItems ? 'none' : 'block';
                }
            }
            
            // Call initially
            toggleNoSessionsMessage();
            
            // Set up a mutation observer to watch for dynamically added sessions
            const observer = new MutationObserver(toggleNoSessionsMessage);
            const sessionsHolder = document.querySelector('.sessions-holder');
            
            if (sessionsHolder) {
                observer.observe(sessionsHolder, { childList: true });
            }
            
            // Add refresh button functionality if it exists
            const refreshBtn = document.getElementById("refresh-sessions");
            if (refreshBtn) {
                refreshBtn.addEventListener("click", function() {
                    // This will trigger the fetchSessions function in get_sessions.js
                    const refreshEvent = new Event('refresh-sessions');
                    document.dispatchEvent(refreshEvent);
                });
            }
        });
        </script>
    </body>
</html>
