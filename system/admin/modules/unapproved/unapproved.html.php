<form action="" method="post" name="users_unapproved" target="_self" class="htmlForm">
  <!-- gridview -->
  <div class="gridView">
    <table id="users_az" cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th id="column0">#</th>
          <th id="column1"><input type="checkbox" name="chkAll" id="chkAll" onclick="toggleChecked(this.checked)" title="Check All Checkboxes." /></th>
          <th id="column2"><a href="?col=1" title="sort this column">Nombre de Usuario</a></th>
          <th id="column3"><a href="?col=2" title="sort this column">Correo</a></th>
          <th id="column4"><a href="?col=3" title="sort this column">Aprobado</a></th>
          <th id="column5"><a href="?col=4" title="sort this column">Bloqueado</a></th>
          <th id="column6"><a href="?col=5" title="sort this column">Iniciado</a></th>
          <th id="column7"><a href="?col=6" title="sort this column">Fecha de creacion</a></th>
        </tr>
      </thead>
      <tbody>
        <?php require_once(ROOT_PATH.'admin/modules/unapproved/unapproved.php'); ?>
        <!-- msg --> 
        <?php echo $msg; ?>
      <tbody>
    </table>
  </div>
  <div class="gvActionsWrap"> 
    <!-- gridview jump menu -->
    <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)" class="jumpMenu">
      <option value="unapproved-users.php">Mostrar</option>
      <option value="unapproved-users.php?display=100">TODOS</option>

    </select>
    <!-- include paging interface -->
    <?php require_once(ROOT_PATH.'admin/modules/unapproved/unapproved.paging.php'); ?>
    <div class="clearBoth"></div>
    <!-- gridview buttons -->
  </div>
</form>