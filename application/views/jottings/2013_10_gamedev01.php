<?php
$languages = array("Cpp", "Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'DevLog 1: Game Engine Progress, One Month In.','Top',true); ?>
    <p>
      <a href="<?=imgsrc('deferred-all_wm.png')?>">
        <img style="width: 100%; max-width:600px;"
             src="<?=imgsrc('deferred-all-600px_wm.png')?>" alt="" />
      </a>
    </p>
    <p>A little over a month ago, I started making my own game engine, which has
      until now, for the most part been a learn-OpenGL-as-I-go process.</p>

    <p>
      This article is the first in a series of development logs where spend
      time to look back and write about the past month. The intention is
      to document progress, decisions made, difficulties encountered and lessons
      learned.
    </p>

    <p> It would be great if the scribblings here were of use to someone else,
      but for now I'll settle for giving an answer to friends and family
      wondering what I'm doing all day. That, and to have something to cheer me
      up, if I feel I'm not making progress.
    </p>

    <p>
      The past month was devoted to
      learning <ccode><a href="http://en.wikipedia.org/wiki/Opengl">OpenGL</a></ccode> and
      <ccode><a href="http://en.wikipedia.org/wiki/Opengl">SDL2</a></ccode>, and
      putting together the first pieces of a game engine (so far, just a
      rudimentary graphics engine).
    </p>

    <div class="pushdown">
      <?php heading(4, '1. Making choices: C++, OpenGL and SDL'); ?>
      <p>First of all, I should point out that I'm not interested in taking the
      shortest path to "making a game". If that were the case, I'd be crazy
      not to go with Unity, Unreal Engine, UDK, or any other framework that
      solves the millions of problems that undoubtedly will arise. I'm interested in
      learning the technology, and the more fundamental building blocks.
      </p>
    </div>
    <?php heading(5, '1.1. Why C++', '', false); ?>
    <p>The first step is to decide which programming language to use for the
    base code. This decision is heavily affected by the platform one would like
    to target. For web games, you would nowadays go with <ccode>HTML5/Javascript</ccode>. For
    android games: <ccode>Java</ccode>. For iOS games: <ccode>Objective-C</ccode>.</p>
    <p>
    As for desktop games, any of
    the above would be possible. However, if you would like to target <em>all of the
    above</em>*, and any other gaming platform (PSP, PS3, PS4, XBox), and your top
    priority is performance, there is only one choice to make:
      <nowrap>C++</nowrap> (or C, for the masochists).
    </p>

    <p class="pushup"><small>* Maybe not web games, although there is
      <a href="https://github.com/kripken/emscripten/wiki">emscripten</a>
    for that.</small></p>

      <?php heading(5, '1.2. Why OpenGL', '', false); ?>
      <p>Games need to interact with the graphics processing unit. Short of using a
    game engine framework (Unity, UDK, etc), you have to deal with the graphics
    card yourself. For this, there is <ccode>OpenGL</ccode> or <ccode>Direct3D</ccode>.
    Since the latter is limited to Windows and Xbox, it leaves <ccode>OpenGL</ccode>,
    which isn't a bad thing.</p>

      <p> Linux is rapidly becoming a viable gaming platform (big thanks to
    Valve), and absolutely every modern gaming platform will be able to use
        <ccode>OpenGL</ccode>... aside from Xbox. Not to mention that with the exception of
    Windows/Xbox, <ccode>OpenGL</ccode> is the <em>only</em> option. The future looks
    very promising for <ccode>OpenGL</ccode>.
      </p>

      <?php heading(5, '1.3. Why SDL', '', false); ?>
      <p>Writing games requires window management, <ccode>OpenGL</ccode>
    interaction, handling user input (touch, keyboard, mouse, joysticks,
    gamepads), playing back sounds, loading images, thread management,
    networking.</p>

      <p>It is possible to use various libraries to handle each separate aspect.
    However, if you would like be cross-platform, and target Android, iOS,
    Linux, Windows, Mac, there aren't that many contenders (even if you just limit yourself to desktops).
        <ccode><a href="http://www.libsdl.org/">Simple Directmedia Library (SDL)</a></ccode>
    is to my knowledge the best library for this. It is mainly developed by
        <a href="http://en.wikipedia.org/wiki/Sam_Lantinga">Sam Latinga</a>,
    who currently works for Valve. Most importantly, Valve is now using <ccode>SDL</ccode>
    in their linux commercial games, including the steam client.
        <a href="http://www.gdcvault.com/play/1017850/"><sup>[1, presentation]</sup></a>
        <sup><a href="https://developer.nvidia.com/sites/default/files/akamai/gamedev/docs/Porting%20Source%20to%20Linux.pdf">[2, slides]</a></sup>
      </p>

      <p>If you only target desktop platforms, you might want to consider
        <ccode><a href="http://www.glfw.org/">GLFW</a></ccode>
    for a clean and lightweight <ccode>OpenGL</ccode> and window management solution, or
        <ccode><a href="http://www.sfml-dev.org/">SFML</a></ccode>
      for a more C++ style alternative to SDL (which very <ccode>C</ccode>-like).
      </p>

      <?php heading(5, '1.4. More decisions.', '', false); ?>
      <ul>
        <li><b>Which OpenGL Version to Target?</b>
          <p>The choice is to balance how old hardware to support, and what functionality
      is necessary.</p>
          <p> Valve shares a survey of user hardware
            <a href="http://store.steampowered.com/hwsurvey">here</a>.
      As a rule of thumb:
            <ul class="pushup">
              <li><ccode>D3D11 = GL4</ccode></li>
              <li><ccode>D3D10 = GL3</ccode></li>
              <li><ccode>D3D9 &nbsp;= GL2</ccode></li>
            </ul>
      Unless you care about the remaining 3.05% of the market, you can safely target OpenGL 3.
          </p>
          <p>For the time being, I'm using OpenGL 4.3 while learning the
      technology, so as to not be limited by non-existing functionality, though I'm fairly
      sure I haven't used any exclusive functionality.</p>
        </li>
        <li><b>Core vs Compatibility Profile?</b><p>OpenGL 3+ hid a lot of
      deprecated functionality in a "compatibility profile"-mode. Since I'm
      starting from scratch, and I have no reason to rely on this functionality,
      I'm sticking to the core profile. The core profile is also much, much
      closer to the OpenGL ES, so if you are planning to port to mobile devices,
      you will make it much easier for yourself.</p></li>
      </ul>
      <p></p>

      <?php heading(4, '2. Early Progress - OpenGL Basics'); ?>
      <p>The first attempts at throwing something interesting on the screen.</p>
      <div class="six columns alpha">
        <small>36 vertices per cube, draw-call per cube.<br/>2.5k cubes in total.</small><br/>
        <iframe width="300" height="225" src="//www.youtube.com/embed/bL4jxx6TMUs"
                frameborder="0" allowfullscreen></iframe>
      </div>
      <div class="six columns omega">
        <br/><small>With a few minor optimizations: 40k cubes:</small><br/>
        <iframe width="300" height="225" src="//www.youtube.com/embed/XMxU4fm_Rk8"
                frameborder="0" allowfullscreen></iframe>
      </div>
      <div class="clear"></div>
      <p></p>

      <div class="six columns alpha">
        <small>Using instanced indexed rendering, 720k cubes.</small><br/>
        <iframe width="300" height="225" src="//www.youtube.com/embed/0KdcxX_0_N8"
                frameborder="0" allowfullscreen></iframe>
      </div>
      <div class="clear"></div>

      <?php heading(4, '3. Rendering 2D, Dynamic Text'); ?>
      <p>Rendering live 2D text was not as straight forward as I had
thought. Turns out that preparing images of the text to write, and then drawing
a quad with this image as a texture is a very naive and inefficient way to go
about it. <ccode>SDL_ttf</ccode> makes
 this fairly easy to do, and one might be tempted to stick with it.
      </p>
      <p>I thought it would be much worse to render a quad for each character to
    display, each with a screen position, and with texture coordinates for the
    position in a character map image. Turns out, it's not.

      </p>
      <p>Just telling OpenGL is to do *anything*, is costly, much more than
    rendering a few hundred individual quads with individual texture lookups.
    This is why, instead of preparing a texture with the text to display and
    rendering it on a single screen (all of which takes precious CPU time), you
    should use a character map (an image where each character is laid out on a
    grid, and you know the texture coordinates of each character), and tell
    OpenGL how to render each character on a tiny quad, and where to place that
    quad.
      </p>
      <p>A efficient way of doing this, I found, was to use a uniform array,
    with only the necessary data: the positions in the character map texture,
    and the position on the screen. Then, rendering each character as an
    instanced quad (four vertex triangle strip), in batches of 256 characters
    pr. render call. The optimum was found around 384 characters per batch, but
    it was only 1.6% better than the nice round number of 256, so I stuck with
    that. It's also a good idea to stay clear of <ccode>MAX_VERTEX_UNIFORM_COMPONENTS</ccode>.
      </p>

      <p><a href="<?=imgsrc('text-bench_wm.png')?>">
        <img style="width: 100%; max-width:600px;"
             src="<?=imgsrc('text-bench-600.png')?>" alt="" />
      </a><br/><small>Btw, I'm using <a href="http://opengameart.org/content/bitmap-font-0">this bitmap font</a>, which I didn't make.</small>
      </p>

      <p>Filling the screen with text, 32 124 characters to be exact, had a
    constant 923 FPS, or 1.083 milliseconds pr. frame. It's more or less
    meaningless to quantify it, other than to find good solutions for my own
    hardware. I'm happy with the solution, as it is both flexible (any font
    style variation is done by extending the character map) and fast. It
    supports TTF fonts by generating a character map with the desired style
    variations, including per-character width data, thus supporting variable
    width fonts.</p>

      <?php heading(4, '4. Loading Wavefront OBJ files'); ?>
      <p>Rendering cubes is boring. And writing out the vertices of something more
    complex, is also not worth it. It would be nice to be able to load 3D
    meshes, with texture coordinates, and normals. One of the simplest and most
    widely supported formats is
        <a href="http://en.wikipedia.org/wiki/Wavefront_OBJ">Wavefront OBJ</a>.
      </p>
      <p>Writing a parser isn't very hard, but certainly tedious, so I used
        <ccode><a href="https://github.com/syoyo/tinyobjloader">tinyobjloader</a></ccode>,
    by <a href="https://github.com/syoyo">syoyo</a>. With this, you can
      load any of the <a href="http://graphics.cs.williams.edu/data/meshes.xml">
    famous 3D models</a> often seen in Siggraph videos, and research papers.
      </p>

      <?php heading(5, '4.1. Speeding it up 50-100x', '', false); ?>
      <p>The main draw-back with the OBJ format is that it is a clear-text format.
    The data is written in ASCII characters, and needs to be parsed. This
    actually takes a significant amount of time. E.g. the Rungholt scene takes
    around 38 seconds to parse.
      </p>
      <p>A simple workaround is to write your own binary format that handles the
      data you are interested in. This is surprisingly quick to do, taking only
      two hours to implement. It reduced the Rungholt load time from 38 to 0.7
      seconds.</p>
      <p>Here are the 70 lines of code, for both writing and reading to
      the <ccode>COBJ</ccode> format (C for Compact).</p>
      <p>
        <div class="prettyprint">
          <pre class="brush: cpp;">
