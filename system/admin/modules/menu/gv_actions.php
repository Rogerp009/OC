<?php
// get required includes
require_once(ROOT_PATH.'admin/modules/menu/error_messages.php');

// ------------------------------------------------------------
// GRIDVIEW JAVASCRIPT
// ------------------------------------------------------------
// buttons
$delete_selected_js = "return confirm('NOTE: Undeleted Child Items of Deleted Parent Items Will be Orphaned. \\r\\nYou can move these Items to an available Parent by using the Move To Parent selection box below. \\r\\n\\r\\nDELETE the SELECTED menu item(s)?');";
$delete_all_js = "return confirm('DELETE ALL menu item(s)? \\r\\nWARNING! This action cannot be undone.');";
$enable_selected_js = "return confirm('ENABLE the SELECTED menu item(s)?');";
$enable_all_js = "return confirm('ENABLE ALL menu item(s)?');";
$disable_selected_js = "return confirm('DISABLE the SELECTED menu item(s)?');";
$disable_all_js = "return confirm('DISABLE ALL menu item(s)?');";
$move_selected_js = "if(confirm('ADD Selected Menu Item(s) To SELECTED MENU GROUP?'))form.submit();else return false;";
$move_to_parent_js = "if(confirm('ADD Selected Menu Item(s) To SELECTED PARENT MENU ITEM?'))form.submit();else return false;";
$delete_selected_group_js = "if(confirm('DELETE Selected MENU GROUP \\r\\nand ALL Associated MENU ITEMS?'))form.submit();else return false;";

// declare variables
$msg = '';
$validate_error = 0;

// ------------------------------------------------------------
// PREVENT MORE THAN ONE DROPDOWNLIST FROM BEING SUBMITTED
// ------------------------------------------------------------
/* 	
	PROBLEM:
	if ddl submission is cancelled (js alert), the selected item remains. 
	If another button or ddl is submitted, both submissions are executed.
	SOLVED... 
*/
// 1. all three selected
if(isset($_POST['ddlAddToParent']) && $_POST['ddlAddToParent'] != 'Move To Parent' 
&& isset($_POST['ddlAddSelected']) && $_POST['ddlAddSelected'] != 'Move To Group' 
&& isset($_POST['ddlDeleteGroup']) && $_POST['ddlDeleteGroup'] != 'Delete Menu Group'
// 2. 1+2 selected
|| isset($_POST['ddlAddToParent']) && $_POST['ddlAddToParent'] != 'Move To Parent' 
&& isset($_POST['ddlAddSelected']) && $_POST['ddlAddSelected'] != 'Move To Group'
// 3. 1+3 selected
|| isset($_POST['ddlAddToParent']) && $_POST['ddlAddToParent'] != 'Move To Parent' 
&& isset($_POST['ddlDeleteGroup']) && $_POST['ddlDeleteGroup'] != 'Delete Menu Group' 
// 4. 2+3 selected
|| isset($_POST['ddlAddSelected']) && $_POST['ddlAddSelected'] != 'Move To Group' 
&& isset($_POST['ddlDeleteGroup']) && $_POST['ddlDeleteGroup'] != 'Delete Menu Group')
{
	$validate_error = 1;
}

// ------------------------------------------------------------
// DELETE SELECTED MENU ITEMS
// ------------------------------------------------------------
if(isset($_POST['btnDeleteSelected']) && isset($_POST['checked']) && $validate_error == 0)
{
	$checked = array_map('intval',$_POST['checked']);
	$delete_list = implode(", ", $checked);
	
	$delete_selected = mysqli_query($conn, "DELETE FROM menus WHERE MenuId IN ($delete_list)")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) MENU ITEMS have been DELETED..</div>";
	}
}
elseif(isset($_POST['btnDeleteSelected']) && !isset($_POST['checked']))
{
	$msg = $nothing_checked_error;
}

// ------------------------------------------------------------
// DELETE ALL MENU ITEMS
// ------------------------------------------------------------
if(isset($_POST['btnDeleteAll']) && $validate_error == 0)
{
	$delete_all = mysqli_query($conn, "DELETE FROM menus")
	or die($dataaccess_error);
	
	if($delete_all)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox3'>SUCCESS: ALL ($effected_rows) MENU ITEMS have been DELETED..</div>";
	}
}

// ------------------------------------------------------------
// ENABLE SELECTED MENU ITEMS
// ------------------------------------------------------------
if(isset($_POST['btnEnableSelected']) && isset($_POST['checked']) && $validate_error == 0)
{
	$checked = array_map('intval',$_POST['checked']);
	$enable_list = implode(", ", $checked);
	
	$enable_selected = mysqli_query($conn, "UPDATE menus SET IsEnabled = 1 WHERE MenuId IN ($enable_list)")
	or die($dataaccess_error);
	
	if($enable_selected)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED MENU ITEM(s) have been ENABLED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: SELECTED MENU ITEM(s) were ALREADY ENABLED. Transaction CANCELLED...</div>";
		}
	}
}
elseif(isset($_POST['btnEnableSelected']) && !isset($_POST['checked']))
{
	$msg = $nothing_checked_error;
}

// ------------------------------------------------------------
// ENABLE ALL MENU ITEMS
// ------------------------------------------------------------
if(isset($_POST['btnEnableAll']) && $validate_error == 0)
{
	$enable_all = mysqli_query($conn, "UPDATE menus SET IsEnabled = 1")
	or die($dataaccess_error);
	
	if($enable_all)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ALL ($effected_rows) MENU ITEM(S) have been ENABLED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: ALL MENU ITEMS were ALREADY ENABLED. Transaction CANCELLED...</div>";
		}
	}
}

