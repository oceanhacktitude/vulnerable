<?php
	$currentPage = $_SERVER['SCRIPT_NAME'];
	include 'header.php';
?>


<div class="container">
    <div class="page-header text-center">
      <h1>Buy our cool things!</h1>
    </div>

    <div>

		<div id="orderForm"><form action="checkout.php" method="get" role="form">
			<div class="form-group" align="center">
				<img src="img/dew.jpg" width="100"/>
				<br />
				<br />
				<!-- submit button -->
				<input type="submit" class="btn btn-default" name="submit" value="Buy!" />
			</div>
		</form></div>




    </div>

</div><!--/container-->

</div><!--/wrap-->

<?php include 'footer.php';?>
