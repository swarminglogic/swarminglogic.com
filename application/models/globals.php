<?php
class Globals extends CI_Model {
	public function __construct()
	{
    parent::__construct();
  }

  // Add global functions, as needed.
  public function get_default_sidebar() {
      return '<div class="about"><h5>About the author</h5><p>
Roald Fernandez<br/>
Norwegian software developer<br/>
Thinks Alpacas are underrated</p></div>';
  }
}