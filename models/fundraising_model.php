<?php

class Fundraising_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }

	public function fundraisingContent() {
		
        return $this->db->singleCache('fundraisingContent', 'SELECT content FROM info where id = :id LIMIT 1', array(':id' => 4));
    }
}