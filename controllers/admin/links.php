<?php

class Links extends Controller {
	
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
					header('Location: ' . URL . 'admin/links/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/links/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->linkDelete($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Links | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Links';
		$this->view->adminlrgimg = 'links.jpg';
		$this->view->alt = 'Links';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/links", "name" => "Links")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'edit', 'delete', 'add');
		
		// truncate the links content
		extract($this->model->linksIndex($this->entries_per_page));
		
		$this->view->links = $rows;
		
		$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/links', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/links/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/links/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/links/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->linkDelete($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		
			$this->entries_per_page = 15;
			
			$this->view->pagetitle = 'Links | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Links';
			$this->view->adminlrgimg = 'links.jpg';
			$this->view->alt = 'Links';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/links", "name" => "Links")	
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'edit', 'delete', 'add');
			
			// truncate the links content
			extract($this->model->linksIndex($this->entries_per_page, (int) $arg));
			
			$this->view->links = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/links', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/links/index');
			$this->view->render('footer');
		}
	}
		
	public function add() {
		
		$this->view->pagetitle = 'Add Link | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Add Link';
		$this->view->adminlrgimg = 'links.jpg';
		$this->view->alt = 'Add Link';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/links", "name" => "Links"),
			array("url" => URL . "admin/links/add", "name" => "Add Link"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save');
			
		if(empty($_POST['action'])) {

			$this->view->render('header');
			$this->view->render('admin/links/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
				
					$data = array();
					
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['website_name']))));
					$data['url'] = trim(htmlspecialchars($_POST['website_url']));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Website Name');
					$validators[]=new ValidateUrl($data['url'],'Website URL');
					
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
					
						$this->view->success = $this->model->linkAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/links/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/links/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/links');
					break;
				default:
			}
		}
	}
		
	public function edit($arg = '') {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Links | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit Link';
		$this->view->adminlrgimg = 'links.jpg';
		$this->view->alt = 'Edit Link';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/links", "name" => "Links"),
			array("url" => URL . "admin/links/edit", "name" => "Edit Link"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
				$this->view->buttons = array('back', 'edit');
				
				// truncate the links content
				extract($this->model->linksIndex($this->entries_per_page));
				
				$this->view->links = $rows;
				
				$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/links', 'pages') : '';
				
				$this->view->render('header');
				$this->view->render('admin/links/index');
				$this->view->render('footer');
			}
			else {
				$this->view->buttons = array('back', 'save');
				
				// truncate the links content
				extract($this->model->linksContent((int) $arg));
				
				$this->view->links = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/links/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save': 
					$this->view->buttons = array('back', 'save');
					
					$data = array();
					
					$data['id'] = $_POST['linkid'];
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['website_name']))));
					$data['url'] = trim(htmlspecialchars($_POST['website_url']));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Website Name');
					$validators[]=new ValidateUrl($data['url'],'Website URL');
					
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
					
						$this->view->success = $this->model->linkEdit($data);
						
						$this->view->links = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/links/edit');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/links/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/links');
					break;
				default:
			}
		}
	}
	
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Links | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Link';
		$this->view->adminlrgimg = 'links.jpg';
		$this->view->alt = 'Delete Link';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/links", "name" => "Links"),
			array("url" => URL . "admin/links/delete", "name" => "Delete Link"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');

		if(empty($_POST['action'])) {
	
			// truncate the links content
			extract($this->model->linksIndex($this->entries_per_page));
			
			$this->view->links = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/links', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/links/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
					
					// submit the comment for moderation
					$this->view->success = $this->model->linkDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/links/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/links');
					break;
				default:
			}
		}
	}
}