<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pack_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tb = 'ci_pack';
		$this->tb_step = 'ci_pack_step';
	}


	public function getTotal( $search ){

		$s = '';
		if( $search ) {
			$s = " and name like '%{$search}%' "; 
		} 

		$sql = "select count(id) count from ".$this->tb.' where 1=1 '.$s ;
		$query = $this->db->query( $sql );
		$count = $query->result_array();
		return $count[0]['count'];
	}

	public function getList( $curpage, $length, $search ) {

		$s = '';
		if( $search ) {
			$s = " and name like '%{$search}%' "; 
		} 

		$offset = ( $curpage - 1 ) * $length;

		$aid = $_SESSION['admin']['id'];
		$sql = "select * from ".$this->tb.' where 1=1'.$s." order by id desc limit {$offset},{$length} ";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	public function getOne( $id ) {
		$query = $this->db->get_where( $this->tb, array('id'=>$id));
		if( $rows = $query->result_array() ){
			return $rows[0];
		} else {
			return false;
		}
	}

	public function create( $data ) {
		if( $this->findByName( $data['name'] ) ) {
			return 'exists';
		}

		if( $this->db->insert( $this->tb , $data ) ) {
			return 'success';
		} else {
			return 'fail';
		}

	}

	public function update( $data, $id ){

		if( $this->findByName( $data['name'], $id ) ) {
			return 'exists';
		}

		if( $this->db->where( 'id', $id )->update( $this->tb , $data ) ) {
			return 'success';
		} else {
			return 'fail';
		}

	}

	public function delete( $id ) {

		return $this->db->delete( $this->tb, array( 'id' => $id ));
	}
	


	public function getListByUsingTimes() {

		$query = $this->db->order_by('times','desc')->limit(5)->get( $this->tb );
		return $query->result_array();

	}

	public function ajaxSearch( $name ){

		$query = $this->db->order_by( 'times', 'desc')->like('name',$name)->limit(5)->get( $this->tb );
		return $query->result_array();

	}


	public function getAjaxPackContent( $limit, $search ) {

		$new_arr = array();
		$query = $this->db->select('name')->limit($limit)->like('name', $search)->get_where( $this->tb );
		$data = $query->result_array();
		foreach( $data as $v ) {

			$new_arr[] = $v['name'];
		}
		return $new_arr;
	}


	private function findByName( $name, $id = null ) {

		if( $id ) {
			$sql = "select * from ".$this->tb.' where id!='.$id." and name='".$name."' "  ;
			$query = $this->db->query( $sql );
		} else {
			$query = $this->db->get_where( $this->tb, array('name'=>$name) );
		}
		if( $row = $query->result_array() ) {
			return $row[0];
		} else {
			return array();
		}

	}
}