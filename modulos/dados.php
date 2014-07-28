<?php
require_once(dirname(dirname(__FILE__)).'/funcoes.php');
protegeArquivo(basename(__FILE__));

switch ($tela) {
    case "incluir":
        if (filter_input(INPUT_GET, 'id')){
            $id = filter_input(INPUT_GET, 'id');
                
            $loja = new lojas();
            $loja->extras_select = "where id_lojas = $id ";
            $loja->selecionaTudo($loja);
            $resLoja = $loja->retornaDados();
            
            $sessao = new sessao();
            $sessao->getNvars();
    
        if (filter_input(INPUT_POST, 'incluir')){
            if (filter_input(INPUT_POST, 'semproduto_dados') == "Não" && $semProduto == FALSE){
                $dados = new dados(array(
                "id_users" => filter_input(INPUT_POST, 'id_users'),
                "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados')));
                $dados->inserir($dados);
            }
        }
            
        ?>
        <form action="" method="post" data-abide >
            <fieldset>
                <legend><h3>Inclusão de Dados de Lojas</h3></legend>
                <!-- inputs hidem post -->
                <div class="small-12 columns">
                    <input type="hidden" name="id_users" value="<?php echo $sessao->getVar('iduser'); ?>" />
                    <input type="hidden" name="nome_users" value="<?php echo $sessao->getVar('nomeuser'); ?>" />
                    <input type="hidden" name="id_lojas" value="<?php if ($resLoja): echo $resLoja->id_lojas; endif; ?>" />
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <div class="small-3 columns">
                            <label for="">Data da Visita
                                <input type="text" name="data_dados" required autofocus pattern="\d{2}\/\d{2}\/\d{4}" maxlength="10" />
                            </label>
                            <small class="error">Campo obrigatório ou data invalida.Ex: 01/01/2014.</small>
                        </div>
                        
                        <div class="small-6 columns">
                            <label for="">Nome da Loja
                                <input type="text" name="nome_lojas" readonly value="<?php if ($resLoja) : echo $resLoja->nome_lojas; endif; ?>" />
                            </label>
                        </div>
                    
                        <div class="small-3 columns">
                            <label for="">Tem produtos?
                                <select name="semproduto_dados" required >
                                    <option value="">Selecionar</option>
                                    <option value="Sim">Sim</option>
                                    <option value="Não">Não</option>
                                </select>
                            </label>
                            <small class="error">Campo Obrigatório!</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                            <div class="panel">
                                <p>Informe abaixo todos os produtos da Seagate na loja e caso tenham o mesmo modelo com capacidades diferente deve-se informar também, pois os preços serão diferentes. </p>
                            </div>
                    </div>
                </div>
                <!-- produto1 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados1" id="segmento" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados1" id="produto">
                                        <option value="0">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados1">
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados1" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados1"  >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados1" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados1'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados1')." | ".filter_input(INPUT_POST, 'capacidade_dados1'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados1')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados1'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados1')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados1') != NULL && filter_input(INPUT_POST, 'produto_dados1') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- Produto2 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados2" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados2" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados2" >
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados2" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados2" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados2" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados2'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados2')." | ".filter_input(INPUT_POST, 'capacidade_dados2'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados2')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados2'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados2')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados2') != NULL && filter_input(INPUT_POST, 'produto_dados2') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- produto3 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados3" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados3" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados3" >
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados3" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados3" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados3" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados3'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados3')." | ".filter_input(INPUT_POST, 'capacidade_dados3'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados3')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados3'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados3')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados3') != NULL && filter_input(INPUT_POST, 'produto_dados3') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- produto4 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados4" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados4" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados4" >
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados4" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados4" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados4" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados4'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados4')." | ".filter_input(INPUT_POST, 'capacidade_dados4'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados4')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados4'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados4')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados4') != NULL && filter_input(INPUT_POST, 'produto_dados4') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- produto5 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados5" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados5" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados5" >
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados5" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados5" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados5" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados5'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados5')." | ".filter_input(INPUT_POST, 'capacidade_dados5'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados5')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados5'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados5')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados5') != NULL && filter_input(INPUT_POST, 'produto_dados5') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- produto6 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados6">
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados6">
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados6">
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados6" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados6" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados6" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados6'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados6')." | ".filter_input(INPUT_POST, 'capacidade_dados6'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados6')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados6'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados6')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados6') != NULL && filter_input(INPUT_POST, 'produto_dados6') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- Produto7 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados7" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados7" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados7" >
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados7" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados7" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados7" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados7'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados7')." | ".filter_input(INPUT_POST, 'capacidade_dados7'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados7')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados7'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados7')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados7') != NULL && filter_input(INPUT_POST, 'produto_dados7') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- produto8 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados8" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados8" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados8" >
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados8" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados8" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados8" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados8'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados8')." | ".filter_input(INPUT_POST, 'capacidade_dados8'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados8')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados8'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados8')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados8') != NULL && filter_input(INPUT_POST, 'produto_dados8') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- produto9 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados9" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados9" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados9" >
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados9" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados9" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados9" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados9'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados9')." | ".filter_input(INPUT_POST, 'capacidade_dados9'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados9')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados9'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados9')));
                }
                if (filter_input(INPUT_POST, 'segmento_produto_dados9') != NULL && filter_input(INPUT_POST, 'produto_dados9') != NULL){
                    $dados->inserir($dados);
                }else {
                    $semProduto = TRUE;
                }
                ?>
                <!-- produto10 -->
                <div class="row">
                            <div class="small-2 columns">
                                <label>Segmento
                                    <select name="segmento_produto_dados10" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos(array('segmento_produtos' => NULL));
                                        $produto->getValor('segmento_produtos');
                                        $produto->selecionaDistinct($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->segmento_produtos, $res->segmento_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-3 columns">
                                <label>Produto
                                    <select name="produto_dados10" >
                                        <option value="">Selecionar</option>
                                        <?php 
                                        $produto = new produtos();
                                        $produto->selecionaTudo($produto);
                                        while ($res = $produto->retornaDados()) {
                                            printf('<option value="%s">%s</option>', $res->nome_produtos, $res->segmento_produtos." | ".$res->nome_produtos);
                                        }
                                        ?>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-1 columns">
                                <label>Cap.
                                    <select name="capacidade_dados10" >
                                        <option value="">Selecionar</option>
                                        <option value="250 Gb">80 Gb</option>
                                        <option value="250 Gb">120 Gb</option>
                                        <option value="250 Gb">250 Gb</option>
                                        <option value="250 Gb">320 Gb</option>
                                        <option value="500 Gb">500 Gb</option>
                                        <option value="250 Gb">700 Gb</option>
                                        <option value="250 Gb">750 Gb</option>
                                        <option value="1 Tb">1 Tb</option>
                                        <option value="1 Tb">2 Tb</option>
                                        <option value="1 Tb">3 Tb</option>
                                        <option value="1 Tb">4 Tb</option>
                                        <option value="1 Tb">5 Tb</option>
                                        <option value="1 Tb">6 Tb</option>
                                        <option value="1 Tb">7 Tb</option>
                                        <option value="1 Tb">8 Tb</option>
                                        <option value="1 Tb">9 Tb</option>
                                        <option value="1 Tb">10 Tb</option>
                                    </select>
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Preço
                                    <input type="text" name="preco_dados10" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Vitrine
                                    <input type="text" name="pecas_vitrine_dados10" >
                                </label>
                                <small class="error">Campo Obrigatório.</small>
                            </div>
                            <div class="small-2 columns">
                                <label>Nº Peças Estoque
                                    <input type="text" name="pecas_estoque_dados10" >
                                </label>
                            </div>
                </div>
                <?php
                if (filter_input(INPUT_POST, 'incluir')){
                    $dados = new dados(array(
                    "id_users" => filter_input(INPUT_POST, 'id_users'),
                    "nome_users" => filter_input(INPUT_POST, 'nome_users'),
                    "id_lojas" => filter_input(INPUT_POST, 'id_lojas'),
                    "nome_lojas" => filter_input(INPUT_POST, 'nome_lojas'),
                    "data_dados" => mudaDataMysql(filter_input(INPUT_POST, 'data_dados')),
                    "semproduto_dados" => filter_input(INPUT_POST, 'semproduto_dados'),
                    "segmento_produto_dados" => filter_input(INPUT_POST, 'segmento_produto_dados10'),
                    "produto_dados" => filter_input(INPUT_POST, 'produto_dados10')." | ".filter_input(INPUT_POST, 'capacidade_dados10'),
                    "preco_dados" => moeda(filter_input(INPUT_POST, 'preco_dados10')),
                    "pecas_vitrine_dados" => filter_input(INPUT_POST, 'pecas_vitrine_dados10'),
                    "pecas_estoque_dados" => filter_input(INPUT_POST, 'pecas_estoque_dados10')));
                
                    if (filter_input(INPUT_POST, 'segmento_produto_dados10') != NULL && filter_input(INPUT_POST, 'produto_dados10') != NULL){
                        $dados->inserir($dados);
                    }else {
                        $semProduto = TRUE;
                    }
                }
                ?>
              
                
                <div class="row">
                    <div class="small-12 columns">
                        <textarea name="coment" placeholder="Comentários, ocorrências e informações úteis." rows="5"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <input type="submit" name="incluir" value="Salvar" class="button small radius left" />
                        <input type="button" onclick="location.href='?m=lojas&t=listar'" value="Cancelar" class="button secondary small radius left" style="margin-left: 1em;" />
                    </div>
                </div>
            </fieldset>
        </form><!--fim do formulário-->
        <?php 
        }else {
            printMsg('Você não escolheu nenhuma loja para inserir dados da visita! Retornar para lista de Lojas <a href="?m=lojas&t=listar"><span class="small label radius">Clique aqui.</span></a>', 'erro');
        }
        ?>
        <?php
        break;
    
    case "listar":
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#lojasList').dataTable({
                    "language": {
                        "zeroRecords": "Nenhum dado encontrado!",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "Nenhum registro a ser exibido",
                        "sSearch": "Pesquisar",
                        paginate:{
                            next: "Próximo",
                            previous: "Anterior"},
                        show: "Mostrar",
                        lengthMenu: "Mostrar _MENU_",
                        "infoFiltered": "(filtrado de _MAX_ registros no total)"},

                    "sScrollY": "100%",
                    "bPaginate": true,
                    "aaSorting": [[0, "desc"]]
                });
            });
        </script>
        <div class="row">
            <div class="small-12 columns">
                <h2>Informações das Lojas</h2>
            </div>
            <div class="small-12 columns">
                <table class="display" id="lojasList" cellspacing="0" cellpadding="0" border="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Data Visita</th>
                            <th style="text-align: center;">Nome da Loja</th>
                            <th style="text-align: center;">Produto</th>
                            <th style="text-align: center;">Preço</th>
                            <th style="text-align: center;">Peças Vitrine</th>
                            <th style="text-align: center;">Peças Estoque</th>
                            <th style="text-align: center;">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $listDados = new dados();
                        $listDados->selecionaTudo($listDados);
                        while ($res = $listDados->retornaDados()):
                            echo '<tr>';
                            printf('<td>%s</td>', date('d/m/Y', strtotime($res->data_dados)));
                            printf('<td>%s</td>', $res->nome_lojas);
                            printf('<td>%s</td>', $res->produto_dados);
                            printf('<td style="text-align: center;">%s</td>', $res->preco_dados);
                            printf('<td style="text-align: center;">%s</td>', $res->pecas_vitrine_dados);
                            printf('<td style="text-align: center;">%s</td>', $res->pecas_estoque_dados);
                            printf('<td>Ações</td>');
                            echo '</tr>';
                        endwhile;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        break;

    default:
        echo "Tela ainda não existe";
        break;
}//fim switch