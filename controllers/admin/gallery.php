<?php

class Gallery extends Controller {
	
	private $entries_per_page;
	
    public function __construct() {
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		if(empty($_POST['action'])) {
		
			$this->entries_per_page = 15;
			
			$this->view->pagetitle = 'Gallery | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Gallery';
			$this->view->adminlrgimg = 'gallery.jpg';
			$this->view->alt = 'Gallery';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/gallery", "name" => "Gallery")	
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'edit', 'delete', 'add');
			
			// truncate the news content
			extract($this->model->galleryIndex($this->entries_per_page));
			
			$this->view->gallery = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'gallery', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/gallery/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
			
				case 'add':
					header('Location: ' . URL . 'admin/gallery/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/gallery/edit/' . $id);
					break;
				case 'delete':
					$this->model->newsDelete($_POST['id']);
					
					header('Location: ' . URL . 'admin/gallery');
					break;
				case 'archive':
					$this->model->newsArchive($_POST['id']);
					
					header('Location: ' . URL . 'admin/gallery');
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
    }
		
	public function add() {
		
		if(empty($_POST['action'])) {
	
			$this->view->pagetitle = 'Gallery Image Upload | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Gallery Image Upload';
			$this->view->adminlrgimg = 'gallery.jpg';
			$this->view->alt = 'Gallery Image Upload';
			
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/gallery", "name" => "Gallery"),
				array("url" => URL . "admin/gallery/add", "name" => "Add Gallery"),
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'save');
			
			$this->view->render('header');
			$this->view->render('admin/gallery/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$this->model->galleryUpload();
					header('Location: ' . URL . 'admin/gallery');
					break;
				case 'back':
					header('Location: ' . URL . 'admin/gallery');
					break;
				default:
			}
		}
	}
		
	public function edit($arg = '') {
		
		$this->view->pagetitle = 'Gallery Image Edit | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Gallery Image Edit';
		$this->view->adminlrgimg = 'gallery.jpg';
		$this->view->alt = 'Gallery Image Edit';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/gallery", "name" => "Gallery"),
			array("url" => URL . "admin/gallery/edit", "name" => "Edit Gallery"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
			
				$this->entries_per_page = 15;

				$this->view->buttons = array('back', 'edit');
				
				// truncate the news content
				extract($this->model->galleryIndex($this->entries_per_page));
				
				$this->view->gallery = $rows;
				
				$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'gallery', 'pages') : '';
				
				$this->view->render('header');
				$this->view->render('admin/gallery/index');
				$this->view->render('footer');
			}
			else {
				
				// truncate the news content
				extract($this->model->galleryContent((int) $arg));
				
				$this->view->news = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/gallery/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save': 
					$this->model->galleryEdit((int) $_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin/gallery');
					break;
				default:
			}
		}
	}
	
	public function delete() {
	
		if(empty($_POST['action'])) {
	
			$this->entries_per_page = 15;
		
			$this->view->pagetitle = 'Gallery Image Delete | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Gallery Image Delete';
			$this->view->adminlrgimg = 'gallery.jpg';
			$this->view->alt = 'Gallery Image Delete';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/gallery", "name" => "Gallery"),
				array("url" => URL . "admin/gallery/delete", "name" => "Delete Gallery"),
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'delete');
			
			// truncate the news content
			extract($this->model->newsIndex($this->entries_per_page));
			
			$this->view->gallery = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'gallery', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/gallery/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
					$this->model->galleryDelete($_POST['id']);
					header('Location: ' . URL . 'admin/gallery');
					break;
				case 'back':
					header('Location: ' . URL . 'admin/gallery');
					break;
				default:
			}
		}
	}
}