<?php
class OBForum {
	protected $boardid;
	protected $topicid;
	protected $topicname;
	protected $topicmessage;
	protected $author;
	private $today;
	private $day;
	private $time;
	public $db;
	
	//Constructor
	public function __construct() {
	
		$this->time;
		$this->today;
		$this->day;
	}
	
	// function to display the date the user posted message
	public function change_date($post_time) {
		// initilaise private variables to be used only in this function
		$this->time = $post_time;
		
		// get today's date
		$this->today = strtotime(date('F d, Y'));
		$this->day = ($this->time - $this->today)/86400;

		if ($this->day >= 0 && $this->day < 1) {
			// date is today's date
			return '<b>Today</b>'.date(', h:i:s A', $this->time ? $this->time : time());
		} 
		else if ($this->day >= -1 && $this->day < 0) {
			// date is yesterday's date
			return '<b>Yesterday</b>'.date(', h:i:s A', $this->time ? $this->time : time());
		}
		else {
			// date is older than yesterday's date
			return date('F d, Y, h:i:s A',$this->time ? $this->time : time());
		}
	}
	
	// function to insert a new topic title in the database
	public function new_topic($boardid, $topicname, $topicmessage, $author) {
	
		// start a transaction so all queries can be executed
		$this->db->beginTransaction();
		
		try {
			// FIRST TRANSACTION
			$this->boardid = $boardid;
			$this->topicname = $topicname;
			$this->topicmessage = $topicmessage;
			$this->author = $author;
			
			//set up the query using placeholders
			$this->db->query('INSERT INTO topics (boardid, topicname, author) VALUES (:boardid, :topicname, :author)');
			
			// bind varibales to the placehoders
			$this->db->bind(':boardid', $this->boardid);
			$this->db->bind(':topicname', $this->topicname);
			$this->db->bind(':author', $this->author);
			
			//query to enter form data into database 	    
			$this->db->execute();	
			
			// get the id of the last inserted topic
			$this->topicid = $this->db->lastInsertId();
			
			// SECOND TRANSACTION
			//set up the query using placeholders
			$this->db->query('INSERT INTO messages (boardid, topicid, message, author, postdate) VALUES (:boardid, :topicid, :topicmessage :author, now())');
			
			// bind varibales to the placehoders
			$this->db->bind(':boardid', $this->boardid);
			$this->db->bind(':topicid', $this->topicid);
			$this->db->bind(':topicmessage', $this->topicmessage);
			$this->db->bind(':author', $this->author);
			
			//query to enter form data into database 	    
			$this->db->execute();
			
			// end the transactions as all data should have saved.  On failuire, rollback.
			$this->db->endTransaction();
			
			$this->check_subscriptions();
			
			$this->email_subscribers();
			
			return true;
		}
		catch(PDOException $e) {
			// If this statement fails, rollback...
			$this->db->cancelTransaction();
			
			return false;
		}
	}
	
	private function check_subscriptions() {
	
		// check to see if use has subscribed to the topic
		//set up the query using placeholders
		$this->db->query('SELECT COUNT(*) FROM subscriptions WHERE topic=:topicid AND username=:author');
		
		// bind varibales to the placehoders
		$this->db->bind(':topicid', $this->topicid);
		$this->db->bind(':author', $this->author);
		
		// get the number of columns
		$result = $this->db->fetchColumn();
		
		// if the result is 0 then subscribe user to topic
		if($this->db->fetchColumn() == 0) {
		
			$email = $_SESSION['email'];
			
			//set up the query using placeholders
			$this->db->query('INSERT INTO subscriptions (username, email, topic) VALUES (:author, :email, :topicid)');
			
			// bind varibales to the placehoders
			$this->db->bind(':author', $this->author);
			$this->db->bind(':email', $email);
			$this->db->bind(':topicid', $this->topicid);
			
			//query to enter form data into database 
			$created = $this->db->execute();
		}
	}
	
	// function to enter the topic message in the database
	private function reply_topic() {
	
		//set up the query using placeholders
		$this->db->query('INSERT INTO messages (boardid, topicid, message, author, postdate) VALUES (:boardid, :topicid, :topicmessage :author, now())');
		
		// bind varibales to the placehoders
		$this->db->bind(':boardid', $this->boardid);
		$this->db->bind(':topicid', $this->topicid);
		$this->db->bind(':topicmessage', $this->topicmessage);
		$this->db->bind(':author', $this->author);
		
		//query to enter form data into database 	    
		$created = $this->db->execute();
		
		// if the query executed successfully
		if($created)
		{	
			return true;	
		}	
		else
		{
			return false;
		}	
	}

	public static function nl2br_revert_bis($string) {
	
		$br = preg_match('`<br>[\\n\\r]`',$string) ? '<br>' : '<br />';
		return preg_replace('`'.$br.'([\\n\\r])`', '$1', $string);
	}
	
	private function email_subscribers() {
	
		$sql = 'SELECT s.username, s.email, s.topic, t.topicname, b.boardname
			FROM subscriptions s
			LEFT OUTER JOIN topics t ON s.topic = t.topicid
			LEFT OUTER JOIN boards b ON b.boardid = t.boardid
			WHERE s.topic = :topicid';
		
		//set up the query using placeholders
		$this->db->query($sql);

		// bind varibales to the placehoders
		$this->db->bind(':topicid', $this->topicid);
		
		//query to enter form data into database 	    
		$rows = $this->resultset();

		// send an email to all subscribers alerting that a new post has been made
		foreach($rows as $row) {
			// extract column names to variables
			extract($row, XTR_PREFIX_INVALID, '_');
			
			$boardname = strtolower(str_replace(' ','-',$boardname));
			$topicname = strtolower(str_replace(' ','-',topicname));
			$subject = "Topic reply - ".$topicname;
			$message = "Hi $username,
			
			A reply has been posted to a topic you are watching by $author
			
			View the reply at:
			http://www.operationbraveheart.org.uk/forum/$boardname/$topicname/
						
			Unsubscribe from this topic:

			http://www.operationbraveheart.org.uk/forum/unsubscribe/$topicname/$email

			Regards, the OPeration Braveheart Forums team.

			This is an automated response, please do not reply!"; 
			
			mail($email, $subject, $message, "From: www.operationbraveheart.org.uk Forum team<noreply@operationbraveheart.org.uk>\n X-Mailer: PHP/" . phpversion());
		}
	}
}
?>