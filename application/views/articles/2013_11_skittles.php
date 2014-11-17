<?php
$languages = array("CSharp");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'Image Processing - Detecting Skittles in Images', false); ?>
    <p>
    The goal of this short project (one week) was to automatically extract
    information from images of skittles on desaturated backgrounds. In
    particular: position, radius and hue of each skittle, as well as grouping
    and counting skittles based on color.
    </p>

    <div class="six columns alpha">
      <p><small>Example input image</small>
        <a href="<?=imgsrc('input3_full.png')?>" data-lightbox="overview"
          data-title="Example input image">
          <img src="<?=imgsrc('input3_300px.png')?>" alt="" />
        </a>
      </p>
    </div>
    <div class="six columns omega">
      <p><small>Final detection + visualization</small>
        <a href="<?=imgsrc('finalviz_full.png')?>" data-lightbox="overview"
           data-title="Final detection + visualization">
          <img src="<?=imgsrc('finalviz_300px.png')?>" alt="" />
        </a>
      </p>
    </div>
    <div class="clear"></div>


    <p>
    This work done as part of a project in a course at
      <a href="http://www.ntnu.edu/">NTNU</a> (university in Trondheim, Norway),
    which I'm taking for the fun of it. For a video demo, see below in the
      <a href="#visualization">visualization section</a>.
    </p>

    <p>The code was written using <ccode>C++</ccode>,
      <a href="http://opencv.org/"><code>OpenCV</code></a>,
      <a href="http://libsdl.org/"><code>SDL2</code></a>. For the graphics framework,
      <a href="/jotting/2013_10_gamedev01">this write-up</a> might be of interest.
    </p>

    <?php heading(4, '1. Object Segmentation'); ?>
    <div class="pushup">
      <?php heading(5, '1.1 Saturation Thresholding'); ?>
    </div>
    <p>
      Initial segmentation takes advantage of the assumption that backgrounds
    are dissaturated, and objects of interest are saturated. The input image is
    converted to the <?=wiki('HSL_and_HSV', 'HSV color space')?>,
    followed by applying <?=wiki('Gaussian_blur','Gaussian blur')?>
    and binary <?=wiki('Thresholding_(image_processing)','thresholding')?>
    to the saturation channel.
    </p>

    <div class="six columns alpha">
      <p><small>Source</small><br/>
        <a href="<?=imgsrc('01-input1.png')?>" data-lightbox="objsegment"
           data-title="Source Image">
          <img src="<?=imgsrc('01-input1_300px.png')?>" alt="" />
        </a>
      </p>
    </div>
    <div class="clear"></div>

    <div class="six columns alpha">
      <p><small>HSV hue channel</small><br/>
        <a href="<?=imgsrc('01-hue-channel.png')?>" data-lightbox="objsegment"
           data-title="HSV hue channel">
          <img src="<?=imgsrc('01-hue-channel_300px.png')?>" alt="" />
        </a>
      </p>
    </div>
    <div class="six columns omega">
      <p><small>+ blur and threshold</small><br/>
        <a href="<?=imgsrc('01-hue-threshold.png')?>" data-lightbox="objsegment"
           data-title="HSV hue + blur + threshold">
          <img src="<?=imgsrc('01-hue-threshold_300px.png')?>" alt="" />
        </a>
      </p>
    </div>
    <div class="clear"></div>

    <p>There is some left over clutter from the binary thresholding.
    This is mitigated using <?=wiki('Distance_transform', 'distance transform')?>.
    </p>

    <?php heading(5, '1.2 Distance Transform'); ?>
    <p>Distance transform takes in a binary image and replaces all white pixels
    with the distance to the closest black pixel. There are many ways to define
    distances, some which allow for faster algorithms. The most accurate for the
    application here is the Euclidean distance, which has been used (rather, a
    good approximation of it).</p>

    <div class="six columns alpha">
      <p><small>Distance Transform</small><br/>
        <a href="<?=imgsrc('02-distance-transform.png')?>" data-lightbox="objsegment"
           data-title="HSV hue + blur + threshold + distance transform">
          <img src="<?=imgsrc('02-distance-transform_300px.png')?>" alt="" />
        </a>
      </p>
    </div>
    <div class="six columns omega">
      <p><small>Threshold pass</small><br/>
        <a href="<?=imgsrc('02-distance-transform-threshold.png')?>" data-lightbox="objsegment"
           data-title="HSV hue + blur + threshold + distance transform + threshold pass">
          <img src="<?=imgsrc('02-distance-transform-threshold_300px.png')?>" alt="" />
        </a>
      </p>
    </div>
    <div class="clear"></div>

    <p>By applying a threshold pass (values above threshold are preserved, all
    lower set to zero) with a "minimum skittle radius allowed", in effect, all
    blobs with a radius smaller than this value are removed.</p>

    <p><small>Closeup</small><br/>
      <img src="<?=imgsrc('03-disttrans_closeup.png')?>" class="" alt="" />
    </p>

    <p>The peaks correspond to the skittles' center, and the value is a good
    estimate for the skittles' radius. The next step is therefore to isolate the
    peaks (local maxima).</p>


    <?php heading(4, '2. Isolating Peaks'); ?>
    <p>Below, the series of operations performed to isolate the local
    maxima is shown:<br/>
    </p>
    <div class="">
      <div class="two columns alpha">
        <p><small><b>A:</b> Dist.trans.</small><br/>
          <img src="<?=imgsrc('03-disttrans.png')?>" alt="" />
        </p>
      </div>
      <div class="two columns">
        <p><small><ccode>1.</ccode><b>B:</b> Dilation</small><br/>
          <img src="<?=imgsrc('03-dilated.png')?>" alt="" />
        </p>
      </div>
      <div class="two columns">
        <p><small><ccode>2.</ccode><b>B</b> - <b>A</b></small><br/>
          <img src="<?=imgsrc('03-dilated-sub.png')?>" alt="" />
        </p>
      </div>
      <div class="two columns">
        <p><small><ccode>3.</ccode>Thresholded</small><br/>
          <img src="<?=imgsrc('03-dilated-sub-thresh.png')?>" alt="" />
        </p>
      </div>
      <div class="two columns omega">
        <p><small><ccode>4.</ccode>Isolated peaks</small><br/>
          <img src="<?=imgsrc('03-peaks.png')?>" alt="" />
        </a>
        </p>
      </div>
      <div class="clear"></div>
    </div>

    <p>
      <b><ccode>1.</ccode></b>
      The morphological <?=wiki('Dilation_(morphology)','dilation operation')?>
      replaces values with the maximum of nearby values. In effect, this brings
     the peaks' surrounding pixels up to the same height as the peak.
    </p>
    <p>
      <b><ccode>2.</ccode></b>
      By subtracting the distance transform from the dilation result, only the
      peak pixels have a <ccode>0</ccode> value. Everything else is greater than
      <ccode>0</ccode>.
    </p>
    <p>
      <b><ccode>3.</ccode></b>
      Since only the peak pixels have <ccode>0</ccode> value, they can be isolated with
      binary thresholding.
    </p>
    <p>
      <b><ccode>4.</ccode></b>
      Filling the background gives the desired result: An image with the local
    maxima isolated.
    </p>

    <?php heading(4, '3. Determining Skittle Location & Radius'); ?>
    <p>Some skittle configurations cause problems in the segmentation, and is
    the rationale for the two-phase approach described in this section. Note
    the false peak in the example below:</p>

    <div class="offset-by-one">
      <div class="two columns alpha">
        <p><small>Source</small><br/>
          <img src="<?=imgsrc('04-eg2-src.png')?>" alt="" />
        </p>
      </div>
      <div class="two columns">
        <p><small>Dist.transf.</small><br/>
          <img src="<?=imgsrc('04-eg2-disttrans.png')?>" alt="" />
        </p>
      </div>
      <div class="two columns omega">
        <p><small>Peaks</small><br/>
          <img src="<?=imgsrc('04-eg2-peaks.png')?>" alt="" />
        </p>
      </div>
      <div class="clear"></div>
    </div>

    <p>
      Determining the peak locations is done by traversing the peak image. Upon
    hitting a black pixel, and the location is stored. To avoid adjacent hits,
    surrounding pixels (within a determined radius) are set to white.
    </p>

    <div class="offset-by-one">
      <div class="two columns alpha">
        <p><small>1st pass</small><br/>
          <img src="<?=imgsrc('04-eg2-1st-pass.png')?>" alt="" />
        </p>
      </div>
      <div class="two columns omega">
        <p><small>2nd pass</small><br/>
          <img src="<?=imgsrc('04-eg2-2nd-pass.png')?>" alt="" />
        </p>
      </div>
      <div class="clear"></div>
    </div>

    <p>
    In the <b>first pass</b>, the radius used is the "minimum allowed skittle
    radius" (the same as was used before). This radius is shown above in blue
    circles. The false peak is also included.
    </p>

    <p>The skittle radius corresponding to the peak is found from the distance
  transform image. By sorting these radii, the median skittle radius is found.
    </p>
    <p>
    In the <b>second pass</b>, the same traversal is repeated, except now using
      <ccode>1.5 * median_skittle_radius</ccode> when filling pixels.
   This is shown above in red circles. Note that the false peak is ignored.
    </p>

    <?php heading(4, '4. Determining Skittle Hue'); ?>
    <p>Since we now have all skittle locations and radii, it is possible to
    extract pixels corresponding to each individual skittle. We do this from the
    HSV hue channel, and average the hues for each skittle.
    </p>
    <p>It is important to note that hues are circular values, if you will, and
