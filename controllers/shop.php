<?php

class Shop extends Controller {
	
	private $entries_per_page;
	private $sizes_count;
	private $json;
	private $blah;
	
    function __construct() {
	
        parent::__construct();
		
		$this->entries_per_page;
		$this->sizes_count;
		$this->json;
		$this->blah;
    }
    
    public function index() {
	
		$this->model->visitorTracker();
	
		// set the number of results to be displayed on the page
		$this->entries_per_page = 12;
		// set the page title
		$this->view->pagetitle = 'Shop | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'shop';
		// set the content heading
		$this->view->heading = 'Shop';
		// set the large content image
		$this->view->largeimg = 'shop.jpg';
		$this->view->alt = 'Shop';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "shop", "name" => "Shop")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getContent($this->entries_per_page));
		
		// check to see if there any news to display
		if(!empty($rows)) {
			// set the news to be displayed
			$this->view->products = $rows;
			
			$this->view->jcart_session = isset($_SESSION['jcartToken']) ? $_SESSION['jcartToken'] : '';
			
			// create the paging 
			$this->view->paging = ($rowcount > $this->entries_per_page) ? $this->model->paging($total_pages, $page, 'shop', 'pages') : '';
			
			// set the counter for the links to the blog content
			$this->view->counter = 1;
		}
		else {
			// no blogs to display
			$this->view->products = '';
		}
		
        $this->view->render('header');
        $this->view->render('shop/index');
        $this->view->render('footer');
    }
	
	public function pages() {
	
		$this->model->visitorTracker();
	}
	
	public function view($arg = '') {
	
		$this->model->visitorTracker();
		
		// set the page title
		$this->view->pagetitle = 'Shop | Operation Braveheart';
		// get an array of additional stylesheets
		$this->view->style = 'shop';
		// set the content heading
		$this->view->heading = 'Shop';
		// set the large content image
		$this->view->largeimg = 'shop.jpg';
		$this->view->alt = 'Shop';
		
		// display the breadcrumbs
		$nav_array = array(array("url" => URL, "name" => "Home"),
						   array("url" => URL . "shop", "name" => "Shop")
		);

		$this->view->crumbs = $this->model->breadcrumbs($nav_array);
		
		// get the rows returned from database
		extract($this->model->getItem( (int) $arg ));
	
		// check to see if there any news to display
		if(!empty($rows)) {
			// set the news to be displayed
			$this->view->products = $rows;
			
			$this->sizes_count = count($rows[$arg]['sizes']);
		
			if($this->sizes_count > 1) {

				$this->json = '{ ';
				foreach($rows[$arg]['sizes'] as $size => $price) {
					$splitprice = explode(".",number_format($price,2));
					if($size != 'X-Large') {
						$this->json .= '"'.$size.'": { "poundPrice": "'.$splitprice[0].'", "pencePrice": "'.$splitprice[1].'", "ItemId": "'.$rows[$arg]['itemid'].'-'.$this->blah.'" },';
					}
					else {
						$this->json .=  '"'.$size.'": { "poundPrice": "'.$splitprice[0].'", "pencePrice": "'.$splitprice[1].'", "ItemId": "'.$rows[$arg]['itemid'].'-'.$this->blah.'" }';
					}
					$this->blah++;
				}
				$this->json .= '};';
			
				$this->view->embed = '
					<script type="text/javascript">

						var item_prices_by_size_' . $rows[$arg]['prodid'] . ' = ' . $this->json . ';
					
						$(function() {
							$(\'#item_'. $rows[$arg]['prodid'] . '\').change(function() {
			
								var form = $(this).parents(\'form\');
			
								// Size is whatever the value the user has selected
								var size = $(this).val();
			
								// Determine the correct price and item ID based on the selected size
								var price_' . $rows[$arg]['prodid'] . ' = item_prices_by_size_' . $rows[$arg]['prodid'] . '[size].Price,
									itemId = item_prices_by_size_' . $rows[$arg]['prodid'] . '[size].ItemId;
									
								var myprice_' . $rows[$arg]['prodid'] . ' = item_prices_by_size_' . $rows[$arg]['prodid'] . '[size].poundPrice,
									itemId = item_prices_by_size_' . $rows[$arg]['prodid'] . '[size].ItemId;
									
								var myprice2_' . $rows[$arg]['prodid'] . ' = item_prices_by_size_' . $rows[$arg]['prodid'] . '[size].pencePrice,
									itemId = item_prices_by_size_' . $rows[$arg]['prodid'] . '[size].ItemId;
			
								form.find(\'#myprice_'. $rows[$arg]['prodid'] . '\').html(\'&#163;\'+myprice_' . $rows[$arg]['prodid'] . ');
								
								form.find(\'#myprice2_'. $rows[$arg]['prodid'] . '\').text(myprice2_' . $rows[$arg]['prodid'] . ');
			
								form.find(\'[name=my-item-price]\').val(price_' . $rows[$arg]['prodid'] . ');
			
							  // Update the item ID
							  form.find(\'[name=my-item-id]\').val(itemId);
			
							});
						});
					</script>';

			}
			
			$this->view->jcart_session = isset($_SESSION['jcartToken']) ? $_SESSION['jcartToken'] : '';
		}
		else {
			// no blogs to display
			$this->view->products = '';
		}
		
        $this->view->render('header');
        $this->view->render('shop/view');
        $this->view->render('footer');
	}
}