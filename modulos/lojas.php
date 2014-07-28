<?php 
require_once(dirname(dirname(__FILE__)).'/funcoes.php');
protegeArquivo(basename(__FILE__));

switch ($tela) {
    case 'incluir':
        if (isset($_POST['incluir'])):
            $loja = new lojas(array(
                'rede_lojas' => trim(titleCase($_POST['rede_lojas'])),
                'nome_lojas' => titleCase($_POST['nome_lojas']),
                'logradouro_lojas' => titleCase($_POST['logradouro_lojas']),
                'complemento_lojas' => titleCase($_POST['complemento_lojas']),
                'bairro_lojas' => titleCase($_POST['bairro_lojas']),
                'cidade_lojas' => titleCase($_POST['cidade_lojas']),
                'uf_lojas' => strtoupper($_POST['uf_lojas']),
                'cnpj_lojas' => $_POST['cnpj_lojas'],
                'canal_lojas' => $_POST['canal_lojas']
            ));
            if ($loja->existeCNPJ('cnpj_lojas',$_POST['cnpj_lojas'])):
                printMsg('Loja ou CNPJ já cadastrado no sistema, favor consultar!', 'erro');
                $duplicado = true;
            endif;

            if ($duplicado != true):
                $loja->inserir($loja);
                if ($loja->linhasAfetadas == 1):
                    printMsg('Dados cadastrados com sucesso! <a href="'.ADMURL.'?m=lojas&t=listar">Sair</a>', 'sucesso');
                    unset($_POST);
                endif;
            endif;
        endif;
        ?>
        <form action="" method="post" data-abide>
            <fieldset>
                <legend><h2>Cadastro de Lojas</h2></legend>
                <div class="row">
                    <div class="small-8 small-centered columns">
                        <div class="small-6 columns">
                            <label>Rede
                                <span data-tooltip class="has-tip" title="Verifique se já existe, digitando as primeiras letras e selecione clicando. Caso não, digitar o nome da rede corretamente!">Importante!</span>
                                <input type="text" list="rede_lojas" name="rede_lojas" value="<?php echo $_POST['rede_lojas']; ?>" required autofocus autocomplete="off">
                                <datalist id="rede_lojas">
                                    <?php 
                                        $loja = new lojas(array('rede_lojas' => null));
                                        $loja->getValor('rede_lojas');
                                        $loja->selecionaDistinct($loja);
                                        while ($res = $loja->retornaDados()) {
                                            printf('<option value="%s">', $res->rede_lojas);                    
                                        }
                                    ?>
                                </datalist>
                            </label>
                            <small class="error">Campo obrigatório.</small>
                        </div>
                        <div class="small-6 columns">
                            <label>Nome da Loja
                                <input type="text" name="nome_lojas" required class="radius" value="<?php echo $_POST['nome_lojas'];?>" autocomplete="off" >
                            </label>
                            <small class="error">Campo obrigatório.</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-8 small-centered columns">
                        <div class="small-6 columns">
                            <label>Endereço
                                <input type="text" name="logradouro_lojas" required class="radius" value="<?php echo  $_POST['logradouro_lojas']; ?>" autocomplete="off"/>
                            </label>
                            <small class="error">Campo obrigatório.</small>
                        </div>
                        <div class="small-6 columns">
                            <label>Complemento
                                <input type="text" name="complemento_lojas" class="radius" value="<?php echo  $_POST['complemento_lojas'];?>" autocomplete="off"/>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-8 small-centered columns">
                        <div class="small-5 columns">
                            <label>Bairro
                                <input type="text" name="bairro_lojas" required class="radius" value="<?php echo  $_POST['bairro_lojas'];?>" autocomplete="off"/>
                            </label>
                            <small class="error">Campo obrigatório.</small>
                        </div>
                        <div class="small-5 columns">
                            <label>Cidade
                                <span data-tooltip class="has-tip" title="Verifique se já existe, digitando as primeiras letras e selecione clicando. Caso não, digitar o nome da cidade corretamente!">Importante!</span>
                                <input type="text" list="cidade_lojas" name="cidade_lojas" required class="radius" value="<?php echo  $_POST['cidade_lojas'];?>" autocomplete="off" />
                                <datalist id="cidade_lojas">
                                    <?php 
                                        $loja = new lojas(array('cidade_lojas' => null));
                                        $loja->getValor('cidade_lojas');
                                        $loja->selecionaDistinct($loja);
                                        while ($res = $loja->retornaDados()) {
                                            printf('<option value="%s">', $res->cidade_lojas);
                                            
                                        }
                                    ?>
                                </datalist>
                            </label>
                            <span class="error">Campo obrigatório.</span>
                        </div>
                        <div class="small-2 columns">
                            <label>Uf
                                <span data-tooltip class="has-tip" title="Verifique se já existe, digitando as primeiras letras e selecione clicando. Caso não, digitar a sigla do estado corretamente!">Obs.!</span>
                                <input type="text" list="uf_lojas" name="uf_lojas" required class="radius" value="<?php echo  $_POST['uf_lojas'];?>" autocomplete="off" />
                                <datalist id="uf_lojas">
                                    <?php 
                                        $loja = new lojas(array('uf_lojas' => null));
                                        $loja->getValor('uf_lojas');
                                        $loja->selecionaDistinct($loja);
                                        while ($res = $loja->retornaDados()) {
                                            printf('<option value="%s">', $res->uf_lojas);
                                            
                                        }
                                    ?>
                                </datalist>
                            </label>
                            <small class="error">Obrigatório.</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-8 small-centered columns">
                        <div class="small-6 columns">
                            <label>CNPJ                                
                                <input type="text" name="cnpj_lojas" class="radius" pattern="^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$" value="<?php echo $_POST['cnpj_lojas'];?>"/>
                            </label>
                            <small class="error">Digite nesse formato 99.888.777/0001-66.</small>
                        </div>
                        <div class="small-6 columns">
                            <label>Canal de Vendas
                                <select name="canal_lojas" required class="radius" value="<?php echo $_POST['canal_lojas'];?>">
                                    <option value="">Selecionar</option>
                                    <option value="varejo">Varejo</option>
                                    <option value="revenda">Revendedor</option>
                                    <option value="revendavarejo">Revendedor e Varejo</option>
                                </select>
                            </label>
                            <small class="error">Campos Obrigatório.</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-8 small-centered columns">
                        <div class="small-12 columns">
                            <input type="submit" name="incluir" value="Cadastrar" class="button small radius left" />
                            <input type="button" onclick="location.href='?m=lojas&t=listar'" value="Cancelar" class="button secondary small radius left" style="margin-left: 1em;" />
                        </div>
                    </div>
                </div>
        
            </fieldset>
        </form>
            
        <?php
        break;        

    case 'editar':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if (isset($_POST['alterar' ])) {
                    $loja = new lojas(array(
                        'rede_lojas' => titleCase($_POST['rede_lojas']),
                        'nome_lojas' => titleCase($_POST['nome_lojas']),
                        'logradouro_lojas' => titleCase($_POST['logradouro_lojas']),
                        'complemento_lojas' => titleCase($_POST['complemento_lojas']),
                        'bairro_lojas' => titleCase($_POST['bairro_lojas']),
                        'cidade_lojas' => titleCase($_POST['cidade_lojas']),
                        'uf_lojas' => strtoupper($_POST['uf_lojas']),
                        'cnpj_lojas' => $_POST['cnpj_lojas'],
                        'canal_lojas' => $_POST['canal_lojas']
                        ));
                        
                    $loja->valorpk = $id;
                    $loja->extras_select = "WHERE id_lojas=$id";
                    $loja->selecionaTudo($loja);
                    $resUpdate = $loja->retornaDados();
                    $loja->atualizar($loja);
                    if ($loja->linhasAfetadas == 1) {
                        printMsg('Dados alterados com sucesso! <a href="?m=lojas&t=listar" class="label radius">Sair</a>', 'sucesso');
                        unset($_POST);
                    } else {
                        printMsg('Nenhum dados alterado! <a href="?m=lojas&t=listar" class="label  radius">Sair</a>', 'erro');
                    };
                };            
                $lojaedit = new lojas();
                $lojaedit->extras_select = "WHERE id_lojas=$id";
                $lojaedit->selecionaTudo($lojaedit);
                $resConsulta = $lojaedit->retornaDados();
        ?>
            <div class="Row">
                <form action="" method="post" data-abide>
                    <fieldset>
                        <legend><h2>Editar dados da Loja</h2></legend>
                        <div class="row">
                            <div class="small-8 small-centered columns">
                                <div class="small-6 columns">
                                    <label>Rede
                                        <span data-tooltip class="has-tip" title="Verifique se já existe, digitando as primeiras letras e selecione clicando. Caso não, digitar o nome da rede corretamente!">Importante!</span>
                                        <input type="text" list="rede_lojas" name="rede_lojas" required autofocus autocomplete="off" value="<?php if ($resConsulta) echo $resConsulta->rede_lojas; ?>" >
                                        <datalist id="rede_lojas">
                                            <?php 
                                                $loja = new lojas(array('rede_lojas' => null));
                                                $loja->getValor('rede_lojas');
                                                $loja->selecionaDistinct($loja);
                                                while ($res = $loja->retornaDados()) {
                                                    printf('<option value="%s">', $res->rede_lojas);

                                                }
                                            ?>
                                        </datalist>
                                    </label>
                                    <small class="error">Campo obrigatório.</small>
                                </div>
                                <div class="small-6 columns">
                                    <label>Nome da Loja
                                        <input type="text" name="nome_lojas" required class="radius" autocomplete="off" value="<?php if ($resConsulta) echo $resConsulta->nome_lojas; ?>" />
                                    </label>
                                    <small class="error">Campo obrigatório.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-8 small-centered columns">
                                <div class="small-6 columns">
                                    <label>Endereço
                                        <input type="text" name="logradouro_lojas" required class="radius" autocomplete="off" value="<?php if ($resConsulta) echo $resConsulta->logradouro_lojas; ?>" />
                                    </label>
                                    <small class="error">Campo obrigatório.</small>
                                </div>
                                <div class="small-6 columns">
                                    <label>Complemento
                                        <input type="text" name="complemento_lojas" class="radius" value="<?php if ($resConsulta) echo $resConsulta->complemento_lojas; ?>"/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-8 small-centered columns">
                                <div class="small-5 columns">
                                    <label>Bairro
                                        <input type="text" name="bairro_lojas" required class="radius" value="<?php if ($resConsulta) echo $resConsulta->bairro_lojas; ?>"/>
                                    </label>
                                    <small class="error">Campo obrigatório.</small>
                                </div>
                                <div class="small-5 columns">
                                    <label>Cidade
                                        <span data-tooltip class="has-tip" title="Verifique se já existe, digitando as primeiras letras e selecione clicando. Caso não, digitar o nome da cidade corretamente!">Importante!</span>
                                        <input type="text" list="cidade_lojas" name="cidade_lojas" required class="radius" autocomplete="off" value="<?php if ($resConsulta) echo $resConsulta->cidade_lojas; ?>" />
                                        <datalist id="cidade_lojas">
                                            <?php 
                                                $loja = new lojas(array('cidade_lojas' => null));
                                                $loja->getValor('cidade_lojas');
                                                $loja->selecionaDistinct($loja);
                                                while ($res = $loja->retornaDados()) {
                                                    printf('<option value="%s">', $res->cidade_lojas);

                                                }
                                            ?>
                                        </datalist>
                                    </label>
                                    <span class="error">Campo obrigatório.</span>
                                </div>
                                <div class="small-2 columns">
                                    <label>Uf
                                        <span data-tooltip class="has-tip" title="Verifique se já existe, digitando as primeiras letras e selecione clicando. Caso não, digitar a sigla do estado corretamente!">Obs.!</span>
                                        <input type="text" list="uf_lojas" name="uf_lojas" required class="radius" autocomplete="off" value="<?php if ($resConsulta) echo $resConsulta->uf_lojas; ?>" />
                                        <datalist id="uf_lojas">
                                            <?php 
                                                $loja = new lojas(array('uf_lojas' => null));
                                                $loja->getValor('uf_lojas');
                                                $loja->selecionaDistinct($loja);
                                                while ($res = $loja->retornaDados()) {
                                                    printf('<option value="%s">', $res->uf_lojas);

                                                }
                                            ?>
                                        </datalist>
                                    </label>
                                    <small class="error">Obrigatório.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-8 small-centered columns">
                                <div class="small-6 columns">
                                    <label>CNPJ
                                        <input type="text" name="cnpj_lojas" class="radius"pattern="^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$" value="<?php if ($resConsulta) echo $resConsulta->cnpj_lojas; ?>"/>
                                    </label>
                                    <small class="error">Digite nesse formato 99.888.777/0001-66.</small>
                                </div>
                                <div class="small-6 columns">
                                    <label>Canal de Vendas
                                        <select name="canal_lojas" required class="radius">
                                            <option value="<?php if ($resConsulta) echo $resConsulta->canal_lojas; ?>"><?php if ($resConsulta) echo $resConsulta->canal_lojas; ?></option>
                                            <option value="varejo">Varejo</option>
                                            <option value="revenda">Revendedor</option>
                                            <option value="revendavarejo">Revendedor e Varejo</option>
                                        </select>
                                    </label>
                                    <small class="error">Campos Obrigatório.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-8 small-centered columns">
                                <div class="small-12 columns">
                                    <input type="submit" name="alterar" value="Salvar" class="button small radius left" />
                                    <input type="button" onclick="location.href='?m=lojas&t=listar'" value="Cancelar" class="button secondary small radius left" style="margin-left: 1em;" />
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>        
            </div>
            <?php
            } else {
                printMsg('Você não selecionou a loja para editar!! <a class="label alert radius"  href="?m=lojas&t=listar">Clique aqui</a>', 'alerta');
            }
        break;
        
    case 'excluir':
        if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if (isset($_POST['excluir' ])) {
                        $loja = new lojas();                        
                        $loja->valorpk = $id;
                        
                        $loja->deletar($loja);
                        if ($loja->linhasAfetadas == 1) {
                            printMsg('Loja excluída com sucesso! <a href="?m=lojas&t=listar" class="label radius">Sair</a>', 'sucesso');
                            unset($_POST);
                        } else {
                            printMsg('Nenhuma loja foi excluida! <a href="?m=lojas&t=listar" class="label  radius">Sair</a>', 'erro');
                        };
                };         
                $useredit = new lojas();
                $useredit->extras_select = "WHERE id_lojas=$id";
                $useredit->selecionaTudo($useredit);
                $resConsulta = $useredit->retornaDados();
        } else {
            printMsg('Você não selecionou o usuário para Ecluir!! <a class="label alert radius"  href="?m=usuarios&t=listar">Sair</a>', 'alerta');
        };
        ?>
            <div class="row">
                    <form action="" method="post" data-abide>
                        <fieldset>
                            <legend><h2>Excluir Loja</h2></legend>
                            <div class="row">
                                <div class="small-8 small-centered columns">
                                    <div class="small-6 columns">
                                        <label>Rede
                                            <input type="text" list="rede_lojas" name="rede_lojas" class="radius" disabled value="<?php if ($resConsulta) echo $resConsulta->rede_lojas; ?>" />
                                        </label>
                                    </div>
                                    <div class="small-6 columns">
                                        <label>Nome da Loja
                                            <input type="text" name="nome_lojas" class="radius" disabled value="<?php if ($resConsulta) echo $resConsulta->nome_lojas; ?>"/>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">
                                    <div class="small-6 columns">
                                        <label>Endereço
                                            <input type="text" name="logradouro_lojas" class="radius" disabled value="<?php if ($resConsulta) echo $resConsulta->logradouro_lojas; ?>"/>
                                        </label>
                                    </div>
                                    <div class="small-6 columns">
                                        <label>Complemento
                                            <input type="text" name="complemento_lojas" class="radius" disabled value="<?php if ($resConsulta) echo $resConsulta->complemento_lojas; ?>"/>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">
                                    <div class="small-5 columns">
                                        <label>Bairro
                                            <input type="text" name="bairro_lojas" class="radius" disabled value="<?php if ($resConsulta) echo $resConsulta->bairro_lojas; ?>"/>
                                        </label>
                                    </div>
                                    <div class="small-5 columns">
                                        <label>Cidade                                
                                            <input type="text" list="cidade_lojas" name="cidade_lojas" class="radius" disabled value="<?php if ($resConsulta) echo $resConsulta->cidade_lojas; ?>" >
                                        </label>
                                    </div>
                                    <div class="small-2 columns">
                                        <label>Uf
                                            <input type="text" list="uf_lojas" name="uf_lojas" class="radius" disabled value="<?php if ($resConsulta) echo $resConsulta->uf_lojas; ?>" >
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">
                                    <div class="small-6 columns">
                                        <label>CNPJ
                                            <input type="text" name="cnpj_lojas" class="radius"pattern="^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$" disabled value="<?php if ($resConsulta) echo $resConsulta->cnpj_lojas; ?>"/>
                                        </label>
                                    </div>
                                    <div class="small-6 columns">
                                        <label>Canal de Vendas
                                            <input type="text" name="canal_lojas" class="radius" disabled value="<?php if ($resConsulta) echo $resConsulta->canal_lojas; ?>"/>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">
                                    <div class="small-12 columns">
                                        <input type="submit" name="excluir" value="Excluir" class="button small radius left" />
                                        <input type="button" onclick="location.href='?m=lojas&t=listar'" value="Cancelar" class="button secondary small radius left" style="margin-left: 1em;" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
            </div>
        <?php
        break;

    case 'listar':
        ?>
        <!-- responsavel por carregar data table. -->
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
                <h2>Relação de Lojas Cadastradas</h2>
            </div>
            <div class="small-12 columns">
                <table class="display" id="lojasList" cellspacing="0" cellpadding="0" border="0">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Rede</th>
                            <th style="text-align: center;">Nome da Loja</th>
                            <th style="text-align: center;">Endereço</th>
                            <th style="text-align: center;">Cidade</th>
                            <th style="text-align: center;">Uf</th>
                            <th style="text-align: center;">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $listLojas = new lojas();
                        $listLojas->selecionaTudo($listLojas);
                        while ($res = $listLojas->retornaDados()):
                            echo '<tr>';
                            printf('<td>%s</td>', $res->rede_lojas);
                            printf('<td>%s</td>', $res->nome_lojas);
                            printf('<td>%s</td>', $res->logradouro_lojas);
                            printf('<td>%s</td>', $res->cidade_lojas);
                            printf('<td style="text-align: center;">%s</td>', $res->uf_lojas);
                            printf('<td style="text-align: center">
                                <a href="?m=lojas&t=editar&id=%s" title="Editar dados loja"><img src="img/edit.png" alt="Editar dados loja." width="15px" /></a>
                                <a href="?m=lojas&t=excluir&id=%s" title="Excluir Loja"><img src="img/delete.png" alt="Ecluir Loja" width="20px" /></a>
                                <a href="?m=dados&t=incluir&id=%s" title="Inserir dados da visita desta loja."><img src="img/insert-info.png" alt="Inserir Visita" width="20px" /></a>
                                </td>', $res->id_lojas, $res->id_lojas, $res->id_lojas );
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
                printMsg('Página não encontrada!!', 'alerta');
            break;
};
?>