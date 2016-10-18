<?php

/**
 * This is a mock model for contacts, but with bogus hard-coded data,
 * so that we don't have to worry about any database setup.
 *
 * @author jim
 */
class Contacts extends CI_Model {

	var $data = array(
		array('id' => '1', 'firstname' => 'Mark', 'lastname' => 'Otto', 'username' => '@mdo'),
		array('id' => '2', 'firstname' => 'Jacob', 'lastname' => 'Thornton', 'username' => '@fat'),
		array('id' => '3', 'firstname' => 'Larry', 'lastname' => 'the Bird', 'username' => '@twitter'),
	);

	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	// retrieve a single record
	public function get($which)
	{
		// iterate over the data until we find the one we want
		foreach ($this->data as $record)
			if ($record['id'] == $which)
				return $record;
		return null;
	}

	// retrieve all of the records, as a "map"
	public function all()
	{
		$results = array();
		foreach ($this->data as $record)
			$results[$record['id']] = (object) $record;
		return $results;
	}

	// retrieve all of the records, as an array of objects
	public function objects()
	{
		$results = array();
		foreach ($this->data as $record)
			$results[] = (object) $record;
		return $results;
	}
}
