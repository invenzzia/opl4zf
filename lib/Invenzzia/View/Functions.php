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
	 * @param String|Array $args The router arguments
	 * @return String
	 */
	public function url($args, $routeName = null)
	{
		if(is_array($args))
		{
			return Invenzzia_View::getInstance()->url($args, $routeName);
		}

		// The standard string "name=val&name=val"
		if($args[0] != '/')
		{
			$items = array();
			parse_str($args, $items);
			return Invenzzia_View::getInstance()->url($items, $routeName);
		}
		else
		{
		// Nice string "/controller/action?name=val&name=val..."
			$data = parse_url($args);
			$items = array();
			parse_str($data['query'], $items);
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
			return Invenzzia_View::getInstance()->url($items, $routeName);
		}
	} // end url();
} // end Invenzzia_View_Functions();
