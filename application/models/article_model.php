<?php
class Article_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
    $this->load->model('article_comments');
  }

  public function get_articles()
  {

    $articles['2013_08_oeis'] =
       array('Mapping the OEIS Database',
             array('Aug','15','2013'),
             '<p>A fun project on getting data from the On-Line Encyclopedia of
Integer Sequences (OEIS), and visualizing the results. In particular, the
relative frequency that each integer occurs in the database.</p>',
             array('linux','bash','curl','math', 'visualization', 'oeis'),
             true);


    $articles['2013_06_cpp_setup'] =
       array('C++ Development Setup - No Time for Sword Fights',
             array('June','24','2013'),
             '<p>The result of a long series of iterations for minimizing
compile time delay.</p>
<ul>
  <li>Automatic rebuilds of code and tests</li>
  <li>Global hotkey triggering of rebuilds and tests</li>
</ul>',
             array('linux','bash','c++','scons','build'),
             true);


    // lookup comment count
    foreach($articles as $key=>$value) {
      array_push($articles[$key],
                 $this->article_comments->get_comment_count($key));
    }
    return $articles;
  }
}