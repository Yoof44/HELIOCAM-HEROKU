<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <title>Privacy Policy | HelioCam</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
    <link rel="apple-touch-icon" href="<?= base_url('/assets/images/Helio-Logo.png'); ?>">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <!-- Bootstrap for modals -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.css'); ?>">
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

    <!-- Simple Page Header with Gradient -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-400 text-white py-10">
        <div class="container mx-auto max-w-3xl px-4">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Privacy Policy</h1>
            <p class="text-orange-100">Last updated: March 07, 2025</p>
        </div>
    </div>

    <!-- Simplified Policy Content -->
    <div class="container mx-auto max-w-3xl px-4 py-10">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-700 mb-6 leading-relaxed">
                This Privacy Policy describes Our policies and procedures on the collection, 
                use and disclosure of Your information when You use the Service and tells 
                You about Your privacy rights and how the law protects You.
            </p>
            
            <p class="text-gray-700 mb-8 leading-relaxed">
                We use Your Personal data to provide and improve the Service. By using the Service, 
                You agree to the collection and use of information in accordance with this Privacy Policy.
            </p>
            
            <div class="space-y-10">
                <!-- Section 1 -->
                <div>
                    <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">Interpretation and Definitions</h2>
                    
                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-2">Interpretation</h3>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        The words of which the initial letter is capitalized have meanings defined under the following conditions. 
                        The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.
                    </p>
                    
                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-2">Definitions</h3>
                    <p class="text-gray-700 mb-4 leading-relaxed">For the purposes of this Privacy Policy:</p>
                    
                    <ul class="space-y-4 mb-6 text-gray-700 pl-5">
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold text-gray-900">Account</span> means a unique account created for You to access our Service or parts of our Service.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold text-gray-900">Application</span> means the software program provided by the Company downloaded by You on any electronic device, named HelioCam.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold text-gray-900">Company</span> refers to Summer Soft, J.P. Rizal Extension, West Rembo, Taguig City.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold text-gray-900">Personal Data</span> is any information that relates to an identified or identifiable individual.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold text-gray-900">Service</span> refers to the Application.
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Section 2 -->
                <div>
                    <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">Collecting and Using Your Personal Data</h2>
                    
                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-2">Types of Data Collected</h3>
                    
                    <div class="bg-primary-50 p-5 rounded-lg mb-6 border-l-4 border-primary-500">
                        <h4 class="font-semibold text-lg text-gray-800 mb-3">Personal Data</h4>
                        <p class="text-gray-700 mb-3 leading-relaxed">
                            While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You.
                        </p>
                        <div class="pl-4">
                            <p class="text-gray-700 leading-relaxed">• Email address</p>
                            <p class="text-gray-700 leading-relaxed">• First name and last name</p>
                            <p class="text-gray-700 leading-relaxed">• Phone number</p>
                            <p class="text-gray-700 leading-relaxed">• Address, State, Province, ZIP/Postal code, City</p>
                            <p class="text-gray-700 leading-relaxed">• Usage Data</p>
                        </div>
                    </div>
                    
                    <h4 class="font-semibold text-lg text-gray-800 mt-6 mb-2">Usage Data</h4>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Usage Data is collected automatically when using the Service. This may include information such as Your Device's Internet Protocol address, browser type, the pages you visit, the time and date of your visit, and other diagnostic data.
                    </p>
                </div>
                
                <!-- Section 3 -->
                <div>
                    <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">Use of Your Personal Data</h2>
                    
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        The Company may use Personal Data for the following purposes:
                    </p>
                    
                    <ul class="space-y-3 mb-6 text-gray-700 pl-5">
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold">To provide and maintain our Service</span>, including to monitor the usage of our Service.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold">To manage Your Account</span>: to manage Your registration as a user of the Service.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold">To contact You</span>: To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold">To provide You</span> with news, special offers and general information about other goods, services and events.
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Section 4 -->
                <div>
                    <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">Security of Your Personal Data</h2>
                    
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.
                    </p>
                </div>
                
                <!-- Contact Section -->
                <div>
                    <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">Contact Us</h2>
                    
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        If you have any questions about this Privacy Policy, You can contact us:
                    </p>
                    
                    <div class="flex items-center p-4 bg-primary-50 rounded-lg mb-6">
                        <i class="fas fa-envelope text-primary-500 text-xl mr-4"></i>
                        <span>By email: <a href="mailto:summersoft@gmail.com" class="text-primary-500 hover:text-primary-700 font-medium">summersoft@gmail.com</a></span>
                    </div>
                    
                    <div class="flex items-center p-4 bg-primary-50 rounded-lg">
                        <i class="fas fa-globe text-primary-500 text-xl mr-4"></i>
                        <span>By visiting this page: <a href="/contact_us" class="text-primary-500 hover:text-primary-700 font-medium">Contact Us</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer with Darker Orange -->
    <footer class="bg-gradient-to-r from-primary-500 to-primary-400 text-white py-6 px-4 mt-auto">
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
</body>
</html>