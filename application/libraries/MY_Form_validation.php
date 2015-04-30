<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	public function __construct($config = array()){
		parent::__construct( $config );
	}

	/**
	 * @return array
	 */
	public function get_error_arr() {
		return $this->_error_array;
	}
}