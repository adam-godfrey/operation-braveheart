<?php

class Board extends Controller {
		
	private $entries_per_page;
	
    function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
    }
	
	public function index() {
	
		$this->model->visitorTracker();
		//because we there's no content to display, do a redirect
		header('Location: '.URL.'forum');
	}
    	
	public function pages($board, $page = false) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Welcome to Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'forum';
		// set the content heading
		$this->view->heading = 'Forum';
		// set the large content image
		$this->view->largeimg = 'forum.jpg';
		$this->view->alt = 'Forum';
		
		$boardid = substr($board, 0, strpos($board, '_'));
		
		$boardname = str_replace('_', ' ', ucwords(substr($board, strpos($board, '_')+1)));
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "forum", "name" => "Forum"),
						   array("url" => URL . "forum/view/" . $board, "name" => $boardname)
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getTopics($boardid, $this->entries_per_page, $page));

		$this->view->board = $board;

		// set the number of topics and how many are displayed per page
		$this->view->offset = $offset;
		$this->view->pagemax = $pagemax;
		$this->view->getresult = $rowcount;

		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'board', 'pages/' . $board) : '';
		// set the forum boards/topics to be displayed
		$this->view->forum = $rows;
		
		// Get the page number and if we're on the first page start the counter from 1.
		if($page == 1) {
			// counter starts from 1 for the links to the blogs content
			$this->view->counter = 1;
		}
		else {
			// counter starts from e.g. (6 * (2-1)) + 1 = 7
			$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
		}
		
		//render the html
		$this->view->render('header');
		$this->view->render('forum/board');
		$this->view->render('footer');
    }
	
	public function newtopic($board) {
	
		$this->model->visitorTracker();

		// set the page title
		$this->view->pagetitle = 'Forum | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'forum';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form.validate'));
		// set the content heading
		$this->view->heading = 'Forum';
		// set the large content image
		$this->view->largeimg = 'forum.jpg';
		$this->view->alt = 'Forum';
		
		$boardid = substr($board, 0, strpos($board, '-'));
		$boardname = str_replace('-', ' ', ucwords(substr($board, strpos($board, '-')+1)));
		
		// display the breadcrumbs
		$nav_array = array(array('url' => URL, 'name' => 'Home'),
						   array('url' => URL . 'forum', 'name' => 'Forum'),
						   array('url' => URL . 'board/pages/'.$board, 'name' => $boardname),
						   array('url' => URL . 'board/pages/'.$board.'/reply', 'name' => 'New Topic')
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->board = $board;
		
		//render the html
		$this->view->render('header');
		$this->view->render('forum/create');
		$this->view->render('footer');
	}
	
	public function postnewtopic() {
	
		$topictitle = htmlspecialchars($_POST['topictitle']);
		$message = htmlspecialchars($_POST['topicmessage']);
		$board = htmlspecialchars($_POST['boardname']);
		
		$boardid = substr($board, 0, strpos($board, '-'));
		$boardname = str_replace('-', ' ', ucwords(substr($board, strpos($board, '-') + 1)));
		
		// create an array of POST variables from user input
		$data = array();
		$data['boardid'] = $boardid;
		$data['topictitle'] = $topictitle;	
		$data['message'] = $message;
		//$data['author'] = Session::get('username');
		$data['author'] = 'AdRock';
		
		// create an array for errors
		$errors = array();
		// Collection of validators
		$validators = array();

		$validators[]=new ValidateEmpty($topictitle,'Topic Title');
		$validators[]=new ValidateEmpty($message,'Message');
		
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
			$this->model->newTopic($data);
			// and redirect back to their comment so they know it's submitted
			header('location: ' . URL . 'board/pages/' . $board);
			exit;
		}
		else {
			// set the page title
			$this->view->pagetitle = 'Forum | Operation Braveheart';
			// get an array of additional stylesheets
			$this->view->style = 'forum';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form.validate'));
			// set the content heading
			$this->view->heading = 'Forum';
			// set the large content image
			$this->view->largeimg = 'forum.jpg';
			$this->view->alt = 'Forum';
			
			// display the breadcrumbs
			$nav_array = array(array('url' => URL, 'name' => 'Home'),
							   array('url' => URL . 'forum', 'name' => 'Forum'),
							   array('url' => URL . 'board/pages/'.$board, 'name' => $boardname),
							   array('url' => URL . 'board/pages/'.$board.'/reply', 'name' => 'New Topic')
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			// set the errors from failed validation
			$this->view->errors = $errors;
			// set the form data so user doesn't have to re-enter
			$this->view->data = $data;
			
			//render the html
			$this->view->render('header');
			$this->view->render('forum/errors/create');
			$this->view->render('footer');
		}
	}
}