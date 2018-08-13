<?php
  $getCategory = "SELECT * FROM category WHERE parent = 0";
  $pquery = $dbconnection->query($getCategory);
?>

<!-- Top Navbar	-->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="index.php" class="navbar-brand">Bishal's Boutique</a>
    <ul class="nav navbar-nav">
      <?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
      <?php
        $parent_id = $parent['id'];
        $getParentId = "SELECT * FROM category WHERE parent = '$parent_id'";
        $cquery = $dbconnection->query($getParentId);

      ?>
      <!-- Menu Items -->
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo strtoupper($parent['category']); ?> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <?php while($child = mysqli_fetch_assoc($cquery)) : ?>
          <li><a href="#"><?php echo $child['category'] ?></a></li>
        <?php endwhile ?>
        </ul> <!-- End dropdown-menu -->
      </li> <!-- End dropdown-->
      <?php endwhile; ?>
    </ul> <!-- End navbar-nav -->
  </div> <!-- End container-->
</nav> <!-- End navbar -->
