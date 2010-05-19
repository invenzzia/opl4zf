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
 * $Id: ErrorHandler.php 20 2009-08-10 17:53:34Z zyxist $
 */

/**
 * The index controller for the sample application.
 */
class IndexController extends Invenzzia_Controller_Action
{

	/**
	 * The index action.
	 */
    public function indexAction()
    {
		$title = Invenzzia_View_HelperBroker::getInstance()->title;
		$title->prependTitle('Index');
    } // end indexAction();

	/**
	 * The currency action.
	 */
    public function currencyAction()
    {
		$title = Invenzzia_View_HelperBroker::getInstance()->title;
		$title->prependTitle('Currency');

		$currency = new Zend_Currency('pl_PL');
		Zend_Registry::set('currency', $currency);
    } // end indexAction();

} // end IndexController;

