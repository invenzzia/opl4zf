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
 * The class wraps the Zend Framework caching objects so that they
 * could be used in the templates.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Cache_Wrapper implements Opt_Caching_Interface
{
	/**
	 * The Zend cache represented by this wrapper
	 * @var Zend_Cache_Core
	 */
	private $_cache;

	/**
	 * Creates the cache wrapper object.
	 *
	 * @param Zend_Cache_Core $zendCache
	 */
	public function __construct(Zend_Cache_Core $zendCache)
	{
		$this->_cache = $zendCache;
	} // end __construct();

	/**
	 * The interface method - decides whether to start the caching and
	 * prints the cached content if necessary.
	 *
	 * @param Opt_View $view The rendered OPT view.
	 * @return Boolean
	 */
	public function templateCacheStart(Opt_View $view)
	{
		return $this->_cache->start(preg_replace('/[^a-zA-Z0-9]/', '_', $view->getTemplate()));
	} // end templateCacheStart();

	/**
	 * Finalizes the caching of the whole template.
	 *
	 * @param Opt_View $view The rendered view.
	 */
	public function templateCacheStop(Opt_View $view)
	{
		$this->_cache->end();
	} // end templateCacheStop();
} // end Invenzzia_Cache_Wrapper;