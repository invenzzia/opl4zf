<?php
/**
 * A sample application bootstrap file
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

set_include_path(get_include_path().PATH_SEPARATOR.ROOT_DIR.'lib/');

// Use the paths.ini file to configure the paths to your copy
// of OPL libraries. Please remember not to use this particular
// solution in a production environment, but rather specify the
// paths explicitly.
$opl = parse_ini_file(ROOT_DIR.'app/paths.ini', true);

// Load the autoloaders.
require($opl['libraries']['Opl'].'Base.php');

// Autoloader initialization
if(SYSTEM_ENV == 'debug')
{
	Opl_Registry::setState('opl_extended_errors', true);
}
Opl_Loader::loadPaths($opl);
Opl_Loader::addLibrary('Zend', array('directory' => ROOT_DIR.'lib/Zend/', 'handler' => null));
Opl_Loader::addLibrary('Invenzzia', array('directory' => ROOT_DIR.'lib/Invenzzia/', 'handler' => null));
Opl_Loader::register();

try
{
	// Initialize the front controller.
	$front = Zend_Controller_Front::getInstance();
	$front->setParam('noErrorHandler', true);
	$front->throwExceptions(true);
	$front->setControllerDirectory(ROOT_DIR.'app/controllers/');

	// Create the improved response.
	$response = new Invenzzia_Controller_Response_Http;
	$front->setResponse($response);
	
	// Do not forget to disable the default view renderer or we'll get a mess.
	$front->setParam('noViewRenderer', true);
	$front->setParam('disableOutputBuffering', true);

	// Note that OPT is initialized by Invenzzia_Layout, if you haven't done
	// it manually. You can pass the OPT configuration as an array to the
	// startMvc() method.
	$layout = Invenzzia_Layout::startMvc(array('compileMode' => Opt_Class::CM_REBUILD, 'stripWhitespaces'=> false));
	$layout->setViewPaths(ROOT_DIR.'app/views/', ROOT_DIR.'cache/');
	Invenzzia_View_HelperBroker::getInstance()->title->appendTitle('Test');

	// Set up the session
	Zend_Session::start();

	// Connect the layout to the Zend response.
	$layout->setOutput($response);
	$layout->setLayout('layout');

	$front->dispatch();

	// Close the session
	Zend_Session::writeClose();
}
catch(Opt_Exception $exception)
{
	$handler = new Opt_ErrorHandler;
	$handler->display($exception);
}
catch(Opl_Exception $exception)
{
	$handler = new Opl_ErrorHandler;
	$handler->display($exception);
}
catch(Zend_Exception $exception)
{
	$handler = new Invenzzia_ErrorHandler;
	$handler->displayZend($exception);
}