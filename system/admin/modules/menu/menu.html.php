<form action="" method="post" name="users_az" target="_self" class="htmlForm">
  <!-- gridview -->
  <div class="gridView3">
    <table id="menu_az" cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th id="column0m">#</th>
          <th id="column1m"><input type="checkbox" name="chkAll" id="chkAll" onclick="toggleChecked(this.checked)" title="Check All Checkboxes." /></th>
          <th id="column2m"><a href="?col=2" title="sort this column">Label</a></th>
          <th id="column3m"><a href="?col=3" title="sort this column">Menu Group</a></th>
          <th id="column4m"><a href="?col=4" title="sort this column">Menu ID</a></th>
          <th id="column5m"><a href="?col=5" title="sort this column">Parent ID / Label</a></th>
          <th id="column7m"><a href="?col=6" title="sort this column">Position</a></th>
          <th id="column8m"><a href="?col=7" title="sort this column">Enabled?</a></th>
        </tr>
      </thead>
      <tbody>
        <?php require_once(ROOT_PATH.'admin/modules/menu/menu.php'); ?>
        <!-- msg --> 
        <?php echo $msg; ?>
      <tbody>
    </table>
  </div>
  <div class="gvActionsWrap"> 
    <!-- gridview jump menu -->
    <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)" class="jumpMenu">
      <option value="menus.php">display</option>
      <option value="menus.php?display=1">1</option>
      <option value="menus.php?display=5">5</option>
      <option value="menus.php?display=10">10</option>
      <option value="menus.php?display=15">15</option>
      <option value="menus.php?display=20">20</option>
      <option value="menus.php?display=25">25</option>
      <option value="menus.php?display=50">50</option>
      <option value="menus.php?display=100">100</option>
      <option value="menus.php?display=1000">1000</option>
    </select>
    <!-- include paging interface -->
    <?php require_once(ROOT_PATH.'admin/modules/menu/menu.paging.php'); ?>
    <div class="clearBoth"></div>
    <!-- gridview buttons -->
    <?php require_once(ROOT_PATH.'admin/modules/menu/gv_buttons.php'); ?>
  </div>
</form>