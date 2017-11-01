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
        <?php echo form_open('Vagas_companies/create_job', ['role' => 'form']);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="create_job" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true"
             style="display: none;">
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
                            <input class="form-control" placeholder="Descrição da Vaga" type="text" name="description"
                                   autofocus
                                   value="" autocomplete="off"
                                   required>
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
                    <h4> <?php echo $job_salvo['attributes']['title'] ?></h4>
                    <p>
                        <?php echo $job_salvo['attributes']['description'] ?>
                        <br>
                    </p>

                </div>
            </div>
        <?php } ?>
    </article>
</div>
