<!DOCTYPE html>
<html class="scroll-smooth" lang="en" dir="ltr">

<head>
    <title>HelioCam| Register </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-left: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen bg-amber-50">
    <div class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full max-w-4xl">
            <div class="flex flex-col md:flex-row">
                <!-- Left side - Brand Content -->
                <div class="bg-[#FF8C42] md:w-2/5 p-8 flex flex-col justify-center text-white">
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold mb-2">Helio<span class="text-gray-800">Cam</span></h1>
                        <h2 class="text-xl font-light">See your future for better security</h2>
                    </div>
                    <div class="hidden md:block">
                        <p class="mb-6 text-sm opacity-90">Join our community and experience enhanced security with our advanced surveillance solution.</p>
                        <div class="flex items-center justify-center mt-8">
                            <img src="/assets/images/Helio-Logo.png" class="h-24 w-auto" alt="HelioCam Logo">
                        </div>
                    </div>
                </div>

                <!-- Right side - Registration Form -->
                <div class="md:w-3/5 p-8 md:p-10 overflow-y-auto max-h-[700px]">
                    <div class="mb-6">
                        <h2 class="text-3xl font-semibold text-gray-800">Create Account</h2>
                        <p class="text-gray-500 mt-2">Please fill in your details to register</p>
                    </div>

                    <form class="space-y-4">
                        <div>
                            <label for="fname" class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="fname" 
                                    name="fname" 
                                    value="aaa"
                                    placeholder="Please type your full name..." 
                                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="uname" class="block text-gray-700 font-medium mb-2">Username</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-user-tag"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="uname" 
                                    name="uname" 
                                    value="bbb"
                                    placeholder="Please type your username..." 
                                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="contact" class="block text-gray-700 font-medium mb-2">Contact #</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="contact" 
                                    name="contact" 
                                    value="123"
                                    placeholder="Please type your contact #..." 
                                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="iisakki331@gmail.com"
                                    placeholder="Please type your email address..." 
                                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    value="facade12"
                                    placeholder="Please type your password..." 
                                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="con_pass" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input 
                                    type="password" 
                                    id="con_pass" 
                                    name="con_pass" 
                                    value="facade12"
                                    placeholder="Please confirm your password..." 
                                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                                >
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" id="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-lg transition transform hover:-translate-y-0.5 flex items-center justify-center">
                                <span id="loginText">Register</span>
                                <span id="spinner" class="spinner" style="display: none;"></span>
                            </button>
                        </div>
                        
                        <div class="text-center pt-2">
                            <p class="text-gray-600">Already have an account? 
                                <a href="/" class="text-orange-500 hover:text-orange-600 font-medium">Login here</a>
                            </p>
                        </div>
                    </form>
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
    <script src="public/assets/js/bootstrap.js"></script>
    <script type="module" src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js"></script>
    <script type="module" src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth.js"></script>
    <script type="module" src="https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/register_user.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
</body>
</html>