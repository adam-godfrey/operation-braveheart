<?php

class Events extends Controller {
	
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
					header('Location: ' . URL . 'admin/events/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/events/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->eventDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->eventArchive($_POST['id']);
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Events | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Events';
		$this->view->imgclass = 'eventslrgimg';
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Events';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/events", "name" => "Events")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
		
		// truncate the event content
		extract($this->model->eventsIndex($this->entries_per_page));;
		
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
		
		$this->view->active_events = $active;
		$this->view->archived_events = $archived;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/events', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/events/index');
		$this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		// check to see if form submitted
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		
		// form submitted to take appropiate action
		if(!empty($action)) {
			switch($action) {
			
				case 'add':
					header('Location: ' . URL . 'admin/events/add');
					break;
				case 'edit':
					foreach($_POST['id'] as $value) {
						$id = $value;
					}	
					header('Location: ' . URL . 'admin/events/edit/' . $id);
					break;
				case 'delete':
					$this->view->success = $this->model->eventDelete($_POST['id']);
					
					break;
				case 'archive':
					$this->view->success = $this->model->eventArchive($_POST['id']);
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin');
					break;
				default:
			}
		}
		
		$this->entries_per_page = 10;
		 
		$this->view->pagetitle = 'Events | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Events';
		$this->view->imgclass = 'eventslrgimg';
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Events';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/events", "name" => "Events")	
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->buttons = array('back', 'edit', 'delete', 'archive', 'add');
		
		// truncate the event content
		extract($this->model->eventsIndex($this->entries_per_page, (int) $arg));;
		
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
		
		$this->view->active_events = $active;
		$this->view->archived_events = $archived;
		
		$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/events', 'pages') : '';
		
