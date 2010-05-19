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
 */

/**
 * The form helper instruction.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View_Instruction_Form extends Opt_Compiler_Processor
{
	/**
	 * The processor name
	 * @var string
	 */
	protected $_name = 'zf_form';

	/**
	 * Configures the instruction processor.
	 */
	public function configure()
	{
		$this->_addAttributes(array('zf:form-data'));
	} // end configure();

	/**
	 * Processes the registered attribute.
	 *
	 * @param Opt_Xml_Node $node The node with the attribute.
	 * @param Opt_Xml_Attribute $attr The instruction attribute.
	 */
	public function processAttribute(Opt_Xml_Node $node, Opt_Xml_Attribute $attr)
	{
		$formRecognized = array('method' => true, 'action' => true, 'enctype' => true);

		$attributes = $node->getAttributes();

		foreach($attributes as $attribute)
		{
			if(isset($formRecognized[$attribute->getName()]))
			{
				unset($formRecognized[$attribute->getName()]);
			}
		}

		// Compile the form data expression
		$expr = $this->_compiler->compileExpression((string)$attr, false, Opt_Compiler_Class::ESCAPE_OFF);
		$code = 'if(is_array('.$expr[0].')){ ';
		foreach($formRecognized as $name => $void)
		{
			if($name == 'action')
			{
				$code .= ' if(!empty('.$expr[0].'[\''.$name.'\'])){	echo \' '.$name.'="\'.Invenzzia_View_Functions::url('.$expr[0].'[\''.$name.'\']).\'"\'; } ';
			}
			else
			{
				$code .= ' if(!empty('.$expr[0].'[\''.$name.'\'])){	echo \' '.$name.'="\'.'.$expr[0].'[\''.$name.'\'].\'"\'; } ';
			}
		}
		$code .= ' } ';

		$node->addAfter(Opt_Xml_Buffer::TAG_ENDING_ATTRIBUTES, $code);
	} // end _processAttribute();
} // end Invenzzia_View_Instruction_Form;