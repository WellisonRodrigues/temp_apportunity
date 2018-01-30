<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 01/11/2017
 * Time: 17:48
 */
?>
<!-- Modal -->
<div class="modal fade" id="new_languages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <?php
        echo form_open('Perfil_user/create_idiomas', ['role' => 'form']);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Novo Idioma</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control" placeholder="Idioma" type="text" name="name_idioma" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <select class="form-control" name="level" required>
                        <option value="">-- Selecione o level --</option>
                        <option value="basic">Basic</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                        <option value="fluent">Fluent</option>
                        <option value="native">Native</option>
                    </select>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input type="submit" class="btn btn-primary" name="salvar"
                       value="Salvar">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <?php echo form_close() ?>
    <!-- /.modal-dialog -->
</div>


<!-- Modal -->
<div class="modal fade" id="new_habilidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <?php
        echo form_open('Perfil_user/create_habilidades', ['role' => 'form']);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Nova Habilidade</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control" placeholder="Habilidade" type="text" name="name_habilidades" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <select class="form-control" name="level" required>
                        <option value="">-- Selecione o level --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input type="submit" class="btn btn-primary" name="salvar"
                       value="Salvar">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <?php echo form_close() ?>
    <!-- /.modal-dialog -->
</div>
<div class="text-center">
    <div class="row"><h4><strong>Sobre</strong></h4></div>
    Idade : <?php echo $profile['attributes']['age'] ?> <br>
    Email : <?php echo $included[0]['attributes']['email'] ?> <br>
    <!--                    verificar habilitação pois a mesma não consta na api-->

    <!--    Habilitação : AD <br>-->
    Vagas em Interesse : <?php echo $profile['attributes']['carrer'] ?><br>
    <br>
    <hr>
    <div class="text-right">
        <button type="button" class="btn btn-primary small" data-toggle="modal"  title="Cadastrar Idioma" style="margin:2px 0px"
                data-target="#new_languages"><i class="fa fa-plus"></i></button>
    </div>
    <?php foreach ($idiomas as $idioma) { ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <div class="text-right">
                    <h4><strong>Conheçimento do
                            Idioma <?php echo $idioma['attributes']['name'] ?>
                        </strong></h4>
                </div>
            </div>
            <div class="col-md-2">

                <button type="button" class="btn btn-primary"><i
                        style="text-decoration: none;color: white"
                        class="fa fa-pencil" data-toggle="modal"
                        data-target=".edit_languages<?php echo $idioma['id'] ?>"></i>
                </button>
                <button type="button"
                        class="btn btn-danger"> <?php echo anchor('Perfil_user/delete_idioma/' . $idioma['id'],
                        '<i
                            style="text-decoration: none;color: white" class="fa fa-trash"> </i>') ?></button>


            </div>
        </div>
        Level : <?php echo $idioma['attributes']['level'] ?><br>

        <div class="modal fade edit_languages<?php echo $idioma['id'] ?>" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <?php
                echo form_open('Perfil_user/edit_language', ['role' => 'form']);
                ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Editar Idioma</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" placeholder="Idioma" type="text" name="name" autofocus
                                   value="<?php echo $idioma['attributes']['name'] ?>" autocomplete="off"
                                   required readonly>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="level" required>
                                <option value="">-- Selecione o level --</option>
                                <option value="basic" <?php if($idioma['attributes']['level'] == 'basic') echo "SELECTED"; ?>>Basic</option>
                                <option value="intermediate" <?php if($idioma['attributes']['level'] == 'intermediate') echo "SELECTED"; ?>>Intermediate</option>
                                <option value="advanced" <?php if($idioma['attributes']['level'] == 'advanced') echo "SELECTED"; ?>>Advanced</option>
                                <option value="fluent" <?php if($idioma['attributes']['level'] == 'fluent') echo "SELECTED"; ?>>Fluent</option>
                                <option value="native" <?php if($idioma['attributes']['level'] == 'native') echo "SELECTED"; ?>>Native</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?php echo $idioma['id'] ?>" />
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

    <?php } ?>

    <div class="text-right">
        <button type="button" class="btn btn-primary small" data-toggle="modal" title="Cadastrar Habilidades" style="margin:2px 0px"
                data-target="#new_habilidades"><i class="fa fa-plus"></i></button>
    </div>

    <?php foreach ($habilidades as $habilidade) { ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <div class="text-right">
                    <h4><strong>Habilidades <?php echo $habilidade['attributes']['name'] ?>
                        </strong></h4>
                </div>
            </div>
            <div class="col-md-2">

                <button type="button" class="btn btn-primary"><i
                        style="text-decoration: none;color: white"
                        class="fa fa-pencil" data-toggle="modal"
                        data-target=".edit_habilidade<?php echo $habilidade['id'] ?>"></i>
                </button>
                <button type="button"
                        class="btn btn-danger"> <?php echo anchor('Perfil_user/delete_habilidade/' . $habilidade['id'],
                        '<i
                            style="text-decoration: none;color: white" class="fa fa-trash"> </i>') ?></button>


            </div>
        </div>
        Level : <?php echo $habilidade['attributes']['level'] ?><br>

        <div class="modal fade edit_habilidade<?php echo $habilidade['id'] ?>" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <?php
                echo form_open('Perfil_user/edit_habilidade', ['role' => 'form']);
                ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Editar Habilidade</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" placeholder="Idioma" type="text" name="name" autofocus
                                   value="<?php echo $habilidade['attributes']['name'] ?>" autocomplete="off"
                                   required readonly>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="level" required>
                                <option value="">-- Selecione o level --</option>
                                <option value="1" <?php if($habilidade['attributes']['level'] == '1') echo "SELECTED"; ?>>1</option>
                                <option value="2" <?php if($habilidade['attributes']['level'] == '2') echo "SELECTED"; ?>>2</option>
                                <option value="3" <?php if($habilidade['attributes']['level'] == '3') echo "SELECTED"; ?>>3</option>
                                <option value="4" <?php if($habilidade['attributes']['level'] == '4') echo "SELECTED"; ?>>4</option>
                                <option value="5" <?php if($habilidade['attributes']['level'] == '5') echo "SELECTED"; ?>>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?php echo $habilidade['id'] ?>" />
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

    <?php } ?>
</div>