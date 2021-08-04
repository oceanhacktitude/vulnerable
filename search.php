<?php
	$currentPage = $_SERVER['SCRIPT_NAME'];
	include 'header.php';
?>


<div class="container">
	<?php

	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
    echo '<div class="page-header text-center">
      <h1>Search Results</h1>
    </div>

    <div>';


      // initialize error array
      $errors = array();

      // if no errors
      if (empty($errors))
      {

				#$query = htmlspecialchars($_GET['query']);
				$query = $_GET['query'];
        echo "<p>No results found for $query</p>";

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
    ?>




    </div>

</div><!--/container-->

</div><!--/wrap-->

<?php include 'footer.php';?>
