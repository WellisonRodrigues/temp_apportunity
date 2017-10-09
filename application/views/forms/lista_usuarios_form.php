<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 02/04/2017
 * Time: 11:58
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3><p class="fa fa-user"> Lista de Usuarios</p>
                </h3>
            </div>
            <div class="panel-body">
                <?php
                $this->table->set_template(['table_open' => '<table class="table table-striped table-bordered table-hover" id="tb_usuarios">']);
                $this->table->set_heading(' E-mail ', 'Tipo de Ticket', 'Manager', 'Admin', 'Dta.Criação', 'Dta.Atualização', 'Editar', 'Excluir');
                foreach (@$usuarios as $usuario) {
                    $created_at = date('d/m/Y H:i:s', strtotime(@$usuario["created_at"]));
                    $updated_at = date('d/m/Y H:i:s', strtotime(@$usuario["updated_at"]));
                    $this->table->add_row(
                        ['data' => @$usuario["email"]],
                        ['data' => @$usuario["ticket_type"]],
                        ['data' => (@$usuario["is_manager"]) ? "Sim" : "Não" ],
                        ['data' => (@$usuario["is_master"]) ? "Sim" : "Não" ],
                        ['data' => $created_at],
                        ['data' => $updated_at],
                        ['data' => anchor("usuarios/editar/". @$usuario["id"]."", "<p class='fa fa-pencil'></p>", 'class = "btn btn-outline btn-primary btn-xs btn-block"'), 'align' => 'center'],
                        ['data' => anchor("usuarios/excluir/". @$usuario["id"]."", "<p class='fa fa-trash'></p>", array('class' => "btn btn-outline btn-primary btn-xs btn-block", 'onclick' => "return confirm('Deseja realmente excluir ?')" , 'align' => 'center'))]
                    );
                }
                echo $this->table->generate();
                ?>
            </div>
        </div>
    </div>
</div>
