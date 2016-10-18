<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Uploading extends Application {

	function __construct()
	{
		parent::__construct();
		$this->load->model('contacts'); // so we can use this everywhere here
		$this->load->library('parser'); // so we don't have to do this inside methods
	}

	public function index()
	{
		$this->data['pagebody'] = 'uploading';
		$this->render();
	}

	// Plain HTML - hard-coded :(
	function p01()
	{
		$this->load->view("cons/p01");
	}

	// Traditional data-driven construction
	function p02()
	{
		$contacts = $this->contacts->all();
		$parms = array('contacts' => (object) $contacts);
		$this->load->view("cons/p02", $parms);
	}

	// Use template parser instead
	function p03()
	{
		$rows = array();
		foreach ($this->contacts->objects() as $record)
			$rows[] = (array) $record; // parser works with arrays
		$parms = array('records' => $rows); // array of arrays
		$this->parser->parse("cons/p03", $parms);
	}

	// View fragments, using template parser
	function p04()
	{
		$result = '';
		foreach ($this->contacts->objects() as $record)
			$result .= $this->parser->parse('cons/p04row', (array) $record, true);
		$parms = array('inside_stuff' => $result);
		$this->parser->parse("cons/p04", $parms);
	}

}
