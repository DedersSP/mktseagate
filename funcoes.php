<?php
//verifica se o arquivo config.php exite ai sim ele roda todo o sistema.
inicializa();
protegeArquivo(basename(__FILE__));

function inicializa(){
	
        if (file_exists(dirname(__FILE__).'/config.php')) {
                require_once(dirname(__FILE__).'/config.php');
        } else {
                die(utf8_decode('O arquivo de configuração não foi localizado, contate o administrador do sistema.'));
        }
        $constantes = array('BASEPATH', 'BASEURL', 'ADMURL', 'CLASSESPATH', 'MODULOSPATH', 'CSSPATH', 'JSPATH', 'DBHOST', 'DBUSER', 'DBPASS', 'DBNAME');
        foreach ($constantes as $valor) :
                if (!defined($valor)) {
                        die(utf8_decode('Uma configuração do sistema está ausente: '.$valor));
                }
        endforeach;
                require_once(BASEPATH.CLASSESPATH.'autoload.php');
        if ($_GET['logoff'] == TRUE) {
            $user = new usuarios();
            $user->doLogout();
            exit;
        };
        
}

//função para colocar os arquivos no head da pagina HTML
function loadCSS($arquivo = null, $media = 'screen', $import = false){
	if ($arquivo != null) {
		if ($import == true) {
			echo '<style type="text/css">@import url("'.BASEURL.CSSPATH.$arquivo.'.css");</style>'."\n";
		} else {
			echo '<link rel="stylesheet" type="text/css" href="'.BASEURL.CSSPATH.$arquivo.'.css" media="'.$media.'" />'."\n";
		}		
	}
}

//função para colocar os arquivos JS no head da pagina.
function loadJS($arquivo = null, $remoto = false){
if ($arquivo != NULL) {
        if ($remoto == false) {
                $arquivo = BASEURL.JSPATH.$arquivo.'.js';
                echo '<script type="text/javascript" src="'.$arquivo.'"></script>'."\n";
        }
}

}

//carregar o mófulo do nosso sistema.
function loadModulo($modulo = null, $tela = null){
    if ($modulo == null || $tela == null) {
        echo '<p>Erro na função <strong>'.__FUNCTION__.'</strong>: faltam parametros para execução.</p>';
    } else {
        if (file_exists(MODULOSPATH."$modulo.php")) {
            include_once(MODULOSPATH."$modulo.php");
        } else {
            echo '<p>Módulo inexistente neste sistema.</p>';
        };
    };
}// carrega o módulo que no nosso caso é usuarios e lojas. e a tela do modulo. Exemplo usuario>>login>>cadastro>>editar>>

//função para não deixar o usuario acessar os aruqivo pela url
function protegeArquivo($nomeArquivo, $redirPara='?erro=3'){
	$url = $_SERVER["PHP_SELF"];
	if (preg_match("/$nomeArquivo/i", $url)) {
		redireciona($redirPara);
	};
}

// irá redirecionar o usuario para o index
function redireciona($url=''){
	header("Location: ".BASEURL.$url);
}

// essa função vai codificar a senha digitada no form de login para comparar com a do banco.
function codificaSenha($senha) {
	return md5($senha);
}//codifica a senha.

function verificaLogin(){
   $sessao = new sessao();
   if ($sessao->getNvars() <= 0 && $sessao->getVar('logado') != TRUE && $sessao->getVar('ip') != $_SERVER['REMOTE_ADDR']) {
       redireciona('?erro=3');
   };
}//verificar login, se o cara pode acessar a sessão ou não.

function printMsg($msg = null, $tipo = null){
    if ($msg != null) :
        switch ($tipo) :
            case 'erro':
                    echo '<div class="alert-box alert radius">'.$msg.'</div>';
                break;
            
            case 'alerta':
                    echo '<div class="alert-box warning radius">'.$msg.'</div>';
                break;
                
            case 'pergunta':
            	   echo '<div class="alert-box info radius">'.$msg.'</div>';
            	break;
                
            case 'sucesso':
                    echo '<div class="alert-box success radius">'.$msg.'</div>';
                break;
                
            default:
                    echo '<div class="alert-box radius">'.$msg.'</div>';
                break;
        endswitch;                
    endif;
}

function isAdmin(){
    verificaLogin();
    $sessao = new sessao();
    $user = new usuarios(array('adm_user'=>NULL,));
    
    $iduser = $sessao->getVar('iduser');
    $user->extras_select = "where id_user=$iduser";
    $user->selecionaCampos($user);
    $res = $user->retornaDados();
    
    if (strtolower($res->adm_user) == 's' ) {
        return TRUE;
    }else {
        return FALSE;
    }
}

function antiInject($string){
        // remove palavras que contenham sintaxe sql
        $string = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i","",$string);
        $string = trim($string);//limpa espacos vazios
        $string = strip_tags($string);//tira tags html e php
        if(!get_magic_quotes_gpc())
        $string = addslashes($string);//Adiciona barras invertidas a uma string
        return $string;
}

//função da internet
function titleCase($string, 
        $delimiters = array(" ", "-", "O'"), $exceptions = array("se" ,"um", "uma", "em", "com", "aos", "aqui", "por", "dos", "das", "do", "da", "o", "e", "to", "a", "the", "of", "by", "and", "with", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X")) {
       /*
        * Exceptions in lower case are words you don't want converted
        * Exceptions all in upper case are any words you don't want converted to title case
        *   but should be converted to upper case, e.g.:
        *   king henry viii or king henry Viii should be King Henry VIII
        */
    $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");

       foreach ($delimiters as $dlnr => $delimiter){
               $words = explode($delimiter, $string);
               $newwords = array();
               foreach ($words as $wordnr => $word){
              
                       if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)){
                               // check exceptions list for any words that should be in upper case
                               $word = mb_strtoupper($word, "UTF-8");
                       }
                       elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)){
                               // check exceptions list for any words that should be in upper case
                               $word = mb_strtolower($word, "UTF-8");
                       }
                      
                       elseif (!in_array($word, $exceptions) ){
                               // convert to uppercase (non-utf8 only)
                            
                               $word = ucfirst($word);
                              
                       }
                       array_push($newwords, $word);
               }
               $string = join($delimiter, $newwords);
       }//foreach
       return $string;
}      

function mudaDataMysql($data){
    $dia = substr($data, 0,2);
    $mes = substr($data, 3,2);
    $ano = substr($data, 6,4);
    $data = $ano."/".$mes."/".$dia;
    return $data;
}

function moeda($get_valor) {
                $source = array('.', ',');
                $replace = array('', '.');
                $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
                return $valor; //retorna o valor formatado para gravar no banco
}
?>