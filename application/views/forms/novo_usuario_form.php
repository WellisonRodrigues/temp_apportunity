<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 03/10/2017
 * Time: 21:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3><p class="fa fa-user"> Novo Usuario</p>
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php
            echo form_open('Usuarios/novo', ['role' => 'form']);
            ?>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Email</label>
                    <?php
                    echo form_input(
                        [
                            'name' => 'email',
                            'required' => 'required',
                            'class' => 'form-control',
                            'type' => 'email',
                            'value' => set_value('email'),
                            'maxlength' => '70',
                        ]);
                    ?>
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <?php
                    echo form_input(
                        [
                            'name' => 'password',
                            'required' => 'required',
                            'type' => 'password',
                            'class' => 'form-control',
                            'value' => set_value('password'),
                            'maxlength' => '70',
                            'minlength' => '4',
                        ]);
                    ?>
                </div>
                <div class="form-group">
                    <label>Cliente:</label>
                    <?php
                    echo form_input(
                        [
                            'name' => 'client',
                            'required' => 'required',
                            'type' => 'number',
                            'class' => 'form-control',
                            'value' => set_value('client'),
                            'maxlength' => '70',
                        ]);
                    ?>
                </div>
                <div class="form-group">
                    <label>Manager</label>
                    <?php
                    $dropdown_opcao['0'] = 'Não';
                    $dropdown_opcao['1'] = 'Sim';
                    echo form_dropdown(
                        'is_manager',
                        @$dropdown_opcao,
                        set_value('is_manager'),
                        'class="form-control"'
                    );
                    ?>
                </div>
                <div class="form-group">
                    <label>Admin</label>
                    <?php
                    echo form_dropdown(
                        'is_master',
                        @$dropdown_opcao,
                        set_value('is_master'),
                        'class="form-control"'
                    );
                    ?>
                </div>
            </div>
            <div class="col-lg-12 " align="right">
                <button type="submit" name="submit" value="salvar_novo_usuario" class="btn btn-primary btn-lg"><i
                            class="fa fa-save"></i> Salvar
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

