<?php
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ("Pages/layout/categories.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");

$q = $_GET['q'] ?? "";

$dbContext = new DbContext();
$message = "";
$resetOk = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //ie("hej");
    $username = $_POST['username'];

    try {
        $dbContext->getUsersDatabase()->getAuth()->forgotPassword($_POST['username'], function ($selector, $token) {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.ethereal.email';
            $mail->SMTPAuth = true;
            $mail->Username = 'virginia91@ethereal.email';
            $mail->Password = 'VjQ1fE6EyXT6VhaEAR';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //det här ska finnas i .env

            $mail->From = "noreply@chefschoice.com";
            $mail->FromName = "Chef";
            $mail->addAddress($_POST['username']);
            $mail->addReplyTo("reset@chefschoice.com", "No-Reply");
            $mail->isHTML(true);
            $mail->Subject = "Chef's Choice - reset password";
            $url = 'http://localhost:8000/user/reset_password?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $mail->Body = "
            <h2>Password reset</h2>
            <p>If you've lost your password or wish to reset it, click <a href=''$url'>$url'>here</a> to get started</p>";
            $mail->send();
        });
        $resetOk = true;
    } catch (\Delight\Auth\InvalidEmailException $e) {
        $message = "Invalid email address";
    } catch (\Delight\Auth\EmailNotVerifiedException $e) {
        $message = "Email not verified";
    } catch (\Delight\Auth\ResetDisabledException $e) {
        $message = "Password reset is disabled";
    } catch (\Delight\Auth\TooManyRequestsException $e) {
        $message = "Too many requests";
    } catch (\Exception $e) {
        $message = "Something went wrong";
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
    <script src="https://kit.fontawesome.com/2471abcbe0.js" crossorigin="anonymous"></script>
    <link href="/css/style.css" rel="stylesheet" />
</head>

<body>
    <?php
    layout_navigation($dbContext);
    echo $message;
    ?>
    <main>
        <?php if ($resetOk) {
            ?>
            <div>Please check your email inbox for a message from us containing a verification link to reset your password.
            </div>
            <?php
        } else {
            ?>

            <form method="post" class="form">
                <div class="username__wrapper">
                    <label for="name">Username</label>
                    <input class="register__input" type="email" name="username" />
                </div>
                <div class="register__submit__wrapper">
                    <button class="reset__button" type="submit" value="Skicka">
                        reset password
                    </button>
                </div>
            </form>
            <?php
        }
        ?>
        <?php
        layout_footer();
        ?>
    </main>
</body>

</html>