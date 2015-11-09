<?php
$roleNames = mysqli_query($conn, "SELECT COUNT( users_in_roles.RoleName ) AS userCount, roles.RoleName FROM roles LEFT JOIN users_in_roles ON roles.RoleName = users_in_roles.RoleName GROUP BY roles.RoleName LIMIT 5")
or die($dataaccess_error);

if(mysqli_num_rows($roleNames) > 0)
{
	while($row = mysqli_fetch_array($roleNames))
	{
		echo '<li><a href=""><span class="col1">'.$row["RoleName"].'</span><span class="col2">'.$row["userCount"].'</span></a></li>';
	}
}
else
{
	$noresults = 'No results found...';
	echo $noresults;
}
?>