<?php

class Events extends Controller {
		
	private $entries_per_page;
	
    function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Events | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Events';
		// set the large content image
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Events';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "events", "name" => " Fundraising Events")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getContent($this->entries_per_page));
		
		// check to see if there any events to display
		if(!empty($rows)) {
			// truncate the events content
			$this->view->events = $rows;
			// create the paging 
			$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'events', 'pages') : '';
			// set the counter for the links to the blog content
			$this->view->counter = 1;
		}
		else {
			// no events to display
			$this->view->events = '';
		}

		// render the html
        $this->view->render('header');
        $this->view->render('events/index');
        $this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Events | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Events';
		// set the large content image
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Events';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "fundraising", "name" => "Fund Raising"),
						   array("url" => URL . "events", "name" => "Events")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getContent($this->entries_per_page, (int) $arg));
	
		// set the events to be displayed
		$this->view->events = $rows;
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'events', 'pages') : '';
		
		// Get the page number and if we're on the first page start the counter from 1.
		if($page == 1) {
			// counter starts from 1 for the links to the blogs content
			$this->view->counter = 1;
		}
		else {
			// counter starts from e.g. (6 * (2-1)) + 1 = 7
			$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
		}
		
		// render the html
        $this->view->render('header');
        $this->view->render('events/index');
        $this->view->render('footer');
    }
	
	public function view($arg = false) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 1;
		// set the page title
		$this->view->pagetitle = 'Events | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'events';
		
		// get the events returned from database
		extract($this->model->getEvent($this->entries_per_page, (int) $arg));

		if(!empty($rows)) $this->view->embed = '<script type="text/javascript">var latitude="'.$rows[0]['lat'].'", longitude="'.$rows[0]['lng'].'";</script>';
		// get an array of additional JavaScripts
		$this->view->scripts = (!empty($rows)) ? $this->model->setScripts(array('jquery.form.validate',
																			 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', 
																			 'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js',
																			 'gmaps')) : $this->model->setScripts(array('jquery.form.validate'));		
		// set the content heading
		$this->view->heading = 'Events';
		// set the large content image
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Events';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "fundraising", "name" => "Fund Raising"),
						   array("url" => URL . "events", "name" => "Events"),
						   (!empty($rows)) ? array("url" => URL . "events/" . str_replace(' ', '-', strtolower($rows[0]['title'])), "name" => ucwords(strtolower($rows[0]['title']))) :  array("url" => URL . "events/", "name" => 'No Events')
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
		// set the events to be displayed
		$this->view->events = $rows;
		// create the paging 

		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'events', 'view') : '';
		
		// Get the page number and if we're on the first page start the counter from 1.
		if($page == 1) {
			// counter starts from 1 for the links to the blogs content
			$this->view->counter = 1;
		}
		else {
			// counter starts from e.g. (6 * (2-1)) + 1 = 7
			$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
		}
		
		// set the page number
		$this->view->pageid = $arg;
		
		// set the comments title
		$this->view->event_title = (!empty($rows)) ? $rows[0]['title'] : '';
		
		// set the comments count
		$this->view->comm_count = (!empty($rows)) ? $this->model->getCommentsCount($rows[0]['id']) : 0;
		// if there are comments in the database for this blogs
		if(!empty($rows)) {
			if($this->model->getCommentsCount($rows[0]['id']) > 0) {
				// extract it from the database
				extract($this->model->getComments($rows[0]['id']));
				// and set it so they can be viewed
				$this->view->comments = $comments;
			}
		}
		
		//render the html
        $this->view->render('header');
        $this->view->render('events/view');
        $this->view->render('footer');
    }
	
	public function date($date) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Events | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		
		// set the content heading
		$this->view->heading = 'Events';
		// set the large content image
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Events';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "fundraising", "name" => "Fund Raising"),
						   array("url" => URL . "events", "name" => "Events")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$date = date("Y-m-d",strtotime(str_replace('_','-',$date)));
		
		// get the rows returned from database
		extract($this->model->getEventsByDate($this->entries_per_page, $date));
	
		// set the events to be displayed
		$this->view->events = $rows;
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'events', 'pages') : '';
		
		// Get the page number and if we're on the first page start the counter from 1.
		if($page == 1) {
			// counter starts from 1 for the links to the blogs content
			$this->view->counter = 1;
		}
		else {
			// counter starts from e.g. (6 * (2-1)) + 1 = 7
			$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
		}
		
		// render the html
        $this->view->render('header');
        $this->view->render('events/index');
        $this->view->render('footer');
	}

	public function reply() {
	
		// create an array of POST variables from user input
		$data = array();		
		$data['fullname'] = $_POST['fullname'];
		$data['email'] = $_POST['email'];
		$data['web'] = $_POST['web'];
		$data['message'] = $_POST['message'];
		$data['eventid'] = $_POST['eventid'];
		$data['pageid'] = $_POST['pageid'];
		$data['captchaimg'] = $_POST['captchaimg'];
		
		// create an array for errors
		$errors = array();
		// Collection of validators
		$validators = array();

		$validators[]=new ValidateName($_POST['fullname'],'Name');
		$validators[]=new ValidateEmail($_POST['email']);
		$validators[]=new ValidateCaptcha($_POST['captchaimg']);
		$validators[]=new ValidateEmpty($_POST['message'],'Comment');

		// Iterate over the validators, validating as we go
		foreach($validators as $validator) {
			if (!$validator->isValid()) {
				while ( $error = $validator->fetch() ) {
					$errors[]=$error;
				}
			}
		}
		
		// if there are no errors in the form
		if(empty($errors)) {
			// submit the comment for moderation
			$this->model->submitComment($data);
			// and redirect back to their comment so they know it's submitted
			header('location: ' . URL . 'events/view/' . $_POST['pageid'].'#lastcomment');
			exit;
		}
		else {
		
			// set the number of results to be displayed on the page
			$this->entries_per_page = 1;
			// set the page title
			$this->view->pagetitle = 'Events | Operation Braveheart';
			// get an array of additional stylesheets
			$this->view->style = 'events';
			
			// get the events returned from database
			extract($this->model->getEvent($this->entries_per_page, (int) $arg));
			
			$this->view->embed = '<script type="text/javascript">var latitude="'.$rows[0]['lat'].'", longitude="'.$rows[0]['lng'].'";</script>';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form.validate', 'gmaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', 
																  'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js'));		
			// set the content heading
			$this->view->heading = 'Events';
			// set the large content image
			$this->view->largeimg = 'events.jpg';
			$this->view->alt = 'Events';
			
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
							   array("url" => URL, "fundraising" => "Fund Raising"),
							   array("url" => URL . "news", "name" => "Events"),
							   array("url" => URL . "events/" . str_replace(' ', '-', strtolower($rows[0]['title'])), "name" => ucwords(strtolower($rows[0]['title'])))
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
				
			// set the events to be displayed
			$this->view->events = $rows;
			// create the paging 
			$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'events', 'view') : '';
			
			// Get the page number and if we're on the first page start the counter from 1.
			if($page == 1) {
				// counter starts from 1 for the links to the blogs content
				$this->view->counter = 1;
			}
			else {
				// counter starts from e.g. (6 * (2-1)) + 1 = 7
				$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
			}
			
			// set the page number
			$this->view->pageid = $arg;
			
			// set the comments title
			$this->view->event_title = $rows[0]['title'];
			
			// set the comments count
			$this->view->comm_count = $this->model->getCommentsCount($rows[0]['id']);
			// if there are comments in the database for this blogs
			if($this->model->getCommentsCount($rows[0]['id']) > 0) {
				// extract it from the database
				extract($this->model->getComments($rows[0]['id']));
				// and set it so they can be viewed
				$this->view->comments = $comments;
			}
		
			// set the errors from failed validation
			$this->view->errors = $errors;
			// set the form data so user doesn't have to re-enter
			$this->view->data = $data;
			
			//render the html
			$this->view->render('header');
			$this->view->render('events/errors');
			$this->view->render('footer');
		}
	}	
}