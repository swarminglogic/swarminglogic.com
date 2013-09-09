<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'zero';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'Automatic Watermarking of Images','Top',false); ?>
    <p>
    </p>

    <?php heading(4, '1. Overview'); ?>
    <p>
    </p>

    <?php heading(4, '2. Configuring Fonts for <code>ImageMagick</code>', '2. Configuring Fonts'); ?>

    <?php heading(4, '3. Simple Examples'); ?>
    <p>
    </p>

    <?php heading(4, '4. Bash script'); ?>
    <p>
    </p>

    <?php heading(4, '5. Thoughts & Conclusions'); ?>
    <p>
    </p>
  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebars/sb_jotting', $data); ?>
</div>
