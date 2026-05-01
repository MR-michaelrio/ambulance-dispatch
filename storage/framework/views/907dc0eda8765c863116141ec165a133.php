<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Ambulance Dispatch GMCI')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN (NO VITE) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Force light mode on guest pages: opt into class strategy and never add the class.
        tailwind.config = { darkMode: 'class' };
    </script>
    <style>
        html { color-scheme: light !important; }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <div>
            <a href="/">
                <h1 class="text-2xl font-bold text-blue-600">
                    Ambulance Dispatch GMCI
                </h1>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <?php echo e($slot); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH /Applications/Dev/ambulance-dispatch/resources/views/layouts/guest.blade.php ENDPATH**/ ?>