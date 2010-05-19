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
 * The implementation of opt:url instruction that helps creating the URL-s
 * using Zend Router.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Opt_Instruction_Url extends Opt_Compiler_Processor
{
	const ROUTING_FUNCTION = 'Invenzzia_View::getInstance()->url';

	/**
	 * Configures the instruction.
	 */
	public function configure()
	{
		$this->_addInstructions(array('opt:url'));
	} // end configure();

	/**
	 * Processes the found OPT-XML node.
	 *
	 * @param Opt_Xml_Node $node The node.
	 */
	public function processNode(Opt_Xml_Node $node)
	{
		// Prevent from adding an attribute to OPT tags
		if(!$node->getParent() instanceof Opt_Xml_Element)
		{
			throw new Opt_InstructionInvalidParent_Exception($node->getXmlName(), 'any non-OPT tag');
		}
		if($this->_compiler->isNamespace($node->getParent()->getNamespace()))
		{
			throw new Opt_InstructionInvalidParent_Exception($node->getXmlName(), 'any non-OPT tag');
		}

		// Parse the instruction attributes
		$params = array(
			'attribute' => array(0 => self::OPTIONAL, self::HARD_STRING, 'href'),
			'route' => array(0 => self::OPTIONAL, self::STRING, null),
			'__UNKNOWN__' => array(0 => self::OPTIONAL, self::EXPRESSION)
		);
		$vars = $this->_extractAttributes($node, $params);

		// Build the code
		$code = 'echo '.self::ROUTING_FUNCTION.'( array (';
		foreach($vars as $name => $value)
		{
			$code .= $name.' => '.$value.',';
		}
		$code .= ')';
		if(!is_null($params['route']))
		{
			$code .= ', '.$params['route'].'); ';
		}

		// Create an attribute for the parent.
		$attribute = new Opt_Xml_Attribute($params['attribute'], null);
		$attribute->addAfter(Opt_Xml_Buffer::ATTRIBUTE_VALUE, $code);

		$node->getParent()->addAttribute($attribute);
	} // end processNode();
} // end Opt_Instruction_Url;