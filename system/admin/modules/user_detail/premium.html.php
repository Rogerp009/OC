<?php require_once(ROOT_PATH.'admin/modules/user_detail/premium.php'); ?>

<div class="detailsWrap">
  <form name="frmPremium" method="post" action="" class="htmlForm">
    <fieldset>
      <legend>FUNCIONES DE PAGO:</legend>
      <div class="divider"></div>

      <p title="<?php echo $is_active_title; ?>">
        <label for="is_premium">ACTIVO</label>
        <input type="checkbox" name="is_premium" id="is_premium" class="checkbox" value="<?php echo $is_premium; ?>" <?php echo $checked1; ?>>
      </p>
      <p title="<?php echo $premium_level_title; ?>">
        <label for="premium_levels">CURSO:</label>
        <select name="premium_levels">
          <option value="<?php echo $premium_level; ?>" selected="selected"><?php echo $premium_level; ?></option>
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
        </select>
      </p>
      <p title="<?php echo $premium_types_title; ?>">
        <label for="premium_types">TIPO DE PAGO</label>
        <select name="premium_types">
          <option value="<?php echo $membership_type; ?>" selected="selected"><?php echo $membership_type; ?></option>
          <option value="Free Membership">Free User</option>
          <?php echo $membership_types; ?>
        </select>
      </p>

      <input name="UpdatePremium" type="submit" value="Grabar" class="gvbtn btn" onclick="return confirm('Seguro?');"/>
    </fieldset>

  </form>
</div>