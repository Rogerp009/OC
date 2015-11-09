<?php
// ------------------------------------------------------------
// GET MENU NAMES
// ------------------------------------------------------------

// DB QUERY: get menu name
// ------------------------------------------------------------
$get_menu_names = mysqli_query($conn, "SELECT DISTINCT MenuName FROM menu_names ORDER BY MenuName ASC")
or die('error message');
// ------------------------------------------------------------

if(mysqli_num_rows($get_menu_names) > 0)
{
	while($row = mysqli_fetch_array($get_menu_names))
	{
		$menu_name = $row["MenuName"];
		echo '<option>'.$menu_name.'</option>';
	}
}
else
{
	echo 'Not Found..';
}
?>