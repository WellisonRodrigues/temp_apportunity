<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 18/11/2017
 * Time: 14:39
 */

?>
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">

            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <div class="row">
                        <div class="col-md-6 text-center"><h3>Seguindo <br> <?php echo @$seguindo ?></h3></div>
                        <div class="col-md-6 text-center"><h3>Seguidores<br> <?php echo @$inscritos ?></h3></div>
                    </div>
                </div>
                <div class="panel panel-body">
                    <div class="row">
                        <?php foreach ($followed as $follow_wed) { ?>

                            <div class="col-md-6">
                                <img src="<?php echo base_url(IMAGES); ?>/profile.jpg" class="img-rounded" width="15%"
                                     height="15%">
                            </div>

                        <?php } ?>
                    </div>
                    <br>
                    <div class="row">
                        <?php foreach ($followers as $follow_as) { ?>

                            <div class="col-md-6">
                                <img src="<?php echo base_url(IMAGES); ?>/profile.jpg" class="img-rounded" width="15%"
                                     height="15%">
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
