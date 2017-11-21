<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 21/11/2017
 * Time: 00:01
 */

?>

    <div class="col-md-8 col-md-offset-2 col-sm-offset-1 col-sm-10">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <select class="form-control" id="sel1" name="type" onchange="yesnoCheck(this);">
                        <option id="companies" value="companies">Empresa</option>
                        <option id="users" value="users">Estabelecimento</option>
                        <option id="users" value="users">Pessoa Fisica</option>
                    </select>
                </div>
                </div>
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text"class="form-control" placeholder="Região">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                  </span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div>
</div>
