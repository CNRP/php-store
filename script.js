
document.addEventListener("DOMContentLoaded", function () {
  const clickable = document.querySelectorAll('.load-clicked');

  clickable.forEach(el => el.addEventListener('click', event => {
    var productID = event.target.getAttribute('data-product');
    var loading = document.getElementById("loading-"+productID);
    loading.classList.add('show');
    console.log(loading);
  }));

}, false);