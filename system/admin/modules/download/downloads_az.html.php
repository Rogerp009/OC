<form action="" method="post" name="downloads_az" target="_self" class="htmlForm">
  <!-- gridview -->
  <div class="gridView8">
    <table id="downloads_az" cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th id="column0d">#</th>
          <th id="column1d"><input type="checkbox" name="chkAll" id="chkAll" onclick="toggleChecked(this.checked)" title="Check All Checkboxes." /></th>
          <th id="column2d"><a href="?col=1" title="sort this column">Nombre de Descarga</a></th>
          <th id="column3d"><a href="?col=2" title="sort this column">Nombre de Archivo</a></th>
          <th id="column4d"><a href="?col=3" title="sort this column">Subido</a></th>
          <th id="column5d"><a href="?col=4" title="sort this column">Ultima Edicion</a></th>
          <th id="column6d"><a href="?col=5" title="sort this column">Permitido</a></th>
          <th id="column7d"><a href="?col=6" title="sort this column">Nivel Curso de Acceso</a></th>
        </tr>
      </thead>
      <tbody>
        <?php require_once(ROOT_PATH.'admin/modules/download/downloads_az.php'); ?>
        <!-- msg --> 
        <?php echo $msg; ?>
      <tbody>
    </table>
  </div>
  <div class="gvActionsWrap"> 
    <!-- gridview jump menu -->
    <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)" class="jumpMenu">
      <option value="downloads-a-z.php">display</option>
      <option value="downloads-a-z.php?display=1">1</option>
      <option value="downloads-a-z.php?display=5">5</option>
      <option value="downloads-a-z.php?display=10">10</option>
      <option value="downloads-a-z.php?display=15">15</option>
      <option value="downloads-a-z.php?display=20">20</option>
      <option value="downloads-a-z.php?display=25">25</option>
      <option value="downloads-a-z.php?display=50">50</option>
      <option value="downloads-a-z.php?display=100">100</option>
      <option value="downloads-a-z.php?display=1000">1000</option>
    </select>
    <!-- include paging interface -->
    <?php require_once(ROOT_PATH.'admin/modules/download/downloads_az.paging.php'); ?>

</form>