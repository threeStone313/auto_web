<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Case_step_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tb = 'ci_case_step';
		$this->tb_case = 'ci_case';
		$this->tb_pack = 'ci_pack';
		$this->tb_ele = 'ci_ele_repository';
	}

	public function getStepList( $cid ) {
		$query = $this->db->order_by('orderby','asc')->get_where( $this->tb, array( 'cid'=>$cid ) );
		$data = $query->result_array();
		foreach( $data as $k=>$v ) {
			if( $v['pack_id'] ) {

				$query = $this->db->get_where( $this->tb_pack, array( 'id'=>$v['pack_id'] ) );
				$pack = $query->result_array();
				$data[$k]['pack_name'] = $pack[0]['name'];
			}
		}
		return $data;
	}

	public function save( $data, $cid ) {


		if( isset( $data['step'] ) and !empty( $data['step'] ) ) {
			$this->step_update( $data['step'], $cid );
		}

		if( isset( $data['add'] ) and !empty( $data['add'] ) ) {
			$this->step_add( $data['add'], $cid );
		}

		return true;

	}

	private function step_add( $data, $cid ) {
		
		foreach( $data as $v ) {
			$v['cid'] = $cid;
			$r = $this->db->insert( $this->tb , $v );

			//alias is exists?
			if( $v['alias'] ) {
				$query = $this->db->limit(1)->get_where( $this->tb_ele, array( 'alias'=>$v['alias'] ) );
				$data = $query->result_array();
				if( empty( $data ) ) {
					$alias = array(
						'alias' => $v['alias'],
						'locator' => $v['locator'],
						'element' => $v['element'],
					);
					$this->db->insert( $this->tb_ele, $alias);
				}
			}
		}
	}

	private function step_update( $data, $cid ){

		//delete rows
		$query = $this->db->get_where( $this->tb, array('cid'=>$cid) );
		$step_datas = $query->result_array();
		$new = array_keys( $data );
		$old = array();
		foreach( $step_datas as $v) {
			$old[] = (int)$v['id'];
		}

		$del_ids = array_diff( $old, $new );
		if( $del_ids ) {
			foreach( $del_ids as $id ) {
				$this->db->delete( $this->tb, array( 'id' => $id ));
			}
		}

		//update rows
		foreach( $data as $id => $v ) {
			$this->db->where( 'id', $id )->update( $this->tb , $v );
			//alias is exists?
			if( $v['alias'] ) {
				$query = $this->db->limit(1)->get_where( $this->tb_ele, array( 'alias'=>$v['alias'] ) );
				$data = $query->result_array();
				if( empty( $data ) ) {
					$alias = array(
						'alias' => $v['alias'],
						'locator' => $v['locator'],
						'element' => $v['element'],
					);
					$this->db->insert( $this->tb_ele, $alias);
				}
			}
		}

	}
}