<?php
class Article_comments extends CI_Model {
	public function __construct()
	{
    parent::__construct();
    $this->load->database();
  }

  public function flag_comment($slug, $id)
  {
    /* TODO: */
    /* $query = $this->db->get_where('news', array('slug' => $slug)); */
    /* $query = $this->db->get_where('article_comments_ver2', */
    /*                               array('slug' => $slug)); */
    /* return $query->result_array(); */
  }

  public function get_comments($slug = FALSE)
  {
    $query = $this->db->get_where('article_comments_ver2',
                                  array('slug' => $slug));
    return $query->result_array();
  }

  public function get_base_comments($slug = FALSE)
  {
    $query = $this->db->get_where('article_comments_ver2',
                                  array('slug' => $slug,
                                        'parent_id' => -1));
    return $query->result_array();
  }

  public function get_child_comments($slug = FALSE,
                                     $parentId)
  {
    $query = $this->db->get_where('article_comments_ver2',
                                  array('slug' => $slug,
                                        'parent_id' => $parentId));
    return $query->result_array();
  }

  public function get_comment_count($slug = FALSE)
  {
    $query = $this->db->get_where('article_comments_ver2',
                                  array('slug' => $slug));
    return $query->num_rows();
  }

  public function check_parent_id($slug, $id)
  {
    $sql = "SELECT COUNT(*) AS count FROM article_comments_ver2 WHERE id = ? AND slug = ?";
    $binds = array($id,
                   $slug);
    $query = $this->db->query($sql, $binds);
    $row = $query->row();
    return ($row->count > 0);
  }

  public function set_comment($slug)
  {
    $parentId = $this->input->post('pid');
    if($parentId >= 0 and !$this->check_parent_id($slug, $parentId))
      $parentId = -1;

    $data = array('name'      => $this->input->post('name'),
                  'email'     => $this->input->post('email'),
                  'web'       => $this->input->post('web'),
                  'slug'      => $slug,
                  'text'      => $this->input->post('ctext'),
                  'parent_id' => $parentId,
                  'created_time' => date("Y-m-d H:i:s"),
                  'lastmod_time' => date("Y-m-d H:i:s"),
                  'ip_address' => ip2long($this->input->ip_address()),
                  'flagged' => 0,
                  'upvotes' => 0,
                  );
    return $this->db->insert('article_comments_ver2', $data);
  }

  /* Works out the time since the entry post,
     takes a an argument in unix time (seconds) */
  function time_since($original) {
    // array of time period chunks
    $chunks = array(array(60 * 60 * 24 * 365 , 'year'),
                    array(60 * 60 * 24 * 30 , 'month'),
                    array(60 * 60 * 24 * 7, 'week'),
                    array(60 * 60 * 24 , 'day'),
                    array(60 * 60 , 'hour'),
                    array(60 , 'minute'),
                    );

    $today = time(); /* Current unix time  */
    $since = $today - $original;

    // $j saves performing the count function each time around the loop
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {

      $seconds = $chunks[$i][0];
      $name = $chunks[$i][1];

      // finding the biggest chunk (if the chunk fits, break)
      if (($count = floor($since / $seconds)) != 0) {
        break;
      }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
  }
}

/*
  Need the following comment information:
  id, unique
  title, name, email, web, slug, text
  parentid (0 if no parent)
  date,time
  ip address (for allowing edit and remove).
  flagged_count
 */


/* CREATE TABLE `article_comments_ver2` ( */
/*   `id` int(11) NOT NULL AUTO_INCREMENT, */
/*   `name` varchar(128) NOT NULL, */
/*   `email` varchar(128), */
/*   `web` varchar(128), */
/*   `slug` varchar(128) NOT NULL, */
/*   `text` text NOT NULL, */
/*   `parent_id` int(11) NOT NULL, */
/*   `created_time` datetime, */
/*   `lastmod_time` datetime, */
/*   `ip_address` int unsigned NOT NULL, */
/*   `flagged` int, */
/*   `upvotes` int, */
/*   PRIMARY KEY (`id`) */
/* ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; */



/* CREATE TABLE `article_comments` ( */
/*   `id` int(11) NOT NULL AUTO_INCREMENT, */
/*   `title` varchar(128) NOT NULL, */
/*   `name` varchar(128) NOT NULL, */
/*   `email` varchar(128) NOT NULL, */
/*   `web` varchar(128) NOT NULL, */
/*   `slug` varchar(128) NOT NULL, */
/*   `text` text NOT NULL, */
/*   PRIMARY KEY (`id`) */
/* ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; */



/* CREATE TABLE IF NOT EXISTS `news` ( */
/* `id` int(11) NOT NULL AUTO_INCREMENT, */
/* `title` varchar(128) NOT NULL, */
/* `slug` varchar(128) NOT NULL, */
/* `text` text NOT NULL, */
/* PRIMARY KEY (`id`), */
/* KEY `slug` (`slug`) */
/*) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; */
