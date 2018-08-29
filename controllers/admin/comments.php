<?php

class Comments extends Controller {
	
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
			
				case 'view':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/comments/view/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->commentDelete($_POST['id']);
					break;
				case 'approve':
					$this->view->success = $this->model->commentPublish($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Comments | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Comments';
		$this->view->adminlrgimg = 'comments.jpg';
		$this->view->alt = 'Comments';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/comments", "name" => "Comments")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'thumbs-up', 'thumbs-down');
		
		// truncate the comments content
		extract($this->model->commentsIndex($this->entries_per_page));
	
		$new = array();
		$published = array();
		
		foreach($rows as $key => $row) {
			switch($row['status']) {
				case 0:
					$new[$key] = $row;
					break;
				case 1:
					$published[$key] = $row;
					break;
				default:
			}
		}	
		
		$this->view->new_comments = $new;
		$this->view->published_comments = $published;
		
		$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/comments', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/comments/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
		
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'view':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/comments/view/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->commentDelete($_POST['id']);
					
					break;
				case 'approve':
					$this->view->success = $this->model->commentPublish($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Comments | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Comments';
		$this->view->adminlrgimg = 'comments.jpg';
		$this->view->alt = 'Comments';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/comments", "name" => "Comments")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'thumbs-up', 'thumbs-down');
		
		// truncate the comments content
		extract($this->model->commentsIndex($this->entries_per_page, (int) $arg));
		
		$new = array();
		$published = array();
		
		foreach($rows as $key => $row) {
			switch($row['status']) {
				case 0:
					$new[$key] = $row;
					break;
				case 1:
					$published[$key] = $row;
					break;
				default:
			}
		}	
		
		$this->view->new_comments = $new;
		$this->view->published_comments = $published;
		
		$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/comments', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/comments/index');
		$this->view->render('footer');
    }
		
	public function view($arg = '') {
		
		$this->view->pagetitle = 'Comments | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Approve Comment';
		$this->view->adminlrgimg = 'comments.jpg';
		$this->view->alt = 'Approve Comment';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/comments", "name" => "Comments"),
			array("url" => URL . "admin/comments/view", "name" => "View Comment"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'thumbs-up', 'thumbs-down');
			
		if(empty($_POST['action'])) {

			if(empty($arg)) {
				$new = array();
				$published = array();
				
				foreach($rows as $key => $row) {
					switch($row['status']) {
						case 0:
							$new[$key] = $row;
							break;
						case 1:
							$published[$key] = $row;
							break;
						default:
					}
				}	
				
				$this->view->new_comments = $new;
				$this->view->published_comments = $published;
				
				$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/comments', 'pages') : '';
						
				$this->view->render('header');
				$this->view->render('admin/comments/index');
				$this->view->render('footer');
			}
			else {
			
				// truncate the comment content
				extract($this->model->commentContent((int) $arg));
								
				$this->view->comments = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/comments/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'approve': 
					$this->view->success = $this->model->commentPublish((int) $_POST['id']);
					
					$this->view->render('header');
					$this->view->render('admin/comments/index');
					$this->view->render('footer');
					
					break;
				case 'delete': 
					$this->view->success = $this->model->commentDelete($_POST['id']);
					
					$this->view->render('header');
					$this->view->render('admin/comments/index');
					$this->view->render('footer');
				
					break;
				case 'back':
					header('Location: ' . URL . 'admin/comments');
					break;
				default:
			}
		}
	}
	
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Comments | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Comment';
		$this->view->imgclass = 'commentlrgimg';
		$this->view->largeimg = 'comments.jpg';
		$this->view->alt = 'Delete Comment';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/comments", "name" => "Comments"),
			array("url" => URL . "admin/comments/delete", "name" => "Delete Comments"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');
		
		if(empty($_POST['action'])) {
			
			// truncate the comment content
			extract($this->model->commentsIndex($this->entries_per_page));
			
			$new = array();
			$published = array();
			
			foreach($rows as $key => $row) {
				switch($row['status']) {
					case 0:
						$new[$key] = $row;
						break;
					case 1:
						$published[$key] = $row;
						break;
					default:
				}
			}	
			
			$this->view->new_comments = $new;
			$this->view->published_comments = $published;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/comments', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/comments/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'delete': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->commentDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/comments/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/comments');
					break;
				default:
			}
		}
	}
	
	public function publish() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Comments | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Publish Comment';
		$this->view->imgclass = 'commentlrgimg';
		$this->view->largeimg = 'comments.jpg';
		$this->view->alt = 'Publish Comment';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/comments", "name" => "Comments"),
			array("url" => URL . "admin/comments/publish", "name" => "Publish Comments"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'publish');
		
		if(empty($_POST['action'])) {
			
			// truncate the comment content
			extract($this->model->commentsIndex($this->entries_per_page));
			
			$new = array();
			$published = array();
			
			foreach($rows as $key => $row) {
				switch($row['status']) {
					case 0:
						$new[$key] = $row;
						break;
					case 1:
						$published[$key] = $row;
						break;
					default:
				}
			}	
			
			$this->view->new_comments = $new;
			$this->view->published_comments = $published;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/comments', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/comments/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'publish': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->commentPublish($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/comments/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/comments');
					break;
				default:
			}
		}
	}
}