<?php
/*
 *  OPL PORT FOR ZEND FRAMEWORK <http://www.invenzzia.org>
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) 2009 Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 *
 * $Id: Form.php 37 2010-02-06 07:38:34Z zyxist $
 */

/**
 * The bootstraping class that adds support for OPL view utilities.
 *
 * @author Tomasz Jędrzejewski
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Application_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 * Initializes the Invenzzia stuff.
	 */
	protected function _initInvenzzia()
	{
		// This is needed in order to load Invenzziaresponse
		$this->registerPluginResource(new Invenzzia_Application_Resource_Invenzzialayout());
		$this->registerPluginResource(new Invenzzia_Application_Resource_Invenzziaresponse());

		// And this to load Invenzzialayout
		// I know it is very strange.
		$pluginLoader = $this->getPluginLoader();
		$pluginLoader->addPrefixPath('Invenzzia_Application_Resource', dirname(__FILE__).'/Resource/');

		// Bootstrap that!
		$this->bootstrap('Invenzzialayout');
		$this->bootstrap('Invenzziaresponse');
	} // end _initInvenzzia();
} // end Invenzzia_Application_Bootstrap;