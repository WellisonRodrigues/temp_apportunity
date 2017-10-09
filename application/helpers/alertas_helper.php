<?php
/**
 * @file Global Helper Functions
 * Stefan
 */

if ( ! function_exists( 'div_alerta' ) ) {
	/*
	 $vetor = [
				'dismissable' => false,
				'type'        => 'success',
				'class'       => '',
				'message'     => $vetor,
			];
	 */
	function div_alerta( $vetor ) {
		if ( ! is_array( $vetor ) ) {
			$vetor = [
				'dismissable' => true,
				'type'        => 'success',
				'class'       => '',
				'message'     => $vetor,
			];
		} else {
			// verifica os indices
			if ( ! isset( $vetor['type'] ) ) {
				$vetor['type'] = 'success';
			}
			if ( ! isset( $vetor['class'] ) ) {
				$vetor['class'] = '';
			}
			if ( ! isset( $vetor['dismissable'] ) ) {
				$vetor['dismissable'] = true;
			}
			if ( ! isset( $vetor['message'] ) ) {
				return false;
			}
		}
		// testa o type (tipo)
		switch ( strtolower($vetor['type']) ) {
			case 'success':
			case 'sucess':
			case 'sucesso':
			default:
				$vetor['class'] .= 'alert alert-success';
				break;
			case 'info':
			case 'informacao':
			case 'informação':
				$vetor['class'] .= 'alert alert-info';
				break;
			case 'erro':
			case 'error':
			case 'danger':
				$vetor['class'] .= 'alert  alert-danger';
				break;
			case 'aviso':
			case 'warning':
				$vetor['class'] .= 'alert alert-warning';
				break;
		}
		// testa dismissable (se pode fechar ou não)
		if ( $vetor['dismissable'] === true ) {
			$vetor['class'] .= ' alert-dismissable ';
			$vetor['message'] = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
			                    . $vetor['message'];
		}
		// mensagem

		echo '<div class="' . $vetor['class'] . '">' . $vetor['message'] . '</div>';
	}
}
