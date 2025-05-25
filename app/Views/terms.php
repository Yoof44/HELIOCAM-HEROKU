<!DOCTYPE html>
<html data-theme="cupcake" class="scroll-smooth" lang="en" dir="ltr">
<head>
    <title>Terms of Service | HelioCam</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Updated favicon with proper path using base_url -->
    <link rel="icon" type="image/x-icon" href="/assets/images/Helio-Logo.ico" sizes="any">
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
    
    <!-- Bootstrap is needed for modals -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.css'); ?>">
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-b from-amber-50 to-orange-50">
        <!-- Navigation Bar - Orange -->
    <nav class="bg-primary-500 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/home" class="flex items-center">
                <img src="/assets/images/Helio-Logo.png" class="h-10 w-auto" alt="HelioCam Logo">
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
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Terms of Service</h1>
            <p class="text-orange-100">Last updated: March 07, 2025</p>
        </div>
    </div>

    <!-- Terms Content -->
    <div class="container mx-auto max-w-3xl px-4 py-10">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-700 mb-6 leading-relaxed">
                Please read these terms carefully before using Our Service.
            </p>
            <div class="space-y-10">
                <!-- Section 1 -->
                 <div>
                    <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">
                        Interpretation and Definitions
                    </h2>
                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-2">
                        Interpretation
                    </h3>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        The words of which the initial letter is capitalized have meanings defined under the following conditions. 
                        The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.
                    </p>
                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-2">
                        Definitions
                    </h3>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        For the purposes of this Privacy Policy:
                    </p>
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
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold text-gray-900">Terms</span>mean these Terms that form the entire agreement between You and the Company regarding the Service.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold text-gray-900">Third-party Social Media Service</span> means any services or content (including data, information, products, or services) provided by a third-party that may be displayed, included, or made available by the Service.
                            </div>
                        </li>
                        <li class="flex">
                            <span class="text-primary-500 mr-2">•</span>
                            <div>
                                <span class="font-semibold text-gray-900">You</span> means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.
                            </div>
                        </li>
                    </ul>
                 </div>
                 <!-- Section 2 -->
                  <div>
                    <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">
                        Acknowledgment
                    </h2>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        These are the Terms and Conditions governing the use of this Service and the agreement that operates between You and the Company.
                        These Terms set out the rights and obligations of all users regarding the use of the Service.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Your access to and use of the Service is conditioned on Your acceptance of and compliance with these Terms.
                        These Terms apply to all visitors, users, and others who access or use the Service.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        By accessing or using the Service You agree to be bound by these Terms.
                        If You disagree with any part of these Terms then You may not access the Service.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        You represent that you are over the age of 18.
                        The Company does not permit those under 18 to use the Service.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Your access to and use of the Service is also conditioned on Your acceptance of and compliance with the Privacy Policy of the Company.
                        Our Privacy Policy describes Our policies and procedures on the collection, use, and disclosure of Your information when You use the Application and tells You about Your privacy rights and how the law protects You.
                    </p>
                  </div>
                    <!-- Section 3 -->
                    <div>
                        <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">
                        Links to Other Websites
                        </h2>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            The Company has no control over, and assumes no responsibility for, the content, privacy policies, 
                            or practices of any third party web sites or services. You further acknowledge and agree that the Company shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such content, goods or services available on or through any such web sites or services.
                        </p>
                    </div>
                    <!-- Section 4 -->
                    <div>
                        <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">
                        Termination
                        </h2>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            We may terminate or suspend Your access immediately, without prior notice or liability, for any reason whatsoever, including without limitation if You breach these Terms.
                            Upon termination, Your right to use the Service will cease immediately.
                        </p>
                    </div>
                    <!-- Section 5 -->
                    <div>
                        <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">
                            Limitation of Liability
                        </h2>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            To the maximum extent permitted by applicable law, in no event shall the Company or its suppliers be liable for any special, incidental, indirect, 
                            or consequential damages whatsoever (including, but not limited to, damages for loss of profits, loss of data or other information, for business interruption, 
                            for personal injury, loss of privacy arising out of or in any way related to the use of or inability to use the Service, third-party software and/or third-party hardware used with the Service, 
                            or otherwise in connection with any provision of this Terms), even if the Company or any supplier has been advised of the possibility of such damages and even if the remedy fails of its essential purpose.
                        </p>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                        Some states do not allow the exclusion of implied warranties or limitation of liability for incidental or consequential damages, which means that some of the above limitations may not apply. 
                        In these states, each party's liability will be limited to the greatest extent permitted by law.
                        </p>
                    </div>
                    <!-- Section 6 -->
                    <div>
                        <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">
                            "AS IS" and "AS AVAILABLE" Disclaimer
                        </h2>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            The Service is provided to You "AS IS" and "AS AVAILABLE" and with all faults and defects without warranty of any kind.
                            To the maximum extent permitted by applicable law, the Company, on its own behalf and on behalf of its Affiliates and its and their respective licensors and service providers, 
                            expressly disclaims all warranties, whether express, implied, statutory or otherwise, with respect to the Service, including all implied warranties of merchantability, fitness for a particular purpose, title and non-infringement, 
                            and warranties that may arise out of course of dealing, course of performance, usage or trade practice. 
                            Without limitation to the foregoing, the Company provides no warranty or undertaking, and makes no representation of any kind that the Service will meet Your requirements, achieve any intended results, be compatible or work with any other software, applications, systems or services, operate without interruption, meet any performance or reliability standards or be error free or that any errors or defects can or will be corrected.
                        </p>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            Without limiting the foregoing, neither the Company nor any of the company's provider makes any representation or warranty of any kind, 
                            express or implied: (i) as to the operation or availability of the Service, or the information, content, and materials or products included thereon; 
                            (ii) that the Service will be uninterrupted or error-free; (iii) as to the accuracy, reliability, or currency of any information or content provided through the Service; 
                            or (iv) that the Service, its servers, the content, or e-mails sent from or on behalf of the Company are free of viruses, scripts, trojan horses, worms, malware, timebombs 
                            or other harmful components.
                        </p>
                    </div>
                    <!-- Section 7 -->
                    <div>
                        <h2 class="text-2xl font-semibold text-primary-500 mb-4 pb-2 border-b border-gray-200">
                            Changes to These Terms and Conditions
                        </h2>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            We reserve the right, at Our sole discretion, to modify or replace these Terms at any time. If a revision is material We will make reasonable efforts to provide at least 30 days' notice prior to any new terms taking effect. 
                            What constitutes a material change will be determined at Our sole discretion.
                        </p>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                        By continuing to access or use Our Service after those revisions become effective, You agree to be bound by the revised terms. If You do not agree to the new terms, in whole or in part, 
                        please stop using the website and the Service.
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


    <!-- Footer -->
    <footer class="bg-gradient-to-r from-primary-500 to-primary-400 text-white py-6 px-4 mt-10">
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
        <script type="module" src="<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_auth/verification_status.js'); ?>"></script>
        <script type="module" src="<?= base_url('/assets/firebase_webrtc/create_session.js'); ?>"></script>
    
</body>


</html>