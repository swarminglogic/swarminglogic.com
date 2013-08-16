<?php
class Article_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
    $this->load->model('article_comments');
  }

  public function get_keyword_description() {
    $keydesc['bash'] =
      "Uses scripts written for the bash unix terminal.";
    $keydesc['c++'] =
      "Topics relating to the C++ programming language";
    $keydesc['curl'] =
      "Uses unix tool 'curl' to retrieve web page sources";
    $keydesc['linux'] =
      "Article is more relevant for linux based users";
    $keydesc['math'] =
      "Uses/covers math-related topics";
    $keydesc['OEIS'] =
      "On-Line Encyclopedia of Integer Sequences";
    $keydesc['SCons'] =
      "Software construction tool (think: make)";
    $keydesc['visualization'] =
      "Covers some aspect of data visualization.";
    return $keydesc;
  }

  public function get_articles()
  {

    $articles['2013_08_oeis'] =
       array('Mapping the OEIS Database',
             array('Aug','15','2013'),
             '<p>A fun project on getting data from the On-Line Encyclopedia of
Integer Sequences (OEIS), and visualizing the results. In particular, the
relative frequency that each integer occurs in the database.</p>',
             array('linux','bash','curl','math', 'visualization', 'OEIS'));


    $articles['2013_06_cpp_setup'] =
       array('C++ Development Setup - No Time for Sword Fights',
             array('June','24','2013'),
             '<p>The result of a long series of iterations for minimizing
compile time delay.</p>
<ul>
  <li>Automatic rebuilds of code and tests</li>
  <li>Global hotkey triggering of rebuilds and tests</li>
</ul>',
             array('linux','bash','c++','SCons'));

    return $articles;
  }
}