<?php 
	$currentPage = $_SERVER['SCRIPT_NAME'];
	include $_SERVER['DOCUMENT_ROOT'] .'/header.php';
?>

<script>
$(document).ready(function(){
    $('#guests').dataTable();
	$('#notguests').dataTable();
});
</script>
	<h1>Attending</h1>
	<table id="guests" class="display" width="100%">  
			<thead>  
			  <tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Family</th>
				<th>Age</th>
				<th>Food Choice</th>
				<th>Phone</th>
				<th>Email</th>
			  </tr>  
			</thead>
			<tbody>
                <tr>
                    <td>Janet</td>
                    <td>Van Dyne</td>
                    <td>Avengers</td>
                    <td>Adult</td>
                    <td>Salmon</td>
                    <td>555-1212</td>
                    <td>jvd@pymtech.com</td>
                </tr>
                <tr>
                    <td>Simon</td>
                    <td>Basset</td>
                    <td>Hastings</td>
                    <td>Adult</td>
                    <td>Steak</td>
                    <td>555-1212</td>
                    <td>sbasset@hastings.uk</td>
                </tr>
			</tbody>  
	</table>
	
	<h1>Not Attending</h1>
	<table id="notguests" class="display" width="100%">  
			<thead>  
			  <tr>
				<th>Family</th>
				<th>Phone</th>
				<th>Email</th>
			  </tr>  
			</thead>
			<tbody>
				<tr>
                    <td>Hydra</td>
                    <td>555-2323</td>
                    <td>info@hyd.ra</td>
                </tr>
			</tbody>  
</table>

</div><!--/wrap-->
<?php include $_SERVER['DOCUMENT_ROOT'] .'/footer.php';?>