<?php
/**
 * A sample index controller. Currently there's a little mess, but
 * this will be improved in the near future to provide a nicer
 * examples of use.
 *
 * @copyright Copyright (c) Invenzzia Group 2009
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class IndexController extends Invenzzia_Controller_Action
{
	/**
	 * The index action, shows the action forwarding.
	 */
	public function indexAction()
	{
		$title = Invenzzia_View_HelperBroker::getInstance()->title;
		$title->prependTitle('Some title');
		$this->view->universe = 'HI UNIVERSE!';
		$this->_forward('secondary');
	} // end indexAction();

	/**
	 * Secondary action, shows the action forwarding and
	 * appending views to another placeholder.
	 */
	public function secondaryAction()
	{
		$layout = Invenzzia_Layout::getMvcInstance();

		$this->view->test = 'Foo';
		$layout->appendView($this->view, 'secondary');
		$this->_forward('third');
	} // end secondaryAction();

	/**
	 * Final third action used in the forwarding demonstration.
	 */
	public function thirdAction()
	{
		$this->view->test = 'Bar';
	} // end thirdAction();

	/**
	 * The action demonstrates Invenzzia_Form
	 */
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

/**
 * A test form used in the demonstration.
 */
class testForm extends Invenzzia_Form
{
	/**
	 * Form constructor. Note that we do not set any decorators here,
	 * as we are using OPT to define the element layout.
	 * 
	 * @param Array $options The form options.
	 */
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