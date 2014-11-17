<?php
$languages = array("Bash", "Python", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div id="article_page" class="twelve columns" data-target="#toc">
  <?php heading(2, 'Cross-compiling for windows (from linux) - Part 1', false); ?>

  <p>This article explains how to cross-compile a 64-bit windows application
      from linux.  This means that you don't need to have a windows build-machine,
      and you can use all linux based development tools. This is great for
      developers who feel more comfortable in linux.
  </p>
  <p>
    For some time, I knew that this was technically possible, but always
    assumed it would be either too difficult, or otherwise buggy and cumbersome.
    That I would eventually give up, and porting the compilation to windows,
    using a build machine running windows.
  </p>
  <p> After two days of working at this problem, I'm eager to explain and
    share my experience with it. I'll try to do so in two parts:</p>
  <p>
    <div class="prettyprint">
      <b><ccode>Part 1:</ccode></b>
      <ul>
        <li>Install the <ccode>mingw</ccode> cross-compilation tools.</li>
        <li>Compile <ccode>hello_world.exe</ccode>.</li>
        <li>A <ccode>SCons</ccode> based build system, that will be used in part 2.</li>
      </ul>
    </div>
  </p>

  <p>
    <div class="prettyprint">
      <b><ccode><a href="/article/2014_11_crosscompile2">Part 2:</a></ccode></b>
      <ul>
        <li>Cross-compile <ccode>SDL</ccode>. Cross-compile a program that links to,
              and initializes <ccode>SDL</ccode>.</li>
        <li>Repeat the process for similar libraries:<br/>
          <ul>
            <li><ccode>SDL_image</ccode>, together with <ccode>libjpg</ccode> and <ccode>libpng</ccode>.</li>
            <li><ccode>SDL_mixer</ccode>, with <ccode>libogg</ccode> and <ccode>libvorbis</ccode></li>
            <li><ccode>SDL_ttf</ccode>, with <ccode>libfreetype</ccode></li>
            <li><ccode>GLEW</ccode></li>
          </ul>
      </ul>
    </div>
  </p>

  <?php heading(4, '1. Getting <ccode>mingw</ccode>, the cross-compiler tools',
                '1. Getting <ccode>mingw</ccode>'); ?>
  <p>To cross-compile, I'll use the <ccode>mingw</ccode>-project, in
    partuclar, the 64 bit <ccode>gcc</ccode>-like build tools. On ubuntu, I installed these with
    <div class="prettyprint">
      <p>
        <?=shBegin('text', 'gutter:false;')?>
   $ sudo apt-get install g++-mingw-w64 mingw-w64-{tools,x86-64-dev}<?=shEnd()?>
      </p>
    </div>
  </p>

  <p>If you're relying on <ccode>c++11</ccode> features, you might want to verify that
    the <ccode>mingw-g++</ccode> compiler is version <ccode>4.7</ccode> or newer.
    To check out which version you have:
    <div class="prettyprint">
      <p>
        <?=shBegin('text', 'gutter:false;')?>
   $ x86_64-linux-gnu-g++ --version
   x86_64-linux-gnu-g++ (Ubuntu 4.8.2-19ubuntu1) 4.8.2
        <?=shEnd()?>
      </p>
    </div>
  </p>

  <?php heading(4, '2. Hello_World.exe', '2. Hello_World.exe'); ?>
  <p>In order to cross-compile a hello world program, all you need to do is:
    <div class="prettyprint">
      <p>
        <?=shBegin('text', 'gutter:false;')?>
    $ x86_64-w64-mingw32-g++ -o main.exe main.cpp --static
        <?=shEnd()?>
      </p>
    </div>
      It <a href="<?=imgsrc('hello_world.png')?>" data-title="hello world"
            data-lightbox="helloworld"> works fine</a>.
      The <ccode>--static</ccode> makes sure all necessary libraries get
      packed into the <ccode>exe</ccode>.
      Without it, you'll get <a href="<?=imgsrc('hello_world_nostatic.png')?>"
                                data-title="hello world, without --static"
                                data-lightbox="helloworld">
      an error message.
      </a>
  </p>

  <?php heading(4, '3. Simple <ccode>SCons</ccode> build system',
                '3. <ccode>SCons</ccode> build system'); ?>
  <p>Since a project usually consists of more than a <ccode>main.cpp</ccode>,
      you want an exensible build system. Preferably, one with the ability
      to easy switch between target platforms, and manage the differences between
      them.</p>
  <p>
      I'll be using <a href="http://www.scons.org/"><ccode>SCons</ccode></a>.
      It is based on <ccode>python</ccode>, and easy to understand and customize. In fact, I
      don't think you need to know anything about <ccode>SCons</ccode> or <ccode>python</ccode>
      to make sense of the scripts (which rarely is the case for <ccode>make</ccode> and <ccode>cmake</ccode>)
  </p>
  <p>
To follow along, grab a
    <a href="https://github.com/swarminglogic/scons-x-compile/tree/basic">copy of the repo</a>
 (and check out the "basic" branch)
    <div class="prettyprint">
      <p>
        <?=shBegin('bash', 'gutter:false;')?>
    $ git clone -b basic https://github.com/swarminglogic/scons-x-compile.git
        <?=shEnd()?>
      </p>
    </div>
  </p>

  <p class="pushdown"><ccode><b>The SCons "Makefile", aka SConsctruct</b></ccode><br/></p>
  <p>
    <div class="githubfile"
         lang="python"
         repo="scons-x-compile"
         branch="basic"
         file="SConstruct"></div>
  </p>
  <p>
    This sets it up so we can use <ccode>--win64</ccode> flag to specify that we
    want a windows build. With this enabled, <ccode>x86_64-w64-mingw32-g++</ccode> is
    used as the compiler, instead of <ccode>g++</ccode>.
  </p>

  <p>
Additionally, the <ccode>SConstruct</ccode> script asks <ccode>SCons</ccode> to
put all files created by the build in <ccode>./build/linux/</ccode> or <ccode>./build/windows/</ccode>. This
    keeps things tidy, and we also don't need to rebuild everything when alternating
    building for the two platforms.</p>

  <p>Lastly, is does whatherver the <ccode>SCons</ccode> build script <ccode>src/SConscript</ccode>
      (together with the environment we set up) tells it to do. But, before I show that, I want to show
      the two <ccode>python</ccode> scripts that will be used to differentiate the details
      between the target platforms:</p>

  <div class="six columns alpha">
    <small><b><ccode>Linux (utils/linux_build.py)</ccode></b></small><br/>
    <div class="githubfile"
         lang="python"
         repo="scons-x-compile"
         branch="basic"
         file="utils/linux_build.py"></div>
  </div>
  <div class="six columns omega">
    <small><b><ccode>Windows (utils/win_build.py)</ccode></b></small><br/>
    <div class="githubfile"
         lang="python"
         repo="scons-x-compile"
         branch="basic"
         file="utils/win_build.py"></div>
  </div>
  <div class="clear"></div>


  <p class="pushdown"><ccode><b>The SCons build script, src/SConscript</b></ccode><br/></p>
  <p>
    <div class="githubfile"
         lang="python"
         repo="scons-x-compile"
         branch="basic"
         file="src/SConscript"></div>
  </p>

  <p><ccode><b>Building with SCons</b></ccode></p>
  <p class="pushup">
        Using the <ccode>SCons</ccode> setup, we can build a
        linux executable (<ccode>./bin/main</ccode>) with:

    <div class="prettyprint">
      <p>
        <?=shBegin('bash', 'gutter:false;')?>
    $ scons
        <?=shEnd()?>
      </p>
    </div>

      To build a windows executable (<ccode>./bin/main.exe</ccode>):
    <div class="prettyprint">
      <p>
        <?=shBegin('bash', 'gutter:false;')?>
    $ scons --win64
        <?=shEnd()?>
      </p>
    </div>
      If you want to clean up, add <ccode>-c</ccode> at the end, e.g.: <ccode>scons --win64 -c</ccode>
  </p>

  <p><ccode><b><a href="/article/2014_11_crosscompile2">To be continued ... (part 2)</a></b></ccode></p>

  <div style="height:200px;" class="clear"></div>

</div>
<?php
global $toc;
$data['toc'] = $toc;
$this->load->view('sidebar', $data); ?>
