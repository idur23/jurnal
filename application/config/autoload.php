<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('database', 'session', 'form_validation', 'template', 'auth_lib', 'logger_lib');
$autoload['drivers'] = array();
$autoload['helper'] = array('url', 'file', 'form', 'security', 'custom_helper');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array('user_model', 'master_model', 'jurnal_model', 'presensi_model', 'penilaian_model', 'log_model');
