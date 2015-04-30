<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('validation_errors_arr')) {
	/**
	 * Validation Error String
	 *
	 * Returns all the errors associated with a form submission. This is a helper
	 * function for the form validation class.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function validation_errors_arr() {
		if (FALSE === ($OBJ =& _get_validation_object())) {
			return '';
		}

		return $OBJ->get_error_arr();
	}
}

if ( ! function_exists('getSelectForm')) {
	/**
	 * Validation Error String
	 *
	 * Returns all the errors associated with a form submission. This is a helper
	 * function for the form validation class.
	 *
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	string
	 */
	function getSelectForm( $item, $name, $select_id = 0 ){

		$data = config_item( 'xo_'.$item );

		$s = '<select class="form-control" name="'.$name.'" >';
		foreach( $data as $id => $v ) {
			$selected = $id == $select_id ? 'selected' : '';
			$s .= '<option value="'.$id.'" '.$selected.'>'.$v.'</option>';
		}

		$s .= '</select>';


		return $s;
	}
}