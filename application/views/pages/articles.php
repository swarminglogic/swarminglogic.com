<?php
$languages = array();
$data['lang'] = $languages;
$this->load->view('parser/code', $data); ?>

<div class="fifteen columns">

<ul>
<?php
  foreach($articles as $key=>$value) {
    $url   = $key;
    $title = $value[0];
    $dateM  = $value[1][0];
    $dateD  = $value[1][1];
    $dateY  = $value[1][2];
    $summary = $value[2];
    $commentCount = $value[4];
    echo '
<li class="articles">
<a href="/articles/'.$url.'" class="articlelist">
<h3 class="title">'.$title.'</h3>
<div class="date">
  <div class="dateM">'.$dateM.'</div>
  <div class="dateD">'.$dateD.'</div>
  <div class="dateY">'.$dateY.'</div>
<!--  <div class="commentCount">
    <img src="/images/comment_icon2.png"/>'.$commentCount.'
  </div> -->
</div>
<div class="summary">'.$summary.'</div>
</a>
</li>
';

}
?>
</ul>
</div>

