<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'watchfile: Execute a command when something changes.', false); ?>
    <p>
      This jotting covers a utility I've been gradually extending, which is handy for solving
      a common automization problem of <wccode>"as soon as something happens, do something else"</wccode>.
    </p>
    <p>
      This can be things like:
      <ul>
        <li>.. interactively execute python/perl/bash/octave/etc scripts while coding.</li>
        <li>.. automatically convert assets to a usable format when they change.</li>
        <li>.. automatically recompile a project when a source file changes.</li>
        <li>.. monitor a website and alert you when it has changed.</li>
      </ul>
    </p>

    <p>
      <div>
        <b><ccode>Demo:</ccode></b><br/>
        <?php gifimage("watchfile.ff.png", "watchfile.opt.gif") ?>
      </div>
    </p>

    <p>The script is provided in its entirety <a href="#script">below</a>, which
I'll leave to the especially interested to go through (70% of it is just parsing
parameters).</p>

    <p>You can check it out as a <a href="https://gist.github.com/swarminglogic/8963507">
github gist here.</a></p>

    <div class="pushdown">
      <?php heading(4, '1. Examples'); ?>
    </div>
    <?php heading(5, 'Example 1: With python, perl, bash, octave'); ?>
    <p>
      Whenever I write scripts in an of these languages, I don't have the syntax
      at my fingertips, so I stumble a bit.
    </p>

    <p> Assuming the file is an executable and has a
      <ccode><?=wiki('Shebang_(Unix)','shabang')?></ccode>,
      here is how you could monitor and automatically execute such a file using the
      <ccode>watchfile</ccode> utility:
      <ccode class="fullwidth prettyprint">
        watchfile foo.py
      </ccode>
    </p>
    <p>
      If <ccode>foo.py</ccode> isn't an executable:
      <ccode class="fullwidth prettyprint">
        watchfile foo.py python foo.py
      </ccode>
    </p>
    <p>
      The default is checking the modified timestamp. However, you can request
      to look at the content itself using the <ccode>--check-content</ccode> option,
      which is fine for smaller files:
      <ccode class="fullwidth prettyprint">
        watchfile --check-content foo.py
      </ccode>

    </p>


    <?php heading(5, 'Example 2: Preparing assets'); ?>
    <p>Say you are monitoring a Wavefront OBJ file, and want to convert it to
    some binary representation using a utility called <ccode>obj2cobj</ccode>, you could do:
      <ccode class="fullwidth prettyprint">
        watchfile foo.obj obj2cobj foo.obj
      </ccode>
    </p>


    <?php heading(5, 'Example 3: Compiling and executing code (e.g <ccode>c++</ccode>)',
                  true, 'ex3'); ?>
    <p>
      Monitoring a file and executing a different command allows for automatic recompiling.
      <ccode class="fullwidth prettyprint">
        watchfile main.cpp g++ -Wall main.cpp -o main
      </ccode>
    </p>
    <p>
      Automatic execution when compilation succeeds (note that you have to escape
      the ampersands):
      <ccode class="fullwidth prettyprint">
        watchfile main.cpp g++ -Wall main.cpp -o main \&\& ./main
      </ccode>
    </p>
    <p>
      Monitoring multiple files, using the <ccode>-i</ccode> flag, to start
      listing files to monitor, and the <ccode>-e</ccode> flag to start listing
      the command to execute:

      <pre class="prettyprint pushup" style="color: #80AAAA;">
watchfile -i main.cpp widget.h widget.cpp \
          -e g++ -Wall main.cpp -o main</pre>
    </p>

    <p>
      Monitoring multiple files, and building with make
      <ccode class="fullwidth prettyprint">
        watchfile -i main.cpp widget.cpp widget.h -e make
      </ccode>
    </p>
    <p>
      Finding and monitoring all source files, and building with make <ccode>(</ccode>note that
      this doesn't handle files created or deleted after monitoring starts, see
      <a href="#ex5">example 5</a> on how to do this<ccode>)</ccode>

      <ccode class="fullwidth prettyprint">
        watchfile -i `find .  -name "*.cpp" -or -name "*.h"` -e make
      </ccode>
    </p>

    <?php heading(5, 'Example 4: Monitoring a website'); ?>
    <p>The <ccode>watchfile</ccode> utility also supports monitoring arbitrary
      commands, and monitors change in the output as if it were a file. This is
      done using the <ccode>-s</ccode> flag, followed by a single
      parameter which is the command to monitor (using quotes, if need be).</p>

    <p>Using <ccode>curl</ccode> and <ccode>grep</ccode>, you can easily extract
      relevant parts of a webpage. By monitoring this output, you can set up an
      alert for when the website changes.</p>

    <p>For instance, say you want to monitor the forecast for northern lights in Europe.
Here is how to get the Aurora Borealis intensity level forecast, from the
      <a href="http://www.gi.alaska.edu/AuroraForecast/Europe">Geophysical Institute at
       UoAF</a>:

      <pre class="prettyprint pushup" style="color: #80AAAA;">
curl -s http://www.gi.alaska.edu/AuroraForecast/Europe/ | \
    grep -oP 'Europe_\d+' | grep -oP '\d+$'</pre>
    </p>

    <p>Let's use the <ccode>watchfile</ccode> to check this value once every 15 minutes (900 seconds),
    and show a pop-up on the screen when it changes, using the <ccode>notify-send</ccode>
    utility.</p>
    <pre class="prettyprint pushup" style="color: #80AAAA;">
watchfile -d 900 \
    -s "curl -s http://www.gi.alaska.edu/AuroraForecast/Europe/ | \
        grep -oP 'Europe_\d+' | grep -oP '\d+$' \
    -e notify-send "Northern lights intensity changed"</pre>
    </p>
    <p>
      Let's now modify it to store the intensity value to a temporary file, and then
 display this value in the pop-up:
      <pre class="prettyprint pushup" style="color: #80AAAA;">
watchfile -d 900 \
    -s "curl -s http://www.gi.alaska.edu/AuroraForecast/Europe/ | \
        grep -oP 'Europe_\d+' | grep -oP '\d+$' | tee /tmp/auroravalue" \
    -e cat /tmp/auroravalue | xargs notify-send \
       "Northern lights intensity changed to: "</pre>
    </p>

    <?php heading(5, 'Example 5: Monitor dynamic list of files', true, 'ex5'); ?>
    <p>In <a href="#ex3">example 3</a>, I mentioned that if you list files to
    monitor using the <ccode>-i</ccode> flag, this list is static cannot change
    dynamically while the <ccode>watchfile</ccode> script is running.</p>

    <p>To circumvent this, we use the <ccode>-s</ccode> flag to pass a command
      that lists the timestamps of all the relevant files.

      <pre class="prettyprint pushup" style="color: #80AAAA;">
watchfile -s \
    "find . -name '*.cpp' -or -name '*.h' | xargs stat -c %Y" \
     -e make \&\& ./main</pre>
    </p>


    <p>
     Alternatively, to output the content of all relevant files (similar to the
      <ccode>--check-content</ccode> option):
      <pre class="prettyprint pushup" style="color: #80AAAA;">
watchfile -s \
    "find . -name '*.cpp' -or -name '*.h' | xargs cat" \
     -e make \&\& ./main</pre>
    </p>
    <!--  .and the same would apply to perl, python, bash, etc -->

    <?php heading(4, '2. The watchfile script', true, 'script'); ?>
    <div class="externgist" lang="bash" gist="8963507" file="watchfile.sh"></div>

    <div style="height:200px;" class="clear"></div>


  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebar', $data); ?>
</div>
