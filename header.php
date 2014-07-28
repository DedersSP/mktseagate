<?php 
require_once('funcoes.php');
protegeArquivo(basename(__FILE__));
verificaLogin();
$sessao = new sessao();
?>

<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Controle Seagate | MR Promoções</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">        
    <!-- CSS -->    
    <?php loadCSS('style'); ?>        
    <link rel="stylesheet" href="css/foundation/foundation.css">
</head>

<body id="body">
    <div class="row">
        <div class="small-12 columns">
        <img src="img/seagate_mr.png" alt="MR Promoções e Seagate" align="right" />
        </div>
    </div>
    
    <div class="row">
            <nav class="top-bar" data-topbar>
                  <ul class="title-area">
                        <li class="name">
                          <h1><a href="#">Controle de Informações e Presença</a></h1>
                        </li>
                 <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                        <!-- <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li> -->
                </ul>
                
                <section class="top-bar-section">
                <!-- Right Nav Section -->
                <ul class="right">
                          <li class="has-dropdown active">
                                    <a href="#">Lojas</a>
                                    <ul class="dropdown">
                                      <li><a href="?m=lojas&t=listar">Consultar</a></li>
                                      <li><a href="?m=lojas&t=incluir">Cadastrar</a></li>
                                    </ul>
                          </li>
                          <li class="active"><a href="#">Produtos</a></li>
                          <li class="has-dropdown active">
                              <a href="#">Dados</a>
                                    <ul class="dropdown">
                                        <li><a href="?m=dados&t=listar">Consultar</a></li>
                                    </ul>
                          </li>
                          <li class="has-dropdown active">
                                    <a href="#">Usuários</a>
                                    <ul class="dropdown">
                                      <li><a href="?m=usuarios&t=listar">Consultar</a></li>
                                      <li><a href="?m=usuarios&t=incluir">Cadastrar</a></li>
                                    </ul>
                          </li>
                          <li class=""><a class="button alert radius" href="?logoff=true">Logoff</a></li>
                </ul>
                
                <!-- Left Nav Section -->
                <!-- <ul class="left">
                      <li><a href="#">Left Nav Button</a></li>
                </ul> -->
                </section>
            </nav>
    </div><!-- nav bar -->
    