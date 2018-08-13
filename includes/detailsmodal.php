<?php
  //require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';﻿
  //require_once 'core/init.php';
  require_once 'c:/xampp/htdocs/ecommerce/core/init.php';
  if(isset($_POST["id"])){
    $id = $_POST["id"];
  }else{
      $id = NULL;
  }

  //$id = $_POST['id'];
  $id = (int)$id;
  $getProduct = "SELECT * FROM products WHERE id = '$id'";
  $productList = $dbconnection->query($getProduct);
  $product = mysqli_fetch_assoc($productList);

  $brand_id = $product['brand'];
  $getBrand = "SELECT brand FROM brand WHERE id = '$brand_id'";
  $brandList = $dbconnection->query($getBrand);
  $brand = mysqli_fetch_assoc($brandList);
  $sizestring = $product['sizes'];
  $size_array = explode(',', $sizestring);
?>

<!-- Details Modal -->
<?php ob_start(); ?>

<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closeModal()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center"><?= $product['title']; ?></h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <div class="center-block">
                <img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class="details img-responsive" />
              </div>
            </div>
            <div class="col-sm-6">
              <h4>Details</h4>
              <p><?= $product['description']; ?></p>
              <hr>
              <p>Price: $ <?= $product['price']; ?></p>
              <p>Brand: <?= $brand['brand']; ?></p>
              <form action="add_cart.php" method="post">
                <div class="form-group">
                  <div class="col-xs-3">
                    <label for="quantity">Quantity:</label>
                    <input type="text" class="form-control" id="quantity" name="quantity">
                  </div><br><br>
                  <div class="col-xs-9">&nbsp;</div>
                </div><br><br>
                <div class="form-group">
                  <label for="size">Size:</label>
                  <select class="form-control" name="size" id="size">
                    <option value=""></option>
                    <?php foreach($size_array as $string){
                      $string_array = explode(':', $string);
                      $size = $string_array[0];
                      $quantity = $string_array[1];
                      echo '<option value="'.$size.' ">'.$size.' '. '(' .$quantity. ' Available)</option>';
                    } ?>
                  </select>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"onclick="closeModal()">Close</button>
        <button type="submit" class="btn btn-warning"> <span class="glyphicon glyphicon-shopping-cart"></span> Add to cart </button>
      </div>
    </div>
  </div>
</div>
<script>
  function closeModal(){
    jQuery('#details-modal').modal('hide');
    setTimeOut(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
    },500);
  }
</script>
<?php echo ob_get_clean(); ?>
