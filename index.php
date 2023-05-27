<?php
  $page_title = "Homepage";
  include 'general/header.php';

  $featured = isset($_GET['featured']) ? $_GET['featured'] : 'nike';
  $array = $mysqli->query("SELECT * FROM `products` ORDER BY `created_at` DESC LIMIT 4;");

  if (isset($_GET["featured"])) {
    $search_string = "%".$_GET["featured"]."%";
    $stmt  = $mysqli->prepare("SELECT * FROM `products` WHERE name LIKE ? or description LIKE ? LIMIT 4");
    $stmt->bind_param("ss", $search_string, $search_string);
    if($stmt->execute()){
        $array = $stmt->get_result();
    }
  }

  
?>

<section class="featured">
  <div class="featured-header">
    <img src="/assets/<?php echo $featured?>-featured.png" alt="">
    <div class="featured-header-content">
      <h1>
        shop for your <br>favourite brands
      </h1>
      <button class="feature-button">Shop now</button>
    </div>
  </div>
  <div class="brand-select">
    <a href="?featured=nike"><button class="feature-button<?php echo ($featured == 'nike' ? ' active' : '')?> ">Nike</button></a>
    <a href="?featured=jordan"><button class="feature-button<?php echo ($featured == 'jordan' ? ' active' : '')?>">Jordans</button></a>
    <a href="?featured=balance"><button class="feature-button<?php echo ($featured == 'balance' ? ' active' : '')?>">Newbalance</button></a>
    <a href=""><button class="feature-button">View all</button></a>
  </div>
  <div class="featured-products">
    <h2>Featured</h2>
    <div class="featured-product-cards">
    <?php
      foreach ($array as $value) {
        // console_log($value['id']. ", ".$value['name']. ", ".$value['description']. ", ".$value['default_price']);
        $price = number_format($stripe->prices->retrieve($value['default_price'])['unit_amount'] / 100, 2, '.', '');
      ?>
        <div class="featured-product-card">
          <div class="product">
              <div class="loading" id="<?php echo 'loading-'.$value['id'] ?>">
                <div class="loader"></div>
              </div>
              <div class="description">
                <img src="<?php echo $value['image_url'] ?>" alt="The cover of Stubborn Attachments" loading="lazy"/>
                  <h3><?php echo $value['name'] ?></h3>
                  <p><?php echo $value['description'] ?></p>
              </div>
              <h5>£<?php echo $price ?></h5>
              '.$cart_controls.'
          </div>
        </div>
      <?php
        }
      ?>
    </div>
    <h2>Search</h2>
    <form action="/products/query.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>  
</section>
<?php include 'general/footer.php';?>
