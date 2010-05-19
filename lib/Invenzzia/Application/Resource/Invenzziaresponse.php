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
 * $Id: Form.php 37 2010-02-06 07:38:34Z zyxist $
 */

/**
 * Dispatches Invenzzia_Response.
 *
 * @author Tomasz Jędrzejewski
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Application_Resource_Invenzziaresponse extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * The initialized response.
	 * @var Invenzzia_Controller_Response_Http
	 */
	protected $_response;

	/**
	 * Initializes the Invenzzia response object.
	 *
	 * @return Invenzzia_Controller_Response_Http
	 */
	public function init()
	{
		return $this->getResponse();
	} // end init();

	/**
	 * Returns and creates the response object.
	 *
	 * @return Invenzzia_Controller_Response_Http
	 */
	public function getResponse()
	{
		if(null === $this->_response)
		{
			$this->_response = new Invenzzia_Controller_Response_Http;

			$bootstrap = $this->getBootstrap();
			$bootstrap->bootstrap('FrontController');
			$bootstrap->getContainer()->frontcontroller
				->setResponse($this->_response)
				->setParam('noViewRenderer', true)
				->setParam('disableOutputBuffering', true);

			$bootstrap = $this->getBootstrap();
			$layout = $bootstrap->bootstrap('invenzzialayout');
			$bootstrap->getContainer()->invenzzialayout->setOutput($this->_response);
		}

		return $this->_response;
	} // end getResponse();
} // end Invenzzia_Application_Resource_Invenzziaresponse;