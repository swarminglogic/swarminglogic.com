<?php
$languages = array("Bash", "Python", "Plain", "JScript");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">

    <?php heading(2, 'C++ Development Setup - No Time for Sword Fights','',false); ?>
    <?php heading(4, '1. Overview'); ?>
    <p>I don't like waiting for compilations to finish, or for unit tests to
run. In the ideal case, output from compiling and running tests should be
available whenever I decide to look at it. Focus shouldn't have to leave the
code editor.</p>

    <p>After a series of iterations, I've created a setup that is not in the
way. A setup that automatically rebuilds when code is changed, and executes
tests that have been affected. A setup where I can use global hotkeys to issue a
full rebuild, launch the main program, or run all tests.</p>

    <p>This is what the end result looks like.
      <?php gifimage("cppsetup.ff.png", "cppsetup.opt.nl.gif") ?>
    </p>
    <p style="text-align: right;"><em>Note that focus never leaves the editor!</em>
    </p>
    <p>I'll go through each of the necessary pieces of the puzzle, and put it
together along the way.
    </p>


    <?php heading(4, '2. Automatic Rebuild'); ?>

    <p>This section describes a script that issues a rebuild whenever a source
    file changes.</p>

    <p>
      <?php gifimage("autobuild.ff.png", "autobuild.opt.gif") ?>
    </p>

    <p>If you understand the following snippet
      <div class="prettyprint">
        <pre class="brush: bash;">
