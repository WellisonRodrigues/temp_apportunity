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
        <h3><p class="fa fa-user"> Editar Usuario</p>
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php
            echo form_open('Usuarios/editar/'.$id_usuario, ['role' => 'form']);
            ?>
            <div class="col-lg-12">

                <div class="form-group">
                    <label>Cliente:</label>
                    <?php
                    echo form_input(
                        [
                            'name' => 'cliente',
                            'type' => 'number',
                            'required' => 'required',
                            'class' => 'form-control',
                            'value' => set_value('cliente'),
                            'maxlength' => '70',
                        ]);
                    ?>
                </div>
                <div class="form-group">
                    <label>Manager</label>
                    <?php
                    $dropdown_opcao[''] = '- - - Escolha uma opção - - -';
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
            </div>
            <div class="col-lg-12 " align="right">
                <button type="submit" name="submit" value="salvar_alterar_usuario" class="btn btn-primary btn-lg"><i
                            class="fa fa-save"></i> Salvar
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

