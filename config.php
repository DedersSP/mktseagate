<?php
//constantes do sistema 
//diretorio do sistema
define("BASEPATH", dirname(__FILE__)."/");
define("BASEURL", "http://localhost/projects/seagate/");
define("ADMURL", BASEURL."painel.php");
define("CLASSESPATH", "classes/");
define("MODULOSPATH", "modulos/");
define("CSSPATH", "css/");
define("JSPATH", "js/");

//banco de dados
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "seagate");

// array para validar todas as constantes da configuração.
//$constantes = array('BASEPATH', 'BASEURL', 'ADMURL', 'CLASSESPATH', 'MODULOSPATH', 'CSSPATH', 'JSPATH', 'DBHOST', 'DBUSER', 'DBPASS', 'DBNAME');
?>