<?php

class Login extends Controller {

    public function __construct() {
	
        parent::__construct();    
    }
    
    public function index()  { 

		$this->model->visitorTracker();
  
		// set the page title
		$this->view->pagetitle = 'Login to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		
		// set the content heading
		$this->view->heading = 'Login';
		// set the large content image
		$this->view->largeimg = 'login.jpg';
		// set the alt text of the image
		$this->view->alt = 'Login to Operation Braveheart';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "login", "name" => "Log In")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// check to see if form submitted
		$action = (isset($_POST['login'])) ? $_POST['login'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			
			$data = array();
					
			$data['username'] = trim($_POST['article_title']);
			$data['password'] = trim($_POST['article_content']);
			
			extract($this->model->login($data));
			
			if($bool) {
				// render the html
				$this->view->render('header');
				$this->view->render('admin/login/success');
				$this->view->render('footer');
				exit;
			}
			else {
				switch($result) {
					case 1:
						$this->view->success = 'Error occured';
						break;
					case 2:
						$this->view->success = 'Not verified';
						break;
					case 3:
						$this->view->success = 'Not active';
						break;
					case 4:
						$this->view->success = 'No match';
						break;
					default;
				}
				// render the html
				$this->view->render('header');
				$this->view->render('admin/login/index');
				$this->view->render('footer');
				exit;
			}
		}

        $this->view->render('header');
        $this->view->render('login/index');
        $this->view->render('footer');
    }
}