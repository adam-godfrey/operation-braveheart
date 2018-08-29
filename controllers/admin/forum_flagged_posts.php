<?php

class Forum_Flagged_Posts extends Controller {
	
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
					header('Location: ' . URL . 'admin/forum-flagged-posts/view/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->flaggedPostsDelete($_POST['id']);
					break;
				case 'approve':
					$this->view->success = $this->model->approvePost($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
	
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Flagged Forum Posts | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Flagged Forum Posts';
		$this->view->imgclass = 'forumlrgimg';
		$this->view->adminimg = 'forum.png';
		$this->view->alt = 'Flagged Forum Posts';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-flagged-posts", "name" => "Flagged Forum Posts")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		
		$this->view->buttons = array('back', 'thumbs-up', 'thumbs-down');
		
		// truncate the flaggedposts content
		extract($this->model->flaggedPostsIndex($this->entries_per_page));
		
		$this->view->flaggedposts = $rows;
		
		$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/forum-flagged-posts', 'pages') : '';
		
		// render the html
		$this->view->render('header');
		$this->view->render('admin/flaggedposts/index');
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
					header('Location: ' . URL . 'admin/forum-flagged-posts/view/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->flaggedPostsDelete($_POST['id']);
					break;
				case 'approve':
					$this->view->success = $this->model->approvePost($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
	
		$this->entries_per_page = 15;
			
		$this->view->pagetitle = 'Flagged Forum Posts | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Flagged Forum Posts';
		$this->view->imgclass = 'forumlrgimg';
		$this->view->adminimg = 'forum.png';
		$this->view->alt = 'Flagged Forum Posts';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-flagged-posts", "name" => "Flagged Forum Posts")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		
		$this->view->buttons = array('back', 'thumbs-up', 'thumbs-down');
		
		// truncate the flaggedposts content
		extract($this->model->flaggedPostsIndex($this->entries_per_page, (int) $arg));
		
		$this->view->flaggedposts = $rows;
		
		$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/forum-flagged-posts', 'pages') : '';
		
		// render the html
		$this->view->render('header');
		$this->view->render('admin/flaggedposts/index');
		$this->view->render('footer');
	}
	
	public function view($arg = '') {
		
		$this->view->pagetitle = 'Flagged Forum Posts | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Flagged Forum Posts';
		$this->view->imgclass = 'forumlrgimg';
		$this->view->adminimg = 'forum.png';
		$this->view->alt = 'Flagged Forum Posts';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-flagged-posts", "name" => "Flagged Forum Posts"),
			array("url" => URL . "admin/forum-flagged-posts/view", "name" => "View Flagged Forum Post"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'thumbs-up', 'thumbs-down');
			
		if(empty($_POST['action'])) {

			if(empty($arg)) {

				// truncate the comment content
				extract($this->model->flaggedPostsIndex());
				
				$this->view->posts = $rows;
				
				$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/forum-flagged-posts', 'pages') : '';
						
				$this->view->render('header');
				$this->view->render('admin/flaggedposts/index');
				$this->view->render('footer');
			}
			else {
			
				// truncate the comment content
				extract($this->model->flaggedPostsContent((int) $arg));
								
				$this->view->flaggedposts = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/flaggedposts/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'approve': 
					$this->view->success = $this->model->commentPublish((int) $_POST['id']);
					
					$this->view->render('header');
					$this->view->render('admin/flaggedposts/index');
					$this->view->render('footer');
					
					break;
				case 'delete': 
					$this->view->success = $this->model->commentDelete($_POST['id']);
					
					$this->view->render('header');
					$this->view->render('admin/flaggedposts/index');
					$this->view->render('footer');
				
					break;
				case 'back':
					header('Location: ' . URL . 'admin/forum-flagged-posts');
					break;
				default:
			}
		}
	}
		
	public function approve($arg = '') {
		
		$this->view->pagetitle = 'Approve Forum Post | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Approve Forum Post';
		$this->view->imgclass = 'forumlrgimg';
		$this->view->adminimg = 'forum.png';
		$this->view->alt = 'Approve Forum Post';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/forum-flagged-posts", "name" => "Flagged Forum Posts"),
			array("url" => URL . "admin/forum-flagged-posts/approve", "name" => "Approve Post"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
		if(empty($_POST['action'])) {

			// truncate the flaggedposts content
			extract($this->model->flaggedPostsContent((int) $arg));
			
			$this->view->flaggedposts = $rows;
			
			$this->view->render('header');
			$this->view->render('admin/flaggedposts/edit');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save': 
					$this->model->approvePost((int) $_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin/forum-flagged-posts');
					break;
				default:
			}
		}
	}
	
	public function delete() {
	
		if(empty($_POST['action'])) {
	
			$this->entries_per_page = 15;
		
			$this->view->pagetitle = 'Delete Forum Post | Operation Braveheart';
			$this->view->pagetitle = 'Flagged Forum Posts | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Delete Forum Post';
			$this->view->imgclass = 'flaggedpostslrgimg';
			$this->view->adminimg = 'flagged.png';
			$this->view->alt = 'Delete Forum Post';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/forum-flagged-posts", "name" => "Flagged Forum Posts"),
				array("url" => URL . "admin/forum-flagged-posts/delete", "name" => "Delete Post"),
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'delete');
			
			// truncate the flaggedposts content
			extract($this->model->flaggedPostsIndex($this->entries_per_page));
			
			$this->view->flaggedposts = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'flaggedposts', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/flaggedposts/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
				
					$this->model->flaggedPostsDelete($_POST['id']);
					header('Location: ' . URL . 'admin/forum-flagged-posts');
					break;
				case 'back':
					header('Location: ' . URL . 'admin/forum-flagged-posts');
					break;
				default:
			}
		}
	}
}