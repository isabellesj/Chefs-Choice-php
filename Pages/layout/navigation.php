<?php
function layout_navigation($dbContext)
{
    ?>
    <section class="navigation">
        <section class="navigation__wrapper">
            <a href='/'><img class="navigation__logo" src="./../assets/chefschoice.png"></img></a>
            <?php
            //kolla om diven ens behövs eller om user-info ska bytas till annat namn => var förut navigation__users eller något
            if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
                ?>
                <a class="user__link" href="/user/login">
                    <i id="user__icon" class="fa-solid fa-user"></i>
                </a>
                <?php
            } else {
                ?>
                <div class="logout__wrapper">
                    <i id="shoppingcart" class="fa-solid fa-basket-shopping"></i>
                    <a class="logout__button" href="/user/logout">
                        Log out
                    </a>
                </div>
                <?php

            }

            ?>
        </section>
    </section>
    <?php
}
?>