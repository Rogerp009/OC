<?php require_once(ROOT_PATH.'admin/modules/download/download_details.php');?>
<form name="frmDownloadDetails" method="post" action="" class="htmlForm">
  <div class="detailsWrap marginTop10">
    <fieldset>
      <legend>EDITAR ARCHIVO:</legend>
      <div class="divider"></div>
      <!-- msg -->
      <ul>
        <?php echo $msg; ?>
      </ul>
      <p title="<?php echo $is_enabled_title; ?>">
        <label for="is_enabled">Permitido</label>
        <input type="checkbox" name="is_enabled" id="is_enabled" class="checkbox" value="<?php echo $is_enabled; ?>" <?php echo $checked1; ?>>
      </p>
      <p title="<?php echo $premium_level_title; ?>">
        <label for="premium_levels">Nivel Curso de Acceso:</label>
        <input name="premium_levels" type="text" id="premium_levels" maxlength="100" value="<?php echo $premium_level; ?>">
      </p>
      <p title="<?php echo $download_name_title; ?>">
        <label for="download_name">Nombre de Descarga:</label>
        <input name="download_name" type="text" id="download_name" maxlength="100" value="<?php echo $download_name; ?>">
      </p>
      <p title="<?php echo $file_name_title; ?>">
        <label for="file_name">Nombre del Archivo:</label>
        <input name="file_name" type="text" disabled id="file_name" value="<?php echo $file_name; ?>" maxlength="150">
      </p>
      <p title="<?php echo $date_added_title; ?>">
        <label for="date_added">Subido:</label>
        <input name="date_added" type="text" disabled id="date_added" value="<?php echo $date_added; ?>" maxlength="19">
      </p>
      <p title="<?php echo $date_modified_title; ?>">
        <label for="date_modified">Ultima Edicion:</label>
        <input name="date_modified" type="text" disabled id="date_modified" value="<?php echo $date_modified; ?>" maxlength="19">
      </p>
      <!-- buttons -->
      <input name="btnUpdateDownload" type="submit" value="Guardar" class="btn" onclick="return confirm('Listo?');" title="Listo." />
    </fieldset>
  </div>
</form>