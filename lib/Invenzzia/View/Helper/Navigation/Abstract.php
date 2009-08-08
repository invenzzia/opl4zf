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
 * The base class for the navigation helpers. The code is partially based
 * on the original implementation from Zend Framework.
 * 
 * @copyright Copyright (c) Invenzzia Group 2009, 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
class Invenzzia_View_Helper_Navigation_Abstract extends Invenzzia_View_Helper_Abstract
{
    /**
     * Container to operate on by default
     * @var Zend_Navigation_Container
     */
    protected $_container;

    /**
     * The minimum depth a page must have to be included when rendering
     * @var int
     */
    protected $_minDepth;

    /**
     * The maximum depth a page can have to be included when rendering
     * @var int
     */
    protected $_maxDepth;

    /**
     * Do we render invisible pages?
     * @var boolean
     */
    protected $_renderInvisible = true;

    /**
     * Translator
     * @var Zend_Translate_Adapter
     */
    protected $_translator;

    /**
     * ACL to use when iterating pages
     * @var Zend_Acl
     */
    protected $_acl;

    /**
     * ACL role to use when iterating pages
     * @var string|Zend_Acl_Role_Interface
     */
    protected $_role;

    /**
     * Whether ACL should be used for filtering out pages
     * @var bool
     */
    protected $_useAcl = true;
	
	/**
	 * The properties accessible via getters and setters.
	 * @var Array
	 */
	protected $_accessibleValues = array(
		'minDepth', 'maxDepth'		
	);

	/**
	 * The property to read.
	 * @param String $name The property name.
	 */
	public function __get($name)
	{
		if(in_array($name, $this->_accessibleValues))
		{
			$name = '_'.$name;
			return $this->$name;
		}
		throw new BadMethodCallException('Invalid Invenzzia_View_Helper_Navigation property: '.$name);
	} // end __get();

	/**
	 * The property to save.
	 * @param String $name The property name.
	 * @param Mixed $value The property value.
	 */
	public function __set($name, $value)
	{
		if(in_array($name, $this->_accessibleValues))
		{
			$name = '_'.$name;
			$this->$name = $value;
		}
		throw new BadMethodCallException('Invalid Invenzzia_View_Helper_Navigation property: '.$name);
	} // end __set();

	/**
	 * Sets the navigation container. The default argument value is null, it means
	 * that the container will reset. The method returns self.
	 *
	 * @param Zend_Navigation_Container $container The new container to set.
	 * @return Invenzzia_View_Helper_Navigation_Abstract
	 */
	public function setContainer(Zend_Navigation_Container $container = null)
	{
		$this->_container = $container;
		return $this;
	} // end setContainer();

	/**
	 * Returns the current navigation container.
	 * 
	 * @return Zend_Navigation_Container|null
	 */
	public function getContainer()
	{
		return $this->_container;
	} // end setContainer();

	/**
	 * Sets the ACL object. The default argument value is null, it means
	 * that the ACL will reset. The method returns self.
	 *
	 * @param Zend_Acl $acl The new ACL to set.
	 * @return Invenzzia_View_Helper_Navigation_Abstract
	 */
	public function setAcl(Zend_Acl $acl = null)
	{
		$this->_acl = $acl;
		return $this;
	} // end setAcl();

	/**
	 * Returns the current ACL object.
	 *
	 * @return Zend_Acl|null
	 */
	public function getAcl()
	{
		return $this->_acl;
	} // end getAcl();

