<?php

class Forgot_Password extends Controller {

    public function __construct() {
	
        parent::__construct();
    }
    
    public function index() {
	
		$this->model->visitorTracker();
	
		// set the page title
        $this->view->pagetitle = 'Request a New Password | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Forgot Your Password?';
		// set the large content image
		$this->view->largeimg = 'password.jpg';
		$this->view->alt = 'Request New Password';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "forgotpassword", "name" => "Forgot Password")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
        
		// render the html
        $this->view->render('header');
        $this->view->render('forgotpassword/index');    
        $this->view->render('footer');
    }
	
	public function request() {
	
		// set the page title
        $this->view->pagetitle = 'Request a New Password | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Forgot Your Password?';
		// set the large content image
		$this->view->largeimg = 'password.jpg';
		$this->view->alt = 'Request New Password';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "forgot-password", "name" => "Forgot Password")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// query the database with the users email to find a match and reset the password
		switch($this->model->request(trim($_POST['email']))) {
		
			case 1:
				// email address valid, password reset and emailed to user
				$this->view->sucess = true;
				$this->view->message = 'A new password has been created and emailed to '.$_POST['email'];
				break;
			case 2:
				// email address valid, password reset but email not sent
				$this->view->sucess = false;
				$this->view->message = 'A new password has been created but could not email new password to '.$_POST['email'];
				break;
			case 0:
				// email address doesn't exist
				$this->view->sucess = false;
				$this->view->message = 'Email address not found in our database';
				break;
			default;
		}
		
		// render the html
        $this->view->render('header');
        $this->view->render('forgotpassword/index');    
        $this->view->render('footer');
	}

}