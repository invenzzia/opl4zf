<?php
/*
 *  ZEND FRAMEWORK PORT FOR OPL <http://www.invenzzia.org>
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
 * The implementation of various utility functions for use with
 * Zend Framework.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_View_Functions
{
	/**
	 * Builds an URL using the current router and routing settings.
	 * The argument may be either an array of arguments or a string
	 * that will be parsed by the function.
	 *
	 * @static
	 * @param String|Array $args The router arguments
	 * @return String
	 */
	static public function url($args, $routeName = null)
	{
		$router = Zend_Controller_Front::getInstance()->getRouter();
		if(is_array($args))
		{
			return $router->assemble($args, $routeName, false, true);
		}

		// The standard string "name=val&name=val"
		if($args[0] != '/')
		{
			$items = array();
			parse_str($args, $items);
			return $router->assemble($items, $routeName, false, true);
		}
		else
		{
		// Nice string "/controller/action?name=val&name=val..."
			$data = parse_url($args);
			$items = array();
			if(isset($data['query']))
			{
				parse_str($data['query'], $items);
			}
			if($data['path'] != '')
			{
				$data = explode('/', $data['path']);
				$items['controller'] = $data[1];
				if(!isset($data[2]))
				{
					$items['action'] = 'index';
				}
				else
				{
					$items['action'] = $data[2];
				}
			}
			return $router->assemble($items, $routeName, false, true);
		}
	} // end url();

	/**
	 * Constructs a base URL for the specified link.
	 *
	 * @param string $link The link
	 * @return string The base URL
	 */
	public function baseUrl($link)
	{
		return Invenzzia_View::getZendView()->baseUrl($link);
	} // end baseUrl();

	/**
	 * A replacement for the currency() helper from Zend_View.
	 *
	 * @param number $amount The amount of money.
	 * @param string $currency The currency name or NULL to use default.
	 * @param int $precision The requested precision.
	 * @return string The formatted currency
	 */
	public function currency($amount, $currency = null, $precision = 2)
	{
		$currency = Zend_Registry::get('currency');

		$options = array('precision' => $precision);
		if(is_string($currency))
		{
			$options['currency'] = $currency;
		}

		return $currency->toCurrency($amount, $options);
	} // end baseUrl();
} // end Invenzzia_View_Functions();
