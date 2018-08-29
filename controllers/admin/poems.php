<?php

class Poems extends Controller {
	
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
					header('Location: ' . URL . 'admin/poems/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/poems/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->poemDelete($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Poems | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Poems';
		$this->view->adminlrgimg = 'poems.jpg';
		$this->view->alt = 'Poems';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/poems", "name" => "Poems")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'edit', 'delete', 'add');
		
		// truncate the poems content
		extract($this->model->poemsIndex($this->entries_per_page));
		
		$this->view->poems = $rows;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/poems', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/poems/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/poems/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/poems/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->poemDelete($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Poems | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Poems';
		$this->view->adminlrgimg = 'poems.jpg';
		$this->view->alt = 'Poems';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/poems", "name" => "Poems")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'edit', 'delete', 'add');
		
		// truncate the poems content
		extract($this->model->poemsIndex($this->entries_per_page, (int) $arg));
		
		$this->view->poems = $rows;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/poems', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/poems/index');
		$this->view->render('footer');
	}
		
	public function add() {
		
		$this->view->pagetitle = 'Add Poem | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Add Poem';
		$this->view->adminlrgimg = 'poems.jpg';
		$this->view->alt = 'Add Poem';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/poems", "name" => "Poems"),
			array("url" => URL . "admin/poems/add", "name" => "Add Poem"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save');
			
		if(empty($_POST['action'])) {

			$this->view->render('header');
			$this->view->render('admin/poems/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
				
					$data = array();
					
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['poem_title']))));
					$data['author'] = trim(htmlspecialchars(ucwords(strtolower($_POST['poem_author']))));
					$data['content'] = trim(htmlspecialchars($_POST['poem_content']));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'], 'Poem Title');
					$validators[]=new ValidateName($data['author'], 'Poem Author');
					$validators[]=new ValidateEmpty($data['content'], 'Poem Content');
					
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
					
						$this->view->success = $this->model->poemAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/poems/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/poems/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/poems');
					break;
				default:
			}
		}
	}
		
	public function edit($arg = '') {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Poems | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit Poem';
		$this->view->adminlrgimg = 'poems.jpg';
		$this->view->alt = 'Edit Poem';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/poems", "name" => "Poems"),
			array("url" => URL . "admin/poems/edit", "name" => "Edit Poem"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
				$this->view->buttons = array('back', 'edit');

				// truncate the poems content
				extract($this->model->poemsIndex($this->entries_per_page));
				
				$this->view->poems = $rows;
				
				$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/poems', 'pages') : '';
				
				$this->view->render('header');
				$this->view->render('admin/poems/index');
				$this->view->render('footer');
			}
			else {
				$this->view->buttons = array('back', 'save');
				// truncate the poems content
				extract($this->model->poemContent((int) $arg));
				
				$this->view->poem = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/poems/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$this->view->buttons = array('back', 'save');
					$data = array();
					
					$data['id'] = $_POST['poemid'];
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['poem_title']))));
					$data['author'] = trim(htmlspecialchars(ucwords(strtolower($_POST['poem_author']))));
					$data['content'] = trim(htmlspecialchars($_POST['poem_content']));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'], 'Poem Title');
					$validators[]=new ValidateName($data['author'], 'Poem Author');
					$validators[]=new ValidateEmpty($data['content'], 'Poem Content');
					
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
					
						$this->view->success = $this->model->poemEdit($data);
						
						$this->view->poem = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/poems/edit');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/poems/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/poems');
					break;
				default:
			}
		}
	}
	
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Poems | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Poem';
		$this->view->adminlrgimg = 'poems.jpg';
		$this->view->alt = 'Delete Poem';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/poems", "name" => "Poems"),
			array("url" => URL . "admin/poems/delete", "name" => "Delete Poem"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');

		if(empty($_POST['action'])) {
	
			// truncate the poems content
			extract($this->model->poemsIndex($this->entries_per_page));
			
			$this->view->poems = $rows;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/poems', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/poems/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
					
					// submit the comment for moderation
					$this->view->success = $this->model->poemDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/poems/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/poems');
					break;
				default:
			}
		}
	}
}