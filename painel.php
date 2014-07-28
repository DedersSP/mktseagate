<?php 
include('header.php'); 

if (isset($_GET['m'])) {
    $modulo = $_GET['m'];
};

if (isset($_GET['t'])) {
    $tela = $_GET['t'];
};
?>
<div class="row">
<!--    <link rel="stylesheet" href="css/foundation/normalize.css">-->
    <link rel="stylesheet" href="css/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.1/css/jquery.dataTables.css">
    
    <script src="js/foundation/vendor/modernizr.js"></script>
    <script src="js/foundation/vendor/jquery.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="js/datatable/jquery.dataTables.min.js"></script>
    <script src="js/foundation/foundation.min.js"></script>

<?php
if ($modulo && $tela) {
    loadModulo($modulo, $tela);
} else {
    echo "<p>Escolha uma opção de menu para inciar</p>";
};
?>

</div>
<?php include('footer.php'); ?>

