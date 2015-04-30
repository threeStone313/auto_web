<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tb = 'ci_setting';
	}

	/**
	 * Get admin setting
	 * @param aid
	 * @return array
	 */ 
	public function getSetting( $aid = 0 ) {

		$aid = $aid ? intval( $aid ) : $_SESSION['admin']['id'];
		$query = $this->db->query( "select * from `ci_setting` where `aid`={$aid};" );

		$setting = array();
		$row = $query->result_array();

		foreach( $row as $v ) {
			$setting[$v['key']] = $v['value']; 
		}
		return $setting;
	}

	public function save( $aid, $data ) {

		foreach( $data as $k => $v ) {
			$query = $this->db->get_where('ci_setting', array('aid' => $aid, 'key'=> $k) );
			$row = $query->result_array();
			if( $row ) {

				$boolen = $this->db->update('ci_setting', array('value' => $v), array('aid' => $aid, 'key'=> $k) );

			} else {

				$insert_data['aid'] = $aid;
				$insert_data['key'] = $k;
				$insert_data['value'] = $v;
				$boolen = $this->db->insert('ci_setting', $insert_data );
			}

		}
        return $boolen;
	}

	public function getOneSetting( $key , $aid = 0) {
		$aid = $aid ? intval( $aid ) : $_SESSION['admin']['id'];

		$query = $this->db->limit(1)->get_where( $this->tb, array('aid' =>$aid, 'key'=>$key) );
		$data = $query->result_array();
		return empty( $data ) ? '' : $data[0]['value'];
	}

	public function getDbConfig() {

		$url = $this->getOneSetting( 'sqlUrl' );
		$user = $this->getOneSetting( 'sqlAccount' );
		$password = $this->getOneSetting( 'sqlPassword' ); 
		
		return array('sqlUrl'=>$url, 'sqlAccount'=>$user, 'sqlPassword'=>$password );

	}

}