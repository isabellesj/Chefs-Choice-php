<?php
require 'vendor/autoload.php';
require_once ('Models/Database.php');
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");

$dbContext = new DbContext();

try {
    $dbContext->getUsersDatabase()->getAuth()->canResetPasswordOrThrow($_GET['selector'], $_GET['token']);

    echo 'Put the selector into a "hidden" field (or keep it in the URL)';
    echo 'Put the token into a "hidden" field (or keep it in the URL)';

    echo 'Ask the user for their new password';
} catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    die('Invalid token');
} catch (\Delight\Auth\TokenExpiredException $e) {
    die('Token expired');
} catch (\Delight\Auth\ResetDisabledException $e) {
    die('Password reset is disabled');
} catch (\Delight\Auth\TooManyRequestsException $e) {
    die('Too many requests');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Chef's Choice</title>
    <script src="https://kit.fontawesome.com/2471abcbe0.js" crossorigin="anonymous"></script>
    <link href="/css/style.css" rel="stylesheet" />
</head>

<body>
    <main>
        <div class="top-header">
            <div class="logo">
                <a href="index.html"> <img src="/images/rocket.png"></a>
            </div>
            <div>
                <label for="active" class="menu-btn">
                    <i class="fas fa-bars" id="menu"></i>
                </label>
            </div>
        </div>

        <div class="content">


            Your email adress is now verified!
        </div>

        </div>


    </main>



    <?php
    layout_footer();
    ?>

</body>

</html>