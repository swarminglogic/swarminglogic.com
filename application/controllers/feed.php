<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->helper('xml');
    $this->load->helper('text');
    $this->load->model('entry_model');
    $this->load->model('globals');
  }

	public function view($page = 'none')
	{
    $data['articles'] = $this->entry_model->articles;
    $data['jottings'] = $this->entry_model->jottings;
    header("Content-Type: application/rss+xml");
    $this->load->view('feed', $data);
	}
}
