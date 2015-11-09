<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL.'admin/themes/default/superfish.css' ?>" media="screen"/>
<?php require_once(ROOT_PATH.'js/jquery/jquery.php'); ?>
<script type="text/javascript" src="<?php echo SITE_URL.'js/jquery/jquery.cookie.js' ?>"></script>
<script type="text/javascript" src="<?php echo SITE_URL.'js/jquery/tabs-memory.js' ?>"></script>
<script type="text/javascript" src="<?php echo SITE_URL.'js/superfish/hoverIntent.js' ?>"></script>
<script type="text/javascript" src="<?php echo SITE_URL.'js/superfish/superfish.js' ?>"></script>
<script type="text/javascript" src="<?php echo SITE_URL.'js/jquery/check-all.js' ?>"></script>
<script type="text/javascript" src="<?php echo SITE_URL.'js/jquery/jump-menu.js' ?>"></script>
<script type="text/javascript" src="<?php echo SITE_URL.'js/jquery/modal.js' ?>"></script>
<script type="text/javascript" src="<?php echo SITE_URL.'admin/themes/custom.js' ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    var azLetter = "<?php if(isset($_GET['az'])){echo $_GET['az'];} ?>";
    if (azLetter != '') {
        $('#' + azLetter).addClass('selected');
    }
});
</script>