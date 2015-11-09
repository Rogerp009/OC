<?php

$get_roles = mysqli_query($conn, "SELECT RoleName FROM roles")
or die($dataaccess_error);


$get_user_in_roles = mysqli_query($conn, "SELECT RoleName FROM users_in_roles WHERE UserId = $user_id")
or die($dataaccess_error);

while($row2 = mysqli_fetch_array($get_user_in_roles))
{
	$user_in_role[] = $row2['RoleName'];
}


while($row1 = mysqli_fetch_array($get_roles))
{
	$role_name = $row1['RoleName'];
	echo '<label class="label"><input type="checkbox" name="checked[]" value='.$role_name.' class="checkbox" '.(in_array($role_name, $user_in_role) ? 'checked="checked"' : '').'>'.$role_name.'</label>';
}
?>