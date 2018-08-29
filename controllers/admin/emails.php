<?php

class Emails extends Controller {
	
	private $entries_per_page;
	
    public function __construct() {
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		if(empty($_POST['action'])) {
		
			$this->entries_per_page = 15;
			
			$this->view->pagetitle = 'Emails | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Emails';
			$this->view->adminlrgimg = 'emails.jpg';
			$this->view->alt = 'Emails';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/emails", "name" => "Emails")	
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'reply', 'delete', 'archive');
			
			// truncate the emails content
			extract($this->model->emailsIndex($this->entries_per_page));
			
			$this->view->emails = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'emails', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/emails/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
			
				case 'delete':
					$this->model->emailDelete($_POST['id']);
					
					header('Location: ' . URL . 'admin/emails');
					break;
				case 'reply':
					$this->model->emailReply($_POST['id']);
					
					header('Location: ' . URL . 'admin/emails');
					break;
				case 'archive':
					$this->model->emailArchive($_POST['id']);
					
					header('Location: ' . URL . 'admin/emails');
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
    }
		
	public function reply($arg = '') {
		
		$this->view->pagetitle = 'Emails | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Reply To  Email';
		$this->view->adminlrgimg = 'emails.jpg';
		$this->view->alt = 'Reply To  Email';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/emails", "name" => "Emails"),
			array("url" => URL . "admin/emails/reply", "name" => "Reply"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
		if(empty($_POST['action'])) {

			// truncate the emails content
			extract($this->model->emailsContent((int) $arg));
			
			$this->view->emails = $rows;
			
			$this->view->render('header');
			$this->view->render('admin/emails/reply');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save': 
					$this->model->replyEmail((int) $_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin/emails');
					break;
				default:
			}
		}
	}
	
	public function delete() {
	
		if(empty($_POST['action'])) {
	
			$this->entries_per_page = 15;
		
			$this->view->pagetitle = 'Emails | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Delete Email';
			$this->view->adminlrgimg = 'emails.jpg';
			$this->view->alt = 'Delete Email';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/emails", "name" => "Emails"),
				array("url" => URL . "admin/emails/delete", "name" => "Delete Email"),
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);

			
			$this->view->buttons = array('back', 'delete');
			
			// truncate the emails content
			extract($this->model->emailsIndex($this->entries_per_page));
			
			$this->view->emails = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'emails', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/emails/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
					$this->model->emailsDelete($_POST['id']);
					header('Location: ' . URL . 'admin/emails');
					break;
				case 'back':
					header('Location: ' . URL . 'admin/emails');
					break;
				default:
			}
		}
	}
	
	public function archive() {
	
		if(empty($_POST['action'])) {
	
			$this->entries_per_page = 15;
		
			$this->view->pagetitle = 'Emails | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Archive Email';
			$this->view->adminlrgimg = 'email.jpg';
			$this->view->alt = 'Archive Email';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/emails", "name" => "Emails"),
				array("url" => URL . "admin/emails/archive", "name" => "Archive Email"),
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'archive');
			
			// truncate the email content
			extract($this->model->emailIndex($this->entries_per_page));
			
			$this->view->email = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'email', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/emails/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'archive':
					$this->model->emailArchive($_POST['id']);
					header('Location: ' . URL . 'admin/emails');
					break;
				case 'back':
					header('Location: ' . URL . 'admin/emails');
					break;
				default:
			}
		}
	}
}