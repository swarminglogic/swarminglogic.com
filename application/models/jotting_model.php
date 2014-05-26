<?php
class Jotting_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
  }


  public function get_jottings()
  {
    $jottings['2014_05_lcov'] =
      array('Line coverage report using <ccode>gcov</ccode>/<wccode>lcov</wccode>',
            array('May','24','2014'),
            "<p>A bit specific to my SCons setup and unit-test system, but hopefully still
 general enough to be useful for someone else. I'll walk through the whole
 process of setting it up and cleaning it up.  </p>",
            array('c++', 'bash', 'SCons', 'development', 'linux'));


    $jottings['2014_04_screenrecordalt'] =
      array('Picture-in-picture timelapse of dual monitors (single X display).',
            array('Apr','8','2014'),
            "<p>How do a screen capture of two monitors within a single
X display, and overlay one screen as a picture-in-picture thumbnail.
</p>",
            array('bash', 'unix', 'linux'));

    $jottings['2014_02_watchfile'] =
      array('watchfile: Execute a command whenever something changes.',
            array('&nbsp;Feb','13','2014'),
            "<p>I'd like to share a script I've made, which I keep finding uses
for all the time. In essense, it performs the task of <wccode>\"whenever
 this changes, do this\"</wccode>. It was initially created for monitoring
files, but later extended for arbitrary commands. This means it can be
used to monitor websites, or what have you.</p>",
            array('bash', 'unix', 'linux', 'automization'));

    $jottings['2014_01_screenrecord'] =
      array('Picture-in-picture timelapse of two separate X displays.',
            array('&nbsp;Jan','29','2014'),
            "<p>How do a screen capture of two separate X displays, and overlay
 one screen as a picture-in-picture thumbnail.
 This is all nicely automated in a script.</p>",
            array('bash', 'unix', 'linux'));


    $jottings['2014_01_nicekill'] =
      array('nicekill: Killing unix processes nicely.',
            array('&nbsp;Jan','28','2014'),
            "
<p>How to ask nicely for a program to terminate.<br/>
If you usually do <ccode>pkill -9 foo</ccode>,
then this is for you.</p>",
            array('bash', 'unix', 'linux'));


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