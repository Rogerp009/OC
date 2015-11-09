<?php require_once(ROOT_PATH.'admin/modules/download/downloads_new.php');?>
<form name="frmDownloadNew" method="post" action="" class="htmlForm" enctype="multipart/form-data">
  <div class="detailsWrap marginTop10">
    <fieldset>
      <legend>AÑADIR NUEVA DESCARGA PARA CURSO:</legend>
      <div class="divider"></div>
      <!-- msg -->
      <ul>
        <?php echo $msg; ?>
      </ul>
      <p title="<?php echo $is_enabled_title; ?>">
        <label for="is_enabled">Permitido</label>
        <input type="checkbox" name="is_enabled" id="is_enabled" class="checkbox">
      </p>
      <p title="<?php echo $premium_level_title; ?>">
        <label for="premium_levels">Nivel de Acceso de Curso:</label>
        <input id="premium_levels" name="premium_levels" type="text" maxlength="100">
      </p>
      <p title="<?php echo $download_name_title; ?>">
        <label for="download_name">Nombre de Descarga:</label>
        <input name="download_name" type="text" id="download_name" maxlength="100">
      </p>
      <p title="<?php echo $file_name_title; ?>">
        <label for="fileUpload">Seleccionar Archivo:</label>
        <input name="fileUpload" type="file" id="fileUpload" maxlength="255" >
      </p>
      <!-- buttons -->
      <input name="btnNewDownload" type="submit" value="Guardar" class="btn" onclick="return confirm('Listo?');" title="Guardado." />
    </fieldset>
  </div>
 </form>