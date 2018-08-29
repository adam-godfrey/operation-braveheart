<?php

class Sponsors extends Controller {
	
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
					header('Location: ' . URL . 'admin/sponsors/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/sponsors/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->sponsorDelete($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Sponsors | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Sponsors';
		$this->view->adminlrgimg = 'sponsors.jpg';
		$this->view->alt = 'Sponsors';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/sponsors", "name" => "Sponsors")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'edit', 'delete', 'add');
		
		// truncate the sponsors content
		extract($this->model->sponsorsIndex($this->entries_per_page));
		
		$this->view->sponsors = $rows;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/sponsors', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/sponsors/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/sponsors/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/sponsors/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->sponsorDelete($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Sponsors | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Sponsors';
		$this->view->adminlrgimg = 'sponsors.jpg';
		$this->view->alt = 'Sponsors';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/sponsors", "name" => "Sponsors")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'edit', 'delete', 'add');
		
		// truncate the sponsors content
		extract($this->model->sponsorsIndex($this->entries_per_page, (int) $arg));
		
		$this->view->sponsors = $rows;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/sponsors', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/sponsors/index');
		$this->view->render('footer');
	}
		
	public function add() {
		
		$this->view->pagetitle = 'Add Sponsor | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Add Sponsor';
		$this->view->adminlrgimg = 'sponsors.jpg';
		$this->view->alt = 'Add Sponsor';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/sponsors", "name" => "Sponsors"),
			array("url" => URL . "admin/sponsors/add", "name" => "Add Sponsor"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save');
			
		if(empty($_POST['action'])) {

			$this->view->render('header');
			$this->view->render('admin/sponsors/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
				
					$data = array();
					
					$data['name'] = trim(htmlspecialchars(ucwords(strtolower($_POST['sponsor_name']))));
					$data['location'] = trim(htmlspecialchars(ucwords(strtolower($_POST['sponsor_location']))));
					$data['url'] = trim(htmlspecialchars($_POST['sponsor_url']));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['name'], 'Sponsor Name');
					$validators[]=new ValidateSubject($data['location'], 'Sponsor Location');
					$validators[]=new ValidateUrl($data['url'], 'Sponsor URL');
					
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
					
						$this->view->success = $this->model->sponsorAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/sponsors/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/sponsors/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/sponsors');
					break;
				default:
			}
		}
	}
		
	public function edit($arg = '') {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Sponsors | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit Sponsor';
		$this->view->adminlrgimg = 'sponsors.jpg';
		$this->view->alt = 'Edit Sponsor';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/sponsors", "name" => "Sponsors"),
			array("url" => URL . "admin/sponsors/edit", "name" => "Edit Sponsor"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
				$this->view->buttons = array('back', 'edit');

				// truncate the sponsors content
				extract($this->model->sponsorsIndex($this->entries_per_page));
				
				$this->view->sponsors = $rows;
				
				$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/sponsors', 'pages') : '';
				
				$this->view->render('header');
				$this->view->render('admin/sponsors/index');
				$this->view->render('footer');
			}
			else {
				$this->view->buttons = array('back', 'save');
				// truncate the sponsors content
				extract($this->model->sponsorsContent((int) $arg));
				
				$this->view->sponsors = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/sponsors/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$this->view->buttons = array('back', 'save');
					$data = array();
					
					$data['id'] = $_POST['sponsorid'];
					$data['name'] = trim(htmlspecialchars(ucwords(strtolower($_POST['sponsor_name']))));
					$data['location'] = trim(htmlspecialchars(ucwords(strtolower($_POST['sponsor_location']))));
					$data['url'] = trim(htmlspecialchars($_POST['sponsor_url']));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['name'], 'Sponsor Name');
					$validators[]=new ValidateSubject($data['location'], 'Sponsor Location');
					$validators[]=new ValidateUrl($data['url'], 'Sponsor URL');
					
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
					
						$this->view->success = $this->model->sponsorEdit($data);
						
						$this->view->sponsors = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/sponsors/edit');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/sponsors/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/sponsors');
					break;
				default:
			}
		}
	}
	
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Sponsors | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Sponsor';
		$this->view->adminlrgimg = 'sponsors.jpg';
		$this->view->alt = 'Delete Sponsor';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/sponsors", "name" => "Sponsors"),
			array("url" => URL . "admin/sponsors/delete", "name" => "Delete Sponsor"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');

		if(empty($_POST['action'])) {
	
			// truncate the sponsors content
			extract($this->model->sponsorsIndex($this->entries_per_page));
			
			$this->view->sponsors = $rows;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/sponsors', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/sponsors/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
					
					// submit the comment for moderation
					$this->view->success = $this->model->sponsorDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/sponsors/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/sponsors');
					break;
				default:
			}
		}
	}
}