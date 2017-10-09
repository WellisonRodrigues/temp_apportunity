<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div align="center">
                <img src="<?php echo base_url(IMAGES); ?>/logos/logo.png" width="220px" height="100px">
            </div>
            <div class="login-panel panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><strong>Login</strong></h3>
                </div>
                <div class="panel-body">
                    <?php
                    echo form_open('login/entrar', ['role' => 'form']);
                    ?>
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="E-mail" type="email" name="email" autofocus  value="" autocomplete="off"
                                   required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Senha" name="password" type="password" value="" autocomplete="off"
                                   required>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="Remember Me">Lembrar de mim
                            </label>
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        <input type="submit" class="btn btn-lg btn-default btn-block" name="login" value="Acessar Conta">
                    </fieldset>
                    <br>
                    <!--                    --><?php //echo anchor('login/cadastrar',' Cadastrar') ?>
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>