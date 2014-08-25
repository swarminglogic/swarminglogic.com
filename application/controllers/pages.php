<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function __construct()
	{
    parent::__construct();
    $this->load->model('navbar_model');
    $this->load->model('entry_model');
    $this->load->model('common_model');
    $this->load->model('globals');
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


  public function articles($key='') {
    $this->entriesViewer('Articles', 'article', 'articles', $key);
  }

  public function jottings($key='') {
    $this->entriesViewer('Jottings', 'jotting', 'jottings', $key);
  }

  public function article($page='') {
    $this->entryViewer('Articles','article', 'articles', $page);
  }

  public function jotting($page='') {
    $this->entryViewer('Jottings','jotting', 'jottings', $page);
  }


  private function entriesViewer($title,
                                 $type, $types,
                                 $key)
  {
    $data['title'] = $title;
    $data['navId'] = $title;
    $data['type']  = $type;
    $data['types'] = $types;

    $data['navbar']  = $this->navbar_model->get_navbar();
    $data['entries'] = $this->entry_model->$types;
    $data['keydesc'] = $this->common_model->get_keyword_description();

    $data['keywordUsed'] = $key;
    $data['isKeywordFiltering'] = false;
    $isKeywordValid = array_key_exists($key, $data['keydesc']);
    if ($key && $isKeywordValid) {
      $data['isKeywordFiltering'] = true;
      foreach($data['entries'] as $entry=>$value) {
        if (!in_array($key, $value[3])) {
          unset($data['entries'][$entry]);
        }
      }
    }
    $data['entryCount'] = sizeof($data['entries']);

    if ((!$key || $isKeywordValid)) {
      $this->load->view('header', $data);
      $this->load->view('pages/entries', $data);
      $this->load->view('footer', $data);
    } else {
      $this->load->view('header', $data);
      $this->load->view('errors/404', $data);
      $this->load->view('footer', $data);
    }
  }


  private function entryViewer($title,
                               $type, $types,
                               $page)
  {
    $data['title'] = ucfirst($page);
    $data['page']  = $page;
    $data['type']  = $type;
    $data['types']  = $types;
    $data['navId'] = $title;
    $data['pageWrapperDiv'] = 'article';
    $data['useSpyScroll'] = true;
    $data['hasSidebar']   = true;
    $data['navbar']       = $this->navbar_model->get_navbar();

    if (array_key_exists($page, $this->entry_model->$types)) {
      $data['entry'] = $this->entry_model->{$types}[$page];
      $data['title'] = strip_tags($data['entry'][0]);
    }

    $data['keydesc']      = $this->common_model->get_keyword_description();
    $data['sidebar_text'] = $this->globals->get_default_sidebar();
    $data['showComments'] = false;

    /* Show page */
    if ( file_exists('application/views/'.$types.'/'.$page.'.php')) {
      $this->load->view('header', $data);
      $this->load->view('article_date', $data);
      $this->load->view('common_article_util', $data);
      $this->load->view($types.'/'.$page, $data);
      $this->load->view('footer');
    }
    else{
      $data['navId'] = 'none';
      $this->load->view('header', $data);
      $this->load->view('errors/404', $data);
      $this->load->view('footer');
    }
  }
}