		$this->view->render('header');
		$this->view->render('admin/events/index');
		$this->view->render('footer');
	}
		
	public function add() {
		
		if(empty($_POST['action'])) {
	
			$this->view->pagetitle = 'Add Event | Operation Braveheart';
			$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('https://maps.googleapis.com/maps/api/js?sensor=false', 'jquery.form', 'jquery.admin', 'jquery.admin-events'));
			$this->view->heading = 'Add Event';
			$this->view->largeimg = 'events.png';
			$this->view->alt = 'Add Event';
			
			// display the breadcrumbs
			$nav_array = array(array("url" => URL, "name" => "Home"),
				array("url" => URL . "admin/", "name" => "Admin"),
				array("url" => URL . "admin/events", "name" => "Events"),
				array("url" => URL . "admin/events/add", "name" => "Add Event"),
			);

			$this->view->crumbs = $this->model->breadcrumbs($nav_array);
			
			$this->view->buttons = array('back', 'save');
			
			$this->view->admin_modal = true;
		
			$this->view->modal = array(
				'title' => 'Event Map',
				'content' => '<div class="container">
                    <div class="row">
                        <div id="map-canvas" class=""></div>
                    </div>
                </div>'
			);
			
			$this->view->render('header');
			$this->view->render('admin/events/add');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'save':
				
					$data = array();
					
					$data['eventid'] = $_POST['eventid'];
					$data['title'] = ucwords($_POST['event_title']);
					$data['content'] = $_POST['event_content'];
					$data['location'] = ucwords($_POST['location']);
					$data['postcode'] = strtoupper($_POST['postcode']);
					$data['latitude'] = $_POST['latitude'];
					$data['longitude'] = $_POST['longitude'];
					$data['eventdate'] = $_POST['eventdate'];
					$data['image'] = $_POST['imgname'];
					$data['alternate'] = substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."));
					$data['keywords'] = $_POST['event_keywords'];
					$data['postdate'] = date('Y-m-d');
					
					// create an array for errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Title');
					$validators[]=new ValidateEmpty($data['content'],'Content');
					$validators[]=new ValidateEmpty($data['location'],'Location');
					$validators[]=new ValidatePostcode($data['postcode'],'Postcode');
					$validators[]=new ValidateCoord($data['latitude'],'Latitude');
					$validators[]=new ValidateCoord($data['longitude'],'Longitude');
					$validators[]=new ValidateDate($data['eventdate'],'Date');
					(!empty($_POST['event_keywords'])) ? $validators[] = new ValidateSubject($data['keywords'],'Keywords') : '';
					

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
						$this->view->success = $this->model->eventAdd($data);
						
						$this->view->events = $data;
						
						//render the html
						$this->view->render('header');
						$this->view->render('admin/events/add');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->events = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/events/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin/events');
					break;
				default:
			}
		}
	}
	
	public function edit($arg = '') {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Events | Operation Braveheart';
		$this->view->style = 'admin';
			// get an array of additional JavaScripts
			$this->view->scripts = $this->model->setScripts(array('https://maps.googleapis.com/maps/api/js?sensor=false', 'jquery.form', 'jquery.admin', 'jquery.admin-events'));
		$this->view->heading = 'Edit Events';
		$this->view->imgclass = 'eventslrgimg';
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Edit Events';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/events", "name" => "Events"),
			array("url" => URL . "admin/events/edit", "name" => "Edit Events"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);

		$this->view->admin_modal = true;
		
		$this->view->modal = array(
			'title' => 'Event Map',
			'content' => '<div class="container">
				<div class="row">
					<div id="map-canvas" class=""></div>
				</div>
			</div>'
		);
			
		if(empty($_POST['action'])) {
		
			if(empty($arg)) {
				$this->view->buttons = array('back', 'edit');
				
				// truncate the event content
				extract($this->model->eventsIndex($this->entries_per_page));
				
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
				
				$this->view->active_events = $active;
				$this->view->archived_events = $archived;
				
				$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/events', 'pages') : '';
						
				$this->view->render('header');
				$this->view->render('admin/events/index');
				$this->view->render('footer');
			}
			else {
				$this->view->buttons = array('back', 'save', 'preview');
				
				// truncate the event content
				extract($this->model->eventContent((int) $arg));
								
				$this->view->event = $rows;
				
				$this->view->render('header');
				$this->view->render('admin/events/edit');
				$this->view->render('footer');
			}
		}
		else {
			switch($_POST['action']) {
				case 'save':
					$this->view->buttons = array('back', 'save', 'preview');
	
					$data = array();
					
					$data['eventid'] = $_POST['eventid'];
					$data['title'] = ucwords($_POST['event_title']);
					$data['content'] = $_POST['event_content'];
					$data['location'] = ucwords($_POST['location']);
					$data['postcode'] = strtoupper($_POST['postcode']);
					$data['latitude'] = $_POST['latitude'];
					$data['longitude'] = $_POST['longitude'];
					$data['eventdate'] = $_POST['eventdate'];
					$data['image'] = $_POST['imgname'];
					$data['alternate'] = substr($_POST['imgname'],0,strrpos($_POST['imgname'], "."));
					$data['keywords'] = $_POST['event_keywords'];
					$data['postdate'] = date('Y-m-d');
					
					// create an array for errors
					$errors = array();
					// Collection of validators
					$validators = array();

					$validators[]=new ValidateSubject($data['title'],'Title');
					$validators[]=new ValidateEmpty($data['content'],'Content');
					$validators[]=new ValidateEmpty($data['location'],'Location');
					$validators[]=new ValidatePostcode($data['postcode']);
					$validators[]=new ValidateCoord($data['latitude'],'Latitude');
					$validators[]=new ValidateCoord($data['longitude'],'Longitude');
					$validators[]=new ValidateDate($data['eventdate'],'Date');
					(!empty($_POST['event_keywords'])) ? $validators[]=new ValidateSubject($data['keywords'],'Keywords') : '';
					

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
						$this->view->success = $this->model->eventEdit($data);
						
						$this->view->event = $data;
						
						//render the html
						$this->view->render('header');
						$this->view->render('admin/events/edit');
						$this->view->render('footer');
					}
					else {
						// set the errors from failed validation
						$this->view->errors = $errors;
						// set the form data so user doesn't have to re-enter
						$this->view->event = $data;
						
						// render the html
						$this->view->render('header');
						$this->view->render('admin/events/errors');
						$this->view->render('footer');
					}
					break;
				case 'back':
					header('Location: ' . URL . 'admin/events');
					break;
				default:
			}
		}
	}
		
	public function delete() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Events | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Delete Events';
		$this->view->imgclass = 'eventslrgimg';
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Delete Events';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/events", "name" => "Events"),
			array("url" => URL . "admin/events/delete", "name" => "Delete Events"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');
		
		if(empty($_POST['action'])) {
			
			// truncate the event content
			extract($this->model->eventsIndex($this->entries_per_page));
			
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
			
			$this->view->active_events = $active;
			$this->view->archived_events = $archived;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/events', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/events/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'delete': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->eventDelete($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/events/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/events');
					break;
				default:
			}
		}
	}
	
	public function archive() {
		
		$this->entries_per_page = 15;
		
		$this->view->pagetitle = 'Events | Operation Braveheart';
		$this->view->style = 'admin';
		// get an array of additional JavaScripts
		$this->view->scripts = $this->model->setScripts(array('jquery.form', 'jquery.admin'));
		$this->view->heading = 'Archive Events';
		$this->view->imgclass = 'eventslrgimg';
		$this->view->largeimg = 'events.png';
		$this->view->alt = 'Archive Events';
			
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
			array("url" => URL . "admin/", "name" => "Admin"),
			array("url" => URL . "admin/events", "name" => "Events"),
			array("url" => URL . "admin/events/archive", "name" => "Archive Events"),
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		$this->view->buttons = array('back', 'delete');
		
		if(empty($_POST['action'])) {
			
			// truncate the event content
			extract($this->model->eventsIndex($this->entries_per_page));
			
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
			
			$this->view->active_events = $active;
			$this->view->archived_events = $archived;
			
			$this->view->paging = ((int) $rowcount > (int) $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'admin/events', 'pages') : '';
					
			$this->view->render('header');
			$this->view->render('admin/events/index');
			$this->view->render('footer');
		}
		else {
			switch($_POST['action']) {
				case 'archive': 
					
					// submit the comment for moderation
					$this->view->success = $this->model->eventArchive($_POST['id']);
					
					//render the html
					$this->view->render('header');
					$this->view->render('admin/events/index');
					$this->view->render('footer');
					
					break;
				case 'back':
					header('Location: ' . URL . 'admin/events');
					break;
				default:
			}
		}
	}
}