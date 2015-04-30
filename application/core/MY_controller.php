<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	function  __construct() {
		parent::__construct();
		$this->load->helper( array( 'form', 'url', 'array','cookie' ) );
		$this->load->library( 'pagination', 'uri' );
		$this->_isLogin();
	}

	/**
	 * Set notice
	 * @param  string  message
	 * @param  string  sub title
	 * @param  string  notice type (success, danger, warning)
	 */
	protected function _setNotice( $message, $sub = 'Oops!', $type = 'danger', $pipe = 1 ) {

		$params = array(
				'message' => is_array( $message ) ? $message : array( $message ),
				'sub'     => $sub,
				'type'    => $type,
			);

		$this->session->set_flashdata( '_notice_' . $pipe , $params );

	}

	/**
	 * Get notice
	 * @param  string  Is show the notice with render or return the notice;
	 */
	protected function _getNotice( $is_show = 'show', $pipe = 1 ) {

		if( $notice = $this->session->flashdata( '_notice_' . $pipe ) ) {

			if ( 'show' ==  $is_show ) {
				return $this->load->view( 'elements/notice', array( 'notice' => $notice), true );
			} else {
				return $notice;
			}

		} else {
			return '';
		}
	}
	
	/**
	 * Load layout
	 * @param string
	 * @param array
	 */
	protected function _LoadMyView( $view, $assign = array() ) {

		$default_assign['notice'] = $this->_getNotice();
		$assign = array_merge( $default_assign, $assign );
		$layout_assign = array(
				'nav'     => $this->load->view( 'elements/nav', array(), true ),
				'contents' => $this->load->view( $view, $assign, true ),
			);
		$this->load->view( 'layouts/default', $layout_assign );

	}

	private function _isLogin() {

		$safe_route = array( 'welcome/index', 'welcome/login', 'welcome/logout','admin/sign_in' );
		list($cur_c, $cur_a) = getCurrentRoute();
		$cur_route = $cur_c. '/' .$cur_a;
		if( !isset($_SESSION['admin']) and !in_array( $cur_route, $safe_route ) ){
			$this->_setNotice( 'You need to login!', 'OoO', 'warning' );
			redirect('/welcome/index/');
		}
	}

	protected function _createPageLink( $config ) {

		$default_config = array(
				'use_page_numbers' => true,
				'enable_query_strings' => true,
				'reuse_query_string' => true,
				'use_global_url_suffix'=>true,
				//Fist & Last
				'first_link' => false,
				'last_link' => false,

				//num page
				'num_tag_open' => '<li>',
				'num_tag_close' => '</li>',

				//prelink
				'prev_link' => '<span class="elusive icon-arrow-left"></span>',
				'prev_tag_open' => '<li>',
				'prev_tag_close' => '</li>',

				//nextLink
				'next_link' => '<span class="elusive icon-arrow-right"></span>',
				'next_tag_open' => '<li>',
				'next_tag_close' => '</li>',

				//current
				'cur_tag_open' => '<li class="active"><a href="#">',
				'cur_tag_close' => '</a></li>',
			);
		$config = array_merge( $default_config, $config );
		$this->pagination->initialize( $config );
		return $this->pagination->create_links();
	}

}