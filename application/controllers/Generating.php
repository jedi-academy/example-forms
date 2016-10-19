<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Generating extends Application {

	function __construct()
	{
		parent::__construct();
		$this->load->library('parser'); // so we don't have to do this inside methods
		$this->load->helper('html');

		// a record object to present
		$starter = new stdClass();
		$starter->name = 'George';
		$starter->size = 'lg';
		$starter->cup = 'steel';
		$starter->opt1 = true;
		$starter->opt2 = false;
		$starter->opt3 = true;
		$starter->extra = 1;
		$starter->message = 'Shaken, not stirred';
		$this->starter = $starter;
	}

	public function index()
	{
		$this->data['pagebody'] = 'generating';
		$this->render();
	}

	// Plain HTML - hard-coded :(
	function p01()
	{
		$this->load->view("bob/p01");
	}

	// Use CodeIgniter HTML helper
	function p02()
	{
		$this->load->helper('html');
		$parms = array(
			'heading' => heading('Build Your Coffee ' . img("images/logo.png"), 2)
		);
		$this->parser->parse("bob/p02", $parms);
	}

	// Use CodeIgniter form helper
	function p03()
	{
		$this->load->helper(['html', 'form']);
		$forming = form_open("/generating/showme");
		$forming .= form_label('Your name: ');
		$forming .= form_input(['name' => 'name']) . br();
		$forming .= form_label('Size: ');
		$forming .= form_radio('size', 'sm') . form_label('Small');
		$forming .= form_radio('size', 'md') . form_label('Medium');
		$forming .= form_radio('size', 'lg', true) . form_label('Large');
		$forming .= form_radio('size', 'hu') . form_label('Ludicrous') . br();
		$forming .= form_label('Cup composition: ');
		$forming .= form_dropdown('cup', ['paper' => 'Paper', 'steel' => 'Stainless', 'glaze' => 'Porcelain']) . br();
		$forming .= form_label('Options? ');
		$forming .= form_checkbox('opt1', true, true) . ' Caramel sauce';
		$forming .= form_checkbox('opt2', false, false) . ' Sprinkles';
		$forming .= form_checkbox('opt3', true, true) . ' Ketchup' . br();
		$forming .= form_label('# of extra shots: ');
		$forming .= form_input(['name' => 'extra', 'type' => 'number', 'min' => '0', 'max' => '3'], 1) . br();
		$forming .= form_label('Special instructions? ');
		$forming .= form_textarea(['name' => 'message', 'rows' => 3, 'cols' => 30]) . br();
		$forming .= form_submit('submit', 'Please');
		$forming .= form_close();
		$parms = array(
			'heading' => heading('Build Your Coffee ' . img("images/logo.png"), 2),
			'theform' => $forming
		);
		$this->parser->parse("bob/p03", $parms);
	}

	// View fragments, using template parser
	function p04()
	{
		$this->load->view("bob/p04");
	}

	// Add some initial data, from array
	function p05()
	{
		// top of form
		$this->load->helper('html');
		$parms = array(
			'heading' => heading('Build Your Coffee ' . img("images/logo.png"), 2)
		);
		// state of a record to use as source
		$record = (array) $this->starter;
		// convert it into usable view parms
		$recordParms = array(
			'name' => $record['name'], 'checked-' . $record['size'] => 'checked',
			'select-' . $record['cup'] => 'selected',
			'checked-opt1' => $record['opt1'] ? 'checked' : '',
			'checked-opt2' => $record['opt2'] ? 'checked' : '',
			'checked-opt3' => $record['opt3'] ? 'checked' : '',
			'extra' => $record['extra'], 'message' => $record['message']
		);
		// add the view parms together
		$parms = array_merge($parms, $recordParms);
		// and ... parse
		$this->parser->parse("bob/p05", $parms);
	}

	// Add some initial data, from object
	function p06()
	{
		// top of form
		$this->load->helper('html');
		$parms = array(
			'heading' => heading('Build Your Coffee ' . img("images/logo.png"), 2)
		);
		$record = $this->starter;
		// make view parms for it
		$recordParms = array(
			'name' => $record->name, 'checked-' . $record->size => 'checked',
			'select-' . $record->cup => 'selected',
			'checked-opt1' => $record->opt1 ? 'checked' : '',
			'checked-opt2' => $record->opt2 ? 'checked' : '',
			'checked-opt3' => $record->opt3 ? 'checked' : '',
			'extra' => $record->extra, 'message' => $record->message
		);
		// merge our view parms and go
		$parms = array_merge($parms, $recordParms);
		$this->parser->parse("bob/p05", $parms);
	}

	// Make fields using CodeIgniter form helper
	function p07()
	{
		$this->load->helper(['html', 'form']);
		$record = $this->starter;
		$parms = array(
			'heading' => heading('Build Your Coffee ' . img("images/logo.png"), 2),
			'fname' => 'Your name: ' . form_input(['name' => 'name'], $record->name) . br(),
			'fsize' => form_label('Size: ') .
				form_radio('size', 'sm', 'sm'==$record->size) . form_label('Small') .
				form_radio('size', 'md', 'md'==$record->size) . form_label('Medium') .
				form_radio('size', 'lg', 'lg'==$record->size) . form_label('Large') .
				form_radio('size', 'hu', 'hu'==$record->size) . form_label('Ludicrous') . br(),
			'fcup' => form_label('Cup composition: ') . form_dropdown('cup', 
					['paper' => 'Paper', 'steel' => 'Stainless', 'glaze' => 'Porcelain'], $record->cup) . br(),
			'fopt1' => form_checkbox('opt1', 'sweet', $record->opt1) . ' Caramel sauce',
			'fopt2' => form_checkbox('opt2', 'sprink', $record->opt2) . ' Sprinkles',
			'fopt3' => form_checkbox('opt3', 'cats', $record->opt3) . ' Ketchup' . br(),
			'fextra' => form_label('# of extra shots: ') . 
				form_input(['name' => 'extra', 'type' => 'number', 'min' => '0', 'max' => '3'], $record->extra) . br(),
			'fmessage' => form_label('Special instructions? ') . 
				form_textarea(['name' => 'message', 'rows' => 3, 'cols' => 30], $record->message) . br(),
			'fsubmit' => form_submit('submit', 'Please')
		);
		$this->parser->parse("bob/p07", $parms);
	}

	// Build your own form helper
	function p08()
	{
		$this->load->helper(['html', 'form', 'formfields']);
		$record = $this->starter;
		$parms = array(
			'heading' => heading('Build Your Coffee ' . img("images/logo.png"), 2),
			'fname' => makeTextField('Your name: ','name', $record->name),
			'fsize' => makeRadioButtons('Size: ', 'size', $record->size, 
					['sm'=>'Small', 'md'=>'Medium', 'lg'=>'Large', 'hu'=>'Ludicrous']),
			'fcup' => makeCombobox('Cup composition: ', 'cup', $record->cup, 
					['paper' => 'Paper', 'steel' => 'Stainless', 'glaze' => 'Porcelain']),
			'fopt1' => makeCheckbox('Caramel sauce', 'opt1', $record->opt1),
			'fopt2' => makeCheckbox('Sprinkles','opt2', $record->opt2),
			'fopt3' => makeCheckbox('Ketchup','opt3', $record->opt3),
			'fextra' => makeTextField('# of extra shots: ', 'extra', $record->extra),
			'fmessage' => makeTextarea('Special instructions? ', 'message', $record->message, '', 30, 3),
			'fsubmit' => makeSubmitButton('Please', 'Just hit me')
		);
		$this->parser->parse("bob/p07", $parms);
	}

	// Display what was submitted
	function showme()
	{
		$result = heading('Data submitted from form', 2) . br();
		$incoming = $this->input->post();
		foreach ($incoming as $key => $value)
			$result .= $key . ' : ' . $value . br();
		$this->data['content'] = $result;
		$this->render('template-simple');
	}

}
