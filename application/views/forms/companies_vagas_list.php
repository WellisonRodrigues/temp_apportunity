<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 31/10/2017
 * Time: 21:23
 */

//print_r($my_company_jobs);

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:32
 */
?>

<div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">
    <article>
        <div class="text-right">
            <p>
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#create_job">
                    Publicar nova vaga <i class="fa fa-plus"></i>
                </button>
            </p>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="create_job" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true"
             style="display: none;">
            <?php echo form_open('Vagas_companies/create_job', ['role' => 'form']);
            ?>
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Nova Vaga</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <input class="form-control" placeholder="Titulo da Vaga" type="text" name="title" autofocus
                                   value="" autocomplete="off"
                                   required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Descrição da Vaga" name="description"
                                      autofocus
                                      rows="5" autocomplete="off"
                                      required></textarea>
                        </div>
                        <div class="form-group">
                            <label> Data termino da vaga :</label>
                            <input class="form-control" placeholder="Data termino da vaga" type="date" name="exp_date"
                                   autofocus
                                   value="" autocomplete="off"
                                   required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" name="create_job"
                               value="salvar">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <?php echo form_close() ?>
            <!-- /.modal-dialog -->
        </div>

        <?php
        foreach ($my_company_jobs as $job_salvo) {
            foreach ($includes as $include) {
                if ($include['id'] == $job_salvo['relationships']['company']['data']['id']) {
                    $name = $include['attributes']['name'];
                    $url = $include['attributes']['img']['url'];
                }
            }
            ?>
            <div class="social-feed-box">
                <div class="social-avatar">
                    <a href="" class="pull-left">
                        <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a1.jpg">
                    </a>
                    <div class="text-right">
                        <strong>
                            <i style="text-decoration: none;color: darkgreen" class="fa fa-edit" data-toggle="modal"
                               data-target=".edit_job<?php echo $job_salvo['id'] ?>"> </i> Editar

                            <?php echo anchor('Vagas_companies/delete_job/' . $job_salvo['id'],
                                '<i style="text-decoration: none;color: darkred" class="fa fa-trash"/> </i>') ?> Excluir

                        </strong>
                    </div>

                    <div class="media-body">
                        <a href="#">
                            <?php
                            echo $name;
                            ?>
                        </a>
                        <small class="text-muted"><?php echo $job_salvo['attributes']['published-at'] ?></small>
                    </div>
                </div>
                <div class="social-body">
                    <h4> <?php echo $job_salvo['attributes']['title'] ?></h4>
                    <p>
                        <?php echo $job_salvo['attributes']['description'] ?>
                        <br>
                    </p>
                    <hr>
                    <p>
                        Vaga expira
                        em: <?php echo date('d/m/Y H:i:s', strtotime($job_salvo['attributes']['exp-date'])); ?>
                        <br>
                    </p>

                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade edit_job<?php echo $job_salvo['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true"
                 style="display: none;">
                <?php echo form_open('Vagas_companies/edit_job', ['role' => 'form']);
                ?>
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Nova Vaga</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <input class="form-control" placeholder="Titulo da Vaga" type="text" name="title"
                                       autofocus
                                       value="<?php echo $job_salvo['attributes']['title'] ?>" autocomplete="off"
                                       required>
                            </div>
                            <div class="form-group">
                            <textarea class="form-control" placeholder="Descrição da Vaga" name="description"
                                      autofocus
                                      rows="5" autocomplete="off"
                                      required><?php echo $job_salvo['attributes']['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label> Data termino da vaga :</label>
                                <input class="form-control" placeholder="Data termino da vaga" type="date"
                                       name="exp_date"
                                       autofocus
                                       value="<?php echo date('d/m/Y H:i:s', strtotime($job_salvo['attributes']['exp-date'])); ?>"
                                       autocomplete="off"
                                       required>
                            </div>
                            <input type="hidden" name="idjob" value="<?php echo $job_salvo['id'] ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" name="edit_job"
                                   value="salvar">
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <?php echo form_close() ?>
                <!-- /.modal-dialog -->
            </div>
        <?php } ?>
        <!--        <script>-->
        <!--            $(document).ready(function () {-->
        <!--                $('.delete_job').click(function () {-->
        <!--                    var idjob = $(this).data('idjob');-->
        <!---->
        <!--                    if (idjob != null) {-->
        <!--                        //$('.content.'+ idjob).empty();-->
        <!--//                        $.post('Vagas_companies/delete_job/' + idjob, function (data) {-->
        <!---->
        <!--                        alert('ok');-->
        <!--                    }-->
        <!--                });-->
        <!--            });-->
        <!--        </script>-->
    </article>
</div>
