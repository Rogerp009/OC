<div class="topMenuWrap">
  <ul class="sf-menu">
    <li class="current"><a href="<?php echo SITE_URL.'index.php' ?>">Sitio</a>
      <ul>
        <li><a href="<?php echo SITE_URL.'index.php' ?>" target="_blank">Inicio</a></li>
        <li><a href="<?php echo SITE_URL.'user/index.php' ?>" target="_blank">Panel de Usuario</a></li>
      </ul>
    </li>
    <li class="current"> <a href="<?php echo SITE_URL.'admin/index.php' ?>">Cuentas</a>
      <ul>
        <li><a href="<?php echo SITE_URL.'admin/add-user.php' ?>">Agregar un Usuario</a></li>
        <li><a href="<?php echo SITE_URL.'admin/users-by-role.php' ?>">Usuarios por Tipo</a></li>
        <li><a href="<?php echo SITE_URL.'admin/unapproved-users.php' ?>">Usuarios sin Pagar</a></li>
      </ul>
    </li>
    <?php if(HIDE_PREMIUM_MEMBERSHIP_IN_ADMIN == 0){ ?>
    <li class="current"> <a href="<?php echo SITE_URL.'admin/premium.php' ?>">Premium</a>
      <ul>
          <ul>
          </ul>
        </li>
        <li><a href="<?php echo SITE_URL.'admin/downloads-a-z.php' ?>">Descargas</a>
          <ul>
            <li><a href="<?php echo SITE_URL.'admin/downloads-add-new.php' ?>" class="modal">Añadir Archivo</a></li>
          </ul>
        </li>

          <ul>
          </ul>
        </li>
          <ul>
          </ul>
        </li>
      </ul>
    </li>
    <?php } ?>
      <ul>
          <ul>
          </ul>
        </li>
          <ul>
          </ul>
        </li>
      </ul>
    </li>
 

  </ul>
  <div class="clearLeft"></div>
</div>
