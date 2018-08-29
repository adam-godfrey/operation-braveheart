<?php

class Shop extends Controller {
	
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
					header('Location: ' . URL . 'admin/shop/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/shop/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->shopDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->shopDisable($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		
		$this->view->pagetitle = 'Shops | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Shops';
		$this->view->imgclass = 'shoplrgimg';
		$this->view->largeimg = 'shop.jpg';
		$this->view->alt = 'Shops';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/shop", "name" => "Shops")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
		
		// truncate the shop content
		extract($this->model->shopIndex($this->entries_per_page));
		
		$active = array();
		$disabled = array();
		
		if(!empty($rows)) {
			foreach($rows as $key => $row) {
				switch($row['active']) {
					case 0:
						$disabled[$key] = $row;
						break;
					case 1:
						$active[$key] = $row;
						break;
					default:
				}
			}
		}
		
		$this->view->active_items = $active;
		$this->view->disabled_items = $disabled;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/shop', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/shop/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
				// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/shop/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/shop/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->shopDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->shopDisable($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		
		$this->view->pagetitle = 'Shops | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Shops';
		$this->view->imgclass = 'shoplrgimg';
		$this->view->largeimg = 'shop.jpg';
		$this->view->alt = 'Shops';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/shop", "name" => "Shops")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
		
		// truncate the shop content
		extract($this->model->shopIndex($this->entries_per_page, (int) $arg));;
		
		$active = array();
		$disabled = array();
		
		if(!empty($rows)) {
			foreach($rows as $key => $row) {
				switch($row['active']) {
					case 0:
						$disabled[$key] = $row;
						break;
					case 1:
						$active[$key] = $row;
						break;
					default:
				}
			}
		}
		
		//echo"<pre>";var_dump($rows);echo"<pre>";
		//exit;
		$this->view->active_items = $active;
		$this->view->disabled_items = $disabled;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/shop', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/shop/index');
		$this->view->render('footer');
	}
		
	public function add() {
	
		$this->view->pagetitle = 'Add Shop | Operation Braveheart';
		$this->view->style = 'admin-shop';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Add Shop';
		$this->view->imgclass = 'shoplrgimg';
		$this->view->largeimg = 'shop.jpg';
		$this->view->alt = 'Add Shop';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/shop", "name" => "Shops"),
			array("url" => URL . "admin/shop/add", "name" => "Add Shop"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'save', 'preview');
		
		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Shop Preview',
			'content' => '<h2 id="preview-heading"></h2>'
		);
		
		if(empty($_POST['action'])) {
	
			$this->view->render('header');
			$this->view->render('admin/shop/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$data = array();
					$data['prodid'] = $_POST['prodid'];
					$data['item_name'] = trim(htmlspecialchars(ucwords(strtolower($_POST['item_name']))));
					$data['short_description'] = trim(htmlspecialchars($_POST['item_shortdesc']));
					$data['full_description'] = trim(htmlspecialchars($_POST['item_fulldesc']));
					$data['is_clothing'] = trim(htmlspecialchars($_POST['is_clothing']));
					$data['item_size'] = trim(htmlspecialchars($_POST['item_size']));
					$data['item_keywords'] = trim(htmlspecialchars($_POST['item_keywords']));
					$data['item_code'] = trim(htmlspecialchars($_POST['item_code']));
					$data['item_price'] = trim(htmlspecialchars($_POST['item_price']));
					$data['item_stock'] = trim(htmlspecialchars($_POST['item_stock']));
					$data['item_image'] = trim(htmlspecialchars($_POST['imgname']));
					$data['alternate'] =  trim(htmlspecialchars(substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."))));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();
					
					$validators[] = new ValidateSubject($data['item_name'],'Product Title');
					$validators[] = new ValidateEmpty($data['short_description'],'Product Short Description');
					$validators[] = new ValidateEmpty($data['full_description'],'Product Full Description');
					$validators[] = new ValidateNumber($data['item_size'],'Product Code');
					$validators[] = new ValidateNumber($data['item_price'],'Product Price');
					$validators[] = new ValidateNumber($data['item_stock'],'Product Stock Level');
					$validators[] = new ValidateEmpty($data['item_image'],'Product Image');
					(!empty($_POST['item_keywords'])) ? $validators[]=new ValidateSubject($data['item_keywords'],'Keywords') : '';
					
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
					
						$this->view->success = $this->model->shopAdd($data);
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/shop/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->data = $data;
					
						//render the html
						$this->view->render('header');
						$this->view->render('admin/shop/errors');
						$this->view->render('footer');
					}
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/shop');
					break;
				default:
			}
		}
	}
		
	public function edit($arg = '') {
		
		$this->entries_per_page = 10;
		
		$this->view->pagetitle = 'Shops | Operation Braveheart';
		$this->view->style = 'admin-shop';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Edit Shops';
		$this->view->imgclass = 'shoplrgimg';
		$this->view->largeimg = 'shop.jpg';
		$this->view->alt = 'Edit Shops';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/shop", "name" => "Shops"),
			array("url" => URL . "admin/shop/edit", "name" => "Edit Shops"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Shops Preview',
			'content' => '<h2 id="preview-heading"></h2><div id="preview-content"></div>'
		);

			
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
			
				$this->view->buttons = array('back', 'edit');
				
				// truncate the shop content
				extract($this->model->shopIndex($this->entries_per_page));
				
				$active = array();
				$disabled = array();
				
				foreach($rows as $key => $row) {
					switch($row['active']) {
						case 0:
							$disabled[$key] = $row;
							break;
						case 1:
							$active[$key] = $row;
							break;
						default:
					}
				}
				
				
				$this->view->active_items = $active;
				$this->view->disabled_items = $disabled;
				
				$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/shop', 'pages') : '';
						
				$this->view->render('header');
				$this->view->render('admin/shop/index');
				$this->view->render('footer');
			}
			else {
				
				$this->view->buttons = array('back', 'save', 'preview');
				
				// truncate the shop content
				extract($this->model->shopContent((int) $arg));	
				$this->view->shop = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/shop/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$this->view->buttons = array('back', 'save', 'preview');
	
					$data = array();
					$data['prodid'] = $_POST['prodid'];
					$data['item_name'] = trim(htmlspecialchars(ucwords(strtolower($_POST['item_name']))));
					$data['short_description'] = trim(htmlspecialchars($_POST['item_shortdesc']));
					$data['full_description'] = trim(htmlspecialchars($_POST['item_fulldesc']));
					$data['is_clothing'] = trim(htmlspecialchars($_POST['is_clothing']));
					$data['item_size'] = trim(htmlspecialchars($_POST['item_size']));
					$data['item_keywords'] = trim(htmlspecialchars($_POST['item_keywords']));
					$data['item_code'] = trim(htmlspecialchars($_POST['item_code']));
					$data['item_price'] = trim(htmlspecialchars($_POST['item_price']));
					$data['item_stock'] = trim(htmlspecialchars($_POST['item_stock']));
					$data['item_image'] = trim(htmlspecialchars($_POST['imgname']));
					$data['alternate'] =  trim(htmlspecialchars(substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."))));
					
					// A array to store errors
					$errors = array();
					// Collection of validators
					$validators = array();
					
					$validators[] = new ValidateSubject($data['item_name'],'Product Title');
					$validators[] = new ValidateEmpty($data['short_description'],'Product Short Description');
					$validators[] = new ValidateEmpty($data['full_description'],'Product Full Description');
					$validators[] = new ValidateNumber($data['item_size'],'Product Code');
					$validators[] = new ValidateNumber($data['item_price'],'Product Price');
					$validators[] = new ValidateNumber($data['item_stock'],'Product Stock Level');
					$validators[] = new ValidateEmpty($data['item_image'],'Product Image');
					(!empty($_POST['item_keywords'])) ? $validators[]=new ValidateSubject($data['item_keywords'],'Keywords') : '';

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
						$this->view->success = $this->model->shopEdit($data);
						
						$this->view->shop = $data;
						
						//render the html
						$this->view->render('header');
						$this->view->render('admin/shop/edit');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->shop = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/shop/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin/shop');
					break;
				default:
			}
		}
	}
	
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Shops | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Shops';
		$this->view->imgclass = 'shoplrgimg';
		$this->view->largeimg = 'shop.jpg';
		$this->view->alt = 'Delete Shops';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/shop", "name" => "Shops"),
			array("url" => URL . "admin/shop/delete", "name" => "Delete Shops"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');
		
		if(empty($_POST['action'])) {
			
			// truncate the shop content
			extract($this->model->shopIndex($this->entries_per_page));
			
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
			
			$this->view->active_items = $active;
			$this->view->disabled_items = $archived;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/shop', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/shop/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'delete': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->shopDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/shop/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/shop');
					break;
				default:
			}
		}
	}
	
	public function disable() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Shops | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Archive Shops';
		$this->view->imgclass = 'shoplrgimg';
		$this->view->largeimg = 'shop.jpg';
		$this->view->alt = 'Archive Shops';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/shop", "name" => "Shops"),
			array("url" => URL . "admin/shop/archive", "name" => "Archive Shops"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'archive');
		
		if(empty($_POST['action'])) {
			
			// truncate the shop content
			extract($this->model->shopIndex($this->entries_per_page));
			
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
			
			$this->view->active_items = $active;
			$this->view->disabled_items = $archived;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/shop', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/shop/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'archive': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->shopDisable($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/shop/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/shop');
					break;
				default:
			}
		}
	}
}