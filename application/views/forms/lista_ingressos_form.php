<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 02/04/2017
 * Time: 11:58
 */
//print_r_c($usuarios);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3><p class="fa fa-ticket"> Lista de Ingressos</p>
                </h3>
            </div>
            <div class="panel-body">
                <!---->
                <!--                :id, :ticket_code, :ticket_type, :ticket_client, :-->
                <!--                ticket_event_id, :ticket_validation, :created_at,-->
                <!--                :updated_at-->

                <?php

                $this->table->set_template(['table_open' => '<table class="table table-striped table-bordered table-hover" id="tb_tickets">']);

                $this->table->set_heading('Cod.Ticket', 'Tipo', 'Cliente ',' Validação ', 'ID.Evento', 'Dta.Criação', 'Dta.Atualização');

                foreach (@$tickets as $ticket) {
                    $created_at = date('d/m/Y H:i:s', strtotime(@$ticket["created_at"]));
                    $updated_at = date('d/m/Y H:i:s', strtotime(@$ticket["updated_at"]));
                    $this->table->add_row(
                        ['data' => @$ticket["ticket_code"]],
                        ['data' => @$ticket["ticket_type"]],
                        ['data' => @$ticket["ticket_client"]],
                        ['data' => @$ticket["ticket_event_id"]],
                        ['data' => @$ticket["ticket_validation"]],
                        ['data' => $created_at],
                        ['data' => $updated_at]
                    //['data' => anchor("usuarios/editar/". @$usuario["id"]."", "<p class='fa fa-pencil'></p>", 'class = "btn btn-outline btn-primary btn-xs btn-block"'), 'align' => 'center'],
                    // ['data' => anchor("usuarios/excluir/". @$usuario["id"]."", "<p class='fa fa-trash'></p>", array('class' => "btn btn-outline btn-primary btn-xs btn-block", 'onclick' => "return confirm('Deseja realmente excluir ?')" , 'align' => 'center'))]
                    );
                }
                echo $this->table->generate();
                ?>
            </div>
        </div>
    </div>
</div>
