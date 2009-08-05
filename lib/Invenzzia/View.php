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
class Invenzzia_View
{
	/**
	 * The helper list.
	 * @static
	 * @var Array
	 */
	static private $_helpers = array();

	/**
	 * Zend_View used for obtaining helpers.
	 * @static
	 * @var Zend_View
	 */
	static private $_zendView;

	/**
	 * Initializes the OPT main object.
	 * @static
	 * @param Opt_Class $opt The main object to initialize.
	 */
	static public function initOpt(Opt_Class $opt)
	{
		Opl_Loader::mapAbsolute('Opt_Instruction_Url', 'Invenzzia/View/Url.php');
		$opt->register(Opt_Class::OPT_INSTRUCTION, 'Url');
		$opt->register(Opt_Class::PHP_FUNCTION, 'printf', 'sprintf');
		$opt->register(Opt_Class::PHP_FUNCTION, 'url', 'Invenzzia_View_Functions::url');
		$opt->register(Opt_Class::PHP_FUNCTION, 'zend', 'Invenzzia_View::getZendView');

		self::$_helpers['title'] = new Invenzzia_View_Helper_Title;
		self::$_helpers['headscript'] = new Invenzzia_View_Helper_HeadScript;
		self::$_helpers['headstyle'] = new Invenzzia_View_Helper_HeadStyle;
	} // end initOpt();

	/**
	 * Gets the Zend_View object.
	 * @static
	 * @return Zend_View
	 */
	static public function getZendView()
	{
		if(self::$_zendView === null)
		{
			self::$_zendView = new Zend_View();
		}
		return self::$_zendView;
	} // end getZendView();

	/**
	 * Sets the translation interface.
	 * @static
	 * @param Zend_Translate $translation
	 */
	static public function setTranslation(Zend_Translate $translation = null)
	{
		$opt = Opl_Registry::get('opt');
		if($translation === null)
		{
			$opt->backticks = null;
		}
		else
		{
			$opt->backticks = array($translation, '_');
		}
	} // end setTranslation();

	/**
	 * Sets the navigation object
	 * @static
	 * @param Zend_Navigation_Container $container
	 */
	static public function setNavigation(Zend_Navigation_Container $container = null)
	{
		Opt_View::assign('navigation', $container);
	} // end setNavigation();

	/**
	 * Adds a new template helper to the system.
	 *
	 * @static
	 * @param String $name The helper identifier
	 * @param Object $helper The helper.
	 */
	static public function addHelper($name, $helper)
	{
		self::$_helpers[$name] = $helper;
	} // end addHelper();

	/**
	 * Returns the helper list.
	 * @static
	 * @return Array
	 */
	static public function getHelpers()
	{
		return self::$_helpers;
	} // end getHelpers();

	/**
	 * Returns the specified helper.
	 * @static
	 * @param String $helper The helper name
	 * @return Object
	 */
	static public function getHelper($title)
	{
		if(!isset(self::$_helpers[$title]))
		{
			throw new Invenzzia_View_Exception('The helper "'.$title.'" does not exist.');
		}
		return self::$_helpers[$title];
	} // end getHelper();
} // end Invenzzia_View;
