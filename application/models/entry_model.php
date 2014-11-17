<?php
class Entry_model extends CI_Model {
	public function __construct()
	{
    parent::__construct();
    /* $this->load->model('article_comments'); */
  }

  public $articles =
  array('2014_11_crosscompile2' =>
        array('Cross-compiling for windows (from linux) - Part 2',
              array('Nov','12','2014'),
              '<p>This article covers cross-compiling (from scracth) all the
 necessary libraries for an SDL2 based OpenGL application. In particular:
 <ccode>SDL2</ccode>, <wccode>SDL2_image (w/png, jpeg)</wccode>,
<wccode>SDL_mixer (w/ogg)</wccode>, <ccode>SDL_ttf</ccode>,
<ccode>GLEW</ccode></p>',
              array('c++', 'development', 'gamedev', 'OpenGL',
                    'SCons', 'linux', 'SDL2')),

        '2014_11_crosscompile' =>
        array('Cross-compiling for windows (from linux) - Part 1',
              array('Nov','11','2014'),
              '<p>This article talks about how to cross-compile a 64bit windows
 application from linux, using <ccode>mingw</ccode>. This first part covers the
 necessary tools, and shows a minimal <ccode>SCons</ccode> based build system
for cross-compiling <ccode>Hello_World.exe</ccode>.</p>',
              array('c++', 'development', 'gamedev', 'OpenGL', 'SCons',
                    'linux')),

        '2014_08_whylinux' =>
        array('Why I Love Linux (Through Examples)',
              array('Aug','21','2014'), "
<p>My personal relation to linux, and how it suits me as a power
user, and makes workflow optimizations possible. Illustrated purely through
examples of scripts and everyday one-liners.</p>",
              array('linux', 'unix', 'bash', 'automization',
                    'development')),

        '2013_11_skittles' =>
        array('Image Processing - Detecting Skittles in Images',
              array('Dec','1','2013'),
              '<p>A quick project on detecting colored skittles on dissaturated
 backgrounds. Skittle positions, radii and hues are estimated.
 Skittles are then clustered by hue. The extracted data is then visualized by
 rendering objects in a virtual scene.</p>',
              array('image processing', 'OpenCV')),

        '2013_08_oeis' =>
        array('Mapping the OEIS Database',
              array('Aug','15','2013'),
              '<p>A fun project on getting data from the On-Line Encyclopedia of
Integer Sequences (OEIS), and visualizing the results. In particular, the
relative frequency that each integer occurs in the database.</p>',
              array('linux','bash','curl','math', 'visualization', 'OEIS')),

        '2013_10_gamedev01' =>
        array('DevLog 1: Game Engine Progress, One Month In.',
              array('Oct','23','2013'),
              "
<p>Firsty monthly development log. A write-up of the experiences and progress
made with learning <ccode>OpenGL</ccode> and <ccode>SDL</ccode>, and putting
together the first pieces of a game engine.
</p>",
              array('OpenGL', 'GLSL', 'SDL2', 'devlog', 'gamedev'),
              array('deferred-all-600px_wm.png')),

        '2013_06_cpp_setup' =>
        array('C++ Development Setup - No Time for Sword Fights',
              array('June','24','2013'),
              '<p>The result of a long series of iterations for minimizing
compile time delay.</p>
<ul>
  <li>Automatic rebuilds of code and tests</li>
  <li>Global hotkey triggering of rebuilds and tests</li>
</ul>',
              array('linux','bash','c++','SCons'))
        );


  public $jottings =
  array('2014_09_watermark' =>
        array('<ccode>subtlemark</ccode>: Watermarking Images',
              array('Sep','3','2014'),"
 <p>A quick look at how to automate the process of adding subtle watermarks to images.</p>",
              array('bash', 'automization', 'linux')),

        '2014_05_lcov' =>
        array('Line coverage report using
<ccode>gcov</ccode>/<wccode>lcov</wccode>',
              array('May','24','2014'),"
 <p>A bit specific to my SCons setup and unit-test system, but hopefully still
 general enough to be useful for someone else. I'll walk through the whole
 process of setting it up and cleaning it up.  </p>",
              array('c++', 'bash', 'SCons', 'development', 'linux')),

        '2014_04_screenrecordalt' =>
        array('Picture-in-picture timelapse of dual monitors (single X display).',
              array('Apr','8','2014'),
              "<p>How do a screen capture of two monitors within a single
X display, and overlay one screen as a picture-in-picture thumbnail.
</p>",
              array('bash', 'unix', 'linux')),

        '2014_02_watchfile' =>
        array('<ccode>watchfile</ccode>: Execute a command whenever something changes.',
              array('Feb','13','2014'),
              "<p>I'd like to share a script I've made, which I keep finding uses
for all the time. In essense, it performs the task of <wccode>\"whenever
 this changes, do this\"</wccode>. It was initially created for monitoring
files, but later extended for arbitrary commands. This means it can be
used to monitor websites, or what have you.</p>",
              array('bash', 'unix', 'linux', 'automization')),

        '2014_01_screenrecord' =>
        array('Picture-in-picture timelapse of two separate X displays.',
              array('Jan','29','2014'),
              "<p>How do a screen capture of two separate X displays, and overlay
 one screen as a picture-in-picture thumbnail.
 This is all nicely automated in a script.</p>",
              array('bash', 'unix', 'linux'))


        //         ,'2014_01_nicekill' =>
        //         array('<ccode>nicekill</ccode>: Killing unix processes nicely.',
        //               array('Jan','28','2014'),
        //               "
        // <p>How to ask nicely for a program to terminate.<br/>
        // If you usually do <ccode>pkill -9 foo</ccode>,
        // then this is for you.</p>",
        //               array('bash', 'unix', 'linux'))
        );

}
