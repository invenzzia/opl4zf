
    ================================
    OPEN POWER LIBS 2
        OFFICIAL ZEND FRAMEWORK PORT
    ================================
                    Version 0.2

Thank you for downloading Open Power Libs port for Zend Framework!
This document contains the necessary information about the package.

PACKAGE CONTENTS
================

The package contains the following items:

 - OPL port for Zend Framework
 - A sample ZF application
 - License file
 - User manual
 - This document

SYSTEM REQUIREMENTS
===================

The package needs the following software in order to work
properly:

 - Open Power Libs, at least 2.0.x (available at [Invenzzia](http://www.invenzzia.org) )
 - Zend Framework 1.10 (available at [Zend.com](http://framework.zend.com) )

INSTALLATION
============

1. Put the contents of the /lib directory in your ZF application directory structure
2. Put the contents of the /lib directory from OPL in your ZF application directory structure
3. Configure the OPL autoloader in the entry script (`index.php`):

~~~~
require('/path/to/Opl/Base.php');
Opl_Loader::setHandleUnknownLibraries(false);
Opl_Loader::addLibrary('Opl', array('directory' => '/path/to/Opl/'));
Opl_Loader::addLibrary('Opt', array('directory' => '/path/to/Opt/'));
Opl_Loader::addLibrary('Invenzzia', array('directory' => '/path/to/Invenzzia/', 'handler' => null));
Opl_Loader::register();
~~~~

4. Extend the `Invenzzia_Application_Bootstrap` class in `Bootstrap.php`

VERSION INFORMATION
===================

This is a development version of the port. Currently it replaces the default
`Zend_Layout` and `Zend_View` implementation with OPT and integrates some
services with it. We would be grateful if you tested it and sent us your
suggestions and ideas.

AUTHORS AND LICENSE
===================

OPL port for Zend Framework
Copyright (c) Invenzzia Group 2009-2010

The port is available under the terms of New BSD License that
can be found in `LICENSE` file.

Authors and contributors:
 - Tomasz Jedrzejewski - idea, design and programming

Zend Framework is a software of Zend Company Ltd.
distributed under New BSD License.