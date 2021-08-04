<?php
	$currentPage = $_SERVER['SCRIPT_NAME'];
	include 'header.php';
?>


<div class="container">
    <div class="page-header text-center">
      <h1>Register here for the party!</h1>
    </div>

    <p class="lead text-center">
     Enter your group name and contact information
    </p>

    <div>
    <script>
		function yesOrNo(value){
			var answer = value;
			if (answer == 'no'){
				document.getElementById('numGuests').innerHTML = '';
				document.getElementById('guestInfo').innerHTML = '';
			} else if (answer == 'yes'){
				document.getElementById('numGuests').innerHTML = '<div class="form-group"><label for="numGuests">Number of Guests Attending:</label><input type="number" min="1" max="10" onclick=\"guestEntry(this.value)\" class="form-control" name="attending" size="60" maxlength="70" required/></div>';
			} else {
				document.getElementById('numGuests').innerHTML = 'Sorry, an error occurred. Please try again.';
			}
		}

		function guestEntry(digit){
			document.getElementById('guestInfo').innerHTML = '';
			for (var i = 1; i <= digit; i++) {
				document.getElementById('guestInfo').innerHTML += '<br><h3>Guest </h3><hr style="border-color: #999; background-color: #999;">';
				document.getElementById('guestInfo').innerHTML += '<div class="form-group"><label for="fname'+i+'">First Name:</label><input type="text" class="form-control" name="fname'+i+'" size="60" maxlength="70" required/></div>';
				document.getElementById('guestInfo').innerHTML += '<div class="form-group"><label for="lname'+i+'">Last Name:</label><input type="text" class="form-control" name="lname'+i+'" size="60" maxlength="70" required/></div>';
				document.getElementById('guestInfo').innerHTML += '<div class="form-group"><label for="age'+i+'">Age Group:</label>';
				document.getElementById('guestInfo').innerHTML += '<div class="radio"><label><input type="radio" name="age'+i+'" value="adult" required>Adult <i>(Age 13 and up)</i></label></div>';
				document.getElementById('guestInfo').innerHTML += '<div class="radio"><label><input type="radio" name="age'+i+'" value="child" required>Child <i>(Ages 4 to 13)</i></label></div>';
				document.getElementById('guestInfo').innerHTML += '<div class="radio"><label><input type="radio" name="age'+i+'" value="young-child" required>Young Child <i>(Younger than 4 years)</i></label></div>';
				document.getElementById('guestInfo').innerHTML += '<label for="meal'+i+'">Meal:</label><br /><input type="radio" name="meal'+i+'" value="steak" required>Steak<br /><input type="radio" name="meal'+i+'" value="salmon" required>Salmon<br/>';
				document.getElementById('guestInfo').innerHTML += '</div>';
			}
		}
		</script>

		<?php

		// this script performs an INSERT query to add a record

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// require the database connection
			require('mysqli_connect.php'); // connects to the db

			// form validation

			// initialize error array
			$errors = array();

			// check for alias
			if (empty($_POST['alias']))
			{
				$errors[] = 'You forgot to enter your group name.';
			}

			// check for phone number
			if (empty($_POST['phone']))
			{
				$errors[] = 'Please enter your phone number.';
			}

			// check for email address
			if (empty($_POST['email']))
			{
				$errors[] = 'Please enter your email address.';
			}

			if (!empty($_POST['attending']))
			{
				for ($i = 1; $i <= $_POST['attending']; $i++)
				{
					if (empty($_POST['fname'.$i])) { $errors[] = 'Missing data.'; }
					if (empty($_POST['lname'.$i])) { $errors[] = 'Missing data.'; }
					if (empty($_POST['age'.$i])) { $errors[] = 'Missing data.'; }
					if (empty($_POST['meal'.$i])) { $errors[] = 'Missing data.'; }
				}

			}

			// if no errors
			if (empty($errors))
			{
				// use escape strings
				$alias = mysqli_real_escape_string($dbc, trim($_POST['alias']));
				$attending = mysqli_real_escape_string($dbc, trim($_POST['attending']));
				$phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
				$email = mysqli_real_escape_string($dbc, trim($_POST['email']));

				// Check connection
				if ($dbc->connect_error) {
					die('<div class="alert alert-danger"><strong>Connection failed:</strong> '.$dbc->connect_error.'</div>');
				}

				// prepare and bind
				$insertFamily = $dbc->prepare("INSERT INTO `family` (`alias`, `attending`, `phone`, `email`, `reg_date`) VALUES (?, ?, ?, ?, NOW());");
				$insertFamily->bind_param("siss", $alias, $attending, $phone, $email);

				if ($insertFamily->execute()) {
					$familyID = $dbc->insert_id;
					echo '<div class="alert alert-success"><strong>Success!</strong> We have received your response.</div>';

					//if value = 0, then no
					if ($attending == 0){
						$smsAttending = "Not coming.";
					} else {
						$smsAttending = "Yes, coming.";
					}

					$message = "RSVP NOTIFICATION: " . $alias . " , " . $smsAttending;
					$to = 'user@example.com';
					$headers = 'From: WI-RSVP@example.com';
					$secondTo = 'user@example.com';
					$result = @mail( $to, '', $message, $headers );
					$secondResult = @mail( $secondTo, '', $message, $headers );

				} else {
					echo '<div class="alert alert-danger"><strong>Oh no! an error occurred.</strong> '.$dbc->error.'</div>';
				}

				$insertFamily->close();

				for ($i = 1; $i <= $attending; $i++)
				{
					// prepare and bind
					$insertPerson = $dbc->prepare("INSERT INTO `person` (`fname`, `lname`, `family_id`, `ageGroup`) VALUES (?, ?, ?, ?);");
					$insertPerson->bind_param("ssis", $firstName, $lastName, $familyID, $ageGroup);

					// set parameters and execute
					$firstName = $_POST['fname'.$i];
					$lastName = $_POST['lname'.$i];
					$ageGroup = $_POST['age'.$i];

					if ($insertPerson->execute()) {
						$personID = $dbc->insert_id;
						//echo "New record created successfully. Last inserted ID is: " . $personID;
					} else {
						echo '<div class="alert alert-danger"><strong>Oh no! An error occurred.</strong> '.$dbc->error.'</div>';
					}

					$insertPerson->close();

					// prepare and bind
					$insertMeal = $dbc->prepare("INSERT INTO `mealChoice` (`choice`, `person_id`) VALUES (?, ?);");
					$insertMeal->bind_param("si", $choice, $personID);

					// set parameters and execute
					$choice = $_POST['meal'.$i];

					if ($insertMeal->execute()) {
						$mealID = $dbc->insert_id;
						//echo "New record created successfully. Last inserted ID is: " . $mealID;
					} else {
						echo '<div class="alert alert-danger"><strong>Oh no! An error occurred.</strong> '.$dbc->error.'</div>';
					}

					$insertMeal->close();
				}

				$dbc->close();


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


		} // main submit conditional
		else
		{
			echo '<div id="rsvpForm"><form action="rsvp.php" method="post" role="form">
			<div class="form-group">
			<label for="alias">Group Name:<small><i>(Examples: The Avengers, The Mystery Gang, etc.)</i></small></label>
			<input type="text" class="form-control" name="alias" size="60" maxlength="70" required/>
			</div>

			<div class="form-group">
			<label for="phone">Phone Number: </label>
			<input type="text" class="form-control" name="phone" size="12" maxlength="12" required/>
			</div>

			<div class="form-group">
			<label for="email">Email Address: </label>
			<input type="text" class="form-control" name="email" size="40" maxlength="60" required/>
			</div>

			<div class="form-group">
			<label for="yesno">Attending: </label><br>
			<label><input type="radio" onclick="yesOrNo(this.value)" name="yesno" value="yes" required>Yes, I/we will attend this!</label>
			<label><input type="radio" onclick="yesOrNo(this.value)" name="yesno" value="no" required>No, I/we regretfully decline.</label>
			</div>

			<p id="numGuests"></p>
			<p id="guestInfo"></p>

			<br />
			<!-- submit button -->
			<input type="submit" class="btn btn-default" name="submit" value="Next &rarr;" />

			</form></div>';
		}

		?>



    </div>

</div><!--/container-->

</div><!--/wrap-->

<?php include 'footer.php';?>
