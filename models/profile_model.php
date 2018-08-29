<?php

class Profile_Model extends Model {

	private $braveheart;

    public function __construct() {
        parent::__construct();
		
		$this->braveheart = new Braveheart();
    }
    
    public function getPrivateMessages() {
	
		$sql = 'SELECT u.username, p.* FROM privatemsgrec p INNER JOIN users u on  p.senderid=u.userid WHERE p.opened= :opened AND recipientid= :recipient';
        $rows = $this->db->select($sql, array(':opened' => 'n', ':recipient' => $_SESSION['userid']));
		
		return array('rows' => $rows);
    }
	
	public function getSignature() {
		
		$sql = 'SELECT signature FROM misc WHERE userid = :userid LIMIT 1';
		
		$rows = $this->db->select($sql, array(':userid' => $_SESSION['userid']));
       
		return array('rows' => $rows);
	}
	
	public function setSignature($signature) {
		
		$postData = array(
			'signature' => $signature
        );
		
		$this->db->update('misc', $postData, "`userid` = {$_SESSION['userid']}");
	}
	
	public function getAvatar() {
	
		$sql = 'SELECT  m.userid as userid, 
						m.avatar as avatar, 
						a.avatarname as avatarname, 
						a.avdesc as avdesc
				FROM misc m
				INNER JOIN avatars a ON m.avatar = a.avatarname 
				WHERE m.userid = :userid LIMIT 1';
		
		$rows = $this->db->select($sql, array(':userid' => $_SESSION['userid']));
        
		return array('rows' => $rows);
	}
	
	public function setAvatar($avatar) {
	
		$postData = array(
			'avatar' => $avatar
        );
		
		$this->db->update('misc', $postData, "`userid` = {$_SESSION['userid']}");
	}
	
	public function displayAvatars() {
	
		$sql ='SELECT avid, avatarname, avdesc FROM avatars ORDER BY avid ASC';
		
		$rows = $this->db->clean($sql);
		
		$avatars = array();
		
		foreach($rows as $key => $row) {
		
			list($marginlr, $margintb) = $this->braveheart->getMargin(URL . 'public/images/avatars/' . $row['avatarname'],130,130);
			
			$avatars[$key]['avid'] = $row['avid'];
			$avatars[$key]['avatarname'] = $row['avatarname'];
			$avatars[$key]['avdesc'] = ucwords($row['avdesc']);
			$avatars[$key]['marginlr'] = $marginlr;
			$avatars[$key]['margintb'] = $margintb;
		}
			
        return array('rows' => $avatars);
	}
	
	public function getEmail() {
	
		$sql = 'SELECT email FROM users WHERE userid = :userid LIMIT 1';
		
		$rows = $this->db->select($sql, array(':userid' => $_SESSION['userid']));
        
		return array('rows' => $rows);
	}
	
	public function setEmailPassword($data) {
		
		if(!empty($data['password'])) {
			
			//Generate users salt
			$user_salt = $this->randomString();
					
			//Salt and Hash the password
			$password = $user_salt . $data['password'];
			$password = $this->hashData($password);
			
			$postData = array(
				'email' => $data['email'],
				'password' => $password,
				'salt' => $user_salt
			);
			
			$this->db->update('users', $postData, "`userid` = {$_SESSION['userid']}");
		}
		else {
			$postData = array(
				'email' => $data['email'],
			);
			
			$this->db->update('users', $postData, "`userid` = {$_SESSION['userid']}");
		}
	}
	
	public function getOptions() {
	
		$sql = 'SELECT email_admin, email_other, autosubscribe, pm_dis, pm_admin, inf_pm, save_sent FROM misc WHERE userid = :userid LIMIT 1';
		
		$rows = $this->db->select($sql, array(':userid' => $_SESSION['userid']));
        
		return array('rows' => $rows);
	}
	
	public function setOptions($data) {
	
		$postData = array(
			'email_admin' => $data['email_admin'],
			'email_other' => $data['email_other'],
			'autosubscribe' => $data['autosubscribe'],
			'pm_disabled' => $data['pm_disabled'],
			'pm_admin' => $data['pm_admin'],
			'new_prvt_msg' => $data['new_prvt_msg'],
			'save_sent' => $data['save_sent'],
		);
		
		$this->db->update('misc', $postData, "`userid` = {$_SESSION['userid']}");
	}
	
}