<?php
/*
 *  OPL PORT FOR ZEND FRAMEWORK <http://www.invenzzia.org>
 *  ======================================================
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) 2009 Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 *
 * $Id$
 * 
 */

/**
 * Provides an singleton construction for the Zend View in order
 * to find it quicker and get the access to Zend helpers.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View extends Zend_View
{
	static private $_instance = null;

	/**
	 * Returns the instance of Zend_View for helper access purposes.
	 *
	 * @static
	 * @return Zend_View
	 */
	static public function getInstance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	} // end getInstance();
} // end Invenzzia_View;
