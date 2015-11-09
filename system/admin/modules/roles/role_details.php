<?php
// if id sent is ok
if(isset($_GET['rid']) && !empty($_GET['rid']) && is_numeric($_GET['rid']) && $_GET['rid'] > 0)
{
	// get query string
	$sent_id = mysqli_real_escape_string($conn, $_GET['rid']);

	$role_id = $sent_id;
	
	$get_role_details = mysqli_query($conn, "SELECT * FROM roles WHERE RoleId = $role_id LIMIT 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_role_details) == 1)
	{
		$row = mysqli_fetch_array($get_role_details);
		$role_name = $row['RoleName'];
		$role_description = $row['Description'];
	}
}
?>