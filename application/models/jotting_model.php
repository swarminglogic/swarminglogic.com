<?php
class Jotting_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
  }


  public function get_jottings()
  {
    $jottings['2013_10_gamedev01'] =
      array('DevLog 1: Game Engine Progress, One Month In.',
            array('&nbsp;Oct','23','2013'),
            "
<p>Firsty monthly development log. A write-up of the experiences and progress
made with learning <ccode>OpenGL</ccode> and <ccode>SDL</ccode>, and putting
together the first pieces of a game engine.
</p>",
            array('OpenGL', 'GLSL', 'SDL2', 'devlog', 'gamedev'));

/*     $jottings['2013_08_watermark'] = */
/*       array('Automatic Visible Watermarking of Images', */
/*             array('Aug','17','2013'), */
/*             " */
/* <p>Quick look at automatically adding subtle time-stamped watermarks.</br> */
/* I'll be using <code>imagemagick</code> with a tablespoon of <code>bash</code> scripting.</p>", */
/*             array('linux', 'bash','automization', */
/*                   'imagemagick','watermark')); */

/*     $jottings['2013_08_css_color_transform'] = */
/*     $jottings['2013_08_gifscreencapture'] = */

/*     $jottings['YYYY_DD_blob'] = */
/*        array('Title', */
/*              array('m','d','y'), */
/*              '<p>Description</p>', */
/*              array('keyword1','keyword2','etc')); */

    return $jottings;
  }

}