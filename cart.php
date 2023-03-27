<?php

class Cart{
  public $products = array();
  public $stripe = [];

  // public function Cart($stripe){
  //   $this->stripe = $stripe;
  // }

  public function getCart(){
    return $this->products;
  }

  public function add($stripe){
    if($stripe !== null){
      $product = $stripe->products->retrieve(
        $_GET['addToCart'],
        []
      );

      $this->products[$_GET['addToCart']] ??= [
          'id' => $_GET['addToCart'],
          'quantity' => 0,
          'name' => $product['name'],
          'description' => $product['description'],
          'price' => number_format($stripe->prices->retrieve($product['default_price'])['unit_amount'] / 100, 2, '.', ''),
          'image' => $product['images'][0],
      ];
      $this->products[$_GET['addToCart']]["quantity"]++;

      console_log($this->products[$_GET['addToCart']]);
    }
  }

  public function remove(){
    if(isset($this->products[$_GET['subtractFromCart']])){
      $array = $this->products[$_GET['subtractFromCart']];
      unset($this->products[$array['id']]);
    }
  }
}

?>