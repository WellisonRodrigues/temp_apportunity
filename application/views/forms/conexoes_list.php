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
                                   id="li_seguindo">Seguindo <br> <?php echo @$inscritos ?></a></h3></div>
                        <div class=" col-md-6 text-center">
                            <h3><a href="#tab_seguidores" data-toggle="tab"
                                   id="li_seguidores">Seguidores<br> <?php echo @$seguindo ?></a></h3>
                        </div>
                    </div>
                </div>

                <div class="panel panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_seguindo">
                            <div class="text-left">
                                <h3>Seguindo</h3>
                            </div>
                            <div class="row">
                                <?php foreach ($followed as $follow_wed) {
                                    ?>
                                    <script>
                                        $(document).ready(function () {
                                            var iduser = "<?php echo $follow_wed; ?>";
                                            var status = "seguindo";

                                            function list_user() {
                                                $.get("<?php echo base_url('Follows/get_users_list/')?>" + iduser + '/' + status,

                                                    function (result) {
                                                        $("#result_followed" + iduser).html(result);

                                                    }
                                                )
                                            }

                                            //LISTAR
                                            list_user();
                                        });
                                    </script>
                                    <div id="result_followed<?php echo $follow_wed; ?>">

                                    </div>


                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_seguidores">
                            <div class="text-left">
                                <h3>Seguidores</h3>
                            </div>
                            <div class="row">
                                <?php foreach ($followers as $follow_as) {
                                    foreach ($followed as $follow_wed) {
                                        if ($follow_as == $follow_wed) {
                                            $status = 'seguindo';
                                        } else {
                                            $status = 'seguir';
                                        }
                                    }

                                    ?>

                                    <script>
                                        $(document).ready(function () {
                                            var iduser = "<?php echo $follow_as; ?>";
                                            var status = "<?php echo $status; ?>";

                                            function list_user_f() {
                                                $.get("<?php echo base_url('Follows/get_users_list/')?>" + iduser + '/' + status,

                                                    function (result) {
                                                        $("#result_follower" + iduser).html(result);

                                                    }
                                                )
                                            }

                                            //LISTAR
                                            list_user_f();
                                        });
                                    </script>
                                    <div id="result_follower<?php echo $follow_as; ?>">

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