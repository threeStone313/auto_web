<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cases extends MY_Controller {

	public $item_per_page = 10;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'project_model' );
		$this->load->model( 'case_model' );
	}

	




	/**
	 * @param string
	 */
	private function _FormValidation( $mode ) {

		$this->load->library('form_validation');

		switch ( $mode ) {
			case 'create':
				$this->form_validation->set_rules( 'pname', 'Project Name', 'required' );
				break;

			default:
				# code...
				break;
		}

		if ( $this->form_validation->run() == FALSE ) {
			$this->_setNotice( validation_errors_arr() );
			return false;
		} else {
			return true;
		}

	}

	private function _getPagelink( $total ) {
		
		$base_url = site_url();
		list( $c, $a ) = getCurrentRoute();
		$base_url .= $c.'/'.$a;
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total;
		$config['per_page'] = $this->item_per_page;
		return $this->_createPageLink( $config );

	}
}