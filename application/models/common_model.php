<?php
class Common_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
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
}
