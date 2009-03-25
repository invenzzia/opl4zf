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
 * A wrapper for the Zend Framework exceptions that allows to render
 * them as OPL exceptions.
 */
class Invenzzia_Exception extends Opl_Exception
{
	private $_exception;

	/**
	 * Creates a wrapper for the Zend Framework exception.
	 *
	 * @param Zend_Exception $e Zend Framework exception
	 */
	public function __construct(Zend_Exception $e)
	{
		$this->_exception = $e;
		$this->message = $e->getMessage();
		$this->line = $e->getLine();
		$this->file = $e->getFile();
	} // end __construct();

	/**
	 * Returns the original exception object.
	 *
	 * @return Zend_Exception The original exception object.
	 */
	public function getOriginalException()
	{
		return $this->_exception;
	} // end getOriginalException();
} // end Invenzzia_Exception;

/**
 * The exception handler that uses the standard OPL core and
 * display style.
 */
class Invenzzia_ErrorHandler extends Opl_ErrorHandler
{
	protected $_library = 'Zend Engine';
	protected $_context = array(
		'__UNKNOWN__' => array(
			'BacktraceInfo' => array()
		),
	);

	/**
	 * Displays the Zend_Exception object using the standard OPL
	 * style.
	 *
	 * @param Zend_Exception $e The Zend_Exception to be displayed
	 */
	public function displayZend(Zend_Exception $e)
	{
		parent::display(new Invenzzia_Exception($e));
	} // end displayZend();

	protected function _printBacktraceInfo($exception)
	{
		$trace = $exception->getOriginalException()->getTrace();
		foreach($trace as $call)
		{
			echo "		<p class=\"directive\">".(isset($call['class']) ? $call['class'].'::' : '-').$call['function']." <span>".(isset($call['line']) ? 'Line '.$call['line'].' in '.basename($call['file']) : '-')."</span></p>\r\n";
		}
	} // end _printBacktraceInfo();
} // end Invenzzia_ErrorHandler;