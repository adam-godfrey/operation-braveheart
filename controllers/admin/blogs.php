<?php

class Blogs extends Controller {
	
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
					header('Location: ' . URL . 'admin/blogs/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/blogs/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->blogDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->blogArchive($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		
		$this->view->pagetitle = 'Blogs | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Blogs';
		$this->view->imgclass = 'blogslrgimg';
		$this->view->largeimg = 'blogs.jpg';
		$this->view->alt = 'Blogs';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/blogs", "name" => "Blogs")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
		
		// truncate the blog content
		extract($this->model->blogIndex($this->entries_per_page));;
		
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
		
		$this->view->active_blogs = $active;
		$this->view->archived_blogs = $archived;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/blogs', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/blogs/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/blogs/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/blogs/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->blogDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->blogArchive($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		 
		$this->view->pagetitle = 'Blogs | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Blogs';
		$this->view->imgclass = 'blogslrgimg';
		$this->view->largeimg = 'blogs.jpg';
		$this->view->alt = 'Blogs';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/blogs", "name" => "Blogs")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
		
		// truncate the blog content
		extract($this->model->blogIndex($this->entries_per_page, (int) $arg));;
		
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
		
		$this->view->active_blogs = $active;
		$this->view->archived_blogs = $archived;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/blogs', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/blogs/index');
		$this->view->render('footer');
	}
		
	public function add() {
	
		$this->view->pagetitle = 'Add Blog | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Add Blog';
		$this->view->imgclass = 'blogslrgimg';
		$this->view->largeimg = 'blogs.jpg';
		$this->view->alt = 'Add Blog';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/blogs", "name" => "Blogs"),
			array("url" => URL . "admin/blogs/add", "name" => "Add Blog"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save', 'preview');
		
		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Blog Preview',
			'content' => '<h2 id="preview-heading"></h2>'
		);
		
		if(empty($_POST['action'])) {
	
			$this->view->render('header');
			$this->view->render('admin/blogs/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$data = array();
					
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['blog_title']))));
					$data['content'] = trim(htmlspecialchars($_POST['blog_content']));
					$data['image'] = trim(htmlspecialchars($_POST['imgname']));
					$data['keywords'] = trim(htmlspecialchars($_POST['blog_keywords']));
					$data['alternate'] =  trim(htmlspecialchars(substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."))));
					$data['postdate'] = date('Y-m-d');
					$data['author'] = '';
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Blog Title');
					$validators[]=new ValidateEmpty($data['content'],'Blog Content');
					(!empty($_POST['blog_keywords'])) ? $validators[]=new ValidateSubject($data['keywords'],'Keywords') : '';
					
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
					
						$this->view->success = $this->model->blogAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/blogs/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/blogs/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/blogs');
					break;
				default:
			}
		}
	}
		
	public function edit($arg = '') {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Blogs | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit Blogs';
		$this->view->imgclass = 'blogslrgimg';
		$this->view->largeimg = 'blogs.jpg';
		$this->view->alt = 'Edit Blogs';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/blogs", "name" => "Blogs"),
			array("url" => URL . "admin/blogs/edit", "name" => "Edit Blogs"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Blogs Preview',
			'content' => '<h2 id="preview-heading"></h2><div id="preview-content"></div>'
		);

			
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
				$this->view->buttons = array('back', 'edit');
				
				// truncate the blog content
				extract($this->model->blogIndex($this->entries_per_page));
				
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
				
				$this->view->active_blogs = $active;
				$this->view->archived_blogs = $archived;
				
				$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/blogs', 'pages') : '';
						
				$this->view->render('header');
				$this->view->render('admin/blogs/index');
				$this->view->render('footer');
			}
			else {
				$this->view->buttons = array('back', 'save', 'preview');
				// truncate the blog content
				extract($this->model->blogContent((int) $arg));
								
				$this->view->blog = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/blogs/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$this->view->buttons = array('back', 'save', 'preview');
					
					$data = array();
					
					$data['id'] = $_POST['blogid'];
					$data['title'] = $_POST['blog_title'];
					$data['content'] = $_POST['blog_content'];
					$data['image'] = $_POST['imgname'];
					$data['keywords'] = $_POST['blog_keywords'];
					$data['alternate'] =  substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."));
					$data['postdate'] = date('Y-m-d');
					$data['author'] = '';
					
					// create an array for errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Blog Title');
					$validators[]=new ValidateEmpty($data['content'],'Blog Content');
					(!empty($_POST['blog_keywords'])) ? $validators[]=new ValidateSubject($data['keywords'],'Keywords') : '';

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
						$this->view->success = $this->model->blogEdit($data);
						
						$this->view->blog = $data;
						
						//render the html
						$this->view->render('header');
						$this->view->render('admin/blogs/edit');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->blog = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/blogs/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin/blogs');
					break;
				default:
			}
		}
	}
	
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Blogs | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Blogs';
		$this->view->imgclass = 'blogslrgimg';
		$this->view->largeimg = 'blogs.jpg';
		$this->view->alt = 'Delete Blogs';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/blogs", "name" => "Blogs"),
			array("url" => URL . "admin/blogs/delete", "name" => "Delete Blogs"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');
		
		if(empty($_POST['action'])) {
			
			// truncate the blog content
			extract($this->model->blogIndex($this->entries_per_page));
			
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
			
			$this->view->active_blogs = $active;
			$this->view->archived_blogs = $archived;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/blogs', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/blogs/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'delete': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->blogDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/blogs/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/blogs');
					break;
				default:
			}
		}
	}
	
	public function archive() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Blogs | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Archive Blogs';
		$this->view->imgclass = 'blogslrgimg';
		$this->view->largeimg = 'blogs.jpg';
		$this->view->alt = 'Archive Blogs';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/blogs", "name" => "Blogs"),
			array("url" => URL . "admin/blogs/archive", "name" => "Archive Blogs"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'archive');
		
		if(empty($_POST['action'])) {
			
			// truncate the blog content
			extract($this->model->blogIndex($this->entries_per_page));
			
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
			
			$this->view->active_blogs = $active;
			$this->view->archived_blogs = $archived;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/blogs', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/blogs/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'archive': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->blogArchive($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/blogs/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/blogs');
					break;
				default:
			}
		}
	}
}