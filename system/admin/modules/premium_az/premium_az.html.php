<form action="" method="post" name="users_az" target="_self" class="htmlForm">
  <!-- gridview -->
  <div class="gridView">
    <table id="premium_az" cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th id="column0">#</th>
          <th id="column1"><input type="checkbox" name="chkAll" id="chkAll" onclick="toggleChecked(this.checked)" title="Check All Checkboxes." /></th>
          <th id="column2"><a href="?col=1" title="sort this column">User Name</a></th>
          <th id="column3"><a href="?col=2" title="sort this column">Email</a></th>
          <th id="column4"><a href="?col=3" title="sort this column">Approved?</a></th>
          <th id="column5"><a href="?col=4" title="sort this column">Locked Out?</a></th>
          <th id="column6"><a href="?col=5" title="sort this column">Logged In?</a></th>
          <th id="column7"><a href="?col=6" title="sort this column">Create Date</a></th>
        </tr>
      </thead>
      <tbody>
        <?php require_once(ROOT_PATH.'admin/modules/premium_az/premium_az.php'); ?>
        <!-- msg --> 
        <?php echo $msg; ?>
      <tbody>
    </table>
  </div>
  <div class="gvActionsWrap"> 
    <!-- gridview jump menu -->
    <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)" class="jumpMenu">
      <option value="premium-a-z.php">display</option>
      <option value="premium-a-z.php?display=1">1</option>
      <option value="premium-a-z.php?display=5">5</option>
      <option value="premium-a-z.php?display=10">10</option>
      <option value="premium-a-z.php?display=15">15</option>
      <option value="premium-a-z.php?display=20">20</option>
      <option value="premium-a-z.php?display=25">25</option>
      <option value="premium-a-z.php?display=50">50</option>
      <option value="premium-a-z.php?display=100">100</option>
      <option value="premium-a-z.php?display=1000">1000</option>
    </select>
    <!-- include paging interface -->
    <?php require_once(ROOT_PATH.'admin/modules/premium_az/premium_az.paging.php'); ?>
    <div class="clearBoth"></div>
    <!-- gridview buttons -->
    <?php require_once(ROOT_PATH.'admin/modules/shared/gv_buttons.php'); ?>
  </div>
</form>
