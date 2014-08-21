<?php
class Article_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
    $this->load->model('article_comments');
  }


  public function get_articles()
  {
    $articles['2014_08_whylinux'] =
      array('Why I Love Linux (Through Examples)',
            array('Aug','21','2014'),
            "<p>My personal relation to linux, and how it suits me as a power
user, and makes workflow optimizations possible. Illustrated purely through examples of scripts
and everyday one-liners.</p>",
            array('linux', 'unix', 'bash', 'automization', 'development'));

    $articles['2013_11_skittles'] =
       array('Image Processing - Detecting Skittles in Images',
             array('Dec','&nbsp;&nbsp;1','2013'),
             '<p>A quick project on detecting colored skittles on dissaturated
 backgrounds. Skittle positions, radii and hues are estimated.
 Skittles are then clustered by hue. The extracted data is then visualized by
 rendering objects in a virtual scene.</p>',
             array('image processing', 'OpenCV'));



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