<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploadtest extends CI_Controller {

	public function __construct()
	{
	   parent::__construct();
	   $this->load->helper(array('url', 'form'));
	   $this->load->library(array('session', 'encrypt'));
	}

	public function index()
	{
		$this->load->view('upload_form');
	}

	public function uploadify()
	{
		$config['upload_path'] = "./uploads";
		$config['allowed_types'] = '*';
		$config['max_size'] = 0;
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload("userfile"))
		{
			$error = $this->upload->display_errors();
			var_dump($this->upload->data());
			var_dump($error);
		}
		else
		{
			$data = $this->upload->data();

			var_dump($data);
		}
	}
}

/* End of file uploadify.php */
/* Location: ./application/controllers/uploadify.php */