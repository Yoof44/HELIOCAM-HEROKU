@ -0,0 +1,73 @@
<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta charset="utf-8">
<head>
        
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="shortcut icon" type="image/ico" href="public/assets/css/Helio-Logo.ico">
        <link rel="stylesheet" href="./output.css">
        <link rel="stylesheet" href="public/assets/css/bootstrap.css">
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




<footer>
        <p>© 2025 HelioCam. All Rights Reserved.</p> 
        <div>
        <p class="made">Made with 
         | <a href="">Summersoft</a></p>
        <p>Follow us:</p>
        <ul class="flex list-none">
        <li><a href="">
        <i class="fab fa-facebook text-orange-300 text-2xl"></i>
        </li></a>
        <li><a href="">
        <i class="fab fa-instagram text-orange-300 text-2xl"></i>
        </li></a>
        <li><a href="">
        <i class="fab fa-twitter text-orange-300 text-2xl"></i>
        </li></a>
        <li><a href="">
        <i class="fab fa-linkedin text-orange-300 text-2xl"></i>
        </li></a>
        </ul> 
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