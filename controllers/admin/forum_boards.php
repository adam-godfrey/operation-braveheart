<?php

class Forum_Boards extends Controller {
	
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
					header('Location: ' . URL . 'admin/forum-boards/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/forum-boards/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->boardDelete($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}

		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Forum Boards | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Forum Boards';
		$this->view->adminlrgimg = 'boards.jpg';
		$this->view->alt = 'Forum Boards';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-boards", "name" => "Forum Boards")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'edit', 'delete', 'add');
		
		// truncate the news content
		extract($this->model->boardsIndex($this->entries_per_page));
		
		$this->view->boards = $rows;
		
		$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/forum-boards', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/forum-boards/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
		
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/forum-boards/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/forum-boards/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->boardDelete($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}

		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Forum Boards | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Forum Boards';
		$this->view->adminlrgimg = 'boards.jpg';
		$this->view->alt = 'Forum Boards';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-boards", "name" => "Forum Boards")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'edit', 'delete', 'add');
		
		// truncate the news content
		extract($this->model->boardsIndex($this->entries_per_page, (int) $arg));
		
		$this->view->boards = $rows;
		
		$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/forum-boards', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/forum-boards/index');
		$this->view->render('footer');
    }
		
	public function add() {

		$this->view->pagetitle = 'Add Forum Board | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Add Forum Board';
		$this->view->adminlrgimg = 'boards.jpg';
		$this->view->alt = 'Add Forum Board';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-boards", "name" => "Forum Boards"),
			array("url" => URL . "admin/forum-boards/add", "name" => "Add Forum Board"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save');
		
		if(empty($_POST['action'])) {
		
			$this->view->render('header');
			$this->view->render('admin/forum-boards/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
				
					$data = array();
					
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['board_title']))));
					$data['description'] = trim(htmlspecialchars($_POST['board_desc']));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Board Name');
					$validators[]=new ValidateEmpty($data['description'],'Board Description');
					
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
					
						$this->view->success = $this->model->boardAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/forum-boards/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/forum-boards/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/forum-boards');
					break;
				default:
			}
		}
	}
	
	public function edit($arg = '') {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Edit Forum Board | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit Forum Board';
		$this->view->adminlrgimg = 'boards.jpg';
		$this->view->alt = 'Edit Forum Board';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-boards", "name" => "Forum Boards"),
			array("url" => URL . "admin/forum-boards/edit", "name" => "Edit Forum Board"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'edit');
			
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {

				// truncate the boards content
				extract($this->model->boardsIndex($this->entries_per_page));
				
				$this->view->boards = $rows;
				
				$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/forum-boards', 'pages') : '';
				
				$this->view->render('header');
				$this->view->render('admin/forum-boards/index');
				$this->view->render('footer');
			}
			else {
				
				// truncate the boards content
				extract($this->model->boardContent((int) $arg));
				
				$this->view->boards = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/forum-boards/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save': 
					$data = array();
					
					$data['id'] = $_POST['id'];
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['board_title']))));
					$data['description'] = trim(htmlspecialchars($_POST['board_desc']));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Board Name');
					$validators[]=new ValidateEmpty($data['description'],'Board Description');
					
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
					
						$this->view->success = $this->model->boardEdit($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/forum-boards/edit');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/forum-boards/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/forum-boards');
					break;
				default:
			}
		}
	}
		
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Delete Forum Board | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Forum Board';
		$this->view->adminlrgimg = 'boards.jpg';
		$this->view->alt = 'Delete Forum Board';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-boards", "name" => "Forum Boards"),
			array("url" => URL . "admin/forum-boards/delete", "name" => "Delete Forum Board"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');

		if(empty($_POST['action'])) {
	
			// truncate the boards content
			extract($this->model->boardsIndex($this->entries_per_page));
			
			$this->view->boards = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/forum-boards', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/forum-boards/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
					
					// submit the comment for moderation
					$this->view->success = $this->model->boardDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/forum-boards/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/forum-boards');
					break;
				default:
			}
		}
	}
}