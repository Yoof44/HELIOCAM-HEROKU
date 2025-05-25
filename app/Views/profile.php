<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">
    <head>
        <title>Profile | HelioCam</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Updated favicon with proper path using base_url -->
        <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#FF8C42',
                        }
                    }
                }
            }
        </script>
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
                    <a href="/profile" class="text-orange-100 bg-gray-800 p-2 rounded-full">
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
                <!-- Profile Header -->
                <div class="flex flex-col md:flex-row items-center mb-8 gap-6">
                    <div class="bg-orange-200 rounded-full w-32 h-32 flex items-center justify-center shadow-lg">
                        <i class="fas fa-user text-gray-800 text-5xl"></i>
                    </div>
                    
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-800" id="profile-username">User Profile</h1>
                        <p class="text-gray-600 mt-1">Manage your personal information</p>
                    </div>
                </div>
                
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-semibold text-gray-800">Personal Information</h2>
                        <a href="/eprofile" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition transform hover:-translate-y-0.5">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                    
                    <hr class="border-gray-200 mb-6">
                    
                    <!-- Loading indicator -->
                    <div id="loading-indicator" class="py-4 text-center">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-orange-500 border-t-transparent"></div>
                        <p class="text-gray-600 mt-2">Loading your profile data...</p>
                    </div>
                    
                    <form class="space-y-5" id="profile-form" style="display: none;">
                        <div>
                            <label for="fname" class="block text-gray-700 font-medium mb-2">Full Name:</label>
                            <div 
                                id="fname-display" 
                                class="w-full bg-gray-100 border border-gray-200 rounded-lg py-3 px-4 text-gray-700"
                            ></div>
                            <input 
                                type="hidden" 
                                name="fname" 
                                id="fname"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address:</label>
                            <div 
                                id="email-display" 
                                class="w-full bg-gray-100 border border-gray-200 rounded-lg py-3 px-4 text-gray-700"
                            ></div>
                            <input 
                                type="hidden" 
                                name="email" 
                                id="email"
                            >
                        </div>

                        <div>
                            <label for="uname" class="block text-gray-700 font-medium mb-2">Username:</label>
                            <div 
                                id="uname-display" 
                                class="w-full bg-gray-100 border border-gray-200 rounded-lg py-3 px-4 text-gray-700"
                            ></div>
                            <input 
                                type="hidden" 
                                name="uname" 
                                id="uname"
                            >
                        </div>

                        <div>
                            <label for="contact" class="block text-gray-700 font-medium mb-2">Contact #:</label>
                            <div 
                                id="contact-display" 
                                class="w-full bg-gray-100 border border-gray-200 rounded-lg py-3 px-4 text-gray-700"
                            ></div>
                            <input 
                                type="hidden" 
                                name="contact" 
                                id="contact"
                            >
                        </div>
                    </form>
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
        <script type="module" src="<?= base_url('/assets/firebase_data/fetch_user_data.js'); ?>"></script>
        
        <!-- Additional script to handle loading indicator -->
        <script type="module">
            // Wait for the data to load, then show the form and hide the loading indicator
            document.addEventListener('DOMContentLoaded', function() {
                const checkFormFilled = setInterval(() => {
                    // Check both hidden input and display div
                    const emailField = document.getElementById('email');
                    const emailDisplay = document.getElementById('email-display');
                    
                    const hasEmailValue = emailField && emailField.value && emailField.value !== '';
                    const hasEmailDisplay = emailDisplay && emailDisplay.textContent && emailDisplay.textContent !== '';
                    
                    if (hasEmailValue || hasEmailDisplay) {
                        console.log("Profile data loaded, showing form");
                        document.getElementById('loading-indicator').style.display = 'none';
                        document.getElementById('profile-form').style.display = 'block';
                        
                        // Populate display divs from input values if necessary
                        const fields = ['fname', 'email', 'uname', 'contact'];
                        fields.forEach(field => {
                            const input = document.getElementById(field);
                            const display = document.getElementById(field + '-display');
                            
                            if (input && display && !display.textContent && input.value) {
                                display.textContent = input.value;
                                if (input.value === 'Not set') {
                                    display.classList.add('text-gray-500', 'italic');
                                }
                            }
                        });
                        
                        // Also update the username at the top if available
                        const username = document.getElementById('uname').value;
                        if (username && username !== 'Not set') {
                            document.getElementById('profile-username').textContent = username;
                        }
                        
                        clearInterval(checkFormFilled);
                    }
                }, 500);
                
                // Timeout after 5 seconds in case of error
                setTimeout(() => {
                    clearInterval(checkFormFilled);
                    if (document.getElementById('loading-indicator').style.display !== 'none') {
                        document.getElementById('loading-indicator').innerHTML = 
                            '<p class="text-red-500">Unable to load profile data. Please refresh the page.</p>';
                    }
                }, 5000);
            });
        </script>
    </body>
</html>