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
 * A helper for flash messages
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View_Helper_FlashMessage extends Invenzzia_View_Helper_Abstract
{
	/**
	 * The flash message to display.
	 * @var String
	 */
	private $_message = null;
	/**
	 * The session namespace.
	 * @var String
	 */
	private $_namespace = 'flash';

	/**
	 * Initializes the helper.
	 * @param string $name The helper name given during the registration.
	 */
	public function initHelper($name)
	{
		Opt_View::setFormatGlobal('helper.'.$name, 'Objective', false);
	} // end initHelper();

	/**
	 * Sets the session namespace.
	 * @param String $namespace The namespace
	 */
	public function setSessionNamespace($namespace)
	{
		$this->_namespace = $namespace;
	} // end setSessionNamespace();

	/**
	 * Assigns the new message to the flash buffer.
	 * @param String $message The message to display.
	 * @param String|Array $redirect The place to redirect us to.
	 * @param String $routeName The route name used with the router.
	 */
	public function setMessage($message, $redirect = null, $routeName = null)
	{
		$namespace = new Zend_Session_Namespace($this->_namespace);
		$namespace->message = $message;

		// We can optionally redirect the user and even use the router.
		if($redirect !== null)
		{
			if(is_string($redirect))
			{
				Zend_Session::writeClose();
				header('Location: '.$redirect);
			}
			elseif(is_array($redirect))
			{
				Zend_Session::writeClose();
				$router = Zend_Controller_Front::getInstance()->getRouter();
				if($routeName !== null)
				{
					header('Location: '.$router->assemble($redirect, $routeName));
				}
				else
				{
					header('Location: '.$router->assemble($redirect));
				}
			}
		}
	} // end setMessage();

	/**
	 * Returns the information about the flash buffer. Possible values are:
	 *
	 * - hasMessage - true, if there is a message in the buffer.
	 * - message - the message content.
	 * 
	 * @param String $name The identifier
	 * @return Mixed
	 */
	public function __get($name)
	{
		if($this->_message === null)
		{
			$namespace = new Zend_Session_Namespace($this->_namespace);
			if(isset($namespace->message))
			{
				$this->_message = (is_string($namespace->message) ? $namespace->message : false);
			}
			else
			{
				$this->_message = false;
			}
			$namespace->message = false;
		}
		switch($name)
		{
			case 'hasMessage':
				return ($this->_message !== false);
			case 'message':
				return $this->_message;
		}
		return NULL;
	} // end __get();
} // end Invenzzia_View_Helper_FlashMessage;
