<?php

class Search_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	private $words = NULL;
	
	
    public function __construct()
    {
        parent::__construct();
		
		$this->words = new Words();
		
		$this->getcount;
		$this->total_pages;
    }
	
	public function getRowCount($keywords) {
	
		$sql = "SELECT COUNT(*) FROM (SELECT t.boardid, t.topicid, 'messages' as mytable, topicname as title, message as content,
		MATCH(topicname, message) AGAINST(:keywords IN BOOLEAN MODE)
		as score FROM topics t INNER JOIN messages m ON t.topicid=m.topicid  
		WHERE MATCH(topicname, message) 
		AGAINST(:keywords IN BOOLEAN MODE)
		UNION ALL
		SELECT id,'', 'news' as mytable,title, content,
		MATCH(title, content) AGAINST(:keywords IN BOOLEAN MODE)
		as score FROM news WHERE archived = :archived AND MATCH(title, content) 
		AGAINST(:keywords IN BOOLEAN MODE)
		UNION ALL
		SELECT  id,'', 'events' as mytable,title, content,
		MATCH(title, content) AGAINST(:keywords IN BOOLEAN MODE)
		as score FROM events WHERE archived = :archived AND MATCH(title, content) 
		AGAINST(:keywords IN BOOLEAN MODE)
		UNION ALL
		SELECT  id,'', 'blogs' as mytable,title, content,
		MATCH(title, content) AGAINST(:keywords IN BOOLEAN MODE)
		as score FROM blogs WHERE archived = :archived AND MATCH(title, content) 
		AGAINST(:keywords IN BOOLEAN MODE)
		UNION ALL
		SELECT  id,'', 'articles' as mytable,title, content,
		MATCH(title, content) AGAINST(:keywords IN BOOLEAN MODE)
		as score FROM articles WHERE archived = :archived AND MATCH(title, content) 
		AGAINST(:keywords IN BOOLEAN MODE)) a GROUP BY title";
				
		return (int) $this->db->rowcount($sql, array(':keywords' => $keywords.'*', ':archived' => 'N'));
	}
	
	public function getContent($entries_per_page, $pageno = '', $keywords) {
	
		// get the number of rows
		$this->getcount = $this->getRowCount($keywords);
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1);
		// set the number of entries to appear on the page
		 
		// total pages is rounded up to nearest integer
		$this->total_pages = ceil($this->getcount/$entries_per_page); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);
			
		if($this->getcount != 0) {
		
		$sql = "SELECT * FROM (
				SELECT b.boardname as id, t.topicname as topicname, 'messages' as mytable, topicname as title,message as content,'' as position,
					MATCH(topicname) AGAINST(:keywords IN BOOLEAN MODE) * 8 +
					MATCH(message) AGAINST(:keywords IN BOOLEAN MODE) * 4
						as score FROM topics t INNER JOIN messages m ON t.topicid=m.topicid INNER JOIN boards b on  b.boardid=t.boardid
							WHERE MATCH(topicname, message) 
								AGAINST(:keywords IN BOOLEAN MODE)
				UNION ALL
					SELECT  id,'' as topicname, 'events' as mytable,title, content, position, 
						MATCH(title) AGAINST(:keywords  IN BOOLEAN MODE) * 8 +
						MATCH(content) AGAINST(:keywords IN BOOLEAN MODE) * 4
							as score FROM events JOIN (
								SELECT id as eventid, @rownum:=@rownum+1 position, archived
									FROM events, (SELECT @rownum:=0) r WHERE archived = :archived
										ORDER BY eventid DESC
								) AS position ON id=eventid
							WHERE events.archived = :archived AND MATCH(title, content) 
								AGAINST(:keywords IN BOOLEAN MODE)
				UNION ALL
					SELECT  id,'' as topicname, 'news' as mytable,title, content, position, 
						MATCH(title) AGAINST(:keywords  IN BOOLEAN MODE) * 8 +
						MATCH(content) AGAINST(:keywords IN BOOLEAN MODE) * 4
							as score FROM news JOIN (
								SELECT id as newsid, @rownum:=@rownum+1 position, archived
									FROM news, (SELECT @rownum:=0) r WHERE archived = :archived
										ORDER BY newsid DESC
								) AS position ON id=newsid
							WHERE news.archived = :archived AND MATCH(title, content) 
								AGAINST(:keywords IN BOOLEAN MODE)
				UNION ALL
					SELECT  id,'' as topicname, 'blogs' as mytable,title, content, position, 
						MATCH(title) AGAINST(:keywords  IN BOOLEAN MODE) * 8 +
						MATCH(content) AGAINST(:keywords IN BOOLEAN MODE) * 4
							as score FROM blogs JOIN (
								SELECT id as blogid, @rownum:=@rownum+1 position, archived
									FROM blogs, (SELECT @rownum:=0) r WHERE archived = :archived
										ORDER BY blogid DESC
								) AS position ON id=blogid
							WHERE blogs.archived = :archived AND MATCH(title, content) 
								AGAINST(:keywords IN BOOLEAN MODE)
				UNION ALL
					SELECT  id,'' as topicname, 'articles' as mytable,title, content, position, 
						MATCH(title) AGAINST(:keywords  IN BOOLEAN MODE) * 8 +
						MATCH(content) AGAINST(:keywords IN BOOLEAN MODE) * 4
							as score FROM articles JOIN (
								SELECT id as articleid, @rownum:=@rownum+1 position, archived
									FROM articles, (SELECT @rownum:=0) r WHERE archived = :archived
										ORDER BY articleid DESC
								) AS position ON id=articleid
							WHERE articles.archived = :archived AND MATCH(title, content) 
								AGAINST(:keywords IN BOOLEAN MODE)
				) a ORDER BY score DESC, id DESC LIMIT $offset,$entries_per_page";	
				
			// get the start time of the query
			$start_time = Braveheart::getmicrotime();		
			// execute the query
			$rows = $this->db->select($sql, array(':keywords' => $keywords.'*', ':archived' => 'N'));
			// get the end time of the query
			$end_time = Braveheart::getmicrotime();
			
			Session::set('keywords',$keywords);

			$querytime = substr($end_time-$start_time,0,5);
			
			foreach($rows as &$row) {
				
				$row['title'] = preg_replace("/$keywords/i", "<span class=\"searchbold\">\$0</span>", ucwords(strtolower($row['title'])));
				$row['content'] = preg_replace("/$keywords/i", "<span class=\"searchbold\">\$0</span>", $this->words->ShortenText($row['content'], 300));
			}
			
			return array(
				'rows' => $rows, 
				'total_pages' => $this->total_pages, 
				'page' => $page, 
				'querytime' => $querytime,
				'totalcount' => $this->getcount,
				'rowcount' => $this->getcount
			);
		}
	}
}