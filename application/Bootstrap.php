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
 * $Id: ErrorHandler.php 20 2009-08-10 17:53:34Z zyxist $
 */

/**
 * The bootstraping utility. In order to use the OPL port
 * for Zend Framework, we have to extend Invenzzia_Application_Bootstrap.
 */
class Bootstrap extends Invenzzia_Application_Bootstrap
{
	/**
	 * This bootstraping hook initializes some view helpers
	 * provided by the port.
	 */
	public function _initInvenzziaHelpers()
	{
		// Ensure that all the dependencies are loaded.
		$this->bootstrap('invenzzia');

		// Configure the title helper
		$title = Invenzzia_View_HelperBroker::getInstance()->title;
		$title->setDefaultTitle('ZF+OPTv2 demo');
		$title->appendTitle('ZF+OPTv2 demo');

		// Configure the HeadStyle helper
		$headStyle = Invenzzia_View_HelperBroker::getInstance()->headStyle;
		$headStyle->appendGroup('standard');
	} // end _initInvenzziaHelpers();

} // end _initHelpers();

