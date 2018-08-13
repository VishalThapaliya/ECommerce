<?php
  require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ecommerce/core/init.php');
  include 'includes/header.php';
  include 'includes/navigation.php';

  $selectCategory = "SELECT * FROM category WHERE parent = 0";
  $resultCategory = $dbconnection->query($selectCategory);
  $errors = array();

  //Process form
  if (isset($_POST) && !empty($_POST)) {
    $parent = sanitize($_POST['parent']);
    $category = sanitize($_POST['category']);
    $checkCategory = "SELECT * FROM category WHERE category = '$category' AND parent = '$parent'";
    $categoryResult = $dbconnection->query($checkCategory);
    $count = mysqli_num_rows($categoryResult);
    //if category is blank
    if ($category == '') {
      $errors[] .= 'The category cannot be left blank.';
    }

    //If exists in the database
    if($count > 0){
      $errors[] .= $category. ' already exists. Please choose a new category.';
    }

    //Display Errors or Update Database
    if(!empty($errors)){
      //display errors
      $display = display_errors($errors); ?>
      <script>
        jQuery('document').ready(function(){
          jQuery('#errors').html('<?=$display; ?>')
        });
      </script>
    <?php }else{
      //update database
      $updateCategory = "INSERT INTO category (category, parent) VALUES ('$category','$parent')";
      $execUpdateCategory = $dbconnection->query($updateCategory);
      header('Location: categories.php');
    }
  }
?>

<h2 class="text-center">Categories</h2><hr>
<div class="row">
  <!-- Form -->
  <div class="col-md-6">
    <form class="form" action="categories.php" method="post">
      <legend>Add A Category</legend>
      <div id="errors"></div>
      <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-control" name="parent" id="parent">
          <option value="0">Parent</option>
          <?php while($parent = mysqli_fetch_assoc($resultCategory)): ?>
            <option value="<?=$parent['id'];?>"><?=$parent['category'];?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" class="form-control" id="category" name="category" value="">
      </div>
      <div class="form-group">
        <input type="submit" value="Add Category" class="btn btn-success">
      </div>
    </form>
  </div>

  <!-- Category Table -->
  <div class="col-md-6">
      <table class="table table-bordered">
        <thead>
          <th>Category</th>
          <th>Parent</th>
          <th></th>
        </thead>
        <tbody>
          <?php
            $selectCategory = "SELECT * FROM category WHERE parent = 0";
            $resultCategory = $dbconnection->query($selectCategory);
            while($parent = mysqli_fetch_assoc($resultCategory)):
            $parent_id = (int)$parent['id'];
            $selectChildCategory = "SELECT * FROM category WHERE parent = '$parent_id'";
            $childResult = $dbconnection->query($selectChildCategory);
          ?>
          <tr class="bg-primary">
            <td><?=$parent['category'];?></td>
            <td>Parent</td>
            <td>
              <a href="categories.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span> </a>
              <a href="categories.php?delete=<?=$parent['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span> </a>
            </td>
          </tr>
          <?php while($child = mysqli_fetch_assoc($childResult)): ?>
            <tr class="bg-info">
              <td><?=$child['category'];?></td>
              <td><?=$parent['category'] ?></td>
              <td>
                <a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span> </a>
                <a href="categories.php?delete=<?=$child['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span> </a>
              </td>
            </tr>
          <?php endwhile; ?>
          <?php endwhile; ?>
        </tbody>
      </table>
  </div>
</div>


<?php include 'includes/footer.php'; ?>
