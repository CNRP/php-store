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

  toggleNav();
}, false);

function toggleNav() {
  const obj = document.getElementById("cart");
      if (obj.style.transform === "translateX(200%)") {
          obj.style.opacity = "1";
          obj.style.transform = "translateX(0)";
      } else {
          obj.style.opacity = "0";
          obj.style.transform = "translateX(200%)";
      }
  }

  function selectSelected(value){
    loadCart();
    if (value) window.location.href=value;
  }

  function loadCart(){
    var loading = document.getElementById("loading-cart");
    loading.classList.add('show');
  }