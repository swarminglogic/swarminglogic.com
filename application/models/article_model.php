<?php
class Article_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
    $this->load->model('article_comments');
  }

  public function get_articles()
  {


    $articles['2013_06_cpp_setup'] =
       array('C++ Development Setup - No Time for Sword Fights',
             array('June','24','2013'),
             '<p>The result of a long series of iterations for minimizing compile time delay.</p>
<ul>
  <li>Automatic rebuilds of code and tests</li>
  <li>Global hotkey triggering of rebuilds and tests</li>
</ul>',
             true);

    // lookup comment count
    foreach($articles as $key=>$value) {
      array_push($articles[$key],
                 $this->article_comments->get_comment_count($key));
    }
    return $articles;
  }
}