<?php
$unapproved = mysqli_query($conn, "SELECT COUNT(*) AS Unapproved FROM users WHERE (IsApproved = 0)")
or die($dataaccess_error);

if(mysqli_num_rows($unapproved) > 0)
{
	$row = mysqli_fetch_array($unapproved);
	echo '<li><a href=""><span class="col1">Unapproved Accounts</span><span class="col2">'.$row["Unapproved"].'</span></a></li>';
}
else
{
	$noresults = 'No results found...';
	echo $noresults;
}
?>