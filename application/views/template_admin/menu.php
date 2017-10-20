<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 13/03/2017
 * Time: 20:23
 */
?>

<header>
    <div class="row">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url('painel_admin') ?>"><img rel="icon"
                                                                                               src="<?php echo base_url(IMAGES); ?>/pessoinha-50px.png"/></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="#""><h4><strong><i class="fa fa-large fa-star"> Torne se Premium</i></strong>
                            </h4></a></li>
                        <li><a href="#"><h4><strong><i class="fa fa-large fa-question-circle">
                                            Ajuda</i></strong></h4></a></li>
                        <li><a href="#"><h4><strong><i class="fa fa-large fa-file-text"> Termos de Uso</i></strong>
                                </h4></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><h4><strong><i class="fa fa-large fa-paper-plane"> Feed</i></strong></h4></a></li>
                        <li><a href="#"><h4><strong><i class="fa fa-large fa-users"> Vagas</i></strong></h4></a></li>
                        <li><a href="#"><h4><strong><i class="fa fa-large fa-user"> Perfil</i></strong></h4></a></li>
                        <li><a href="#"><h4><strong><i class="fa fa-large fa-sign-out"> Sair</i></strong></h4></a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
    </div>
</header>