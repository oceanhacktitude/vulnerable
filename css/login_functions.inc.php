<?php

// defines two functions used by the login/logout process

// function that determines the URL and redirects the user there
function redirect_user ($page = 'admin.php') {
	
	// start defining the URL. http plus host name, plus directory
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	
	// remove the slashes
	$url = rtrim($url, '/\\');
	
	// add the page
	$url .= '/' . $page;
	
	// redirect the user
	header("Location: $url");
	exit(); // quits the script
	
} // end of redirect_user() function

// function that validates the form data, and returns an array of information
function check_login($dbc, $username = '', $password = '') {
	
	// begin an error array
	$errors = array();
	
	// validate the username
	if (empty($username)) {
		$errors[] = 'You forgot to enter your username.';
	} 
	else 
	{
		$un = mysqli_real_escape_string($dbc, trim($username));
	}
	
	// validate the password
	if (empty($password)) 
	{
		$errors[] = 'You forgot to enter your password.';
	} 
	else 
	{
		$p = mysqli_real_escape_string($dbc, trim($password));
	}
	
	if (empty($errors)) { // if everything is okay
		
		// retrieve the user_id and first_name for that username/password combination
		$q = "SELECT user_id, username, pass
				FROM users WHERE username = '$un'
				AND pass=SHA1('$p')";
				
		// run the query
		$r = @mysqli_query($dbc, $q);
			
		//check the result
		if (mysqli_num_rows($r) == 1) 
		{
			// fetch the record
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			
			// return true and the record
			return array(true, $row);
			
		} 
		else 
		{ // not a match
			$errors[] = 'The username and password entered do not match those on file.';
		}
	}
	// return false and the errors:
	return array(false, $errors);
	
} // end of check_login() function