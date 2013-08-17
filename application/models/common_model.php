<?php
class Common_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
  }


  public function get_keyword_description() {
    $keydesc['automization'] =
      "Topics related to doing things slowly once, to avoid spending time doing it again later.";
    $keydesc['bash'] =
      "Uses scripts written for the bash unix terminal.";
    $keydesc['c++'] =
      "Topics relating to the C++ programming language";
    $keydesc['curl'] =
      "Uses unix tool 'curl' to retrieve web page sources";
    $keydesc['imagemagick'] =
      "Collection of command-line tools for image manipulation.";
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
    $keydesc['watermark'] =
      "On watermarks in images.";
    return $keydesc;
  }
}
