<?php
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');
require_once ("Pages/layout/categories.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");
require_once ("Functions/doctype.php");
require_once ("Utils/Validator.php");

$q = $_GET['q'] ?? "";
$token = $_GET['token'] ?? "";
$selector = $_GET['selector'] ?? "";

$dbContext = new DbContext();
$message = "";
$username = "";
$password = "";
$passwordAgain = "";
$registeredOk = false;
$v = new Validator($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordAgain = $_POST['passwordAgain'];

    $v->field('username')->required()->email();
    $v->field('password')->required()->min_len(8)->max_len(16)->must_contain('@#$&!')->must_contain('a-z')->must_contain('A-Z')->must_contain('0-9');

    if ($_POST['password'] == $_POST['passwordAgain']) {
        if ($v->is_valid()) {
            try {
                $Username = $_ENV['Username'];
                $Password = $_ENV['Password'];

                $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username, function ($selector, $token) use ($Username, $Password) {
                    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.ethereal.email';
                    $mail->SMTPAuth = true;
                    $mail->Username = $Username;
                    $mail->Password = $Password;
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->From = "noreply@chefschoice.com";
                    $mail->FromName = "Chef's Choice";
                    $mail->addAddress($_POST['username']);
                    $mail->isHTML(true);
                    $mail->Subject = "Chef's Choice - verify email";
                    $url = 'http://localhost:8000/user/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
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
        } else {
            $message = "Fix registration errors";
        }
    } else {
        $message = "Password does not match";
    }
}


doctype();
?>

<body>

    <?php
    layout_navigation($dbContext);
    ?>

    <main>
        <?php if ($registeredOk) {

            ?>
            <div class="register__account__wrapper">
                <p class="register__email-text">Thank you for registering. Please check your email inbox for a message from
                    us containing a verification link to complete your registration process.</p>
            </div>
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
                            <input class="register__input" type="text" value="<?php echo $username ?>" name="username">
                        </div>
                        <div class="password__wrapper">
                            <label for="name">Password</label>
                            <input class="register__input" type="password" value="<?php echo $password ?>" name="password">
                        </div>
                        <div class="password__wrapper">
                            <label for="name">Password again</label>
                            <input class="register__input" type="password" value="<?php echo $passwordAgain ?>"
                                name="passwordAgain">
                        </div>
                        <div class="register__submit__wrapper">
                            <button class="register__button" type="submit" value="Register">
                                Register
                            </button>
                        </div>
                    </form>

                    <?php
        }
        ?>
            </section>


    </main>



    <?php
    layout_footer();
    ?>

</body>

</html>