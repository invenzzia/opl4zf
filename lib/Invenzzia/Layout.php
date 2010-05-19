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
 *
 */

/**
 * Provides layout support for MVC applications.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Layout
{
	/**
	 * MVC instance of Invenzzia_Layout
	 * @static
	 * @var Invenzzia_Layout
	 */
	static private $_mvc = null;

	/**
	 * The placeholder list with the views.
	 * @var Array
	 */
	private $_placeholders = array();

	/**
	 * Layout services enabled?
	 * @var Opt_View
	 */
	private $_layout = null;

	/**
	 * OPT Output System
	 * @var Opt_Output_Interface
	 */
	private $_output = null;

	/**
	 * Controller plugin object.
	 * @var Invenzzia_Layout_Controller_Plugin
	 */
	private $_plugin = null;

	/**
	 * Layout name.
	 * @var String
	 */
	private $_layoutName = 'layout';

	/**
	 * Re-throw exceptions or not?
	 * @var boolean
	 */
	private $_throwExceptions = false;


	/**
	 * Initializes Invenzzia_Layout with MVC support.
	 *
	 * @static
	 * @param String|Array|Zend_Config $config
	 * @return Invenzzia_Layout
	 */
	static public function startMvc($config = null)
	{
		if(is_object(self::$_mvc))
		{
			return self::$_mvc;
		}
		self::$_mvc = new Invenzzia_Layout;

		// Register helpers, etc.
		if(Zend_Controller_Action_HelperBroker::hasHelper('layout'))
		{
			Zend_Controller_Action_HelperBroker::removeHelper('layout');
		}
		
		Zend_Controller_Action_HelperBroker::addHelper(new Invenzzia_Layout_Controller_Action_Helper);

		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(self::$_mvc->_plugin = new Invenzzia_Layout_Controller_Plugin);

		// Register OPT stuff
		if(Opl_Registry::exists('opt'))
		{
			$opt = Opl_Registry::get('opt');
		}
		else
		{
			$opt = new Opt_Class;
		}
		if(!is_null($config))
		{
			if(is_array($config) || is_string($config))
			{
				$opt->loadConfig($config);
			}
			elseif($config instanceof Zend_Config)
			{
				foreach($config as $name=>$value)
				{
					$opt->$name = $value;
				}
			}
		}
		Invenzzia_View::initOpt($opt);

		return self::$_mvc;
	} // end startMvc();

	/**
	 * Returns an MVC instance of Invenzzia_Layout object.
	 * 
	 * @static
	 * @return Invenzzia_Layout|null
	 */
	static public function getMvcInstance()
	{
		return self::$_mvc;
	} // end getInstance();

	/**
	 * Unregisters everything and destroys MVC layout instance.
	 *
	 * @static
	 */
	static public function resetMvcInstance()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->unregisterPlugin($this->_plugin);

		if(Zend_Controller_Action_HelperBroker::hasHelper('layout'))
		{
			Zend_Controller_Action_HelperBroker::removeHelper('layout');
		}

		self::$_mvc = null;
	} // end resetMvcInstance();

	/**
	 * Disables the layout services. The programmer must render the views
	 * manually. Implements fluent interface.
	 * 
	 * @return Invenzzia_Layout Fluent interface.
	 */
	public function disableLayout()
	{
		$this->_layout = null;

		return $this;
	} // end disableLayout();

	/**
	 * Enables the layout services. Implements
	 * fluent interface.
	 *
	 * @return Invenzzia_Layout Fluent interface.
	 */
	public function enableLayout()
	{
		$opt = Opl_Registry::get('opt');
		self::$_mvc->_layout = new Opt_View($this->_layoutName);

		return $this;
	} // end enableLayout();

	/**
	 * Allows to disable or enable throwing exceptions. If the
	 * OPT exceptions are not thrown, the layout automatically captures
	 * them and displays using the standard OPT error handler. Implements
	 * fluent interface.
	 *
	 * @param boolean $state Throw exception state.
	 * @return Invenzzia_Layout Fluent interface.
	 */
	public function setThrowExceptions($state)
	{
		$this->_throwExceptions = (boolean)$state;

		return $this;
	} // end setThrowExceptions();

	/**
	 * Returns the current throw exception state.
	 *
	 * @return boolean The current throw exception state.
	 */
	public function getThrowExceptions()
	{
		return $this->_throwExceptions;
	} // end getThrowExceptions();

	/**
	 * Sets the paths to the view templates. The arguments are
	 * compatible with the semantics of Open Power Template
	 * sourceDir and compileDir arguments.
	 *
	 * @param String|Array $sourceDir Template source directory.
	 * @param String $compileDir Compiled template directory
	 * @return Invenzzia_Layout
	 */
	public function setViewPaths($sourceDir, $compileDir)
	{
		$opt = Opl_Registry::get('opt');
		$opt->sourceDir = $sourceDir;
		$opt->compileDir = $compileDir;

		return $this;
	} // end setViewPaths();

	/**
	 * Returns the main layout view object.
	 *
	 * @return Opt_View
	 */
	public function getLayout()
	{
		return $this->_layout;
	} // end getLayoutView();

	/**
	 * Initializes the layout.
	 *
	 * @param String $layout Layout name
	 * @return Opt_View
	 */
	public function setLayout($name)
	{
		$this->_layoutName = $name;

		if(!is_null($this->_layout))
		{
			$this->_layout->setTemplate($name.'.tpl');
		}
		else
		{
			$this->_layout = new Opt_View($name.'.tpl');
		}
	} // end setLayout();

	/**
	 * Returns action view list for the specified placeholder.
	 *
	 * @param String $placeholder optional The placeholder name ("content" by default).
	 * @return Array
	 */
	public function getViews($placeholder = 'content')
	{
		if(!isset($this->_placeholders[$placeholder]))
		{
			return array();
		}
		return $this->_placeholders[$placeholder];
	} // end getActionViews();

	/**
	 * Appends a new view to the placeholder.
	 *
	 * @param Opt_View $view View object.
	 * @param String $placeholder optional Placeholder name.
	 * @return Invenzzia_Layout
	 */
	public function appendView(Opt_View $view, $placeholder = 'content')
	{
		if(!isset($this->_placeholders[$placeholder]))
		{
			$this->_placeholders[$placeholder] = array();
		}
		$this->_placeholders[$placeholder][] = $view;
		
		// Save the used placeholder.
		$view->placeholder = $placeholder;

		return $this;
	} // end appendView();

	/**
	 * Prepends a new view to the placeholder.
	 *
	 * @param Opt_View $view View object.
	 * @param String $placeholder optional Placeholder name.
	 * @return Invenzzia_Layout
	 */
	public function prependView(Opt_View $view, $placeholder = 'content')
	{
		if(!isset($this->_placeholders[$placeholder]))
		{
			$this->_placeholders[$placeholder] = array();
		}
		array_unshift($this->_placeholders[$placeholder], $view);

		// Save the used placeholder.
		$view->placeholder = $placeholder;

		return $this;
	} // end prependView();

	/**
	 * Sets the OPT output system used to render the page.
	 *
	 * @param Opt_Output_Interface $output New output interface
	 */
	public function setOutput(Opt_Output_Interface $output)
	{
		$this->_output = $output;
	} // end setOutput();

	/**
	 * Returns the current output system used to render the page.
	 *
	 * @return Opt_Output_Interface
	 */
	public function getOutput()
	{
		if(is_null($this->_output))
		{
			$this->_output = new Opt_Output_Http;
		}

		return $this->_output;
	} // end getOutput();

	/**
	 * Renders the views and sends the result to the specified output
	 * system.
	 *
	 * @return Boolean
	 */
	public function render()
	{
		if(!is_object($this->_layout))
		{
			return false;
		}

		$opt = Opl_Registry::get('opt');
		$opt->setup();

		if(is_null($this->_output))
		{
			$this->_output = new Opt_Output_Http;
		}
		foreach($this->_placeholders as $name => &$placeholder)
		{
			$data = array();
			foreach($placeholder as $view)
			{
				$data[] = array('view' => $view);
			}
			$this->_layout->assign($name, $data);
		}
		try
		{
			$this->_output->render($this->_layout);
		}
		catch(Opt_Exception $exception)
		{
			if($this->_throwExceptions)
			{
				throw $exception;
			}
			$h = new Opt_ErrorHandler;
			$h->display($exception);
		}

		return true;
	} // end render();
} // end Invenzzia_Layout;
