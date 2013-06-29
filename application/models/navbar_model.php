<?php
class Navbar_model extends CI_Model {
	public function __construct()
	{
  }

  public function get_navbar()
  {
    $nav['Contact'] = "contact";
    $nav['Articles'] = "articles";
    return $nav;
  }
}