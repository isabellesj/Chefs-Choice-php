<?php
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ("Pages/layout/categories.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");

$q = $_GET['q'] ?? "";

$dbContext = new DbContext();
$message = "";
$username = "";
$registeredOk = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO:Add validation - redan registrerad, password != passwordAgain
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username, function ($selector, $token) {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.ethereal.email';
            $mail->SMTPAuth = true;
            $mail->Username = 'virginia91@ethereal.email';
            $mail->Password = 'VjQ1fE6EyXT6VhaEAR';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->From = "noreply@chefschoice.com";
            $mail->FromName = "Chef";
            $mail->addAddress($_POST['username']); //Address to which recipient will reply 
            $mail->addReplyTo("info@chefschoice.com", "No-Reply"); //CC and BCC 
            $mail->isHTML(true);
            $mail->Subject = "Chef's Choice - verify email";
            $url = 'http://localhost:8000/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $mail->Body = "
            <h2>Hi!</h2>
            <p>Thank you for signing up. Please verify your email address by clicking the following link: <a href='$url'>$url</a></p>
            <p>If you are having any issues, please don't hesitate to contact us.</p>
            <p>Do you have any problems or need help? <br> 
            Please contact info@chefschoice.com</p>";
            $mail->send();
        });
        $registeredOk = true;
    } catch (\Delight\Auth\InvalidEmailException $e) {
        $message = "Incorrect email";
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        $message = "Invalid password";
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
        $message = "User already exist";
    } catch (\Exception $e) {
        $message = "Something went wrong";
    }
    //header('Location: /user/registerthanks');
    //exit;
//}
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
    ?>

    <main>

        <div class="content">
            <?php if ($registeredOk) {

                ?>
                <div>Thank you for registering. Please check your email inbox for a message from us containing a
                    verification link to complete your registration process.</div>

                <?php
            } else {
                ?>

                <div class="register">
                    <section class="register__wrapper">
                        <div class="register__message__wrapper">
                            <h2>Register:
                                <?php echo $message; ?>
                            </h2>
                            <a class="cancel__link" href="/user/login"><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <form method="post" class="form">
                            <div class="username__wrapper">
                                <label for="name">Username</label>
                                <input class="register__input" type="username" name="username">
                            </div>
                            <div class="password__wrapper">
                                <label for="name">Password</label>
                                <input class="register__input" type="password" name="password">
                            </div>
                            <div class="password__wrapper">
                                <label for="name">Password again</label>
                                <input class="register__input" type="password" name="passwordAgain">
                            </div>
                            <div class="register__submit__wrapper">
                                <button class="register__button" type="submit" value="Register">
                                    <a class="cancelreg" href="/user/registerthanks">Register</a>
                                </button>
                            </div>
                        </form>

                        <?php
            }
            ?>
                </section>
            </div>


    </main>



    <?php
    layout_footer();
    ?>

</body>

</html>