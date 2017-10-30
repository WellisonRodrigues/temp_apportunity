<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:32
 */
foreach ($jobs as $job_salvo) {
    ?>
    <div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">
        <article>
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
                    <h4> <?php echo $job_salvo['data']['attributes']['title'] ?></h4>
                    <p>
                        <?php echo $job_salvo['data']['attributes']['description'] ?>
                        <br>
                    </p>

                </div>
            </div>
        </article>
    </div>
<?php } ?>