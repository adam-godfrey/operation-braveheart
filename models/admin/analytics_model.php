<?php

class Analytics_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function getDailyHits() {
	
		//get the number of page hits for today
		$sql = 'SELECT *, ROUND((counter / (SELECT sum(counter) FROM analytics WHERE insertdate = CURDATE() ORDER BY counter DESC LIMIT 10)*100),2) as hits FROM analytics WHERE insertdate = CURDATE() GROUP BY pagename ORDER BY counter DESC LIMIT 10';
		//execute the query
		$rows = $this->db->clean($sql);
		
		$maxwidth = 173;
		$max = $rows[0]['hits'];
		
		foreach($rows as $key => $row) {
		
			$rows[$key]['maxwidth'] = round($maxwidth * ($row['hits']/$max));
		}
		
		//return the results
		return array('day' => $rows);
	}
	
	public function getWeeklyHits() {
		
		// get the number of page hits for the week
		$sql = 'SELECT *, ROUND((counter / (SELECT sum(counter) FROM analytics WHERE insertdate BETWEEN DATE_SUB(NOW(),INTERVAL 1 WEEK) AND NOW() ORDER BY counter DESC LIMIT 10)*100),2) as hits FROM analytics WHERE insertdate BETWEEN DATE_SUB(NOW(),INTERVAL 1 WEEK) AND NOW() GROUP BY pagename ORDER BY counter DESC LIMIT 10';
		//execute the query
		$rows = $this->db->clean($sql);
		
		$maxwidth = 173;
		$max = $rows[0]['hits'];
		
		foreach($rows as $key => $row) {
		
			$rows[$key]['maxwidth'] = round($maxwidth * ($row['hits']/$max));
		}
		
		//return the results
		return array('week' => $rows);
	}
	
	public function getMonthlyHits() {
	
		// get the number of page hits for the month 
		$sql = 'SELECT *, ROUND((counter / (SELECT sum(counter) FROM analytics WHERE insertdate BETWEEN DATE_SUB(NOW(),INTERVAL 1 MONTH) AND NOW() ORDER BY counter DESC LIMIT 10)*100),2) as hits FROM analytics WHERE insertdate BETWEEN DATE_SUB(NOW(),INTERVAL 1 MONTH) AND NOW() GROUP BY pagename ORDER BY counter DESC LIMIT 10';
	
		//execute the query
		$rows = $this->db->clean($sql);
		
		$maxwidth = 173;
		$max = $rows[0]['hits'];
		
		foreach($rows as $key => $row) {
		
			$rows[$key]['maxwidth'] = round($maxwidth * ($row['hits']/$max));
		}
		
		//return the results
		return array('month' => $rows);
	}
}