<?php
  require_once '../core/init.php';
  include 'includes/header.php';
  include 'includes/navigation.php';

  //get brands from database
  $getBrands = "SELECT * FROM brand ORDER BY brand";
  $brandList = $dbconnection->query($getBrands);
  $errors = array();

  //Edit Brand
  if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $queryEditBrand = "SELECT * FROM brand WHERE id = '$edit_id'";
    $editBrand = $dbconnection->query($queryEditBrand);
    $eBrand = mysqli_fetch_assoc($editBrand);
  }

  //Delete Brand
  if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $queryRemoveBrand = "DELETE FROM brand WHERE id = '$delete_id'";
    $removeBrand = $dbconnection->query($queryRemoveBrand);
    header('Location:brands.php');
  }
  //If add form is submitted
  if (isset($_POST['add_submit'])) {
    $brand = sanitize($_POST['brand']);
    //check if brand is blank
    if ($_POST['brand'] == '') {
      $errors[] .= 'You must enter a brand!';
    }
    //check if brand exits in Database
    $checkBrand = "SELECT * FROM brand WHERE brand = '$brand'";
    if(isset($_GET['edit'])){
      $checkBrand = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
    }
    $brands = $dbconnection->query($checkBrand);
    $countBrand = mysqli_num_rows($brands);
    if ($countBrand > 0) {
      $errors[] .= $brand .  ' already exists. Please choose another brand name';
    }

    //display errors
    if (!empty($errors)) {
      echo display_errors($errors);
    }else{
      //Add brand to database
      $addBrand = "INSERT INTO brand (brand) VALUES ('$brand')";
      if(isset($_GET['edit'])){
        $addBrand = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
      }
      $saveBrand = $dbconnection->query($addBrand);
      header('Location: brands.php');
    }
  }
?>
<h2 class="text-center">Brands</h2><hr>
<!-- Brands Form -->
<div class="text-center">
  <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'') ?>" method="post">
    <div class="form-group">
      <?php
        $brand_value = '';
        if(isset($_GET['edit'])){
          $brand_value = $eBrand['brand'];
        }else {
          if(isset($_POST['brand'])){
            $brand_value = sanitize($_POST['brand']);
          }
        }
      ?>
      <label for="brand"><?=(isset($_GET['edit']))?'Edit':'Add A'?> Brand: </label>
      <input type="text" name="brand" id="brand" class="form-control" value="<?= $brand_value; ?>">
      <?php if(isset($_GET['edit'])):?>
        <a href="brands.php" class="btn btn-default">Cancel</a>
      <?php endif;?>
      <input type="submit" name="add_submit" value="<?=(isset($_GET['edit']))?'Edit':'Add'?> Brand" class="btn btn-success">
    </div>

  </form>
</div><hr>
<table class="table table-bordered table-striped table-auto table-condensed">
  <thead>
    <th></th><th>Brand</th><th></th>
  </thead>
  <tbody>
    <?php while($brand = mysqli_fetch_assoc($brandList)): ?>
    <tr>
      <td><a href="brands.php?edit=<?= $brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
      <td><?= $brand['brand']; ?></td>
      <td><a href="brands.php?delete=<?= $brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php
  include 'includes/footer.php';
?>
