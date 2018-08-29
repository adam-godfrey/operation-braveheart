<?php

class Index_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }

	public function indexContent() {
		
        return $this->db->singleCache('index_Content', 'SELECT content FROM info where id = :id LIMIT 1', array(':id' => 1));
    }
	
	public function newsContent() {
		
		$sql="SELECT id, title, content, DATE_FORMAT( postdate, '%D %M %Y' ) AS postdate, alternate, ifnull( c.commentscount, 0 ) AS count
			FROM news n
			LEFT OUTER
			JOIN (
				SELECT pageid, page, count( * ) AS commentscount
				FROM comments
				GROUP BY pageid
			) AS c ON c.pageid = n.id
			WHERE archived = :archived
			ORDER BY id DESC
			LIMIT 1 ";
		
        $rows = $this->db->selectCache('index_NewsContent', $sql, array(':archived' => 'n'));

		return array('rows' => $rows);		
    }
	
	public function blogContent() {
		
		$sql="SELECT id, title, content, DATE_FORMAT( postdate, '%D %M %Y' ) AS postdate, alternate, ifnull( c.commentscount, 0 ) AS count
			FROM blogs b
			LEFT OUTER
			JOIN (
				SELECT pageid, page, count( * ) AS commentscount
				FROM comments
				GROUP BY pageid
			) AS c ON c.pageid = b.id
			WHERE archived = :archived
			ORDER BY id DESC
			LIMIT 1 ";
			
        $rows = $this->db->selectCache('index_BlogsContent', $sql, array(':archived' => 'n'));

		return array('rows' => $rows);	
    }
}