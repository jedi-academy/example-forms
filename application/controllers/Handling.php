<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Handling extends Application {

	function __construct()
	{
		parent::__construct();
		$this->load->library('parser'); // so we don't have to do this inside methods
		$this->load->helper(['html', 'form', 'formfields']);
		// a record object to work with
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
		// result after handling the form
		$this->record = new stdClass();
	}

	// build base form parameters
	private function basics($record = null)
	{
		if ($record == null)
			$record = $this->starter;
		$parms = array(
			'heading' => heading('Build Your Coffee ' . img("images/logo.png"), 2),
			'fname' => makeTextField('Your name: ', 'name', $record->name),
			'fsize' => makeRadioButtons('Size: ', 'size', $record->size, ['sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large', 'hu' => 'Ludicrous']),
			'fcup' => makeCombobox('Cup composition: ', 'cup', $record->cup, ['paper' => 'Paper', 'steel' => 'Stainless', 'glaze' => 'Porcelain']),
			'fopt1' => makeCheckbox('Caramel sauce', 'opt1', $record->opt1),
			'fopt2' => makeCheckbox('Sprinkles', 'opt2', $record->opt2),
			'fopt3' => makeCheckbox('Ketchup', 'opt3', $record->opt3),
			'fextra' => makeTextField('# of extra shots: ', 'extra', $record->extra),
			'fmessage' => makeTextarea('Special instructions? ', 'message', $record->message, '', 30, 3),
			'fsubmit' => makeSubmitButton('Please', 'Just hit me'),
			'target' => 'q01'
		);
		return $parms;
	}

	// reset the session's record
	public function p99()
	{
		$this->index();
	}

	public function index()
	{
		$this->data['pagebody'] = 'handling';
		$this->render();
	}

	// Traditional handling
	function p01()
	{
		$record = $this->starter;
		$parms = array_merge($this->basics($this->starter), ['target' => 'q01']);
		$this->parser->parse("fred/p01", $parms);
	}

	// Handler form submission traditionally
	function q01()
	{
		$this->record = $this->extractBasic();
		$this->showme();
	}

	// extract fields traditionally
	private function extractBasic()
	{
		$record = new stdClass();
		$record->name = $_POST['name'];
		$record->size = $_POST['size'];
		$record->cup = $_POST['cup'];
		$record->opt1 = isset($_POST['opt1']) ? true : false;
		$record->opt2 = isset($_POST['opt2']) ? true : false;
		$record->opt3 = isset($_POST['opt3']) ? true : false;
		$record->extra = $_POST['extra'];
		$record->message = $_POST['message'];
		return $record;
	}

	// CodeIgniter handling
	function p02()
	{
		$record = $this->starter;
		$parms = array_merge($this->basics(), ['target' => 'q02']);
		$this->parser->parse("fred/p01", $parms);
	}

	// Handler form submission traditionally
	function q02()
	{
		$this->record = $this->extract();
		$this->showme();
	}

	// Extract fields the CI way
	private function extract()
	{
		$record = new stdClass();
		$record->name = $this->input->post('name');
		$record->size = $this->input->post('size');
		$record->cup = $this->input->post('cup');
		$record->opt1 = $this->input->post('opt1');
		$record->opt2 = $this->input->post('opt2');
		$record->opt3 = $this->input->post('opt3');
		$record->extra = $this->input->post('extra');
		$record->message = $this->input->post('message');
		return $record;
	}

	// Basic error handling
	function p03()
	{
		$record = $this->starter;
		$parms = array_merge($this->basics(), ['target' => 'q03']);
		$this->parser->parse("fred/p01", $parms);
	}

	// Handler form submission traditionally
	function q03()
	{
		$this->record = $this->extract();
		$record = $this->record;

		$errors = array();
		if (empty($record->name))
			$errors[] = 'You have to provide a name';
		// purposeful error:
		if (!in_array($record->size, ['sm', 'md', 'large', 'hu']))
			$errors[] = 'Incorrect size';
		if (!($record->opt1 || $record->opt2 || $record->opt3))
			$errors[] = 'Must pick at least one option';
		if ((!empty($record->message)) && (strlen($record->message) < 10))
			$errors[] = 'Message, if provided, must be longer than 10 chars';

		$this->showme($errors);
	}

	// Form validation
	function p04()
	{
		$record = $this->starter;
		$parms = array_merge($this->basics(), ['target' => 'q04']);
		$this->parser->parse("fred/p01", $parms);
	}

	// Do form validation
	function q04()
	{
		$this->load->library('form_validation');
		$this->record = $this->extract();

		$errors = array();

		$this->form_validation->set_rules('name', 'Customer name', 'required');
		$this->form_validation->set_rules('size', 'Drink size', 'in_list[sm,md,large,hu]');
		$this->form_validation->set_rules('opt1', 'Options', 'callback_need1');


		if ($this->form_validation->run() == TRUE)
		{
			$this->showme('No validation errors');
			return;
		}

		$this->showme(validation_errors());
	}

	// Validation - ensure at least one option
	// Parameter passed is ignored, because it if a single field
	// Yes, this isn't quite proper, but expedient
	function need1($str)
	{
		$record = $this->record;
		if (!($record->opt1 || $record->opt2 || $record->opt3))
		{
			$this->form_validation->set_message('need1', 'Must pick at least one option');
			return false;
		} else
			return true;
	}

	// Data transfer buffer
	function p05()
	{
		if ($this->session->has_userdata('record'))
			$record = $this->session->userdata('record');
		else
		{
			$record = $this->starter;
			$this->session->set_userdata('record', $record);
		}
		$parms = array_merge($this->basics($record), ['target' => 'q05']);
		$this->parser->parse("fred/p01", $parms);
	}

	// Do form validation & use data transfer buffer
	function q05()
	{
		$this->load->library('form_validation');
		$this->record = $this->extract();

		$errors = array();

		$this->form_validation->set_rules('name', 'Customer name', 'required');
		$this->form_validation->set_rules('size', 'Drink size', 'in_list[sm,md,large,hu]');
		$this->form_validation->set_rules('opt1', 'Options', 'callback_need1');


		if ($this->form_validation->run() == TRUE)
		{
			$this->showme('No validation errors');
			// save the record appropriately, and then...
			$this->session->unset_userdata('record');
			return;
		}

		// update the DTB so we don't lose current changes
		$this->session->set_userdata('record',$this->record);
		$this->showme(validation_errors());
	}

	// Display what was submitted
	function showme($errors = '')
	{
		$result = heading('Data submitted from form', 2);
		$result .= json_encode($_POST) . br();
		$this->data['content'] = $result;

		$result2 = heading('The updated record', 2);
		$result2 .= json_encode($this->record) . br();
		$this->data['content'] .= $result2;

		$booboos = '';
		if (!empty($errors))
		{
			$booboos = heading('Errors detected', 2);
			if (is_array($errors))
			{
				foreach ($errors as $error)
					$booboos .= $error . br();
			} else
			{
				$booboos .= $errors;
			}
		}
		$this->data['content'] .= $booboos;
		$this->render('template-simple');
	}

}
