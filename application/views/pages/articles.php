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
    $keywords = $value[3];
    echo '
<li class="articles">
  <a href="/articles/'.$url.'" class="articlelist">
    <h3 class="title">'.$title.'</h3>
    <div class="date">
      <div class="dateM">'.$dateM.'</div>
      <div class="dateD">'.$dateD.'</div>
      <div class="dateY">'.$dateY.'</div>
    </div>
    <div class="summary">'.$summary.'</div>
  </a>
  <div class="keywords">';
    foreach($keywords as $value) {
      echo '<a href="#" pp="'.$keydesc[$value].'" class="tooltip">
        <span class="keyword">'.
        $value.
        '</span></a>';
    }
echo '
  </div>
</li>
';

}
?>
</ul>
</div>

