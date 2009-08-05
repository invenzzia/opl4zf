<?php
/**
 * A sample index controller.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class IndexController extends Invenzzia_Controller_Action
{
	public function indexAction()
	{
		$this->helpers['title']->prependTitle('Some title');
		$this->view->universe = 'HI UNIVERSE!';
		$this->_forward('secondary');
	} // end indexAction();

	public function secondaryAction()
	{
		$layout = Invenzzia_Layout::getMvcInstance();

		$this->view->test = 'Foo';
		$layout->appendView($this->view, 'secondary');
		$this->_forward('third');
	} // end secondaryAction();

	public function thirdAction()
	{
		$this->view->test = 'Bar';
	} // end thirdAction();

	public function formAction()
	{
		$form = new testForm;
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if($form->isValid($_POST))
			{
				$this->view->data = $_POST;
				$this->view->setTemplate('index/form_valid.tpl');
			}
			else
			{
				$form->setAction('controller=index&action=form');
				$form->populate($_POST);
				$form->assignForm($this->view);
			}
		}
		else
		{
			$form->setAction('controller=index&action=form');
			$form->assignForm($this->view);
		}
	} // end formAction();
} // end IndexController;

class testForm extends Invenzzia_Form
{
	public function __construct( $options = null )
	{
		parent::__construct($options);
		$email = $this->createElement( 'text', 'email' );
		$email->setLabel( 'E-mail' )
				  ->setRequired( true )
				  ->addValidator('NotEmpty')
				  ->addValidator(new Zend_Validate_EmailAddress(Zend_Validate_Hostname::ALLOW_LOCAL));
		$this->addElement($email);

		$firstname = $this->createElement( 'text', 'firstname' );
		$firstname->setLabel( 'First name' )
				  ->setRequired( true )
				  ->addValidator('NotEmpty');
		$this->addElement($firstname);

		$surname = $this->createElement( 'text', 'surname' );
		$surname->setLabel( 'Last name' )
				->setRequired( true )
				->addValidator('NotEmpty');
		$this->addElement($surname);
	} // end __construct();
} // end testForm;