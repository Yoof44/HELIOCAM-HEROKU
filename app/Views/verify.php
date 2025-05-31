
<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta charset="utf-8">
<head>
        
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="shortcut icon" type="image/ico" href="public/assets/css/Helio-Logo.ico">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
</head>


        <title>HelioCam</title>

 <body class="d-flex vh-100 align-items-center justify-content-center bg-light">

<nav class="navbar">
    <div class="nav-con">
    <a href="/home">
    <img src="/assets/images/Helio-Logo.png" class="logo">
    </a>
      <ul>
        <li class="nav-item">
          <a class="nav-link" id = "logoutButton">Logout</a>
        </li>
      </ul> 
    </div> 
</nav>

<p class="text-center fw-bold text-danger" style="margin-top: 30vh;">
        This user is not verified yet. Check your email and verify. You may refresh this page once verified.
    </p>




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

</body>

<script src = "public/assets/js/bootstrap.js"></script>

<script type="module" src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js"></script>
<script type="module" src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth.js"></script>
<script type="module" src="https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js"></script>

<script type = "module" src="<?= base_url('/assets/firebase_auth/register_user.js'); ?>"></script>
<script type = "module" src = "<?= base_url('/assets/firebase_auth/login_status.js'); ?>"></script>
<script type = "module" src = "<?= base_url('/assets/firebase_auth/logout.js'); ?>"></script>
</html>