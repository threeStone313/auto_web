<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends MY_Controller {

	public $item_per_page = 10;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'migration_model' );

	}

	public function start() {

		//echo 'admin migration <br/>';
		//$this->migration_model->admin_migration();

		//echo 'ele repository migration <br/>';
		//$this->migration_model->ele_repository_migration();

		//echo 'pack migration <br/>';
		//$this->migration_model->pack_migration();

		//echo 'project migration <br/>';
		//$this->migration_model->project_migration();
	}
}