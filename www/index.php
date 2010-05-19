<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/** Open Power Libs */
$opl = parse_ini_file('../paths.ini', true);
require($opl['libraries']['Opl'].'Base.php');
Opl_Loader::setHandleUnknownLibraries(false);
Opl_Loader::addLibrary('Opl', array('directory' => $opl['libraries']['Opl']));
Opl_Loader::addLibrary('Opt', array('directory' => $opl['libraries']['Opt']));
Opl_Loader::addLibrary('Invenzzia', array('directory' => $opl['libraries']['Invenzzia'], 'handler' => null));
Opl_Loader::register();

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../lib'),
	'/home/zyxist/Projekty/Zfport_trunk/lib',
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()
            ->run();