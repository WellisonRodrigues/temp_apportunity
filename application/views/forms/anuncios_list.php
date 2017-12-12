<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:32
 */

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">
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
                        <input class="form-control" placeholder="Titulo" type="text" name="title" autofocus
                               value="<?php echo $anum['attributes']['title'] ?>" autocomplete="off"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea class="form-control" placeholder="Descricao" name="description" autofocus
                                  autocomplete="off"
                                  required><?php echo $anum['attributes']['description'] ?></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="hidden" name="id_anuncio" value="<?php echo $anum['id']; ?>">
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
    <div class="text-right">
        <p>
            <button type="button" class="btn btn-primary btn-small" data-toggle="modal" data-target="#myModal">
                Novo Anúncio <i class="fa fa-plus"></i>
            </button>
        </p>
    </div>
    <!---->
    <!--    <i class="fa fa-plus" data-toggle="modal" data-target="#myModal"> Cadastrar Anuncio</i>-->
    <?php
    foreach ($anuncios as $anuncio) {
        $id  = $anuncio["id"];
        ?>
        <div class="social-feed-box" id="idanuncio_<?php echo $id; ?>">
            <div class="social-avatar">
                <a href="" class="pull-left">
                    <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a1.jpg">
                </a>
                <div class="pull-right">
                    <strong>
                        <button type="button"
                                class="btn btn-primary small" data-toggle="modal"
                                data-target=".edit_job<?php echo $id ?>"><i class="fa fa-edit"></i>
                        </button>
                        <button type="button"
                                class="btn btn-danger small remover" data-toggle="modal" data-codigo="<?php echo $id ?>"
                                data-target=".edit_job<?php echo $id ?>">
                            <?php echo anchor('Vagas_companies/delete_job/'.$id.'' . $job_salvo['id'], '<i class="fa fa-trash">
                            </i>') ?>
                        </button>
                    </strong>
                </div>

                <div class="media-body">
                    <a href="#">
                        <?php
                        echo $name;
                        ?>
                    </a>
                    <!--                <small class="text-muted">-->
                    <?php //echo $job_salvo['attributes']['published-at'] ?><!--</small>-->
                </div>
            </div>
            <div class="social-body">
                <h4> <?php echo $anuncio["attributes"]["title"] ?></h4>
                <p>
                    <?php echo $anuncio["attributes"]["description"] ?>
                    <br>
                </p>
				
                <hr>
                <img src="<?php echo $anuncio["attributes"]["image"]['url'] ?>" height="80px"
                     alt="<?php echo $anuncio["attributes"]["title"] ?>"/>
                <!--            <p>-->
                <!--                Vaga expira-->
                <!--                em: --><?php //echo date('d/m/Y H:i:s', strtotime($job_salvo['attributes']['exp-date'])); ?>
                <!--                <br>-->
                <!--            </p>-->

            </div>
        </div>

        <!---->
        <!--    <div class="tab-content">-->
        <!--        <div class="tab-pane active">-->
        <!--            <table class="table">-->
        <!--                <thead>-->
        <!--                <th>#</th>-->
        <!--                <th>Titulo</th>-->
        <!--                <th>Descrição</th>-->
        <!--                <th>Imagem</th>-->
        <!--                <th>Ações</th>-->
        <!--                </thead>-->
        <!--                <tbody>-->
        <!---->
        <!--                    <tr id="--><?php //echo $anuncio["id"] ?><!--">-->
        <!--                        <td>--><?php //echo $anuncio["id"] ?><!--</td>-->
        <!--                        <td></td>-->
        <!--                        <td>--><?php //echo $anuncio["attributes"]["description"] ?><!--</td>-->
        <!--                        <td><img src="--><?php //echo $anuncio["attributes"]["image"]['url'] ?><!--" height="80px" alt="--><?php //echo $anuncio["attributes"]["title"] ?><!--"/> </td>-->
        <!--                        <td>-->
        <!--                            <a href="--><?php //echo $anuncio["id"] ?><!--" class="remover"><i class="fa fa-remove"-->
        <!--                                                                                      style="font-size:18px">Excluir</i></a>-->
        <!--                            <i class="fa fa-edit editar2" data-toggle="modal" data-target="#myModal" data-codigo="--><?php //echo $anuncio["id"]?><!--"-->
        <!--                                style="cursor: pointer;font-size:18px">Editar</i>-->
        <!--                        </td>-->
        <!--                    </tr>-->
        <!--               -->
        <!--                </tbody>-->
        <!--            </table>-->
        <!--        </div>-->
        <!--    </div>-->
    <?php } ?>
    <div class="clearfix"></div>

    <script>
        $(document).ready(function () {
            $('.remover').bind('click', function () {
                if (confirm("Deseja realmente exlcuir?")) {
                    //$(".fa-heart-o").css("color", "red");
                    var idanuncio = $(this).data('codigo');
                    $('#idanuncio_' + idanuncio).remove();
                    $.post('Anuncios/deletar', {idanuncio: idanuncio}, function (data) {
                    }, 'json');
                    return false;
                }
                return false;
            });
            $(".editar2").bind('click', function () {
                var id = $(this).data('codigo');
                $.post('Anuncios/deletar', {idanuncio: idanuncio}, function (data) {

                }, 'json');
                return false;
                $('#myModal').show();
            })
        });
    </script>
</div>
