<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'Picture-in-picture timelapse of dual monitors','Top',true); ?>

    <p>A few months ago, <a href="2014_01_screenrecord">I wrote a post </a> on
    how to do a picture-in-picture timelapse recording when dealing with a dual
    monitor setup where each monitor has its own separate X display.</p>

    <p>Long story short, after a harddrive failure forcing me to reconfigure my
    linux setup, I went away from the dual X screen setup, to a single X display
    spanning the two montiors. </p>
    <p>
    This means that a screen dump using <ccode>xwd -root -out screenshot.xwd</ccode>
    produces a single image of both monitors side-by-side. This also means the
    script I wrote for the previous post no longer works. A rewrite was in
    order to deal with the new setup, and that's what this post is for.
    </p>
    <p>I'll keep this post short with only the <a href="#script">script</a> and a
      <a href="#video">demo recording</a> (a timelapse made while writing this post).
      For an explanation of the <ccode>ImageMagic</ccode> magic, see the
      <a href="2014_01_screenrecord">previous post</a>.
    </p>
    </p>

    <?php heading(4, '1. Script', '', true, 'script'); ?>
    <p>Putting together the various pieces mentioned so far, this is the final
    script.
    </p>
    <p>
      <div class="externgist" lang="bash" gist="8692569" file="recordscreenalt.sh"></div>
    </p>

    <?php heading(4, '2. Demo', '', true, 'video'); ?>
    <p>
      If the above script for some reason skips a frame, this will cause
      problems when creating a video from them. A quick fix is to create a
      symlink to the previous file, for any missing frame.
    </p>
    <div class="prettyprint">
      <pre class="brush: bash;">
#!/bin/bash
lastFrame=`ls -1 frames/ | tail -n 1`
nframes=`echo ${lastFrame%.*} | sed 's/^0*//'`

for i in $(seq 1 1 $nframes)
do
    curr=`printf '%.5d.png' $i`
    prev=`printf '%.5d.png' $((i-1))`
    if [ ! -e frames/$curr ] ; then
       echo "$prev -> $curr"
       ln -s $prev frames/$curr
    fi
done
      </pre>

      <p>A <ccode>30 fps</ccode> video, consuming <ccode>15 frames</ccode> for each second
    in the output, can be made using <ccode>ffmpeg</ccode> with the following:
      </p>
      <div class="prettyprint">
        <pre class="brush: bash;">
ffmpeg -r 15 -i frames/%05d.png -c:v \
   libx264 -r 30 -pix_fmt yuv420p timelapsevideo.mp4
        </pre>
      </div>

      <p>While I wrote this post, I had the screen recording script running, and
      this is the produced video:</p>
      <div class="youtubevid">
        <iframe src="//www.youtube.com/embed/BWmjgwkdgkc"
                frameborder="0" allowfullscreen></iframe>
      </div>


    <div style="height:200px;" class="clear"></div>


  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebars/sb_jotting', $data); ?>
</div>
