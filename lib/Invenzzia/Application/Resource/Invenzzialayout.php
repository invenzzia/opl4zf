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
 * Dispatches Invenzzia_Layout.
 *
 * @author Tomasz Jędrzejewski
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Invenzzia_Application_Resource_Invenzzialayout extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * The layout object.
	 * @var Invenzzia_Layout
	 */
	protected $_layout;

	/**
	 * The options.
	 * @var array
	 */
	protected $_options = array(
		'sourceDir' => null,
		'compileDir' => null,
		'usePlugins' => false,
		'template' => null,
		'layout' => 'layout'
	);

	/**
	 * Initializes the layout.
	 *
	 * @return Invenzzia_Layout
	 */
	public function init()
	{
		return $this->getLayout();
	} // end init();

	/**
	 * Returns the layout object, optionally creating it.
	 *
	 * @return Invenzzia_Layout
	 */
	public function getLayout()
	{
		if(null === $this->_layout)
		{
			$options = $this->getOptions();

			$applicationPath = APPLICATION_PATH;
			if($applicationPath[strlen($applicationPath) - 1] != '/')
			{
				$applicationPath .= '/';
			}

			$sourceDir = $applicationPath.'views/templates/';
			if(!empty($options['sourceDir']))
			{
				$sourceDir = $options['sourceDir'];
			}
			$compileDir = $applicationPath.'cache/templates/';
			if(!empty($options['compileDir']))
			{
				$compileDir = $options['compileDir'];
			}
			$pluginDir = null;
			$pluginDataDir = null;
			if(!empty($options['usePlugins']) && $options['usePlugins'])
			{
				$pluginDir = $applicationPath.'views/plugins/';
				$pluginDataDir = $compileDir;
				if(!isset($options['pluginDir']))
				{
					$pluginDir = $options['pluginDir'];
				}
			}

			if(!isset($options['template']))
			{
				$options['template'] = array();
			}

			$this->_layout = Invenzzia_Layout::startMvc($options['template']);

			$opt = Opl_Registry::get('opt');
			$opt->pluginDir = $pluginDir;
			$opt->pluginDataDir = $pluginDataDir;
			$this->_layout->setViewPaths($sourceDir, $compileDir);

			$this->_layout->setLayout($options['layout']);

			$this->getBootstrap()->getContainer()->layout = $this->_layout;
		}

		return $this->_layout;
	} // end getLayout();
} // end Invenzzia_Application_Resource_Invenzzialayout;