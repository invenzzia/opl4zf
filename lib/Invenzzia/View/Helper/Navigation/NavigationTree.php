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
 * A navigation tree that allows to generate menus, site maps, etc.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View_Helper_Navigation_NavigationTree extends Invenzzia_View_Helper_Navigation_Abstract
{

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
	 * Creates a data array for the OPT instructions.
	 * @return Array
	 */
	public function toArray()
	{
		if(!$this->_container instanceof Zend_Navigation_Container)
		{
			return array();
		}

		$iterator = new RecursiveIteratorIterator($this->_container, RecursiveIteratorIterator::SELF_FIRST);

		if(is_int($this->_maxDepth))
		{
			$iterator->setMaxDepth($this->_maxDepth);
		}

		$result = array();

		$prevDepth = -1;
		foreach($iterator as $page)
		{
			$depth = $iterator->getDepth();
			$isActive = $page->isActive(true);

			// Pages not accepted or below the minimum depth are not displayed.
			if($depth < $this->_minDepth || !$this->accept($page))
			{
				continue;
			}

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

			// Prepare the result row.
			$result[] = array(
				'depth' => $depth,
				'label' => $label,
				'attr' => array(
					'id' => $page->getId(),
					'title' => $title,
					'href' => $page->getHref(),
					'class' => $page->getClass(),
					'target' => $page->getTarget()
				)
			);
		}
		return $result;
	} // end toArray();


} // end Invenzzia_View_Helper_Navigation_NavigationTree;