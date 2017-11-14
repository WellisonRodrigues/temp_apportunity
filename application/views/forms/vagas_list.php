<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:32
 */

?>
<div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">

    <ul class="nav nav-tabs tabs-pills">
        <li class="active"><a href="#tab_saved_jobs" data-toggle="tab" id="li_saved_job">Vagas Salvas</a></li>
        <li><a href="#tab_job_applications" data-toggle="tab" id="li_job_applications">Vagas Cadidatadas</a></li>
    </ul>
    <hr>

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
