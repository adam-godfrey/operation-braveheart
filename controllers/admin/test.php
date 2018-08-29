<?php

class Test extends Controller {
	
	private $entries_per_page;
	
    public function __construct() {
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		if(empty($_POST['action'])) {
		
			$this->entries_per_page = 10;
			
			$this->view->pagetitle = 'News | Operation Braveheart';
			$this->view->styles = $this->model->setStylesheet(array('contact-us', 'news', 'admin'));
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'News';
			$this->view->imgclass = 'newslrgimg';
			$this->view->largeimg = 'news.jpg';
			$this->view->alt = 'News';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/news", "name" => "News")	
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);

			$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
			
			// truncate the news content
			extract($this->model->newsIndex($this->entries_per_page));;
			
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
			
			$this->view->news_count = count($rows);
			$this->view->active_news = $active;
			$this->view->archived_news = $archived;
			
			$this->view->paging = ((int) $this->view->news_count > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/news', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/news/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
			
				case 'add':
					header('Location: ' . URL . 'admin/news/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/news/edit/' . $id);
					break;
				case 'delete':
					$this->model->newsDelete($_POST['id']);
					
					header('Location: ' . URL . 'admin/news');
					break;
				case 'archive':
					$this->model->newsArchive($_POST['id']);
					
					header('Location: ' . URL . 'admin/news');
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
    }
	
	public function pages($arg = false) {
	
		if(empty($_POST['action'])) {
		
			$this->entries_per_page = 10;
			
			$this->view->pagetitle = 'News | Operation Braveheart';
			$this->view->styles = $this->model->setStylesheet(array('contact-us', 'news', 'admin'));
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'News';
			$this->view->imgclass = 'newslrgimg';
			$this->view->largeimg = 'news.jpg';
			$this->view->alt = 'News';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/news", "name" => "News")	
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);

			$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
			
			// truncate the news content
			extract($this->model->newsIndex($this->entries_per_page, (int) $arg));;
			
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
			
			$this->view->news_count = count($rows);
			$this->view->active_news = $active;
			$this->view->archived_news = $archived;
			
			$this->view->paging = ((int) $this->view->news_count > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/news', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/news/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
			
				case 'add':
					header('Location: ' . URL . 'admin/news/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/news/edit/' . $id);
					break;
				case 'delete':
					$this->model->newsDelete($_POST['id']);
					
					header('Location: ' . URL . 'admin/news');
					break;
				case 'archive':
					$this->model->newsArchive($_POST['id']);
					
					header('Location: ' . URL . 'admin/news');
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
	}
		
	public function add() {
	
		$this->view->pagetitle = 'Add News | Operation Braveheart';
		$this->view->styles = $this->model->setStylesheet(array('contact-us', 'news', 'admin'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Add News';
		$this->view->imgclass = 'newslrgimg';
		$this->view->largeimg = 'news.jpg';
		$this->view->alt = 'Add News';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/news", "name" => "News"),
			array("url" => URL . "admin/news/add", "name" => "Add News"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save', 'preview');
		
		if(empty($_POST['action'])) {
	
			$this->view->render('header');
			$this->view->render('admin/news/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$data = array();
					
					$data['title'] = trim(htmlspecialchars(ucwords(strtolower($_POST['news_title']))));
					$data['content'] = trim(htmlspecialchars($_POST['news_content']));
					$data['photo'] = trim(htmlspecialchars($_POST['imgname']));
					$data['keywords'] = trim(htmlspecialchars($_POST['news_keywords']));
					$data['alternate'] =  trim(htmlspecialchars(substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."))));
					$data['postdate'] = date('Y-m-d');
					$data['author'] = '';
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'News Title');
					$validators[]=new ValidateEmpty($data['content'],'News Content');
					(!empty($_POST['news_keywords'])) ? $validators[]=new ValidateSubject($data['keywords'],'Keywords') : '';
					
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
					
						$this->view->success = $this->model->newsAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/news/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/news/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/news');
					break;
				default:
			}
		}
	}
		
	public function edit($arg = '') {
		
		$this->view->pagetitle = 'News | Operation Braveheart';
		$this->view->styles = $this->model->setStylesheet(array('contact-us', 'news', 'admin'));
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit News';
		$this->view->imgclass = 'newslrgimg';
		$this->view->largeimg = 'news.jpg';
		$this->view->alt = 'Edit News';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/news", "name" => "News"),
			array("url" => URL . "admin/news/edit", "name" => "Edit News"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save', 'preview');
		
		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'News Preview',
			'content' => '<h2 id="preview-heading"></h2>'
		);

			
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
			
				$this->entries_per_page = 15;

				$this->view->buttons = array('back', 'edit');
				
				// truncate the news content
				extract($this->model->newsIndex($this->entries_per_page));

				$this->view->news = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/news/index');
				$this->view->render('footer');
			}
			else {
				
				// truncate the news content
				extract($this->model->newsContent((int) $arg));
								
				$this->view->news = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/news/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save': 
					$data = array();
					
					$data['id'] = $_POST['newsid'];
					$data['title'] = $_POST['news_title'];
					$data['content'] = $_POST['news_content'];
					$data['photo'] = $_POST['imgname'];
					$data['keywords'] = $_POST['news_keywords'];
					$data['alternate'] =  substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."));
					$data['postdate'] = date('Y-m-d');
					$data['author'] = '';
					
					// create an array for errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateEmpty($data['title'],'Name');
					$validators[]=new ValidateEmpty($data['content'],'Name');

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
						$this->view->success = $this->model->newsEdit($data);
						
						$this->view->news = $data;
						
						//render the html
						$this->view->render('header');
						$this->view->render('admin/news/edit');
						$this->view->render('footer');
					}
					else {
						$this->view->news = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/news/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin/news');
					break;
				default:
			}
		}
	}
	
	public function delete() {
	
		if(empty($_POST['action'])) {
	
			$this->entries_per_page = 15;
		
			$this->view->pagetitle = 'News | Operation Braveheart';
			$this->view->styles = $this->model->setStylesheet(array('contact-us', 'news', 'admin'));
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Delete News';
			$this->view->imgclass = 'newslrgimg';
			$this->view->largeimg = 'news.jpg';
			$this->view->alt = 'Delete News';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/news", "name" => "News"),
				array("url" => URL . "admin/news/delete", "name" => "Delete News"),
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'delete');
			
			// truncate the news content
			extract($this->model->newsIndex($this->entries_per_page));
			
			$this->view->news = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'news', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/news/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'delete':
					$this->model->newsDelete($_POST['id']);
					header('Location: ' . URL . 'admin/news');
					break;
				case 'back':
					header('Location: ' . URL . 'admin/news');
					break;
				default:
			}
		}
	}
	
	public function archive() {
	
		if(empty($_POST['action'])) {
	
			$this->entries_per_page = 15;
		
			$this->view->pagetitle = 'News | Operation Braveheart';
			$this->view->styles = $this->model->setStylesheet(array('contact-us', 'news', 'admin'));
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
			$this->view->heading = 'Archive News';
			$this->view->imgclass = 'newslrgimg';
			$this->view->largeimg = 'news.jpg';
			$this->view->alt = 'Archive News';
				
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/news", "name" => "News"),
				array("url" => URL . "admin/news/archive", "name" => "Archive News"),
			);
			
			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
				
			$this->view->buttons = array('back', 'archive');
			
			// truncate the news content
			extract($this->model->newsIndex($this->entries_per_page));
			
			$this->view->news = $rows;
			
			$this->view->paging = ((int)count($rows) > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'news', 'pages') : '';
			
			$this->view->render('header');
			$this->view->render('admin/news/index');
			$this->view->render('footer');
		}
		else {
		
			switch($_POST['action']) {
				case 'archive':
					$this->model->newsArchive($_POST['id']);
					header('Location: ' . URL . 'admin/news');
					break;
				case 'back':
					header('Location: ' . URL . 'admin/news');
					break;
				default:
			}
		}
	}
}