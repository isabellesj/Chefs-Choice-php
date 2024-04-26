<?php
require 'vendor/autoload.php';
require_once ('Models/Database.php');
require_once ("Utils/Validator.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");
require_once ("Functions/doctype.php");
require_once ("Utils/Validator.php");

$dbContext = new DbContext();
$v = new Validator($_POST);
$message = "";
$resetOk = false;

try {
    $dbContext->getUsersDatabase()->getAuth()->canResetPasswordOrThrow($_GET['selector'], $_GET['token']);
} catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    $message = "Invalid token";
} catch (\Delight\Auth\TokenExpiredException $e) {
    $message = "Token expired";
} catch (\Delight\Auth\ResetDisabledException $e) {
    $message = "Password reset is disabled";
} catch (\Delight\Auth\TooManyRequestsException $e) {
    $message = "Too many requests";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordAgain = $_POST['passwordAgain'];

    $v->field('password')->required()->min_len(8)->max_len(16)->must_contain('@#$&!')->must_contain('a-z')->must_contain('A-Z')->must_contain('0-9');

    if ($_POST['password'] == $_POST['passwordAgain']) {
        if ($v->is_valid()) {
            try {
                $dbContext->getUsersDatabase()->getAuth()->resetPassword($_POST['selector'], $_POST['token'], $_POST['password']);
                $resetOk = true;
            } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
                $message = "Invalid token";
            } catch (\Delight\Auth\TokenExpiredException $e) {
                $message = "Token expired";
            } catch (\Delight\Auth\ResetDisabledException $e) {
                $message = "Password reset is disabled";
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                $message = "Invalid password";
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                $message = "Too many requests";
            }
        } else {
            $message = "Fix errors";
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
        <?php if ($resetOk) {

            ?>
            <div class="forgotpassword__wrapper">
                <p>Your password is now reset. Click here to log in:</p>
                <button class="login__button"><a class="login__link" href="/user/login">Login</a></button>
            </div>

            <?php
        } else {
            ?>

            <div class="reset">
                <section class="reset__wrapper">
                    <div class="reset__message__wrapper">
                        <h2>Change password:
                            <?php echo $message; ?>
                        </h2>
                        <a class="cancel__link" href="/user/login"><i class="fa-solid fa-xmark"></i></a>
                    </div>
                    <form method="post" class="form">
                        <input type="hidden" name="selector" value="<?php echo $_GET['selector']; ?>">
                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                        <div class="username__wrapper">
                            <label for="name">Username</label>
                            <input class="reset__input" type="text" name="username">
                        </div>
                        <div class="password__wrapper">
                            <label for="name">New password</label>
                            <input class="register__input" type="password" name="password">
                        </div>
                        <div class="password__wrapper">
                            <label for="name">New password again</label>
                            <input class="register__input" type="password" name="passwordAgain">
                        </div>
                        <div class="reset__submit__wrapper">
                            <button class="reset__button" type="submit" value="Reset">
                                Change password
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