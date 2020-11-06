<?php
defined('BASEPATH') or exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array(
    'database',
    'session',
    'encryption',
    'form_validation',
    'keys_controller',
    'wsdl_controller'
);
$autoload['drivers'] = array();
$autoload['helper'] = array(
    'url',
    'form',
    'date',
    'security',
    'file',
    'download'
);
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array(
    'midware_model',
    'mapping_model'
);
