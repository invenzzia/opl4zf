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
 * $Id$
 */

/**
 * The action extender that initializes the view properly, replacing the
 * default Zend Framework support.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Controller_Action extends Zend_Controller_Action
{
	/**
	 * The OPT view.
	 * @var Opt_View
	 */
	public $view;

	/**
	 * The layout manager.
	 * @var Invenzzia_Layout
	 */
	public $layout;

	/**
	 * Initializes the Opt_View object for the action.
	 */
	public function initView()
	{
		$this->view = new Opt_View;
	} // end initView();

	/**
	 * This method is not used with Invenzzia view management.
	 */
	public function render($action = null, $name = null, $noController = false)
	{
		require_once('Invenzzia/Controller/Exception.php');
		throw new Invenzzia_Controller_Exception('Invenzzia_Controller_Action::render() - not supported.');
	} // end render();
} // end Invenzzia_Controller_Action;