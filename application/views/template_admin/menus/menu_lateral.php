<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 13/03/2017
 * Time: 20:26
 */ ?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <?php echo anchor('usuarios', '<i class="fa fa-user "></i> Usuarios<span class="fa arrow"></span>'); ?>
                <ul class="nav nav-second-level">
                    <li>
                        <?php echo anchor('usuarios/novo', '<i class="fa fa-plus "></i> Novo Usuario '); ?>
                    </li>
                    <li>
                        <?php echo anchor('usuarios/lista', '<i class="fa fa-list "></i> Lista de Usuarios'); ?>
                    </li>

                </ul>
            </li>

            <li>
                <?php echo anchor('tickets', '<i class="fa fa-ticket"></i> Ingressos <span class="fa arrow"></span>'); ?>

                <ul class="nav nav-second-level">
<!--                    <li>-->
<!--                        --><?php //echo anchor('tickets/novo', '<i class="fa fa-plus "></i> Novo Ticket '); ?>
<!--                    </li>-->
                    <li>
                        <?php echo anchor('tickets/lista', '<i class="fa fa-list "></i> Lista de Ingressos'); ?>
                    </li>

                </ul>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>