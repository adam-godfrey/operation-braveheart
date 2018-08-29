<?php

class Articles extends Controller {
	
	private $entries_per_page;
	
    public function __construct() {
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/articles/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/articles/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->articleDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->articleArchive($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Articles';
		$this->view->imgclass = 'articleslrgimg';
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Articles';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/articles", "name" => "Articles")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
		
		// truncate the article content
		extract($this->model->articleIndex($this->entries_per_page));;
		
		$active = array();
		$archived = array();
		
		if(!empty($rows)) {
			foreach($rows as $key => $row) {
				switch($row['archived']) {
					case 0:
						$active[$key] = $row;
						break;
					case 1:
						$archived[$key] = $row;
						break;
					default:
				}
			}
		}
		
		$this->view->active_articles = $active;
		$this->view->archived_articles = $archived;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/articles', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/articles/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/articles/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/articles/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->articleDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->articleArchive($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		 
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Articles';
		$this->view->imgclass = 'articleslrgimg';
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Articles';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/articles", "name" => "Articles")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
		
		// truncate the article content
		extract($this->model->articleIndex($this->entries_per_page, (int) $arg));;
		
		$active = array();
		$archived = array();
		
		foreach($rows as $key => $row) {
			switch($row['archived']) {
				case 0:
					$active[$key] = $row;
					break;
				case 1:
					$archived[$key] = $row;
					break;
				default:
			}
		}	
		
		$this->view->active_articles = $active;
		$this->view->archived_articles = $archived;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/articles', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/articles/index');
		$this->view->render('footer');
	}
		
	public function add() {
	
		$this->view->pagetitle = 'Add Article | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Add Article';
		$this->view->imgclass = 'articleslrgimg';
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Add Article';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/articles", "name" => "Articles"),
			array("url" => URL . "admin/articles/add", "name" => "Add Article"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save', 'preview');
		
		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Article Preview',
			'content' => '<h2 id="preview-heading"></h2>'
		);
		
		if(empty($_POST['action'])) {
	
			$this->view->render('header');
			$this->view->render('admin/articles/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$data = array();
					
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['article_title']))));
					$data['content'] = trim(htmlspecialchars($_POST['article_content']));
					$data['image'] = trim(htmlspecialchars($_POST['imgname']));
					$data['keywords'] = trim(htmlspecialchars($_POST['article_keywords']));
					$data['alternate'] =  trim(htmlspecialchars(substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."))));
					$data['postdate'] = date('Y-m-d');
					$data['author'] = '';
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Article Title');
					$validators[]=new ValidateEmpty($data['content'],'Article Content');
					(!empty($_POST['article_keywords'])) ? $validators[]=new ValidateSubject($data['keywords'],'Keywords') : '';
					
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
					
						$this->view->success = $this->model->articleAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/articles/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/articles/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/articles');
					break;
				default:
			}
		}
	}
		
	public function edit($arg = '') {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit Articles';
		$this->view->imgclass = 'articleslrgimg';
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Edit Articles';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/articles", "name" => "Articles"),
			array("url" => URL . "admin/articles/edit", "name" => "Edit Articles"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Articles Preview',
			'content' => '<h2 id="preview-heading"></h2><div id="preview-content"></div>'
		);

			
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
			
				$this->view->buttons = array('back', 'edit');
				
				// truncate the article content
				extract($this->model->articleIndex($this->entries_per_page));
				
				$active = array();
				$archived = array();
				
				foreach($rows as $key => $row) {
					switch($row['archived']) {
						case 0:
							$active[$key] = $row;
							break;
						case 1:
							$archived[$key] = $row;
							break;
						default:
					}
				}
				
				
				$this->view->active_articles = $active;
				$this->view->archived_articles = $archived;
				
				$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/articles', 'pages') : '';
						
				$this->view->render('header');
				$this->view->render('admin/articles/index');
				$this->view->render('footer');
			}
			else {
				
				$this->view->buttons = array('back', 'save', 'preview');
				
				// truncate the article content
				extract($this->model->articleContent((int) $arg));
								
				$this->view->articles = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/articles/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$this->view->buttons = array('back', 'save', 'preview');
	
					$data = array();
					
					$data['id'] = $_POST['articleid'];
					$data['title'] = $_POST['article_title'];
					$data['content'] = $_POST['article_content'];
					$data['image'] = $_POST['imgname'];
					$data['keywords'] = $_POST['article_keywords'];
					$data['alternate'] =  substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."));
					$data['postdate'] = date('Y-m-d');
					$data['author'] = '';
					
					// create an array for errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateEmpty($data['title'],'Name');
					$validators[]=new ValidateEmpty($data['content'],'Name');

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
						$this->view->success = $this->model->articleEdit($data);
						
						$this->view->articles = $data;
						
						//render the html
						$this->view->render('header');
						$this->view->render('admin/articles/edit');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->articles = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/articles/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin/articles');
					break;
				default:
			}
		}
	}
	
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Articles';
		$this->view->imgclass = 'articleslrgimg';
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Delete Articles';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/articles", "name" => "Articles"),
			array("url" => URL . "admin/articles/delete", "name" => "Delete Articles"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');
		
		if(empty($_POST['action'])) {
			
			// truncate the article content
			extract($this->model->articleIndex($this->entries_per_page));
			
			$active = array();
			$archived = array();
			
			foreach($rows as $key => $row) {
				switch($row['archived']) {
					case 0:
						$active[$key] = $row;
						break;
					case 1:
						$archived[$key] = $row;
						break;
					default:
				}
			}	
			
			$this->view->active_articles = $active;
			$this->view->archived_articles = $archived;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/articles', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/articles/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'delete': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->articleDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/articles/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/articles');
					break;
				default:
			}
		}
	}
	
	public function archive() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Articles | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Archive Articles';
		$this->view->imgclass = 'articleslrgimg';
		$this->view->largeimg = 'articles.jpg';
		$this->view->alt = 'Archive Articles';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/articles", "name" => "Articles"),
			array("url" => URL . "admin/articles/archive", "name" => "Archive Articles"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'archive');
		
		if(empty($_POST['action'])) {
			
			// truncate the article content
			extract($this->model->articleIndex($this->entries_per_page));
			
			$active = array();
			$archived = array();
			
			foreach($rows as $key => $row) {
				switch($row['archived']) {
					case 0:
						$active[$key] = $row;
						break;
					case 1:
						$archived[$key] = $row;
						break;
					default:
				}
			}	
			
			$this->view->active_articles = $active;
			$this->view->archived_articles = $archived;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/articles', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/articles/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'archive': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->articleArchive($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/articles/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/articles');
					break;
				default:
			}
		}
	}
}