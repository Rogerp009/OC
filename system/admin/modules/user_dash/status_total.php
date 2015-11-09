<?php
$totalAccounts = mysqli_query($conn, "SELECT COUNT(*) AS TotalCount FROM users")
or die($dataaccess_error);

if(mysqli_num_rows($totalAccounts) > 0)
{
	$row = mysqli_fetch_array($totalAccounts);
	echo '<li><a href=""><span class="col1">Total Accounts =</span><span class="col2">'.$row["TotalCount"].'</span></a></li>';
}
else
{
	$noresults = 'No results found...';
	echo $noresults;
}
?>