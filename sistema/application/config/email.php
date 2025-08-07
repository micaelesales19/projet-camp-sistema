<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Email

*/
$config['smtp_host'] = 'smtp.hostinger.com';
$config['smtp_port'] = 587;
$config['smtp_user'] = 'camp@campbrasil.com'; 
$config['smtp_pass'] = 'campBR202@';
$config['protocol']  = 'smtp';
$config['validate']  = TRUE;
$config['mailtype']  = 'html';
$config['charset']   = 'utf-8';
$config['wordwrap']   = TRUE;
$config['newline']   = "\r\n";