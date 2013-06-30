<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('article_model');
    $this->load->model('globals');
  }

	public function view($page = 'none')
	{
    $data['articles'] = $this->article_model->get_articles();
    $this->load->view('feed', $data);
	}
}
