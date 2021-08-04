<?php 

function get_var($name, $default = "", $sitewide = false){
	// if sitewide flag is set, use "site" as the key
	// otherwise, use the filename/path as the key
	$page = $sitewide ? "site" : $_SERVER['PHP_SELF'];
	
	if(isset($_POST[$name])){
		$value = $_POST[$name];
	} else if(isset($_GET[$name])){
		$value = $_GET[$name];
	} else if(isset($_SESSION[$page][$name])){
		$value = $_SESSION[$page][$name];
	} else{
		$value = $default;
	}
	
	// store value in session
	$_SESSION[$page][$name] = $value;
	
	return $value;
}


// used to return consistant column heading links
function get_sort_link($db_col_name, $display_name, $sort, $dir){
    // set whether we want an up or down arrow
    $dir_arrow = ($dir == "ASC") ? "&darr;" : "&uarr;";
    
    // logic for ASC vs. DESC
    $this_dir = ($sort == $db_col_name and $dir == "ASC") ? "DESC" : "ASC";
    $this_arrow = ($sort == $db_col_name) ? $dir_arrow : "";
    $this_title = 'Sort by ' . strtolower($display_name) . (($this_dir == "ASC") ? ' ascending.' : ' descending.');
    
    // retun the generated link
    return '<a href="?sort=' . $db_col_name .  '&dir=' . $this_dir .'&start=0" title="' . $this_title . '">
                ' . $display_name . '<span>' . $this_arrow . '</span>
            </a>';
}
?>