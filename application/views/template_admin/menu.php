<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 13/03/2017
 * Time: 20:23
 */
print_r($this->session->userdata('logado')->id);
?>


<header>
    <div class="row">
        <nav class="navbar navbar-default">

            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle btn-default" data-toggle="collapse"
                            data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">

<!--                        <b class="sr-only">Toggle navigation</b>-->
                        <b class="icon-bar"></b>
                        <b class="icon-bar"></b>
                        <b class="icon-bar"></b>
                    </button>
                    <div class="metade-collor">
                        <div class="col-md-offset-3">
                            <a class="navbar-brand" href="<?php echo base_url('Painel_admin') ?>">
                                <img rel="icon"
                                     src="<?php echo base_url(IMAGES); ?>/pessoinha-50px.png"/></a>
                        </div>
                    </div>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <!--                        <ul class="nav navbar-nav">-->
                    <!--                            --><?php //if (!$this->session->userdata('logado')['type'] == 'users') {
                    //
                    //                                ?>
                    <!--                                <li><a href="#""><h4><strong><i class="fa fa-large fa-star"> Torne se-->
                    <!--                                                Premium</i></strong>-->
                    <!--                                    </h4></a></li>-->
                    <!--                            --><?php //} ?>
                    <!--                            <li><a href="#"><h4><strong><i class="fa fa-large fa-question-circle">-->
                    <!--                                                Ajuda</i></strong></h4></a></li>-->
                    <!--                            <li><a href="#"><h4><strong><i class="fa fa-large fa-file-text"> Termos de Uso</i></strong>-->
                    <!--                                    </h4></a></li>-->
                    <!--                        </ul>-->
                    <ul class="nav navbar-nav navbar-right">
                        <?php if ($this->session->userdata('logado')['type'] == 'users') {

                            ?>
                            <li><a href="<?php echo base_url('Mensagens') ?>"><h4><strong><i
                                                    class="fa fa-large fa-paper-plane"> Mensagens</i></strong></h4>
                                </a>
                            </li>
                            <li><a href="<?php echo base_url('Painel_admin') ?>"><h4><strong><i
                                                    class="fa fa-large fa-paper-plane"> Feed</i></strong></h4></a>
                            </li>
                            <li><a href="<?php echo base_url('Vagas') ?>"><h4><strong><i
                                                    class="fa fa-large fa-edit">
                                                Vagas</i></strong></h4></a></li>

                        <?php }
                        if ($this->session->userdata('logado')['type'] == 'companies') {
                            ?>
                            <li><a href="<?php echo base_url('Mensagens') ?>"><h4><strong><i
                                                    class="fa fa-large fa-paper-plane"> Mensagens</i></strong></h4>
                                </a>
                            </li>

                            <li><a href="<?php echo base_url('Vagas_companies') ?>"><h4><strong><i
                                                    class="fa fa-large fa-edit">
                                                Vagas publicadas</i></strong></h4></a></li>
                            <li><a href="<?php echo base_url('Anuncios') ?>"><h4><strong><i
                                                    class="fa fa-large fa-edit">
                                                Anuncios</i></strong></h4></a></li>

                        <?php } ?>
                        <li><a href="<?php echo base_url('Perfil_user') ?>"><h4><strong><i
                                                class="fa fa-large fa-user">
                                            Perfil</i></strong></h4></a></li>
                        <li><a href="<?php echo base_url('Pesquisar') ?>"><h4><strong><i
                                                class="fa fa-large fa-search">
                                            Pesquisar</i></strong></h4></a></li>
                        <li><a href="<?php echo base_url('Follows/index') ?>"><h4><strong><i
                                                class="fa fa-large fa-users"> Conexões</i></strong></h4></a></li>
                        <li>  <?php
                            echo anchor('Sair', '<b><h4><strong><i class="fa fa-large fa-sign-out"> Sair</i></strong></h4></b>')

                            ?></li>
                        <!--                        <li><a href="#"><h4><strong><i class="fa fa-large fa-sign-out"> Sair</i></strong></h4></a></li>-->
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
            <!--/.container-fluid -->
        </nav>
    </div>
</header>