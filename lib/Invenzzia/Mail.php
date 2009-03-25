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
 * The class adds the implementation of Opt_Output_Interface to Zend_Mail
 * so the programmer can create the mail content using Open Power Template.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Mail extends Zend_Mail implements Opt_Output_Interface
{
	/**
	 * Returns the name of the OPT output.
	 *
	 * @return String The output name
	 */
	public function getName()
	{
		return 'Zend_Mail';
	} // end getName();

	/**
	 * Renders a view as a mail body.
	 *
	 * @param Opt_View $view The view to be rendered.
	 * @param Opt_Cache_Hook_Interface $cache The cache hook used for caching.
	 */
	public function render(Opt_View $view, Opt_Cache_Hook_Interface $cache = null)
	{
		ob_start();

		if(!$cache instanceof Opt_Cache_Hook_Interface)
		{
			$view->_parse($this, $this->_tpl->mode);
			$this->setBodyHtml(ob_get_clean());
		}
		$cache->cache($this->_tpl, $view, $mode);

		$this->setBodyHtml(ob_get_clean());
	} // end render();
} // end Invenzzia_Mail;