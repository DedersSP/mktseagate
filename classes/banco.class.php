<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

abstract class banco{
    //propriedades
    public $servidor = DBHOST;
    public $usuario = DBUSER;
    public $senha = DBPASS;
    public $nomeBanco = DBNAME;
    public $conexao = NULL;
    public $dataSet = NULL;
    public $linhasAfetadas = -1;
    
//métodos
public function __construct(){
        $this->conecta();
}//construct

public function __destruct(){
        if ($this->conexao != NULL) {
                mysql_close($this->conexao);
        };
}//destruct

public function conecta(){
        $this->conexao = mysql_connect($this->servidor, $this->usuario, $this->senha, true) or die($this->trataErro(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(),TRUE));
        mysql_select_db($this->nomeBanco) or die($this->trataErro(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(),TRUE));
        //para alterar o charset para utf8 em todos os comandos.
        mysql_query("SET NAMES 'utf8'");                
        mysql_query("set character_set_connection = utf8");
        mysql_query("set character_set_client = utf8");
        mysql_query("set character_set_results = utf8");
        //echo "método conecta funcionando";
}//conecta ao banco de dados.
	
public function inserir($objeto){
    //insert into nomedatabela (campo1, campo2, campo3) values (campo1, campo2, campo3);
    $sql = "INSERT INTO ".$objeto->tabela." (";
    for ($i = 0; $i  < count($objeto->campos_valores); $i ++) { 
        $sql .= key($objeto->campos_valores);
        if ($i < (count($objeto->campos_valores) -1)) {
            $sql .= ", ";
        }else{
            $sql .= ") ";
        }
        next($objeto->campos_valores);
    };
    reset($objeto->campos_valores); //reseta o for, para retornar ao primeiro indice ou chave.
    $sql .= "VALUES (";
    for ($i=0; $i < count($objeto->campos_valores); $i++) {
        $sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ? $objeto->campos_valores[key($objeto->campos_valores)] : "'".$objeto->campos_valores[key($objeto->campos_valores)]."'";
        if ($i < (count($objeto->campos_valores) -1)) {
            $sql .= ", ";
        }else {
            $sql .= ") ";
        };
        next($objeto->campos_valores);
    };
    return $this->executaSQL($sql);
}// inserir.
	
	public function atualizar($objeto){
	    //update nomedatabela set campo1= valor1, campo2 = valor2 where campoPK = valorPK;
	    
        $sql = "UPDATE ".$objeto->tabela." SET ";
        
        for ($i = 0; $i  < count($objeto->campos_valores); $i ++) { 
            $sql .= key($objeto->campos_valores)."=";
            
            $sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ? 
                        $objeto->campos_valores[key($objeto->campos_valores)] : 
                        "'".$objeto->campos_valores[key($objeto->campos_valores)]."'";
        
            if ($i < (count($objeto->campos_valores) -1)) {
                $sql .= ", ";
            }else{
                $sql .= " ";
            };
            
            next($objeto->campos_valores);            
        };
        
        $sql .= "WHERE ".$objeto->campopk."=";
        $sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";                
        
        return $this->executaSQL($sql);
	}// função atualizar usuarios.
	
	public function deletar($objeto){
	    //delete from nomedatabela where campopk= valorpk;
        
        $sql = "DELETE FROM ".$objeto->tabela;
        $sql .= " WHERE ".$objeto->campopk." = ";
        $sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
        
        return $this->executaSQL($sql);
	}// deletar linha bo banco.
	
	public function selecionaTudo($objeto = NULL){
	    $sql = "SELECT * FROM ".$objeto->tabela;
        
        if ($objeto->extras_select != NULL){
            $sql .= " ".$objeto->extras_select;
        };
        
        return $this->executaSQL($sql); 
	}//nada mais é que um select que trará todos os campos em um objeto ou array.
	
	public function selecionaCampos($objeto = NULL){
        $sql = "SELECT ";
        
        for ($i = 0; $i < count($objeto->campos_valores); $i++){
            $sql .= key($objeto->campos_valores);
            
            if ($i < (count($objeto->campos_valores)-1)){
                $sql .= ", ";
            }else {
                $sql .= " ";
            };
            next($objeto->campos_valores);
        };
        
        $sql .= " FROM ".$objeto->tabela;
        
        if ($objeto->extras_select != NULL){
            $sql .= " ".$objeto->extras_select;
        };
        
        return $this->executaSQL($sql);
        
        }//nada mais é que um select que trará todos os campos em um objeto ou array.
        
        public function selecionaDistinct($objeto = NULL){
        $sql = "SELECT DISTINCT ";
        
        for ($i = 0; $i < count($objeto->campos_valores); $i++){
            $sql .= key($objeto->campos_valores);
            
            if ($i < (count($objeto->campos_valores)-1)){
                $sql .= ", ";
            }else {
                $sql .= " ";
            };
            next($objeto->campos_valores);
        };
        
        $sql .= " FROM ".$objeto->tabela;
        
        if ($objeto->extras_select != NULL){
            $sql .= " ".$objeto->extras_select;
        };
        
        return $this->executaSQL($sql);
        
        }//nada mais é que um select que trará todos os campos em um objeto ou array.
	
	public function executaSQL($sql = NULL){
	    if ($sql != NULL) {
	        
            $query = mysql_query($sql) or $this->trataErro(__FILE__, __FUNCTION__);
            $this->linhasAfetadas = mysql_affected_rows($this->conexao);
            
            if (substr(trim(strtolower($sql)), 0, 6) == 'select') {
                $this->dataSet = $query;
                return $query;
            }else {
                return $this->linhasAfetadas;
            };
                
        }else {
            $this->trataErro(__FILE__, __FUNCTION__, null,  'Comando SQL não informado na rotina', FALSE);
        };
        
	}// executa SQL vai pegar as SQLs criadas de inserir, atualizar e delete.
	
	public function retornaDados($tipo = NULL){
	    
        switch (strtolower($tipo)){
            case "array":
                return mysql_fetch_array($this->dataSet);                
                break;
                
            case "assoc":
                return mysql_fetch_assoc($this->dataSet);
                break;
            
            case "object":
                return mysql_fetch_object($this->dataSet);
                break;
                
            default:                
                return mysql_fetch_object($this->dataSet);                
                break;
        };
	    
	}// retornar os dados da consulta ao banco do mysql..... E altera para array, assoc e objeto para acessar e usalo na view.

	public function trataErro($arquivo = null, $rotina = null, $numErro = null, $msgErro = null, $geraExcept = false){
		if ($arquivo == null) $arquivo = "não informado";
		if ($rotina == null) $rotina = "não informada";
        if ($numErro == null) $numErro = mysql_errno($this->conexao);
        if ($msgErro == null) $msgErro = mysql_error($this->conexao);
        
        $resultado = 'Ocorreu um erro com os seguintes detalhes: <br>
                        <strong>Arquivo: </strong>'.$arquivo.'<br>
                        <strong>Rotina: </strong>'.$rotina.'<br>
                        <strong>Código: </strong>'.$numErro.'<br>
                        <strong>Mensagem: </strong>'.$msgErro;
                        
        if ($geraExcept == FALSE):
            echo $resultado;
        else:
            die($resultado);
        endif;
	}// tratamento dos erros de conecção e consultadas ao banco de dados.

}// fim da clase banco
?>