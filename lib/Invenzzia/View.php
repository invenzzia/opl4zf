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
		$opt->register(Opt_Class::OPT_FORMAT, 'InvenzziaDefault', 'Invenzzia_View_Format_Default');
		$opt->register(Opt_Class::PHP_FUNCTION, 'printf', 'sprintf');
		$opt->register(Opt_Class::PHP_FUNCTION, 'url', 'Invenzzia_View_Functions::url');
		$opt->register(Opt_Class::PHP_FUNCTION, 'zend', 'Invenzzia_View::getZendView');

		$helperBroker = Invenzzia_View_HelperBroker::getInstance();
		$helperBroker->addHelper('title', new Invenzzia_View_Helper_Title);
		$helperBroker->addHelper('headScript', new Invenzzia_View_Helper_HeadScript);
		$helperBroker->addHelper('headStyle', new Invenzzia_View_Helper_HeadStyle);
		$helperBroker->addHelper('flashMessage', new Invenzzia_View_Helper_FlashMessage);
		$helperBroker->addHelper('breadcrumbs', new Invenzzia_View_Helper_Navigation_Breadcrumbs);
		$helperBroker->addHelper('navigationTree', new Invenzzia_View_Helper_Navigation_NavigationTree);

		Opt_View::assignGlobal('helper', $helperBroker);
		Opt_View::setFormatGlobal('helper', 'InvenzziaDefault', false);
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
} // end Invenzzia_View;
