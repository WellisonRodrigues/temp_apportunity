<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 13/03/2017
 * Time: 20:23
 */
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 1px">
    <div class="navbar-header">
        <a class="navbar-left" href="<?php echo base_url(); ?>painel_admin">&nbsp;&nbsp;&nbsp;&nbsp; <img src="<?php echo base_url(IMAGES); ?>/logos/logohome.png" width="100px"></a>
    </div>
    <div class="nav navbar-top-links navbar-right">
        <!-- /.navbar-top-links -->
        <?php $this->load->view('template_admin/menus/menu_superior'); ?>
    </div>
       <div class="navbar-default sidebar">
        <?php $this->load->view('template_admin/menus/menu_lateral'); ?>
    </div>
    <!-- /.navbar-static-side -->
</nav>
