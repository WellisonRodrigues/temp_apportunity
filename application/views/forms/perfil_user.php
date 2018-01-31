<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 19/10/2017
 * Time: 23:49
 */
//print_r($profile);
//var_dump($profile);
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
                    <input id="imageinput" type="file" accept="image/gif, image/jpeg, image/png"
                           onchange="readURL(this);"/>
                </div>
                <div class="form-group">
                    <label>Curriculum (PDF)</label>
                    <input id="fileinput" type="file" accept="application/pdf"
                           onchange="readURL2(this);"/>
                </div>
                <input type="hidden" name="image_atual" value="<?php echo $profile['attributes']['image'] ?>">
                <input type="hidden" name="new_image" id="new_image" value="">
                <input type="hidden" name="document_atual" value="<?php echo $profile['attributes']['document'] ?>">
                <input type="hidden" name="new_document" id="new_document" value="">
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
            <script type="text/javascript">
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#falseinput').attr('src', e.target.result);
                            $('#new_image').val(e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                function readURL2(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#falseinput2').attr('src', e.target.result);
                            $('#new_document').val(e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
        </div>
        <!-- /.modal-content -->
    </div>
    <?php echo form_close() ?>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <?php
        echo form_open('Perfil_user/editarEmpresa', ['role' => 'form']);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Dados da Empresa</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Imagem de Perfil (JPG)</label>
                    <input id="imageinpu2" type="file" accept="image/gif, image/jpeg, image/png"
                           onchange="readURL3(this);"/>
                </div>
                <input type="hidden" name="image_atual3" value="<?php echo $profile['attributes']['image'] ?>">
                <input type="hidden" name="new_image3" id="new_image3" value="">
                <div class="form-group">
                    <input class="form-control" placeholder="Nome" type="text" name="name" autofocus
                           value="<?php echo $profile['attributes']['name'] ?>" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Email" type="text" name="email" autofocus
                           value="<?php echo $profile['attributes']['email'] ?>" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Region" type="text" name="region" autofocus
                           value="<?php echo $profile['attributes']['region'] ?>" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="about" type="text" name="about" autofocus
                           value="<?php echo $profile['attributes']['about'] ?>" autocomplete="off"
                           required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input type="submit" class="btn btn-primary" name="editar"
                       value="Editar">
            </div>
            <script type="text/javascript">
                function readURL3(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#falseinput3').attr('src', e.target.result);
                            $('#new_image3').val(e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
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
            $image = $profile['attributes']['image'];
            $name = $profile['attributes']['name'];
            if ($name) {
                $return_name = $name;
            } else {

                $return_name = 'Not name Not name';
            }
            if (!$image) {
                $image_final = 'data:image/png;base64,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';
            } else {
                $image_final = $image;
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="text-right">
                        <h4><i
                                    class="fa fa-pencil" data-toggle="modal" data-target="#myModal"></i>
                        </h4>
                    </div>

                    <div class=" text-center center-block">
                        <img src="<?php echo $image_final ?>" width="120px" height="120px"
                             class="img-circle">
                        <div class="row"><h4><strong><?php echo $return_name ?></strong></h4>
                        </div>
                        <br>
                        <?php echo $profile['attributes']['region'] ?><br>
                        <div class="row"><?php echo $inscritos; ?> Inscritos</div>
                        <br>
                        <button type="button" id="curriculo" class="btn btn-primary">Visualizar Curriculo</button>
                    </div>
                </div>
                <div class="panel-body">
                    <?php $this->load->view('forms/languages_users') ?>
                </div>
            </div>
        <?php }
        if ($this->session->userdata('logado')['type'] == 'companies') {
            $image = $profile['attributes']['image'];
            $name = $profile['attributes']['name'];
            if ($name) {
                $return_name = $name;
            } else {

                $return_name = 'Not name Not name';
            }
            if (!$image) {
                $image_final = 'data:image/png;base64,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';
            } else {
                $image_final = $image;
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="text-right">
                        <h4><i
                                    class="fa fa-pencil" data-toggle="modal" data-target="#myModal2"></i>
                        </h4>
                    </div>
                    <div class=" text-center center-block">
                        <img src="<?php echo $image_final ?>" width="150px" height="150px"
                             class="img-circle">
                        <div class="row"><h4><strong><?php echo $name ?></strong></h4>
                        </div>
                        <?php echo $profile['attributes']['region'] ?>
                        <br>
                        <?php echo $profile['attributes']['about'] ?>
                        <!--                    <div class="row">--><?php //echo $inscritos; ?><!-- Inscritos</div>-->
                        <br>
                        <br>
                    </div>
                </div>

            </div>
            <?php
        } ?>
    </div>
    <script>
        $("#curriculo").bind('click', function () {
            alert('ok');
        });
    </script>