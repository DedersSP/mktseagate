<?php 
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

/**
* Classe de ususários, pelo que estou entendendo tenho que colocar tudo que for relacionado ao usuário, insert, update, edit e consultas.
* by @DedersSP and @Mktreports
*/
class usuarios extends base {
	
    public function __construct($campos = array()) {
            parent::__construct();

            $this->tabela = "usuarios";

            if (sizeof($campos) <= 0){
                    $this->campos_valores = array(
                        "nome_user" => NULL,
                        "email_user" => NULL,
                        "senha_user" => NULL,
                        "ativo_user" => NULL,
                        "adm_user" => NULL);
            }else {
                    $this->campos_valores = $campos;
            };

            $this->campopk = "id_user";
    }//__construct acessa a tabela de usuarios, verifica a quantidade de intens no array Objeto, se for <= que 0, joga no "campos_valores" um novo array com dados null.

public function doLogin($objeto) {	    
    $objeto->extras_select = "WHERE email_user='".$objeto->getValor('email_user')."' AND senha_user='".codificaSenha($objeto->getValor('senha_user'))."' AND ativo_user = 's' ";
    $this->selecionaTudo($objeto);
    $sessao = new sessao();
    if ($this->linhasAfetadas == 1){
        $uslogado = $objeto->retornaDados();
        $sessao->setVar('iduser', $uslogado->id_user);
        $sessao->setVar('nomeuser', $uslogado->nome_user);
        $sessao->setVar('emailuser', $uslogado->email_user);
        $sessao->setVar('ativouser', $uslogado->ativo_user);
        $sessao->setVar('admuser', $uslogado->adm_user);
        $sessao->setVar('logado', TRUE);
        $sessao->setVar('ip', $_SERVER['REMOTE_ADDR']);
        return true;
    } else{
        $sessao->destroy(TRUE);
        return false;
    };
}//doLogin esta recebendo os dados da tela de login, verifica se tem no banco, seleciona os dados, e retorna um true ou false se == a 1;
	
public function doLogout(){
        $sessao = new sessao();
        $sessao->destroy(TRUE);
        redireciona('?erro=1');
}//doLogout
	
public function existeUser($campo = null, $valor = null) {
    if ($campo != null && $valor != null) {
        if (is_numeric($valor)) {
                $valor = $valor;
        } else{
                $valor = "'".$valor."'";
        };
        $this->extras_select = "WHERE $campo=$valor";
        $this->selecionaTudo($this);
        if ($this->linhasAfetadas > 0) {
            return TRUE;
        } else {
            return FALSE;
        };
    } else {
        $this->trataErro(__FILE__, __FUNCTION__, NULL, 'Faltam parâmetros para executar a função.', TRUE);
    };
}

}//fim classe usuarios.
?>