<!DOCTYPE html>
<html>
<head>
    <title>404</title>
</head>
<body>
    <h1>404 - Page Not Found</h1>
    <p>Requested Path: <?php echo e(request()->path()); ?></p>
    <a href="<?php echo e(route('home')); ?>">Back to Home</a>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/errors/404.blade.php ENDPATH**/ ?>