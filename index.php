<?php
	require_once 'core/init.php';
	include 'includes/header.php';
	include 'includes/navigation.php';
	include 'includes/headerfull.php';
	include 'includes/leftbar.php';

	$getProducts = "SELECT * FROM products WHERE featured = 1";
	$featuredProduct = $dbconnection->query($getProducts);
?>
			<!-- Main Content -->
			<div class="col-md-8">
				<div class="row">
					<h2 class="text-center">Feature Products</h2>
					<?php while($product = mysqli_fetch_assoc($featuredProduct)) : ?>
						<div class="col-md-3">
							<h4><?= $product['title'];?></h4>
							<img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class = "img-thumb"/>
							<p class="list-price text-danger">list-price: <s><?= $product['list_price']; ?></s></p>
							<p class="price">Our Price: <?= $product['price']; ?></p>
							<button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)">Details</button>
						</div>
					<?php endwhile; ?>
				</dd Main Content -->

<?php
	include 'includes/rightbar.php';
	include 'includes/detailsmodal.php';
	include 'includes/footer.php';
?>
