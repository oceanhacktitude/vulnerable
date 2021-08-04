<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$value = $_POST['creditCard'];
	setcookie("CreditCardNumber", $value, time()+3600, "/");
}
 ?>

<?php
	$currentPage = $_SERVER['SCRIPT_NAME'];
	include 'header.php';
?>


<div class="container">
	<?php

	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
    echo '<div class="page-header text-center">
      <h1>Please enter your credit card information</h1>
    </div>

    <div>';


      // initialize error array
      $errors = array();

      // if no errors
      if (empty($errors))
      {

				echo '<div id="orderForm"><form action="checkout.php" method="post" role="form">
					<div class="form-group" align="center">
					<label for="creditCard">Credit Card Number: </label>
					<input type="text" class="form-control" name="creditCard" size="40" maxlength="60" required/>
					<br />
						<!-- submit button -->
						<input type="submit" class="btn btn-default" name="submit" value="Pay!" />
					</div>
				</form>
				</div>';

    } // closing tag for if(empty)
    else
    { // report all the errors

      echo '<h1>Error!</h1>
          <p class="error">The following error(s) occurred:<br />';

          foreach ($errors as $msg)
          { // print each error
            echo " - $msg<br />\n";
          }
          echo '</p><p>Please try again.</p><p><br /></p>';

    } // end of else errors
	}
	elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
	{

		echo '<div class="page-header text-center">
			<h1>Thank you for your purchase!</h1>
			<h2></h2>
		</div>

		<div>';


			// initialize error array
			$errors = array();

			// if no errors
			if (empty($errors))
				{

				echo '<p class="lead text-center">
				     Feel free to search for something else on our site
				    </p>';
				echo '<div id="orderForm"><form action="search.php" method="get" role="form">
					<div class="form-group" align="center">
					<label for="query">Search: </label>
					<input type="text" class="form-control" name="query" size="40" maxlength="60" required/>
					<br />
						<!-- submit button -->
						<input type="submit" class="btn btn-default" name="submit" value="Search!" />
					</div>
				</form>
				</div>';

		} // closing tag for if(empty)
		else
		{ // report all the errors

			echo '<h1>Error!</h1>
					<p class="error">The following error(s) occurred:<br />';

					foreach ($errors as $msg)
					{ // print each error
						echo " - $msg<br />\n";
					}
					echo '</p><p>Please try again.</p><p><br /></p>';

		} // end of else errors
	}
    ?>




    </div>

</div><!--/container-->

</div><!--/wrap-->

<?php include 'footer.php';?>
