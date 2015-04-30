<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pack extends MY_Controller {

	public $item_per_page = 10;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'pack_model' );
		$this->load->model( 'pack_step_model' );
	}

	public function index( $curpage = 1 ) {

		$curpage = max( (int)$curpage, 1 );

		$search = $this->input->get('s');
		$total = $this->pack_model->getTotal( $search );

		$assign['search'] = $search;
		$assign['pagelinks'] = $this->_getPagelink( $total );
		$assign['datas'] = $this->pack_model->getList( $curpage , $this->item_per_page, $search );
		$this->_LoadMyView( 'pack/list', $assign );
	}


	public function add() {
		$this->_LoadMyView( 'pack/add' );
	}

	public function create() {

		if( $this->_FormValidation( 'create' ) ) {

			$data = $this->input->post();

			$status = $this->pack_model->create( $data );

			switch ( $status ) {

				case 'exists':
					$this->_setNotice( 'Pack already exists!' );
					redirect('/pack/add/');
					break;
				case 'success':
					$this->_setNotice( 'Success!', '^_^', 'success' );
					redirect('/pack/index/');
					break;
				case 'fail':
					$this->_setNotice( 'Fail!' );
					redirect('/pack/add/');
					break;

				default:
					redirect('/pack/index/');
					break;
			}

		} else {
			redirect('/pack/add/');
		}

	}

	public function edit( $id ) {

		$id = intval($id);
		if( $assign['data'] = $this->pack_model->getOne( $id ) ){
			$this->_LoadMyView( 'pack/edit', $assign );
		} else {
			show_error( 'Element Not Found!' );
		}

	}

	public function update( $id ) {

		$id = intval( $id );
		if( $this->_FormValidation( 'create' ) ) {

			$data = $this->input->post();
			$status = $this->pack_model->update( $data, $id );

			switch ( $status ) {

				case 'exists':
					$this->_setNotice( 'Pack already exists!' );
					redirect('/pack/edit/'.$id);
					break;
				case 'success':
					$this->_setNotice( 'Success!', '^_^', 'success' );
					redirect('/pack/index/');
					break;
				case 'fail':
					$this->_setNotice( 'Fail!' );
					redirect('/pack/edit/'.$id);
					break;

				default:
					redirect('/pack/index/');
					break;
			}

		} else {
			redirect('/pack/edit/'.$id);
		}

	}

	public function delete(	$id ) {

		$eid = intval($eid);
		if( $this->pack_model->delete( $id ) ) {

			$this->_setNotice( 'Success!', '^_^', 'success' );
			redirect('/pack/index/');

		} else {
			redirect('/pack/index/');
		}

	}


	public function step_list( $pack_id ) {

		$pack_id = intval( $pack_id );
		if ( $data = $this->pack_model->getOne( $pack_id ) ) {
			$_SESSION['pack_id'] = $pack_id;
			$assign['pack_name'] = $data['name'];
			$assign['datas'] = $this->pack_step_model->getStepList( $pack_id );
			$this->_LoadMyView( 'pack/step_list', $assign );

		} else {
			show_error('Pack Not Found!');
		}

	}

	public function step_save( $pack_id ) {

		$pack_id = intval( $pack_id ); 
		$data = $this->input->post();
		if( $this->pack_step_model->save( $data, $pack_id ) ) {
			$this->_setNotice( 'Success!', '^_^', 'success' );
			redirect( '/pack/step_list/'.$_SESSION['pack_id'] );
		}

	}

	public function ajax_search(){

		$post = $this->input->post();
		$data = $this->pack_model->ajaxSearch( $post['name'] );
		foreach( $data as $k=>$v) {
			$data[$k]['name'] = htmlspecialchars( $v['name'] );
		}

		echo json_encode( $data );
		die;
	}

	public function ajax_pack_auto() {

		if( $this->input->is_ajax_request() ) {

			$s = $this->input->get('q');
			$limit = $this->input->get('limit');
			$data = $this->pack_model->getAjaxPackContent( $limit, $s );
			foreach ($data as $key=>$value) {
				echo "$key|$value\n";
			}
		}
		die;

	}

	/**
	 * @param string
	 */
	private function _FormValidation( $mode ) {

		$this->load->library('form_validation');

		switch ( $mode ) {
			case 'create':
				$this->form_validation->set_rules( 'name', 'Pack Name', 'required' );
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

	private function _getPagelink( $total, $id = 0,$uri_segment = 3 ) {
		
		$base_url = site_url();
		list( $c, $a ) = getCurrentRoute();
		$base_url .= $c .'/'. $a . ( $id ? '/' . $id : '' );
		$config['base_url'] = $base_url;
		$config['uri_segment'] = $uri_segment;
		$config['total_rows'] = $total;
		$config['per_page'] = $this->item_per_page;
		return $this->_createPageLink( $config );

	}
}