// ------------------------------------------------------------
// DISABLE SELECTED MENU ITEMS
// ------------------------------------------------------------
if(isset($_POST['btnDisableSelected']) && isset($_POST['checked']) && $validate_error == 0)
{
	$checked = array_map('intval',$_POST['checked']);
	$disable_list = implode(", ", $checked);
	
	$disable_selected = mysqli_query($conn, "UPDATE menus SET IsEnabled = 0 WHERE MenuId IN ($disable_list)")
	or die($dataaccess_error);
	
	if($disable_selected)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED MENU ITEM(S) have been DISABLED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: SELECTED MENU ITEMS were ALREADY DISABLED. Transaction CANCELLED...</div>";
		}
	}
}
elseif(isset($_POST['btnDisableSelected']) && !isset($_POST['checked']))
{
	$msg = $nothing_checked_error;
}

// ------------------------------------------------------------
// DISABLE ALL MENU ITEMS
// ------------------------------------------------------------
if(isset($_POST['btnDisableAll']) && $validate_error == 0)
{
	$disable_all = mysqli_query($conn, "UPDATE menus SET IsEnabled = 0")
	or die($dataaccess_error);
	
	if($disable_all)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ALL ($effected_rows) MENU ITEM(S) have been DISABLED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: ALL MENU ITEMS were ALREADY DISABLED. Transaction CANCELLED...</div>";
		}
	}
}

// ------------------------------------------------------------
// MOVE SELECTED MENU ITEMS TO SELECTED PARENT
// ------------------------------------------------------------
if(isset($_POST['ddlAddToParent']) && $_POST['ddlAddToParent'] != 'Move To Parent' && isset($_POST['checked']) && $validate_error == 0)
{
	// checked menu items
	$checked = array_map('intval',$_POST['checked']);
	$move_to_parent_list = implode(", ", $checked);
	
	// selected parent item 
	$sent_parent_item = mysqli_real_escape_string($conn, $_POST['ddlAddToParent']);
	list($sent_parent_id, $sent_parent_label) = explode('|', $sent_parent_item);

	$parent_id = $sent_parent_id;
	$parent_label = $sent_parent_label;
	
	// update database
	$move_selected = mysqli_query($conn, "UPDATE menus SET ParentId = $parent_id, ParentLabel = '$parent_label' WHERE MenuId IN ($move_to_parent_list)")
	or die($dataaccess_error);
	
	// display message
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED MENU ITEM(S) have been MOVED Under ($sent_parent_label)..</div>";
	}
	else
	{
		$msg = "<div class='msgBox4'>NOTE: SELECTED MENU ITEMS were ALREADY UNDER that PARENT. Transaction CANCELLED...</div>";
	}
}
elseif(isset($_POST['ddlAddToParent']) && $_POST['ddlAddToParent'] != 'Move To Parent' && !isset($_POST['checked']))
{
	$msg = $nothing_checked_error;
}

// ------------------------------------------------------------
// MOVE SELECTED MENU ITEMS TO SELECTED GROUP
// ------------------------------------------------------------
if(isset($_POST['ddlAddSelected']) && $_POST['ddlAddSelected'] != 'Move To Group' && isset($_POST['checked']) && $validate_error == 0)
{
	// checked items
	$checked = array_map('intval',$_POST['checked']);
	$move_selected_list = implode(", ", $checked);
	
	// selected menu group
	$selected_menu_group = mysqli_real_escape_string($conn, $_POST['ddlAddSelected']);
	
	$move_selected = mysqli_query($conn, "UPDATE menus SET MenuName = '$selected_menu_group' WHERE MenuId IN ($move_selected_list)")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED MENU ITEM(S) have been MOVED To ($selected_menu_group)..</div>";
	}
	else
	{
		$msg = "<div class='msgBox4'>NOTE: SELECTED MENU ITEMS were ALREADY IN That GROUP. Transaction CANCELLED...</div>";
	}
}
elseif(isset($_POST['ddlAddSelected']) && $_POST['ddlAddSelected'] != 'Move To Group' && !isset($_POST['checked']))
{
	$msg = $nothing_checked_error;
}

// ------------------------------------------------------------
// DELETE SELECTED MENU GROUP AND ALL ASSOCIATED ITEMS
// ------------------------------------------------------------
if(isset($_POST['ddlDeleteGroup']) && $_POST['ddlDeleteGroup'] != 'Delete Menu Group' && $validate_error == 0)
{	
	// selected menu group
	$selected_menu_group = mysqli_real_escape_string($conn, $_POST['ddlDeleteGroup']);
	
	// delete selected menu group
	$delete_group = mysqli_query($conn, "DELETE FROM menu_names WHERE MenuName = '$selected_menu_group'")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		// number of deleted groups
		$deleted_groups = mysqli_affected_rows($conn);
		
		// delete all menu items in selected menu group
		$delete_menu_items = mysqli_query($conn, "DELETE FROM menus WHERE MenuName = '$selected_menu_group'")
		or die($dataaccess_error);
		
		if(mysqli_affected_rows($conn) > 0)
		{
			// number of deleted menu items
			$deleted_items = mysqli_affected_rows($conn);
		}
		
		$msg = "<div class='msgBox3'>SUCCESS: ($deleted_groups) GROUP and ($deleted_items) MENU ITEM(S) have been DELETED..</div>";
	}
}

// ------------------------------------------------------------
// IF VALIDATION ERROR NOT ZERO (0)
// ------------------------------------------------------------
if($validate_error == 1)
{
	$msg = $multiple_submission_error;
}
?>