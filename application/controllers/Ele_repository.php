<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ele_repository extends MY_Controller {

	public $item_per_page = 10;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'ele_rep_model' );
	}

	public function index( $curpage=1 ) {

		$curpage = max( (int)$curpage, 1 );

		$search = $this->input->get('s');
		$total = $this->ele_rep_model->getTotal( $search );


		$assign['search'] = $search;
		$assign['pagelinks'] = $this->_getPagelink( $total );
		$assign['locator'] = config_item( 'xo_step_locator' );
		$assign['datas'] = $this->ele_rep_model->getList( $curpage , $this->item_per_page, $search );
		$this->_LoadMyView( 'ele_rep/list', $assign );
	}

	public function add() {


		$this->_LoadMyView( 'ele_rep/add' );
	}

	public function create() {

		if( $this->_FormValidation( 'create' ) ) {

			$data = $this->input->post();

			$status = $this->ele_rep_model->create( $data );

			switch ( $status ) {

				case 'exists':
					$this->_setNotice( 'Alias already exists!' );
					redirect('/ele_repository/add/');
					break;
				case 'success':
					$this->_setNotice( 'Success!', '^_^', 'success' );
					redirect('/ele_repository/index/');
					break;
				case 'fail':
					$this->_setNotice( 'Fail!' );
					redirect('/ele_repository/add/');
					break;

				default:
					redirect('/ele_repository/index/');
					break;
			}

		} else {
			redirect('/ele_repository/add/');
		}
	}

	public function edit( $eid ) {

		$eid = intval($eid);
		if( $assign['data'] = $this->ele_rep_model->getOne( $eid ) ){
			$this->_LoadMyView( 'ele_rep/edit', $assign );
		} else {
			show_error( 'Element Not Found!' );
		}
		
	}

	public function update( $eid ) {

		$eid = intval( $eid );
		if( $this->_FormValidation( 'create' ) ) {

			$data = $this->input->post();
			$status = $this->ele_rep_model->update( $data, $eid );

			switch ( $status ) {

				case 'exists':
					$this->_setNotice( 'Alias already exists!' );
					redirect('/ele_repository/edit/'.$eid);
					break;
				case 'success':
					$this->_setNotice( 'Success!', '^_^', 'success' );
					redirect('/ele_repository/index/');
					break;
				case 'fail':
					$this->_setNotice( 'Fail!' );
					redirect('/ele_repository/edit/'.$eid);
					break;

				default:
					redirect('/ele_repository/index/');
					break;
			}

		} else {
			redirect('/ele_repository/edit/'.$eid);
		}

	}

	public function delete(	$eid ) {

		$eid = intval($eid);
		if( $this->ele_rep_model->delete( $eid ) ) {

			$this->_setNotice( 'Success!', '^_^', 'success' );
			redirect('/ele_repository/index/');

		} else {
			redirect('/ele_repository/index/');
		}

	}

	public function ajax_autocomplete(){

		if( $this->input->is_ajax_request() ) {
			$s = $this->input->get('q');
			$limit = $this->input->get('limit');
			$data = $this->ele_rep_model->getAll( $limit, $s );
			foreach ($data as $key=>$value) {
				echo "$key|$value\n";
			}
		}die;
	}

	/**
	 * @param string
	 */
	private function _FormValidation( $mode ) {

		$this->load->library('form_validation');

		switch ( $mode ) {
			case 'create':
				$this->form_validation->set_rules( 'alias', 'Alias', 'required' );
				$this->form_validation->set_rules( 'element', 'Element', 'required' );
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