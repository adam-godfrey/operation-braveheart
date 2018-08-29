<?php

class Contact extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {

		// set the page title
		$this->view->pagetitle = 'Contact Us | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.contact-form-validate'));
		// set the content heading
		$this->view->heading = 'Contact Us';
		// set the large content image
		$this->view->largeimg = 'contact-us.jpg';
		$this->view->alt = 'Contact Us';

		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "contact", "name" => "Contact Us")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		if(isset($_POST['send'])) {
		
			// get all the post data from the registration form
			$data = array();
			$data['token'] = $_POST['token'];	
			$data['session'] = 'Br3@veH3@rt_token';
			$data['name'] = $_POST['fullname'];
			$data['email'] = $_POST['email'];
			$data['website'] = $_POST['web'];
			$data['subject'] = $_POST['subject'];
			$data['message'] = $_POST['comment'];

			// A array to store errors
			$errors = array();

			// Collection of validators
			$validators = array();

			$validators[]=new ValidateName($data['name'],'Name');
			$validators[]=new ValidateEmail($data['email']);
			if(!empty($data['website'])) {
				$validators[]=new ValidateUrl($data['web'], 'Website');
			}
			$validators[]=new ValidateSubject($data['subject'], 'Subject');
			$validators[]=new ValidateEmpty($data['message'], 'Comment');
			$validators[]=new ValidateCaptcha($_POST['captcha']);

			// Iterate over the validators, validating as we go
			foreach($validators as $validator) {
				if (!$validator->isValid()) {
					while ( $error = $validator->fetch() ) {
						$errors[]=$error;
					}
				}
			}
			
			// If there are no errors on the form
			if(empty($errors)) {
			
				$result = $this->model->submit($data);
				
				if($result) {
					$this->view->success = $result;
					
					//render the html
					$this->view->render('header');
					$this->view->render('contact/index');
					$this->view->render('footer');
				}
				else {
					$this->view->errors = $result;
					
					$this->view->token = $this->model->generateFormToken('Br3@veH3@rt');
					
					//render the html
					$this->view->render('header');
					$this->view->render('contact/errors');
					$this->view->render('footer');
				}
			}
			else {
				// set the errors from failed validation
				$this->view->errors = $errors;
				
				$this->view->token = $this->model->generateFormToken('Br3@veH3@rt');
				
				// set the form data so user doesn't have to re-enter
				$this->view->data = $data;

				//render the html
				$this->view->render('header');
				$this->view->render('contact/errors');
				$this->view->render('footer');
			}
		}
		else {
			$this->view->token = $this->model->generateFormToken('Br3@veH3@rt');
			
			//render the html
			$this->view->render('header');
			$this->view->render('contact/index');
			$this->view->render('footer');
		}

		
	}

	public function send() {

		// set the page title
		$this->view->pagetitle = 'Contact Us | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.contact-form-validate'));
		// set the content heading
		$this->view->heading = 'Contact Us';
		// set the large content image
		$this->view->largeimg = 'contact-us.jpg';
		$this->view->alt = 'Contact Us';

		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "contact", "name" => "Contact Us")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		// get all the post data from the registration form
		$data = array();
		$data['token'] = $_POST['token'];	
		$data['name'] = $_POST['fullname'];
		$data['email'] = $_POST['email'];
		$data['website'] = $_POST['web'];
		$data['subject'] = $_POST['subject'];
		$data['message'] = $_POST['comment'];

		// A array to store errors
		$errors = array();

		// Collection of validators
		$validators = array();

		$validators[]=new ValidateName($data['name'],'Name');
		$validators[]=new ValidateEmail($data['email']);
		$validators[]=new ValidateSubject($data['subject']);
		$validators[]=new ValidateEmpty($data['message'], 'Comment');
		$validators[]=new ValidateCaptcha($_POST['captchaimg']);

		// Iterate over the validators, validating as we go
		foreach($validators as $validator) {
			if (!$validator->isValid()) {
				while ( $error = $validator->fetch() ) {
					$errors[]=$error;
				}
			}
		}

		// If there are no errors on the form
		if(empty($errors)) {
		
			$result = $this->model->submit($data);

			$this->view->success = $result;

			if($success) {
			
				//render the html
				$this->view->render('header');
				$this->view->render('contact/index');
				$this->view->render('footer');
			}
			else {

				$this->view->errors = $result;
				
				//render the html
				$this->view->render('header');
				$this->view->render('contact/errors');
				$this->view->render('footer');
			}
		}
		else {
			// set the errors from failed validation
			$this->view->errors = $errors;
			// set the form data so user doesn't have to re-enter
			$this->view->data = $data;

			//render the html
			$this->view->render('header');
			$this->view->render('contact/errors');
			$this->view->render('footer');
		}
	}
}