<?php
//constantes do sistema 
//diretorio do sistema
define("BASEPATH", dirname(__FILE__)."/");
define("BASEURL", "http://mktreports.com.br/web/seagate/");
define("ADMURL", BASEURL."painel.php");
define("CLASSESPATH", "classes/");
define("MODULOSPATH", "modulos/");
define("CSSPATH", "css/");
define("JSPATH", "js/");

//banco de dados
define("DBHOST", "http://dbmy0036.whservidor.com/");
define("DBUSER", "mktreports_1");
define("DBPASS", "mr4476seagate");
define("DBNAME", "mktreports_1");

// array para validar todas as constantes da configuração.
$constantes = array('BASEPATH', 'BASEURL', 'ADMURL', 'CLASSESPATH', 'MODULOSPATH', 'CSSPATH', 'JSPATH', 'DBHOST', 'DBUSER', 'DBPASS', 'DBNAME');
?>