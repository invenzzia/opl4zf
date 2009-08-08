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

class Invenzzia_View_Helper_Title extends Invenzzia_View_Helper_Abstract
{
	/**
	 * The list of title parts
	 * @var Array
	 */
	private $_title = array();

	/**
	 * The title part separator
	 * @var String
	 */
	private $_separator = ' / ';
	/**
	 * The default title used, if the title list is empty.
	 * @var String
	 */
	private $_default = 'Default title';

	/**
	 * Initializes the helper.
	 * @param string $name The helper name given during the registration.
	 */
	public function initHelper($name)
	{
		Opt_View::setFormatGlobal($name, 'InvenzziaDefault/Array', false);
	} // end initHelper();

	/**
	 * Sets the default title
	 * @param String $default The new default title
	 */
	public function setDefaultTitle($default)
	{
		$this->_default = $default;
	} // end setDefaultTitle();

	/**
	 * Appends a new part to the title.
	 *
	 * @param String $title The title part.
	 */
	public function appendTitle($title)
	{
		array_push($this->_title, $title);
	} // end appendTitle();

	/**
	 * Prepends a new part to the title.
	 * @param String $title The title part.
	 */
	public function prependTitle($title)
	{
		array_unshift($this->_title, $title);
	} // end prependTitle();

	/**
	 * Sets the title separator.
	 * @param String $sep The new separator
	 */
	public function setSeparator($sep)
	{
		$this->_separator = $sep;
	} // end setSeparator();

	/**
	 * Resets the title.
	 */
	public function reset()
	{
		$this->_title = array();
	} // end reset();

	/**
	 * Returns the string representation of a title.
	 * @return String
	 */
	public function __toString()
	{
		if(sizeof($this->_title) == 0)
		{
			return $this->_default;
		}
		return implode($this->_separator, $this->_title);
	} // end __toString();

	/**
	 * Returns the string representation of a title.
	 * @return String
	 */
	public function getTitle()
	{
		if(sizeof($this->_title) == 0)
		{
			return $this->_default;
		}
		return implode($this->_separator, $this->_title);
	} // end getTitle();

	/**
	 * Returns the data for OPT sections. Called by the data format.
	 * @return Array
	 */
	public function toArray()
	{
		return $this->_title;
	} // end toArray();

	/**
	 * The hook for the Invenzzia data format
	 * @param Array $section The section data
	 * @return String
	 */
	public function invenzziaSectionHook($section)
	{
		return '$_sect'.$section['name'].'_vals = Opt_View::$_global[\'helper\']->'.$section['name'].'->toArray(); ';
	} // end invenzziaSectionHook();
} // end Invenzzia_View_Helper_Title;