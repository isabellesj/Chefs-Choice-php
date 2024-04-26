<?php
require 'vendor/autoload.php';
require_once ('Models/Database.php');
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");
require_once ("Functions/doctype.php");

$dbContext = new DbContext();
$token = $_GET['token'];
$selector = $_GET['selector'];

try {
    $dbContext->getUsersDatabase()->getAuth()->confirmEmail($_GET['selector'], $_GET['token']);
} catch (Exception $e) {
    $message = "Could not login";
} catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    $message = "Invalid token";
} catch (\Delight\Auth\TokenExpiredException $e) {
    $message = "Token expired";
} catch (\Delight\Auth\UserAlreadyExistsException $e) {
    $message = "Email address already exists";
} catch (\Delight\Auth\TooManyRequestsException $e) {
    $message = "Too many requests";
}

doctype();
?>

<body>
    <?php
    layout_navigation($dbContext);
    ?>
    <main>
        <div class="verifiedaccount__wrapper">
            <p>Your account is now verified! Click here to log in:</p>
            <button class="login__button"><a class="login__link" href="/user/login">Login</a></button>
        </div>


    </main>

    <?php
    layout_footer();
    ?>

</body>

</html>