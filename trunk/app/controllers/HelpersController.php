<?php
/**
 * Helper demonstration controller.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class HelpersController extends Invenzzia_Controller_Action
{
	/**
	 * The action shows the helper menu.
	 */
	public function indexAction()
	{
		$title = Invenzzia_View_HelperBroker::getInstance()->title;
		$title->prependTitle('Some title');
	} // end indexAction();

	/**
	 * Demonstrates the "title" helper.
	 */
	public function titleAction()
	{
		$title = Invenzzia_View_HelperBroker::getInstance()->title;
		$title->appendTitle('Foo');
		$title->appendTitle('Bar');
		$title->appendTitle('Joe');
	} // end titleAction();

	/**
	 * Demonstrates the "headScript" helper.
	 */
	public function headscriptAction()
	{
		$headScript = Invenzzia_View_HelperBroker::getInstance()->headScript;
		$headScript->appendFile('script.js');
		$headScript->appendScript('document.write(\'foo\');');
		$headScript->appendGroup('standard');
		$headScript->appendGroup('printable');
		$this->view->setFormat('script', 'Objective/Array');
	} // end headscriptAction();

	/**
	 * Demonstrates the "headStyle" helper
	 */
	public function headstyleAction()
	{
		$headStyle = Invenzzia_View_HelperBroker::getInstance()->headStyle;
		$headStyle->appendFile('style.css');
		$headStyle->appendStyle(' body { } ');
		$headStyle->appendGroup('standard');
		$headStyle->appendGroup('printable');
		$this->view->setFormat('style', 'Objective/Array');
	} // end headstyleAction();

	/**
	 * Demonstrates the "translate" helper
	 */
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

	/**
	 * Demonstrates the "flashMessage" helper. This helper performs a HTTP
	 * redirect to "flash2" action, which displays the result.
	 */
	public function flashmessageAction()
	{
		$flashMessage = Invenzzia_View_HelperBroker::getInstance()->flashMessage;
		$flashMessage->setMessage('The test message.', array('controller' => 'helpers', 'action' => 'flash2'));
	} // end flashmessageAction();

	/**
	 * Displays the flash message set by "flashmessage" action.
	 */
	public function flash2Action()
	{
		/* null */
	} // end flash2Action();

	/**
	 * Demonstrates the "breadcrumbs" helper.
	 */
	public function breadcrumbsAction()
	{
		$container = new Zend_Navigation(array(
			array(
				'label' => 'Index',
				'controller' => 'helpers',
				'id' => 'index'
			),
			array(
				'label' => 'Helpers',
				'controller' => 'helpers',
				'id' => 'helpers',
				'pages' => array(
					array(
						'label' => 'Breadcrumbs',
						'controller' => 'helpers',
						'action' => 'breadcrumbs',
						'id' => 'breadcrumbs'
					)
				)
			)
		));
		$breadcrumbs = Invenzzia_View_HelperBroker::getInstance()->breadcrumbs;
		$breadcrumbs->setContainer($container);
		$breadcrumbs->setSeparator(' / ');
	} // end breadcrumbsAction();

	/**
	 * Demonstrates the "navigationTree" helper.
	 */
	public function navigationtreeAction()
	{
		$container = new Zend_Navigation(array(
			array(
				'label' => 'Index',
				'controller' => 'index',
				'id' => 'index'
			),
			array(
				'label' => 'Helpers',
				'controller' => 'helpers',
				'id' => 'helpers',
				'pages' => array(
					array(
						'label' => 'Breadcrumbs',
						'controller' => 'helpers',
						'action' => 'breadcrumbs',
						'id' => 'breadcrumbs'
					)
				)
			)
		));
		$navTree = Invenzzia_View_HelperBroker::getInstance()->navigationTree;
		$navTree->setContainer($container);
	} // end navigationtreeAction();
} // end HelpersController;