<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'Why I Love Linux (With Examples)','Top',true); ?>
    <img style="float: left; position: relative; top: -0.5em;"
         src="<?=imgsrc('nonflammable-shadow.png')?>" class="" alt="" />
    <blockquote>This article is not meant to incite a comparitive discussion of
    various operative systems. These are solely my thoughts and
    experiences.<br/><br/>I feel Linux helps my productivity, and that I'm
    not equally productive on other operating systems.
    If you feel otherwise is true for you, then that's great.</blockquote>
    <br/>
    <p>This article is structured in the following:
      <div class="offset-by-one">
        <table class="twos offset-by-one nudgeup">
          <tr>
            <td class="left">
              <b>1.</b><br/>
              <b>2.</b><br/>
              <b>3.</b>
            </td>
            <td class="right">
            Examples of scripts and how Linux simplifies tasks.<br/>
            Overview of useful knowledge and foundation for writing the scripts.<br/>
            Personal background and how I started using Linux
            </td>
          </tr>
        </table>
      </div>
    </p>
    <p>
    The reason for this seemingly illogical ordering is my preference for examples
    over lengthy explanations. If the examples are
    interesting, you either already understand how they work, or more motivated
    to read on. Lastly, and probably least interesting, is my personal
    background, which describes the transition to <ccode>linux</ccode>, and the effort and
    perserverance it required.</p>


    <?php heading(4, '1. Examples'); ?>
    <p>This section lists recent examples that simplified tasks. It doesn't do
    much effort in explaining why it works. For that, send me an email, or skip to
    the <a href="#bblocks">foundation overview</a>.</p>

    <?php heading(5, '1.1 Downloading Embedded YouTube Videos'); ?>
    <div class="prettyprint">
      <br/>
      <p ><ccode><b>What it does:</b></ccode><br/>
    Downloads the <ccode>HTML</ccode> source of a URL, extracts
    embedded youtube videos, and downloads them one by one at highest
    resolution using <a href="http://rg3.github.io/youtube-dl/"><ccode>youtube-dl</ccode></a>.
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("getyt.ff.png", "getyt.opt.gif") ?>
        </div>
      </p>

      <ccode><b>Script: getyt</b></ccode></p>
      <p>
        <pre class="brush: bash;">
