<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ele_rep_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tb = 'ci_ele_repository';
	}

	public function getAll( $limit, $search ) {

		$new_arr = array();

		$query = $this->db->select('alias')->limit($limit)->like('alias', $search)->get( $this->tb );

		$data = $query->result_array();
		foreach( $data as $v ) {

			$new_arr[] = $v['alias'];
		}
		return $new_arr;
	}

	public function getList( $curpage, $length, $search ) {

		$s = '';
		if( $search ) {
			$s = " and alias like '%{$search}%' "; 
		} 

		$offset = ( $curpage - 1 ) * $length;

		$sql = "select * from ".$this->tb.' where 1=1'.$s." order by id desc limit {$offset},{$length} ";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	public function getOne( $id ) {

		$query = $this->db->get_where( $this->tb, array( 'id'=>$id ) );
		if( $row = $query->result_array() ) {
			return $row[0];
		} else {
			return array();
		}
	}

	public function getTotal( $search ){

		$s = '';
		if( $search ) {
			$s = " and alias like '%{$search}%' "; 
		} 

		$aid = $_SESSION['admin']['id'];
		$sql = "select count(id) count from ".$this->tb.' where 1=1 '.$s ;
		$query = $this->db->query( $sql );
		$count = $query->result_array();
		return $count[0]['count'];
	}

	public function create( $data ) {
		if( $this->findByAlias( $data['alias'] ) ) {
			return 'exists';
		}

		if( $this->db->insert( $this->tb , $data ) ) {
			return 'success';
		} else {
			return 'fail';
		}

	}

	public function update( $data, $id ){

		if( $this->findByAlias( $data['alias'], $id ) ) {
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

	private function findByAlias( $alias, $id = null ) {

		if( $id ) {
			$sql = "select * from ".$this->tb.' where id!='.$id." and alias='".$alias."' "  ;
			$query = $this->db->query( $sql );
		} else {
			$query = $this->db->get_where( $this->tb, array('alias'=>$alias) );
		}
		if( $row = $query->result_array() ) {
			return $row[0];
		} else {
			return array();
		}

	}
}