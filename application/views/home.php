<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($response);
//print_r($jobs);
//print_r($idiomas);

?>


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">
    <article>
        <?php
        //        $cont = 0;
        //        print_r($jobs->data);
        foreach ($jobs as $job) {
            $cont++;
            $id_job = $job["id"];
            //$this->CI->like_list_job($id_job);
            $curtiuJob = $funcao->like_list_job($id_job);
            if ($curtiuJob != 0) {
                $classJob = "dislike";
                $corJob = "red";
            } else {
                $classJob = "curtir";
                $corJob = "black";
            }

//            $comentarios = $funcao->get_comments_job($id_job);
            //r_dump($comentarios);
            ///                            print_r($job['relationships']['company']['data']['id']);
            foreach ($includes as $include) {
                if ($include['id'] == $job['relationships']['company']['data']['id']) {
                    $name = $include['attributes']['name'];
                    $type = $include['type'];
                    $url = $include['attributes']['img']['url'];
                    $id = $include['id'];
                }
            }
            ?>
            <div class="social-feed-box">
                <div class="social-avatar">
                    <a href="" class="pull-left">
                        <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a1.jpg">
                    </a>
                    <div class="pull-right">
                        <h6 class="salvar_vaga" data-idjob="<?php echo $id_job; ?>"><b> Salvar Vaga
                                <i class="fa fa-edit <?php echo $id_job; ?>"></i></b>
                        </h6>
                    </div>
                    <div class="media-body">
                        <a href="<?php echo base_url('Profiles/index/'.$id.'/'.$type) ?>">
                            <?php
                            echo $name;
                            ?>

                        </a>
                        <small class="text-muted">Data
                            Publicação: <?php echo date('d/m/Y H:i:s', strtotime($job['attributes']['published-at'])) ?>
                        </small>
                    </div>
                </div>
                <div class="social-body">
                    <h4> <?php echo $job['attributes']['title'] ?></h4>
                    <p>
                        <?php echo $job['attributes']['description'] ?>
                        <br>
                    </p>
                    <small class="text-muted">Vaga expira
                        em: <?php echo date('d/m/Y H:i:s', strtotime($job['attributes']['exp-date'])) ?>
                    </small>
                    <div class="media">
                        <!--                        <img class="img-responsive" src="-->
                        <?php //echo base_url(IMAGES); ?><!--/banner.jpg">-->
                    </div>
                    <!--            <div class="btn-group">-->
                    <hr>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-6">
                            <h4 class="curtir <?php echo $id_job; ?>" data-idjob="<?php echo $id_job; ?>"
                                data-idlike="<?php echo $curtiuJob ?>" data-type="<?php echo $classJob; ?>">
                                <i class="fa fa-heart <?php echo $id_job; ?>"
                                   style="color:<?php echo $corJob; ?>"></i> Gostei desta publicação
                            </h4>
                        </div>
                        <div class="col-md-5">
                            <h4 class="coment" data-idjob="<?php echo $id_job; ?>"
                                data-status="<?php echo $response['status'] ?>"><i class="fa fa-comment-o"></i> Comentar
                            </h4>
                            <!--                    <button class="btn btn-white btn-xs"><i class="fa fa-share"></i></button>-->
                        </div>
                        <!--                </div>-->
                    </div>
                </div>
                <div class="social-footer content <?php echo $id_job; ?>">
                    <div id="resultado<?php echo $id_job; ?>">
                    </div>

                    <div class="social-comment">
                        <a href="" class="pull-left">
                            <img alt="image" src="http://webapplayers.com/inspinia_admin-v2.5/img/a3.jpg">
                        </a>
                        <div class="media-body">
                            <textarea class="form-control comentario_<?php echo $id_job; ?>" name="insertComments"
                                      placeholder="Write comment..."></textarea>
                            <input type="button" class="comentar" data-idjob="<?php echo $id_job; ?>" value="Comentar"/>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } ?>

        <script>
            $(document).ready(function () {


                $('.curtir').bind('click', function () {
                    //$(".fa-heart-o").css("color", "red");
                    var idjob = $(this).data('idjob');
                    var idlike = $(this).data('idlike');
                    var type = $(this).data('type');

                    if (type == 'curtir') {
                        $(".fa-heart." + idjob).css("color", "red");
                        $(this).data('type', 'dislike');
                        $.post('Painel_admin/like_job', {idjob: idjob}, function (data) {
                            /* if(data.response.data.id){
                             var idlikenew = data.response.data.id;
                             $('.curtir.'+idjob).data('idlike', idlikenew)
                             }*/
                        }, 'json');
                    } else {
                        if (idlike > 0) {
                            $(".fa-heart." + idjob).css("color", "black");
                            $(this).data('type', 'curtir');
                            $(this).data('idlike', '0');
                            $.post('Painel_admin/dislike_job', {idjob: idjob, idlike: idlike}, function (data) {

                            });
                        }
                    }
                });

                $('.coment').click(function () {
                    var idjob = $(this).data('idjob');
                    var status = $(this).data('status');
                    if (status == 'premium') {
                        function modifica_trabalho() {
                            $.get("<?php echo base_url('Painel_admin/get_comments_job/')?>" + idjob,

                                function (resultado) {
                                    $("#resultado" + idjob).html(resultado);
                                }
                            );
                        }

                        //LISTAR
                        modifica_trabalho();
                        $('.content.' + idjob).toggle("slow");
//                        var idjob = $(this).data('idjob');


                        //$('.content.'+ idjob).empty();
                        /*$.post('Painel_admin/get_comments_job/' + idjob, function (data) {
                         $('.content.' + idjob).append("<div class='social-comment'>").append(data).append('</div>');
                         });*/
                    } else {
                        alert('Para comentar e visulizar os comentários é necessário ser usuário premium.');
                    }
                });

                $('.comentar').on('click', function () {
                    var idjob = $(this).data('idjob');
                    var texto = $('.comentario_' + idjob).val();
                    if (texto != "" && texto != " ") {
                        $.post('Painel_admin/insert_comments_job/', {idjob: idjob, texto: texto}, function (data) {
//                            var idjob = $(this).data('idjob');
                            function modifica_trabalho() {
                                $.get("<?php echo base_url('Painel_admin/get_comments_job/')?>" + idjob,

                                    function (resultado) {
                                        $("#resultado" + idjob).html(resultado);
                                    }
                                );
                            }

                            //LISTAR
                            modifica_trabalho();
                        });
                    }
                });

                $('.salvar_vaga').bind('click', function () {
                    var idjob = $(this).data('idjob');
                    $.post('Vagas/save_vagas/', {idjob: idjob}, function (data) {
                        alert('Vaga salva com sucesso');
                    });

                });


                $('.content').hide();
            })
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
                    <strong><?php echo $profile['attributes']['name'] ?></strong><br>
                    <?php echo $profile['attributes']['region'] ?><br>
                    <?php echo $inscritos; ?> Inscritos
                    <hr>

                    <?php echo anchor('Perfil_user/get_profile', 'Editar Perfil', 'type="button" class="btn btn-primary"') ?>
                    <br>
                    <hr>
                    <div class="text-center">
                        <div class="row"><strong>Sobre</strong></div>
                        Email : <?php echo $included[0]['attributes']['email'] ?> <br>
                        Idade : <?php echo $profile['attributes']['age'] ?> <br>
                        Habilitação : AD <br>
                        Vagas em Interesse : <?php echo $profile['attributes']['carrer'] ?><br>
                        <hr>
                        <?php foreach ($idiomas as $idioma) { ?>
                            <div class="row"><strong>Conheçimento do
                                    Idioma <?php echo $idioma['attributes']['name'] ?></strong></div>
                            Level : <?php echo $idioma['attributes']['level'] ?><br>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</aside>
