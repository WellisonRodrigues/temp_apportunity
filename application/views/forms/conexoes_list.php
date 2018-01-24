<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 18/11/2017
 * Time: 14:39
 */

//sou seguido por follower
//print_r($followed_follower);
//echo '<br>';
//print_r($followers);
//print_r($quant_seguidores);
//print_r($quant_seguindo);

?>
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h3><a href="#tab_seguindo" data-toggle="tab"
                                   id="li_seguindo">Seguidores <br> <?php echo @$quant_seguidores ?></a></h3></div>
                        <div class=" col-md-6 text-center">
                            <h3><a href="#tab_seguidores" data-toggle="tab"
                                   id="li_seguidores">Seguindo<br> <?php echo @$quant_seguindo ?></a></h3>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_seguindo">
                            <div class="text-left">
                                <h3>Seguidores</h3>
                            </div>
                            <div class="row">
                                <form class="result_followed">
                                    <?php
                                    //                                    echo form_open('Pesquisar/listar', array('id' => 'formulario', 'method' => 'post', 'role' => 'form'));
                                    foreach ($followers as $key2 => $follow) {
//                                        foreach ($followed as $key3 => $follow_as) {
//                                            if (in_array($follow['id'], $followed)) {
//                                                $key4 = $key3;
//                                            }
                                            $this->fetchuser->setauthtoken($this->session->userdata('verify')['auth_token']);
                                            $this->fetchuser->setiduser($follow['id']);
                                            $this->fetchuser->setuserattributes($follow['id'], $this->fetchuser->getauthtoken());
                                            $image = $this->fetchuser->getuserimage();
                                            $name = $this->fetchuser->getusername();

                                            if ($name) {
                                                $return_name = $name;
                                            } else {

                                                $return_name = 'Not name Not name';
                                            }

                                            if (in_array($follow['id'], $followed_follower)) {
                                                $texto = 'Seguindo';
                                                $class = 'btn btn-primary ' . $follow['id'];
                                            } else {
                                                $texto = 'Seguir';
                                                $class = 'btn btn-default ' . $follow['id'];
                                            }
                                            if (!$image) {
                                                $image_final = 'data:image/png;base64,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';
                                            } else {
                                                $image_final = $image;
                                            }
//                                        print_r($key2);
                                            ?>
                                            <div class="col-md-4">
                                                <div class="jumbotron">
                                                    <div class="text-center">
                                                        <img src="<?php echo $image_final; ?>"
                                                             class="img-circle"
                                                             width="50%"
                                                             height="50%"><br>
                                                        <b> <?php echo $return_name ?><br></b>
                                                        <!--                -->
                                                        <?php //echo $user['attributes']['age'] ?><!-- Anos</b><br>-->
                                                        <button type="button"
                                                                class="<?php echo $class ?> <?php echo $texto . $key2 ?> ">
                                                            <?php echo $texto ?>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $(".<?php echo $texto . $key2 ?>").bind('click', function () {
                                                        var texto = "<?php echo $texto;?>";
                                                        var id = "<?php echo $key2;?>";
                                                        var id_user = "<?php echo $follow['id'];?>";
                                                        $.post('follows_funtion/', {
                                                            iduser: id_user,
                                                            idfollow: id,
                                                            funcao: texto
                                                        }, function () {
                                                            alert('Vaga salva com sucesso');
                                                        });
                                                    });
                                                });
                                            </script>
                                            <?php
                                        }
//                                    }
                                    ?>
                            </div>
                        </div>


                        <div class="tab-pane" id="tab_seguidores">
                            <div class="text-left">
                                <h3>Seguindo</h3>
                            </div>
                            <div class="row">
                                <div class="result_follower">
                                    <?php
                                    foreach ($followed as $key1 => $follow_as) {
                                        $this->fetchuser->setauthtoken($this->session->userdata('verify')['auth_token']);
                                        $this->fetchuser->setiduser($follow_as['id']);
                                        $this->fetchuser->setuserattributes($follow_as['id'], $this->fetchuser->getauthtoken());
                                        $image = $this->fetchuser->getuserimage();
                                        $name = $this->fetchuser->getusername();

                                        if ($name) {
                                            $return_name = $name;
                                        } else {

                                            $return_name = 'Not name Not name';
                                        }

                                        $texto = 'Seguindo';
                                        $class = 'btn btn-primary ' . $follow_as['id'];


                                        if (!$image) {
                                            $image_final = 'data:image/png;base64,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';
                                        } else {
                                            $image_final = $image;
                                        }
                                        ?>
                                        <div class="col-md-4">
                                            <div class="jumbotron">
                                                <div class="text-center">
                                                    <img src="<?php echo $image_final; ?>"
                                                         class="img-circle"
                                                         width="50%"
                                                         height="50%"><br>
                                                    <b> <?php echo $return_name ?><br></b>
                                                    <!--                -->
                                                    <?php //echo $user['attributes']['age'] ?><!-- Anos</b><br>-->
                                                    <button type="button"
                                                            class="<?php echo $class ?> <?php echo $texto . $key1 ?>">
                                                        <?php echo $texto ?>
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function () {
                                                var texto = "<?php echo $texto;?>";
                                                var id = "<?php echo $key1;?>";
                                                $(".<?php echo $texto . $key1 ?>").bind('click', function () {
                                                        alert(texto);
                                                        alert(id);
                                                    }
                                                );
                                            });
                                        </script>
                                        <?php
                                    }

                                    ?>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
