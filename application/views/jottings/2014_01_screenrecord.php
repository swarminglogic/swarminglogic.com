<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'Timelapse screen recording of separate X displays', false); ?>
    <p><b>Update 2014-04-8:</b> See <a href="2014_04_screenrecordalt">this post</a> on how to deal with
    two monitors on a single X screen.</p>

    <p>This post is for those with separate X displays, who want to do timelapse screencapture.
    There are many utilities for doing this kind of timelapses, in particular, I'd recommend
      <a href="http://code.google.com/p/chronolapse/">chronolapse</a>, which does
    a very good job, even with multiple monitors. If that works for you, then go
    for it! However, if you have trouble with it working for separate
    X-displays as I did, or just want more control, read on!
    </p>

    <p>
    The post is broken up into small steps, which are put together as <a href="#script">a complete script</a>.<br/>
    There is also a <a href="#video">demo video</a> made using this script at the very bottom.
    </p>

    <?php heading(4, '1. Capturing screenshot of full X display', '1. Capturing screenshot'); ?>
    <p>There are several ways to take a screenshot from the command line. The
    two most interesting utilities are <ccode><?=wiki('Xwd','xwd');?></ccode>,
    and Image Magick's <ccode><a href="http://www.imagemagick.org/script/import.php">import</a></ccode> utility, as
    these utilities are available in most systems by default (and if you don't have the latter, you should).
    </p>

    <p>
      Since using <ccode>import</ccode> caused jittering when capturing the screen, I'll stick with <ccode>xwd</ccode>.
      Here is how to take a screenshot:
      <ccode class="fullwidth prettyprint">xwd -root -out screenshot.xwd</ccode>
    </p>


    <?php heading(4, '2. Specifying which X to use'); ?>
    <p>The environment variable <ccode>DISPLAY</ccode> determines which display is used.
    By setting this variable prior to executing a command, you determine which display it communicates with.
    Try out these examples in a terminal:
      <ccode class="fullwidth prettyprint">DISPLAY=:0.0 gedit<br/>
DISPLAY=:0.1 gedit
      </ccode>
    </p>

    <p>
    Putting it together with the <ccode>xwd</ccode> utility, you can specify which display to take a screenshot of:
      <ccode class="fullwidth prettyprint">DISPLAY=:0.0 xwd -root -out screenshot-left.xwd <br/>
DISPLAY=:0.1 xwd -root -out screenshot-right.xwd </ccode>
    </p>


    <?php heading(4, '3. Creating the thumbnail'); ?>
    <p>
      Since the goal was to have a picture-in-picture of one monitor shown on
    top of the other, we will have to create this thumbnail. This is where the
    ImageMagick utilities shine. First let's grab a screenshot:
      <ccode class="fullwidth prettyprint">xwd -root -out screen.xwd</ccode>
      Then, lets create reduce the image, so that it fits a <ccode>300x300</ccode> pixel box,
     while retaining its aspect ratio.
      <ccode class="fullwidth prettyprint">convert screen.xwd -thumbnail 300x300 thumbnail-300px.png</ccode>
      <div>
        <img src="<?=imgsrc('thumbnail-300px.png')?>" class="" alt="" />
      </div>
    </p>
    <br/>
    <p>
      Now, lets add a 2-pixel border, with the color <ccode>#881111aa</ccode>.
      <pre class="prettyprint pushup" style="color: #80AAAA;">convert screen.xwd -thumbnail 300x300 \
   -bordercolor "#881111aa" -border 2 thumbnail-border-300px.png</pre>

      <div>
        <img src="<?=imgsrc('thumbnail-border-300px.png')?>" class="" alt="" />
      </div>
    </p>

    <p>
      Let's add a nice falloff shadow, on a white background (so you can see it).
      <pre class="prettyprint pushup" style="color: #80AAAA;">convert screen.xwd -thumbnail 300x300 \
   -bordercolor "#881111aa" -border 2 \
   \( +clone -background black -shadow 100x3+2+2 \) \
       +swap -background white -layers merge +repage \
       thumbnail-border-shadow-whitebg-300px.png</pre>
      <div>
        <img src="<?=imgsrc('thumbnail-border-shadow-whitebg-300px.png')?>" class="" alt="" />
      </div>
    </p>


    <p>
      And of course, we want a transparent background, so for the sake of completeness:
      <pre class="prettyprint pushup" style="color: #80AAAA;">convert screen.xwd -thumbnail 300x300 \
   -bordercolor "#881111aa" -border 2 \
   \( +clone -background black -shadow 100x3+2+2 \) \
       +swap -background none -layers merge +repage \
       thumbnail-border-shadow-nobg-300px.png</pre>
      <div>
        <img src="<?=imgsrc('thumbnail-border-shadow-nobg-300px.png')?>" class="" alt="" />
      </div>
    </p>


    <?php heading(4, '5. Overlaying images.'); ?>
    <p>Again, <ccode>ImageMagick</ccode> comes to the rescue. <br/>Here is how
    to place <ccode>thumnail.png</ccode> on top of <ccode>image-large.png</ccode>
    at position <ccode>(100,20)</ccode>.
      <pre class="prettyprint pushup" style="color: #80AAAA;">
convert -composite image-large.png thumbnail.png \
   -geometry +100+20 imageoverlay.png</pre>
      <div>
        <img src="<?=imgsrc('imageoverlay.png')?>" class="" alt="" />
      </div>
    </p>


    <?php heading(4, '6. Executing a command every X seconds', '6. Executing every X seconds'); ?>
    <p>To execute a command every <ccode>X</ccode> seconds, you might think that <ccode>watch -n X ./foo</ccode> or perhaps
      <ccode>while sleep X; do ./foo ; done</ccode> would do a good job. And you would be
    right, assuming that<ccode>./foo</ccode> executes immediately.  When it's a
    command you want to execute repeatedly, at fixed intervals, you have to send the
    command to the background, using<ccode>&</ccode>.
    </p>

    <div class="prettyprint">
      <pre class="brush: bash;">
while sleep 1
do
    (./foo.sh &)
done
      </pre>
    </div>
    <p>This will exceute the script <ccode>./foo.sh</ccode> once every second, even if <ccode>foo.sh</ccode> takes
    several seconds to complete.</p>


    <?php heading(4, '7. Final script', true, 'script'); ?>
    <p>Putting together the various pieces mentioned so far, this is the final
    script.
    </p>
    <p>
      <div class="externgist" lang="bash" gist="8692569" file="recordscreen.sh"></div>
    </p>


    <?php heading(4, '8. Bonus - rendering video', true, 'video'); ?>
    <p>A <ccode>30 fps</ccode> video, consuming <ccode>15 frames</ccode> for each second
    in the output, can be made using <ccode>ffmpeg</ccode> with the following:
    </p>
    <div class="prettyprint">
      <pre class="brush: bash;">
ffmpeg -r 15 -i frames/%05d.png -c:v \
   libx264 -r 30 -pix_fmt yuv420p timlapsevideo.mp4
      </pre>
    </div>

    <p>While I wrote this post, I had the above script running, and this is the produced video:</p>
    <div class="youtubevid">
      <iframe src="//www.youtube.com/embed/gwNGpRiZ8qk"
              frameborder="0" allowfullscreen></iframe>
    </div>


    <div style="height:200px;" class="clear"></div>


  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebar', $data); ?>
</div>
