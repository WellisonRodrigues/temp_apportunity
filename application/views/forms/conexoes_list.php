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
                        <div class="col-md-6 text-center">
                            <h3><a href="#tab_seguindo" data-toggle="tab"
                                   id="li_seguindo">Seguindo <br> <?php echo @$seguindo ?></a></h3></div>
                        <div class=" col-md-6 text-center">
                            <h3><a href="#tab_seguidores" data-toggle="tab"
                                   id="li_seguidores">Seguidores<br> <?php echo @$inscritos ?></a></h3>
                        </div>
                    </div>
                </div>

                <div class="panel panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_seguidores">
                            <div class="text-left">
                                <h3>Seguidores</h3>
                            </div>
                            <div class="row">
                                <?php foreach ($followed as $follow_wed) { ?>

                                    <div class="col-md-4">
                                        <div class="jumbotron">
                                            <div class="text-center">
                                                <img src="<?php echo base_url(IMAGES); ?>/profile.jpg"
                                                     class="img-circle"
                                                     width="50%"
                                                     height="50%"><br>
                                                <b> Wellison<br>
                                                    26 anos</b><br>
                                                <button type="button" class="btn btn-primary">
                                                    Seguindo
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_seguindo">
                            <div class="text-left">
                                <h3>Seguindo</h3>
                            </div>
                            <div class="row">
                                <?php foreach ($followers as $follow_as) { ?>

                                    <div class="col-md-4">
                                        <div class="jumbotron">
                                            <div class="text-center">
                                                <img src="<?php echo base_url(IMAGES); ?>/profile.jpg"
                                                     class="img-circle"
                                                     width="50%"
                                                     height="50%"><br>
                                                <b> Wellison<br>
                                                    26 anos</b><br>
                                                <button type="button" class="btn btn-primary">
                                                    Seguindo
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
