<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('navbar_model');
    $this->load->model('article_model');
    $this->load->model('article_comments');
	  $this->load->helper(array('form', 'url'));
	  $this->load->library('form_validation');
    $this->load->helper('captcha');
    $this->load->model('globals');
  }

	public function view($page = 'none')
	{
    $data['title'] = ucfirst($page); // Capitalize the first letter
    $data['page']  = $page; // Capitalize the first letter
    $data['navId'] = 'Articles';
    $data['pageWrapperDiv'] = 'article';
    $data['useSpyScroll'] = true;
    $data['hasSidebar'] = true;
    $data['navbar']        = $this->navbar_model->get_navbar();
    $data['articles']      = $this->article_model->get_articles();;
    $data['comment_count'] = $this->article_comments->get_comment_count($page);
    $data['sidebar_text'] = $this->globals->get_default_sidebar();

    if (array_key_exists($page, $data['articles']))
      $data['title'] = $data['articles'][$page][0];

    /* Comment validation */
    $this->form_validation->set_rules('name', 'Name',
        'required|min_length[2]|max_length[29]|xss_clean');
    $this->form_validation->set_rules('email', 'Email',
        'trim|valid_email|xss_clean');
    $this->form_validation->set_rules('web', 'Web page',
        'trim|prep_url|xss_clean');
    $this->form_validation->set_rules('captcha', 'Captcha',
        'trim|required|xss_clean');
    $this->form_validation->set_rules('ctext', 'comment',
        'trim|required|min_length[8]|prep_for_form|xss_clean');
    $data['comment_form_ok'] = ($this->form_validation->run() == TRUE);
    $data['is_form_submitted'] = $this->_is_form_submitted();
    $data['captcha_status_ok'] = $this->_check_capthca();

    /* Submit comment */
    if($data['captcha_status_ok'] and $data['comment_form_ok']) {
      $this->article_comments->set_comment($page);
      redirect(current_url());
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
      $this->load->view('comments',$data);
      $this->load->view('footer');
    }

	}
  function _is_form_submitted()
  {
    return isset($_POST['name']);
  }

  function _check_capthca()
  {
    /* Verify captcha */
    $expiration = time()-7200; // Two hour limit
    $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

    // Then see if a captcha exists:
    $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
    $binds = array($this->input->post('captcha'),
                   $this->input->ip_address(),
                   $expiration);
    $query = $this->db->query($sql, $binds);
    $row = $query->row();

    /* Then clear this entry from the table as it has been "used". */
    /* UNTESTED */
    if($row->count > 0) {
      $sql = "DELETE FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
      $binds = array($this->input->post('captcha'),
                     $this->input->ip_address(),
                     $expiration);
      $query = $this->db->query($sql, $binds);
    }

    return ($row->count > 0);
  }
}
