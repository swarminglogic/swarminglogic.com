<div id="sidebar_id" class="four columns">
  <?php
   $sidebar_showSummary = false;
   if(in_array($page, $articles)) {
     $article_summary = $articles[$page][2];
     $sidebar_showSummary  = $articles[$page][3];
   }
/*
  if($sidebar_showSummary and sizeof($article_summary) > 0) {?>
  <div class="sidebar">
    <h5>Summary</h5>
    <?php echo $article_summary; ?>
  </div>
  <br/>
  <?php }*/?>

  <h5>Table of Contents</h5>
  <ul id="toc">
    <?php foreach($toc as $key => $value) {
      if ($key=='0') {
        echo "<li class=\"active\"><a href=\"#$value[0]\">$value[2]</a></li>
";
      }
      else {
        /* $value[0]: toc1,   toc2  :: anchor name
        $value[1]: 1,2,3, weight :: (h1, h2, etc.)
        $value[2]: Title, title  :: Header title content */
        echo "<li><a href=\"#$value[0]\">$value[2]</a></li>
";
      }
    } ?>
  </ul>
  <br/>
  <?php echo $sidebar_text;?>
</div>
