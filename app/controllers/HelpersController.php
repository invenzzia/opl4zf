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
		$title = Invenzzia_View_HelperBroker::getInstance()->title;
		$title->prependTitle('Some title');
	} // end indexAction();

	public function titleAction()
	{
		$title = Invenzzia_View_HelperBroker::getInstance()->title;
		$title->appendTitle('Foo');
		$title->appendTitle('Bar');
		$title->appendTitle('Joe');
	} // end titleAction();

	public function headscriptAction()
	{
		$headScript = Invenzzia_View_HelperBroker::getInstance()->headScript;
		$headScript->appendFile('script.js');
		$headScript->appendScript('document.write(\'foo\');');
		$headScript->appendGroup('standard');
		$headScript->appendGroup('printable');
		$this->view->setFormat('script', 'Objective/Array');
	} // end headscriptAction();

	public function headstyleAction()
	{
		$headStyle = Invenzzia_View_HelperBroker::getInstance()->headStyle;
		$headStyle->appendFile('style.css');
		$headStyle->appendStyle(' body { } ');
		$headStyle->appendGroup('standard');
		$headStyle->appendGroup('printable');
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
	} // end translateAction();

	public function flashmessageAction()
	{
		$flashMessage = Invenzzia_View_HelperBroker::getInstance()->flashMessage;
		$flashMessage->setMessage('The test message.', array('controller' => 'helpers', 'action' => 'flash2'));
	} // end flashmessageAction();

	public function flash2Action()
	{
		/* null */
	} // end flash2Action();

} // end HelpersController;