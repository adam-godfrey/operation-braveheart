<?php

class Database extends PDO {

    private $cache = NULL;
	
    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS);
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		// store Cache class instance
        $this->cache = Cache::getInstance();
    }
	
    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
		$sth = $this->prepare($sql);
		foreach ($array as $key => $value)
		{
			$sth->bindValue("$key", $value);
		}
		
		$sth->execute();
		return $sth->fetchAll($fetchMode);
    }
	
	/**
     * single
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function single($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
		$sth = $this->prepare($sql);
		foreach ($array as $key => $value)
		{
			$sth->bindValue("$key", $value);
		}
		
		$sth->execute();
		return $sth->fetch($fetchMode);
    }
	
	/**
     * count
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function count($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
		$sth = $this->prepare($sql);
		foreach ($array as $key => $value)
		{
			$sth->bindValue("$key", $value);
		}
		
		$sth->execute();
		return $sth->fetchColumn();
	}
	
	/**
     * count
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function rowcount($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
		
		$sth = $this->prepare($sql);
		foreach ($array as $key => $value)
		{
			$sth->bindValue("$key", $value);
		}
        
        $sth->execute();
        return $sth->rowCount();
    }
	
	/**
     * clean
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function clean($sql, $fetchMode = PDO::FETCH_ASSOC)
    {
		$sth = $this->query($sql);
		//$sth->execute();
		return $sth->fetchAll();	
    }
	
	
    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function selectCache($table, $sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
		// if the cache file is valid fetch records from cache file
        if ($this->cache->valid($table))
        {
           return $this->cache->get($table);
        }
        else
        {
			$sth = $this->prepare($sql);
			foreach ($array as $key => $value) {
				$sth->bindValue("$key", $value);
			}
			
			$sth->execute();
			$rows = $sth->fetchAll($fetchMode);
			$this->cache->set($table, $rows);
			return $rows;
		}
    }
	
	/**
     * single
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function singleCache($table, $sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
		// if the cache file is valid fetch records from cache file
        if ($this->cache->valid($table))
        {
           return $this->cache->get($table);
        }
        else
        {
			$sth = $this->prepare($sql);
			foreach ($array as $key => $value) {
				$sth->bindValue("$key", $value);
			}
			
			$sth->execute();
			$rows = $sth->fetch($fetchMode);
			$this->cache->set($table, $rows);
			return $rows;
		}
    }
	
	/**
     * count
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function countCache($table, $sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
		// if the cache file is valid fetch records from cache file
        if ($this->cache->valid($table))
        {
           return $this->cache->get($table);
        }
        else
        {
			$sth = $this->prepare($sql);
			foreach ($array as $key => $value) {
				$sth->bindValue("$key", $value);
			}
			
			$sth->execute();
			$rows = $sth->fetchColumn();
			$this->cache->set($table, $rows);
			return $rows;
		}
	}
	
	/**
     * count
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function rowcountCache($table, $sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
		// if the cache file is valid fetch records from cache file
        if ($this->cache->valid($table))
        {
           return $this->cache->get($table);
        }
        else
        {
			$sth = $this->prepare($sql);
			foreach ($array as $key => $value)
			{
				$sth->bindValue("$key", $value);
			}
		}
        
        $sth->execute();
        $rows = $sth->rowCount();
		$this->cache->set($table, $rows);
		return $rows;
    }
	
	/**
     * clean
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function cleanCache($table, $sql, $fetchMode = PDO::FETCH_ASSOC)
    {
		// if the cache file is valid fetch records from cache file
        if ($this->cache->valid($table))
        {
           return $this->cache->get($table);
        }
        else
        {
			$sth = $this->query($sql);
		    //$sth->execute();
			$rows = $sth->fetchAll();
			$this->cache->set($table, $rows);
			return $rows;
		}
    }
    
    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */
	public function insert($table, $data)
	{
		ksort($data);
		
		$fieldNames = implode('`, `', array_keys($data));
		$fieldValues = ':' . implode(', :', array_keys($data));
		
		$sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
		
		foreach ($data as $key => $value)
		{
			$sth->bindValue(":$key", $value);
		}
		
		return ($sth->execute()) ? true : false;
	}
    
    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data, $where)
    {
        ksort($data);
        
        $fieldDetails = NULL;
        foreach($data as $key=> $value)
		{
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        
        foreach ($data as $key => $value)
		{
            $sth->bindValue(":$key", $value);
        }
        
        return ($sth->execute()) ? true : false;
    }
    
    /**
     * delete
     * 
     * @param string $table
     * @param string $where
     * @param integer $limit
     * @return integer Affected Rows
     */
    public function delete($table, $where)
    {
        return $this->exec("DELETE FROM $table WHERE $where");
    }
	
	/**
    * Returns the ID of the last row inserted
    * @return int
    * @access public
    */
	public function lastInsertId($seqname = null)
	{
		return parent::lastInsertId();
	}
	
	/**
	* Initiates a transaction 
	* @return boolean
	* @access pubic
	*/
	public function beginTransaction()
	{
		return parent::beginTransaction();
	}
		
	/**
	* Commits a transaction 
	* @return boolean
	* @access pubic
	*/
	public function endTransaction()
	{
		return parent::commit();
	}
	
	/**
	* Rolls back a transaction 
	* @return boolean
	* @access pubic
	*/
	public function cancelTransaction()
	{
		return parent::rollBack();
	}
	
	/**
     * updatein
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
	public function updatein($table, $data, $where, $ids)
	{
		ksort($data);
        
        $fieldDetails = NULL;
        foreach($data as $key=> $value)
		{
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where IN (:ids)");
        
        foreach ($data as $key => $value)
		{
            $sth->bindValue(":$key", $value);
        }
		
		$sth->bindParam(':ids', implode(",", $ids));
        
        $sth->execute();
	}
	
	/**
	 * increment
	 * @param string $sql An SQL string
	 * @param array $array Paramters to bind
	 */
	public function increment($sql, $array = array())
	{
		$sth = $this->prepare($sql);
		foreach ($array as $key => $value)
		{
			$sth->bindValue("$key", $value);
		}
	}
	
	/**
     * updateCase
     * @param string $table A name of table to update
     * @param string $field The field to update
     * @param string $where the WHERE query part
     */
	public function updateCase($table, $field, $where)
	{
		$sth = $this->prepare("UPDATE $table  
			SET $field = CASE  
				WHEN $field = 0 THEN 1 
					ELSE $field = 0
				END 
			WHERE $where");
		
        return ($sth->execute()) ? true : false;
	}
}