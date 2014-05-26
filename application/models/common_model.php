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
    $keydesc['devlog'] =
      "Development log/diary. I.e. WIP on long term projects.";
    $keydesc['development'] =
      "Related to project management and development itself.";
    $keydesc['gamedev'] =
      "Game-development related.";
    $keydesc['GLSL'] =
      "OpenGL Shading Language";
    $keydesc['image processing'] =
      "Collection of command-line tools for image manipulation.";
    $keydesc['imagemagick'] =
      "Collection of command-line tools for image manipulation.";
    $keydesc['linux'] =
      "Article is more relevant for linux based users";
    $keydesc['math'] =
      "Uses/covers math-related topics";
    $keydesc['OEIS'] =
      "On-Line Encyclopedia of Integer Sequences";
    $keydesc['OpenCV'] =
      "Computer vision and image processing library";
    $keydesc['OpenGL'] =
      "Graphics programming using OpenGL API";
    $keydesc['SCons'] =
      "Software construction tool (think: make)";
    $keydesc['SDL2'] =
      "Simple Directmedia Library (version 2.0+). Cross platform
library for handling windows, sound,
input, etc.";
    $keydesc['unix'] =
      "Relies only on unix tools";
    $keydesc['visualization'] =
      "Covers some aspect of data visualization.";
    $keydesc['watermark'] =
      "On watermarks in images.";
    return $keydesc;
  }
}