void write(std::ostream& stream,
           const std::vector&lt;tinyobj::shape_t&gt;& shapes)
{
  assert(sizeof(float) == sizeof(uint32_t));
  const auto sz = sizeof(uint32_t);
  const uint32_t nMeshes = static_cast&lt;uint32_t&gt;(shapes.size());
  const uint32_t nMatProperties = 3;

  stream.write((const char*)&nMeshes, sz);        // nMeshes
  stream.write((const char*)&nMatProperties, sz); // nMatProperties

  for (size_t i = 0 ; i &lt; nMeshes ; ++i) {
    const uint32_t nVertices  = (uint32_t)shapes[i].mesh.positions.size();
    const uint32_t nNormals   = (uint32_t)shapes[i].mesh.normals.size();
    const uint32_t nTexcoords = (uint32_t)shapes[i].mesh.texcoords.size();
    const uint32_t nIndices   = (uint32_t)shapes[i].mesh.indices.size();

    // Write nVertices, nNormals,, nTexcoords, nIndices
    // Write #nVertices positions
    // Write #nVertices normals
    // Write #nVertices texcoord
    // Write #nIndices  indices
    // Write #nMatProperties material properties
    stream.write((const char*)&nVertices,  sz);
    stream.write((const char*)&nNormals,   sz);
    stream.write((const char*)&nTexcoords, sz);
    stream.write((const char*)&nIndices,   sz);

    stream.write((const char*)&shapes[i].mesh.positions[0], nVertices  * sz);
    stream.write((const char*)&shapes[i].mesh.normals[0],   nNormals   * sz);
    stream.write((const char*)&shapes[i].mesh.texcoords[0], nTexcoords * sz);
    stream.write((const char*)&shapes[i].mesh.indices[0],   nIndices   * sz);
    stream.write((const char*)&shapes[i].material.ambient[0], 3 * sz);
  }
}


