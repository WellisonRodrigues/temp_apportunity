<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 13/03/2017
 * Time: 20:23
 */
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation"">
<div class="col-md-10 col-md-offset-1 col-lg-offset-1 col-lg-10">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="<?php echo base_url(IMAGES); ?>/menu-50px.png"/>
        </button>
        <a class="navbar-brand" href="index.html"><img
                    src="<?php echo base_url(IMAGES); ?>/pessoinha-50px.png"/></a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><i class="fa fa-home"> Feed</i>
                    </button>
                </div>
            </li>
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><i class="fa fa-comment-o"> Mensagens</i>
                    </button>
                </div>
            </li>
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><i class="fa fa-users"> Contatos</i>
                    </button>
                </div>
            </li>
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><i class="fa fa-hand-o-left"> Vagas</i>
                    </button>
                </div>
            </li>
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><i class="fa fa-user"> Contatos</i>
                    </button>
                </div>
            </li>
            <li>
                <div class="btn-group">
                    <button class="btn btn-default dropdown-toggle dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="fa fa-cog"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
</nav>