	/**
	 * Sets the ACL role used by the ACL.
	 *
	 * @param Zend_Acl_Role_Interface|string $role The ACL role.
	 * @throws Invenzzia_View_Exception
	 * @return Invenzzia_View_Helper_Navigation_Abstract
	 */
	public function setRole($role)
	{
		if($role === null || is_string($role) || $role instanceof Zend_Acl_Role_Interface)
		{
			$this->_role = $role;
		}
		else
		{
			throw new Invenzzia_View_Exception('Invenzzia_View_Helper_Navigation_Abstract::setRole() accepts only
				null values, strings or Zend_Acl_Role_Interface objects.');
		}
		return $this;
	} // end setRole();

	/**
	 * Returns the current ACL role used in the rendering.
	 *
	 * @return Zend_Acl_Role_Interface|string
	 */
	public function getRole()
	{
		return $this->_role;
	} // end getRole();

	/**
	 * Sets the invisible rendering state.
	 * @param boolean $renderInvisible The new state
	 */
	public function setRenderInvisible($renderInvisible)
	{
		$this->_renderInvisible = $renderInvisible;
	} // end setRenderInvisible();

	/**
	 * Gets the current state of rendering invisible pages.
	 * @return boolean
	 */
	public function getRenderInvisible()
	{
		return $this->_renderInvisible;
	} // end getRenderInvisible();

	/**
	 * Sets the translator object. The default argument value is null, it means
	 * that the ACL will reset. If the argument contains the Zend_Translate object,
	 * the adapter is extracted from it. The method returns self.
	 *
	 * @param Zend_Translate_Adapter|Zend_Translate $translator The new translator.
	 * @throws BadMethodCallException
	 * @return Invenzzia_View_Helper_Navigation_Abstract
	 */
	public function setTranslator($translator = null)
	{
		if($translator === null)
		{
			$this->_translator = null;
		}
		elseif($translator instanceof Zend_Translate_Adapter)
		{
			$this->_translator = $translator;
		}
		elseif($translator instanceof Zend_Translate)
		{
			$this->_translator = $translator->getAdapter();
		}
		else
		{
			throw new BadMethodCallException('Invalid argument for '.get_class($this).'::setTranslator(): Zend_Translate_Adapter or Zend_Translate expected.');
		}
		return $this;
	} // end setAcl();

	/**
	 * Returns the current translator.
	 *
	 * @return Zend_Translate_Adapter|null
	 */
	public function getTranslator()
	{
		return $this->_translator;
	} // end getAcl();

    /**
     * Finds the deepest active page in the given container
     *
	 * @copyright Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
	 * @license http://framework.zend.com/license/new-bsd New BSD License
     * @param  Zend_Navigation_Container $container  container to search
     * @param  int|null                  $minDepth   [optional] minimum depth
     *                                               required for page to be
     *                                               valid. Default is to use
     *                                               {@link getMinDepth()}. A
     *                                               null value means no minimum
     *                                               depth required.
     * @param  int|null                  $minDepth   [optional] maximum depth
     *                                               a page can have to be
     *                                               valid. Default is to use
     *                                               {@link getMaxDepth()}. A
     *                                               null value means no maximum
     *                                               depth required.
     * @return array                                 an associative array with
     *                                               the values 'depth' and
     *                                               'page', or an empty array
     *                                               if not found
     */
    public function findActive(Zend_Navigation_Container $container, $minDepth = null, $maxDepth = -1)
    {
		if (!is_int($minDepth))
		{
			$minDepth = $this->minDepth;
		}
		if ((!is_int($maxDepth) || $maxDepth < 0) && null !== $maxDepth)
		{
			$maxDepth = $this->maxDepth;
		}

		$found  = null;
		$foundDepth = -1;
		$iterator = new RecursiveIteratorIterator($container, RecursiveIteratorIterator::CHILD_FIRST);

		foreach ($iterator as $page)
		{
			$currDepth = $iterator->getDepth();
			if ($currDepth < $minDepth || !$this->accept($page))
			{
				// page is not accepted
				continue;
			}

			if ($page->isActive(false) && $currDepth > $foundDepth)
			{
				// found an active page at a deeper level than before
				$found = $page;
				$foundDepth = $currDepth;
			}
		}

		if(is_int($maxDepth) && $foundDepth > $maxDepth)
		{
			while($foundDepth > $maxDepth)
			{
				if(--$foundDepth < $minDepth)
				{
					$found = null;
					break;
				}

				$found = $found->getParent();
				if(!$found instanceof Zend_Navigation_Page)
				{
					$found = null;
					break;
				}
			}
		}

		if($found)
		{
			return array('page' => $found, 'depth' => $foundDepth);
		}
		else
		{
			return array();
		}
    } // end findActive();

	/**
	 * Determines, if the page could be accepted
	 *
	 * @param Zend_Navigation_Page $page The page to accept
	 * @param boolean $recursive Do we perform a recursive check?
	 * @return boolean
	 */
	public function accept(Zend_Navigation_Page $page, $recursive = true)
	{
		// Accept by default.
		$accept = true;
		if(!$page->isVisible(false) && !$this->_renderInvisible)
		{
			$accept = false;
		}
		if($this->_acl !== null && $this->_acceptAcl($page))
		{
			$accept = false;
		}
		// TODO: Add recursive check.
		return $accept;
	} // end accept();

	/**
	 * Determines if the page should be accepted by ACL.
	 * 
	 * @param Zend_Navigation_Page $page The page to accept.
	 */
	protected function _acceptAcl(Zend_Navigation_Page $page)
	{
		$resource = $page->getResource();
		$privilege = $page->getPrivilege();

		if($resource || $privilege)
		{
			return $this->_acl->isAllowed($this->_role, $resource, $privilege);
		}
		return true;
	} // end _acceptAcl();

	/**
	 * The hook for the Invenzzia data format
	 * @param Array $section The section data
	 * @return String
	 */
	public function invenzziaSectionHook($section)
	{
		return '$_sect'.$section['name'].'_vals = Opt_View::$_global[\'helper\']->'.$section['name'].'->toArray(); ';
	} // end invenzziaSectionHook();
} // end Invenzzia_View_Helper_Navigation_Abstract;
