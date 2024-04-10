<?php
function layout_navigation($dbContext)
{
    ?>
    <section class="navigation">
        <section class="navigation__wrapper">
            <img class="navigation__logo" src="./../assets/chefschoice.png"></img>
            <div class="navigation__user">


                <a class="navigation__user-link" href="/user/login">
                    Log in

                </a>


                <a class="navigation__user-link" href="/user/register">
                    Register
                </a>


                <a class="navigation__user-link" href="/user/logout">
                    Log out
                </a>
        </section>


        </div>
    </section>
    <?php
}
?>