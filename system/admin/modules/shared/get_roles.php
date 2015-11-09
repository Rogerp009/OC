<?php
// ------------------------------------------------------------
// GET ROLES
// ------------------------------------------------------------
$get_roles = mysqli_query($conn, "SELECT RoleName FROM roles")
or die('error message');

if(mysqli_num_rows($get_roles) > 0)
{
	while($row = mysqli_fetch_array($get_roles))
	{
		echo '<option>'.$row["RoleName"].'</option>';
	}
}
else
{
	echo 'Not Found..';
}
?>