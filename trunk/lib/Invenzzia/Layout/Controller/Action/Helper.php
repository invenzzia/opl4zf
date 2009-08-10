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
 * The action helper that initializes the action views etc.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Layout_Controller_Action_Helper extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Currently dispatched controller
	 * @var String
	 */
	private $_lastController;
	/**
	 * Currently dispatched controller
	 * @var String
	 */
	private $_lastAction;

	/**
	 * Returns the helper name.
	 * 
	 * @return String
	 */
	public function getName()
	{
		return 'layout';
	} // end getName();

	/**
	 * The code executed before the action dispatch.
	 */
	public function preDispatch()
	{
		$this->_actionController->initView();
		
		// We have to store the values here, because forwarding overwrites
		// the request settings.
		$request = $this->getRequest();
		$this->_lastAction = $request->getActionName();
		$this->_lastController = $request->getControllerName();
	} // end preDispatch();

	/**
	 * The code executed after the action dispatch.
	 */
	public function postDispatch()
	{
		// Non-OPT views are ignored.
		if(! $this->_actionController->view instanceof Opt_View)
		{
			return;
		}
		// Set the default name, if not specified.
		if($this->_actionController->view->getTemplate() == '')
		{
			$request = $this->getRequest();
			$this->_actionController->view->setTemplate(strtolower($this->_lastController).'/'.strtolower($this->_lastAction).'.tpl');
		}
		// If it has been already added somewhere, skip.
		if(!is_null($this->_actionController->view->placeholder))
		{
			return;
		}

		// Add the view object to the default placeholder.
		$layout = Invenzzia_Layout::getMvcInstance();
		$layout->appendView($this->_actionController->view);
	} // end postDispatch();

} // end Invenzzia_Layout_Controller_Action_Helper;