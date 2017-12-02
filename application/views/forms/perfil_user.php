<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 19/10/2017
 * Time: 23:49
 */
//print_r($included[0]['attributes']['email']);
//print_r($profile);
?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
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

<div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">
        <?php
        if ($this->session->userdata('logado')['type'] == 'users') {
            ?>
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <div class="text-right">
                        <h4><i
                                    class="fa fa-pencil" data-toggle="modal" data-target="#myModal"></i>
                        </h4>
                    </div>
                    <div class=" text-center center-block">
                        <img src="<?php echo base64_decode($profile['attributes']['image'])?>" width="15%" height="15%"
                             class="img-circle">
                        <div class="row"><h4><strong><?php echo $profile['attributes']['name'] ?></strong></h4>
                        </div>
                        <br>
                        <?php echo $profile['attributes']['region'] ?><br>
                        <div class="row"><?php echo $inscritos; ?> Inscritos</div>
                        <br>
                        <div class="row">
                            <?php echo anchor('perfil_user/editar', 'Tornar empresa', 'type="button" class="btn btn-primary"') ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-body">
                    <?php $this->load->view('forms/languages_users') ?>
                </div>
            </div>
        <?php }
        if ($this->session->userdata('logado')['type'] == 'companies') {

        ?>
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <div class="text-right">
                    <h4><i
                                class="fa fa-pencil" data-toggle="modal" data-target="#myModal"></i>
                    </h4>
                </div>
                <div class=" text-center center-block">
                    <img src="<?php echo base_url(IMAGES); ?>/profile.jpg" width="15%" height="15%"
                         class="img-circle">
                    <div class="row"><h4><strong><?php echo $profile['attributes']['name'] ?></strong></h4>
                    </div>
                    <br>
                    <div class="row"><?php echo $inscritos; ?> Inscritos</div>
                    <br>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>