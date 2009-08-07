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
 * $Id: Url.php 11 2009-07-21 09:48:19Z zyxist $
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

	protected $_properties = array(
		'variable:assign' => false,
		'item:assign' => false,
		'section:itemAssign' => false
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
			$section = $this->_getVar('section');

			if(!is_object($this->_decorated))
			{
				throw new Opt_FormatNotDecorated_Exception('InvenzziaDefault');
			}

			// It is used for certain section types only.
			switch($section['name'])
			{
				case 'headStyle':
					return '$_sect'.$section['name'].'_vals = Opt_View::$_global[\'helper\']->headStyle->toArray(); ';
				case 'headScript':
					return '$_sect'.$section['name'].'_vals = Opt_View::$_global[\'helper\']->headScript->toArray(); ';
				case 'title':
					return '$_sect'.$section['name'].'_vals = Opt_View::$_global[\'helper\']->title->toArray(); ';
			}
		}
		elseif($hookName == 'variable:main')
		{
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
			return '->'.$this->_getVar('item');
		}
	} // end _build();
} // end Opt_Compiler_Format;