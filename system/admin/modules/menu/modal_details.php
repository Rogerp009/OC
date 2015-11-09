<?php
// get required includes
require(ROOT_PATH.'admin/modules/menu/error_messages.php');

// declare variables
$msg = '';
$menu_name = '';
$menu_label = '';
$parent_label = '';
$parent_id = 0;
$menu_url = '';
$menu_target = '';
$menu_title = '';
$ordinal_position = '';
$menu_description = '';
$is_enabled = 0;
$checked1 = 0;

// get query string
$sent_id = mysqli_real_escape_string($conn, $_GET['mid']);

// ------------------------------------------------------------
// GET CURRENT MENU LABEL
// ------------------------------------------------------------
if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
{
	// set menu id equal to sent id
	$menu_id = $sent_id;
	
	/* 
	we need to know what the original label, parent label 
	and parent id is on page load, so we can see what changes
	when the form is submitted and coordinate accordingly.
	*/
	$get_menu_details = mysqli_query($conn, "SELECT Label, ParentId, ParentLabel FROM menus WHERE MenuId = $menu_id LIMIT 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_menu_details) == 1 )
	{
		$row = mysqli_fetch_array($get_menu_details);
		$current_menu_label = $row['Label'];
		$current_parent_id = $row['ParentId'];
		$current_parent_label = $row['ParentLabel'];
	}
}

// ------------------------------------------------------------
// UPDATE MENU ITEM DETALS
// ------------------------------------------------------------
if(isset($_POST['btnUpdateMenuItem']))
{
	$validate_error = 0;
	$error = 0;
	$menu_id = $sent_id;
	
	// Get Menu Name (Group)
	if(!empty($_POST['ddlMenuName']))
	{
		$menu_name = mysqli_real_escape_string($conn, $_POST['ddlMenuName']);
	}
	else
	{
		$validate_error = 1;
		$error = 1;
		$msg = $menu_name_empty_msg;
		exit();
	}
	
	// Get Menu Label and check if exist
	if(!empty($_POST['MenuLabel']))
	{
		$sent_menu_label = mysqli_real_escape_string($conn, trim($_POST['MenuLabel']));
		
		if($current_menu_label != $sent_menu_label)
		{
			$check_if_exist = mysqli_query($conn, "SELECT Label FROM menus WHERE Label = '$sent_menu_label' AND MenuName = '$menu_name'")
			or die($dataaccess_error);
			
			if(mysqli_num_rows($check_if_exist) == 0)
			{
				$menu_label = $sent_menu_label;
			}
			else
			{
				$validate_error = 1;
				$error = 1;
				$msg .= $menu_label_exist_msg;
			}
		}
		else
		{
			$menu_label = $sent_menu_label;
		}
	}
	else
	{
		$validate_error = 1;
		$error = 1;
		$msg .= $menu_label_empty_msg;
	}
	
	// Get Menu Url
	if(!empty($_POST['MenuUrl']))
	{
		$menu_url = mysqli_real_escape_string($conn, trim($_POST['MenuUrl']));
	}
	else
	{
		$validate_error = 1;
		$error = 1;
		$msg .= $menu_url_empty_msg;
	}
	
	// Get Menu Target
	if(!empty($_POST['MenuTarget']))
	{
		$menu_target = mysqli_real_escape_string($conn, $_POST['MenuTarget']);
	}
	else
	{
		$menu_target = '';
	}
	
	// Get Menu Title
	if(!empty($_POST['MenuTitle']))
	{
		$menu_title = mysqli_real_escape_string($conn, trim($_POST['MenuTitle']));
	}
	else
	{
		$menu_title = '';
	}
	
	// Get dropdownlist Parent Label and Id
	if(!empty($_POST['ddlParentLabel']) && !empty($menu_label))
	{
		$sent_parent_label = mysqli_real_escape_string($conn, $_POST['ddlParentLabel']);
		list($sent_parent_id, $sent_parent_label) = explode('|', $sent_parent_label);

		// 1. if the LABEL has CHANGED but the PARENT has NOT, and the parent IS TOP LEVEL with the id of zero (0)
		if($current_menu_label != $sent_menu_label && $current_parent_label == $sent_parent_label && $current_parent_id == 0)
		{
			$parent_id = $current_parent_id;
			$parent_label = $menu_label;
		}
		
		// 2. if the LABEL has CHANGED but the PARENT has NOT, and the parent is NOT TOP LEVEL
		if($current_menu_label != $sent_menu_label && $current_parent_label == $sent_parent_label && $current_parent_id != 0)
		{
			$parent_id = $current_parent_id;
			$parent_label = $sent_parent_label;
		}
		
		// 3. if the LABEL has NOT CHANGED but the parent HAS CHANGED
		if($current_menu_label == $sent_menu_label && $current_parent_label != $sent_parent_label)
		{
			$parent_id = $sent_parent_id;
			$parent_label = $sent_parent_label;
		}
		
		// 4. if NEITHER the LABEL NOR the PARENT LABEL has CHANGED
		if($current_menu_label == $sent_menu_label && $current_parent_label == $sent_parent_label)
		{
			$parent_id = $current_parent_id;
			$parent_label = $current_parent_label;
		}
		
		// 5. if sent parent label equals _TopLevel
		if($sent_parent_label == '_TopLevel')
		{
			$parent_id = 0;
			$parent_label = $menu_label;
		}
	}
	
	// Get Ordinal Position
	if(!empty($_POST['OrdinalPosition']) && is_numeric($_POST['OrdinalPosition']) && $_POST['OrdinalPosition'] >= 0)
	{
		$ordinal_position = mysqli_real_escape_string($conn, trim($_POST['OrdinalPosition']));
	}
	else
	{
		$validate_error = 1;
		$error = 1;
		$msg .= $ordinal_position_msg;
	}
	
	// Get Menu Description
	if(!empty($_POST['MenuDescription']))
	{
		$menu_description = mysqli_real_escape_string($conn, trim($_POST['MenuDescription']));
	}
	else
	{
		$menu_description = '';
	}

	// Get IsEnabled
	if(isset($_POST['IsEnabled']))
	{
		$is_enabled = 1;
	}
	else
	{
		$is_enabled = 0;
	}
	
	// update menu item
	if($validate_error == 0)
	{
		$update_menu_item = mysqli_query($conn, "UPDATE menus SET MenuName = '$menu_name', Url = '$menu_url', Target = '$menu_target', Label = '$menu_label', Title = '$menu_title', Description = '$menu_description', ParentId = $parent_id, ParentLabel = '$parent_label', OrdinalPosition = $ordinal_position, IsEnabled = $is_enabled WHERE MenuId = $menu_id")
		or die($dataaccess_error);
		
		if(mysqli_affected_rows($conn) > 0)
		{
			echo $menu_update_success;
		}
		else
		{
			echo $no_changes_made;
		}
	}
	
	// show banner if not 0
	if($error == 1)
	{
		echo $general_banner_error;
	}
}

// ------------------------------------------------------------
// DISPLAY MENU DETAILS ON PAGE LOAD
// ------------------------------------------------------------
if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
{
	$menu_id = $sent_id;
	
	$get_menu_details = mysqli_query($conn, "SELECT * FROM menus WHERE MenuId = $menu_id LIMIT 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_menu_details) == 1 )
	{
		$row = mysqli_fetch_array($get_menu_details);
		$menu_name = $row['MenuName'];
		$menu_label = $row['Label'];
		$parent_label = $row['ParentLabel'];
		$parent_id = $row['MenuId'];
		$menu_url = $row['Url'];
		$menu_target = $row['Target'];
		$menu_title = $row['Title'];
		$ordinal_position = $row['OrdinalPosition'];
		$menu_description = $row['Description'];
		$is_enabled = $row['IsEnabled'];
		if($is_enabled == 1){$checked1 = 'checked="checked"';}else{$checked1 = '';}
	}
	else
	{
		exit();
	}
}
?>