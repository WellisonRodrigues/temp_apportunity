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
                    <h4 class="modal-title" id="myModalLabel">Dados do Anuncio</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Imagem (JPG)</label>
                        <input class="form-control" type="file" name="file" autofocus
                               value="" autocomplete="off"
                        >
                    </div>

                    <div class="form-group">
                        <label>Titulo</label>
                        <input class="form-control" placeholder="Titulo" type="text" name="titulo" autofocus
                               value="<?php echo $profile['attributes']['title'] ?>" autocomplete="off"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea class="form-control" placeholder="descricao"  name="descricao" autofocus autocomplete="off" required>
                            <?php echo $profile['attributes']['description'] ?>
                        </textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" name="cadastrar"
                           value="Cadastrar">
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
        <div class="tab-pane active">
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                <td>#</td>
                <td>Titulo</td>
                <td>Descrição</td>
                <td>Imagem</td>
                <td>Ações</td>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
