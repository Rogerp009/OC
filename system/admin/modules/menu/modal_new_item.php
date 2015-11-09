<?php
// get required includes
require(ROOT_PATH.'admin/modules/menu/error_messages.php');

// declare variables
$msg = '';

// ------------------------------------------------------------
// INSERT NEW MENU
// ------------------------------------------------------------
if(isset($_POST['btnInsertMenuItem']))
{
	$validate_error = 0;
	$error = 0;
	
	// Get Menu Name (group)
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
	
	// Get Menu Label
	if(!empty($_POST['MenuLabel']) && !empty($menu_name))
	{
		$sent_menu_label = mysqli_real_escape_string($conn, trim($_POST['MenuLabel']));
		
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
	
	// Get Parent Label and Id
	if(!empty($_POST['ddlParentLabel']) && !empty($menu_label))
	{
		$sent_parent_label = mysqli_real_escape_string($conn, $_POST['ddlParentLabel']);

		if($sent_parent_label == '_TopLevel')
		{
			$parent_id = 0;
			$parent_label = $menu_label;
		}
		else
		{
			list($value_id, $value_label) = explode('|', $sent_parent_label);
			$parent_id = $value_id;
			$parent_label = $value_label;
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
	
	// insert menu item
	if($validate_error == 0)
	{
		$insert_menu_item = mysqli_query($conn, "INSERT INTO menus(MenuName,Url,Target,Label,Title,Description,ParentId,ParentLabel,OrdinalPosition,IsEnabled) VALUES('$menu_name','$menu_url','$menu_target','$menu_label','$menu_title','$menu_description',$parent_id,'$parent_label',$ordinal_position,$is_enabled)")
		or die($dataaccess_error);
		
		if(mysqli_affected_rows($conn) > 0)
		{
			echo $menu_insert_success;
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
?>