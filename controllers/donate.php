<?php

class Donate extends Controller {
	
	private $entries_per_page;
	
    public function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
    }
    
    public function index() {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 20;
		// set the page title
		$this->view->pagetitle = 'Make a donation | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'screen';
		// set the content heading
		$this->view->heading = 'Make a Donation';
		// set the large content image
		$this->view->largeimg = 'donate.jpg';
		$this->view->alt = 'Make a Donation';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "fundraising", "name" => "Fund Raising"),
						   array("url" => URL . "donate", "name" => "Donate")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		// get the rows returned from database
		extract($this->model->getDonations());

		// set to change the Google charts when deprecated chart unsupported
	
		$this->view->scripts = $this->model->setScripts(array('https://www.google.com/jsapi'));
		$chart = json_encode($chartData);
		$this->view->embed = '
			<script type="text/javascript">
				google.load("visualization", "1", {packages:["corechart"]});
				
				google.setOnLoadCallback(function() {
					$(function() {
						$(\'#loader\').remove();
						drawChart();
					});
				});
				function drawChart() {
					var data = google.visualization.arrayToDataTable('.$chart.');

					var options = {
						width:450,
						height:250,
						colors: ["#FD7E1D","#F0F0F0"],
						chartArea:{left:10,top:20,width:"100%",height:"100%"},
						is3D: true,
					};

					var chart = new google.visualization.PieChart(document.getElementById("piechart_3d"));
					chart.draw(data, options);
				}
			</script>
		';

		// set the percentage raised from the model
		$this->view->percent = $percent;
		// get the rows returned from database
		extract($this->model->getDonators($this->entries_per_page));
		// set the donators comments
		$this->view->comments = $rows;
		
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'donate', 'pages') : '';
		
		// render the html
        $this->view->render('header');
        $this->view->render('donate/index');
        $this->view->render('footer');
    }
	
	public function thankyou() {
	
		$this->model->visitorTracker();
	
		// set the page title
		$this->view->pagetitle = 'Make a donation | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->styles = $this->model->setStylesheet(array('news'));
		// set the content heading
		$this->view->heading = 'Make a Donation';
		// set the large content image
		$this->view->largeimg = 'donate.jpg';
		$this->view->alt = 'Make a Donation';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "fundraising", "name" => "Fund Raising"),
						   array("url" => URL . "donate", "name" => "Donate")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// create an array of POST variables from user input
		$data = array();
		$data['txn_id'] = $_POST['txn_id'];
		$data['nameField'] = $_POST['nameField'];
		$data['websiteField'] = $_POST['websiteField'];
		$data['messageField'] = $_POST['messageField'];
		
		
		$this->view->result = $this->model->postMessage($data);

        $this->view->render('header');
        $this->view->render('donate/thankyou');
        $this->view->render('footer');
    }
	
	public function pages($arg = false) {
	
		$this->model->visitorTracker();
	
		$this->entries_per_page = 20;
		
		$this->view->pagetitle = 'Welcome to Operation Braveheart';
		$this->view->styles = $this->model->setStylesheet(array('news'));
		$this->view->heading = 'News';
		$this->view->largeimg = '';
		$this->view->alt = '';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "fundraising", "name" => "Fund Raising"),
						   array("url" => URL . "donate", "name" => "Donate")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getNews($this->entries_per_page, (int) $arg));	
		// truncate the newd content
		$this->view->news = $rows;
		// create the paging 
		$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'news', 'view') : '';
		
		$this->view->url = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"]);
		
		extract($this->model->getDonations());

		// set to change the Google charts when deprecated chart unsupported
		if('2015-04-19' < date('Y-m-d')) {
		
			$this->view->scripts = $this->model->setScripts(array('https://www.google.com/jsapi'));
			$chart = json_encode($chartData);
			$this->view->embed = '
				<script type="text/javascript">
					google.load("visualization", "1", {packages:["corechart"]});
					google.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable('.$chart.');

						var options = {
							title: "Donations",
							width:450,
							height:250,
							colors: ["#FD7E1D","#F0F0F0"],
							is3D: true,
						};

						var chart = new google.visualization.PieChart(document.getElementById("piechart_3d"));
						chart.draw(data, options);
					}
				</script>
			';
		}
		else {
		
			$this->view->chartURL = $chartURL;
		}
		
		$this->view->percent = $percent;
		
		// get the rows returned from database
		extract($this->model->getDonators($this->entries_per_page, (int) $arg));
	
		// truncate the newd content
		$this->view->comments = $rows;
		// create the paging 
		$this->view->paging = $this->model->paging($total_pages, $page, 'donate', 'pages');
		
        $this->view->render('header');
        $this->view->render('donate/index');
        $this->view->render('footer');
    }	
}