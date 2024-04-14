<?php
function layout_navigation($dbContext, $sortCol, $q)
{
    ?>
    <section class="navigation">
        <section class="navigation__wrapper">
            <a href='/'><img class="navigation__logo" src="./../assets/chefschoice.png"></img></a>
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
            </div>
        </section>
        <form class="searchForm" method="GET">
            <ul class="category">
                <li class="category__item"><a class="category__link" href="/allProducts">All Products</a></li>
                <?php
                foreach ($dbContext->getAllCategories() as $category) { ?>

                    <li class="category__item">
                        <a class="category__link" href="/viewCategory?id=<?php echo $category->id ?>">
                            <?php echo $category->title ?>
                        </a>
                    </li>
                <?php } ?>

            </ul>
            </ul>
            <input class="search" type="text" name="q" value="<?php echo $q; ?>" />
            <input type="hidden" name="id" value="<?php echo $category->id ?>" />

        </form>
    </section>
    <?php
}
?>