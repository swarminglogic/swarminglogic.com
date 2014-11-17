<?php
$languages = array("Bash", "Python", "Cpp", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>
<div id="article_page" class="twelve columns" data-target="#toc">
  <?php heading(2, 'Cross-compiling for windows (from Linux) - Part 2', false); ?>

  <p>
      In <a href="/article/2014_11_crosscompile">part 1</a>, I covered a basic
      cross-compilation setup, that let us use any of the libraries that come
      as part of the <ccode>mingw-w64-x86-64-dev</ccode> package:
  </p>
  <p>
    <div class="prettyprint">
      <b><ccode><a href="/article/2014_11_crosscompile">Part 1:</a></ccode></b>
      <ul>
        <li>Install the <ccode>mingw</ccode> cross-compilation tools.</li>
        <li>Compile <ccode>hello_world.exe</ccode>.</li>
        <li>A <ccode>SCons</ccode> based build system, that will be used in part 2.</li>
      </ul>
    </div>
  </p>
  <p>In this part two, I'll cover how to:
    <div class="prettyprint">
      <b><ccode>Part 2:</ccode></b>
      <ul>
        <li>Cross-compile <ccode>SDL2</ccode>. Cross-compile a program that links to,
              and initializes <ccode>SDL2</ccode>.</li>
        <li>Repeat the process for similar libraries:<br/>
          <ul>
            <li><ccode>SDL2_image</ccode>, together with <ccode>libjpg</ccode> and <ccode>libpng</ccode>.</li>
            <li><ccode>SDL2_mixer</ccode>, with <ccode>libogg</ccode> and <ccode>libvorbis</ccode></li>
            <li><ccode>SDL2_ttf</ccode>, with <ccode>libfreetype</ccode></li>
            <li><ccode>GLEW</ccode></li>
          </ul>
      </ul>
    </div>
  </p>

  <p><ccode><b>A quick word about cross-compiled libraries</b></ccode>
  </p>

  <p>
      Libraries used when cross-compiling also need to be cross-compiled.
  </p>
  <p>For example, you probably use <ccode>&lt;cmath&gt;</ccode> functions on
      Linux, and link to the shared <ccode>libm.so</ccode> or static
    <ccode>libm.a</ccode> library file. For cross-compilation, you want
      to link to a static cross-compiled <ccode>libm.a</ccode>
      (shared libraries for cross-compilations
      are a pita, so I'll avoid it altogether).
  </p>
  <p>How do we get these static cross-compiled libraries?
      Lucky for us, the <ccode>mingw-w64-x86-64-dev</ccode> package provides
      many fundamental libraries.
  </p>
  <p>
     On my system, these are located in <ccode>/usr/x86_64-w64-mingw32/lib/</ccode>.
     If you find that <ccode>libm.a</ccode> is located there, then you can link with
     it without any fuss. When building your project, it is not necessary to specify this
      directory, as
    <ccode>x86_64-w64-mingw32-g++</ccode> will look for libraries here by default.
  </p>
  <p>
    The important thing to note is that all the static libraries you link to
    will become part of the <ccode>.exe</ccode>, which ends up being
    a large file.
  </p>




  <?php heading(4, '1. Building a cross-platform <ccode>SDL2</ccode> library',
                '1. Cross-platform <ccode>SDL2</ccode>'); ?>
  <p>As mentioned above, the <ccode>mingw-w64-x86-64-dev</ccode> package
    provides many fundamental libraries.  This is great, but for all other
    libraries, you typically need to find these elsewhere, or build them
    yourself.
     I'm only interested in the latter.
     First off,
    <ccode><a href="https://www.libsdl.org/">Simple DirectMedia Library (SDL)</a></ccode>.
  </p>

  <p><ccode>SDL2</ccode> can be built using <ccode>autotools</ccode>, i.e.
    <ccode>configure && make && make install</ccode>.
  </p>
  <p>
    <ccode>Autotools</ccode>
      has very good support for cross-compiling, which makes this easy.
      Typically, we just need to tell <ccode>configure</ccode>
      that we want to use the <ccode>x86_64-w64-mingw32</ccode> toolchain.
  </p>

  <p>I'll be placing all cross-compiled libraries we build in:
    <div class="prettyprint pushup">
      <?=shBegin('text', 'gutter:false;')?>
    /usr/local/cross-tools/x86_64-w64-mingw32/
      <?=shEnd()?>
    </div>
  </p>

  <?php heading(5, '1.1 Building a cross-platform <ccode>SDL2</ccode> library',
                '1.1 Cross-compiling <ccode>SDL2</ccode>'); ?>


  <p>In the <ccode>SDL2</ccode> source repository,
    we'll create a directory <ccode>build-win64</ccode>, and from
    there call <ccode>configure</ccode> with the cross-compilation
    configuration set. Pay attention to features the <ccode>configure</ccode> output
    might warn you about. In my case, it all looked good, so I went
    ahead with a <ccode>make install</ccode>.
  </p>

  <p>From the <ccode>SDL2</ccode> directory:</p>
  <div class="prettyprint pushup">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# create build-win64 directory and cd to it
mkdir build-win64 && cd $_

# Set up some common variables
PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
# We make CC variable available to child processes
export CC="$TOOLSET-gcc -static-libgcc"

# Configure build
../configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$PREFIX/$TOOLSET
# building and installing
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>

  <p>You should now find <ccode>libSDL2.a</ccode> and <ccode>libSDL2main.a</ccode>
    in the <ccode>$PREFIX/$TOOLSET/lib</ccode> directory you used.</p>

  <?php heading(5, '1.2 <ccode>Hello_SDL.exe</ccode>'); ?>
  <p>In <a href="/articles/2014_11_crosscompile">part 1</a>, I described a
    <ccode>SCons</ccode> based build setup for cross-compilation.
      We want to use this to build a simple program that uses <ccode>SDL2</ccode>.
  </p>
  <p>
      To check out the <ccode>SCons</ccode> setup, and this program, use (note the <ccode>hello-sdl</ccode> branch):
    <div  class="prettyprint">
      <?=shBegin('bash','gutter:false;')?>
 $ git clone -b hello-sdl https://github.com/swarminglogic/scons-x-compile.git
      <?=shEnd()?>
    </div>
  </p>

  <p>
      Here is a simple program that initializes <ccode>SDL2</ccode>, outputs version
      information, creates a small window, and waits for the user to exit.
  </p>

  <div class="githubfile"
       lang="cpp"
       repo="scons-x-compile"
       branch="hello-sdl"
       file="src/main.cpp">
  </div>
  <p>If you have checked out the example code, you can
    build a windows execuable with <ccode>scons --win64</ccode>.
    I won't go into much detail on how it is compiled. If it doesn't work,
    and <ccode>utils/windows_build.py</ccode> and <ccode>utils/linux_build.py</ccode>
    doesn't make sense, shoot me an email.
  </p>
  <p>The Linux <ccode>SCons</ccode> build requires that <ccode>sdl2-config</ccode> is in the
    <ccode>$PATH</ccode> variable. The windows build assumes that the cross-compiled
    <ccode>SDL2</ccode> library is in: <ccode>/usr/local/cross-tools/x86_64-w64-mingw32/</ccode>
  </p>

  <p>The only important difference from what <ccode>sdl2-config</ccode> suggests
    (the one corresponding to the cross-compiled <ccode>SDL2</ccode>),
    is that I omit the <ccode>-mwindows</ccode> flag. With this flag set,
    a console window isn't created. Although very nice for a release, I want to see
    the standard output, so I won't use this flag.
  </p>
  <div class="six columns alpha">
    <small><b><ccode>Linux output</ccode></b></small><br/>
    <a href="<?=imgsrc('sdl_linux.png')?>"
       data-title="Basic SDL2 on Linux"
       data-lightbox="hellosdl">
      <img style="max-width:100%;" src="<?=imgsrc('sdl_linux.png')?>"/>
    </a>
  </div>
  <div class="six columns omega">
    <small><b><ccode>Windows output</ccode></b></small><br/>
    <a href="<?=imgsrc('sdl_windows.png')?>"
       data-title="Basic SDL2 on Windows"
       data-lightbox="hellosdl">
      <img style="max-width:100%;" src="<?=imgsrc('sdl_windows.png')?>"/>
    </a>
  </div>
  <div class="clear"></div>



  <?php heading(4, '2. Building a cross-platform <ccode>SDL2_image</ccode> library',
                '2. Cross-platform <ccode>SDL2_image</ccode>'); ?>
  <p>We want to build a cross-platform version of <ccode>SDL2_image</ccode>,
    and that it supports loading of <ccode>jpeg</ccode> and <ccode>png</ccode> images.
    This means we have to first build <ccode>libpng</ccode> and <ccode>libjpeg</ccode>.
    Also, <ccode>libpng</ccode> requires <ccode>zlib</ccode>. Will compile these
    three first.
  </p>

  <?php heading(5, '2.1 Cross-compiling <ccode>zlib</ccode>'); ?>
  <div class="prettyprint">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# We do this in /tmp
cd /tmp

# Download zlib 1.2.8
wget http://zlib.net/zlib128.zip
unzip zlib128.zip
cd zlib-1.2.8

# Specify our toolchain in the makefile
perl -i -pe 's,(PREFIX =)$,$1 x86_64-w64-mingw32-,' win32/Makefile.gcc

# Call make
make -f win32/Makefile.gcc

# Install it to our cross-tools directory
PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
sudo DESTDIR=$PREFIX/$TOOLSET/ \
    INCLUDE_PATH=include  LIBRARY_PATH=lib  BINARY_PATH=bin \
    make install -f win32/Makefile.gcc
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libz.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>

  <?php heading(5, '2.2 Cross-compiling <ccode>libpng</ccode>'); ?>
  <div class="prettyprint">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# We do this in /tmp
cd /tmp

# Download libpng 1.2.50
wget http://download.sourceforge.net/libpng/libpng-1.2.50.tar.gz
tar xf libpng-1.2.50.tar.gz
cd libpng-1.2.50

# Configure
PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET
export CFLAGS="-I${CROSSPATH}/include"
export LDFLAGS="-L${CROSSPATH}/lib"
./configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$CROSSPATH

# make and install
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libpng.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>

  <?php heading(5, '2.3 Cross-compiling <ccode>libjpeg</ccode>'); ?>
  <div class="prettyprint">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# We do this in /tmp
cd /tmp

# check if you have nasm assembler, if not, install it
if ! command -v nasm ; then
  sudo apt-get install nasm
fi

# Download libjpeg-turbo 1.3.0
wget "http://downloads.sourceforge.net/project/"\
"libjpeg-turbo/1.3.0/libjpeg-turbo-1.3.0.tar.gz"
tar xf libjpeg-turbo-1.3.0.tar.gz
cd libjpeg-turbo-1.3.0/

PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET
export CFLAGS="-I${CROSSPATH}/include"
export LDFLAGS="-L${CROSSPATH}/lib"
./configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$CROSSPATH

# Make and install
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libjpeg.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>


  <?php heading(5, '2.4 Cross-compiling <ccode>SDL2_image</ccode>'); ?>
  <p>From the <ccode>SDL2_image</ccode> source directory:</p>
  <div class="prettyprint ">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# create build-win64 directory and cd to it
mkdir build-win64 && cd $_

# Set up some common variables
PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET

export CC="$TOOLSET-gcc -static-libgcc"
export PKG_CONFIG_PATH=${CROSSPATH}/lib/pkgconfig
export PATH=${CROSSPATH}/bin:$PATH
export CFLAGS="-I${CROSSPATH}/include"
export LDFLAGS="-L${CROSSPATH}/lib"

# Configure build (it should find both libjpeg and libpng now)
../configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$CROSSPATH \
             --disable-webp

# Build and install
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libSDL2_image.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>

  <?php heading(5, '2.5 <ccode>Hello_SDL_image.exe</ccode>'); ?>
  <p>An example program with <ccode>SCons</ccode> build setup can be checked out with:</p>
  <div class="prettyprint">
    <?=shBegin('bash','gutter:false;')?>
 $ git clone -b hello-sdl-image https://github.com/swarminglogic/scons-x-compile.git
    <?=shEnd()?>
  </div>


  <?php heading(4, '3. Building a cross-platform <ccode>SDL2_mixer</ccode> library',
                '3. Cross-platform <ccode>SDL2_mixer</ccode>'); ?>
  <p>For the <ccode>SDL2_mixer</ccode>, I won't bother with <ccode>.mp3</ccode> support,
      since I prefer the better <ccode>ogg</ccode> format. For this we need both
    <ccode>libogg</ccode> and <ccode>libvorbis</ccode>. I'll show how to cross-compile both.
  </p>

  <?php heading(5, '3.1 Cross-compiling <ccode>libogg</ccode>'); ?>
  <div class="prettyprint">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# We do this in /tmp
cd /tmp

# Download libogg 1.3.1
wget http://downloads.xiph.org/releases/ogg/libogg-1.3.1.tar.gz
tar xf libogg-1.3.1.tar.gz
cd libogg-1.3.1/

PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET
./configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$CROSSPATH

# Make and install
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libogg.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>


  <?php heading(5, '3.2 Cross-compiling <ccode>libvorbis</ccode>'); ?>
  <div class="prettyprint">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# We do this in /tmp
cd /tmp

# Download libvorbis 1.3.2
wget http://downloads.xiph.org/releases/vorbis/libvorbis-1.3.2.tar.gz
tar xf libvorbis-1.3.2.tar.gz
cd libvorbis-1.3.2/

PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET
export CFLAGS="-I${CROSSPATH}/include"
export LDFLAGS="-L${CROSSPATH}/lib"
./configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$CROSSPATH

# Make and install
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libvorbis.a</ccode> and <ccode>libvorbisfile.a</ccode>
     should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>

  <?php heading(5, '3.3 Cross-compiling <ccode>SDL2_mixer</ccode>'); ?>
  <p>From the <ccode>SDL2_mixer</ccode> source directory:</p>
  <div class="prettyprint ">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# create build-win64 directory and cd to it
mkdir build-win64 && cd $_

# Set up some common variables
PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET

export CC="$TOOLSET-gcc -static-libgcc"
export PKG_CONFIG_PATH=${CROSSPATH}/lib/pkgconfig
export PATH=${CROSSPATH}/bin:$PATH
export CFLAGS="-I${CROSSPATH}/include"
export LDFLAGS="-L${CROSSPATH}/lib"

# Configure build (it should find ogg and vorbis)
../configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$CROSSPATH \
             --disable-music-mp3-smpeg

# Build and install
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libSDL2_mixer.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>

  <?php heading(5, '3.4 <ccode>Hello_SDL_mixer.exe</ccode>'); ?>
  <p>An example program with <ccode>SCons</ccode> build setup can be checked out with:</p>
  <div class="prettyprint">
    <?=shBegin('bash','gutter:false;')?>
 $ git clone -b hello-sdl-mixer https://github.com/swarminglogic/scons-x-compile.git
    <?=shEnd()?>
  </div>

  <p>The program should list which sound and music decoders it has available.
    On my Linux machine, the (relevant) output is:
  </p>
  <div class="prettyprint">
    <?=shBegin('text','gutter:false;')?>
 $ ./bin/Hello_SDL_mixer
Music decoders (5): WAVE, TIMIDITY, OGG, FLAC, MP3
Audio decoders (6): WAVE, AIFF, VOC, OGG, FLAC, MP3
    <?=shEnd()?>
  </div>
  <p>On my virtual Windows7 machine:
  </p>
  <div class="prettyprint">
    <?=shBegin('text','gutter:false;')?>
> Hello_SDL_mixer.exe
Music decoders (3): WAVE, NATIVEMIDI, OGG
Audio decoders (4): WAVE, AIFF, VOC, OGG
    <?=shEnd()?>
  </div>

  <?php heading(4, '4. Building a cross-platform <ccode>SDL2_ttf</ccode> library',
                '4. Cross-platform <ccode>SDL2_ttf</ccode>'); ?>
  <p>As with previous libraries, <ccode>SDL2_ttf</ccode> has a dependency.
  In this case, <ccode>libfreetype</ccode>. It also depends on <ccode>libpng</ccode>, but I
  assume you are following this article in order, and already have that
  available.</p>

  <?php heading(5, '4.1 Cross-compiling <ccode>libfreetype</ccode>'); ?>
  <div class="prettyprint">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# We do this in /tmp
cd /tmp

# Download freetype-2.5.2
wget http://download.savannah.gnu.org/releases/freetype/freetype-2.5.2.tar.gz
tar xf freetype-2.5.2.tar.gz
cd freetype-2.5.2/

PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET
PATH=${CROSSPATH}/bin:$PATH
export CFLAGS="-I${CROSSPATH}/include"
export LDFLAGS="-L${CROSSPATH}/lib"
export LIBPNG="`libpng-config --libs`"
export LIBPNG_CFLAGS="`libpng-config --cflags`"
export LIBPNG_LDFLAGS="`libpng-config --ldflags`"

./configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$CROSSPATH

# Make and install
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libfreetype.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>


  <?php heading(5, '4.2 Cross-compiling <ccode>SDL2_ttf</ccode>'); ?>
  <p>From the <ccode>SDL2_ttf</ccode> source directory:</p>
  <div class="prettyprint ">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# create build-win64 directory and cd to it
mkdir build-win64 && cd $_

# Set up some common variables
PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET

export CC="$TOOLSET-gcc -static-libgcc"
export PKG_CONFIG_PATH=${CROSSPATH}/lib/pkgconfig
export PATH=${CROSSPATH}/bin:$PATH
export CFLAGS="-I${CROSSPATH}/include"
export LDFLAGS="-L${CROSSPATH}/lib"

# Configure build (it should find libfreetype now)
../configure --target=$TOOLSET --host=$TOOLSET \
             --build=x86_64-linux --prefix=$CROSSPATH

# Build and install
make
sudo make install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libSDL2_ttf.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>


  <?php heading(5, '4.3 <ccode>Hello_SDL_ttf.exe</ccode>'); ?>
  <p>An example program with <ccode>SCons</ccode> build setup can be checked out with:</p>
  <div class="prettyprint">
    <?=shBegin('bash','gutter:false;')?>
 $ git clone -b hello-sdl-ttf https://github.com/swarminglogic/scons-x-compile.git
    <?=shEnd()?>
  </div>

  <?php heading(4, '4. Building a cross-platform <ccode>GLEW</ccode> library',
                '4. Cross-platform <ccode>GLEW</ccode>'); ?>
  <p>In order to make <ccode>OpenGL</ccode> function calls, we use a helper library
  for figuring out which functions are supported by the graphics card,
  based on a system of extensions. One such helper library is <ccode>GLEW</ccode>.
  </p>
  <div class="prettyprint">
    <p>
      <?=shBegin('bash', 'gutter:true;')?>
# We do this in /tmp
cd /tmp

# Download glew 1.11.0
wget http://downloads.sourceforge.net/project/glew/glew/1.11.0/glew-1.11.0.tgz
tar xf  glew-1.11.0.tgz
cd glew-1.11.0/

PREFIX=/usr/local/cross-tools/
TOOLSET=x86_64-w64-mingw32
CROSSPATH=$PREFIX/$TOOLSET

# Slightly trickier, since it doesn't use configure
make SYSTEM=linux-mingw64            \
  CC=${TOOLSET}-gcc LD=${TOOLSET}-ld \
  LDFLAGS.EXTRA=-L${CROSSPATH}/lib   \
  GLEW_PREFIX=${CROSSPATH}           \
  GLEW_DEST=${CROSSPATH}

sudo make SYSTEM=linux-mingw64       \
  CC=${TOOLSET}-gcc LD=${TOOLSET}-ld \
  LDFLAGS.EXTRA=-L${CROSSPATH}/lib   \
  GLEW_PREFIX=${CROSSPATH}           \
  GLEW_DEST=${CROSSPATH} install
      <?=shEnd()?>
    </p>
  </div>
  <p>Static library <ccode>libglew32.a</ccode> should now be in <ccode>$CROSSPATH/lib</ccode></ccode></p>

  <?php heading(4, '5. <ccode>Hello_OpenGL.exe</ccode>'); ?>
  <p>Let's put everything together into a program
   that uses and initializes <ccode>SDL2</ccode>,
    <ccode>SDL2_image</ccode>, <ccode>SDL2_mixer</ccode>,
    <ccode>SDL2_ttf</ccode>, and <ccode>OpenGL</ccode> through <ccode>GLEW</ccode>.
    For <ccode>OpenGL</ccode> creation, it should try to
    find the highest version that it can create a context for.
  </p>

  <p>You can check out and compile this example with:</p>
  <div class="prettyprint">
    <?=shBegin('bash','gutter:false;')?>
 $ git clone -b hello-opengl https://github.com/swarminglogic/scons-x-compile.git
    <?=shEnd()?>
  </div>

  <p>The example tries to create an <ccode>OpenGL 4.4</ccode> context,
    if that fails, it tries a <ccode>4.3</ccode> context,
    then <ccode>4.2</ccode> and so on.  After it creates an <ccode>OpenGL</ccode> context,
    it initializes <ccode>GLEW</ccode>.
  </p>
  <p>
    The version of the created context, together with graphics driver information,
    extensions found, etc, are sent to the standard output.
  </p>

  <div class="six columns alpha">
    <small><b><ccode>Linux output</ccode></b></small><br/>
    <a href="<?=imgsrc('sdl_all_linux.png')?>"
       data-title="SDL2 libraries + OpenGL through GLEW on Linux"
       data-lightbox="hello-opengl">
      <img style="max-width:100%;" src="<?=imgsrc('sdl_all_linux.png')?>"/>
    </a>
  </div>
  <div class="six columns omega">
    <small><b><ccode>Windows output</ccode></b></small><br/>
    <a href="<?=imgsrc('sdl_all_windows.png')?>"
       data-title="SDL2 libraries + OpenGL through GLEW on Windows"
       data-lightbox="hello-opengl">
      <img style="max-width:100%;" src="<?=imgsrc('sdl_all_windows.png')?>"/>
    </a>
  </div>
  <div class="clear"></div>


  <div style="height:200px;" class="clear"></div>

</div>
<?php
global $toc;
$data['toc'] = $toc;
$this->load->view('sidebar', $data); ?>