std::vector&lt;tinyobj::shape_t&gt; read(std::istream& stream)
{
  assert(sizeof(float) == sizeof(uint32_t));
  const auto sz = sizeof(uint32_t);

  std::vector&lt;tinyobj::shape_t&gt; shapes;

  uint32_t nMeshes = 0;
  uint32_t nMatProperties = 0;
  stream.read((char*)&nMeshes, sz);
  stream.read((char*)&nMatProperties, sz);
  shapes.resize(nMeshes);
  for (size_t i = 0 ; i &lt; nMeshes ; ++i) {
    uint32_t nVertices = 0, nNormals = 0, nTexcoords = 0, nIndices = 0;
    stream.read((char*)&nVertices,  sz);
    stream.read((char*)&nNormals,   sz);
    stream.read((char*)&nTexcoords, sz);
    stream.read((char*)&nIndices,   sz);

    shapes[i].mesh.positions.resize(nVertices);
    shapes[i].mesh.normals.resize(nNormals);
    shapes[i].mesh.texcoords.resize(nTexcoords);
    shapes[i].mesh.indices.resize(nIndices);

    stream.read((char*)&shapes[i].mesh.positions[0], nVertices  * sz);
    stream.read((char*)&shapes[i].mesh.normals[0],   nNormals   * sz);
    stream.read((char*)&shapes[i].mesh.texcoords[0], nTexcoords * sz);
    stream.read((char*)&shapes[i].mesh.indices[0],   nIndices   * sz);
    stream.read((char*)&shapes[i].material.ambient[0], 3 * sz);
  }
  return shapes;
}
          </pre>
        </div>
      </p>


      <?php heading(4, '5. Deferred Rendering'); ?>
      <p><a href="http://en.wikipedia.org/wiki/Deferred_shading">Deferred Shading</a>
    is one of the methods I read about, and was awed by, thinking it would be
    hard to implement. Turns out yet again that it wasn't, at least the basic
    functionality. Then again, I haven't gotten to the hard parts yet (lighting,
    shadows, not to mention transparency, so these words might mock me later.</p>

      <p>In traditional <em>forward rendering</em>, the geometry goes through the
    rendering pipeline, performing all computations necessary to determine the
    end result, as a pixel on the screen. If it turns out it ends up behind
    something already on the screen, and throws it away, along with the effort
    to compute its values.</p>

      <p>The main idea with <em>deferred shading</em> is to store the minimum
    necessary data to compute the output image, as textures. Then, draw a quad
    filling the screen, and with access to the "data textures", compute the
    output image. This very neatly splits the process of preparing the data for
    rendering, and performing the heavy computations (i.e. deferring the heavy
    work to this second stage, hence the name). It also allows for some very
    cool screen space effects, which I will get to soon.</p>

      <p>Currently, only position, normals and albedo texture is stored.
      </p>
      <div class="six columns alpha">
        <p><small>Position</small>
          <a href="<?=imgsrc('rungholt_position.png')?>">
            <img src="<?=imgsrc('rungholt_position_300px.png')?>" alt="" />
          </a>
        </p>
      </div>
      <div class="six columns omega">
        <p><small>Normals</small>
          <a href="<?=imgsrc('rungholt_normals.png')?>">
            <img src="<?=imgsrc('rungholt_normals_300px.png')?>" alt="" />
          </a>
        </p>
      </div>
      <div class="clear"></div>
      <div class="six columns alpha">
        <p><small>Albedo texture</small>
          <a href="<?=imgsrc('rungholt_albedo.png')?>">
            <img src="<?=imgsrc('rungholt_albedo_300px.png')?>" alt="" />
          </a>
        </p>
      </div>
      <div class="six columns omega">
        <p><small>Z-component of position (adjusted)</small>
          <a href="<?=imgsrc('rungholt_depth.png')?>">
            <img src="<?=imgsrc('rungholt_depth_300px.png')?>" alt="" />
          </a>
        </p>
      </div>
      <div class="clear"></div>

      <p>Since it might not be apparent from the position data image, that the
    depth buffer is contained there, I added a visualization of just the the
    z-component (with adjusted ranges for better visualization)</p>
      <p>Retrieving the data is done through texture lookups.
        <div class="prettyprint pushup">
          <pre class="brush: cpp;">
  const vec3 pos  = vec3(texture(PositionData, vs_texpos));
  const vec3 norm = vec3(texture(NormalData, vs_texpos));
  const vec3 col  = vec3(texture(ColorData, vs_texpos));
          </pre>
        </div>
      </p>
      <?php heading(5, '5.1. Diffuse Shading', '', false); ?>
      <p>For a diffuse shader, all that is required is normals normals and positions data.
        <div class="prettyprint pushup">
          <pre class="brush: cpp;">
  const vec3 s = normalize(lightPos.xyz - pos);
  const vec3 diffuse = vec3(0.38, 0.36, 0.34) + max(dot(s, norm), 0.0);
          </pre>
        </div>
      </p>
      <div class="six columns alpha">
        <p>
          <a href="<?=imgsrc('rungholt_diffuse.png')?>">
            <img src="<?=imgsrc('rungholt_diffuse_300px.png')?>" alt="" />
          </a><br/><small>Diffuse shader</small>
        </p>
      </div>
      <div class="clear"></div>

      <?php heading(5, '5.2. Edge Detection', '', false); ?>
      <p>Using a <a href="http://en.wikipedia.org/wiki/Sobel_operator">Sobel operator</a> on
    the depth data, a visualization of sudden depth changes can be achieved.</p>
      <div class="six columns alpha">
        <p>
          <a href="<?=imgsrc('rungholt_depth-edgdedetection.png')?>">
            <img src="<?=imgsrc('rungholt_depth-edgdedetection_300px.png')?>" alt="" />
          </a><br/><small>Depth-based Sobel edge detection.</small>
        </p>
      </div>
      <div class="clear"></div>
      <?php heading(5, '5.3. Screen Space Ambient Occlusion', '', false); ?>
      <p><a href="http://en.wikipedia.org/wiki/Screen_space_ambient_occlusion">Screen space
     ambient occlusion (SSAO)</a> is a clever technique to approximate the
     shadows that would result from geometry occluding global illumination. The
     implemented method is quite basic, with random sampling, but no blurring.
      </p>
      <div class="six columns alpha">
        <p>
          <a href="<?=imgsrc('rungholt_ssao.png')?>">
            <img src="<?=imgsrc('rungholt_ssao_300px.png')?>" alt="" />
          </a><br/><small>Screen space ambient occlusion.</small>
        </p>
      </div>
      <div class="clear"></div>

      <?php heading(5, '5.4. Putting it together + gamma correction',
                    '', false); ?>
      <p>Combining the above effects:
        <ul class="pushup">
          <li>Texture color</li>
          <li>Diffuse shading</li>
          <li>Depth based edge detection</li>
          <li>SSAO</li>
          <li>Gamma correction</li>
        </ul>
      </p>
      <p>
        <a href="<?=imgsrc('rungholt_diffuse-albedo-edgedetect-ssao.png')?>">
          <img src="<?=imgsrc('rungholt_diffuse-albedo-edgedetect-ssao_300px.png')?>" alt="" />
        </a><br/>
        <small></small>
      </p>
      <div class="clear"></div>
      <p>YouTube video. The framerate is a bit low, but it's mainly because of the amount of geometry.</p>
      <div class="youtubevid">
        <iframe src="//www.youtube.com/embed/FD7HYZscGFs"
                frameborder="0" allowfullscreen></iframe>
      </div>

      <?php heading(4, '6. Shadowing OpenGL State'); ?>
      <p>Telling OpenGL to transition to a state that it's already in, changes
        nothing, but might still be an expensive call, and it's recommended to avoid it.
      </p>
      <p>The easiest way to do so, is shadowing (aka mirroring) the <ccode>OpenGL</ccode>
        state, and checking if a gl-call will be redundant. I do this with a singleton class,
        which static access functions mapped to private member functions. The point of this is to be able to say:
        <div class="prettyprint pushup">
          <pre class="brush: cpp; gutter: false;">
             &nbsp;GlState::enable(GlState::DEPTH_TEST);
          </pre>
        </div>
        Instead of the usual:
        <div class="prettyprint">
          <pre class="brush: cpp; gutter:false;">
            &nbsp;GlState::instance().enable(GlState::DEPTH_TEST);
          </pre>
        </div>
      </p>

      <?php heading(5, '6.1. Finding Redundant State Changes', '', false); ?>
      <p><ccode><a href="http://www.gremedy.com">gDEbugger</a></ccode> is an
        excellent tool for detecting redundant state changes.</p>
      <p> Below is a
        screenshot, showing two functions I've yet to add to my GlState
        shadowing: <ccode>glBindBGufferBase</ccode> and <ccode>glDepthMask</ccode>.
      </p>
      <p>
        <a href="<?=imgsrc('gldebugger-redundant.png')?>">
          <img style="width: 100%; max-width:600px;"
               src="<?=imgsrc('gldebugger-redundant.png')?>" alt="" />
        </a>
      </p>

      <?php heading(5, '6.2. Is it worth it?', '', false); ?>
      <p>For learning OpenGL, definitely. It helps to understand the OpenGL
        state machine. However, as for performance concerns, there was no gain
        in avoiding redundant state changes, if anything a slight penalty due to
        the added overhead. It might be a different case once the rendering
        complexity becomes more realistic.
        Since it's easy to implement, and easy to disable
        once you do, I'm still happy to have it in place.</p>

      <p>The second alternative which might be better for performance, but a
        lot trickier to implement, is to sort operations based on state, and
        executing them in the order with minimal state change. With this you
        don't only avoid redundant state change <em>request</em>, but actually
        avoid the redundant state change altogether.
      </p>

      <?php heading(4, '7. Other Stuff'); ?>
      <p>I fear this article is getting a bit out of hand, and I might end up
      spending far too much time on it. I'll try to just summarize the rest.</p>

      <?php heading(5, '7.1. Logging System'); ?>
      <p>Using <ccode>printf</ccode> or <ccode>std::cout</ccode> becomes
      unmanageable, quickly.  It's still very useful and important to log
      events. There are many ways to implement such a system. I've kept mine
      simple and flexible, with the following features:

        <ul class="pushup">
          <li>Level system (debug, info, warning, error).</li>
          <li>Timestamp.</li>
          <li>Log instance owner (who made the log entry).</li>
          <li>Storing log output to log-file.</li>
          <li>Ability to define a macro, to compile away logging.</li>
          <li>Various colored terminal output styles (currently only <ccode>bash</ccode>).</li>
        </ul>

        <a href="<?=imgsrc('loggingsystem.png')?>">
          <img style="width: 100%; max-width:600px;"
               src="<?=imgsrc('loggingsystem.png')?>" alt="" />
        </a>
      </p>

      <?php heading(5, '7.2. Automatic Shader Rebuild'); ?>
      <p>
      When learning GLSL, it is nice to minimize the time between changing shader
      code, and seeing visual change. For this, automatic monitoring of
      files is performed. When a file's timestamp is newer, it reloads the file,
      compiles and links the shaders. If it succeeds, the current shader is
      replaced. If it fails, it rejects the current modification and keeps the
      existing one, logging error output.</p>

      <p> Here is a quick demo:
      </p>
      <p class="pushup">
        <div class="youtubevid">
          <iframe src="//www.youtube.com/embed/hlSG_iVC6xc"
                  frameborder="0" allowfullscreen></iframe>
        </div>
      </p>

      <?php heading(5, '7.3. Checking for OpenGL memory leaks'); ?>
      <p>Since I'm using an nvidia card, and linux, the utility <ccode>nvidia-msi</ccode>
      was a quick and dirty way of making sure I properly deleted allocated
      buffers. Use <ccode>watch</ccode> to get a live update of the memory consumption.

        <div class="prettyprint pushup">
          <pre class="brush: bash; gutter:false;">
            &nbsp;$ watch -n 0.2 nvidia-msi
          </pre>
        </div>

        <img style="max-width:600px;"
             src="<?=imgsrc('nvidia-msi.png')?>" alt="" />
      </p>


      <?php heading(5, '7.4. Unit testing'); ?>
      <p>
        If used right, <a href="http://en.wikipedia.org/wiki/Unit_testing">Unit testing</a> can be an
        invaluable tool. It can help the class design process, catch bugs early, document
        functionality, and later let you be confident that a change you introduced didn't
        mess up something else.
      </p>
      <p>My favorite unit test system (by far) is <ccode><a href="http://cxxtest.com/">CxxTest</a></ccode>,
        mostly for the reasons that come to light in
        <a href="http://gamesfromwithin.com/exploring-the-c-unit-testing-framework-jungle">
        this overview</a>. I customized the output to make it prettier, and also show
        test execution time when it exceeds <nowrap>1 ms</nowrap>:
      </p>
      <p>
        <img style="max-width:600px;"
             src="<?=imgsrc('cxxtest.png')?>" alt="" />
      </p>
      <p><a href="/images/articles/2013_06_cpp_setup/testexec2.opt.gif">Here is an animated gif</a>
       showing how simple it is to add a test suite, and individual test functions.
      </p>
      <?php heading(5, '7.5. Automatic Build System'); ?>
      <p>See my <a href="/article/2013_06_cpp_setup">previous article</a> on the
      setup for automatic code compilation. It saves a ton of time, however, it
      might not be viable for large code bases.
      </p>

      <?php heading(4, '8. Thoughts & Conclusions'); ?>
      <p>I spent too much time writing this. <ccode>¯\_(ツ)_/¯</ccode></p>
      <p>If you want the source code, let me know, and I'll consider putting it
      on github. Currently, it's hosted on bitbucket.</p>
  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebar', $data); ?>
</div>
