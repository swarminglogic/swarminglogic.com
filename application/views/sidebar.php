<div id="sidebar_id" class="four columns">
  <p></p>
  <h5>Table of Contents</h5>
  <ul id="toc">
   <li class=""><a href="#wrapper"><nowrap>Top</nowrap></a>
    <?php foreach($toc as $key => $value) {
     /* $size = ' style = "font-size: '.(($value[1] == 5)?14:17).'px;" '; */
     $subTxt = ($value[1] == 5) ? " sub" : "";
      if ($key=='0') {
        echo "<li class=\"active$subTxt\"><a href=\"#$value[0]\"><nowrap>$value[2]</nowrap></a></li>
";
      }
      else {
        /* $value[0]: toc1,   toc2  :: anchor name
        $value[1]: 1,2,3, weight :: (h1, h2, etc.)
        $value[2]: Title, title  :: Header title content */
        echo "<li class=\"$subTxt\"><a href=\"#$value[0]\"><nowrap>$value[2]</nowrap></a></li>
";
      }
    }
    if (isset($showComments) && $showComments) {
      echo '<hr/>';
      echo '<li><a href="#toc-comments">Comments</a></li>';
    }
 ?>
  </ul><br/>
<?php
  if (isset($entry) && sizeof($entry[3]) > 0) {
    echo '<h5>Tags</h5>';
    echo '<p>';
    $c = 0;
    foreach($entry[3] as $v) {
      ++$c;
      echo '<a style="font-size: 12px;display: inline-block;
                      padding-bottom: 10px; padding-right: 3px"
        href="/'.$types.'/'.$v.'" pp="'.$keydesc[$v].'" class="tooltip">
        <span style="color:#9AA;" class="keyword">'.
        $v.
        '</span></a>';
    }
  }
?>

<h5>Newsletter</h5>
<div id="mc_embed_signup">
      <div class="mc_icon">
        <img src="/images/mailchimp.png" title="powered by mailchimp.com" class=""/>
      </div>
      <form
        action="http://swarminglogic.us7.list-manage.com/subscribe/post?u=f13ab70a2e3ac42e709661334&amp;id=cf7cf2a3e0"
        method="post"
        id="mc-embedded-subscribe-form"
        name="mc-embedded-subscribe-form"
        class="validate"
        target="_blank" novalidate>

  <div class="tooltip" pp="Sign up to the swarminglogic.com newsletter,
and receive e-mails when new posts are published. (powered by mailchimp)">
	<input
      type="email" value="" name="EMAIL"
      class="email"
      id="mce-EMAIL"
      placeholder="email address" required>
  <input type="submit" value="ok"
      name="subscribe" id="mc-embedded-subscribe" class="btn btn-info">
  </div>
</form>
</div>

  <?php echo $sidebar_text;

  // TODO swarminglogic, 2013-08-18: Refactor license. DRY:'sb_jottings.php'
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
    } else if ($cclicense == 'zero') {
      $licenseUrl='http://creativecommons.org/publicdomain/mark/1.0/';
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
