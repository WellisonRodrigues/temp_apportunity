<?php
defined('BASEPATH') OR exit('No direct script access allowed');
print_r($response);
//print_r($jobs);

?>


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">
    <article>
        <?php
        //        print_r($jobs->data);
        foreach ($jobs as $job) {
            ///                            print_r($job['relationships']['company']['data']['id']);
            foreach ($includes as $include) {
                if ($include['id'] == $job['relationships']['company']['data']['id']) {
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
                    <h4> <?php echo $job['attributes']['title'] ?></h4>
                    <p>
                        <?php echo $job['attributes']['description'] ?>
                        <br>
                    </p>
                    <div class="media">
                        <img class="img-responsive" src="<?php echo base_url(IMAGES); ?>/banner.jpg">
                    </div>
                    <!--            <div class="btn-group">-->
                    <div class="row">

                        <div class="col-md-offset-1 col-md-6">
                            <h4><i class="fa fa-heart-o"></i> Gostei desta publicação</h4>
                        </div>
                        <div class="col-md-5">
                            <h4><i class="fa fa-comment-o" id="coment"></i> Comentar</h4>
                            <!--                    <button class="btn btn-white btn-xs"><i class="fa fa-share"></i></button>-->
                        </div>
                        <!--                </div>-->
                    </div>
                </div>
                <div class="social-footer content">
                    <div class="social-comment">
                        <a href="" class="pull-left">
                            <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a1.jpg">
                        </a>
                        <div class="media-body">
                            <a href="#">
                                Andrew Williams
                            </a>
                            Internet tend to repeat predefined chunks as necessary, making this the first true
                            generator
                            on
                            the Internet. It uses a dictionary of over 200 Latin words.
                            <br>
                            <a href="#" class="small"><i class="fa fa-thumbs-up"></i> 26 Like this!</a> -
                            <small class="text-muted">12.06.2014</small>
                        </div>
                    </div>

                    <div class="social-comment">
                        <a href="" class="pull-left">
                            <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a2.jpg">
                        </a>
                        <div class="media-body">
                            <a href="#">
                                Andrew Williams
                            </a>
                            Making this the first true generator on the Internet. It uses a dictionary of.
                            <br>
                            <a href="#" class="small"><i class="fa fa-thumbs-up"></i> 11 Like this!</a> -
                            <small class="text-muted">10.07.2014</small>
                        </div>
                    </div>

                    <div class="social-comment">
                        <a href="" class="pull-left">
                            <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a3.jpg">
                        </a>
                        <div class="media-body">
                            <textarea class="form-control" placeholder="Write comment..."></textarea>
                        </div>
                    </div>

                </div>

            </div>


            <?php
        } ?>

        <script>
            $(document).ready(function () {
                $('.content').hide();
            });
        </script>
    </article>
</div>

<!--</div>-->

<aside>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel panel-heading">
                <div class="text-center center-block">
                    <img src="<?php echo base_url(IMAGES); ?>/profile.jpg" width="30%" height="30%"
                         class="img-circle">
                </div>
            </div>
            <div class="panel panel-body">
                <div class="text-center">
                    <strong>Paulo Henrique</strong><br>
                    Tokyo, Japan<br>
                    36 Inscritos
                    <hr>

                    <?php echo anchor('Perfil_user/get_profile', 'Editar Perfil', 'type="button" class="btn btn-primary"') ?>
                    <br>
                    <hr>
                    <div class="text-center">
                        <div class="row"><strong>Sobre</strong></div>
                        Email : welllison.244@gmail.com <br>
                        Idade : 26 anos <br>
                        Habilitação : AD <br>
                        Vagas em Interesse : ......<br>
                        <hr>
                        <div class="row"><strong>Conheçimento do Idioma Japones</strong></div>
                        Fala : 90%<br>
                        Escrita : 70%<br>
                        Entende : 100%<br>

                    </div>
                </div>
            </div>
        </div>

    </div>
</aside>
</div>
