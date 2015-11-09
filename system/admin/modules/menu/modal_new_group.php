<?php
// get required includes
require(ROOT_PATH.'admin/modules/menu/error_messages.php');

// declare variables
$msg = '';
$msg_2 = '';
$default_menu_name = 'Select a Menu Group to Edit';
$menu_name = '';
$f_group_name = '';
$f_group_description = '';

// ------------------------------------------------------------
// INSERT NEW MENU GROUP NAME
// ------------------------------------------------------------
if(isset($_POST['btnAddMenuGroup']))
{
	$validate_error = 0;
	$error = 0;

	// Get Menu Name (group)
	if(!empty($_POST['GroupName']))
	{
		$sent_group_name = mysqli_real_escape_string($conn, trim($_POST['GroupName']));
		
		// check if already exist
		$check_if_exist = mysqli_query($conn, "SELECT MenuName FROM menu_names WHERE MenuName = '$sent_group_name' LIMIT 1")
		or die($dataaccess_error);
		
		if(mysqli_num_rows($check_if_exist) == 0 )
		{
			$menu_group_name = $sent_group_name;
		}
		else
		{
			$validate_error = 1;
			$error = 1;
			$msg = $menu_group_exist_msg;
		}
	}
	else
	{
		$validate_error = 1;
		$error = 1;
		$msg = $menu_group_empty_msg;
	}
	
	// Get Menu Name (group)
	if(!empty($_POST['GroupDescription']))
	{
		$menu_group_description = mysqli_real_escape_string($conn, trim($_POST['GroupDescription']));
	}
	else
	{
		$menu_group_description = '';
	}
	
	// update menu item
	if($validate_error == 0)
	{
		$insert_menu_group = mysqli_query($conn, "INSERT INTO menu_names(MenuName,Description) VALUES('$menu_group_name','$menu_group_description')")
		or die($dataaccess_error);
		
		if(mysqli_affected_rows($conn) > 0)
		{
			echo $menu_group_insert_success;
		}
		else
		{
			echo $no_changes_made;
		}
	}
	
	// show error banner if not 0
	if($error == 1)
	{
		echo $general_banner_error;
	}
}

// ------------------------------------------------------------
// DISPLAY MENU GROUP DETAILS ON SELECTION
// ------------------------------------------------------------
if(isset($_POST['ddlMenuName']) && !empty($_POST['ddlMenuName']))
{
	$selected_group_name = mysqli_real_escape_string($conn, trim($_POST['ddlMenuName']));
	$menu_name = $selected_group_name;
	
	$get_menu_group = mysqli_query($conn, "SELECT MenuName, Description FROM menu_names WHERE MenuName = '$menu_name' LIMIT 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_menu_group) == 1 )
	{
		$row = mysqli_fetch_array($get_menu_group);
		$f_group_name = $row['MenuName'];
		$f_group_description = $row['Description'];
	}
}
else
{
	$menu_name = $default_menu_name;
}

// ------------------------------------------------------------
// SAVE EDITED MENU GROUP DETAILS
// ------------------------------------------------------------
if(isset($_POST['btnEditMenuGroup']))
{
	$validate_error = 0;
	$error = 0;
	
	// Update Menu Group Name
	if(!empty($_POST['EditGroupName']) && $_POST['ddlMenuName'] != $default_menu_name)
	{
		$selected_group_name = mysqli_real_escape_string($conn, trim($_POST['ddlMenuName']));
		$sent_edit_group_name = mysqli_real_escape_string($conn, trim($_POST['EditGroupName']));
		$edit_group_description = mysqli_real_escape_string($conn, trim($_POST['EditGroupDescription']));
		
		if($selected_group_name == $sent_edit_group_name)
		{
			$edit_group_name = $sent_edit_group_name;
		}
		elseif($selected_group_name != $sent_edit_group_name)
		{
			// check if already exist
			$check_if_exist = mysqli_query($conn, "SELECT MenuName FROM menu_names WHERE MenuName = '$sent_edit_group_name' LIMIT 1")
			or die($dataaccess_error);
			
			if(mysqli_num_rows($check_if_exist) == 0 )
			{
				$edit_group_name = $sent_edit_group_name;
			}
			else
			{
				$validate_error = 1;
				$error = 1;
				$msg_2 = $menu_group_exist_msg;
			}
		}

		// if all is valid
		if($validate_error == 0)
		{
			// update menu_names table
			$update_menu_group = mysqli_query($conn, "UPDATE menu_names SET MenuName = '$edit_group_name',Description = '$edit_group_description' WHERE MenuName = '$selected_group_name'")
			or die($dataaccess_error);
			
			if(mysqli_affected_rows($conn) > 0)
			{
				// update menus table
				$update_menus = mysqli_query($conn, "UPDATE menus SET MenuName = '$edit_group_name' WHERE MenuName = '$selected_group_name'")
				or die($dataaccess_error);
				
				if(mysqli_affected_rows($conn) > 0)
				{
					// reset form to default
					$menu_name = $default_menu_name;
					$f_group_name = '';
					$f_group_description = '';
					
					// display success message
					echo $menu_group_update_success;
				}
			}
			else
			{
				echo $no_changes_made;
			}
		}
	}
	else
	{
		$error = 1;
		$msg_2 = $menu_group_empty_msg;
	}
	
	// show error banner if not 0
	if($error == 1)
	{
		echo $general_banner_error;
	}
}
?>