<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function __construct()
	{
    parent::__construct();
    $this->load->model('navbar_model');
    $this->load->model('article_model');
    $this->load->model('jotting_model');
    $this->load->model('common_model');
    $this->load->model('globals');
  }

  public function articles($key='')
  {
    $data['title'] = 'Articles';
    $data['navId'] = 'Articles';
    $data['navbar']   = $this->navbar_model->get_navbar();
    $data['articles'] = $this->article_model->get_articles();
    $data['keydesc']  = $this->common_model->get_keyword_description();

    // Prune list of articles if keyword set
    $data['keywordUsed'] = $key;
    $data['isKeywordFiltering'] = false;

    $isKeywordSet   = $key;
    $isKeywordValid = array_key_exists($key, $data['keydesc']);
    if ($isKeywordSet && $isKeywordValid) {
      $data['isKeywordFiltering'] = true;
      foreach($data['articles'] as $article=>$value) {
        if (!in_array($key, $value[3])) {
          unset($data['articles'][$article]);
        }
      }
    }
    $data['articleCount'] = sizeof($data['articles']);

    if ((!$isKeywordSet || $isKeywordValid)) {
      $this->load->view('header', $data);
      $this->load->view('pages/articles', $data);
      $this->load->view('footer', $data);
    } else {
      $this->load->view('header', $data);
      $this->load->view('errors/404', $data);
      $this->load->view('footer', $data);
    }
  }

  public function jottings($key='')
  {
    $data['title'] = 'Jottings';
    $data['navId'] = 'Jottings';
    $data['navbar'] = $this->navbar_model->get_navbar();
    $data['jottings'] = $this->jotting_model->get_jottings();
    $data['keydesc']  = $this->common_model->get_keyword_description();

    // Prune list of articles if keyword set
    $data['keywordUsed'] = $key;
    $data['isKeywordFiltering'] = false;
    $isKeywordSet   = $key;
    $isKeywordValid = array_key_exists($key, $data['keydesc']);
    if ($isKeywordSet && $isKeywordValid) {
      $data['isKeywordFiltering'] = true;
      foreach($data['jottings'] as $jotting=>$value) {
        if (!in_array($key, $value[3])) {
          unset($data['jottings'][$jotting]);
        }
      }
    }
    $data['jottingCount'] = sizeof($data['jottings']);

    if ((!$isKeywordSet || $isKeywordValid)) {
      $this->load->view('header', $data);
      $this->load->view('pages/jottings', $data);
      $this->load->view('footer', $data);
    } else {
      $this->load->view('header', $data);
      $this->load->view('errors/404', $data);
      $this->load->view('footer', $data);
    }
  }

  public function contact($void='')
  {
    $data['title'] = 'Contact';
    $data['navId'] = 'Contact';
    $data['navbar'] = $this->navbar_model->get_navbar();
    $this->load->view('header', $data);
    $this->load->view('pages/contact', $data);
    $this->load->view('footer', $data);
  }

	public function view($page = 'home')
	{
    $data['title'] = ucfirst($page);
    $data['navId'] = ucfirst($page);

    $data['navbar'] = $this->navbar_model->get_navbar();
    $data['articles']=$this->article_model->get_articles();
    $data['keydesc']=$this->common_model->get_keyword_description();

    $data['sidebar_text'] = $this->globals->get_default_sidebar();

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
