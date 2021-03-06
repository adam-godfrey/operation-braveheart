<?php

class Articles extends Controller {
		
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
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'news';
		// set the content heading
		$this->view->heading = 'Articles';
		// set the large content image
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Articles';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "articles", "name" => "Articles")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getContent($this->entries_per_page));
		
		// check to see if there any articles to display
		if(!empty($rows)) {
			// set the articles to be displayed
			$this->view->articles = $rows;
			// create the paging 
			$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'articles', 'pages') : '';
			
			// set the counter for the links to the article content
			$this->view->counter = 1;
		}
		else {
			// no articles to display
			$this->view->article = '';
		}
				
		// render the html
        $this->view->render('header');
        $this->view->render('articles/index');
        $this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 6;
		// set the page title
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'news';
		// set the content heading
		$this->view->heading = 'Articles';
		// set the large content image
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Articles';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "articles", "name" => "Articles")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getContent($this->entries_per_page, $arg));
		// set the articles to be displayed
		$this->view->article = $rows;
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'articles', 'pages') : '';
		
		// Get the page number and if we're on the first page start the counter from 1.
		if($page == 1) {
			// counter starts from 1 for the links to the articles content
			$this->view->counter = 1;
		}
		else {
			// counter starts from e.g. (6 * (2-1)) + 1 = 7
			$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
		}
		
		//render the html
        $this->view->render('header');
        $this->view->render('articles/index');
        $this->view->render('footer');
    }
	
	public function view($arg = false) {
	
		$this->model->visitorTracker();
		
		// set the number of results to be displayed on the page
		$this->entries_per_page = 1;
		// set the page title
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news', 'contact-us'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form.validate'));
		// set the content heading
		$this->view->heading = 'Articles';
		// set the large content image
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Articles';
	
		// get the rows returned from database
		extract($this->model->getArticle($this->entries_per_page, (int) $arg));	
		// set the articles to be displayed
		$this->view->articles = $rows;
		
		$this->view->token = $this->model->generateFormToken('Br3@veH3@rt');
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "articles", "name" => "Articles"),
						   array("url" => URL . "articles/" . str_replace(' ', '-', strtolower($rows[0]['title'])), "name" => ucwords(strtolower($rows[0]['title'])))
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'articles', 'pages') : '';
		
		// Get the page number and if we're on the first page start the counter from 1.
		if($page == 1) {
			// counter starts from 1 for the links to the articles content
			$this->view->counter = 1;
		}
		else {
			// counter starts from e.g. (6 * (2-1)) + 1 = 7
			$this->view->counter = ($this->entries_per_page * ($page-1)) + 1;
		}
		
		// set the page number
		$this->view->pageid = $arg;
		
		// set the comments title
		$this->view->article_title = $rows[0]['title'];
		
		// set the comments count
		$this->view->comm_count = $this->model->getCommentsCount($rows[0]['id']);
		// if there are comments in the database for this articles
		if($this->model->getCommentsCount($rows[0]['id']) > 0) {
			// extract it from the database
			extract($this->model->getComments($rows[0]['id']));
			// and set it so they can be viewed
			$this->view->comments = $comments;
		}
		
		//render the html
        $this->view->render('header');
        $this->view->render('articles/view');
        $this->view->render('footer');
    }
	
	public function reply($arg = false) {
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 1;
		// set the page title
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news', 'contact-us'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form.validate'));
		// set the content heading
		$this->view->heading = 'Articles';
		// set the large content image
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Articles';
		
		// get the rows returned from database
		extract($this->model->getArticle($this->entries_per_page, $arg));	
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "articles", "name" => "Article"),
						   array("url" => URL . "articles/" . str_replace(' ', '-', strtolower($rows[0]['title'])), "name" => ucwords(strtolower($rows[0]['title'])))
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
	
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'articles', 'view') : '';
		
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
		
		// set the article to be displayed
		$this->view->articles = $rows;
		// create the paging 
	 
		// set the comments title
		$this->view->article_title = $rows[0]['title'];
		
		// set the comments count
		$this->view->comm_count = $this->model->getCommentsCount($rows[0]['id']);
		// if there are comments in the database for this articles
		if($this->model->getCommentsCount($rows[0]['id']) > 0) {
			// extract it from the database
			extract($this->model->getComments($rows[0]['id']));
			// and set it so they can be viewed
			$this->view->comments = $comments;
		}
			
		if(isset($_POST['send'])) {
			// create an array of POST variables from user input
			$data = array();	
			$data['token'] = $_POST['token'];	
			$data['session'] = 'Br3@veH3@rt_token';
			$data['name'] = $_POST['fullname'];
			$data['email'] = $_POST['email'];
			$data['website'] = $_POST['website'];
			$data['message'] = $_POST['comment'];
			$data['articleid'] = $_POST['articleid'];
			$data['pageid'] = $_POST['pageid'];
			
			// create an array for errors
			$errors = array();
			// Collection of validators
			$validators = array();

			$validators[]=new ValidateName($data['name'],'Name');
			$validators[]=new ValidateEmail($data['email']);
			if(!empty($data['website'])) {
				$validators[]=new ValidateUrl($data['website'], 'Website');
			}
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
			
			// if there are no errors in the form
			if(empty($errors)) {
				// submit the comment for moderation
				$this->view->success = $this->model->submitComment($data);
				
				//render the html
				$this->view->render('header');
				$this->view->render('articles/view');
				$this->view->render('footer');
			}
			else {
				$this->view->token = $this->model->generateFormToken('Br3@veH3@rt');
				// set the errors from failed validation
				$this->view->errors = $errors;
				// set the form data so user doesn't have to re-enter
				$this->view->data = $data;
				
				//render the html
				$this->view->render('header');
				$this->view->render('articles/errors');
				$this->view->render('footer');
			}
		}
		else {
			//render the html
			$this->view->render('header');
			$this->view->render('articles/view');
			$this->view->render('footer');
		}	
	}
}