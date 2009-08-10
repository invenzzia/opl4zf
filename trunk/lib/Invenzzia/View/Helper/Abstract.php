<?php
/*
 *  ZEND FRAMEWORK PORT FOR OPL <http://www.invenzzia.org>
 *  ======================================================
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) 2009 Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 *
 * $Id: Container.php 11 2009-07-21 09:48:19Z zyxist $
 */

/**
 * The abstract class for the view helpers.
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
abstract class Invenzzia_View_Helper_Abstract
{
	
	/**
	 * The method is executed during the helper registration.
	 *
	 * @param string $name The helper name given during the registration.
	 */
	public function initHelper($name)
	{
		/* null */
	} // end initHelper();

} // end Invenzzia_View_Helper_Abstract;