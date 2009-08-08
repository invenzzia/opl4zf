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
 * The breadcrumb generator
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View_Helper_Navigation_Breadcrumbs extends Invenzzia_View_Helper_Navigation_Abstract
{
	/**
	 * The separator used in the automated rendering.
	 * @var string
	 */
	private $_separator = '';

	/**
	 * The properties accessible via getters and setters.
	 * @var Array
	 */
	protected $_accessibleValues = array(
		'minDepth', 'maxDepth', 'separator'
	);

	/**
	 * Initializes the helper.
	 * @param string $name The helper name given during the registration.
	 */
	public function initHelper($name)
	{
		Opt_View::setFormatGlobal('helper.'.$name, 'Objective', false);
		Opt_View::setFormatGlobal($name, 'InvenzziaDefault/Array', false);
	} // end initHelper();

	/**
	 * Sets the new separator.
	 * @param String $separator The new separator.
	 */
	public function setSeparator($separator)
	{
		$this->_separator = (string)$separator;
	} // end setSeparator();

	/**
	 * Returns the current separator.
	 *
	 * @return string
	 */
	public function getSeparator()
	{
		return $this->_separator;
	} // end getSeparator();

	/**
	 * Returns the auto-generated HTML for the breadcrumbs
	 *
	 * @return string
	 */
	public function __toString()
	{
		$results = $this->toArray();

		$output = '';
		foreach($results as $result)
		{
			if($result['item'] == 'default')
			{
				$output .= '<a '.Opt_Function::buildAttributes($result['attr']).'>'.$result['label'].'</a>'.$this->_separator;
			}
			else
			{
				$output .= $result['label'];
			}
		}
		return $output;
	} // end __toString();

	/**
	 * Returns the data for the breadcrumb generator.
	 * @return Array
	 */
	public function toArray()
	{
		if(!$active = $this->findActive($this->_container))
		{
			return array();
		}
		else
		{
			$active = $active['page'];
		}

		$result = array();
		$result[] = $this->_createRow($active, 'current');

		while($parent = $active->getParent())
		{
			if($parent instanceof Zend_Navigation_Page)
			{
				$result[] = $this->_createRow($parent, 'default');
			}
			if($parent === $this->_container)
			{
				break;
			}
			$active = $parent;
		}
		return array_reverse($result);
	} // end toArray();

	/**
	 * Creates a breadcrumb row for the result array.
	 * @param Zend_Navigation_Page $page The page to convert.
	 * @param String $item The item name used by opt:selector
	 * @return Array
	 */
	protected function _createRow(Zend_Navigation_Page $page, $item)
	{
		// Perform translation transformations
		$label = $page->getLabel();
		$title = $page->getTitle();
		if($this->_translator !== null)
		{
			if(is_string($label) && !empty($label))
			{
				$label = $this->_translator->_($label);
			}
			if(is_string($title) && !empty($title))
			{
				$title = $this->_translator->_($title);
			}
		}

		// Return the row.
		return array(
			'item' => $item,
			'label' => $label,
			'attr' => array(
				'id'	=> $page->getId(),
				'title'	=> $title,
				'href'	=> $page->getHref(),
				'target'	=> $page->getTarget(),
				'class' => $page->getClass()
			)
		);
	} // end _createRow();
} // end Invenzzia_View_Helper_Navigation_Breadcrumbs;