<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package Codeigniter
 * @subpackage Email
 * @category Config
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

$config['useragent'] = 'MedanSoftware';
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.medansoftware.my.id';
$config['smtp_user'] = 'no-reply@medansoftware.my.id';
$config['smtp_pass'] = 'ScjLjNmT2s4I';
$config['smtp_port'] = 465;
$config['smtp_timeout'] = 6;
$config['smtp_keepalive'] = FALSE;
$config['smtp_crypto'] = 'ssl';
$config['wordwrap'] = TRUE;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['validate'] = TRUE;
$config['priority'] = 3;

/* End of file email.php */
/* Location : ./application/config/email.php */