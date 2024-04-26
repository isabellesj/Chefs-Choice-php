<?php
function layout_navigation($dbContext)
{
    ?>
    <section class="navigation">
        <section class="navigation__wrapper">
            <a href='/'><img class="navigation__logo" src="./../assets/chefschoice.png"></img></a>
            <?php
            if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
                ?>
                <a class="user__link" href="/user/login">
                    <i id="user__icon" class="fa-solid fa-user"></i>
                </a>
                <?php
            } else {
                ?>
                <div class="logout__wrapper">
                    <div class="shoppingcart__wrapper">
                        <i id="shoppingcart" class="fa-solid fa-cart-shopping"></i>
                        <p>
                            <?php
                            $cartItems = $dbContext->getCart();
                            $totalQuantity = 0;
                            foreach ($cartItems as $item) {
                                $totalQuantity += $item->quantity;
                            }
                            echo $totalQuantity ?>
                        </p>
                    </div>
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