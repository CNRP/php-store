document.addEventListener("DOMContentLoaded", function () {
  const clickableProducts = document.querySelectorAll('.load-add');

  clickableProducts.forEach(el => el.addEventListener('click', event => {
    var productID = event.target.getAttribute('data-product');
    var loading = document.getElementById("loading-"+productID);
    loading.classList.add('show');
  }));

  const clickableCart = document.querySelectorAll('.load-cart');
  clickableCart.forEach(el => el.addEventListener('click', event => {
    loadCart();
  }));

}, false);

