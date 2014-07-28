<?php 
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

/**
 * Classe Base criação de cada classe e cada tabela que iremos criar.
 */
abstract class base extends banco {
    // propriedades    
    public $tabela = "";
    public $campos_valores = array();
    public $campopk = null;
    public $valorpk = null;
    public $extras_select = "";
    
    //métodos
    public function addCampo($campo = null, $valor = null) {
        if ($campo != null):
            $this->campos_valores[$campo] = $valor;            
        endif;        
    }// Add campos e valores no array
    
    public function delCampo($campo = null){
        if (array_key_exists($campo, $this->campos_valores)):
            unset($this->campos_valores[$campo]);
        endif;
    }// Delatar campos ou valor do array
    
    public function setValor($campo = null, $valor = null){
        if ($campo != null && $valor != null) {
            $this->campos_valores[$campo] = $valor;
        }else{
            echo "Não foi setada!!!";
        }
    }// função para setar um valor do array.
    
    public function getValor($campo = null){
        if ($campo != null && array_key_exists($campo, $this->campos_valores)) {
            return $this->campos_valores[$campo];
        }else{
            return FALSE;
        }
    }// getValor pega o valor e retorna para ser usado.
    
}// fim classe base
?>