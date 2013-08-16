<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('navbar_model');
    $this->load->model('article_model');
    $this->load->model('globals');
  }

	public function view($page = 'none')
	{
    $data['title'] = ucfirst($page); // Capitalize the first letter
    $data['page']  = $page; // Capitalize the first letter
    $data['navId'] = 'Articles';
    $data['pageWrapperDiv'] = 'article';
    $data['useSpyScroll'] = true;
    $data['hasSidebar']   = true;
    $data['navbar']       = $this->navbar_model->get_navbar();
    $data['articles']     = $this->article_model->get_articles();;
    $data['keydesc']      = $this->article_model->get_keyword_description();
    $data['sidebar_text'] = $this->globals->get_default_sidebar();
    $data['showComments'] = false;

    if (array_key_exists($page, $data['articles'])) {
      $data['title'] = $data['articles'][$page][0];
    }

    /* Show page */
    if ( ! file_exists('application/views/articles/'.$page.'.php')) {
      $data['navId'] = 'none';
      $this->load->view('header', $data);
      $this->load->view('errors/404', $data);
      $this->load->view('footer');
    }
    else{
      $this->load->view('header', $data);
      $this->load->view('article_date', $data);
      $this->load->view('common_article_util', $data);
      $this->load->view('articles/'.$page, $data);
      $this->load->view('footer');
    }

	}
}
