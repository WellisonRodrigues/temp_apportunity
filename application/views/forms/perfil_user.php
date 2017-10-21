<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 19/10/2017
 * Time: 23:49
 */
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <div class="text-center center-block">
                    <img src="<?php echo base_url(IMAGES); ?>/profile.jpg" width="15%" height="15%"
                         class="img-circle">
                    <div class="row"><h4><strong>Paulo Henrique</strong></h4></div>
                    <br>
                    Tokyo, Japan<br>
                    <div class="row">36 Inscritos</div>
                    <br>
                    <div class="row">
                        <?php echo anchor('perfil_user/editar', 'Tornar empresa', 'type="button" class="btn btn-primary"') ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-body">
                <div class="text-center">
                    <div class="text-right">
                        <h4><i class="fa fa-pencil"></i></h4>
                    </div>
                    <div class="row"><h4><strong>Sobre</strong></h4></div>
                    Email : welllison.244@gmail.com <br>
                    Idade : 26 anos <br>
                    Habilitação : AD <br>
                    Vagas em Interesse : ......<br>
                    <br>
                    <hr>
                    <div class="text-right">
                        <h4><i class="fa fa-pencil"></i></h4>
                    </div>
                    <div class="row"><h4><strong>Conheçimento do Idioma Japones</strong></h4></div>
                    Fala : 90%<br>
                    Escrita : 70%<br>
                    Entende : 100%<br>

                </div>
            </div>
        </div>
    </div>
</div>