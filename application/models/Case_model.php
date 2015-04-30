<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Case_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tb_name = 'ci_case';
		$this->tb_name_p = 'ci_project';
	}


	public function create( $data ) {

		$query = $this->db->get_where( $this->tb_name_p, array('id'=>$data['pid']));
		if( $rows = $query->result_array() ){

			$total = $this->getCaseTotal( $data['pid'] );

			$data['orderby'] = $total + 1;
			$this->db->insert( $this->tb_name , $data );
			$project_id = $this->db->insert_id();

			return $project_id;

		} else {
			return false;
		}

	}

	public function update( $cid, $data ) {

		return $this->db->where( 'id', $cid )->update( $this->tb_name , $data );
	}

	public function delete( $cid ) {

		return $this->db->delete( $this->tb_name, array( 'id' => $cid ) );
	}

	public function getCaseTotal( $pid, $search ){

		$s = '';
		if( $search ) {
			$s = " and cname like '%{$search}%' "; 
		} 

		$aid = $_SESSION['admin']['id'];
		$sql = "select count(id) count from ".$this->tb_name." where pid={$pid}".$s;
		$query = $this->db->query( $sql );
		$count = $query->result_array();
		return $count[0]['count'];
	}

	public function getCaseList( $pid, $curpage, $length, $search ) {

		$s = '';
		if( $search ) {
			$s = " and cname like '%{$search}%' "; 
		} 

		$offset = ( $curpage - 1 ) * $length;

		$aid = $_SESSION['admin']['id'];
		$sql = "select * from ".$this->tb_name." where pid={$pid}".$s." order by orderby,id asc limit {$offset},{$length} ";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	public function getOne( $cid ) {

		$query = $this->db->get_where( $this->tb_name, array( 'id'=> $cid ) );
		$rows = $query->result_array();
		return $rows ? $rows[0] : array();
	}

	public function save_order( $order_data ) {

		foreach( $order_data as $cid => $order ) {
			$data['orderby'] = intval( $order );
			$this->db->where( 'id', $cid )->update( $this->tb_name , $data );
		}
		return true;
	}

	public function getAjaxCaseContent( $limit, $search ) {

		$new_arr = array();
		$query = $this->db->select('cname')->limit($limit)->like('cname', $search)->get_where( $this->tb_name, array('pid'=>$_SESSION['project_id'] ) );
		$data = $query->result_array();
		foreach( $data as $v ) {

			$new_arr[] = $v['cname'];
		}
		return $new_arr;
	}
}