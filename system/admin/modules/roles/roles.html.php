<form action="" method="post" name="users_unapproved" target="_self" class="htmlForm">
  <!-- gridview -->
  <div class="gridView2">
    <table id="users_az" cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th id="column0r">#</th>
          <th id="column1r"><input type="checkbox" name="chkAll" id="chkAll" onclick="toggleChecked(this.checked)" title="Check All Checkboxes." /></th>
          <th id="column2r"><a href="?col=1" title="sort this column">Role Name</a></th>
          <th id="column3r"><a href="?col=2" title="sort this column">Description</a></th>
          <th id="column4r"><a href="?col=3" title="sort this column">User Count</a></th>
        </tr>
      </thead>
      <tbody>
        <?php require_once(ROOT_PATH.'admin/modules/roles/roles.php'); ?>
        <!-- msg --> 
        <?php echo $msg; ?>
      <tbody>
    </table>
  </div>
  <div class="gvActionsWrap"> 
    <!-- gridview jump menu -->
    <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)" class="jumpMenu">
      <option value="roles.php">display</option>
      <option value="roles.php?display=1">1</option>
      <option value="roles.php?display=5">5</option>
      <option value="roles.php?display=10">10</option>
      <option value="roles.php?display=15">15</option>
      <option value="roles.php?display=20">20</option>
      <option value="roles.php?display=25">25</option>
      <option value="roles.php?display=50">50</option>
      <option value="roles.php?display=100">100</option>
      <option value="roles.php?display=1000">1000</option>
    </select>
    <!-- include paging interface -->
    <?php require_once(ROOT_PATH.'admin/modules/roles/roles.paging.php'); ?>
    <div class="clearBoth"></div>
    <!-- gridview buttons -->
    <?php require_once(ROOT_PATH.'admin/modules/shared/role_buttons.php'); ?>
  </div>
</form>