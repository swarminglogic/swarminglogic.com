<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, '<ccode>subtlemark</ccode>: Watermarking Images', false); ?>
    <p>A quick look at how to automate the process of adding subtle watermarks to images.
    </p>


    <?php heading(4, '1. Configuring Fonts for <code>ImageMagick</code>', '1. Configuring Fonts'); ?>
    <p>
      <ccode>ImageMagick</ccode> uses
      <ccode><a href="http://linux.die.net/man/5/fonts-conf">fonts-conf</a></ccode>
      to detect and use fonts. As such, the default configuration gives many fonts
      to chose from. To list available fonts, use <wccode>identify -list font | grep "Font:"</wccode>
    </p>
    <p>
      Since I want my watermark as subtle as possible, I'll use a tiny font,
      <a href="http://kottke.org/plus/type/silkscreen/"><ccode>silkscreen</ccode></a>,
      which is only 5 pixels high. To install the font (for a single user), unpack the
      <ccode>ttf</ccode>-files to <wccode>~/.fonts/</wccode>
    </p>
    <p><ccode>ImageMagick</ccode> should now be able to find the font.
      <div class="prettyprint pushup">
        <pre class="brush: bash; gutter:false;">
$ identify -list font | grep -i "font: silkscreen"
  Font: Silkscreen
  Font: SilkscreenB
  Font: SilkscreenExpanded
  Font: SilkscreenExpandedB
        </pre>
      </div>

    </p>
    <hr class="soft"/>
    <p>
      If for some reason the <ccode>ImageMagick</ccode> doesn't properly detect
      the font, you can use a script
        (<wccode><a href="http://www.imagemagick.org/Usage/scripts/imagick_type_gen">imagick_type_gen</a>)
        </wccode>
      to generate an <wccode>ImageMagick</wccode> font configuration file. Here is how:

        <div class="prettyprint pushup">
          <pre class="brush: bash; gutter:false;">
$ cd /tmp
$ wget http://www.imagemagick.org/Usage/scripts/imagick_type_gen
$ chmod +x imagick_type_gen
$ mkdir ~/.magick
$ find ~/.fonts/ -name "*.ttf" | ./imagick_type_gen -f - > ~/.magick/type.xml
          </pre>
        </div>
    </p>
    <p>The newly generatedfile <ccode>~/.magick/type.xml</ccode> should contain the entry:
      <div class="prettyprint pushup">
        <pre class="brush: text; gutter:false;">
  &lt;type
     format="ttf"
     name="Silkscreen"keyfunc-output-overlay.png
     fullname="Silkscreen"
     family="Silkscreen"
     glyphs="/home/okami/.fonts/slkscr.ttf"
     />
        </pre>
      </div>
    </p>


    <?php heading(4, '3. Key Functionality'); ?>
    <?php heading(5, 'Extending image with watermark label'); ?>
    <p>
      The following snippet shows how the <ccode>convert</ccode> tool can be
      used to extend an image with a text label:

      <div class="prettyprint pushup">
        <pre class="brush: bash; gutter:false;">
    convert input.png  -background "#888" \
        -font "Silkscreen" \
        -pointsize 8 \
        -fill "#0007" \
        label:"Roald Fernandez  swarminglogic.com  $(date +'%Y-%m-%d')  CC-BY" \
        -gravity SouthEast -append output.png
        </pre>
      </div>

      <div class="clear"></div>
      <table class="lines">
        <tr>
          <td style="vertical-align:top;">
            <ccode><b>Input</b></ccode><br/>
            <a href="<?=imgsrc('keyfunc-input.png')?>" data-title="Input" data-lightbox="extended">
              <img src="<?=imgsrc('thumb-keyfunc-input.png')?>" style="float:top;" alt="" />
            </a><br/><small>(Click to enlarge)</small>
          </td>
          <td>
            <ccode><b>Output</b></ccode><br/>
            <a href="<?=imgsrc('keyfunc-output-extended.png')?>"
               data-title="Output (w/watermark extending image)" data-lightbox="extended">
              <img src="<?=imgsrc('keyfunc-output-extended.png')?>" class="" alt="" />
            </a>
          </td>
        </tr>
      </table>
    </p>
    <?php heading(5, 'Overlaying watermark on top of image'); ?>
    <p>
      Changing the image size can mess up the perfect screen resolution of an image. Here is a different snippet,
      that draws a rectangle on top of the image, and the text on top of that again.

      <div class="prettyprint pushup">
        <pre class="brush: bash; gutter:false;">
    width=$(identify -format %w input.png)
    height=$(identify -format %h input.png)
    rect="0,$((height-10)),${width},${height}"
    convert input.png \
        -fill "888A" -draw "rectangle ${rect}" \
        -font "Silkscreen" \
        -pointsize 8 \
        -fill "#0007" \
        -gravity SouthEast \
        -draw "text 0,0 'Roald Fernandez  swarminglogic.com  $(date +'%Y-%m-%d')  CC-BY  '" \
        output.png
        </pre>
      </div>

      <table class="lines">
        <tr>
          <td style="vertical-align:top;">
            <ccode><b>Input</b></ccode><br/>
            <a href="<?=imgsrc('keyfunc-input.png')?>" data-title="Input" data-lightbox="overlay">
              <img src="<?=imgsrc('thumb-keyfunc-input.png')?>" style="float:top;" alt="" />
            </a><br/><small>(Click to enlarge)</small>
          </td>
          <td>
            <ccode><b>Output</b></ccode><br/>
            <a href="<?=imgsrc('keyfunc-output-overlay.png')?>"
               data-title="Output (w/overlay watermark)" data-lightbox="overlay">
              <img src="<?=imgsrc('keyfunc-output-overlay.png')?>" class="" alt="" />
            </a>
          </td>
        </tr>
      </table>


    </p>

    <?php heading(4, '4. Bash script'); ?>
    <p>I got carried away with adding features to the script <ccode>^_^</ccode></p>
    <div class="prettyprint">
      <p><ccode><b>Example use:</b></ccode><br/>
Add a watermark overlay to an image. The caption should say "SwarmingLogic",
    be on the top left, with text color <ccode>#243A</ccode>, transparent background, and
    use the font <ccode>Silkscreen</ccode> with point size <ccode>8</ccode>.
        <pre class="brush: bash; gutter:false;">
subtlemark -c '#243A' -b none -f Silkscreen -F 8 \
  -p NorthWest -t "SwarmingLogic" input.png output.png
        </pre>
      </p>
      <p class="offset-by-one">
      <img src="<?=imgsrc('subtlemark-example.png')?>" class="" alt="" />
      </p>
    </div>

    <br/>
    <div class=""><ccode><b>The final script:</b></ccode></div>
    <div class="externgist" lang="bash" gist="e563571ec4d11ec0901b" file="subtlemark.sh">
    </div>

    <div style="height:200px;" class="clear"></div>


  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebar', $data); ?>
</div>
