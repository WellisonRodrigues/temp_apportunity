<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 19/10/2017
 * Time: 23:49
 */
//print_r($included[0]['attributes']['email']);
//print_r($profile['attributes']);
?>
<!-- Modal -->
<div class="modal fade" id="modal_dados_pessoais" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <?php
        echo form_open('Perfil_user/editar', ['role' => 'form']);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Dados Pessoais</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <input class="form-control" placeholder="Nome" type="text" name="name_user" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Idade" type="number" name="age" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Região" type="text" name="region" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Vagas de Interesse" type="text" name="carrer" autofocus
                           value="" autocomplete="off"
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
<div class="modal fade" id="modal_skills" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <?php
        echo form_open('Perfil_user/editar', ['role' => 'form']);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Dados Pessoais</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <input class="form-control" placeholder="Nome" type="text" name="name_user" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Idade" type="number" name="age" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Região" type="text" name="region" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Vagas de Interesse" type="text" name="carrer" autofocus
                           value="" autocomplete="off"
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

<div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <div class="text-right">
                    <h4><i
                                class="fa fa-pencil" data-toggle="modal" data-target="#modal_dados_pessoais"></i>
                    </h4>
                </div>
                <div class=" text-center center-block">
                    <img src="<?php echo base_url(IMAGES); ?>/profile.jpg" width="15%" height="15%"
                         class="img-circle">
                    <div class="row"><h4><strong><?php echo $profile['attributes']['name'] ?></strong></h4>
                    </div>
                    <br>
                    <?php echo $profile['attributes']['region'] ?><br>
                    <!--                    <div class="row">36 Inscritos</div>-->
                    <br>
                    <div class="row">
                        <?php echo anchor('perfil_user/editar', 'Tornar empresa', 'type="button" class="btn btn-primary"') ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-body">
                <div class="text-center">
                    <div class="text-right">
                        <h4><i class="fa fa-pencil"></i></h4>
                    </div>
                    <div class="row"><h4><strong>Sobre</strong></h4></div>
                    Email : <?php echo $included[0]['attributes']['email'] ?> <br>
                    Idade : <?php echo $profile['attributes']['age'] ?> <br>

                    <!--                    verificar habilitação pois a mesma não consta na api-->

                    Habilitação : AD <br>
                    Vagas em Interesse : <?php echo $profile['attributes']['carrer'] ?><br>
                    <br>
                    <hr>
                    <div class="text-right">
                        <h4><i class="fa fa-pencil"></i></h4>
                    </div>
                    <div class="row"><h4><strong>Conheçimento do Idioma Japones</strong></h4></div>
                    Fala : 90%<br>
                    Escrita : 70%<br>
                    Entende : 100%<br>

                </div>
            </div>
        </div>
    </div>
</div>