find ./src ./SConstruct \
 -name "[!\.]*.cpp" -or \
 -name "[!\.]*.h"   -or \
 -name "[!\.]*.tpp" -or \
 -name "SConscript*" -or \
 -name "SConstruct" \
 | xargs stat -c %y \
 | md5sum
        </pre>
      </div>
      <table class="prettyprint lines">
        <tr><td><b>Line 1-6:</b></td><td>Finds all relevant projects files.</td></tr>
        <tr><td><b>Line 7:</b></td>  <td>Finds the 'last modified' timestamp for all files.</td></tr>
        <tr><td><b>Line 8:</b></td>  <td>Reduces the above to a single md5 hash.</td></tr>
      </table>
    ... you might want to skip ahead to the <a href="#recompile">final script</a>.
    </p>

    <?php heading(5, '2.1 Find all relevant project files', '', false, 'find'); ?>
    <p>Using the <code>find</code>-utility, one can list all files with
    particular extension with <br/> <code class="clean">$ find . -name "*.cpp"</code><br/>
    </p>
    <p>
      To find both <code>.cpp</code> and <code>.h</code> files:<br/>
      <code class="clean">$ find . -name "*.cpp" -or -name "*.h"</code><br/>
    </p>

    <p>
      To avoid finding hidden files:<br/>
      <code class="clean">$ find . -name "[!\.]*.cpp" -or -name "[!\.]*.h"</code><br/>
    </p>

    <p>
      To do the same but limit results to <code>./src</code> directory:<br/>
      <code class="clean">$ find ./src -name "[!\.]*.cpp" -or -name "[!\.]*.h"</code><br/>
    </p>

    <p>
      <b>Putting it together:</b> Find all non-hidden files in <code>./src</code> directory with
      <code>.cpp .h .tpp</code> extensions, any <code>SConscript*</code> files, and also
      the <code>SConstruct</code> file in root directory:
      <pre class="block soft">$ find ./src ./SConstruct \
 -name "[!\.]*.cpp" -or \
 -name "[!\.]*.h"   -or \
 -name "[!\.]*.tpp" -or \
 -name "SConscript*" -or \
 -name "SConstruct"</pre>
    </p>

    <?php heading(5, '2.2 Determine \'last modified\'-timestamp', '', false, 'timestamp'); ?>

    <p>Unix command <code>stat</code> shows detailed timestamp information of a file.
      <pre>$ stat SConstruct
  File: `SConstruct'
  Size: 778       	Blocks: 24         IO Block: 4096   regular file
Device: 14h/20d	Inode: 1208177     Links: 1
Access: (0664/-rw-rw-r--)  Uid: ( 1000/   okami)   Gid: ( 1000/   okami)
Access: 2013-06-21 09:08:13.198346996 +0200
Modify: 2013-06-21 09:08:13.030346998 +0200
Change: 2013-06-21 09:08:13.030346998 +0200
 Birth: -</pre>
    </p>

    <p>
      To only list modification time:<br/>
      <code class="clean">$ stat SConstruct -c %y</code><br/>
      <code class="clean">2013-06-21 09:08:13.030346998 +0200</code>
    </p>

    <p>
      <b>Putting it together:</b> Determine the last modified timestamp of all files found by <code>find</code>
      <pre class="block soft">$ find ./src ./SConstruct \
 -name "[!\.]*.cpp" -or \
 -name "[!\.]*.h"   -or \
 -name "[!\.]*.tpp" -or \
 -name "SConscript*" -or \
 -name "SConstruct" | xargs stat -c %y</pre>
    </p>

    <?php heading(5, '2.3 Use md5sum to simplify timestamp information', '', false, 'md5sum'); ?>
    <p><a href="http://en.wikipedia.org/wiki/Md5">md5</a> is a hashing algorithm
    that reduces any chunk of information to a 128-bit value. To compute the md5
    hash, use <code>md5sum</code>.
    </p>
    <p>
      Computing the md5 hash of <code>myfile.txt:</code><br/>
      <code class="clean">$ md5sum myfile.txt</code><br/>
      <code class="clean">09f7e02f1290be211da707a266f153b3  myfile.txt</code><br/>
    </p>
    <p>
      Or pipe the content to md5:<br/>
      <code class="clean">$ cat myfile.txt | md5sum</code><br/>
      <code class="clean">09f7e02f1290be211da707a266f153b3  -</code><br/>
    </p>
    <p>
      <b>Putting it together:</b> By piping all the timestamps above, we reduce
    the information to a single value. If any timestamp changes, the value
    changes.
      <pre class="block soft">$ find ./src ./SConstruct \
 -name "[!\.]*.cpp" -or \
 -name "[!\.]*.h"   -or \
 -name "[!\.]*.tpp" -or \
 -name "SConscript*" -or \
 -name "SConstruct" | xargs stat -c %y | md5sum</pre>
    </p>

    <?php heading(5, '2.4 Automatic Rebuild Script', '', false, 'recompile'); ?>
    <p>
      <div class="externgist" lang="bash" gist="5623057" file="autobuild.sh")">
      </div>
    </p>

    <?php heading(4, '3. Automatic Test Execution'); ?>

    <p>I compile each test suite into its own executable, and put each
    executable in a particular directory. Automatic test-execution becomes as
    simple as monitoring a directory, and executing tests if they change.  This
    is what it looks like:</p>

    <p>
      <?php gifimage("testexec2.ff.png", "testexec2.opt.gif") ?>
    </p>

    <p>This python-script does just that. It monitors executables in a
    directory, and executes any that change.</p>

    <div class="externgist" lang="python" gist="5619183" file="autodirexec.py")">
    </div>

    <?php heading(4, '4. Redirecting Ouput to Specific TTY', '4. Redirecting to TTY'); ?>

    <p>Taking advantage of terminals, and redirecting output to a specific TTY
is central to the setup. It allows us to set up global hotkeys that run scripts
that send the output to a particular terminal. <em><a href="http://www.linusakesson.net/programming/tty/">The
TTY demystified</a></em> is a good article on TTYs if you want to read more
about it, but from a practical point of view, this is all you need to know:</p>
    <p>
      <ul><li>Each of your terminal sessions has a TTY-number.</li>
        <li>You can determine this number with the <code>tty</code> command.</li>
        <li>You can send output to a particular TTY by redirecting it to
          <code>/dev/pts/TTY</code>.</li>
      </ul>
    </p>
    <p>
      <?php gifimage("tty.ff.png", "tty.opt.nl.gif") ?>
    </p>

    <?php heading(5, 'Global Hotkeys', '', false, 'redir'); ?>
    <p>Setting up global hotkeys is a distro-specific issue, so it won't be
    covered. The global hotkey should trigger a script that determines the
    correct project path and redirects output to a particular tty.</p>

    <p>I use three scripts for the following:
      <table class="prettyprint lines">
        <tr><td><b>recompile:</b></td><td>Does a full build from scratch</td></tr>
        <tr><td><b>run-main:</b></td><td>Runs the executable created by the compilation.</td></tr>
        <tr><td><b>run-tests:</b></td><td>Runs all the tests.</td></tr>
      </table>
    </p>

    <p>I suggest writing additional scripts to help the 'compile', 'run-main' and 'run-tests' script:
      <table class="prettyprint lines">
        <tr><td><b>marktty:</b></td><td>Writes your current <code>TTY</code> to a file, e.g. ~/scripts/ttynumber.</td></tr>
        <tr><td><b>markttytest:</b></td><td>Writes your current <code>TTY</code> to a file, e.g ~/scripts/ttynumber_test.</td></tr>
        <tr><td><b>markproj:</b></td><td>Writes the <code>`pwd`</code> to a file, e.g. ~/scripts/project</td></tr>
      </table>
    </p>


    <?php heading(4, '5. Extra - tmuxinator'); ?>
    <p>Creating two terminal windows, starting automatic building, starting
    automatic test execution, registering each<code> tty</code> to receive
    global triggered scripts... it takes time. Roughly half a minute.</p>

    <p>It would be nice to have a way to automate this as well. There are several tools that can help you.
      One such is <a href="https://github.com/aziz/tmuxinator"><code>tmuxinator</code></a>. Here is the setup script I use.</p>

    <div class="prettyprint">
      <pre class="brush: plain;">
project_name: CppCoding
project_root: "`cdpval`"
rvm: 2.0.0
pre:
tabs:
  - mytab:
      layout: main-horizontal
      panes:
        - marktty && autobuild ./bin/main
        - markttytest && autodirexec ./bin/tests</pre>
    </div>

    <p>
      <table class="prettyprint lines">
        <tr><td><b>Line &nbsp;2:</b></td><td><code>cdpval</code> is a script that
      outputs the project directory.</td></tr>
        <tr><td><b>Line &nbsp;9:</b></td>  <td>Top pane for autobuild, set to execute <code>./bin/main</code>.
          <br/>Uses <code>marktty</code> to receive global build and run.</td></tr>

          <tr><td><b>Line 10:</b></td>  <td>Bottom pane for autodirexec, set to
      monitor test directory.<br/> Uses <code>markttytest</code> to receive
      global test run.</td></tr>
      </table>
    </p>

    <p>In action:
    <?php gifimage("tmuxinator2.ff.png", "tmuxinator2.opt.gif") ?>
    </p>

    <?php heading(4, '6. Conclusion'); ?>
    <p>This concludes my first article. If you would like clarification on any
    particular aspect, let me know. I'm happy to get any tips, or suggestions as
    to how to improve it, both the article and setup.</p>

    <p>Using this setup has been very useful to me, and hopefully this might
    give some inspiration to set up something similar, or devise something
    better. Maybe you already have, and would like to share.</p>

  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebars/sb_article', $data); ?>
</div>