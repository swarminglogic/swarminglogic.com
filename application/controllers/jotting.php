<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jotting extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('navbar_model');
    $this->load->model('jotting_model');
    $this->load->model('common_model');
    $this->load->model('globals');
  }

	public function view($page = 'none')
	{
    $data['title'] = ucfirst($page);
    $data['page']  = $page;
    $data['navId'] = 'Jottings';
    $data['pageWrapperDiv'] = 'article';
    $data['pagestyle']      = 'jotting';
    $data['useSpyScroll'] = true;
    $data['hasSidebar']   = true;
    $data['navbar']       = $this->navbar_model->get_navbar();
    $data['jottings']     = $this->jotting_model->get_jottings();;
    $data['keydesc']      = $this->common_model->get_keyword_description();
    $data['sidebar_text'] = $this->globals->get_default_sidebar();
    $data['showComments'] = false;

    if (array_key_exists($page, $data['jottings'])) {
      $data['title'] = $data['jottings'][$page][0];
    }

    /* Show page */
    if ( ! file_exists('application/views/jottings/'.$page.'.php')) {
      $data['navId'] = 'none';
      $this->load->view('header', $data);
      $this->load->view('errors/404', $data);
      $this->load->view('footer');
    }
    else{
      $this->load->view('header', $data);
      $this->load->view('article_date', $data);
      $this->load->view('common_article_util', $data);
      $this->load->view('jottings/'.$page, $data);
      $this->load->view('footer');
    }

	}
}