#!/bin/bash
curl -s | grep -oP "https://www.youtube.com/embed/.{11}" | xargs youtube-dl
        </pre>
      </p>
      <p>

    </div>

    <?php heading(5, '1.2 Creating animated gif screencapture'); ?>
    <div class="prettyprint">
      <br/>
      <p><ccode><b>What it does:</b></ccode><br/>
    Accepts screen coordinates and generates an optimized <ccode>gif</ccode>.
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">All the animated gifs you'll find in this article.
        </div>
      </p>
      <p><ccode><b>Script: gifcapture</b></ccode></p>
      <p class="pushup">Too long (and ugly) to be included.
        <a href="https://gist.github.com/swarminglogic/5829070">Github gist of it here</a>.
      </p>

    </div>

    <?php heading(5, '1.3 Monitor files & scripts'); ?>
    <div class="prettyprint">
      <br/>

      <p><ccode><b>What it does:</b></ccode><br/>
        Monitor a list of files (or command output), and execute a command on change.
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("watchfile.ff.png", "watchfile.opt.gif") ?>
        </div>
      </p>

      <p><ccode><b>Script: watchfile</b></ccode></p>
      <p class="pushup">
        <a href="/jotting/2014_02_watchfile">Write-up.</a><br/>
        <a href="https://gist.github.com/swarminglogic/8963507">Github gist.</a><br/>
      </p>
      <p>There are several utilities that cover similar functionality. In particular
        <a href="http://manpages.ubuntu.com/manpages/hardy/man1/iwatch.1.html"><ccode>iwatch</ccode></a> and
        <a href="http://manpages.ubuntu.com/manpages/hardy/man1/inotifywatch.1.html"><ccode>inotifywatch</ccode></a>.
        I might have suffered from a small case of <?=wiki('Not_invented_here', 'NIH')?>, though I still prefer
        straight forwardness of <ccode>watchfile</ccode>.
      </p>
    </div>


    <?php heading(5, '1.4 User/Pass Management'); ?>
    <div class="prettyprint">
      <br/>

      <p><ccode><b>What it does:</b></ccode><br/>
        Manages passwords in a file owned by root. Allows partial match queries.
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("userpass.ff.png", "userpass.opt.gif") ?>
        </div>
      </p>

      <p><ccode><b>Script: userpass</b></ccode></p>
      <p class="pushup">
        <a href="https://gist.github.com/swarminglogic/8963507">Github gist.</a><br/>
      </p>
    </div>


    <?php heading(5, '1.5 Automatic User/Pass Entry'); ?>
    <div class="prettyprint">
      <br/>
      <p><ccode><b>What it does:</b></ccode><br/>
        Fills username and password fields, in any browser or application.
        Uses process information to determine best matching username/password pair.
        Triggered by a global hotkey that asks for sudo rights to read the password list.
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("enterpass.ff.png", "enterpass.opt.gif") ?>
        </div>
      </p>

      <p><ccode><b>Script: enterpass</b></ccode></p>
      <p class="pushup">
        <a href="https://gist.github.com/swarminglogic/def93e17d80bbbf858b2">Github gist.</a><br/>
      </p>
    </div>


    <?php heading(5, '1.6 Development Setup'); ?>
    <div class="prettyprint">
      <br/>
      <p><ccode><b>What it does:</b></ccode><br/>
        Creates a bunch of terminals, runs scripts in them and sets up <ccode>TTY</ccode> redirections.
      </p>

      <p><ccode><b>Demo:</b></ccode><br/>
        <div class="pushup">
          <?php gifimage("terminalsetup-tiny.ff.png", "terminalsetup-tiny.opt.gif") ?>
        </div>
      </p>

    </div>


    <?php heading(4, '2. Building Blocks', '', true, 'bblocks'); ?>
    <p>Before getting to the examples, this section lists various building blocks that are
    very useful parts of this collection of tools. Finding the right
    tools and languages for the job. Knowing what the possibilities are, etc.</p>

    <p>It's not sensible to cover everything in depth, nor do I think I'm
    particularly well suited to do so.</p>

    <div class="pushdown"><?php heading(5, '2.1 Basics'); ?></div>
    <h5><ccode>command-line</ccode></h5>
    <div class="prettyprint offset-by-one">
      <p>At the heart of everything in this article is the <?=wiki('Command-line_interface', 'command-line interface')?>.</p>
      <p> In <ccode>linux</ccode> there are <?=wiki('Unix_shell#Bourne_shell_compatible', 'many "shells" to chose from')?>, but most probably you are using <ccode><?=wiki('Bash_(Unix_shell)', 'bash')?></ccode>. In a regular desktop with a window manager, this runs inside a <?=wiki('Terminal_emulator', 'terminal emulator')?> (e.g. <ccode><?=wiki('Gnome-terminal', 'gnome-terminal')?></ccode>, <ccode><?=wiki('Terminator_(terminal_emulator)', 'terminator')?></ccode>, <ccode><?=wiki('Xterm', 'Xterm')?></ccode>, <?=wiki('List_of_terminal_emulators#Linux', 'etc')?>). In most of these terminal emulators, you can determine which shell is running behind the scenes by executing <wccode>echo $0</wccode>.
      </p>
      <p>
        <table class="twos"><tr>
          <td class="left middle"><a href="http://linuxcommand.org/learning_the_shell.php">
            <button type="button" class="btn btn-info ">Read on</button></a>
          </td>
          <td class="border right middle">A nice website on unix shells, with a lot of important <ccode>linux/unix</ccode> fundamentals. <em><strong>PS:</strong> Check out the book (it's free)!</em></td>
        </tr>
        </table>
      </p>
    </div>

    <h5><ccode>unix/linux commands</ccode></h5>
    <div class="prettyprint offset-by-one">
      <p>
      The <ccode>shell</ccode> is only as meaningful as the commands you execute in it.
      </p>
      <p>
        The most important ones are <b>(hover for description)</b>
      </p>
      <div class="offset-by-one">
        <div class="two columns alpha">
          <ccode class="tooltip top" pp="List content of a directory">ls</ccode><br/>
          <ccode class="tooltip top" pp="Move/rename files and directories">mv</ccode><br/>
          <ccode class="tooltip top" pp="List content of a file (w/navigation)">less</ccode><br/>
          <ccode class="tooltip top" pp="Show the n latter lines">tail</ccode><br/>
          <ccode class="tooltip top" pp="Path of executable">which</ccode><br/>
          <ccode class="tooltip top" pp="Change file owner">chmown</ccode><br/>
          <ccode class="tooltip top" pp="Create symbolic links">ln</ccode><br/>
          <ccode class="tooltip top" pp="Execute command with super-user privileges">sudo</ccode><br/>
          <ccode class="tooltip top" pp="Download file from network">wget</ccode><br/>
          <ccode class="tooltip top" pp="Show disk usage">df</ccode><br/>
          <ccode class="tooltip top" pp="Terminate processes">kill</ccode><br/>
          <ccode class="tooltip top" pp="Continue running a suspended process (CTRL+z) in the foreground">fg</ccode><br/>
          <ccode class="tooltip top" pp="Count lines, words and characters">wc</ccode><br/>

        </div>

        <div class="two columns">
          <ccode class="tooltip top" pp="Change current directory">cd</ccode><br/>
          <ccode class="tooltip top" pp="Delete files or directories">rm</ccode><br/>
          <ccode class="tooltip top" pp="Dump content of a file">cat</ccode><br/>
          <ccode class="tooltip top" pp="Search for files or directories">find</ccode><br/>
          <ccode class="tooltip top" pp="Manual page of a command">man</ccode><br/>
          <ccode class="tooltip top" pp="Output input">echo</ccode><br/>
          <ccode class="tooltip top" pp="Specify runtime priority to command">nice</ccode><br/>
          <ccode class="tooltip top" pp="Output source of file from network">curl</ccode><br/>
          <ccode class="tooltip top" pp="List processes (typically used as 'ps aux')">ps</ccode><br/>
          <ccode class="tooltip top" pp="Terminate processes by name">pkill</ccode><br/>
          <ccode class="tooltip top" pp="Store or extract compressed files">tar</ccode><br/>
          <ccode class="tooltip top" pp="Continue running a suspended process (CTRL+z) in the background">bg</ccode><br/>
          <ccode class="tooltip top" pp="Text transformation tool">sed</ccode><br/>
        </div>

        <div class="two columns">
          <ccode class="tooltip top" pp="List full path of current directory">pwd</ccode><br/>
          <ccode class="tooltip top" pp="Create directories">mkdir</ccode><br/>
          <ccode class="tooltip top" pp="Filter input">grep</ccode><br/>
          <ccode class="tooltip top" pp="Describe a file">file</ccode><br/>
          <ccode class="tooltip top" pp="Change file permissions">chmod</ccode><br/>
          <ccode class="tooltip top" pp="Show date/time">date</ccode><br/>
          <ccode class="tooltip top" pp="Clears terminal">clear</ccode><br/>
          <ccode class="tooltip top" pp="Find files from an indexed database
                 of all files (update with `updatedb`)">locate</ccode><br/>
          <ccode class="tooltip top" pp="Interactive processes viewer">top</ccode><br/>
          <ccode class="tooltip top" pp="[debian/ubuntu] Install/delete software from package repository">apt-get</ccode><br/>
          <ccode class="tooltip top" pp="Update timestamp or create empty file">touch</ccode><br/>
          <ccode class="tooltip top" pp="Extract basename from path">basename</ccode><br/>

        </div>

        <div class="two columns omega">
          <ccode class="tooltip top" pp="Copy files and directories">cp</ccode><br/>
          <ccode class="tooltip top" pp="Remove empty directory">rmdir</ccode><br/>
          <ccode class="tooltip top" pp="Show the n first lines">head</ccode><br/>
          <ccode class="tooltip top" pp="Describe a command">type</ccode><br/>
          <ccode class="tooltip top" pp="Change file owner">chmown</ccode><br/>
          <ccode class="tooltip top" pp="Answers existential questions">whoami</ccode><br/>
          <ccode class="tooltip top" pp="Establish shortcut to a command">alias</ccode><br/>
          <ccode class="tooltip top" pp="Establish secure shell to remote computer">ssh</ccode><br/>
          <ccode class="tooltip top" pp="Same as `top`, but much better, though it might not be
                 included in your distro by default.">htop</ccode><br/>
          <ccode class="tooltip top" pp="[debian/ubuntu] Search packages by files (`apt-file search`)
                 or list files in package (`apt-file list`).
                 Must be updated with `apt-file update`">apt-file</ccode><br/>
          <ccode class="tooltip top" pp="List running processes in shell">jobs</ccode><br/>
          <ccode class="tooltip top" pp="Remove basename from path">dirname</ccode><br/>
        </div>
      </div>
      <div class="clear"></div>
      </p>
      <p>
        <table class="twos"><tr>
          <td class="left middle"><a href="http://linuxcommand.org/learning_the_shell.php">
            <button type="button" class="btn btn-info">Read on</button></a>
          </td>
          <td class="right middle border">The same link as above, in case you skipped it. Did I mention the free book? It's excellent.
          </td>
        </tr>
        </table>
      </p>
    </div>


    <h5><ccode>unix/linux fundamentals</ccode></h5>
    <p>
      Beyond the commands mentioned so far are a few concepts worth noting:
    </p>
    <div class="prettyprint nudgemargin">
      <div class="alpha three columns nudgedown"><ccode>File I/O <br/>redirection</ccode></div>
      <div class="omega seven columns">
        <p class="nudgedown">Redirecting output to files.
          <pre class="brush: bash;">
$ date > tmp.txt
$ cat tmp.txt
Mon Aug 11 15:11:37 CEST 2014
          </pre>
        </p>

        <p class="nudgedown">Or input from files:
          <pre class="brush: bash;">
$ tail -c 30 < alice.txt
hole party swam to the
shore.
          </pre>
        </p>

        <p class="nudgedown">Or both:
          <pre class="brush: bash;">
$ tail -c 30 < alice.txt > end.txt
$ cat end.txt
hole party swam to the
shore.
          </pre>
        </p><br/>
      </div>

      <!-- ------------------ -->
      <hr class="soft"/>
      <div class="alpha three columns"><ccode>Piping</ccode></div>
      <div class="omega seven columns">
        <p>
      Output of one command passed as input to another. Kinda like the above
        "file I/O redirection", except that this goes from one command to
        another, is often parallelized, and terminates early when possible.
        </p>
        <p>
Listing all files within a directory can be done with:
          <div class="pushup">
            <pre class="brush: bash; gutter: false;">
find . -type f
            </pre></div>
        </p>
        <p>
      Counting number of lines in an output can be done with:
          <div class="pushup">
            <pre class="brush: bash; gutter: false;">
wc -l
            </pre></div>
        </p>
        <p>
      Combining the two lets you count number of files within a directory:
          <div class="pushup">
            <pre class="brush: bash; gutter: false;">
find . -type f | wc -l
            </pre></div>
        </p>
      </div>

      <!-- ------------------ -->
      <hr class="soft"/>
      <div class="alpha three columns"><ccode>Linux Directories</ccode></div>
      <div class="omega seven columns">
        <p>
          What is typically in <ccode>/bin/</ccode>,
          <ccode>/boot/</ccode>,
          <ccode>/dev/</ccode>,
          <ccode>/etc/</ccode>,
          <ccode>/home/</ccode>,
          <ccode>/lib/</ccode>,
          <ccode>/mnt/</ccode>,
          <ccode>/proc/</ccode>,
          <ccode>/tmp/</ccode>, etc.
        </p>
      </div>

      <!-- ------------------ -->
      <hr class="soft"/>
      <div class="alpha three columns"><ccode>Symbolic links</ccode></div>
      <div class="omega seven columns">
        <p>
          How files can exist only as links to other files, and why this is useful.
        </p>
      </div>

      <!-- ------------------ -->
      <hr class="soft"/>
      <div class="alpha three columns"><ccode>Environment<br/>variables<br/>&nbsp;</ccode></div>
      <div class="omega seven columns">
        <p>
          In particular <ccode>PATH</ccode> and <ccode>LD_LIBRARY_PATH</ccode>.
        </p>
      </div>


      <!-- ------------------ -->
      <hr class="soft"/>
      <div class="alpha three columns"><ccode>File permissions</div>
        <div class="omega seven columns">
          <p>
          How file and directory permissions work. Commands
            <ccode>chmod</ccode>,
            <ccode>chown</ccode>,
            <ccode>chgrp</ccode>,
            <ccode>su</ccode>,
            <ccode>sudo</ccode>,
            etc.
          </p>
        </div>

        <!-- ------------------ -->
        <hr class="soft"/>
        <div class="offset-by-one">
          <table class="twos"><tr>
            <td class="left middle"><a href="http://linuxcommand.org/tlcl.php">
              <button type="button" class="btn btn-info">Read on</button></a>
            </td>
            <td class="right middle border">Everything mentioned so far is covered in
              the book by William Shotts, which he has made available for free.
            </td>
          </tr>
          </table>
          <p></p>
        </div>

        <div class="clear"></div>
    </div>


    <?php heading(5, '2.1 Scripting Languages'); ?>
    <p>Bash, python, perl, ruby, octave, c/c++, makefile, tex, texinfo</p>
    <p>Right tool for the job, then bash to bind them all.</p>

    <?php heading(5, '2.2 Unix/Linux Fundamentals'); ?>
    <p>Symbolic links. Terminal (bash language), bashrc, alias
    man, less, mkdir, ps, htop, rm, rmdir, locate, echo, pwd, TTYs. Piping. Sudo, Permissions (chmod), Groups, Redirection. , env, PATH, Shebang</p>

    System info gathering:
    <p>w, who, /proc/, fd, whoami, ps aux, top, htop</p>
    <p>

http://mally.stanford.edu/~sr/computing/basic-unix.html
http://homepage.smc.edu/morgan_david/cs40/fundamentalcommands.htm

 ls - list directory contents (like MS-DOS dir)
 cat - send file content to screen  (like MS-DOS type)
 cd - change current directory (like MS-DOS cd)
 chmod - change file permissions
 cp - copy files and directories (like MS-DOS copy)
 echo - write characters to the screen
 find - find files (slow but fresh)
 locate - find files (faster but stale)
 grep - print lines matching a pattern
 less - file filter for viewing
 man - display on-line manual pages for individual commands
 mkdir - make directories  (like MS-DOS md)
 mv - rename/move files  (like MS-DOS ren or move)
 ps - give a process status report
 pwd - print name of the current, working directory
 rm - remove files and directories  (like MS-DOS del)
 rmdir - remove empty directories  (like MS-DOS rd)
    </p>

    <?php heading(5, '2.3 Linux/Unix Commands'); ?>
cat /var/tmp/tts/flite-1.4-release/doc/alice | tr -cs A-Za-z '\n' | tr A-Z a-z | sort | uniq -c | sort -rn

    <p>cd, ls, find, grep, sed, tr, tar, curl, ln, xargs, wc,
    sort, uniq, printf, kill, basename, dirname, readlink, awk</p>

    <?php heading(5, '2.4 Text Editor'); ?>
    <p>Emacs, vi, sublime text</p>

    <?php heading(5, '2.5 Additional Important Tools'); ?>
    <p>Git/Hg, ImageMagick suite, vox, youtube-dl, wget, curl, ffmpeg</p>

    <?php heading(5, '2.6 C/C++ related'); ?>
    <p>c++filt, readelf</p>


    <?php heading(4,
                  '3. Background', //  (<a href="#bblocks">feel free to skip this</a>)
                  '3. Background',
                  true); ?>
    <p>
    I grew up playing computer games in the mid-90s and on. The operating system
    of choice at that time for games was <ccode>Windows</ccode>, hands down. Naturally, it also
    became my system of choice for everything else.
    </p>
    <p>
    Later, when attending university, some courses required <ccode>linux</ccode> interaction.
    This was often simple enough that one could get by with a few terminal commands,
    editing files with <ccode>gedit</ccode> or <ccode>nano</ccode> (<ccode>emacs</ccode>
    and <ccode>vi</ccode> seeming completely unusable), compiling with <ccode>gcc</ccode>,
    modifying a simple (and at the time, cryptic) <ccode>Makefile</ccode>, etc.
    </p>
    <p>
    I still stuck to <ccode>windows</ccode> all the way until I studied a year in the US,
    and took a computer security course that relied heavily on everyone being familiar
    with <ccode>linux</ccode>.

    I went for <ccode>Fedora</ccode> and spent countless
    frustrating hours fighting with basic things like getting wifi and graphics drivers to
    work properly.
    </p>

    <p>After the course ended, I happily switched back to <ccode>windows</ccode>,
    and relished in the sweet comfort of Visual Studio for <ccode>C/C++</ccode>
    programming, and <ccode>notepad++</ccode> for everything else.
    </p>

    <p>Fast forward a few years, I decided to give <ccode>linux</ccode> another
    go in preparation for a software development position that primarily used
      <ccode>Centos</ccode> machines. This time going for <ccode>ubuntu</ccode>,
    and, possibly due to the matured linux driver support in the three years passed
    since my previous struggles, it was much smoother sailing.
    </p>

    <p>
    Bereft of Visual Studio, I set out to learn <ccode>emacs</ccode> for
    writing <ccode>C++</ccode> code. <ccode>SCons</ccode> for compiling
      <ccode>C/C++</ccode> projects.

    I found the <ccode>bash</ccode> scripting languge repulsive, ugly and unintuitive,
    but still used it occasionally for small scripts to simplify command
    line tasks. As time passed, slowly learning new <ccode>unix/linux</ccode> tools here
    and there, and gained a better understanding of how linux works.
    </p>

    <p>
    The transition was a long journey, riddled with frustration. A few sessions
    with <ccode>grub</ccode> or twiddling with <ccode>xorg.conf</ccode> will
    tempt any sane person to throw in the towel.
    </p>

    <p>
    In not doing so, every small thing I learned became a piece of an incredibly powerful and versatile
    toolbox, as most of the unix tools follow the <ccode>unix</ccode> philosophy.
      <a href="http://en.wikipedia.org/wiki/Unix_philosophy#Doug_McIlroy_on_Unix_programming">
      As the quote goes:
      </a>
      <blockquote>This is the Unix philosophy: Write programs that do one thing
      and do it well. Write programs to work together. Write programs to handle
      text streams, because that is a universal interface.</blockquote>

    </p>

    <p>
    This is in stark contrast to how it was for me in <ccode>windows</ccode>. Here,
    almost any task I wanted to solve had to be accomplished by finding a finished
    software, monolithic and specific for solving the task at hand. For example,
    I recall needing a program for batch renaming files (<ccode>magic file renamer</ccode>),
    and another program for batch editing images (<ccode>XnView</ccode>).
    </p>

    <p>
      To some extent, <ccode>windows</ccode> might have cought up to this with
      <?=wiki('Powershell', 'PowerShell')?>. If you are an experienced <ccode>PowerShell</ccode> user,
      skip to the examples, and consider how you would implement those scripts. If you
      see obvious solitions to all of them, I'd be happy to hear from you.
    </p>

    <div style="height:200px;" class="clear"></div>


  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebars/sb_jotting', $data); ?>
</div>
