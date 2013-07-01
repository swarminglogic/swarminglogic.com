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
  <p>
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
    }
    if (isset($showComments) && $showComments) {
      echo '<hr/>';
      echo '<li><a href="#toc-comments">Comments</a></li>';
    }
 ?>
  </ul>
  </p>
  <?php echo $sidebar_text;

  if (isset($cclicense)) {
    $cclicense=strtolower($cclicense);
    $licenseUrl='';
    $isLicenseOk=true;
    if ($cclicense == 'by'       ||
        $cclicense == 'by-nd'    ||
        $cclicense == 'by-sa'    ||
        $cclicense == 'by-nc'    ||
        $cclicense == 'by-nc-sa' ||
        $cclicense == 'by-nc-nd') {
      $licenseUrl='http://creativecommons.org/licenses/'.$cclicense.'/3.0';
    } else {
      $isLicenseOk = false;
      trigger_error('Invalid license type: '.$cclicense);
    }

    if ($isLicenseOk) {
      echo '<h5 class="license">License</h5>';
      echo '<a href="'.$licenseUrl.'">';
      echo '<img src="/images/licenses/'.$cclicense.'-flat.png"/></a>';
    }
  }
?>
</div>
