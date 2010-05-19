<?php
/*
 *  ZEND FRAMEWORK PORT FOR OPL <http://www.invenzzia.org>
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
 * The helper broker that manages the available helpers.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View_HelperBroker
{
	/**
	 * The helper list.
	 * @var Array
	 */
	private $_helpers;

	/**
	 * Returns an instance of the helper broker.
	 * @return Invenzzia_View_HelperBroker
	 */
	static public function getInstance()
	{
		if(!Zend_Registry::isRegistered('Invenzzia_View_HelperBroker'))
		{
			$helperBroker = new Invenzzia_View_HelperBroker;
			Zend_Registry::set('Invenzzia_View_HelperBroker', $helperBroker);

			return $helperBroker;
		}
		else
		{
			return Zend_Registry::get('Invenzzia_View_HelperBroker');
		}
	} // end getInstance();

	/**
	 * Adds a new template helper to the system.
	 * @param String $name The helper identifier
	 * @param Invenzzia_View_Helper_Abstract $helper The helper.
	 * @throws Invenzzia_View_Exception
	 */
	public function addHelper($name, Invenzzia_View_Helper_Abstract $helper)
	{
		if(isset($this->_helpers[$name]))
		{
			throw new Invenzzia_View_Exception('The helper \''.$name.'\' is already registered.');
		}
		$this->_helpers[$name] = $helper;
		$helper->initHelper($name);
	} // end addHelper();

	/**
	 * Returns true, if the helper exists.
	 * @param String $name The helper name.
	 * @return Boolean
	 */
	public function hasHelper($name)
	{
		return isset($this->_helpers[$name]);
	} // end hasHelper();

	/**
	 * Removes the helper with the specified name.
	 * @param String $name The helper name.
	 * @throws Invenzzia_View_Exception
	 */
	public function removeHelper($name)
	{
		if(!isset($this->_helpers[$name]))
		{
			throw new Invenzzia_View_Exception('The helper \''.$name.'\' does not exist and cannot be removed.');
		}
		unset($this->_helpers[$name]);
	} // end removeHelper();

	/**
	 * Returns the helper list.
	 * @return Array
	 */
	public function getHelpers()
	{
		return $this->_helpers;
	} // end getHelpers();

	/**
	 * Returns the specified helper.
	 * @param String $helper The helper name
	 * @throws Invenzzia_View_Exception
	 * @return Invenzzia_View_Helper_Abstract
	 */
	public function getHelper($title)
	{
		if(!isset($this->_helpers[$title]))
		{
			throw new Invenzzia_View_Exception('The helper "'.$title.'" does not exist.');
		}
		return $this->_helpers[$title];
	} // end getHelper();

	/**
	 * Returns the specified helper.
	 * @param String $helper The helper name.
	 * @throws Invenzzia_View_Exception
	 * @return Invenzzia_View_Helper_Abstract
	 */
	public function __get($title)
	{
		if(!isset($this->_helpers[$title]))
		{
			throw new Invenzzia_View_Exception('The helper "'.$title.'" does not exist.');
		}
		return $this->_helpers[$title];
	} // end __get();
} // end Invenzzia_View_HelperBroker;
