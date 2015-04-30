<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Execute extends MY_Controller {

	public $item_per_page = 10;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'project_model' );
		$this->load->model( 'case_model' );
		$this->load->model( 'admin_model');
		$this->load->model( 'execute_model' );
		$this->load->model( 'setting_model' );
		$this->load->helper( 'email' );
	}

	public function test_email() {
		$message = send_report( 'szhou@xogrp.com', 'This is an email form automan' );
		echo nl2br($message);
	}

	public function project_run( ) {

		$execute_data = $this->input->post();

		$ip = trim( $execute_data['ip'] );
		if( !$ip ) show_error('Ip is emtpy now. Please set in setting page.');
		$_SESSION['ip'] = $ip;

		$dbconfig = $this->setting_model->getDbConfig();
		if( !$dbconfig ) show_error('Database haven\'t set yet.Please set in setting page.');

		$email = $this->admin_model->getEmail();

		if( !isset($execute_data['exec']) or empty($execute_data['exec'])) show_error('You haven\'t select any project yet.');



		$ids = $execute_data['exec'];

		$filename = date('ymdhis').mt_rand(10,99);
		$this->CreateXML( $execute_data, $ip, $email, $filename, $dbconfig );

		foreach( $ids as $id ) {

			if( $data = $this->project_model->getOne( $id ) ){

				$this->execute_model->save( $id, $filename );

			} else {
				show_error( 'Id: '.$id. ' Project not Found!' );
			}

		} 

		$this->run( $filename );
		$message = send_report( $email, 'Auto Test Report' );
		file_put_contents( 'mail.log' , $message, FILE_APPEND);
	}

	public function case_run() {

		$execute_data = $this->input->post();
		$ip = trim( $execute_data['ip'] );
		if( !$ip ) show_error('Ip is emtpy now. Please set.');
		$_SESSION['ip'] = $ip;

		$dbconfig = $this->setting_model->getDbConfig();
		if( !$dbconfig ) show_error('Database haven\'t set yet.Please set in setting page.');

		$email = $this->admin_model->getEmail();


		if( !isset($execute_data['exec']) or empty($execute_data['exec'])) show_error('You haven\'t select any case yet.');

		$ids = $execute_data['exec'];

		$filename = date('ymdhis').mt_rand(10,99);
		$this->CreateXML( $execute_data, $ip, $email, $filename, $dbconfig );
		foreach( $ids as $v ) {

			$this->execute_model->save_case( $v, $filename );
			
		}

		

		
		$this->run( $filename );
		$message = send_report( $email, 'Auto Test Report' );
		file_put_contents( 'mail.log' , $message, FILE_APPEND);

	}

	private function run( $filename ) {

		ini_set("max_execution_time", "36000");
		ini_set("output_buffering", "off");
		ob_end_flush();
		$run_bat_file = FCPATH.'run.bat';
		if( !file_exists($run_bat_file)) { show_error('Run.bat file is missing!'); }
		
		$path = $run_bat_file.' '.$filename;
		$path = str_replace('/','\\', $path);
		system($path);

	}

	private function CreateXML(  $execute_data, $ip, $email, $filename, $dbconfig  ) {


		$dom = new DOMDocument;
		$root = $dom->createElement("suite");
		$dom->appendChild($root);
		$name=$dom->createAttribute("name");
		$root->appendChild($name);
		$nameVal = $dom->createTextNode("browserNumb");
		$name->appendChild($nameVal);
		$vb=$dom->createAttribute("verbose");
		$root->appendChild($vb);
		$vbVal = $dom->createTextNode("0");
		$vb->appendChild($vbVal);


		$test = $dom->createElement("test");
		$root->appendChild($test);
		$tname=$dom->createAttribute("name");
		$test->appendChild($tname);
		$tnameVal = $dom->createTextNode("theKnot");
		$tname->appendChild($tnameVal);

		$parameter_u=$dom->createElement("parameter");
		$test->appendChild($parameter_u);
		$pName_u=$dom->createAttribute("name");
		$parameter_u->appendChild($pName_u);
		$pNameVal_u=$dom->createTextNode("sqlUrl");
		$pName_u->appendChild($pNameVal_u);
		$pValue_u=$dom->createAttribute("value");
		$parameter_u->appendChild($pValue_u);
		$pValueVal_u=$dom->createTextNode( $dbconfig['sqlUrl'] );
		$pValue_u->appendChild($pValueVal_u);


		$parameter=$dom->createElement("parameter");
		$test->appendChild($parameter);
		$pName=$dom->createAttribute("name");
		$parameter->appendChild($pName);
		$pNameVal=$dom->createTextNode("sqlAccount");
		$pName->appendChild($pNameVal);
		$pValue=$dom->createAttribute("value");
		$parameter->appendChild($pValue);
		$pValueVal=$dom->createTextNode( $dbconfig['sqlAccount'] );
		$pValue->appendChild($pValueVal);

		$parameter=$dom->createElement("parameter");
		$test->appendChild($parameter);
		$pName=$dom->createAttribute("name");
		$parameter->appendChild($pName);
		$pNameVal=$dom->createTextNode("sqlPassword");
		$pName->appendChild($pNameVal);
		$pValue=$dom->createAttribute("value");
		$parameter->appendChild($pValue);
		$pValueVal=$dom->createTextNode( $dbconfig['sqlPassword'] );
		$pValue->appendChild($pValueVal);

		$parameter=$dom->createElement("parameter");
		$test->appendChild($parameter);
		$pName=$dom->createAttribute("name");
		$parameter->appendChild($pName);
		$pNameVal=$dom->createTextNode("IP");
		$pName->appendChild($pNameVal);
		$pValue=$dom->createAttribute("value");
		$parameter->appendChild($pValue);
		$pValueVal=$dom->createTextNode( $ip );
		$pValue->appendChild($pValueVal);

		$parameter2=$dom->createElement("parameter");
		$test->appendChild($parameter2);
		$pName2=$dom->createAttribute("name");
		$parameter2->appendChild($pName2);
		$pNameVal2=$dom->createTextNode("browser");
		$pName2->appendChild($pNameVal2);
		$pValue2=$dom->createAttribute("value");
		$parameter2->appendChild($pValue2);
		$pValueV2=$dom->createTextNode( $execute_data['browser'] );
		$pValue2->appendChild($pValueV2);

		$parameter3=$dom->createElement("parameter");
		$test->appendChild($parameter3);
		$pName3=$dom->createAttribute("name");
		$parameter3->appendChild($pName3);
		$pNameVal3=$dom->createTextNode("width");
		$pName3->appendChild($pNameVal3);
		$pValue3=$dom->createAttribute("value");
		$parameter3->appendChild($pValue3);
		$pValueV3=$dom->createTextNode( $execute_data['width'] );
		$pValue3->appendChild($pValueV3);

		$parameter4=$dom->createElement("parameter");
		$test->appendChild($parameter4);
		$pName4=$dom->createAttribute("name");
		$parameter4->appendChild($pName4);
		$pNameVal4=$dom->createTextNode("height");
		$pName4->appendChild($pNameVal4);
		$pValue4=$dom->createAttribute("value");
		$parameter4->appendChild($pValue4);
		$pValueV4=$dom->createTextNode( $execute_data['height'] );
		$pValue4->appendChild($pValueV4);

		$parameter5=$dom->createElement("parameter");
		$test->appendChild($parameter5);
		$pName5=$dom->createAttribute("name");
		$parameter5->appendChild($pName5);
		$pNameVal5=$dom->createTextNode("email");
		$pName5->appendChild($pNameVal5);
		$pValue5=$dom->createAttribute("value");
		$parameter5->appendChild($pValue5);
		$pValueVal5=$dom->createTextNode( $email );
		$pValue5->appendChild($pValueVal5);

		$classes=$dom->createElement("classes");
		$test->appendChild($classes);

		$class=$dom->createElement("class");
		$classes->appendChild($class);
		$cName=$dom->createAttribute("name");
		$class->appendChild($cName);
		$cNameVal=$dom->createTextNode("KWS.prepare.t".$filename);
		$cName->appendChild($cNameVal);

		$listeners = $dom->createElement("listeners");
		$root->appendChild($listeners);

		$listener=$dom->createElement("listener");
		$listeners->appendChild($listener);
		$lName=$dom->createAttribute("class-name");
		$listener->appendChild($lName);
		$lNameVal=$dom->createTextNode("com.netease.qa.testng.TestResultListener");
		$lName->appendChild($lNameVal);

		$listener2=$dom->createElement("listener");
		$listeners->appendChild($listener2);
		$lName2=$dom->createAttribute("class-name");
		$listener2->appendChild($lName2);
		$lNameVal2=$dom->createTextNode("com.netease.qa.testng.RetryListener");
		$lName2->appendChild($lNameVal2);

		$listener3=$dom->createElement("listener");
		$listeners->appendChild($listener3);
		$lName3=$dom->createAttribute("class-name");
		$listener3->appendChild($lName3);
		$lNameVal3=$dom->createTextNode("com.netease.qa.testng.PowerEmailableReporter");
		$lName3->appendChild($lNameVal3);

		$save_path = config_item( 'xo_xml_path' ).$filename.'.xml';

		$dom->save( $save_path );
	}
}