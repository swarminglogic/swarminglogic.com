<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function __construct()
	{
    parent::__construct();
    $this->load->model('navbar_model');
    $this->load->model('article_model');
    $this->load->model('globals');
  }

	public function view($page = 'home')
	{
    $data['title'] = ucfirst($page); // Capitalize the first letter
    $data['navId'] = ucfirst($page);

    $data['navbar'] = $this->navbar_model->get_navbar();
    $data['articles']=$this->article_model->get_articles();
    $data['keydesc']=$this->article_model->get_keyword_description();

    $data['sidebar_text'] = $this->globals->get_default_sidebar();

    // Check if RSS:Feed
    if ($page == "feed") {
      // Implement RSS Feed
      return;
    }

    // Load default website
    if ( ! file_exists('application/views/pages/'.$page.'.php')) {
      $this->load->view('header', $data);
      $this->load->view('errors/404', $data);
      $this->load->view('footer', $data);
    }
    else {
      $this->load->view('header', $data);
      $this->load->view('pages/'.$page, $data);
      $this->load->view('footer', $data);
    }
	}
}
