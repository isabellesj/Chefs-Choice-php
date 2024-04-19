<?php
require 'vendor/autoload.php';
require_once ('Models/Database.php');
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");

$sortCol = $_GET['sortCol'] ?? "";
$q = $_GET['q'] ?? "";

$dbContext = new DbContext();
$message = "";
$username = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $dbContext->getUsersDatabase()->getAuth()
            ->login($username, $password);
        header('Location: /');
        exit;
    } catch (Exception $e) {
        $message = "Could not login";
    }
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
    <link href="/css/style.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/2471abcbe0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    layout_navigation($dbContext);
    echo $dbContext->getUsersDatabase()->getAuth()->isLoggedIn();
    ?>

    <div class="login">
        <section class="login__wrapper">
            <div class="login__message__wrapper">
                <h2>Log in:
                    <?php echo " $message"; ?>
                </h2>
                <a class="cancel__link" href="/"><i class="fa-solid fa-xmark"></i></a>
            </div>
            <form method="post" class="form">
                <div class=username__wrapper>
                    <label for="name">Username</label>
                    <input class="login__input" type="text" name="username" value="<?php echo $username ?>">
                </div>
                <div class=password__wrapper>
                    <label for="name">Password</label>
                    <input class="login__input" type="password" name="password">
                </div>
                <div class="login__submit__wrapper">
                    <button class="login__button" type="submit">Log in</button>
                    <a class="forgot__password__link" href="/user/forgotpassword">Forgot password?</a>
                    <a class="register__link" href="/user/register">Register</a>
                </div>
            </form>
        </section>
    </div>

    <?php
    layout_footer();
    ?>

</body>

</html>