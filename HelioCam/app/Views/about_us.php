<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <title>About Us | HelioCam</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
    <link rel="alternate icon" href="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'><path fill='%23FF8C42' d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm1-11h-2V7h2v2zm0 4h-2v-2h2v2zm0 4h-2v-2h2v2z'/></svg>" type="image/svg+xml">
    <script>
        // Set page-specific favicon for better tab identification
        const pageIcon = document.createElement('link');
        pageIcon.rel = 'icon';
        pageIcon.href = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="%23FF8C42" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 7c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4zm6 5H6v-.99c.2-.72 3.3-2.01 6-2.01s5.8 1.29 6 2v1z"/></svg>';
        pageIcon.type = 'image/svg+xml';
        document.head.appendChild(pageIcon);
    </script>
    
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
                            700: '#C2410C',
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
    <!-- Standard Navigation Bar -->
    <nav class="bg-primary-500 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/home" class="flex items-center">
                <img src="<?= base_url('/assets/images/Helio-Logo.png'); ?>" class="h-10 w-auto" alt="HelioCam Logo">
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

    <!-- Hero Section with darker colors -->
    <section class="bg-gradient-to-br from-gray-950 to-gray-900 text-white py-24">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-10">
                <div class="lg:w-1/2 text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">About <span class="text-primary-500">HelioCam</span></h1>
                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">We're a team of innovators dedicated to transforming how you monitor and secure what matters most.</p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="/hostsession" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-medium transition">
                            Get Started
                        </a>
                        <a href="#learn-more" class="bg-transparent border border-white hover:bg-white hover:text-gray-900 text-white px-6 py-3 rounded-lg font-medium transition">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 flex justify-center">
                    <img src="<?= base_url('/assets/images/Helio-Logo.png'); ?>" class="w-64 h-64 object-contain" alt="HelioCam Logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section id="learn-more" class="py-20 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Story</h2>
                <div class="w-20 h-1 bg-primary-500 mx-auto mb-6"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">HelioCam was born from a desire to make home monitoring accessible, user-friendly, and secure for everyone.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1">
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">HelioCam Monitoring System</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">HelioCam transforms your device into a versatile home monitoring system that's easy to use and secure. Our peer-to-peer technology ensures your footage remains private while providing real-time alerts and monitoring capabilities.</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-primary-100 rounded-full p-2 mt-1">
                                <i class="fas fa-lock text-primary-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Private P2P Streaming</h4>
                                <p class="text-gray-600 text-sm">Your video feeds are transmitted directly, with no third-party storage.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="bg-primary-100 rounded-full p-2 mt-1">
                                <i class="fas fa-bell text-primary-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Motion Detection</h4>
                                <p class="text-gray-600 text-sm">Get instant alerts when movement is detected in your camera view.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="bg-primary-100 rounded-full p-2 mt-1">
                                <i class="fas fa-mobile-alt text-primary-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Multi-Device Access</h4>
                                <p class="text-gray-600 text-sm">Monitor from anywhere on your phone, tablet, or computer.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-1 md:order-2 bg-gray-100 rounded-3xl p-10 flex justify-center items-center shadow-inner">
                    <img src="<?= base_url('/assets/images/Helio-Logo.png'); ?>" alt="HelioCam Logo" class="w-48 h-48 object-contain transform hover:scale-110 transition duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Company Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="bg-white rounded-3xl p-10 flex justify-center items-center shadow-lg">
                    <img src="<?= base_url('/assets/images/summersoft_logo.png'); ?>" alt="Summersoft Logo" class="w-48 h-48 object-contain transform hover:scale-110 transition duration-500">
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold mb-2 text-gray-800">Our Company</h3>
                    <h2 class="text-3xl md:text-4xl font-bold text-primary-500 mb-4">Summersoft</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">Summersoft is a forward-thinking software development company specializing in creating innovative solutions for businesses and individuals. Our team of experienced developers is dedicated to building products that make a difference.</p>
                    
                    <!-- Mission & Vision Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
                        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-600 hover:shadow-lg transition">
                            <h4 class="text-xl font-semibold mb-3">Our Mission</h4>
                            <p class="text-gray-600 leading-relaxed">To provide innovative software solutions that help businesses and individuals achieve their goals through technology that's both powerful and accessible.</p>
                        </div>
                        
                        <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-600 hover:shadow-lg transition">
                            <h4 class="text-xl font-semibold mb-3">Our Vision</h4>
                            <p class="text-gray-600 leading-relaxed">To become a leading software development company known for creating cutting-edge solutions that address real-world problems efficiently and elegantly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section with darker shades -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Services</h2>
                <div class="w-20 h-1 bg-primary-500 mx-auto mb-6"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">We offer a comprehensive suite of monitoring solutions designed to meet your security needs.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-400 p-5 group-hover:from-primary-600 group-hover:to-primary-500 transition">
                        <i class="fas fa-video text-4xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">Surveillance System</h3>
                        <p class="text-gray-600">Advanced camera monitoring to detect motion and provide real-time notifications to keep your property secure.</p>
                    </div>
                </div>
                
                <!-- Service Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-400 p-5 group-hover:from-primary-600 group-hover:to-primary-500 transition">
                        <i class="fas fa-history text-4xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">Activity History</h3>
                        <p class="text-gray-600">Comprehensive history of detected motion events, with timestamps and preview images for reference.</p>
                    </div>
                </div>
                
                <!-- Service Card 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-400 p-5 group-hover:from-primary-600 group-hover:to-primary-500 transition">
                        <i class="fas fa-mobile-alt text-4xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">Mobile App</h3>
                        <p class="text-gray-600">Stay connected on the go with our responsive mobile app for remote monitoring and notifications.</p>
                    </div>
                </div>
                
                <!-- Service Card 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-400 p-5 group-hover:from-primary-600 group-hover:to-primary-500 transition">
                        <i class="fas fa-lock text-4xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">Enhanced Security</h3>
                        <p class="text-gray-600">dvanced security protocols and secure access controls ensure your footage remains private and protected at all times.</p>
                    </div>
                </div>
                
                <!-- Service Card 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-400 p-5 group-hover:from-primary-600 group-hover:to-primary-500 transition">
                        <i class="fas fa-headset text-4xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">Customer Support</h3>
                        <p class="text-gray-600">Dedicated technical support team available to help you with setup, troubleshooting, and ongoing assistance.</p>
                    </div>
                </div>
                
                <!-- Service Card 6 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-400 p-5 group-hover:from-primary-600 group-hover:to-primary-500 transition">
                        <i class="fas fa-comments text-4xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-3">User Feedback</h3>
                        <p class="text-gray-600">We actively collect and implement user feedback to continuously improve our products and services.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Team</h2>
                <div class="w-20 h-1 bg-primary-500 mx-auto mb-6"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Meet the passionate individuals behind HelioCam who make it all possible.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member Cards (kept as is) -->
                <!-- Team Member 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="p-1 bg-gradient-to-r from-primary-500 to-primary-400"></div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <img src="<?= base_url('/assets/images/CEO.png'); ?>" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow" alt="Miguel A. Sta.Maria">
                            <div>
                                <h3 class="text-xl font-bold">Miguel A. Sta.Maria</h3>
                                <p class="text-primary-500 font-medium">CEO/Developer</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <p class="text-gray-600 italic">"De eroplano de bangga sa cambal na bilding."</p>
                        </div>
                        <div class="mt-4 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="p-1 bg-gradient-to-r from-primary-500 to-primary-400"></div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <img src="<?= base_url('/assets/images/CTO.png'); ?>" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow" alt="Eufredo T. Alto">
                            <div>
                                <h3 class="text-xl font-bold">Eufredo T. Alto</h3>
                                <p class="text-primary-500 font-medium">CTO/Business Analyst</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <p class="text-gray-600 italic">"Lorem lorem lorem ipsum, phuno ng papaya."</p>
                        </div>
                        <div class="mt-4 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="p-1 bg-gradient-to-r from-primary-500 to-primary-400"></div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <img src="<?= base_url('/assets/images/COO.png'); ?>" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow" alt="David Olimberio">
                            <div>
                                <h3 class="text-xl font-bold">David Olimberio</h3>
                                <p class="text-primary-500 font-medium">COO/Business Analyst</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <p class="text-gray-600 italic">"Mollitia quas, hindi ka niya millitia."</p>
                        </div>
                        <div class="mt-4 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="p-1 bg-gradient-to-r from-primary-500 to-primary-400"></div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <img src="<?= base_url('/assets/images/Tester.png'); ?>" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow" alt="Wimari L. Bautista">
                            <div>
                                <h3 class="text-xl font-bold">Wimari L. Bautista</h3>
                                <p class="text-primary-500 font-medium">Tester</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <p class="text-gray-600 italic">"Expedita cupal tempora distinctio perferendis indio."</p>
                        </div>
                        <div class="mt-4 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 5 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="p-1 bg-gradient-to-r from-primary-500 to-primary-400"></div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <img src="<?= base_url('/assets/images/Designer.png'); ?>" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow" alt="Nhiko B. Bragais">
                            <div>
                                <h3 class="text-xl font-bold">Nhiko B. Bragais</h3>
                                <p class="text-primary-500 font-medium">Designer</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <p class="text-gray-600 italic">"Leit titia quas vitae, porque con de guo."</p>
                        </div>
                        <div class="mt-4 flex space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer with darker colors -->
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

    <!-- Scripts -->
    <script src="<?= base_url('/assets/js/bootstrap.bundle.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
    <script type="module" src="<?= base_url('/assets/firebase_auth/verification_status.js'); ?>"></script>
    
    <script>
    // Simple animations on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll('.bg-white.rounded-xl');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeIn');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3
        });
        
        animatedElements.forEach(element => {
            observer.observe(element);
        });
    });
    
    // Add this to your style section or inline style
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fadeIn {
                animation: fadeIn 0.6s ease-out forwards;
            }
        </style>
    `);
    </script>
</body>
</html>