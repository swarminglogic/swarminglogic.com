<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'Why I Love Linux (Through Examples)','Top',true); ?>
    <img style="float: left; position: relative; top: -0.5em;"
         src="<?=imgsrc('nonflammable-shadow.png')?>" class="" alt="" />
    <blockquote>This article is not meant to incite a comparative discussion of
    various operative systems. These are solely my thoughts and
    experiences.<br/><br/>I feel Linux helps my productivity, and that I'm
    not equally productive on other operating systems.
    If you feel otherwise is true for you, then that's great.</blockquote>
    <br/>
    <p>
    I started using <ccode>Linux</ccode> three years ago. As newbie as they get,
    and totally clueless. Now, that hasn't changed much, but since then,
    I have written some scripts and use trivial
    everyday one-liners that ease a lot of tedious manual labor.</p>

    <p>This article
    lists some of these scripts and one-liners, which in themselves, hopefully
    illustrate why I have become dependent on <ccode>Linux</ccode>.

    No attempt is made to explain the examples. For that, I refer you to a
    book by William Shotts:</p>
    <p>
      <table class="twos"><tr>
        <td class="left middle"><a href="http://linuxcommand.org/tlcl.php">
          <button type="button" class="btn btn-info ">Get the Book</button></a>
        </td>
        <td class="border right middle">This free and awesome book is
      what I wish I had read early on, instead of going by my cursory hack-it-together
      approach. It covers most of what is used in the examples, but also much
      more.</td>
      </tr>
      </table>
    </p>

    <div style="height:30px;" class="clear"></div>
    <?php heading(4, 'Example 1: Downloading Embedded YouTube Videos', 'Example 1: getyt'); ?>
    <div class="prettyprint">
      <p ><ccode><b>What it does:</b></ccode><br/>
    Downloads the <ccode>HTML</ccode> source of a URL, extracts
    embedded youtube videos, and downloads them one by one at highest
    resolution using <a href="http://rg3.github.io/youtube-dl/"><ccode>youtube-dl</ccode></a>.
      </p>

      <ccode><b>Script: getyt</b></ccode></p>
      <p>
        <pre class="brush: bash;">
#!/bin/bash
curl -s | grep -oP "https://www.youtube.com/embed/.{11}" | xargs youtube-dl
        </pre>
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("getyt.ff.png", "getyt.opt.gif") ?>
        </div>
      </p>

    </div>


    <div style="height:30px;" class="clear"></div>
    <?php heading(4, 'Example 2: Creating animated gif screencapture', 'Example 2: gifcapture'); ?>
    <div class="prettyprint">
      <p><ccode><b>What it does:</b></ccode><br/>
    Accepts screen coordinates and generates an optimized <ccode>gif</ccode>.
      </p>

      <p><ccode><b>Script: gifcapture</b></ccode></p>
      <p class="pushup">Too long (and ugly) to be included.
        <a href="https://gist.github.com/swarminglogic/5829070">Github gist of it here</a>.
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">All the animated gifs you'll find in this article.
        </div>
      </p>

    </div>


    <div style="height:30px;" class="clear"></div>
    <?php heading(4, 'Example 3: Monitor files & scripts', 'Example 3: watchfile'); ?>
    <div class="prettyprint">
      <p><ccode><b>What it does:</b></ccode><br/>
        Monitor a list of files (or command output), and execute a command on change.
      </p>
      <p>There are several utilities that cover similar functionality. In particular
        <a href="http://manpages.ubuntu.com/manpages/hardy/man1/iwatch.1.html">
          <ccode>iwatch</ccode></a> and
          <a href="http://manpages.ubuntu.com/manpages/hardy/man1/inotifywatch.1.html">
            <ccode>inotifywatch</ccode></a>.
        I might have suffered from a small case of <?=wiki('Not_invented_here', 'NIH')?>,
        though I still prefer straight forwardness of <ccode>watchfile</ccode>.
      </p>

      <p><ccode><b>Script: watchfile</b></ccode></p>
      <p class="pushup">
        <a href="/jotting/2014_02_watchfile">Write-up.</a><br/>
        <a href="https://gist.github.com/swarminglogic/8963507">Github gist.</a><br/>
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("watchfile.ff.png", "watchfile.opt.gif") ?>
        </div>
      </p>
    </div>



    <div style="height:30px;" class="clear"></div>
    <?php heading(4, 'Example 4a: User/Pass Management', 'Example 4a: userpass'); ?>
    <div class="prettyprint">


      <p><ccode><b>What it does:</b></ccode><br/>
        Manages passwords in a file owned by root. Allows partial match queries.
      </p>
      <p><ccode><b>Script: userpass</b></ccode></p>
      <p class="pushup">
        <a href="https://gist.github.com/swarminglogic/40922ce92e49aae3b2ca">Github gist.</a><br/>
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("userpass.ff.png", "userpass.opt.gif") ?>
        </div>
        <hr class="soft"/>
        <div class="pushup">
          <pre class="brush: bash; gutter:false;">
 # Add an entry to the password database
