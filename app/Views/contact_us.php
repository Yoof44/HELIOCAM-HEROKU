<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <title>Contact Us | HelioCam</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

<body class="font-sans antialiased text-gray-800 bg-gray-50 min-h-screen flex flex-col">
    <!-- Navigation Bar - Darker Orange -->
    <nav class="bg-primary-500 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/home" class="flex items-center">
                <img src="<?= base_url('/assets/images/Helio-Logo.png'); ?>" class="h-10 w-auto" alt="HelioCam Logo">
            </a>
            
            <ul class="flex items-center space-x-6">
                <li>
                    <a href="/home" class="text-orange-100 hover:text-white transition">
                        <i class="fas fa-home text-2xl"></i>
                    </a>
                </li>
                <li>
                    <a href="/history" class="text-orange-100 hover:text-white transition">
                        <i class="fas fa-clock text-2xl"></i>
                    </a>
                </li>
                <li>
                    <a href="/notification" class="text-orange-100 hover:text-white transition">
                        <i class="fas fa-bell text-2xl"></i>
                    </a>
                </li>
            </ul>
            
            <ul class="flex items-center space-x-6">
                <li>
                    <a href="/profile" class="text-orange-100 hover:text-white transition">
                        <i class="fas fa-user text-2xl"></i>
                    </a>
                </li>
                <li>
                    <a href="/settings" class="text-orange-100 hover:text-white transition">
                        <i class="fas fa-cog text-2xl"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-400 text-white py-12 px-4">
        <div class="container mx-auto max-w-4xl">
            <h1 class="text-3xl md:text-4xl font-bold">Contact Us</h1>
            <p class="mt-2 text-orange-100 max-w-2xl">We're here to help! Send us a message and our team will respond as soon as possible.</p>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="container mx-auto max-w-4xl px-4 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5">
                <!-- Left side - Contact Info -->
                <div class="bg-gradient-to-br from-primary-500 to-primary-400 p-8 text-white lg:col-span-2">
                    <h2 class="text-2xl font-semibold mb-6">Get in Touch</h2>
                    
                    <div class="space-y-6">
                        <p class="text-sm opacity-90 leading-relaxed">
                            We value your feedback and are always here to assist you. If you have any concerns, questions, or suggestions, please reach out to us through any of these channels.
                        </p>
                        
                        <div class="space-y-4 mt-8">
                            <div class="flex items-start space-x-3">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mt-1">
                                    <i class="fas fa-phone text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Phone Support</h3>
                                    <p class="text-sm opacity-90 mt-1">0910-123-4567 (Management Office)</p>
                                    <p class="text-sm opacity-90">0999-888-7777 (Customer Service)</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mt-1">
                                    <i class="fas fa-envelope text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Email</h3>
                                    <p class="text-sm opacity-90 mt-1">summersoft@gmail.com</p>
                                    <p class="text-sm opacity-90">support@heliocam.com</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="bg-white bg-opacity-20 rounded-full p-2 mt-1">
                                    <i class="fas fa-map-marker-alt text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Office Location</h3>
                                    <p class="text-sm opacity-90 mt-1">123 HelioCam Street, Legazpi City</p>
                                    <p class="text-sm opacity-90">Albay, Philippines 4500</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-8">
                            <h3 class="font-medium mb-3">Connect With Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-9 h-9 flex items-center justify-center transition">
                                    <i class="fab fa-facebook-f text-white"></i>
                                </a>
                                <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-9 h-9 flex items-center justify-center transition">
                                    <i class="fab fa-twitter text-white"></i>
                                </a>
                                <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-9 h-9 flex items-center justify-center transition">
                                    <i class="fab fa-instagram text-white"></i>
                                </a>
                                <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-9 h-9 flex items-center justify-center transition">
                                    <i class="fab fa-linkedin-in text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right side - Contact Form -->
                <div class="p-8 lg:col-span-3">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Send us a message</h2>
                    
                    <form class="space-y-6">
                        <div>
                            <label for="fullname" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="fullname" 
                                    name="fullname" 
                                    placeholder="Your full name"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition bg-white" 
                                    required
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    placeholder="your.email@example.com"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition bg-white" 
                                    required
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="subject" 
                                    name="subject" 
                                    placeholder="What is this regarding?"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition bg-white"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message</label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-comment"></i>
                                </span>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    rows="5" 
                                    placeholder="Please tell us how we can help..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition bg-white" 
                                    required
                                ></textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button 
                                type="submit" 
                                class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition shadow-sm hover:shadow flex items-center space-x-2"
                            >
                                <span>Send Message</span>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="container mx-auto max-w-4xl px-4 py-8 mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Frequently Asked Questions</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800 mb-2">How do I start using HelioCam?</h3>
                <p class="text-sm text-gray-600">Simply create an account, set up your first session, and follow the easy step-by-step instructions to begin monitoring your space.</p>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800 mb-2">Is HelioCam secure to use?</h3>
                <p class="text-sm text-gray-600">Yes, HelioCam uses advanced security protocols to ensure your camera feeds remain private and secure.</p>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800 mb-2">How quickly will you respond to my message?</h3>
                <p class="text-sm text-gray-600">Our support team typically responds within 24-48 business hours after receiving your inquiry.</p>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800 mb-2">Can I use HelioCam on multiple devices?</h3>
                <p class="text-sm text-gray-600">Absolutely! HelioCam works across various devices including smartphones, tablets, and computers.</p>
            </div>
        </div>
    </div>

    <!-- Footer - Darker Orange -->
    <footer class="bg-gradient-to-r from-primary-500 to-primary-400 text-white py-8 px-4 mt-auto">
        <div class="container mx-auto max-w-4xl">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Left side content -->
                <div class="self-start md:self-center mb-4 md:mb-0">
                    <img src="<?= base_url('/assets/images/Helio-Logo.png'); ?>" class="h-10 w-auto mb-3" alt="HelioCam Logo">
                    <p class="mb-1">&copy; 2025 HelioCam. All Rights Reserved.</p>
                    <p class="text-xs opacity-80">Made with <span class="text-red-300">♥</span> | <a href="" class="text-orange-200 hover:text-white">Summersoft</a></p>
                </div>
                
                <!-- Right side content -->
                <div class="self-end md:self-center">
                    <p class="text-sm mb-2 text-right">Connect with us:</p>
                    <ul class="flex justify-end space-x-4">
                        <li><a href="" class="text-orange-200 hover:text-white transition"><i class="fab fa-facebook text-xl"></i></a></li>
                        <li><a href="" class="text-orange-200 hover:text-white transition"><i class="fab fa-instagram text-xl"></i></a></li>
                        <li><a href="" class="text-orange-200 hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a></li>
                        <li><a href="" class="text-orange-200 hover:text-white transition"><i class="fab fa-linkedin text-xl"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('/assets/js/bootstrap.bundle.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/verification_status.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_webrtc/create_session.js'); ?>"></script>
</body>
</html>