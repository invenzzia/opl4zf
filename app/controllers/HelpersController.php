<?php
/**
 * Helper demonstration controller.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class HelpersController extends Invenzzia_Controller_Action
{
	public function indexAction()
	{
		$this->helpers['title']->prependTitle('Some title');
	} // end indexAction();

	public function titleAction()
	{
		$this->helpers['title']->appendTitle('Foo');
		$this->helpers['title']->appendTitle('Bar');
		$this->helpers['title']->appendTitle('Joe');
	} // end titleAction();

	public function headscriptAction()
	{
		$this->helpers['headscript']->appendFile('script.js');
		$this->helpers['headscript']->appendScript('document.write(\'foo\');');
		$this->helpers['headscript']->appendGroup('standard');
		$this->helpers['headscript']->appendGroup('printable');
		$this->view->setFormat('script', 'Objective/Array');
	} // end headscriptAction();

	public function headstyleAction()
	{
		$this->helpers['headstyle']->appendFile('style.css');
		$this->helpers['headstyle']->appendStyle(' body { } ');
		$this->helpers['headstyle']->appendGroup('standard');
		$this->helpers['headstyle']->appendGroup('printable');
		$this->view->setFormat('style', 'Objective/Array');
	} // end headstyleAction();

	public function translateAction()
	{
		$english = array(
			'message1' => 'Message 1',
			'message2' => 'Message 2: %s',
			'message3' => 'Message 3');
		$translate = new Zend_Translate('array', $english, 'en');

		$this->view->value = 'Foo';

		Invenzzia_View::setTranslation($translate);
	} // end titleAction();

} // end HelpersController;