<?php
$newestMembers = mysqli_query($conn, "SELECT UserId, UserName, CreateDate FROM users ORDER BY CreateDate DESC LIMIT 5")
or die($dataaccess_error);

if(mysqli_num_rows($newestMembers) > 0)
{
	while($row = mysqli_fetch_array($newestMembers))
	{
		echo '<li><a href=""><span class="col1">'.$row["UserName"].'</span><span class="col2">'.$row["CreateDate"].'</span></a></li>';
	}
}
else
{
	$noresults = 'No results found...';
	echo $noresults;
}
?>