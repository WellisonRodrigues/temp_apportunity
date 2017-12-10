<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($response);
//print_r($jobs);
//print_r($idiomas);

$image_my = $profile['attributes']['image'];
if ($image_my) {
    $image_final_my = $image_my;
} else {
    $image_final_my = 'data:image/png;base64,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
';
}
?>


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<aside>
    <div class="col-md-3 col-sm-4">

        <div class="panel panel-body">
            <div class="text-center center-block">
                <img src="<?php echo $image_final_my ?>" width="30%" height="30%"
                     class="img-circle">
            </div>
            <div class="text-center">
                <strong><?php echo $profile['attributes']['name'] ?></strong><br>
                <?php echo $profile['attributes']['region'] ?><br>
                <?php echo $inscritos; ?> Inscritos<br></div>
            <div class="text-center">
                <br> <?php echo anchor('Perfil_user/get_profile', 'EDITAR PERFIL', 'type="button" class="btn btn-primary"') ?>
                <hr>
                <div class="text-left">
                    <div class="row">Sobre</strong></div>
                    <p class="text-muted">Email : <?php echo $included[0]['attributes']['email'] ?> <br>
                        Idade : <?php echo $profile['attributes']['age'] ?></p>
                    <hr>
                    Habilitação <br>
                    <p class="text-muted"> Motorista, Empilhadeira</p>
                    <!--                    Vagas em Interesse<br>-->
                    <!--                    <p class="text-muted">-->
                    <?php //echo $profile['attributes']['carrer'] ?><!--</p><br>-->
                    <hr>
                    <?php foreach ($idiomas as $idioma) { ?>
                        Conheçimento do
                        Idioma<p class="text-muted"> <?php echo $idioma['attributes']['name'] ?><br>
                            <?php echo $idioma['attributes']['level'] ?></p><br>

                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</aside>
<div class="col-md-5 col-sm-10">
    <article>
        <?php
        foreach ($ads as $ads_row) {
            $this->fetchcompany->setauthtoken($this->session->userdata('verify')['auth_token']);

            $this->fetchcompany->setidcompany($ads_row['relationships']['company']['data']['id']);
            $this->fetchcompany->setcompanyattributes($this->fetchcompany->getidcompany(), $this->fetchcompany->getauthtoken());
            $name = $this->fetchcompany->getcompanyname();
            $image_ads = $this->fetchcompany->getcompanyimage();
            if ($image_ads) {
                $image_final_ads = $image_ads;
            } else {
                $image_final_ads = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAMAAABOo35HAAABX1BMVEXx8PCrq6rs6+usrKy4t7fm5eXr6urq6em6ubnu7ezAwMCrrKvk4+Ourq3t7OyxsbHJyMjw7++trazNzMvOzczo5+fMy8vIx8ezsrLl5OTFxMSsrKu2trbGxcWxsbDp6OfY2Nfn5uXd3NzS0dGwsLC1tbXDwsLCwsLn5ua2trW+vb3T0tK6urrv7+/X19a9vbzPz86zs7Pd3N27u7u0tLTV1dW3t7bZ2Njo5uavr6+/vr7u7e7R0dDW1tW7urnHxsXIxsba2dnh4ODMy8rBwMDCwsHj4uLLysnR0NDAv77g39/W1tbOzs3e3t2wsK/d3NvZ2djEw8OysrHHx8fPzs3j4uHGxcTQ0M/W1dTc29vHxsbi4eHBwL+ysrLf3t7CwcHq6urAv7/BwcHX19fb2trV1NPW1dXm5eS1tbS8vLy8vLu3t7e5uLjv7u7BwcDU09Ovrq7i4ODKycm0s7OqqqmpKDaiAAAFm0lEQVR4XuzKuQ2AMBAAMAa+Lwn7C4mWBSjs2tePAAAAAAAAAAAAAAAAkKt3xZn7NSdq98pP42HnznrTWLYoAK9qwIwmIsYxGGMwtgMBx8HOKCuJI2ee53mOlJcovJj1/3VezuPVVZ/urm3Vrvp+wlK3urWn6HF3zfB/MGvdxxFi02/U/Gv4f5i/zRECAPVJnjHkJ3X4bqN7mjGd7m7AZ7WKYXw0lRp8tTw0/I/McBk+mt3uMIHO7Rm8s7/HhPb24ZdZlyl0Z/DIvUtM5dI9eONyjinlLsMPjRVmYKUBD5QPmImDMtSLSsxIKYJyUZ6Zyf+bVsgqpFUuMVOlMvR6yIw9hForzNwKlLpBC25ApVqOFuRqUGi2TSu2Z9DnkJYcQp2ntOYplJnNac18Bl2WaNESVOnlaFGuB03O0qqzUKRgaJUpQI+7tOwu1LhmaJm5Bi1e07rXUKK8SOsWy9DhNwX8hg4lCihBhR5F9KDBlCKm0OAmRdyEAnVDEaYO912lkKt+tXRCoydPIXk4r1GlkGoDrqtRTM2nzmrot56hmDM+FZRDcfkixVyE67YpZhuu26KYLbhukWIW4ToKCmGFsNIKYYWwDMUYCAhfwxCWg9YpZh2um1PMHK67QjFX4LoditmB635SzE+4bpViVuG6+xRzH657QDEP4LpditmF6x5RzCO4rkgxRThPrn0P9+1RyB7cd4FCLsB9tyjkFty3SSGbcN+AQgZwX0QhERRYD3XS+MYUMYYGxxRxDA1eUMQLaPCDIn5AhRYFtKDDLwr4BR0mFDCBDgUKKECJrTBPamUWPhxY2Q3NivgiQ8tMBDVK4VBBfG9o2RvosUHLNqDIOVp1Dpo0aVUTmmwoeAuV7ODnoct1WnQdukRVWlONoEyF1lSgzT6t2Yc622E1Or7NMOOQ4qak/B3JcBtqBRqNDC0wI6g0pAVD6FSjBTUoVTnRH9LwaNWg1gEzdgC92oaZMm0otho2DOMr5pihXBGqnQlH/uIrn2JmTpWhXJ+Z6UO9C2GxKb5Rh5nojOCBJ8zEE/igkWcG8g14od1hap02PDFlalN44w9T+gN/FJ8xlWdFeOS5YQrmObzSlBnHCiXmCnxTzjOhfBneKbaYSKsIDxXENpr8vWEQwUfLTGQZPvrGRL7BR5thHCu+l0zkJXz0iom8goeOmNAR/LMa2tCxLXSYUG4BvjlkYofwzFvDxMxbeGW2xhTWZvDJO6byDh55z5TewxsfmNoHeGJimJqZwAvH4cZfXNGYGRlHUO7jFjOz9RGa1T8xU5/qUGt3nRlb34VOn3dowc5n6FOo0JJKAbq0h4bWmGEbehx9oWVfjqBCo1+igFK/AdcVm18p5GuzCJcN7hgKMncGcNTCdE5x8+kC3DP4XuWJqH4fwCm9pRZPUGupB0ec748NT5gZ9887ENU/7NdtisIwFIXhwdI6IDQhxaLiBgoO/vCbiijqShQ/UFHw7J9ZxU2Tw32W8HIJJ6ldIQgrmwZ+VKcJAjI5/cV/VHpe5zGCND6HVqpefxGs77oOaX6WHwTtU4YyVdvbBMFLtu0QrsomiEJim76uukgQjaRo9O26GETFXBpL1f9FdH77zaz1ooMIdYoGVv11iEgNr75bzRyi5WZeU70GiNrg5a9Va4PIbVq+WnVviN6t66lVDwR6XmplU1CYZh7e9idIPOVf+SNoHKVbvUHkLdtq6UDELUVj3UHlLtlqBzI7wVgVyFRyrRagsxCLNQKdkVSrFIRSoVglCJVCseYgNJdplYFS1vTI0qm1B6W9SKwDKB1EYj1A6SESy4CSEYnlQMmJxAIpjaWxNJbG0likNJbG0lgaS2NBY+lHWoIFJSsSK69AqMp/ROTWgIyx+X87dEwAAACAMMj+qc2wHyIQAgAAAAAAAAAAAAAAADhs1XdoSSmsIQAAAABJRU5ErkJggg==
';
            }
            ?>
            <div class="social-feed-box">
                <div class="social-avatar">
                    <a href="" class="pull-left">
                        <img alt="image" src="<?php echo $image_final_ads ?>">
                    </a>
                    <div class="pull-right">
                        <button class="btn btn-primary small salvar_vaga" data-idjob="<?php echo $id_job; ?>">
                            <i class="fa fa-edit <?php echo $id_job; ?>"></i> Salvar

                        </button>
                    </div>
                    <div class="media-body">
                        <a href="<?php echo base_url('Profiles/index/' . $id . '/' . $type) ?>">
                            <?php
                            echo $name;
                            ?>

                        </a>
                        <small class="text-muted"><?php echo date('d \of M', strtotime($ads_row['attributes']['published-at'])) ?>
                        </small>
                    </div>
                </div>
                <div class="social-body">
                    <h4> <?php echo $ads_row['attributes']['title'] ?></h4>
                    <p>
                        <?php echo $ads_row['attributes']['description'] ?>
                        <br>
                    </p>
                    <!--                    <small class="text-muted">Vaga expira-->
                    <!--                        em: --><?php //echo date('d/m/Y H:i:s', strtotime($job['attributes']['exp-date'])) ?>
                    <!--                    </small>-->
                    <?php if ($ads_row['attributes']['image']['url']) { ?>
                        <div class="row box-footer">
                            <div class="col-md-offset-1 col-md-6">
                                <?php echo $ads_row['attributes']['image'] ?>
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        } ?>

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
                $corJob = 'gostei_laranja.png';
            } else {
                $classJob = "curtir";
                $corJob = 'gostei_azul.png';
            }

//            $comentarios = $funcao->get_comments_job($id_job);
            //r_dump($comentarios);
            ///                            print_r($job['relationships']['company']['data']['id']);
            foreach ($includes as $include) {
                if ($include['id'] == $job['relationships']['company']['data']['id']) {
                    $name = $include['attributes']['name'];
                    $image = $include['attributes']['image'];
                    $type = $include['type'];
                    $url = $include['attributes']['img']['url'];
                    $id = $include['id'];
                }
            }
            if ($image) {
                $image_final = $image;
            } else {
                $image_final = 'data:image/png;base64,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
';
            }
            ?>
            <div class="social-feed-box">
                <div class="social-avatar">
                    <a href="" class="pull-left">
                        <img alt="image" src="<?php echo $image_final ?>">
                    </a>
                    <div class="pull-right">
                        <button class="btn btn-primary small salvar_vaga" data-idjob="<?php echo $id_job; ?>">
                            <i class="fa fa-save <?php echo $id_job; ?>"></i> Salvar

                        </button>
                    </div>
                    <div class="media-body">
                        <a href="<?php echo base_url('Profiles/index/' . $id . '/' . $type) ?>">
                            <?php
                            echo $name;
                            ?>

                        </a>
                        <small class="text-muted"><?php echo date('d \of M', strtotime($job['attributes']['published-at'])) ?>
                        </small>
                    </div>
                </div>
                <div class="social-body">
                    <h4> <?php echo $job['attributes']['title'] ?></h4>
                    <p>
                        <?php echo $job['attributes']['description'] ?>
                        <br>
                    </p>
                    <!--                    <small class="text-muted">Vaga expira-->
                    <!--                        em: --><?php //echo date('d/m/Y H:i:s', strtotime($job['attributes']['exp-date'])) ?>
                    <!--                    </small>-->
                    <hr>
                    <div class="row box-footer">
                        <div class="col-md-offset-1 col-md-6">
                            <h4 class="curtir <?php echo $id_job; ?>" data-idjob="<?php echo $id_job; ?>"
                                data-idlike="<?php echo $curtiuJob ?>" data-type="<?php echo $classJob; ?>"
                                data-tipo="<?php echo $job['type']; ?>">
                                <img class="curtir <?php echo $id_job; ?>"
                                     src="<?php echo base_url(IMAGES); ?>/logos/<?php echo $corJob ?>">
                            </h4>
                        </div>
                        <div class="col-md-5">
                            <h4 class="coment" data-idjob="<?php echo $id_job; ?>"
                                data-status="<?php echo $response['status'] ?>"><img
                                        src="<?php echo base_url(IMAGES); ?>/logos/comentar.png">
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
                    var tipo = $(this).data('tipo');

                    if (type == 'curtir') {
//                        $(".fa-heart." + idjob).css("color", "#FF5209");
                        $('.' + idjob).attr("src", "<?php echo base_url(IMAGES); ?>/logos/gostei_laranja.png");
                        $(this).data('type', 'dislike');
                        $.post('Painel_admin/like_job', {idjob: idjob, tipo: tipo}, function (data) {
                            /* if(data.response.data.id){
                             var idlikenew = data.response.data.id;
                             $('.curtir.'+idjob).data('idlike', idlikenew)
                             }*/
                        }, 'json');
                    } else {
                        if (idlike > 0) {
                            $('.' + idjob).attr("src", "<?php echo base_url(IMAGES); ?>/logos/gostei_azul.png");
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


