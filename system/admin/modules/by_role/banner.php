<div class="gvBanner">
  <form id='frmSearch' name='frmSearch' method='post' action="<?php echo SITE_URL.'admin/users-by-role.php' ?>" class='htmlForm'>
    <span class="title"> Usuarios por Rol: </span>
    <select name="ddlUserRoles" class="rolesSelect" title="Seleccionar de los Roles Disponibles." onchange="this.form.submit();">
      <option selected="selected">Seleccionar un Rol</option>
      <?php require(ROOT_PATH.'admin/modules/shared/get_roles.php'); ?>
      <option>All</option>
    </select>
    <?php if(isset($_POST['ddlUserRoles'])){echo '<span class="selectedRole">Rol seleccionado: '.$_POST['ddlUserRoles'].'</span>';}elseif(isset($_SESSION['select_q'])){echo '<span class="selectedRole">Rol Seleccionado: '.$_SESSION['select_q'].'</span>';} ?>
  </form>
</div>
