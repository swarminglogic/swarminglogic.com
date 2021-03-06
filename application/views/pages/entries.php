<?php
$languages = array();
$data['lang'] = $languages;
$this->load->view('parser/code', $data); ?>

<div class="fifteen columns">
  <?php
  if ($isKeywordFiltering) {?>
  <div class="prettyprint keywordFilterNotice">
      Showing <code class="clean"><?=$entryCount?></code>
    <?=$entryCount>1?$types:$type?>
      with tag
    <a href="#" pp="<?=$keydesc[$keywordUsed]?>" class="tooltip">
      <span class="keyword"><?=$keywordUsed?></span>
    </a>
  </div>
  <?php
  }
  echo '<ul class="articleCollection">';
  foreach($entries as $key=>$value) {
    $url   = '/'.$type.'/'.$key;
    $title = $value[0];
    $dateM  = $value[1][0];
    $dateD  = $value[1][1];
    $dateY  = $value[1][2];
    $summary = $value[2];
    $keywords = $value[3];
    echo '
<li class="articles">
  <div class="thumbnail">
    <a href="'.$url.'">
      <img src="/images/entries/'.$key.'/thumbnail-'.$key.'.png"/>
    </a>
  </div>
  <a href="'.$url.'" class="articlelist">
    <div class="date">
      <div class="dateD">'.$dateD.'</div>
      <div class="dateM">'.$dateM.'</div>
      <div class="dateY">'.$dateY.'</div>
    </div>
    <h3 class="title">'.$title.'</h3>
    <div class="summary">'.$summary.'</div>
  </a>
  <div class="keywords">';
    foreach($keywords as $k) {
      echo '<a href="/'.$types.'/'.$k.'" pp="'.$keydesc[$k].'" class="tooltip">
        <span class="keyword">'.
            $k.
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
