<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends MY_Controller {

	public $item_per_page = 10;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'project_model' );
		$this->load->model( 'pack_model' );
		$this->load->model( 'case_model' );
		$this->load->model( 'case_step_model' );

	}

	public function index( $curpage = 1 ) {
		$curpage = max( (int)$curpage, 1 );

		$search = $this->input->get('s');
		$total = $this->project_model->getTotal( $search );

		$assign['search'] = $search;
		$assign['pagelinks'] = $this->_getPagelink( $total );
		$assign['datas'] = $this->project_model->getList( $curpage , $this->item_per_page, $search );
		$this->_LoadMyView( 'project/list', $assign );
	}

	public function add() {

		$assign['owner_list'] = $this->project_model->getAdminList();
		$this->_LoadMyView( 'project/add', $assign );
	}

	public function edit( $id ) {
		$id = intval( $id );
		if ( !$id ) show_error('Project Not Found!');

		if( $assign['data'] = $this->project_model->getOne( $id ) ) {

			if( $assign['data']['aid'] != $_SESSION['admin']['id'] ) show_error( 'You don\'t have access to do that!' );

			$assign['owner_list'] = $this->project_model->getOwnerList( $id, $assign['data']['aid'] );
			
			$this->_LoadMyView( 'project/edit', $assign );

		} else {

			show_error('Project Not Found!');
		}
	}

	public function delete( $id ) {
		$id = intval( $id );
		if ( !$id ) show_error('Project Not Found!');

		if( $this->project_model->delete( $id ) ) {
			$this->_setNotice( 'Success!', '^_^', 'success' );
			redirect('/project/index/');
		} else {
			$this->_setNotice( 'Fail!' );
			redirect('/project/index/');
		}

	}

	public function create(){

		if( $this->_FormValidation( 'create' ) ) {

			$data = $this->input->post();
			if( $this->project_model->create( $data ) ) {

				$this->_setNotice( 'Success!', '^_^', 'success' );
				redirect('/project/index/');

			} else {
				$this->_setNotice( 'Fail!' );
				redirect('/project/add/');
			}

		} else {
			redirect('/project/add/');
		}
	}

	public function update( $id ) {

		$id = intval( $id );
		if ( !$id ) show_error('Project Not Found!');

		if( $this->_FormValidation( 'create' ) ) {

			$data = $this->input->post();
			if( $this->project_model->update( $id, $data ) ) {

				$this->_setNotice( 'Success!', '^_^', 'success' );
				redirect('/project/edit/'.$id);

			} else {
				$this->_setNotice( 'Fail!' );
				redirect('/project/edit/'.$id);
			}

		} else {
			redirect('/project/edit/'.$id);
		}
	}


	/**
	 * @param int project id
	 * @param int current page
	 */
	public function case_list( $pid , $curpage = 1 ) {

		$pid = intval( $pid );
		if ( $data = $this->project_model->getOne( $pid ) ) {

			$_SESSION['project_id'] = $pid;
			$curpage = max( (int)$curpage, 1 );

			$search = $this->input->get('s');
			$total = $this->case_model->getCaseTotal( $pid, $search );
			$assign['search'] = $search;
			$assign['project_name'] = $data['pname'];
			$assign['pagelinks'] = $this->_getPagelink( $total, $pid, 4 );
			$assign['datas'] = $this->case_model->getCaseList( $pid, $curpage , $this->item_per_page, $search );
			$this->_LoadMyView( 'project/case_list', $assign );

		} else {
			show_error('Project Not Found!');
		}
	}

	public function case_order( ) {

		$data = $this->input->post();
		$pid = $_SESSION['project_id'];
		if( isset( $data['order'] ) and $data['order'] ){
			if( $this->case_model->save_order( $data['order'] ) ) {

				$this->_setNotice( 'Success!', '^_^', 'success' );
				redirect('/project/case_list/'.$pid);
			}
		} else {
			show_error('Can Not Order!');
		}
	}

	public function case_add( ) {

		$this->_LoadMyView( 'project/case_add' );
	}

	public function case_create() {

		
		if( $this->_FormValidation( 'case_create' ) ) {

			$data = $this->input->post();
			$data['pid'] = $_SESSION['project_id'];
			
			if( $this->case_model->create( $data ) ) {

				$this->_setNotice( 'Success!', '^_^', 'success' );
				redirect( '/project/case_list/'.$_SESSION['project_id'] );

			} else {
				$this->_setNotice( 'Fail!' );
				redirect( '/project/case_add/' );
			}

		} else {
			redirect( '/project/case_add/' );
		}
	}

	public function case_edit( $cid ) {

		if ( $data = $this->case_model->getOne( $cid ) ) {

			$assign['data'] = $data;
			$assign['cid'] = $cid;
			$this->_LoadMyView( 'project/case_edit', $assign );

		} else {
			show_error('Case Not Found!');
		}
	}

	public function case_update( $cid ) {

		$cid = intval( $cid );
		if ( !$cid ) show_error('Case Not Found!');

		if( $this->_FormValidation( 'case_create' ) ) {

			$data = $this->input->post();
			if( $this->case_model->update( $cid, $data ) ) {

				$this->_setNotice( 'Success!', '^_^', 'success' );
				redirect('/project/case_edit/'.$cid);

			} else {
				$this->_setNotice( 'Fail!' );
				redirect('/project/case_edit/'.$cid);
			}

		} else {
			redirect('/project/case_edit/'.$cid);
		}

	}

	public function case_delete( $cid ) {
		$cid = intval( $cid );
		if ( !$cid ) show_error('Project Not Found!');

		if( $this->case_model->delete( $cid ) ) {
			$this->_setNotice( 'Success!', '^_^', 'success' );
			redirect( '/project/case_list/'.$_SESSION['project_id'] );
		} else {
			$this->_setNotice( 'Fail!' );
			redirect( '/project/case_list/'.$_SESSION['project_id'] );
		}
	}


	public function step_list( $cid ) {

		$cid = intval( $cid );
		if ( $data = $this->case_model->getOne( $cid ) ) {

			$_SESSION['case_id'] = $cid;
			$assign['case_name'] = $data['cname'];


			$assign['pack_list'] = $this->pack_model->getListByUsingTimes();
			$assign['datas'] = $this->case_step_model->getStepList( $cid );
			$this->_LoadMyView( 'project/step_list', $assign );

		} else {
			show_error('Project Not Found!');
		}

	}

	public function step_save( $cid ) {

		$cid = intval( $cid ); 
		$data = $this->input->post();
		if( $this->case_step_model->save( $data, $cid ) ) {
			$this->_setNotice( 'Success!', '^_^', 'success' );
			redirect( '/project/step_list/'.$_SESSION['case_id'] );
		}
	}

	public function ajax_get_step_data() {

		if( $this->input->is_ajax_request() ) {

			$data['action'] = config_item( 'xo_step_action' );
			$data['locator'] = config_item( 'xo_step_locator' );
			echo json_encode( $data );
		}
		die;
	}

	public function ajax_project_auto() {

		if( $this->input->is_ajax_request() ) {

			$s = $this->input->get('q');
			$limit = $this->input->get('limit');
			$data = $this->project_model->getAjaxProjectContent( $limit, $s );
			foreach ($data as $key=>$value) {
				echo "$key|$value\n";
			}
		}
		die;
	}

	public function ajax_case_auto() {

		if( $this->input->is_ajax_request() ) {

			$s = $this->input->get('q');
			$limit = $this->input->get('limit');
			$data = $this->case_model->getAjaxCaseContent( $limit, $s );
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
				$this->form_validation->set_rules( 'pname', 'Project Name', 'required' );
				break;
			case 'case_create':
				$this->form_validation->set_rules( 'cname', 'Case Name', 'required' );
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