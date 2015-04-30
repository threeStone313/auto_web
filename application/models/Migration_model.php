<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array( 'security' ) );
		$this->new = $this->load->database('default', TRUE);
		$this->old = $this->load->database('autoweb', TRUE);
	}

	public function project_migration(){

		$locators = config_item( 'xo_step_locator' );
		$actions = config_item( 'xo_step_action' );

		$locators = array_flip($locators);
		$actions = array_flip($actions);

		
		$query = $this->old->get( 'project' );
		$project = $query->result_array();

		foreach( $project as $v ) {

			$data = array(
					'pname' => $v['pname'],
					'tags' => $v['tags'],
				);
			$query = $this->old->get_where( 'project_user', array('pname'=>$v['pname']));
			if( $project_user = $query->result_array() ) {
				$query = $this->new->get_where( 'ci_admin', array('email'=>$project_user[0]['user']));
				$user = $query->result_array();
				$data['aid'] = $user[0]['id'];
			} else {

				$data['aid'] = 1;
			}
			$this->new->insert('ci_project', $data);
			$pid = $this->new->insert_id();
			$map = array(
					'aid' => $data['aid'],
					'pid' => $pid,
				);
			$this->new->insert('ci_admin_project_map', $map);

			$query = $this->old->order_by('id','asc')->get_where( 'test_cases', array('pname'=>$v['pname']) );
			$case = $query->result_array();
			foreach( $case as $k2=>$v2 ) {

				$data2 = array(

						'pid'=>$pid,
						'cname'=>$v2['name'],
						'tags' => $v2['tag'],
						'orderby' => ($k2+1),
					);

				$this->new->insert('ci_case', $data2);
				$cid = $this->new->insert_id();

				$query = $this->old->order_by('step_id','asc')->get_where( 'tc_detail', array('pname'=>$v['pname'],'id'=>$v2['id']) );
				$steps = $query->result_array();
				foreach ($steps as $key => $value) {

					$data3 = array( 
						'cid'=>$cid,
						'checkpoint'=>$value['function_point'],
						
						'orderby'=>($key+1),
					 );
					
					if( $value['action_type'] == "Referenced steps pack" ) {

						$query = $this->new->get_where('ci_pack',array('name'=>$value['data']));
						$thispack = $query->result_array();
						if( $thispack ) {
							$data3['action'] = $actions[$value['action_type']] ? $actions[$value['action_type']] : 0;
							$data3['pack_id'] = $thispack[0]['id'];
						} else {
							print_r($value['data']);
						}
						

					} else {

						$data3['action'] = $actions[$value['action_type']] ? $actions[$value['action_type']] : 0;
						$data3['locator'] = $locators[$value['locate_way']] ? $locators[$value['locate_way']] : 0;
						$data3['element'] = $value['element'];
						$data3['alias'] = $value['alias'];
						$data3['data'] = $value['data'];
					}

					$this->new->insert('ci_case_step',$data3);
					unset($data3);
				}
				unset($data2);

			}
			
		}


	}

	public function pack_migration() {

		$locators = config_item( 'xo_step_locator' );
		$actions = config_item( 'xo_step_action' );

		$locators = array_flip($locators);
		$actions = array_flip($actions);

		$query = $this->old->get('packsteps');
		$packsteps = $query->result_array();

		foreach( $packsteps as $v ){
			$data = array(
					'name' => $v['packname'],
					'tags' => $v['tags'],
				);
			$this->new->insert( 'ci_pack', $data );
			$id = $this->new->insert_id();

			$sql = "select * from pack_detail where id in (select id from packsteps where packname='{$v['packname']}')";
			$query = $this->old->query( $sql );
			$steps = $query->result_array();
			foreach( $steps as $k2=>$v2) {
				$ndata = array(
						'pack_id'=>$id,
						'checkpoint'=>$v2['function_point'],
						'action'=> $actions[$v2['action_type']] ? $actions[$v2['action_type']] : 0,
						'locator'=> $locators[$v2['locate_way']] ? $locators[$v2['locate_way']] : 0,
						'element' => $v2['element'],
						'alias' => $v2['alias'],
						'data' => $v2['data'],
						'orderby' => ($k2+1),
					);

				$this->new->insert('ci_pack_step',$ndata);
			}
		}
		
	}

	public function ele_repository_migration() {

		$locators = config_item( 'xo_step_locator' );
		$locators = array_flip($locators);
		$query = $this->old->get('elerepository');
		$elerepository = $query->result_array();

		foreach( $elerepository as $v ) {

			$data = array(

					'alias' =>$v['alias'],
					'locator' => $locators[$v['locate']],
					'element' => $v['element'],

				);
			$this->new->insert( 'ci_ele_repository', $data );
		}

	}

	public function admin_migration() {

		$query = $this->old->get('users');
		$users = $query->result_array();
		
		foreach( $users as $v) {

			$data = array(
					'email'=>$v['email'],
					'nickname' => $v['userName'],
					'password' => do_hash($v['password'])
				);
			$this->new->insert( 'ci_admin', $data );
			$id = $this->new->insert_id();

			$setting = array(
					'aid' => $id,
					'key' => 'ip',
					'value' => $v['ip'],
				);
			$this->new->insert( 'ci_setting', $setting );

		}
	}

}