<?php
$languages = array("Bash", "Latex", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'Mapping the OEIS Database', false); ?>
    <p>
      <img style="width: 100%; max-width:600px;"
           src="<?=imgsrc('oeis_frequencymap2_600crop_wm.png')?>" alt="" />
      <img style="position:relative; top: -12px; border: 1px solid #777; width: 100%; max-width:598px;"
           src="<?=imgsrc('color2_ramp_598.png')?>" alt="" />
    </p>

    <?php heading(4, '1. Overview'); ?>
    <p>
      First of all, what is OEIS, and what is the image above? It certainly
      looks cool!
    </p>

    <p>
      OEIS is short for <a href="http://oeis.org/">The On-Line Encyclopedia
      of Integer Sequences</a>, and is the go-to database to look up number sequences, and find
      math papers that talk about it. E.g. the sequence <a
      href="http://oeis.org/search?q=2%2C4%2C8%2C32&language=english&go=Search"> '2,
      4, 8, 32'</a>, gives 24 results, one of which is $a(n) = 2^{\mathrm{Fibonacci}(n)}$.
      Good to know!
    </p>

    <p>
      <b>Q:</b> What happens if you use this database to <em>look up a single integer</em>?<br/>
      <b>A:</b> It returns all the sequences that contain that number
    </p>

    <p>At the time of writing...
      <ul class="pushup">
        <li>the integer <b>101</b> has
          <a href="http://oeis.org/search?q=101&sort=&language=english&go=Search">12468</a>
          entries.
        </li>
        <li>the integer <b>-340</b> has
          <a href="http://oeis.org/search?q=-340&sort=&language=english&go=Search">1545</a>
          entries.
        </li>
      </ul>
    </p>

    <p>
      In a way, the number of entries for a particular number, <em>is a
      measure for how interesting the number is.</em>
    </p>
    <p>
      As preposterous as it sounds to quantify something so subjective,
      I don't know how else to put it.
    </p>

    <p>
      Imagine you had access to all the photographs taken by humans
      (pretend you're the NSA), and you counted all images where an apple
      was depicted, and counted all images where sharks were depicted. You
      could, in a sense, use this number as a relative measure for how
      interesting apples and sharks are (as the object of photography).
    </p>

    <p>
      The second question -- the image above? It is a plot of the
      relative OEIS occurrence frequency, of each integer from -125 000 to +125
      000 (not exactly, but close enough).

      Structured in a snake-like pattern with 0 in the center, positive values
      growing in the top half, and corresponding negative values mirrored in the
      lower half (see below).
    </p>


    <?php heading(4, '2. Plotting the Data'); ?>
    <div class="eight columns alpha">
      <p>
      Initially I only looked at the positive integers, and had structured them
      in a spiral, wrapping around itself, clockwise.
      </p>
      <p>
      Then I considered the negative integers as well, and the only
      meaningful way to lay out the numbers in a 'spiral like' way, was the
      the following:
      </p>
    </div>
    <div class="four columns omega">
      <p><img src="<?=imgsrc('snakepattern2_small.png')?>" alt="" /></p>
    </div>
    <div class="clear"></div>

    <p>The actual value plotted, $p_i$, for each integer, $x_i$, is:</p>
    <p>
      <div class="pushup offset-by-one">
        $M = \log(\mathrm{max}(x_i + 1))$</br>
        $p_i = M^{-1}\log (x_i + 1)$</br>
      </div>
    </p>
    <p>Using this color ramp to map the values from 0 to 1:</p>
    <p class="pushup offset-by-one">
      <img style="border: 1px solid #777; width: 100%; max-width:500px;"
           src="<?=imgsrc('color2_ramp_598.png')?>" alt="" />
    </p>
    <p>Which was created by linearly interpolating between the following HSL values:
      <pre class="pushup offset-by-one">|------+-----+-----+------|
|  Val |   H |   S |    L |
|------+-----+-----+------|
| 0.00 | 241 | 0.3 | 0.0  |
| 0.07 | 241 | 0.4 | 0.33 |
| 0.15 | 209 | 0.4 | 0.5  |
| 0.20 | 169 | 0.5 | 0.6  |
| 0.25 | 125 | 0.6 | 0.72 |
| 0.30 |  65 | 0.9 | 0.6  |
| 0.61 |  14 | 0.8 | 0.6  |
| 0.81 |   0 | 0.7 | 0.8  |
| 1.00 |   0 | 0.4 | 1.0  |
|------+-----+-----+------|</pre>
      <?php heading(4, '3. Acquiring the Data'); ?>
      <p>
        The quickest way I know to do this, is writing a <code>bash</code>-script using <code>curl</code>
        to get the html page, and unix tools <code>sed</code> and <code>head</code> to extract the value.
      </p>
      <?=shBegin('bash', 'gutter:true;')?>
function getnresults() {
    v=`curl --silent "http://oeis.org/search?q=$1" \
         | grep -P '\d result(s|\s)'               \
         | head -n1                                \
         | sed 's/.*Found\s//g'                    \
         | sed 's/.*of\s//g'                       \
         | sed 's/\s.*//g'`
    [[ $v ]] && echo $v || echo 0
}<?=shEnd()?>
      <table class="prettyprint lines">
        <tr><td><b>Line 2:</b></td><td>Gets the HTML source for the OEIS page.</td></tr>
        <tr><td><b>Line 3:</b></td><td>Extracts all lines containing <code>result</code> or <code>results</code></td></tr>
        <tr><td><b>Line 4:</b></td><td>Ignores all matches except the first.</td></tr>
        <tr><td><b>Line 5-7:</b></td><td>Isolates the value of interest.</td></tr>
        <tr><td><b>Line 8:</b></td><td>Returns the value, or <code>0</code> if no results were found.</td></tr>
      </table>

      <?php heading(5, 'Parallelizing Queries', false); ?>
      <div class="six columns alpha">
        <p class="">
        The goal was to get to a <code class="clean">1000 x 1000</code> image.
        </p>
        <p>
        Using the above function in a large <code class="clean">for</code>-loop, it would have taken around <b>50 days</b>.
        If running separately for positive and negative values, 25 days.
        </p>
        <p>
        A better parallelized version was written,
        and can be found in this <a href="https://gist.github.com/swarminglogic/6241381">github gist</a>
        , reducing it to a couple of days. Here it is in action:
        </p>
        <p>
          <b>NB:</b> If you live in the US, think carefully before running such a script. Apparently, making HTTP requests with
        modified URLs could be <a href="http://opinionator.blogs.nytimes.com/2013/04/13/hacktivists-as-gadflies/">a criminal
        offense</a>. <code>&lt;/tongueincheek&gt;</code>
        </p>
      </div>
      <div class="six columns omega pushup">
        <?php gifimage("oeis.ff.png", "oeis.opt.gif") ?>
      </div>
      <div class="clear"></div>
      <?php heading(4, '4. Creating the Image'); ?>
      <p>
        The best tool for generating the image would be processing, octave, matlab,
        gnuplot, or any other language with a library for pixel manipulation in
        images, or advanced 2D plotting.
      </p>

      <p>
        I would definitely not recommend my choice: C++ and SDL. But hey, that's what I'm
        trying to learn these days, so why not? Here is the final image
        (<a href="<?=imgsrc('oeis_frequencymap2_wm.png')?>">click for full resolution</a>),
        with over 1.4 million values from the OEIS database.
      </p>
      <p class="pushup">
        <a href="<?=imgsrc('oeis_frequencymap2_wm.png')?>"  data-lightbox="oeis"
           data-title="Visualization of extracted OEIS Data" >
          <img style="border: 1px solid #444; width: 100%; max-width:600px;"
               src="<?=imgsrc('oeis_frequencymap2_600.png')?>" />
        </a>
      </p>

      <p>
         I'm also learning <a href="http://www.blender.org/">Blender</a>, so
         here you have a 3D plot using the values as a displacement map.</p>
      <p>
        <a href="<?=imgsrc('oeis_blender_far2_wm.png')?>" data-lightbox="oeis"
           data-title="Blender visualization of OEIS Data" >
          <img style="width: 100%; max-width:600px;" src="<?=imgsrc('oeis_blender_far2_600.png')?>" />
        </a>
        <a href="<?=imgsrc('oeis_blender_closeup_wm.png')?>" data-lightbox="oeis"
           data-title="Blender visualization of OEIS Data (closeup)" >
          <img style="width: 100%; max-width:600px;" src="<?=imgsrc('oeis_blender_closeup_600.png')?>" />
        </a>
      </p>

      <p>
      </p>

      <?php heading(4, '5. Thoughts & Conclusions'); ?>
      <p>
        There are three things that surprised me about the data:
      </p>
      <p>
        <ol>
          <li>
        The sudden drop in entries for positive values. The first explanation
        that comes to mind is that the OEIS database itself limits the number of
        searchable entries for any given sequence. Many sequences like "natural
        numbers", "even numbers", "odd numbers", would mean that no integers
        should have zero entries, yet, this is not the case.
          </li>
          <li>
            <div class="row">
              <div class="seven columns alpha">
                <p>
        There is a peak for values ranging from around, let's see <em>*crunches some numbers*</em>
                  <code>1970</code>, to ...<em>*crunches even more numbers*</em> <code>2013</code>.
                </p>
                <p>
                  <em>*facepalm*</em> Apparently I also searched the meta-data, and most
        sequences have references to findings and papers between <code>1970-2013</code>.
                </p>
              </div>
              <div class="two columns omega">
                <img src="<?=imgsrc('oeis_anom_2.png')?>" class="" alt="" />
              </div>
            </div>
            <div class="clear"></div>
          </li>
          <li class="pushup">
            <p>
        The peaks close to the diagonals and "y-axis". I have no idea why they
        occur. Ironically, the integer sequences that correspond to the
        diagonals, are not themselves registered in the database.
            </p>
            <p>
        The sequence corresponding to "y-axis", <code>0, 1, 8, 17, 32, 49</code>,
        is registered as <a href="http://oeis.org/A077221">A077221</a>.
            </p>
            <p>
        This means that the sequence corresponding to the diagonal in the first,
        second, third, and fourth quadrants are ($a_1$, $a_2$, $a_3$, $a_4$, respectively):
        $$\begin{aligned}
          a_1(n) & = A_{077221}(n) - (-1)^{n} n \\
          a_2(n) & = A_{077221}(n) + (-1)^{n} n \;\;\;\;\;\text{(offset by 1)} \\
          a_3(n) & = -a_2(n)                    \\
          a_4(n) & = -a_1(n)
        \end{aligned}$$
            </p>
          </li>
        </ol>
      </p>
      <hr class="soft"/>
      <p>
        Lastly, I should point out that I didn't do this because I considered it important or valuable.
        It just seemed like a fun thing to do. I hope you enjoyed.
      </p>
      <p><b>PS:</b> If there is any interest, I'll upload the raw data.</p>

      <div style="height:200px;" class="clear"></div>
  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebar', $data); ?>
</div>
