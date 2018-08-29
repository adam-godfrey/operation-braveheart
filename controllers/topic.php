<?php

class Topic extends Controller {
		
	private $entries_per_page;
	
    function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
    }
    
	public function pages($board, $topic, $page = false) {
	
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
		$this->view->largeimg = 'forum.png';
		$this->view->alt = 'Forum';
		
		$boardid = substr($board, 0, strpos($board, '_'));
		$boardname = str_replace('_', ' ', ucwords(substr($board, strpos($board, '_')+1)));
		$topicid = substr($topic, 0, strpos($topic, '_'));
		$topicname = str_replace('_', ' ', ucwords(substr($topic, strpos($topic, '_')+1)));
	
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "forum", "name" => "Forum"),
						   array("url" => URL . "board/pages/".$board, "name" => $boardname),
						   array("url" => URL . "topic/pages/".$board.'/'.$topic, "name" => $topicname)
		);
		
		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// update the topics table to increment another topic view
		$this->model->updateTopics($topicid);
		// get the rows returned from database
		extract($this->model->getPosts($topicid, $this->entries_per_page, $page));
		
		$this->view->board = $board;
		$this->view->topic = $topic;

		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'topic', 'pages/'.$board.'/'.$topic) : '';
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
		$this->view->render('forum/topic');
		$this->view->render('footer');
    }
	
	public function view($board, $topic, $page = false) {
	
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
		$this->view->largeimg = 'forum.png';
		$this->view->alt = 'Forum';
		
		$boardid = substr($board, 0, strpos($board, '_'));
		$boardname = str_replace('_', ' ', ucwords(substr($board, strpos($board, '_')+1)));
		$topicid = substr($topic, 0, strpos($topic, '_'));
		$topicname = str_replace('_', ' ', ucwords(substr($topic, strpos($topic, '_')+1)));
	
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "forum", "name" => "Forum"),
						   array("url" => URL . "board/pages/".$board, "name" => $boardname),
						   array("url" => URL . "topic/pages/".$board.'/'.$topic, "name" => $topicname)
		);
		
		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// update the topics table to increment another topic view
		$this->model->updateTopics($topicid);
		// get the rows returned from database
		extract($this->model->getPosts($topicid, $this->entries_per_page, $page));
		
		$this->view->board = $board;
		$this->view->topic = $topic;

		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'topic', 'pages/'.$board.'/'.$topic) : '';
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
		$this->view->render('forum/topic');
		$this->view->render('footer');
	}
	
	public function reply($board, $topic, $messageid = false) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Forum | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'forum';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form.validate'));
		// set the content heading
		$this->view->heading = 'Forum';
		// set the large content image
		$this->view->largeimg = 'forum.png';
		$this->view->alt = 'Forum';
		
		$boardid = substr($board, 0, strpos($board, '_'));
		$boardname = str_replace('_', ' ', ucwords(substr($board, strpos($board, '_')+1)));
		$topicid = substr($topic, 0, strpos($topic, '_'));
		$topicname = str_replace('_', ' ', ucwords(substr($topic, strpos($topic, '_')+1)));
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "forum", "name" => "Forum"),
						   array("url" => URL . "board/pages/" . $board, "name" => $boardname),
						   array("url" => URL . "topic/pages/" . $board . '/' . $topic, "name" => $topicname),
						   array("url" => URL . "reply", "name" => "Reply")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getPosts($topic, $this->entries_per_page));	
		// set the news to be displayed
		$this->view->forum = $rows;
		
		$this->view->board = $board;
		$this->view->topic = $topic;
		$this->view->message = isset($messageid) ? '[QUOTE="'.$rows[0]['mauthor'].'"]'.OBForum::nl2br_revert_bis($rows[0]['message']).'[/QUOTE]' : '';
		
		if($messageid != false) $this->view->messageid = $messageid;
	
		//render the html
		$this->view->render('header');
		$this->view->render('forum/reply');
		$this->view->render('footer');

	}
	
	public function postreply() {
	
		$message= htmlspecialchars($_POST['topicmessage']);
		$board = htmlspecialchars($_POST['board']);
		$topic = $_POST['topic'];
		
		$boardid = substr($board, 0, strpos($board, '_'));
		$boardname = str_replace('_', ' ', ucwords(substr($board, strpos($board, '_')+1)));
		$topicid = substr($topic, 0, strpos($topic, '_'));
		$topicname = str_replace('_', ' ', ucwords(substr($topic, strpos($topic, '_')+1)));
		
		// create an array of POST variables from user input
		$data = array();
		$data['boardid'] = $boardid;
		$data['topicid'] = $topicid;
		$data['message'] = $message;
		$data['author'] = Session::get('username');
		
		// create an array for errors
		$errors = array();
		// Collection of validators
		$validators = array();

		$validators[]=new ValidateEmpty($message,'Comment');

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
			$this->model->postReply($data);
			// and redirect back to their comment so they know it's submitted
			header('location: ' . URL . 'forum/view/' . $board . '/' . $topic);
			exit;
		}
		else {
			// set the number of results to be displayed on the page
			$this->entries_per_page = 6;
			// set the page title
			$this->view->pagetitle = 'Forum | Operation Braveheart';
			// get an array of additional stylesheets
			$this->view->style = 'forum';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form.validate'));
			// set the content heading
			$this->view->heading = 'Forum';
			// set the large content image
			$this->view->largeimg = 'forum.png';
			$this->view->alt = 'Forum';
			
			$this->view->board = $_POST['board'];
			$this->view->topic = $_POST['topic'];
			
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
							   array("url" => URL . "forum", "name" => "Forum"),
							   array("url" => URL . "board/pages/" . $board, "name" => $boardname),
							   array("url" => URL . "topic/pages/" . $board . '/' . $topic, "name" => $topicname),
							   array("url" => URL . "reply", "name" => "Reply")
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			// get the rows returned from database
			extract($this->model->getPosts($topicid, $this->entries_per_page, $page));	
			// set the news to be displayed
			$this->view->forum = $rows;
			
			// create the paging 
			$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'topic', 'reply') : '';
		
			// set the errors from failed validation
			$this->view->errors = $errors;
			// set the form data so user doesn't have to re-enter
			$this->view->data = $data;
			
			//render the html
			$this->view->render('header');
			$this->view->render('forum/errors/reply');
			$this->view->render('footer');
		}
	}
}