<?php
$show_date = false;
if (isset($articles) && array_key_exists($page, $articles)) {
  $show_date = true;
  $dateM = $articles[$page][1][0];
  $dateD = $articles[$page][1][1];
  $dateY = $articles[$page][1][2];
} else if (isset($jottings) && array_key_exists($page, $jottings)) {
  $show_date = true;
  $dateM = $jottings[$page][1][0];
  $dateD = $jottings[$page][1][1];
  $dateY = $jottings[$page][1][2];
}

if($show_date) {
  echo '
<div class="articledate">
  <div class="dateM">'.$dateM.'</div>
  <div class="dateD">'.$dateD.'</div>
  <div class="dateY">'.$dateY.'</div>
</div>
';
}

?>
