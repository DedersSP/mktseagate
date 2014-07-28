<?php 
require_once(dirname(dirname(__FILE__)).'/funcoes.php');
protegeArquivo(basename(__FILE__));

switch ($tela) {
    case 'login':
    $sessao = new sessao();
    if ($sessao->getNvars() > 0 || $sessao->getVar('logado') > 0 || $sessao->getVar('ip') == $_SERVER['REMOTE_ADDR'] ) redireciona('painel.php');
    if (isset($_POST['logar'])){
        $user = new usuarios();
        $user->setValor('email_user', antiInject($_POST['email_user']));
        $user->setValor('senha_user', antiInject($_POST['senha_user']));
        if ($user->doLogin($user)) {
            redireciona('painel.php');
        }else {
            redireciona('?erro=2');
        };
    };  
?>
<div class="row" id="form_login">
    <div class="small-6 small-centered small-text-center columns">
        <img src="img/seagate_mr.png" class="logo_seagate_mr" width="350px">
    </div>
</div>

<div class="row">
    <div class="small-6 small-centered columns">
        <form data-abide method="post">
               <fieldset>
                    <legend>Bem Vindo! Favor se identificar.</legend>
                    
                        <div class="email-field">
                            <div class="row collapse">
                                 <div class="small-3 columns">
                                     <span class="prefix">E-mail:</span>
                                 </div>
                                 <div class="small-9 columns">                            
                                     <input type="email" name="email_user" value="<?php echo $_POST['email_user']; ?>" required autofocus>
                                     <small class="error">Favor inserir ou corrigir seu e-mail!</small>
                                 </div>
                            </div>
                        </div>

                        <div class="password-field">
                            <div class="row collapse">
                                 <div class="small-3 columns">
                                     <span class="prefix">Senha:</span>
                                 </div>
                                 <div class="small-9 columns">                                   
                                     <input type="password" id="password" name="senha_user" value="<?php echo $_POST['senha_user']; ?>" required pattern="([0-9a-zA-Z].{3,7})">                            
                                     <small class="error">Favor inseir ou corrigir sua senha de 4 a 8 digitos!</small>
                                 </div>
                            </div>
                        </div>

                    <div class="row collapse">
                    <div class="small-12 columns">
                    <button type="submit" name="logar" class="button small radius right" >Logar</button>    
                    </div>
                        <?php
                            if (isset($_GET['erro'])){                              
                                switch ($_GET['erro']) {
                                    case 1:
                                        echo '<div class="small-12 label success columns">Você fez logoff do sistema.</div>';
                                    break;
                                    case 2:
                                        echo '<div class="small-12 label alert columns">Dados incorretos ou usuário inativo.</div>';
                                    break;
                                    case 3:
                                        echo '<div class="small-12 label warning columns">Faça o login antes de acessar a página solicitada.</div>';
                                    break;
                                };
                            };
                        ?>
                    </div>
               </fieldset>           
        </form>
    </div>
</div><!-- fim row form -->
<?php
            break; //break login

    case 'incluir':
    if (isset($_POST['incluir'])) {
        $user = new usuarios(array(
            'nome_user' => $_POST['nome_user'],
            'email_user' => $_POST['email_user'],
            'senha_user' => codificaSenha($_POST['senha_user']),
            'adm_user' => ($_POST['adm_user'] == 'on') ? 's' : 'n'            
        ));

        if ($user->existeUser('email_user', $_POST['email_user'])) {
            printMsg('E-mail já cadastrado! Dúvidas entre em contato.', 'erro');
            $duplicado = TRUE;
        };

        if ($duplicado != TRUE) {
            $user->inserir($user);

                if ($user->linhasAfetadas == 1) {
                    printMsg('Dados inseridos com sucesso! <a href="'.ADMURL.'?m=usuarios&t=listar">Exibir Usuários</a> ', 'sucesso');
                    unset($_POST);
                };
        };    
    };
    ?>
            <div class="row">
                <form action="" method="post" class="userForm" data-abide>
                    <fieldset id="" class="">
                        <legend><h2>Cadastro de Usuários</h2></legend>
                          <div class="row">
                              <div class="small-8 small-centered columns">		            
                                  <div class="small-6 columns">
                                    <label for="nome">Nome Completo:*</label>
                                    <input type="text" required autofocus name="nome_user" value="<?php echo $_POST['nome_user'] ?>" class="radius" />
                                  </div>

                                  <div class="small-6 columns">
                                <label for="nome">E-mail:*</label>
                                <input type="email" required name="email_user" value="<?php echo $_POST['email_user'] ?>" class="radius" />
                              </div>
                              </div>
                          </div>

                          <div class="row">
                          <div class="small-8 small-centered columns">                    
                              <!-- <div class="small-3 columns">                            
                                  <label>Status do Usuário:</label>
                                  <input id="checkbox1" type="checkbox" name="ativo_user" value="" checked="checked"><label for="checkbox1">Ativo</label>
                              </div> -->

                              <div class="small-4 columns">                            
                                  <label>Administrador:</label>
                                  <input type="checkbox" name="adm_user" <?php if (!isAdmin()) echo 'disabled="disable"'; if ($_POST['adm_user']) echo 'checked="checked"';?> />
                                  <label for="checkbox1">Administrador</label>
                              </div>

                              <div class="small-4 columns">
                                    <label for="nome">Senha:*</label>
                                    <input type="password" required name="senha_user" id="senha_user" value="<?php echo $_POST['senha_user'] ?>" class="radius" pattern="[a-zA-Z0-9].{3,7}"/>
                                    <small class="error">A senha deve conter de 4 a 8 caracteres. </small>
                              </div>

                              <div class="small-4 columns">
                                    <label for="nome">Repita Senha:*</label>
                                    <input type="password" required name="senhaconf" value="<?php echo $_POST['senhaconf'] ?>" class="radius" pattern="[a-zA-Z0-9].{3,7}" data-equalto="senha_user" />
                                      <small class="error">A senha não confere!</small> 
                              </div>   
                          </div>                    
                          </div>
                          <div class="row">
                          <div class="small-8 small-centered columns">
                              <div class="small-6 columns">
                                <input type="submit" name="incluir" value="Cadastrar" class="button small radius left" />
                                <input type="button" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar" class="button secondary small radius left" style="margin-left: 1em;" />
                              </div>
                              <div class="small-6 columns">
                                  <p class="label warning right">A senha deve conter de 4 a 8 caracteres.</p>
                              </div>
                          </div>
                          </div>
                    </fieldset>
                </form><!--form cadastrar usuarios-->
            </div>
            <?php
            break;
		
    case 'listar':
        ?>
            <!-- responsavel por carregar data table. -->
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#listausers').dataTable({
                            "language": {
                                    "zeroRecords": "Nenhum dado encontrado!",
                                    "info": "Mostrando página _PAGE_ de _PAGES_ páginas",
                                    "infoEmpty": "Nenhum registro a ser exibido",
                                    "sSearch": "Pesquisar",
                                    paginate:{
                                                next: "Próximo",
                                                previous: "Anterior"} ,
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
                    <h3>Lista de Usuários</h3>
                </div>
                <div class="small-12 columns">
                    <table class="display" id="listausers" cellspacing="0" cellpadding="0" border="0" >
                        <thead>
                            <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Nome</th>
                                    <th style="text-align: center">Email</th>
                                    <th style="text-align: center">Ativo | Admin</th>
                                    <th style="text-align: center">Cadastro</th>
                                    <th style="text-align: center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $user = new usuarios();
                            $user->selecionaTudo($user);
                            while ($res = $user->retornaDados()) {
                                echo '<tr>';
                                printf('<td style="text-align: center">%s</td>', $res->id_user);
                                printf('<td>%s</td>', $res->nome_user);
                                printf('<td>%s</td>', $res->email_user);
                                printf('<td style="text-align: center">%s | %s</td>', strtoupper($res->ativo_user), strtoupper($res->adm_user) );
                                printf('<td style="text-align: center">%s</td>', date("d/m/Y", strtotime($res->registro_user)));
                                printf('<td style="text-align: center">
                                <a href="?m=usuarios&t=editar&id=%s" title="Editar dados"><img src="img/edit.png" alt="Editar dados" width="15px" /></a>
                                <a href="?m=usuarios&t=senha&id=%s" title="Alterar senha"><img src="img/pass.png" alt="Alterar senha" width="15px" /></a>
                                <a href="?m=usuarios&t=excluir&id=%s" title="Ecluir Usuário"><img src="img/delete.png" alt="Ecluir Usuário" width="20px" /></a>
                                </td>', $res->id_user, $res->id_user, $res->id_user );
                                echo '</tr>';
                            };               
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        break;
        
    case 'editar':
        $sessao = new sessao();
        if (isAdmin() == TRUE || $sessao->getVar('iduser') == $_GET['id']) {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if (isset($_POST['alterar' ])) {
                        $user = new usuarios(array(
                                'nome_user' => $_POST['nome_user'],
                                'ativo_user' => ($_POST['ativo_user'] == 'on') ? 's' : 'n',
                                'adm_user' => ($_POST['adm_user'] == 'on') ? 's' : 'n'
                        ));
                        
                        $user->valorpk = $id;
                        $user->extras_select = "WHERE id_user=$id";
                        $user->selecionaTudo($user);
                        $resUpdate = $user->retornaDados();
                        $user->atualizar($user);
                        if ($user->linhasAfetadas == 1) {
                            printMsg('Dados alterados com sucesso! <a href="?m=usuarios&t=listar" class="label radius">Sair</a>', 'sucesso');
                            unset($_POST);
                        } else {
                            printMsg('Nenhum dados alterado! <a href="?m=usuarios&t=listar" class="label  radius">Sair</a>', 'erro');
                        };      
                };                
                $useredit = new usuarios();
                $useredit->extras_select = "WHERE id_user=$id";
                $useredit->selecionaTudo($useredit);
                $resConsulta = $useredit->retornaDados();
            } else {
                printMsg('Você não selecionou o usuário para editar!! <a class="label alert radius"  href="?m=usuarios&t=listar">Clique aqui</a>', 'alerta');
            };
            ?>
            <div class="row">
                    <div class="small-12 columns">
                        <form action="" method="post" class="userForm" data-abide>
                        <fieldset id="" class="">
                          <legend><h2>Edição de dados do Usuários</h2></legend>
                            <div class="row">
                                <div class="small-8 small-centered columns">                    
                                    <div class="small-6 columns">
                                      <label for="nome">Nome Completo:*</label>
                                      <input type="text" required autofocus name="nome_user" value="<?php if ($resConsulta) echo $resConsulta->nome_user; ?>" class="radius" />
                                    </div>

                                    <div class="small-6 columns">
                                      <label for="nome">E-mail:*</label>
                                      <input type="email" required disabled="disabled" name="email_user" value="<?php if ($resConsulta) echo $resConsulta->email_user; ?>" class="radius" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">                    
                                    <div class="small-6 columns">                            
                                        <label>Status do Usuário:</label>
                                        <input id="checkbox1" type="checkbox" name="ativo_user" <?php if (!isAdmin()) echo 'disabled="disable"'; if ($resConsulta->ativo_user == 's') echo 'checked="checked"';?>><label for="checkbox1">Ativo</label>
                                    </div>

                                    <div class="small-6 columns">                            
                                        <label>Administrador:</label>
                                        <input type="checkbox" name="adm_user" <?php if (!isAdmin()) echo 'disabled="disable"'; if ($resConsulta->adm_user == 's') echo 'checked="checked"';?> />
                                        <label for="checkbox1">Administrador</label>
                                    </div>              
                                </div>      
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">
                                    <div class="small-12 columns">
                                      <input type="submit" name="alterar" value="Alterar" class="button small radius left" />
                                      <input type="button" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar" class="button secondary small radius left" style="margin-left: 1em;" />
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </form><!--form cadastrar usuarios-->
                    </div>
            </div>
            <?php
        }else {
             printMsg('Você não tem permissão para alterar os dados deste usuário!! <a class="label radius"  href="?m=usuarios&t=listar">Retornar</a>', 'erro');
        };
            ?>
            <?php
            break;
            
    case 'senha':
        $sessao = new sessao();
        if (isAdmin() == TRUE || $sessao->getVar('iduser') == $_GET['id']) {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if (isset($_POST['mudaSenha' ])) {
                        $user = new usuarios(array(
                                'senha_user' => codificaSenha($_POST['senha_user'])
                        ));
                        
                        $user->valorpk = $id;                        
                        $user->atualizar($user);
                        if ($user->linhasAfetadas == 1) {
                            printMsg('Senha alterada com sucesso! <a href="?m=usuarios&t=listar" class="label radius">Sair</a>', 'sucesso');
                            unset($_POST);
                        } else {
                            printMsg('Nenhum dados alterado! <a href="?m=usuarios&t=listar" class="label  radius">Sair</a>', 'erro');
                        };      
                };                
                $useredit = new usuarios();
                $useredit->extras_select = "WHERE id_user=$id";
                $useredit->selecionaTudo($useredit);
                $resConsulta = $useredit->retornaDados();
            } else {
                printMsg('Você não selecionou o usuário para editar!! <a class="label alert radius"  href="?m=usuarios&t=listar">Clique aqui</a>', 'alerta');
            };            
            ?>
            <div class="row">
                    <div class="small-12 columns">
                        <form action="" method="post" class="userForm" data-abide>
                        <fieldset id="" class="">
                          <legend><h2>Alteração de Senha do Usuários</h2></legend>
                            <div class="row">
                                <div class="small-8 small-centered columns">                    
                                    <div class="small-6 columns">
                                      <label for="nome">Nome Completo:*</label>
                                      <input type="text" required disabled="disabled" name="nome_user" value="<?php if ($resConsulta) echo $resConsulta->nome_user; ?>" class="radius" />
                                    </div>

                                    <div class="small-6 columns">
                                      <label for="nome">E-mail:*</label>
                                      <input type="email" required disabled="disabled" name="email_user" value="<?php if ($resConsulta) echo $resConsulta->email_user; ?>" class="radius" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">
                                        <div class="small-6 columns">
                                              <label for="nome">Senha:*</label>
                                              <input type="password" required autofocus name="senha_user" id="senha_user" value="<?php echo $_POST['senha_user'] ?>" class="radius" pattern="[a-zA-Z0-9].{3,7}"/>
                                              <small class="error">A senha deve conter de 4 a 8 caracteres!</small>
                                        </div>

                                        <div class="small-6 columns">
                                              <label for="nome">Repita Senha:*</label>
                                              <input type="password" required name="senhaconf" value="<?php echo $_POST['senhaconf'] ?>" class="radius" pattern="[a-zA-Z0-9].{3,7}" data-equalto="senha_user" />
                                                <small class="error">A senha não confere!</small>      
                                        </div>
                                </div>
                            </div>                   

                            <div class="row">
                                <div class="small-8 small-centered columns">
                                    <div class="small-12 columns">
                                      <input type="submit" name="mudaSenha" value="Alterar" class="button small radius left" />
                                      <input type="button" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar" class="button secondary small radius left" style="margin-left: 1em;" />
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </form><!--form cadastrar usuarios-->
                    </div>
            </div>
            <?php
        }else {
             printMsg('Você não tem permissão para alterar os dados deste usuário!! <a class="label radius"  href="?m=usuarios&t=listar">Retornar</a>', 'erro');
        };
            ?>
            <?php
    break;	
    case 'excluir':
        $sessao = new sessao();
        if (isAdmin() == TRUE) {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if (isset($_POST['excluir' ])) {
                        $user = new usuarios();                        
                        $user->valorpk = $id;
                        
                        $user->deletar($user);
                        if ($user->linhasAfetadas == 1) {
                            printMsg('Usuário excluído com sucesso! <a href="?m=usuarios&t=listar" class="label radius">Sair</a>', 'sucesso');
                            unset($_POST);
                        } else {
                            printMsg('Nenhum usuário foi excluido! <a href="?m=usuarios&t=listar" class="label  radius">Sair</a>', 'erro');
                        };      
                };                
                $useredit = new usuarios();
                $useredit->extras_select = "WHERE id_user=$id";
                $useredit->selecionaTudo($useredit);
                $resConsulta = $useredit->retornaDados();
            } else {
                printMsg('Você não selecionou o usuário para Ecluir!! <a class="label alert radius"  href="?m=usuarios&t=listar">Sair</a>', 'alerta');
            };
            ?>
            <div class="row">
                        <form action="" method="post" class="userForm" data-abide>
                        <fieldset id="" class="">
                          <legend><h2>Exclusão de Usuários</h2></legend>

                            <div class="row">
                                <div class="small-8 small-centered columns">                    
                                    <div class="small-6 columns">
                                      <label for="nome">Nome Completo:*</label>
                                      <input type="text" required disabled="disabled" name="nome_user" value="<?php if ($resConsulta) echo $resConsulta->nome_user; ?>" class="radius" />
                                    </div>

                                    <div class="small-6 columns">
                                      <label for="nome">E-mail:*</label>
                                      <input type="email" required disabled="disabled" name="email_user" value="<?php if ($resConsulta) echo $resConsulta->email_user; ?>" class="radius" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">                    
                                    <div class="small-6 columns">                            
                                        <label>Status do Usuário:</label>
                                        <input id="checkbox1" disabled="disabled" type="checkbox" name="ativo_user" <?php if ($resConsulta->ativo_user == 's') echo 'checked="checked"';?>><label for="checkbox1">Ativo</label>
                                    </div>

                                    <div class="small-6 columns">                            
                                        <label>Administrador:</label>
                                        <input type="checkbox" disabled="disabled" name="adm_user" <?php if ($resConsulta->adm_user == 's') echo 'checked="checked"';?> />
                                        <label for="checkbox1">Administrador</label>
                                    </div>              
                                </div>      
                            </div>

                            <div class="row">
                                <div class="small-8 small-centered columns">
                                    <div class="small-12 columns">
                                      <input type="submit" name="excluir" value="Excluir" class="button small radius left" />
                                      <input type="button" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar" class="button secondary small radius left" style="margin-left: 1em;" />
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </form><!--form cadastrar usuarios-->
            </div>
            <?php
        }else {
             printMsg('Você não tem permissão para alterar os dados deste usuário!! <a class="label radius"  href="?m=usuarios&t=listar">Retornar</a>', 'erro');
        };
            ?>
            <?php           
    break;
    default:
            printMsg('Página não encontrada!!', 'alerta');
            break;
}//fim switch end
?>