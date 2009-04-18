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
 * The class is a OPT component wrapper for Zend form helpers.
 * It allows to use the component features to customize the
 * look of the form elements.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Form_Component implements Opt_Component_Interface
{
	/**
	 * OPT View.
	 * @var Opt_View
	 */
	private $_view;
	/**
	 * Form element
	 * @var Zend_Form_Element
	 */
	private $_formElement;

	/**
	 * Extra component params.
	 * @var Array
	 */
	private $_params = array();

	/**
	 * Form component constructor. Not used.
	 *
	 * @param String $name Not used
	 */
	public function __construct($name = '')
	{
		/* null */
	} // end __construct();

	/**
	 * Initializes the component for the specified form element.
	 *
	 * @param Zend_Form_Element $formElement
	 */
	public function init(Zend_Form_Element $formElement)
	{
		$this->_formElement = $formElement;

		$this->_params = array(
			'label' => $formElement->getLabel(),
			'description' => '',
			'name' => $formElement->getName(),
			'id' => 'f_'.$formElement->getName()
		);

		if(!is_null($formElement->getDescription()))
		{
			$this->_params['description'] = $formElement->getDescription();
		}
	} // end init();

	/**
	 * Loads the rendered OPT view.
	 *
	 * @param Opt_View $tpl
	 */
	public function setView(Opt_View $view)
	{
		$this->_view = $view;
	} // end setView();

	/**
	 * Datasources - not used.
	 *
	 * @param Mixed $data
	 */
	public function setDatasource(&$data)
	{
		/* null */
	} // end setDatasource();

	/**
	 * Setting parameters - not used.
	 *
	 * @param String $name
	 * @param Mixed $value
	 */
	public function set($name, $value)
	{
		/* null */
	} // end set();

	/**
	 * Returns the specified parameter value
	 *
	 * @param String $name Parameter name
	 * @return Mixed
	 */
	public function get($name)
	{
		if(isset($this->_params[$name]))
		{
			return $this->_params[$name];
		}
		return NULL;
	} // end get();

	/**
	 * Returns true if the parameter is already defined.
	 *
	 * @param String $name Parameter name
	 * @return Boolean
	 */
	public function defined($name)
	{
		return isset($this->_params[$name]);
	} // end defined();

	/**
	 * Displays the component in the template.
	 *
	 * @param Array $attributes opt:display tag attributes.
	 */
	public function display($attributes = array())
	{
		$layout = Invenzzia_Layout::getMvcInstance();
		$zendView = Invenzzia_View::getInstance();

		$helper = $this->_formElement->helper;
		$helper2 = substr($helper, 4, strlen($helper)-4);
		$opt = Opl_Registry::get('opt');

		// Get the helper style.
		if($this->_formElement->hasErrors())
		{
			$style = Opt_View::getTemplateVar('formStyle'.ucfirst($helper2).'Invalid');
		}
		else
		{
			$style = Opt_View::getTemplateVar('formStyle'.ucfirst($helper2).'Valid');
		}
		if(!is_null($style) && !isset($attributes['class']))
		{
			$attributes['class'] = $style;
		}
		$attributes['id'] = 'f_'.$this->_formElement->getName();

		if($this->_formElement instanceof Zend_Form_Element_Multi)
		{
			echo $zendView->$helper($this->_formElement->getName(), $this->_formElement->getValue(), $attributes, $this->_formElement->getMultiOptions());
		}
		else
		{
			echo $zendView->$helper($this->_formElement->getName(), $this->_formElement->getValue(), $attributes, array());
		}
	} // end display();

	/**
	 * Fires various events. Here, only "error" is supported.
	 * Returns true if the specified event occurs.
	 *
	 * @param String $name Event name
	 * @return Boolean
	 */
	public function processEvent($name)
	{
		if($name == 'error')
		{
			if($this->_formElement->hasErrors())
			{
				$messages = array();
				foreach($this->_formElement->getMessages() as $msg)
				{
					$messages[] = $msg;
				}
				$this->_view->componentErrors = $messages;
				return true;
			}
		}
		return false;
	} // end processEvent();

	/**
	 * Manages the attributes of the XML tags with the com: namespace
	 * and returns the modified list of attributes.
	 *
	 * @param String $tagName Tag name
	 * @param Array $attributes The current list of attributes.
	 * @return Array
	 */
	public function manageAttributes($tagName, Array $attributes)
	{
		if($tagName == 'div' || $tagName == 'tr')
		{
			if($this->_formElement->hasErrors())
			{
				$style = Opt_View::getTemplateVar('formStyleInvalid');
				if(!is_null($style))
				{
					$attributes['class'] = $style;
				}
			}
		}
		return $attributes;
	} // end createAttribute();
} // end Invenzzia_Form_Component;
