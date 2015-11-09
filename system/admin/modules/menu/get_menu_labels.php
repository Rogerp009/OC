<?php
// ------------------------------------------------------------
// GET MENU ITEMS
// ------------------------------------------------------------

// DB QUERY: get menu labels
// ------------------------------------------------------------
$get_menu_label = mysqli_query($conn, "SELECT MenuId, Label FROM menus ORDER BY Label ASC")
or die('error message');
// ------------------------------------------------------------

if(mysqli_num_rows($get_menu_label) > 0)
{	
	while($row = mysqli_fetch_array($get_menu_label))
	{
		$value_id = $row["MenuId"];
		$value_label = $row["Label"];
		echo '<option value="'.$value_id.'|'.$value_label.'">'.$value_label.'</option>';
	}
}
else
{
	echo 'Not Found..';
}
?>