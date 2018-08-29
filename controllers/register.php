<?php

class Register extends Controller {
		
    public function __construct() {
	
        parent::__construct();
    }
    
    public function index() {
	
		$this->model->visitorTracker();
		
		// set the page title
		$this->view->pagetitle = 'Register with Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'register';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.passwordStrength', 'jquery.username-check', 'jquery.register-form-validate'));
		// set the content heading
		$this->view->heading = 'Account Registration';
		// set the large content image
		$this->view->largeimg = 'register.jpg';
		// set the alt text of the image
		$this->view->alt = 'Register with Operation Braveheart';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "register", "name" => "Register")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		//render the html
        $this->view->render('header');
        $this->view->render('register/index');
        $this->view->render('footer');
    }
	
	public function create() {

		// set the page title
		$this->view->pagetitle = 'Register with Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'register';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.passwordStrength', 'jquery.username-check', 'jquery.register-form-validate'));
		// set the content heading
		$this->view->heading = 'Account Registration';
		// set the large content image
		$this->view->largeimg = 'register.jpg';
		$this->view->alt = 'Register with Operation Braveheart';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "register", "name" => "Register")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get all the post data from the registration form
		$data['first_name'] = $_POST['first_name'];
		$data['last_name'] = $_POST['last_name'];
		$data['email'] = $_POST['email'];
		$data['interests'] = $_POST['interests'];
		$data['username'] = $_POST['username'];
		$data['password'] = $_POST['passwordInput'];
		$data['newsletter'] = (isset($_POST['newsletter'])) ? $_POST['newsletter'] : 'No';
		$data['termscheck'] = (isset($_POST['termscheck'])) ? $_POST['termscheck'] : 'No';
		
		// A array to store errors
		$errors = array();
		// Collection of validators
		$validators = array();

		$validators[]=new ValidateName($data['first_name'],'Forename');
		$validators[]=new ValidateName($data['last_name'],'Surname');
		$validators[]=new ValidateEmails(array($data['email'], $_POST['confemail']));
		$validators[]=new ValidateUsername($data['username']);
		$validators[]=new ValidatePasswords(array($data['password'], $_POST['confirmPasswordInput']));
		$validators[]=new ValidateTerms($data['termscheck']);
		$validators[]=new ValidateCaptcha($_POST['captchaimg']);

		// Iterate over the validators, validating as we go
		foreach($validators as $validator) {
			if (!$validator->isValid()) {
				while ( $error = $validator->fetch() ) {
					 $errors[]=$error;
				}
			}
		}
		
		/**
		* If there are no errors on the form, call the function to register a new account using the varaibles from the form.
		* If the new user details are successfully saved in the database, give the user a confirmation message
		* otherwise display an error for the user.
		*/
		if(empty($errors)) {
		
			switch($this->model->create($data)) {
				case 1:
				case 3:
					$this->view->success = 'Account created successfully';
					$this->view->message = '<p class="thanks">Thank you '.$_POST['first_name'].'!  You have successfully registered.</p>
											<p>You will soon be receiving an email with your username and password and details on how to activate your account.</p>
											<p>Once you have activated your account, you will be able to login and post in the forums.</p>
											<p>Thank you for registering and supporting us.</p>';
					break;
				case 2:
					$this->view->success = 'Account created successfully but failed to sign up for newsletter';
					$this->view->message = '<p class="thanks">Thank you '.$_POST['first_name'].'!  You have successfully registered.</p>
											<p>You will soon be receiving an email with your username and password and details on how to activate your account.</p>
											<p>Once you have activated your account, you will be able to login and post in the forums.</p>
											<p>If you would still like to sign up for our newsletter, please use the newsletter signup form.</p>
											<p>Thank you for registering and supporting us.</p>';
					break;
				case 4:
					$this->view->success = 'Account creation failed';
					$this->view->message = '<p>Please contact the webmaster via the <a href="'.URL.'contact">contact form</a>.<p>';
					break;
				case 5:
					$this->view->success = 'Account created successfully but failed to send email confirmation';
					$this->view->message = '<p class="thanks">Thank you '.$_POST['first_name'].'!  You have successfully registered.<p>
											<p>We regret that your email confirmation could not be sent.</p>
											<p>Please contact the webmaster via the <a href="'.URL.'contact">contact form<a/> so we can send you your email confirmation.</p>
											<p>Thank you for registering and supporting us.</p>';
					break;
				default:
			}
			
			//render the html
			$this->view->render('header');
			$this->view->render('register/result');
			$this->view->render('footer');
		}
		else {
			// set the errors from failed validation
			$this->view->errors = $errors;
			// set the form data so user doesn't have to re-enter
			$this->view->data = $data;
		
			//render the html
			$this->view->render('header');
			$this->view->render('register/errors');
			$this->view->render('footer');
		}
	}
	
	public function activate($userid = false, $code = false) {
	
		// set the page title
		$this->view->pagetitle = 'Register with Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Account Activation';
		// set the large content image
		$this->view->largeimg = 'register.jpg';
		$this->view->alt = 'Register with Operation Braveheart';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "register", "name" => "Register"),
						   array("url" => URL . "activate", "name" => "Activate")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// create an array from the activation link parameters
		$data = array();
        $data['userid'] = $userid;
        $data['code'] = $code;
        
		// pass the array to the model to activate the user
		$this->view->success = $this->model->activate($data);
		
		//render the html
        $this->view->render('header');
        $this->view->render('register/result');
        $this->view->render('footer');
	}
}	