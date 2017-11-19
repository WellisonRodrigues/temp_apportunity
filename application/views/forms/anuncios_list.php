<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:32
 */

?>
<div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">
    <h1>Lista de Anuncios</h1>

    <hr>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
         style="display: none;">
        <div class="modal-dialog">
            <?php
            echo form_open('Anuncios/cadastro', ['role' => 'form']);
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Dados Pessoais</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Imagem de Perfil (JPG)</label>
                        <input class="form-control" type="file" name="file" autofocus
                               value="" autocomplete="off"
                        >
                    </div>
                    <div class="form-group">
                        <label>Curriculum (PDF)</label>
                        <input class="form-control" type="file" name="pdf" autofocus
                               value="" autocomplete="off"
                        >
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Nome" type="text" name="name_user" autofocus
                               value="<?php echo $profile['attributes']['name'] ?>" autocomplete="off"
                               required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Idade" type="number" name="age" autofocus
                               value="<?php echo $profile['attributes']['age'] ?>" autocomplete="off"
                               required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Região" type="text" name="region" autofocus
                               value="<?php echo $profile['attributes']['region'] ?>" autocomplete="off"
                               required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Vagas de Interesse" type="text" name="carrer" autofocus
                               value="<?php echo $profile['attributes']['carrer'] ?>" autocomplete="off"
                               required>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" name="editar"
                           value="Editar">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <?php echo form_close() ?>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <i class="fa fa-plus" data-toggle="modal" data-target="#myModal"> Cadastrar Anuncio</i>

    <div class="tab-content">
        <div class="tab-pane active" id="tab_saved_jobs">
            <?php
            foreach ($jobs as $job_salvo) {
                ?>


                <article>
                    <div class="social-feed-box">
                        <div class="social-avatar">
                            <a href="" class="pull-left">
                                <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a1.jpg">

                            </a>
                            <div class="text-right">
                                <?php echo anchor('vagas/save_job_application/' .$job_salvo['data']['id'],
                                    '<p class="btn btn-primary"/>Candidatar-se</p>') ?>
                            </div>
                            <div class="media-body">
                                <a href="#">
                                    <?php
                                    echo $name;
                                    ?>
                                </a>
                                <small class="text-muted"></small>
                            </div>
                        </div>
                        <div class="social-body">
                            <h4> <?php echo $job_salvo['data']['attributes']['title'] ?></h4>
                            <p>
                                <?php echo $job_salvo['data']['attributes']['description'] ?>
                                <br>
                            </p>

                        </div>
                    </div>
                </article>

            <?php } ?>
        </div>
        <div class="tab-pane" id="tab_job_applications">
            <?php

            foreach ($jobs_application['response']['data'] as $job_app) {
                foreach ($jobs_application['response']['included'] as $include){
                    if ($include['id'] == $job_app['relationships']['job']['data']['id'] and $include['type'] == 'jobs') {
                        $title = $include['attributes']['title'];
                        $description = $include['attributes']['description'];
                    }
                }
           ?>
                <article>
                    <div class="social-feed-box">
                        <div class="social-avatar">
                            <a href="" class="pull-left">
                                <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a1.jpg">

                            </a>
                            <div class="media-body">
                                <a href="#">
                                    <?php
                                    echo @$name;
                                    ?>
                                </a>
                                <small class="text-muted"></small>
                            </div>
                        </div>
                        <div class="social-body">
                            <h4> <?php echo $title ?></h4>
                            <p>
                                <?php echo $description ?>
                                <br>
                            </p>

                        </div>
                    </div>
                </article>
           <?php }


            ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
