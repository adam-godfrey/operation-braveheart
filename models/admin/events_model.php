<?php

class Events_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	
    public function __construct() {
	
        parent::__construct();
		
		$this->getcount;
		$this->total_pages;
    }
	
	public function getRowCount() {
	
		$sql = "SELECT MAX(counts.counted) AS mycount
				FROM (
					SELECT COUNT(*) AS counted
					FROM events WHERE archived = 0
					UNION ALL
					SELECT COUNT(*) AS counted
					FROM events WHERE archived = 1) AS counts";
		
		return (int) $this->db->count($sql);
	}
	
	public function eventsIndex($entries_per_page, $pageno = '') {
			
		// get the number of rows
		$this->getcount = $this->getRowCount();
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1);
		// set the number of entries to appear on the page
		 
		// total pages is rounded up to nearest integer
		$this->total_pages = ceil($this->getcount/$entries_per_page); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);
		
		if($this->getcount != 0) {
		
			$sql="(SELECT id, title, archived, eventdate, postdate FROM events WHERE archived = 0 ORDER by postdate DESC LIMIT $offset, $entries_per_page) UNION (SELECT id, title, archived, eventdate, postdate FROM events WHERE archived = 1 ORDER by postdate DESC LIMIT $offset, $entries_per_page)";
			
			$rows = $this->db->clean($sql);
			
			foreach($rows as $key => $row) {
				$rows[$key]['postdate'] = date("d M Y", strtotime($row['postdate']));
				$rows[$key]['eventdate'] = date("d M Y", strtotime($row['eventdate']));
			}

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0, 'total_pages' => 0, 'page' => 0, 'rowcount' => 0);
		}	
    }
	
	public function eventContent($id) {
		
		$sql = 'SELECT id, title, content, eventdate, image, alternate, location, postcode, latitude, longitude FROM events WHERE id = :id LIMIT 1';
		
		$rows = $this->db->select($sql, array(':id' => $id));
		
		$events = array();
		
		foreach($rows as $row) {
			foreach($row as $key => $value) {
				if($key == 'eventdate') {
					$events['eventdate'] = date("d-m-Y", strtotime($row['eventdate']));
				}
				else {
					$events[$key] = $value;
				}
			}	
		}
		
		return array('rows' => $events);
	}
	
	public function eventAdd($data) {
	
		$insert = $this->db->insert('events', array(
			'title' => $data['title'],
			'content' => $data['content'], 
			'eventdate' => date('Y-m-d', strtotime($data['eventdate'])),
			'image' => $data['image'], 
			'alternate' => $data['alternate'], 
			'location' => $data['location'],
			'postcode' => $data['postcode'], 
			'latitude' => $data['latitude'],
			'longitude' => $data['longitude'],
			'postdate' => $data['postdate'],
			'keywords' => $data['keywords'],
        ));	

		return ($insert) ? true: false;
	}
	
	public function eventEdit($data) {
	
		$postData = array(
			'id' => $data['id'],
			'title' => $data['title'],
			'content' => $data['content'], 
			'eventdate' => date('Y-m-d', strtotime($data['eventdate'])),
			'image' => $data['image'], 
			'alternate' => $data['alternate'], 
			'location' => $data['location'],
			'postcode' => $data['postcode'], 
			'latitude' => $data['latitude'],
			'longitude' => $data['longitude'],
			'postdate' => $data['postdate'],
			'keywords' => $data['keywords'],
        );
        
        return $this->db->update('events', $postData, "`id` = {$data['eventid']}");
	}
	
	public function articleDelete($id) {
	
		return array('result' => $this->db->delete('events', "`id` IN (".implode(',',$id).")"), 'action' => 'deleted');
	}
	
	public function articleArchive($id) {
	
        return array('result' => $this->db->updateCase('events', 'archived', "`id` IN (".implode(',',$id).")"), 'action' => 'archived');
	}
}