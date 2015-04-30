<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->helper( array( 'security' ) );
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {

		if( $cookie = get_cookie('login_info') ) {
			$_SESSION['admin'] = json_decode( $cookie, true );
		}

		if( isset( $_SESSION['admin'] ) ) {
			redirect('/dashboard/index/');
		}

		$assign['notice'] = $this->_getNotice();
		$this->load->view( 'login', $assign );
	}

	public function login() {

		if ( $this->_FormValidation() ) {

			$this->load->model('admin_model');

			$data = $this->input->post();
			if ( $admin = $this->admin_model->checkLoginData( $data ) ) {

				$_SESSION['admin'] = array(
						'id' => $admin['id'],
						'email' => $admin['email'],
						'nickname' => $admin['nickname']
					);

				if( isset( $data['remember'] ) ) {
					set_cookie( 'login_info', json_encode( $_SESSION['admin'] ), 3600*24*7 );
				}

				redirect('/dashboard/index/');

			} else {
				$this->_setNotice( 'Email or Password error!' );
				redirect('/welcome/index/');
			}
			
		} else {
			redirect('/welcome/index/');
		}
	}

	public function logout() {

		unset($_SESSION['admin']);
		delete_cookie( 'login_info' );

		$this->_setNotice( 'Logout successfully!', '^_^', 'success' );
		redirect('/welcome/index/');
	}

	private function _FormValidation() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules( 'email', 'Email', 'required|valid_email' );
		$this->form_validation->set_rules( 'password', 'Password', 'required' );
		if ( $this->form_validation->run() == FALSE ) {
			$this->_setNotice( validation_errors_arr() );
			return false;
		} else {
			return true;
		}
	}
}
