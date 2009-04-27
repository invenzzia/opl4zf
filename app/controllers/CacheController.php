<?php
/**
 * A sample index controller.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class CacheController extends Invenzzia_Controller_Action
{
	public function cachedAction()
	{
		$frontendOptions = array(
		   'lifetime' => 40,                   // cache lifetime of 30 seconds
		   'automatic_serialization' => false  // this is the default anyways
		);

		$backendOptions = array('cache_dir' => '../cache/');

		$this->view->setCache(new Invenzzia_Cache_Wrapper(Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions)));
	} // end cachedAction();

} // end CacheController;