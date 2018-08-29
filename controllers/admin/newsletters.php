<?php

class Newsletters extends Controller {
	
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
					header('Location: ' . URL . 'admin/newsletters/create');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/newsletters/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->newsletterDelete($_POST['id']);
					
					break;
				case 'send':
					$this->view->success = $this->model->newsletterSend($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		
		$this->view->pagetitle = 'Newsletters | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'newsletters';
		$this->view->imgclass = 'newsletterslrgimg';
		$this->view->largeimg = 'newsletters.jpg';
		$this->view->alt = 'Newsletters';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/newsletters", "name" => "Newsletters")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'send', 'add');
		
		// truncate the newsletter content
		extract($this->model->newslettersIndex($this->entries_per_page));;
		
		$unsent = array();
		$sent = array();
		
		if(!empty($rows)) {
			foreach($rows as $key => $row) {
				switch($row['sent']) {
					case 0:
						$unsent[$key] = $row;
						break;
					case 1:
						$sent[$key] = $row;
						break;
					default:
				}
			}
		}
		
		$this->model->debug($rows);
		exit;
		
		$this->view->unsent_newsletters = $unsent;
		$this->view->sent_newsletters = $sent;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/newsletters', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/newsletters/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/newsletters/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/newsletters/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->newsletterDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->newsletterArchive($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		 
		$this->view->pagetitle = 'Newsletters | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Newsletters';
		$this->view->imgclass = 'newsletterslrgimg';
		$this->view->largeimg = 'newsletters.jpg';
		$this->view->alt = 'Newsletters';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/newsletters", "name" => "Newsletters")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'send', 'add');
		
		// truncate the newsletter content
		extract($this->model->newsletterIndex($this->entries_per_page, (int) $arg));;
		
		$unsent = array();
		$sent = array();
		
		if(!empty($rows)) {
			foreach($rows as $key => $row) {
				switch($row['sent']) {
					case 0:
						$unsent[$key] = $row;
						break;
					case 1:
						$sent[$key] = $row;
						break;
					default:
				}
			}
		}
		
		$this->view->unsent_newsletters = $unsent;
		$this->view->sent_newsletters = $sent;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/newsletters', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/newsletters/index');
		$this->view->render('footer');
	}
	
	public function add() {
	
		$this->view->pagetitle = 'Add Newsletter | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin', 'jquery.admin-newsletter'));
		$this->view->heading = 'Add Newsletter';
		$this->view->imgclass = 'newsletterslrgimg';
		$this->view->largeimg = 'newsletters.jpg';
		$this->view->alt = 'Add Newsletter';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/newsletters", "name" => "Newsletters"),
			array("url" => URL . "admin/newsletters/add", "name" => "Add Newsletter"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save', 'preview');
		
		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Newsletter Preview',
			'content' => '<h2 id="preview-heading"></h2>'
		);
		
		if(empty($_POST['action'])) {
	
			$this->view->render('header');
			$this->view->render('admin/newsletters/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
					// remove submit from POST array
					unset($_POST['submit']);
					
					$data = array();
					$temp = array();
					
					foreach($_POST as $key => $value) {
						switch($key) {
							case 'newsletter_title':
								$data['title'] = $value;
								break;
							case 'intro':
								$data['intro'] = $value;
								break;
							default:
								$temp[$key] = $value;
						}
					}
					
					$data['body'] = json_encode($temp);
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Newsletter Title');
					$validators[]=new ValidateEmpty($data['intro'],'Intro Message');
					(!empty($data['body'])) ? $validators[]=new ValidateEmpty($data['body'],'Newsletter Content') : '';
					
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
					
						$this->model->newsletterAdd($data);
						
						$this->view->success = $this->model->newsletterAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/newsletters/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/newsletters/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin/newsletters');
					break;
				default:
			}
		}
	}
	
	public function edit($arg = '') {
		
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin', 'jquery.admin-newsletter'));
	
		$this->view->heading = 'Edit Newsletter';
		$this->view->adminlrgimg = 'newsletters.jpg';
		$this->view->alt = 'Edit Newsletter';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/newsletters", "name" => "Newsletters"),
			array("url" => URL . "admin/newsletters/edit", "name" => "Edit Newsletter"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
		if(empty($_POST['action'])) {
		
			$this->view->buttons = array('back', 'edit');
			
			if(empty($arg)) {
			
				$this->entries_per_page = 15;

				// truncate the newsletters content
				extract($this->model->newslettersIndex($this->entries_per_page));
				
				$this->view->newsletters = $rows;
				
				$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'newsletters', 'pages') : '';
				
				$this->view->render('header');
				$this->view->render('admin/newsletters/index');
				$this->view->render('footer');
			}
			else {
				
				// truncate the newsletters content
				extract($this->model->newslettersContent((int) $arg));
				//$this->model->debug($rows);
				//exit;
				$this->view->newsletter = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/newsletters/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save': 
					// remove submit from POST array
					unset($_POST['submit']);
					
					$data = array();
					$temp = array();
					
					foreach($_POST as $key => $value) {
						switch($key) {
							case 'newsletter_title':
								$data['title'] = $value;
								break;
							case 'intro':
								$data['intro'] = $value;
								break;
							default:
								$temp[$key] = $value;
						}
					}
					
					$data['body'] = json_encode($temp);
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Newsletter Title');
					$validators[]=new ValidateEmpty($data['intro'],'Intro Message');
					(!empty($data['body'])) ? $validators[]=new ValidateEmpty($data['body'],'Newsletter Content') : '';
					
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
					
						$this->model->newsletterAdd($data);
						
						$this->view->success = $this->model->newsletterAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/newsletters/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/newsletters/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin/newsletters');
					break;
				default:
			}
		}
	}
	
	public function delete() {
	
		if(empty($_POST['action'])) {
	
			$this->entries_per_page = 15;
		
			$this->view->pagetitle = 'Newsletter | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Delete Newsletter';
			$this->view->adminlrgimg = 'newsletters.jpg';
			$this->view->alt = 'Delete Newsletter';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/newsletters", "name" => "Newsletters"),
				array("url" => URL . "admin/newsletters/delete", "name" => "Delete Newsletter"),
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'delete');
			
			// truncate the newsletters content
			extract($this->model->newslettersIndex($this->entries_per_page));
			
			$this->view->newsletters = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'newsletters', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/newsletters/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
					$this->model->newslettersDelete($_POST['id']);
					header('Location: ' . URL . 'admin/newsletters');
					break;
				case 'back':
					header('Location: ' . URL . 'admin/newsletters');
					break;
				default:
			}
		}
	}
}