$ sudo userpass -a foosite -u userbar -p hunter2 -m Foo

# Query the newly made entry
$ sudo userpass foosite
key:      foosite
username: userbar
password: hunter2
meta:     Foo

# Query by partially matching keyword
$ sudo userpass oos
key:      foosite
username: userbar
password: hunter2
meta:     Foo

# Find entry by text containing meta data:
$ sudo userpass --script-mode -m "We Got Foo! Login"
foosite

# Use script-mode to get password matching entry
$ sudo userpass --script-mode foosite -p
hunter2

# Use script-mode to get username matching entry
$ sudo userpass --script-mode foosite -u
userbar
          </pre>
        </div>
      </p>
    </div>

    <div style="height:30px;" class="clear"></div>
    <?php heading(4, 'Example 4b: Automatic User/Pass Entry', 'Example 4b: enterpass'); ?>
    <div class="prettyprint">

      <p><ccode><b>What it does:</b></ccode><br/>
        Fills username and password fields, in any browser or application.
        Uses process information to determine best matching username/password pair.
        Triggered by a global hotkey that asks for sudo rights to read the password list.
      </p>

      <p><ccode><b>Script: enterpass</b></ccode></p>
      <p class="pushup">
        <a href="https://gist.github.com/swarminglogic/def93e17d80bbbf858b2">Github gist.</a><br/>
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("enterpass.ff.png", "enterpass.opt.gif") ?>
        </div>
      </p>
    </div>

    <div style="height:30px;" class="clear"></div>
    <?php heading(4, 'Example 5: Development Setup', 'Example 5: terminalsetup'); ?>
    <div class="prettyprint">

      <p><ccode><b>What it does:</b></ccode><br/>
        Creates a bunch of terminals, runs scripts in them and sets up <ccode>TTY</ccode> redirections.
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("terminalsetup-tiny.ff.png", "terminalsetup-tiny.opt.gif") ?>
          <small>The script creates terminals with specific sizes and adjusts font size, and placement.
          </small>
        </div>
      </p>

    </div>



    <div style="height:30px;" class="clear"></div>
    <?php heading(4, 'Example 6: Dual Monitor Timelapse Recording', 'Example 6: recordscreen'); ?>
    <div class="prettyprint">
      <p><ccode><b>What it does:</b></ccode><br/>
        Takes a screen capture every <ccode>N</ccode> seconds of a dual monitor setup. Converts
        the inactive monitor into a picture-in-picture thumbnail.
      </p>

      <p><ccode><b>Script: enterpass</b></ccode></p>
      <p class="pushup">
        <a href="/jotting/2014_04_screenrecordalt">Write-up.</a><br/>
        <a href="https://gist.github.com/swarminglogic/8692569#file-recordscreenalt-sh">Github gist.</a><br/>
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="youtubevid pushup">
          <iframe src="//www.youtube.com/embed/BWmjgwkdgkc"
                  frameborder="0" allowfullscreen></iframe>
        </div>
      </p>
    </div>


    <div style="height:30px;" class="clear"></div>
    <?php heading(4, 'Example 7: Tic/Toc Timer Pair', 'Example 7: ttic/ttoc'); ?>
    <div class="prettyprint">
      <p><ccode><b>What it does:</b></ccode><br/>
        I missed the <ccode>Matlab</ccode>/<ccode>Octave</ccode> way of timing
      things with a tic/toc pair... so, I made them.</p>

      <p><ccode><b>Script: ttic & ttoc</b></ccode></p>
      <p class="pushup">
        <a href="https://gist.github.com/swarminglogic/87adb0bd0850d76ba09f">Github gist.</a><br/>
      </p>


      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <pre class="brush: bash; gutter:false;">
 # Simple use
$ ttic && sleep 0.4 && ttoc
0.404

