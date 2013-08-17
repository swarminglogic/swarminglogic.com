<?php
class Jotting_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
  }


  public function get_jottings()
  {
    $jottings['2013_08_watermark'] =
      array('Automatic Visible Watermarking of Images',
            array('Aug','17','2013'),
            "
<p>Quick look at automatically adding subtle time-stamped watermarks.</br>
I'll be using <code>imagemagick</code> with a tablespoon of <code>bash</code> scripting.</p>",
            array('linux', 'bash','automization',
                  'imagemagick','watermark'));

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