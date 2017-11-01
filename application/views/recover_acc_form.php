<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 30/10/2017
 * Time: 23:48
 */

?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <b>Digite seu e-mail para recuperar sua senha</b>
                </div>
                <div class="panel-body">
                    <?php
                    echo form_open('Login/recover_accout', ['role' => 'form']);
                    ?>
                    <div class="form-group">
                        <input class="form-control" placeholder="E-mail" type="email" name="email" autofocus="" value=""
                               autocomplete="off" required="">
                    </div>
                    <div class="form-group">
                        <label for="sel1">Eu sou:</label>
                        <select class="form-control" id="sel1" name="type">
                            <option id="companies" value="companies">Empresa</option>
                            <option id="users" value="users">Pessoa Fisica</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" name="reset_password"
                               value="Resetar">
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

