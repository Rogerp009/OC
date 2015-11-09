<?php
// get required includes
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'admin/modules/roles/error_messages.php');

// declare variables
$msg = '';
$role_name = '';
$role_description = '';
// ------------------------------------------------------------
// CREATE NEW ROLE
// ------------------------------------------------------------
if(isset($_POST['NewRole']))
{
	if(!empty($_POST['role']))
	{
		$new_role = mysqli_real_escape_string($conn, $_POST['role']);
		$new_description = mysqli_real_escape_string($conn, $_POST['description']);
		
		// check if role exists
		$check_if_exist = mysqli_query($conn, "SELECT * FROM roles WHERE RoleName = '$new_role'")
		or die($dataaccess_error);
		
		if(mysqli_num_rows($check_if_exist) == 0)
		{
			// add new role
			$new_role = mysqli_query($conn, "INSERT INTO roles(RoleName, Description) VALUES('$new_role','$new_description')")
			or die($dataaccess_error);
			
			$msg = $role_success;
		}
		elseif(mysqli_num_rows($check_if_exist) == 1)
		{
			$msg = $role_exist_error;
		}
	}
	else
	{
		$msg = $new_role_error;
	}
}

// ------------------------------------------------------------
// UPDATE SELECTED ROLE
// ------------------------------------------------------------
if(isset($_POST['EditRole']))
{
	if(isset($_GET['rid']) && !empty($_GET['rid']) && is_numeric($_GET['rid']) && $_GET['rid'] > 0)
	{
		// get query string
		$sent_id = mysqli_real_escape_string($conn, $_GET['rid']);
		$role_id = $sent_id;
		
		// get form data
		$role_name = mysqli_real_escape_string($conn, $_POST['role']);
		$role_description = mysqli_real_escape_string($conn, $_POST['description']);

		// ------------------------------------------------------------
		// UPDATE USER ROLE
		// ------------------------------------------------------------
		if(isset($role_name) && !empty($role_name))
		{
			$new_role = mysqli_query($conn, "UPDATE roles SET RoleName = '$role_name', Description = '$role_description' WHERE RoleId = $role_id AND NOT RoleName = 'owner' AND NOT RoleName = 'superadmin' AND NOT RoleName = 'administrator' AND NOT RoleName = 'member' AND NOT RoleName = 'user'")
			or die($dataaccess_error);
			
			if(mysqli_affected_rows($conn) > 0)
			{
				$check_users_in_roles = mysqli_query($conn, "SELECT RoleName FROM users_in_roles WHERE RoleId = $role_id AND NOT RoleName = 'owner' AND NOT RoleName = 'superadmin' AND NOT RoleName = 'administrator' AND NOT RoleName = 'member' AND NOT RoleName = 'user'")
				or die($dataaccess_error);
				
				if(mysqli_num_rows($check_users_in_roles) > 0)
				{
					$update_users_in_roles = mysqli_query($conn, "UPDATE users_in_roles SET RoleName = '$role_name' WHERE RoleId = $role_id AND NOT RoleName = 'owner' AND NOT RoleName = 'superadmin' AND NOT RoleName = 'administrator' AND NOT RoleName = 'member' AND NOT RoleName = 'user'")
					or die($dataaccess_error);
				}
				
				$msg = $role_update_success;
			}
			else
			{
				$msg = $role_null_update;
			}
		}
		else
		{
			$msg = $role_empty_error;
		}
	}
	else
	{
		$msg = $msg_no_role_selected;
	}
}
?>