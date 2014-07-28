<?php 
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

/**
 * Classe sessão para acesso de login
 */
class sessao {
    //propriedades
    protected $id; //armarzena o id da sessão
    protected $nvars; //numero de campos que a sessão tem.
    
    //inicia uma sessão por padrão.
    public function __construct($inicia = true) {
            if ($inicia == TRUE) :
                    $this->start();
            endif;
    }//construct

    //start na sessão inicia uma sessão
    public function start(){
        session_start();
    $this->id = session_id();
    $this->setNvars();
    }//função Start

    //vai pegar todas as variáveis da sessão e calcula a quantidade de variáveis.
    public function setNvars(){
        $this->nvars = sizeof($_SESSION);
    }//Set a variavel nVars a quantidade

    public function getNvars(){
        return $this->nvars;
    }//getNvars retorna as variaveis

    public function setVar($var, $valor){
        $_SESSION[$var] = $valor;
        $this->setNvars();
    }//setVar

    public function unsetVar($var){
        unset($_SESSION[$var]);
        $this->setNvars();
    }//unsetVar

    public function getVar($var){
        if (isset($_SESSION[$var])) {
            return $_SESSION[$var];
        }else {
            return NULL;
        };
    }//getVar

    public function destroy($inicia = false){
        session_unset();
        session_destroy();
        $this->setNvars();
        if ($inicia == true) {
            $this->start();
        };
    }//destroy

    public function printAll(){
        foreach ($_SESSION as $key => $value){
            printf("%s = %s<br>", $key, $value);
        };
    }// printAll
	
}// classe sessão..
?>