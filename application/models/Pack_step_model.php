<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pack_step_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tb = 'ci_pack_step';
		$this->tb_pack = 'ci_pack';
		$this->tb_ele = 'ci_ele_repository';
	}

	public function getStepList( $pack_id ) {
		$query = $this->db->order_by('orderby','asc')->get_where( $this->tb, array( 'pack_id'=>$pack_id ) );
		return $query->result_array();
	}

	public function save( $data, $pack_id ) {


		if( isset( $data['step'] ) and !empty( $data['step'] ) ) {
			$this->step_update( $data['step'], $pack_id );
		}

		if( isset( $data['add'] ) and !empty( $data['add'] ) ) {
			$this->step_add( $data['add'], $pack_id );
		}

		return true;

	}

	private function step_add( $data, $pack_id ) {
		
		foreach( $data as $v ) {
			$v['pack_id'] = $pack_id;
			$r = $this->db->insert( $this->tb , $v );
		}
	}

	private function step_update( $data, $pack_id ){

		//delete rows
		$query = $this->db->get_where( $this->tb, array('pack_id'=>$pack_id) );
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
		}

	}
}