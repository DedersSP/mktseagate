<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class produtos extends base {

    function __construct($campos = array()) {
        parent::__construct();
        $this->tabela = "produtos";
        if (sizeof($campos) <= 0){
            $this->campos_valores = array(
            "id_produtos" => NULL,
            "segmento_produtos" => NULL,
            "nome_produtos" => NULL);
        }else {
            $this->campos_valores = $campos;
        }
        $this->campopk = "id_produtos";
    }//fim construct
    

}//fim classe


