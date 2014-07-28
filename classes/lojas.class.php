<?php 
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

/**
 * Classe lojas, todos os comandos da tela loja, exibição etc...
 */
class lojas extends base {
	
	public function __construct($campos = array()) {
		parent::__construct();
        
        $this->tabela = "lojas";
        
        if (sizeof($campos) <= 0) :
            $this->campos_valores = array(
                "rede_lojas" => null,
                "nome_lojas" => null,
                "logradouro_lojas" => null,
                "complemento_lojas" => null,
                "bairro_lojas" => null,
                "cidade_lojas" => null,
                "uf_lojas" => null,
                "cnpj_lojas" => null,
                "canal_lojas" => null
            );
        else:
            $this->campos_valores = $campos;
        endif;

        $this->campopk = "id_lojas";
        
	}//fim function construct

    public function existeCNPJ($campo = null, $valor = NULL) {
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
        }
    }



}//fim class lojas

?>