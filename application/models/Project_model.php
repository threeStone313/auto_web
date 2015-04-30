<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tb_name = 'ci_project';
		$this->tb_case = 'ci_case';
		$this->tb_step = 'ci_case_step';
	}

	public function create( $data ){

		$data['aid'] = $_SESSION['admin']['id'];

		$owner_arr = array();
		if( isset( $data['owner'] ) ) {
			$owner_arr = $data['owner'];
			unset( $data['owner'] );
		}

		//insert main table;
		$this->db->insert( $this->tb_name , $data );
		$project_id = $this->db->insert_id();

		//insert mapping table
		$owner_arr[] = $data['aid'];
		$owner_arr = array_unique( $owner_arr );
		
		$sql = '';
		foreach( $owner_arr as $owner_id ){
			$sql .= '(' . $owner_id . ',' . $project_id .'),';
		}
		$sql = substr( $sql, 0 , -1 );
		$this->db->query('insert into `ci_admin_project_map` ( `aid`, `pid` ) values '.$sql.';');
		return $project_id;
	}

	public function update( $pid, $data ){
		$aid = $_SESSION['admin']['id'];

		$owner_new_list = array();
		if( isset( $data['owner'] ) ) {
			$owner_new_list = $data['owner'];
			unset( $data['owner'] );
		}
		$owner_new_list[] = $aid;


		//update main table;
		$r = $this->db->where( 'id', $pid )->update( $this->tb_name , $data );
		
		//update mapping table
		$owner_old_list = $this->_getProjectOwner( $pid );
		foreach( $owner_old_list as $v) {
			$tmp[] = $v['id'];
		}
		$owner_old_list = $tmp;
		
		$add_diff = array_diff($owner_new_list, $owner_old_list);
		$del_diff = array_diff($owner_old_list, $owner_new_list);
		if( !empty( $add_diff ) ) {
			foreach( $add_diff as $_id ) {
				$this->db->insert( 'ci_admin_project_map' , array('aid'=> $_id, 'pid'=> $pid ));
			}
		}

		if( !empty( $del_diff ) ) {
			foreach( $del_diff as $_id ) {
				$this->db->delete( 'ci_admin_project_map', array('pid' => $pid, 'aid'=> $_id ));
			}
		}
		return $r;

	}


	public function delete( $pid ) {

		//delete main table
		$r1 = $this->db->delete( $this->tb_name, array( 'id' => $pid ));

		//delete mapping table
		$r2 = $this->db->delete( 'ci_admin_project_map', array( 'pid' => $pid ));

		//delete case
		$query = $this->db->get_where( $this->tb_case, array( 'pid' => $pid ) );
		$rows = $query->result_array();
		if( $rows ) {
			$this->db->delete( $this->tb_case, array( 'pid' => $pid ));
			foreach( $rows as $case ) {
				$this->db->delete( $this->tb_step, array( 'cid' => $case['id'] ));
			}
		}
		
		return $r1 && $r2;
	}


	public function getTotal( $search ){

		$s = '';
		if( $search ) {
			$s = " and p.pname like '%{$search}%' "; 
		} 

		$aid = $_SESSION['admin']['id'];
		$sql = "select count(p.id) count from ".$this->tb_name.' p left join `ci_admin_project_map` m on p.id=m.pid where m.aid='.$aid.$s ;
		$query = $this->db->query( $sql );
		$count = $query->result_array();
		return $count[0]['count'];
	}

	public function getAdminList() {

		$query = $this->db->query( 'select `id`,`nickname` from `ci_admin`' );
		return $query->result_array();
	}

	/**
	 * @param int project id
	 * @param int creater id
	 * @return array
	 */
	public function getOwnerList( $pid, $creater ) {

		$owner_list = $this->_getProjectOwner( $pid );

		$admin_list = $this->getAdminList();

		foreach( $admin_list as $k => $admin ) {
			foreach( $owner_list as $k2 => $owner ) {

				if( $admin['id'] == $owner['id'] ) {

					$admin_list[$k]['owner'] = 1;
					if( $admin['id'] == $creater ) {
						$admin_list[$k]['creater'] = 1;
					}
				}
			}
		}
		return $admin_list;
	}

	public function getList( $curpage, $length, $search ) {

		$s = '';
		if( $search ) {
			$s = " and p.pname like '%{$search}%' "; 
		} 

		$offset = ( $curpage - 1 ) * $length;

		$aid = $_SESSION['admin']['id'];
		$sql = "select p.* from ".$this->tb_name.' p left join `ci_admin_project_map` m on p.id=m.pid where m.aid='. $aid ." ".$s." order by p.id desc limit {$offset},{$length} ";
		$query = $this->db->query( $sql );
		return $query->result_array();
	}

	public function getOne( $pid ) {
		$query = $this->db->get_where( $this->tb_name, array('id'=>$pid));
		if( $rows = $query->result_array() ){
			return $rows[0];
		} else {
			return false;
		}
	}

	public function getAjaxProjectContent( $limit, $search ) {

		$new_arr = array();
		$sql = "select p.pname from `ci_project` p left join `ci_admin_project_map` m on p.id=m.pid where m.aid={$_SESSION['admin']['id']} and p.pname like '%{$search}%' limit {$limit}";
		//$query = $this->db->select('pname')->limit($limit)->like('pname', $search)->get_where( $this->tb_name, array('aid'=>$_SESSION['admin']['id']) );
		$query = $this->db->query($sql);
		$data = $query->result_array();
		foreach( $data as $v ) {

			$new_arr[] = $v['pname'];
		}
		return $new_arr;
	}

	private function _getProjectOwner( $pid ) {

		$sql = "select a.id from `ci_admin` a left join `ci_admin_project_map` m on a.id=m.aid where m.pid={$pid}";
		$query = $this->db->query( $sql );
		return  $query->result_array();
	}
}