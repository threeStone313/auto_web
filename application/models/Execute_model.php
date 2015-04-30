<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Execute_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->tb = 'ci_execute';
		$this->tb_case = 'ci_case';
	}

	public function save( $project_id, $file ) {

		$query = $this->db->get_where( $this->tb_case, array( 'pid'=> $project_id ) );
		$cases = $query->result_array();

		foreach( $cases as $case ){
			$data = array(
				'cid' => $case['id'],
				'filename' => $file,

			);

			$this->db->insert( $this->tb, $data );
		}
	}

	public function save_case( $case_id, $file ) {

		$data = array('cid'=>$case_id,'filename'=>$file );
		$this->db->insert( $this->tb, $data);
	}
}