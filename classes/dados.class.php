<?php 
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

class dados extends base {

    public function __construct($campos = array()) {
        parent::__construct();
        $this->tabela = "dados";
        if (sizeof($campos) <= 0) {
            $this->campos_valores = array(
            "id_users" => NULL,
            "nome_users" => NULL,
            "id_lojas" => NULL,
            "nome_lojas" => NULL,
            "data_dados" => NULL,
            "segmento_produto_dados" => NULL,
            "produto_dados" => NULL,
            "preco_dados" => NULL,
            "pecas_vitrine_dados" => NULL,
            "semproduto_dados" => NULL,
            "pecas_estoque_dados" => NULL,
            "registro_dados" => NULL);
        } else {
            $this->campos_valores = $campos;
        }
        $this->campopk = "id_dados";
    }// fim construct
    
    public function verificaRegistro($campo1 = NULL, $valor1 = NULL, $campo2 = NULL, $valor2 = NULL) {
        if ($campo1 != NULL && $valor1 != NULL && $campo2 != NULL && $valor2 != NULL) {
            $valor1 = $valor1;
            $valor2 = $valor2;
            $this->extras_select = "WHERE $campo1 = $valor1 AND $campo2 = $valor2";
            $this->selecionaTudo($this);
            if ($this->linhasAfetadas > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }//fim verifica registro

}//fim classe dados
?>