# Using ID to avoid conflict w/existing tic/toc
$ ttic foo && sleep 0.5 && ttoc foo
0.504

# Using randomly assigned ID
$ id=$(ttic --unique) && sleep 0.6 && ttoc $id
0.604
          </pre>
        </div>
      </p>

    </div>


    <div style="height:30px;" class="clear"></div>
    <?php heading(4,
                  'My Background (Before Linux)'); ?>
    <p>
    I grew up playing computer games in the mid-90s and on. The operating system
    of choice at that time for games was <ccode>Windows</ccode>, hands down. Naturally, it also
    became my system of choice for everything else.
    </p>
    <p>
    Later, when attending university, some courses required <ccode>Linux</ccode> interaction.
    This was often simple enough that one could get by with a few terminal commands,
    editing files with <ccode>gedit</ccode> or <ccode>nano</ccode> (<ccode>emacs</ccode>
    and <ccode>vi</ccode> seeming completely unusable), compiling with <ccode>gcc</ccode>,
    modifying a simple (and at the time, cryptic) <ccode>Makefile</ccode>, etc.
    </p>
    <p>
    I still stuck to <ccode>Windows</ccode> all the way until I studied a year in the US,
    and took a computer security course that relied heavily on everyone being familiar
    with <ccode>Linux</ccode>.

    I went for <ccode>Fedora</ccode> and spent countless
    frustrating hours fighting with basic things like getting wifi and graphics drivers to
    work properly.
    </p>

    <p>After the course ended, I happily switched back to <ccode>Windows</ccode>,
    and relished in the sweet comfort of Visual Studio for <ccode>C/C++</ccode>
    programming, and <ccode>notepad++</ccode> for everything else.
    </p>

    <p>Fast forward a few years, I decided to give <ccode>Linux</ccode> another
    go in preparation for a software development position that primarily used
      <ccode>CentOS</ccode> machines. This time going for <ccode>Ubuntu</ccode>,
    and, possibly due to the matured Linux driver support in the three years passed
    since my previous struggles, it was much smoother sailing.
    </p>

    <p>
    Bereft of Visual Studio, I set out to learn <ccode>emacs</ccode> for
    writing <ccode>C++</ccode> code. <ccode>SCons</ccode> for compiling
      <ccode>C/C++</ccode> projects.

    I found the <ccode>bash</ccode> scripting language repulsive, ugly and unintuitive,
    but still used it occasionally for small scripts to simplify command
    line tasks. As time passed, slowly learning new <ccode>Unix/Linux</ccode> tools here
    and there, and gained a better understanding of how <ccode>Linux</ccode> works.
    </p>

    <p>
    The transition was a long journey, riddled with frustration. A few sessions
    with <ccode>grub</ccode> or twiddling with <ccode>xorg.conf</ccode> will
    tempt any sane person to throw in the towel.
    </p>

    <p>
    In not doing so, every small thing I learned became a piece of an incredibly powerful and versatile
    toolbox, as most of the <ccode>Unix</ccode> tools follow the unix philosophy.
      <a href="http://en.wikipedia.org/wiki/Unix_philosophy#Doug_McIlroy_on_Unix_programming">
      As the quote goes:
      </a>
      <blockquote>This is the Unix philosophy: Write programs that do one thing
      and do it well. Write programs to work together. Write programs to handle
      text streams, because that is a universal interface.</blockquote>

    </p>

    <p>
    This is in stark contrast to how it was for me in <ccode>Windows</ccode>. Here,
    almost any task I wanted to solve had to be accomplished by finding a
    finished software. Monolithic, and specific for solving the task at
    hand. For example, I recall needing a program for batch renaming files. I
    searched for such a utility, and found one (<a href="http://www.finebytes.com/mfr/">
      <ccode>magic file renamer</ccode></a>).
    Some other time, I needed to batch edit images. I searched again, and found a
    another tool (<a href="http://www.xnview.com/en/"><ccode>XnView</ccode></a>).
    </p>

    <p>
      To some extent, <ccode>Windows</ccode> might have caught up to this with
      <?=wiki('Powershell', 'PowerShell')?>. If you are an experienced <ccode>PowerShell</ccode> user,
      and find obvious solutions to all my examples, I'd be happy to hear from
      you. In fairness, I'd be happy to hear from you anyways.
    </p>

    <div style="height:200px;" class="clear"></div>


  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebar', $data); ?>
</div>
