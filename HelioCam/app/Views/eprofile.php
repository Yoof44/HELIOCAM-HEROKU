<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">
    <head>
        <title>Edit Profile | HelioCam</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Updated favicon with proper path using base_url -->
        <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#FF8C42',
                            secondary: '#FFD8B1',
                        },
                        boxShadow: {
                            'custom': '0 10px 15px -3px rgba(255, 140, 66, 0.1), 0 4px 6px -2px rgba(255, 140, 66, 0.05)',
                        }
                    }
                }
            }
        </script>
    </head>

    <body class="flex flex-col min-h-screen bg-gradient-to-b from-amber-50 to-orange-50">
        <!-- Navigation Bar -->
        <nav class="bg-gradient-to-r from-primary to-orange-400 shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <a href="/home" class="flex items-center">
                    <img src="/assets/images/Helio-Logo.png" class="h-10 w-auto" alt="HelioCam Logo">
                </a>
                
                <ul class="flex items-center space-x-6">
                    <li>
                        <a href="/home" class="text-white hover:text-orange-100 transition-all duration-300">
                            <i class="fas fa-home text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/history" class="text-white hover:text-orange-100 transition-all duration-300">
                            <i class="fas fa-clock text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/notification" class="text-white hover:text-orange-100 transition-all duration-300">
                            <i class="fas fa-bell text-2xl"></i>
                        </a>
                    </li>
                </ul>
                
                <ul class="flex items-center space-x-6">
                    <li>
                        <a href="/profile" class="text-white bg-gray-800 p-2 rounded-full shadow-custom transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-user text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/settings" class="text-white hover:text-orange-100 transition-all duration-300">
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
                <div class="flex flex-col md:flex-row items-center mb-8 gap-6 bg-white bg-opacity-80 rounded-2xl p-6 shadow-custom">
                    <div class="bg-gradient-to-br from-orange-300 to-orange-200 rounded-full w-32 h-32 flex items-center justify-center shadow-lg transform hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-user-edit text-gray-800 text-5xl"></i>
                    </div>
                    
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
                        <p class="text-gray-600 mt-1">Update your personal information</p>
                    </div>
                </div>
                
                <!-- Edit Profile Form -->
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 backdrop-blur-sm hover:shadow-custom transition-all duration-300">
                    <div class="mb-4 flex items-center">
                        <div class="bg-primary rounded-full p-2 mr-3 text-white">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800">Personal Information</h2>
                    </div>
                    
                    <hr class="border-gray-200 mb-6">

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="py-4 text-center">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-orange-500 border-t-transparent"></div>
                        <p class="text-gray-600 mt-2">Loading your profile data...</p>
                    </div>

                    <form class="space-y-5" id="edit-profile-form" style="display: none;">
                        <div class="group">
                            <label for="fname" class="block text-gray-700 font-medium mb-2 transition-all duration-300 group-focus-within:text-primary">
                                <i class="fas fa-user mr-2"></i>Full Name:
                            </label>
                            <input 
                                type="text" 
                                name="fname" 
                                id="fname" 
                                placeholder="Enter your full name" 
                                class="w-full bg-white border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 shadow-sm hover:shadow-md"
                            >
                        </div>
                        
                        <div class="group">
                            <label for="email" class="block text-gray-700 font-medium mb-2 transition-all duration-300 group-focus-within:text-primary">
                                <i class="fas fa-envelope mr-2"></i>Email Address:
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                placeholder="Enter your email address" 
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg py-3 px-4 text-gray-700 cursor-not-allowed focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-transparent transition-all duration-300"
                                readonly
                            >
                        </div>
                        
                        <div class="group">
                            <label for="uname" class="block text-gray-700 font-medium mb-2 transition-all duration-300 group-focus-within:text-primary">
                                <i class="fas fa-at mr-2"></i>Username:
                            </label>
                            <input 
                                type="text" 
                                name="uname" 
                                id="uname" 
                                placeholder="Enter your username" 
                                class="w-full bg-white border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 shadow-sm hover:shadow-md"
                            >
                        </div>
                        
                        <div class="group">
                            <label for="contact" class="block text-gray-700 font-medium mb-2 transition-all duration-300 group-focus-within:text-primary">
                                <i class="fas fa-phone mr-2"></i>Contact #:
                            </label>
                            <input 
                                type="text" 
                                name="contact" 
                                id="contact" 
                                placeholder="Enter your contact number" 
                                class="w-full bg-white border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 shadow-sm hover:shadow-md"
                            >
                        </div>

                        <div class="flex justify-center gap-4 mt-8 pt-6 border-t border-gray-100">
                            <button type="submit" id="update-btn" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-50">
                                <i class="fas fa-save mr-2"></i>Update Profile
                            </button>
                            <a href="/profile" class="bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
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

        <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_auth/verification_status.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_data/fetch_user_data.js'); ?>"></script>
    </body>
</html>