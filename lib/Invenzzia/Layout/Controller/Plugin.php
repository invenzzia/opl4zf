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
 * $Id$
 */

/**
 * An implementation of the controller plugin that introduces the
 * OPL views to the Zend Framework
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Layout_Controller_Plugin extends Zend_Controller_Plugin_Abstract
{
	/**
	 * Dispatch loop shutdown action.
	 */
	public function dispatchLoopShutdown()
	{
		$layout = Invenzzia_Layout::getMvcInstance();
		$layout->render();
	} // end dispatchLoopShutdown();
} // end Invenzzia_Layout_Controller_Plugin;
