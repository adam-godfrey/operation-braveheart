<?php

class Profile extends Controller {

    public function __construct() {
	
        parent::__construct();
        //Auth::handleLogin();
    }
    
    public function index() {    
	
		// set the page title
        $this->view->title = 'Dashboard | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news', 'profile'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.profile'));
		// set the content heading
		$this->view->heading = 'Dashboard';
		// set the large content image
		$this->view->imgclass = 'profilelrgimg';
		$this->view->adminimg = 'dashboard.png';
		$this->view->alt = 'Dashboard';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "profile", "name" => "User Profile")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the private messages from the database
		$json = json_decode($this->model->getPrivateMessages(), true);
		// set the private messages
		$this->view->prvtmsg = $json;

		// render the html
        $this->view->render('header');
        $this->view->render('profile/index');
        $this->view->render('footer');
    }
    
    public function logout() {
		// destroy the session
        Session::destroy();
		
		// set the page title
		$this->view->pagetitle = 'Log Out | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news'));
		// set the content heading
		$this->view->heading = 'Logged Out';
		// set the large content image
		$this->view->imgclass = 'profilelrgimg';
		$this->view->adminimg = 'loggedout.png';
		$this->view->alt = 'Logged Out';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "profile", "name" => "User Profile"),
						   array("url" => URL . "logout", "name" => "Logged Out")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// render the html
        $this->view->render('header');
        $this->view->render('profile/logout');
        $this->view->render('footer');
    }
	
	public function signature() {
	
		// set the page title
		$this->view->pagetitle = 'Profile Signature | Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news', 'profile'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.profile'));
		$this->view->heading = 'Edit Signature';
		// set the large content image
		$this->view->imgclass = 'profilelrgimg';
		$this->view->adminimg = 'signature.png';
		$this->view->alt = 'Edit your forum signature';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "profile", "name" => "User Profile"),
						   array("url" => URL . "signature", "name" => "Signature")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the signature for the user from the database
		$json = json_decode($this->model->getSignature(), true);
		$this->view->signature = $json[0]['signature'];

		// render the html
		$this->view->render('header');
        $this->view->render('profile/signature');
        $this->view->render('footer');
	}
	
	public function editsignature() {
	
		// save the signature for the user
		$this->model->setSignature($_POST['signature']);
		// redirect back to their profile page
		header('Location: ' . URL . 'profile');
		exit;
	}
	
	public function avatar() { 
	
		// set the page title
		$this->view->pagetitle = 'Forum Avatar | Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news', 'profile'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.profile'));
		$this->view->heading = 'Edit Avatar';
		// set the large content image
		$this->view->imgclass = 'profilelrgimg';
		$this->view->adminimg = 'avatar.png';
		$this->view->alt = 'Select your avatar';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "profile", "name" => "User Profile"),
						   array("url" => URL . "avatar", "name" => "Avatar")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the user's avatar from the database
		$rows = json_decode($this->model->getAvatar(), true);
		$this->view->current = $current[0];
		//get all the avatars from the database
		$json = json_decode($this->model->displayAvatars(), true);
		$this->view->avatar = $json;

		// render the html
		$this->view->render('header');
        $this->view->render('profile/avatar');
        $this->view->render('footer');
	}
	
	public function editavatar() {
		// save the new avatar for the user
		$this->model->setAvatar($_POST['avpic']);
		// redirect back to their profile page
		header('Location: ' . URL . 'profile');
		exit;
	}
	
	public function emailpassword() {
	
		// set the page title
		$this->view->pagetitle = 'Email &amp; Password | Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news', 'profile'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.profile'));
		$this->view->heading = 'Edit Email and Password';
		// set the large content image
		$this->view->imgclass = 'profilelrgimg';
		$this->view->adminimg = 'emailpassword.png';
		$this->view->alt = 'Edit your email and password';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "profile", "name" => "User Profile"),
						   array("url" => URL . "editemailpassword", "name" => "Edit Email &amp; Password")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the user's email address from the database
		$json = json_decode($this->model->getEmail(), true);
		$this->view->email = $json[0]['email'];

		// render the html
		$this->view->render('header');
        $this->view->render('profile/email-password');
        $this->view->render('footer');
	}
	
	public function editemailpassword() {
	
		// create an array containing the POST variables
		$data = array();
		$data['email'] 	  = $_POST['email1'];
		$data['password'] = $_POST['pass1'];
		// save the user data to the database
		$this->model->setEmailPassword($data);
		// redirect back to their profile page
		header('Location: ' . URL . 'profile');
	}
	
	public function options() {

		// set the page title
		$this->view->pagetitle = 'Options | Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news', 'profile'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.profile'));
		$this->view->heading = 'Edit Options';
		// set the large content image
		$this->view->imgclass = 'profilelrgimg';
		$this->view->adminimg = 'options.png';
		$this->view->alt = 'Edit website options';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "profile", "name" => "User Profile"),
						   array("url" => URL . "editoptions", "name" => "Edit Options")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the user's option from the database
		$json = json_decode($this->model->getOptions(), true);

		// populate the form with the user's options
		$this->view->email_admin = $json[0]['email_admin'];
		$this->view->email_other = $json[0]['email_other'];
		$this->view->autosubscribe = $json[0]['autosubscribe'];
		$this->view->pm_disabled = $json[0]['pm_disabled'];
		$this->view->pm_admin = $json[0]['pm_admin'];
		$this->view->new_prvt_msg = $json[0]['new_prvt_msg'];
		$this->view->save_sent_msgs = $json[0]['save_sent_msgs'];			
		
		// render the html
		$this->view->render('header');
        $this->view->render('profile/options');
        $this->view->render('footer');
	} 
	
	public function saveoptions() {
	
		// create an array of the user's new options
		$data = array();
		$data['email_admin'] = trim($_POST['email_admin']);
		$data['email_other'] = trim($_POST['email_other']);
		$data['autosubscribe'] = trim($_POST['autosubscribe']);
		$data['pm_disabled'] = trim($_POST['pm_disabled']);
		$data['pm_admin'] = trim($_POST['pm_admin']);
		$data['new_prvt_msg'] = trim($_POST['new_prvt_msg']);
		$data['save_sent'] = trim($_POST['save_sent']);
		
		// save the user's options to the database
		$this->model->setOptions($data);
		// redirect back to their profile page
		header('Location: ' . URL . 'profile');
	}
}