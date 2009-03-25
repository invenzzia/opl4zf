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
 */

/**
 * The fixation for the Zend_Form that allows to cooperate with
 * Open Power Template views.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Form extends Zend_Form
{
	/**
	 * The internal ZF method to render the form. Here,
	 * prepares the form elements to be sent to the template.
	 *
	 * @param Opt_View $view OPT View
	 */
	public function render(Opt_View $view)
	{
		$fields = array();
		foreach($this->_elements as $element)
		{
			$component = new Invenzzia_Form_Component();
			$component->init($element);

			$fields[] = array(
				'component' => $component,
			);
		}
		$view->assign('form', array(
			'fields' => $fields,
			'action' => $this->getAction(),
			'method' => $this->getMethod()
		));
	} // end render();

	/**
	 * Allows to remove a group of elements much faster. They are simply
	 * passed as the method arguments.
	 *
	 * @param ... The elements to be removed.
	 */
	public function removeElements()
	{
		$args = func_get_args();
		foreach($args as $element)
		{
			$this->removeElement($element);
		}
	} // end removeElements();
} // end Invenzzia_Form;
