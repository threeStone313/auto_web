<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('setting_model');
	}

	public function index() {
		
		$setting = $this->setting_model->getSetting();
		$assign['setting'] = $setting;
		$this->_LoadMyView( 'setting/setting', $assign );

	}

	public function save_detail() {

		if( $this->_FormValidation( 'detail' ) ) {

			$data = $this->input->post();

			if( $this->setting_model->save( $_SESSION['admin']['id'], $data ) ) {

				$this->_setNotice( 'Success!', '^_^', 'success' );
				redirect('/setting/index/');

			} else {
				$this->_setNotice( 'Fail!' );
				redirect('/setting/index/');
			}

		} else {
			redirect('/setting/index/');
		}

	}

	/**
	 * @param string
	 */
	private function _FormValidation( $mode ) {

		$this->load->library('form_validation');

		switch ( $mode ) {
			case 'detail':
				$this->form_validation->set_rules( 'sqlUrl', 'Datebase Url', 'required' );
				$this->form_validation->set_rules( 'sqlAccount', 'Datebase User', 'required' );
				$this->form_validation->set_rules( 'sqlPassword', 'Datebase Password', 'required' );
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
}