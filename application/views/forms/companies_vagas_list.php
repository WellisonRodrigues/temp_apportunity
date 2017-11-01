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
                <button type="button" class="btn btn-primary btn-lg">Publicar nova vaga <i class="fa fa-plus"></i>
                </button>
            </p>
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
