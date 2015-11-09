<?php
// get required includes
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'admin/modules/roles/error_messages.php');

// ------------------------------------------------------------
// GRIDVIEW JAVASCRIPT
// ------------------------------------------------------------
// buttons
$delete_selected_js = "return confirm('DELETE the SELECTED ROLE(S)? NOTE: DEFAULT ROLES will NOT be deleted.');";
$delete_all_js = "return confirm('WARNING! This action CANNOT be reversed. ALL ROLES other than the DEFAULTS will be DELETED.');";
$add_new_js = "return confirm('APPROVE the SELECTED user(s)?');";

// declare variables
$msg = '';

// ------------------------------------------------------------
// DELETE SELECTED ROLES
// ------------------------------------------------------------
if(isset($_POST['btnDeleteSelected']) && isset($_POST['checked']))
{
    $checked = array_map('intval',$_POST['checked']);
	$delete_list = implode(", ", $checked);
	
	$check_users_in_role = mysqli_query($conn, "SELECT * FROM users_in_roles WHERE RoleId IN ($delete_list)")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($check_users_in_role) > 0)
	{
		$msg = "<div class='msgBox2'>ERROR: CANNOT DELETE Roles that HAVE users IN THEM. FIRST: Please move the relevant USERS INTO another ROLE...</div>";
	}
	elseif(mysqli_num_rows($check_users_in_role) == 0)
	{
		$delete_selected = mysqli_query($conn, "DELETE FROM roles WHERE RoleId IN ($delete_list) AND NOT RoleName = 'owner' AND NOT RoleName = 'superadmin' AND NOT RoleName = 'administrator' AND NOT RoleName = 'member' AND NOT RoleName = 'user' ")
		or die($dataaccess_error);
		
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED ROLE(S) have been DELETED..</div>";
		}
		elseif(mysqli_affected_rows($conn) == 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox4'>NOTE: ($effected_rows) of the SELECTED ROLE(S) were DELETED...  </div>";
		}
	}	
}
elseif(isset($_POST['btnDeleteSelected']) && !isset($_POST['checked']))
{
	$msg = $msg_error;
}
// ------------------------------------------------------------
// DELETE ALL ROLES
// ------------------------------------------------------------
if(isset($_POST['btnDeleteAll']))
{
	$get_role_ids = mysqli_query($conn, "SELECT RoleId FROM roles")
	or die($dataaccess_error);
	
	$ids = '';
	while($row = mysqli_fetch_array($get_role_ids))
	{
		$role_id = $row['RoleId'];
		$ids .= $role_id.',';
	}
	
	$role_ids = rtrim($ids,',');
	
	$check_users_in_role = mysqli_query($conn, "SELECT * FROM users_in_roles WHERE RoleId IN ($role_ids) AND NOT RoleName = 'owner' AND NOT RoleName = 'superadmin' AND NOT RoleName = 'administrator' AND NOT RoleName = 'member' AND NOT RoleName = 'user'")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($check_users_in_role) > 0)
	{
		$msg = "<div class='msgBox2'>ERROR: CANNOT DELETE Roles that HAVE users IN THEM. FIRST: Please move the relevant USERS INTO another ROLE...</div>";
	}
	elseif(mysqli_num_rows($check_users_in_role) == 0)
	{
		$delete_role = mysqli_query($conn, "DELETE FROM roles WHERE NOT RoleName = 'owner' AND NOT RoleName = 'superadmin' AND NOT RoleName = 'administrator' AND NOT RoleName = 'member' AND NOT RoleName = 'user' ")
		or die($dataaccess_error);
		
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) ROLE(S) have been DELETED..</div>";
		}
		elseif(mysqli_affected_rows($conn) == 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox4'>NOTE: ($effected_rows) of the SELECTED ROLE(S) were DELETED...  </div>";
		}
	}
}
?>