care must be taken when averaging them. Think of the hue as just an angle. Both
      <ccode>0°</ccode> and <ccode>360°</ccode> correspond to the same hue (red),
    and averaging them naively gives <ccode>180°</ccode>
    (turquoise).
      <?=wiki('Mean_of_circular_quantities', 'This is the correct way to do it')?>.
    </p>


    <?php heading(4, '5. Hue Clustering'); ?>
    <div class="six columns alpha pushdown">
      <p>
      By plotting the individual skittle hues from various input test images, it
      became clear that this was a fairly robust and accurate way of determining
      the skittle hues.
      </p>
      <p>The clear clustering allowed a very simple algorithm for clustering the hues:</p>
      <div  style="padding-left:1em;" class="prettyprint">
        <?=shBegin('csharp', 'gutter:false;')?>
        # Pseudocode
        sort(hues)
        foreach hue:
        if ( {distance to previous hue} < threshold)
          addHueToCurrentClusterGroup()
        else
          createNewClusterGroup()
          addHueToCurrentClusterGroup()
        <?=shEnd()?>
      </div>
    </div>
    <div class="offset-by-one five columns omega">
      <p><small>Polar plot of skittle hues from <a href="<?=imgsrc('input3_full.png')?>">test image.</a></small><br/>
        <img src="<?=imgsrc('05_hues.png')?>" alt="" />
      </p>
    </div>
    <div class="clear"></div><p></p>

    <p >
      Another, more contrived way of clustering the hues, is
      <?=wiki('Jenks_natural_breaks_optimization', 'Jenks Natural Breaks Optimization')?>.
    </p>

    <?php heading(4, '6. Visualization', true, 'visualization'); ?>
    <p>Visualization is done by rendering skittle-shaped ellipsoid meshes in a
virtual scene. The skittles are rendered in the relative positions and sizes as
found by the image processing part.</p>

    <p>Here is a quick demo:</p>
    <p class="pushup">
      <div class="youtubevid">
        <iframe src="//www.youtube.com/embed/A1wwIGQBIeo"
                frameborder="0" allowfullscreen></iframe>
      </div>
    </p>

    <div style="height:300px;" class="clear"></div>
  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebar', $data); ?>
</div>
