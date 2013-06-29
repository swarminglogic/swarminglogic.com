<?php
class Article_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
    $this->load->model('article_comments');
  }

  public function get_articles()
  {
    $articles['tmp'] =
       array('Title',
             array('Jan','1','1970'),
             '<p>Summary</p>',
             true);

    // lookup comment count
    foreach($articles as $key=>$value) {
      array_push($articles[$key],
                 $this->article_comments->get_comment_count($key));
    }
    return $articles;
  }
}