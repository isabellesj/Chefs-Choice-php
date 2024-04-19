<?php
function layout_categories($dbContext, $q, $categoryId)
{
    ?>
    <form class="searchform" method="GET">
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
        <input type="hidden" name="id" value="<?php echo $categoryId; ?>" />

    </form>
    <?php
}
?>