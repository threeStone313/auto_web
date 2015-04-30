<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'libraries/extra/class.phpmailer.php');
require_once( APPPATH.'libraries/extra/class.smtp.php');

if ( ! function_exists('send_report'))
{
	/**
	 * Validate email address
	 *
	 * @deprecated	3.0.0	Use PHP's filter_var() instead
	 * @param	string	$email
	 * @return	bool
	 */
	function send_report( $to, $subject ) {
		

		$mail_set = config_item('xo_mail');
		$mail = new PHPMailer();

		$mail->CharSet = $mail_set['charset'];//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	    $mail->IsSMTP(); // 设定使用SMTP服务
	    $mail->SMTPDebug  = 0;                     // 启用SMTP调试功能
	    // 1 = errors and messages
	    // 2 = messages only
	    $mail->SMTPAuth   = $mail_set['SMTPAuth'];                  // 启用 SMTP 验证功能
	    $mail->SMTPSecure = $mail_set['SMTPSecure'];                 // 安全协议
	    $mail->Host       = $mail_set['host'];      // SMTP 服务器
	    $mail->Port       = $mail_set['port'];                   // SMTP服务器的端口号
	    $mail->Username   = $mail_set['username'];  // SMTP服务器用户名
	    $mail->Password   = $mail_set['password'];            // SMTP服务器密码
	    $mail->SetFrom( $mail_set['setfrom'][0] , $mail_set['setfrom'][1] );
	    //$mail->AddReplyTo("邮件回复地址,如admin#jiucool.com #换成@","邮件回复人的名称");
	    $mail->Subject    = $subject;
	    $mail->AltBody    = $mail_set['altbody'];
	    $mail->Body ='Here is the test report, please check!';
	    $address = $to;
	    $mail->AddAddress($address);
	    $mail -> AddAttachment( FCPATH.'result/test-report/power-emailable-report.html','AutoTest Report.html');
		$mess = date('Y-m-d H:i:s')."\r\n";
	    if(!$mail->Send()) {
			$mess .= "Mailer Error: " . $mail->ErrorInfo."\r\n";
	    } else {
			$mess .= "success \r\n";
		}
		return $mess . "\r\n";
	}
}