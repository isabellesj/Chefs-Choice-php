<?php
function showProducts($product)
{
    return "
    <div class='product__wrapper'>
        <p><a class='product__name' href='/viewProduct?id=$product->id'>$product->title</a><img class='product__img'
                src=$product->image></img></p>
        <p>Price: $product->price kr</p><button onclick='addToCart($product->id)' class='buy__button'>Add to cart</button>
    </div>";
}

?>