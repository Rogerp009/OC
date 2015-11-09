<?php
$lockedOut = mysqli_query($conn, "SELECT COUNT(*) AS LockedOut FROM users WHERE (IsLockedOut = 1)")
or die($dataaccess_error);

if(mysqli_num_rows($lockedOut) > 0)
{
	$row = mysqli_fetch_array($lockedOut);
	echo '<li><a href=""><span class="col1">Locked Out Accounts</span><span class="col2">'.$row["LockedOut"].'</span></a></li>';
}
else
{
	$noresults = 'No results found...';
	echo $noresults;
}
?>