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
 * The default data format for OPT.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View_Format_Default extends Opt_Compiler_Format
{
	/**
	 * What we can manipulate...
	 * @var Array
	 */
	protected $_supports = array(
		'section', 'variable', 'item'
	);

	/**
	 * The properties of the data format.
	 * @var Array
	 */
	protected $_properties = array(
		'variable:assign' => false,		// Disable the assign operator for variables
		'item:assign' => false,			// Disable the assign operator for variable items
		'section:itemAssign' => false	// Disable the assign operator for the section items
	);

	/**
	 * The manipulator. It returns a PHP code snippet for the specified hook.
	 * 
	 * @param String $hookName The hook name
	 * @return String
	 */
	protected function _build($hookName)
	{
		if($hookName == 'section:init')
		{
			// The section initializer, it forces the section to call the helper broker
			// in order to get the data from the specified helper.
			$section = $this->_getVar('section');

			if(!is_object($this->_decorated))
			{
				throw new Opt_FormatNotDecorated_Exception('InvenzziaDefault');
			}

			// It is used for certain section types only.
			$helperBroker = Invenzzia_View_HelperBroker::getInstance();
			if($helperBroker->hasHelper($section['name']))
			{
				$helper = $helperBroker->getHelper($section['name']);
				if(method_exists($helper, 'invenzziaSectionHook'))
				{
					return $helper->invenzziaSectionHook($section);
				}
			}
		}
		elseif($hookName == 'variable:main')
		{
			// The access to the 'helper' variable
			$this->_applyVars = false;
			$item = $this->_getVar('item');
			if($item != 'helper')
			{
				throw new Opt_NotSupported_Exception('$'.$item, 'InvenzziaDefault format refuses to handle it.');
			}

			return 'Opt_View::$_global[\'helper\']';
		}
		elseif($hookName == 'item:item')
		{
			// The access to the 'helper' variable subitems.
			return '->'.$this->_getVar('item');
		}
	} // end _build();

	/**
	 * The action decorator.
	 *
	 * @param String $name Action name.
	 */
	public function action($name)
	{
		if(!is_object($this->_decorated))
		{
			throw new Opt_FormatNotDecorated_Exception('InvenzziaDefault');
		}
		$this->_decorated->action($name);
	} // end action();
} // end Opt_Compiler_Format;