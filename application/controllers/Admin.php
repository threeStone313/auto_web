<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('admin_model');
	}


	public function sign_in() {

		$data = $this->input->post();

		if( !empty( $data ) ) {

			if( $this->_FormValidation( 'sign_in' ) ) {

				$data = $this->input->post();

				if( $aid = $this->admin_model->sign_in( $data ) ) {
					$this->_setNotice( 'Sign in successfully!', '^_^', 'success' );
					redirect('/welcome/index/');

				} else {
					$this->_setNotice( 'Email alread existed!' );
					redirect('/admin/sign_in/');
				}

			} else {
				redirect('/admin/sign_in/');
			}

		} else {

			$assign['notice'] = $this->_getNotice();
			$this->load->view( 'sign_in', $assign );
		}

	}


	public function change_password() {

		if( $this->_FormValidation( 'password' ) ) {

			$data = $this->input->post();

			if( $this->admin_model->changePassword( $_SESSION['admin']['id'], $data ) ) {

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


	private function _FormValidation( $mode ) {
		$this->load->library('form_validation');
		switch ( $mode ) {
			case 'password':
				$this->form_validation->set_rules( 'password', 'Password', 'required|min_length[6]' );
				$this->form_validation->set_rules( 'passwordconf', 'Password Confirm', 'required|matches[password]' );
				break;
			case 'sign_in':
				$this->form_validation->set_rules( 'email', 'Email', 'required|valid_email' );
				$this->form_validation->set_rules( 'nickname', 'Name', 'required|min_length[4]' );
				$this->form_validation->set_rules( 'password', 'Password', 'required|min_length[6]' );
				$this->form_validation->set_rules( 'passwordconf', 'Password Confirm', 'required|matches[password]' );
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