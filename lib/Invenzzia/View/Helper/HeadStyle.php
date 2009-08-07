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
 * A container for HEAD stylesheets.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View_Helper_HeadStyle extends Invenzzia_View_Helper_Container
{
	/**
	 * Accepted attributes
	 *
	 * @var Array
	 */
	protected $_acceptedAttributes = array('type', 'lang', 'dir', 'media', 'title', 'href');

	/**
	 * Initializes the helper.
	 */
	public function initHelper()
	{
		Opt_View::setFormatGlobal('headStyle', 'InvenzziaDefault/Array', false);
	} // end initHelper();

	/**
	 * Prepends a new external script file to the script list. The file is the
	 * remote URL to the script.
	 *
	 * @param String $file Remote URL to the script file
	 * @param String $type Content type
	 * @param Array $options Extra options
	 */
	public function prependFile($file, $type = 'text/css', $options = array())
	{
		$options['href'] = $file;
		$options['type'] = $type;
		$row = array(
			'item' => 'file',
			'file' => $file,
			'attributes' => $this->_filterAttributes($options)
		);
		$this->_prepend('file:'.$file, $row);
	} // end prependFile();

	/**
	 * Appends a new external script file to the script list. The file is the
	 * remote URL to the script.
	 *
	 * @param String $file Remote URL to the script file
	 * @param String $type Content type
	 * @param Array $options Extra options
	 */
	public function appendFile($file, $type = 'text/css', $options = array())
	{
		$options['href'] = $file;
		$options['type'] = $type;
		$row = array(
			'item' => 'file',
			'file' => $file,
			'attributes' => $this->_filterAttributes($options)
		);
		$this->_append('file:'.$file, $row);
	} // end appendFile();

	/**
	 * Sets a new external script file in the specified location of the script list.
	 * The file is the remote URL to the script.
	 *
	 * @param Integer $offset The offset
	 * @param String $file Remote URL to the script file
	 * @param String $type Content type
	 * @param Array $options Extra options
	 */
	public function offsetSetFile($offset, $file, $type = 'text/css', $options = array())
	{
		$options['href'] = $file;
		$options['type'] = $type;
		$row = array(
			'item' => 'file',
			'file' => $file,
			'attributes' => $this->_filterAttributes($options)
		);
		$this->_offsetSet($offset, 'file:'.$file, $row);
	} // end offsetSetFile();

	/**
	 * Prepends a new script to the script list.
	 *
	 * @param String $script The script source
	 * @param String $type Content type
	 * @param Array $options Extra options
	 */
	public function prependStyle($style, $type = 'text/css', $options = array())
	{
		$options['type'] = $type;
		$row = array(
			'item' => 'style',
			'style' => $style,
			'attributes' => $this->_filterAttributes($options)
		);
		$this->_prepend(null, $row);
	} // end prependStyle();

	/**
	 * Appends a new script to the script list.
	 *
	 * @param String $script The script source
	 * @param String $type Content type
	 * @param Array $options Extra options
	 */
	public function appendStyle($style, $type = 'text/css', $options = array())
	{
		$options['type'] = $type;
		$row = array(
			'item' => 'style',
			'style' => $style,
			'attributes' => $this->_filterAttributes($options)
		);
		$this->_append(null, $row);
	} // end appendStyle();

	/**
	 * Sets a new script in the specified location of the script list.
	 *
	 * @param String $script The script source
	 * @param String $type Content type
	 * @param Array $options Extra options
	 */
	public function offsetSetStyle($offset, $style, $type = 'text/css', $options = array())
	{
		$options['type'] = $type;
		$row = array(
			'item' => 'style',
			'style' => $style,
			'attributes' => $this->_filterAttributes($options)
		);
		$this->_offsetSet(null, $row);
	} // end offsetSetStyle();

	/**
	 * Prepends a new template script group to the script list. It can be used only
	 * with template-based rendering.
	 *
	 * @param String $group The group name
	 * @param Array $options Extra options
	 */
	public function prependGroup($group, $options = array())
	{
		if($group == 'file' || $group == 'style')
		{
			throw new Invenzzia_View_Exception('The "'.$group.'" is a reserved group name and cannot be used.');
		}
		$options['item'] = $group;
		$this->_prepend('group:'.$group, $options);
	} // end prependGroup();

	/**
	 * Appends a new template script group to the script list. It can be used only
	 * with template-based rendering.
	 *
	 * @param String $group The group name
	 * @param Array $options Extra options
	 */
	public function appendGroup($group, $options = array())
	{
		if($group == 'file' || $group == 'style')
		{
			throw new Invenzzia_View_Exception('The "'.$group.'" is a reserved group name and cannot be used.');
		}
		$options['item'] = $group;
		$this->_append('group:'.$group, $options);
	} // end appendGroup();

	/**
	 * Sets a new template group in the specified location of the script list.
	 * It can be used only with template-based rendering.
	 *
	 * @param String $group The group name
	 * @param Array $options Extra options
	 */
	public function offsetSetGroup($offset, $group, $options = array())
	{
		if($group == 'file' || $group == 'style')
		{
			throw new Invenzzia_View_Exception('The "'.$group.'" is a reserved group name and cannot be used.');
		}
		$options['item'] = $group;
		$this->_offsetSet($offset, 'group:'.$group, $options);
	} // end offsetSetGroup();

	public function __toString()
	{
		$output = '';
		foreach($this->_elements as $element)
		{
			switch($element['item'])
			{
				case 'file':
					$output .= '<link rel="stylesheet" '.Opt_Function::buildAttributes($element['attributes'])." />\r\n";
					break;
				case 'style':
					$output .= '<style '.Opt_Function::buildAttributes($element['attributes']).'>/* <![CDATA[ */ '.$element['style']." /* ]]> */</style>\r\n";
					break;
				default:
					break;
			}
		}
		return $output;
	} // end __toString();
} // end Invenzzia_View_Helper_HeadStyle;
