<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= lang('Errors.badRequest') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/ico" href="<?= base_url('public/assets/css/Helio-Logo.ico') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
 
</head>
<body class="flex flex-col min-h-screen bg-amber-50">
<div class="flex-grow flex flex-col items-center justify-center px-4 py-12">
    <div class="bg-[#FF8C42] p-6 flex flex-col justify-center text-white rounded-2xl shadow-xl overflow-hidden w-full max-w-md">

        <h1 class="text-5x1 font-semibold text-gray-200 mb-5">400</h1>

        <p class="text-gray-500 text-sm mb-3">
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                <?= lang('Errors.sorryBadRequest') ?>
            <?php endif; ?>
        </p>
    </div>
    <div class="">
        <button onclick="window.history.back()" class="bg-[#FF8C42] text-white font-bold py-2 px-4 rounded hover:bg-gray-900 hover:text-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-400 transition duration-300 ease-in-out">
        <i class="fas fa-arrow-left"></i> <?= lang('Errors.back') ?>
        </button>
    </div>
</div>
</body>
</html>
