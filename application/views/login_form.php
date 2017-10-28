<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div align="center">
                <img src="<?php echo base_url(IMAGES); ?>/logos/logo.png" width="90px" height="140px">
            </div>

            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills nav-justified">
                                    <li role="presentation" class="active"><a class="tab" href="#tab_login"
                                                                              data-toggle="tab" id="li_login">ENTRAR</a>
                                    </li>
                                    <li role="presentation" class=""><a class="tab" href="#tab_cadastro"
                                                                        data-toggle="tab"
                                                                        id="li_cadastrar">CADASTRAR</a></li>
                                </ul>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_login">
                                <?php
                                echo form_open('login/entrar', ['role' => 'form']);
                                ?>
                                <div class="form-group">
                                    <label for="sel1">Eu sou:</label>
                                    <select class="form-control" id="sel1" name="type_login" onchange="yesnoCheck(this);">
                                        <option id="companies" value="companies">Empresa</option>
                                        <option id="users" value="users">Pessoa Fisica</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" type="email" name="email" autofocus
                                           value="" autocomplete="off"
                                           required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Senha" name="password" type="password"
                                           value=""
                                           autocomplete="off"
                                           required>
                                </div>
                                <div class="text-right">
                                    <?php echo anchor('login/recover_accout', ' Esqueci minha senha') ?>
                                </div>
                                <br/>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-default btn-block" name="login"
                                       value="Entrar">
                                <hr>
                                <div class="text-center">
                                    ou acesse com as redes sociais
                                    <br/>
                                    <br/>
                                    <a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                                    <a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                                    <a class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i></a>

                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="tab-pane" id="tab_cadastro">
                                <?php
                                echo form_open('login/cadastrar', ['role' => 'form']);
                                ?>
                                <div class="form-group">
                                    <label for="sel1">Eu sou:</label>
                                    <select class="form-control" id="sel1" name="type" onchange="yesnoCheck(this);">
                                        <option id="companies" value="companies">Empresa</option>
                                        <option id="users" value="users">Pessoa Fisica</option>
                                    </select>
                                </div>
                                <div id="ifYes" style="display: block;">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Nome" type="text" name="nome"
                                               autofocus
                                               autocomplete="off"
                                        >
                                    </div>
                                </div>
                                <script>
                                    function yesnoCheck(that) {
                                        if (that.value == "companies") {

                                            document.getElementById("ifYes").style.display = "block";
                                        } else {
                                            document.getElementById("ifYes").style.display = "none";
                                        }
                                    }
                                </script>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" type="email" name="email"
                                           autofocus
                                           value="" autocomplete="off"
                                           required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Senha" name="password" type="password"
                                           value=""
                                           autocomplete="off"
                                           required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Repita sua Senha"
                                           name="password_confirmation"
                                           type="password"
                                           value=""
                                           autocomplete="off"
                                           required>
                                </div>
                                <input type="submit" class="btn btn-lg btn-primary btn-block" name="cadastrar"
                                       value="cadastrar">
                                <br/>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </fieldset>
                    <!--                    --><?php //echo anchor('login/cadastrar', ' Cadastrar') ?>
                </div>
            </div>
        </div>
    </div>
</div>