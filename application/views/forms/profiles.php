<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 21/11/2017
 * Time: 21:55
 */

//echo 'ok';

//print_r($idprofile);
//print_r($dados);
//print_r($type);

if ($dados['data']['type'] == 'companies') {

    ?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class=" text-center center-block">
                        <img src="<?php echo $dados['data']['attributes']['image'] ?>" width="15%" height="15%"
                             class="img-circle">
                        <div class="row"><h4><strong><?php echo $dados['data']['attributes']['name'] ?></strong></h4>
                        </div>
                        <div class="row"><h4><strong><?php echo $dados['data']['attributes']['region'] ?></strong></h4>
                        </div>
                        <br>
                        <?php echo anchor('perfil_user/editar', 'Enviar mensagem', 'type="button" class="btn btn-primary"') ?>

                        <?php echo anchor('perfil_user/editar', 'Seguir', 'type="button" class="btn btn-primary"') ?>
                    </div>
                </div>
                <div class="panel-body">
                   <div class="row text-center">
                        <label class="label">Sobre</label>
                        <div class="row"><h4><strong><?php echo $dados['data']['attributes']['about'] ?></strong></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>


    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <div class=" text-center center-block">
                        <img src="<?php echo $dados['data']['attributes']['image'] ?>" width="15%" height="15%"
                             class="img-circle">
                        <div class="row"><h4><strong><?php echo $dados['data']['attributes']['name'] ?></strong></h4>
                        </div>
                        <br>
                        <?php echo $profile['attributes']['region'] ?><br>


                    </div>
                </div>
                <div class="panel panel-body">
                    <div class="row text-center">
                        <?php echo anchor('perfil_user/editar', 'Enviar mensagem', 'type="button" class="btn btn-primary"') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } ?>