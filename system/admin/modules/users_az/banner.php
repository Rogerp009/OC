<div class="gvBanner"> 
<span class="title"> Usuarios Registrados ...
<?php if(isset($_GET['az']) && !empty($_GET['az']) && strlen($_GET['az']) <= 2 && !is_numeric($_GET['az'])){echo '('.$_GET['az'].')';}else{echo '(%)';}?>
</span> 
</div>