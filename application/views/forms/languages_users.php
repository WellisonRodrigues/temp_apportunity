<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 01/11/2017
 * Time: 17:48
 */
?>
<!-- Modal -->
<div class="modal fade" id="edit_languages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <?php
        echo form_open('Perfil_user/editar', ['role' => 'form']);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Novo Idioma</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control" placeholder="Idioma" type="text" name="idioma" autofocus
                           value="" autocomplete="off"
                           required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Level" type="text" name="level" autofocus
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
        <h4><i class="fa fa-pencil" data-toggle="modal" data-target="#edit_languages"></i></h4>
    </div>
    <?php foreach ($idiomas as $idioma) { ?>
        <div class="row"><h4><strong>Conheçimento do
                    Idioma <?php echo $idioma['attributes']['name'] ?></strong></h4></div>
        Level : <?php echo $idioma['attributes']['level'] ?><br>

    <?php } ?>
</div>