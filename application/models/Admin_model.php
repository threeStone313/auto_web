<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array( 'security' ) );
		$this->tb = 'ci_admin';
	}

	/**
	 * Check the login data
	 * @param array
	 * @return boolean
	 */
	public function checkLoginData( $data ) {

		$email = $this->db->escape( $data['email'] );
		$query = $this->db->query( "select * from `ci_admin` where `email`={$email} limit 1;" );

		if( $row = $query->result_array() ) {

			if( $row[0]['password'] == do_hash( $data['password'] ) ) {
				return $row[0];
			} else {
				return false;
			}

		} else {
			return false;
		}

	}

	/**
	 * @param id
	 * @param array
	 * @return boolen
	 */
	public function changePassword( $aid, $data ) {

		$updata_data['password'] = do_hash( $data['password'] );
		return $this->db->update( 'ci_admin', $updata_data, array( 'id'=>$aid ) );

	}

	public function getEmail( $aid = 0) {

		$aid = $aid ? intval( $aid ) : $_SESSION['admin']['id'];
		$query = $this->db->select('email')->get_where( $this->tb, array('id'=>$aid) );
		$data = $query->result_array();
		return empty( $data ) ? '' : $data[0]['email'];  
	}

	public function sign_in( $data ) {

		$query = $this->db->get_where( $this->tb , array('email'=>$data['email']) );
		if( $query->result_array() ) return false;

		unset($data['passwordconf']);
		$data['password'] = do_hash( $data['password'] );
		return $this->db->insert( $this->tb, $data );

	}

}