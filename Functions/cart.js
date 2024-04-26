async function addToCart(id) {
  const quantity = await (await fetch(`/addtocart?id=${id}`)).text();
  console.log(quantity);
  document.getElementById("quantity").innerText = quantity;
}
