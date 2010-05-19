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
 * An extension to the default Zend HTTP response that implements the OPT
 * output system, so that it is able to render OPT views.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Controller_Response_Http extends Zend_Controller_Response_Abstract implements Opt_Output_Interface
{
	/**
	 * The template mode used by OPT.
	 * @var Integer
	 */
	private $_templateMode = null;

	/**
	 * Returns the output system name.
	 *
	 * @return String
	 */
	public function getName()
	{
		return 'Zend_HTTP';
	} // end getName();

	/**
	 * Renders the specified OPT view.
	 *
	 * @param Opt_View $view OPT View.
	 * @param Opt_Cache_Hook_Interface|null $cache Optional caching system.
	 */
	public function render(Opt_View $view)
	{
		if(is_null($this->_templateMode))
		{
			$this->_templateMode = $view->getMode();
			ob_start();
		}
		elseif($this->_templateMode == Opt_Class::XML_MODE)
		{
			throw new Opt_OutputOverloaded_Exception;
		}
		$result = $view->_parse($this, $this->_templateMode);
		$this->setBody(ob_get_clean());

		return $result;
	} // end render();

	/**
	 * Not used - throws an exception.
	 *
	 * @param Void $content
	 * @param Void $name optional
	 */
	public function appendBody($content, $name = null)
	{
		/* null */
	/*	require_once('Invenzzia/Controller/Exception.php');
		throw new Invenzzia_Controller_Exception('Invenzzia_Controller_Response_Http::appendBody() - not supported.');
		*/
	} // end appendBody();

	/**
	 * Not used - throws an exception.
	 *
	 * @param Void $name
	 * @param Void $content
	 */
	public function prepend($name, $content)
	{
		require_once('Invenzzia/Controller/Exception.php');
		throw new Invenzzia_Controller_Exception('Invenzzia_Controller_Response_Http::prepend() - not supported.');
	} // end prepend();
} // end Invenzzia_Controller_Response_Http;
