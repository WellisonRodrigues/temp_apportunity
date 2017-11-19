<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="<?php echo base_url(IMAGES); ?>/logos/logo.png"/>

    <title><?php
        if (isset($template_title)) {
            echo $template_title;
        } else {
            echo 'Apportunity';
        }
        ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(VENDOR); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(VENDOR); ?>/bootstrap-social/bootstrap-social.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(VENDOR); ?>/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!--    Vertical tabs -->
    <link href="<?php echo base_url(VENDOR); ?>/bootstrap-vertical-tabs/bootstrap.vertical-tabs.css" rel="stylesheet"
          type="text/css">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(CSS); ?>/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo base_url(CSS); ?>/feed.css" rel="stylesheet">
    <link href="<?php echo base_url(CSS); ?>/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
<!--    <link href="--><?php //echo base_url(VENDOR); ?><!--/font-awesome/css/font-awesome.min.css" rel="stylesheet"-->
<!--          type="text/css">-->
    <!--    Data tables -->
    <link href="<?php echo base_url(VENDOR); ?>/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(VENDOR); ?>/datatables-plugins/buttons.dataTables.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url(VENDOR); ?>/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="<?php echo base_url(VENDOR); ?>/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
/* ISTO AQUI SERVE PARA VERIFICAR SE POSSUI OU NÃO TEMPLATE PADRÃO
 * $DEFAULT_TEMPLATE -> BOOL
 * SE A VARIAVEL NÃO EXISTIR PASSA A SER VERDADEIRO
 * SE ELA VIER FALSA, NÃO IRÁ EXIBIR MENUS E ETC PADRÃO DO ADMIN.
 * */
if (!isset($default_template)) { // CHECA SE VEIO, SE Ñ = TRUE
    $default_template = true;
}
// SE ELA FOR FALSA, CARREGAR SEM MENUS
if (!$default_template) {
    ?>
    <div class="col-md-10 col-md-offset-1">
        <br>
        <!--        --><?php
        // p/ mesma pagina, sem redirect
        if (isset($alert)) {
            div_alerta($alert);
        }
        // p/ redirect
        $v_temp = $this->session->flashdata('alert');
        if (isset($v_temp)) {
            div_alerta($v_temp);
        }
        //        ?>
    </div>
    <?php
    if (isset($view)) {
        $this->load->view($view);
    }
}// FIM DO TEMPLATE SEM MENUS
else { ?>

    <div id="wrapper">
        <!-- Navigation -->
        <?php $this->load->view('template_admin/menu'); ?>
        <!-- Page Content -->
<!--        <div class="container">-->
            <div class="col-md-10 col-xs-11 col-xs-offset-1 col-md-offset-1">
                <br>
                <?php
                // p/ mesma pagina, sem redirect
                if (isset($alert)) {
                    div_alerta($alert);
                }
                $v_temp = $this->session->flashdata('alert');
                if (isset($v_temp)) {
                    div_alerta($v_temp);
                }
                //                ?>
            </div>
<!--            <div class="container-fluid">-->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php
                        if (isset($view)) {
                            $this->load->view($view);
                        }
                        ?>
                    </div>
                </div>
                <!-- /.row -->
<!--            </div>-->
            <!-- /.container-fluid -->
<!--        </div>-->
        <!-- /#page-wrapper -->

    </div>
<?php }  //FIM DO TEMPLATE COM MENUS
?>
<!-- jQuery -->
<script src="<?php echo base_url(VENDOR); ?>/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(VENDOR); ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- Jquery Mask  -->
<script src="<?php echo base_url(JS); ?>/jquery.mask.js"></script>
<script src="<?php echo base_url(JS); ?>/custom.mask.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url(VENDOR); ?>/metisMenu/metisMenu.min.js"></script>
<!-- DataTables JavaScript -->
<script src="<?php echo base_url(VENDOR); ?>/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(VENDOR); ?>/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(VENDOR); ?>/datatables-responsive/dataTables.responsive.js"></script>
<script src="<?php echo base_url(VENDOR); ?>/datatables-plugins/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(VENDOR); ?>/datatables-plugins/jszip.min.js"></script>
<script src="<?php echo base_url(VENDOR); ?>/datatables-plugins/buttons.flash.min.js"></script>
<script src="<?php echo base_url(VENDOR); ?>/datatables-plugins/buttons.html5.min.js"></script>
<script src="<?php echo base_url(VENDOR); ?>/datatables-plugins/buttons.print.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url(JS); ?>/sb-admin-2.js"></script>
<?php
// CUSTOM JS LOAD
$this->load->view('template_admin/custom.js.php');

// CUSTOM JS FROM CONTROLLER
//if (isset($javascript)) {
//    echo "<script> $( document ).ready(function() {";
//    if (is_array($javascript)) {
//        foreach ($javascript as $temp_js) {
//            echo $temp_js;
//        }
//    } else {
//        echo $javascript;
//    }
//    echo "}); </script> ";
//}

?>
</body>

</html>