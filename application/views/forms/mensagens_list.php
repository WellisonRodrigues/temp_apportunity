<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:32
 */


//print_r($this->fetchuser->getauthtoken());
?>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!--<div class="col-md-6 col-md-offset-3 col-sm-offset-1 col-sm-10">-->
<!--    <h1>Mensagens</h1>-->
<!--    <hr>-->
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url(CSS); ?>/chat.css" rel="stylesheet">
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<div class="container-fluid">
    <div class="row">
        <!--            <div class="col-lg-3">-->
        <!--                <div class="btn-panel btn-panel-conversation">-->
        <!--                    <a href="" class="btn  col-lg-6 send-message-btn " role="button"><i class="fa fa-search"></i> Search</a>-->
        <!--                    <a href="" class="btn  col-lg-6  send-message-btn pull-right" role="button"><i class="fa fa-plus"></i> New Message</a>-->
        <!--                </div>-->
        <!--            </div>-->

        <!--            <div class="col-lg-offset-1 col-lg-7">-->
        <!--                <div class="btn-panel btn-panel-msg">-->
        <!---->
        <!--                    <a href="" class="btn  col-lg-3  send-message-btn pull-right" role="button"><i class="fa fa-gears"></i> Settings</a>-->
        <!--                </div>-->
        <!--            </div>-->
    </div>
    <div class="row">

        <div class="conversation-wrap col-lg-3">
            <?php foreach ($return['data'] as $retorno) {
                $idchat = $retorno['id'];
//                print_r($idchat);
//                                print_r($retorno);
            if ($this->session->userdata('logado')['type'] == 'companies') {
//                    if ($retorn['relationships'] == 'user') {
//                        echo 'ok';

                $this->fetchuser->setauthtoken($this->session->userdata('verify')['auth_token']);
                $id = $retorno['relationships']['user']['data']['id'];
                $this->fetchuser->setiduser($id);
                $this->fetchuser->setuserattributes($this->fetchuser->getiduser(), $this->fetchuser->getauthtoken());
                $image = $this->fetchuser->getuserimage();
                $name = $this->fetchuser->getusername();
//                    } else {
//                        $idcompanyname = $retorn['relationships']['company']['data']['id'];
//                        $this->fetchcompany->setidcompany($idcompanyname);
//                        $this->fetchcompany->setcompanyattributes($this->fetchcompany->getidcompany(), $this->fetchcompany->getauthtoken());
//                        $image = $this->fetchcompany->getcompanyimage();
////                    $image = $this->fetchcompany->getuserimage();
//                        $name = $this->fetchcompany->getcompanyname();
//                }

                if (!$image) {
                    $image_final = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAMAAABOo35HAAABX1BMVEXx8PCrq6rs6+usrKy4t7fm5eXr6urq6em6ubnu7ezAwMCrrKvk4+Ourq3t7OyxsbHJyMjw7++trazNzMvOzczo5+fMy8vIx8ezsrLl5OTFxMSsrKu2trbGxcWxsbDp6OfY2Nfn5uXd3NzS0dGwsLC1tbXDwsLCwsLn5ua2trW+vb3T0tK6urrv7+/X19a9vbzPz86zs7Pd3N27u7u0tLTV1dW3t7bZ2Njo5uavr6+/vr7u7e7R0dDW1tW7urnHxsXIxsba2dnh4ODMy8rBwMDCwsHj4uLLysnR0NDAv77g39/W1tbOzs3e3t2wsK/d3NvZ2djEw8OysrHHx8fPzs3j4uHGxcTQ0M/W1dTc29vHxsbi4eHBwL+ysrLf3t7CwcHq6urAv7/BwcHX19fb2trV1NPW1dXm5eS1tbS8vLy8vLu3t7e5uLjv7u7BwcDU09Ovrq7i4ODKycm0s7OqqqmpKDaiAAAFm0lEQVR4XuzKuQ2AMBAAMAa+Lwn7C4mWBSjs2tePAAAAAAAAAAAAAAAAkKt3xZn7NSdq98pP42HnznrTWLYoAK9qwIwmIsYxGGMwtgMBx8HOKCuJI2ee53mOlJcovJj1/3VezuPVVZ/urm3Vrvp+wlK3urWn6HF3zfB/MGvdxxFi02/U/Gv4f5i/zRECAPVJnjHkJ3X4bqN7mjGd7m7AZ7WKYXw0lRp8tTw0/I/McBk+mt3uMIHO7Rm8s7/HhPb24ZdZlyl0Z/DIvUtM5dI9eONyjinlLsMPjRVmYKUBD5QPmImDMtSLSsxIKYJyUZ6Zyf+bVsgqpFUuMVOlMvR6yIw9hForzNwKlLpBC25ApVqOFuRqUGi2TSu2Z9DnkJYcQp2ntOYplJnNac18Bl2WaNESVOnlaFGuB03O0qqzUKRgaJUpQI+7tOwu1LhmaJm5Bi1e07rXUKK8SOsWy9DhNwX8hg4lCihBhR5F9KDBlCKm0OAmRdyEAnVDEaYO912lkKt+tXRCoydPIXk4r1GlkGoDrqtRTM2nzmrot56hmDM+FZRDcfkixVyE67YpZhuu26KYLbhukWIW4ToKCmGFsNIKYYWwDMUYCAhfwxCWg9YpZh2um1PMHK67QjFX4LoditmB635SzE+4bpViVuG6+xRzH657QDEP4LpditmF6x5RzCO4rkgxRThPrn0P9+1RyB7cd4FCLsB9tyjkFty3SSGbcN+AQgZwX0QhERRYD3XS+MYUMYYGxxRxDA1eUMQLaPCDIn5AhRYFtKDDLwr4BR0mFDCBDgUKKECJrTBPamUWPhxY2Q3NivgiQ8tMBDVK4VBBfG9o2RvosUHLNqDIOVp1Dpo0aVUTmmwoeAuV7ODnoct1WnQdukRVWlONoEyF1lSgzT6t2Yc622E1Or7NMOOQ4qak/B3JcBtqBRqNDC0wI6g0pAVD6FSjBTUoVTnRH9LwaNWg1gEzdgC92oaZMm0otho2DOMr5pihXBGqnQlH/uIrn2JmTpWhXJ+Z6UO9C2GxKb5Rh5nojOCBJ8zEE/igkWcG8g14od1hap02PDFlalN44w9T+gN/FJ8xlWdFeOS5YQrmObzSlBnHCiXmCnxTzjOhfBneKbaYSKsIDxXENpr8vWEQwUfLTGQZPvrGRL7BR5thHCu+l0zkJXz0iom8goeOmNAR/LMa2tCxLXSYUG4BvjlkYofwzFvDxMxbeGW2xhTWZvDJO6byDh55z5TewxsfmNoHeGJimJqZwAvH4cZfXNGYGRlHUO7jFjOz9RGa1T8xU5/qUGt3nRlb34VOn3dowc5n6FOo0JJKAbq0h4bWmGEbehx9oWVfjqBCo1+igFK/AdcVm18p5GuzCJcN7hgKMncGcNTCdE5x8+kC3DP4XuWJqH4fwCm9pRZPUGupB0ec748NT5gZ9887ENU/7NdtisIwFIXhwdI6IDQhxaLiBgoO/vCbiijqShQ/UFHw7J9ZxU2Tw32W8HIJJ6ldIQgrmwZ+VKcJAjI5/cV/VHpe5zGCND6HVqpefxGs77oOaX6WHwTtU4YyVdvbBMFLtu0QrsomiEJim76uukgQjaRo9O26GETFXBpL1f9FdH77zaz1ooMIdYoGVv11iEgNr75bzRyi5WZeU70GiNrg5a9Va4PIbVq+WnVviN6t66lVDwR6XmplU1CYZh7e9idIPOVf+SNoHKVbvUHkLdtq6UDELUVj3UHlLtlqBzI7wVgVyFRyrRagsxCLNQKdkVSrFIRSoVglCJVCseYgNJdplYFS1vTI0qm1B6W9SKwDKB1EYj1A6SESy4CSEYnlQMmJxAIpjaWxNJbG0likNJbG0lgaS2NBY+lHWoIFJSsSK69AqMp/ROTWgIyx+X87dEwAAACAMMj+qc2wHyIQAgAAAAAAAAAAAAAAADhs1XdoSSmsIQAAAABJRU5ErkJggg==';
                } else {
                    $image_final = $image;
                }
                echo '<br>';
                ?>
                <!--                    <input type="hidden" value="--><?php //echo $retorno->id?><!--">-->
                <div class="media conversation">
                    <a class="pull-left" href="#">
                        <img class="img-circle" data-src="holder.js/64x64" alt="64x64"
                             style="width: 50px; height: 50px;"
                             src="<?php echo $image_final ?>">
                    </a>
                    <div class="media-body">
                        <h5 class="media-heading  btn <?php echo $idchat ?> btn-default btn-lg"><?php echo $name ?>
                            <small class="fa fa-large fa-paper-plane"></small>
                        </h5>
                    </div>
                </div>
            <?php } else {

                $this->fetchcompany->setauthtoken($this->session->userdata('verify')['auth_token']);
                $id = $retorno['relationships']['company']['data']['id'];
                $this->fetchcompany->setidcompany($id);
                $this->fetchcompany->setcompanyattributes($id, $this->fetchcompany->getauthtoken());
                $image = $this->fetchcompany->getcompanyimage();
                $name = $this->fetchcompany->getcompanyname();

                if (!$image) {
                    $image_final = 'data:image/png;base64,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';
                } else {
                    $image_final = $image;
                }
                echo '<br>';
                ?>
                <div class="media conversation">
                    <a class="pull-left" href="#">
                        <img class="img-circle"
                             style="width: 30px; height: 30px;"
                             src="<?php echo $image_final ?>">
                    </a>
                    <div class="media-body">
                        <!--                            <br>-->
                        <h5 class="media-heading  btn <?php echo $idchat ?> btn-default btn-lg"><?php echo $name ?>
                            <small class="fa fa-large fa-paper-plane"></small>
                            <input type="hidden" id="<?php echo $idchat ?>" value="<?php echo $idchat ?>">
                            <input type="hidden" id="<?php echo $retorno['attributes']['channel-name'] ?>"
                                   value="<?php echo $retorno['attributes']['channel-name'] ?>">
                        </h5>
                        <!--                            <small>Hello</small>-->


                    </div>
                </div>

            <?php
            }
            ?>
                <script>
                    $(document).ready(function () {
                        $('.<?php echo $idchat?>').bind('click', function () {
                            var idchat = $('#<?php echo $idchat?>').val();
                            var chanel = $('#<?php echo $retorno['attributes']['channel-name']?>').val();
                            alert(chanel);
                            $.get("<?php echo base_url('Mensagens/msg_list/')?>" + idchat +'/' + chanel,

                                function (resultado) {
                                    $("#tela_msg").html(resultado);
                                }
                            );
                        });
//                        $('#tela_msg').load("<?php //echo base_url('Mensagens/msg_list/')?>//" + idchat);
                    });
                </script>
                <?php
            } ?>
        </div>
        <div id="tela_msg"></div>
    </div>
</div>
<!--</div>-->


<!--    <div class="clearfix"></div>-->
<!---->
<!--    <script>-->
<!--        $(document).ready(function () {-->
<!--            $('.remover').bind('click', function () {-->
<!--                //$(".fa-heart-o").css("color", "red");-->
<!--                var idanuncio = $(this).attr('href');-->
<!--                $('tr#'+idanuncio).remove();-->
<!--                $.post('Anuncios/deletar', {idanuncio: idanuncio}, function (data) {-->
<!--                }, 'json');-->
<!--                return false;-->
<!--            });-->
<!--            $(".editar2").bind('click',function(){-->
<!--                var id = $(this).data('codigo');-->
<!--                $.post('Anuncios/deletar', {idanuncio: idanuncio}, function (data) {-->
<!---->
<!--                }, 'json');-->
<!--                return false;-->
<!--                $('#myModal').show();-->
<!--            })-->
<!--        });-->
<!--    </script>-->
<!--</div>-->
