<?php
$totalRoles = mysqli_query($conn, "SELECT COUNT(*) AS RoleCount FROM roles")
or die($dataaccess_error);

if(mysqli_num_rows($totalRoles) > 0)
{
	$row = mysqli_fetch_array($totalRoles);
	echo '<li><a href=""><span class="col1">Total Roles =</span><span class="col2">'.$row["RoleCount"].'</span></a></li>';
}
else
{
	$noresults = 'No results found...';
	echo $noresults;
}
?>