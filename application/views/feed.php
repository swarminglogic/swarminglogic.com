<?php
$rssBegin='<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
  <channel>
    <title>swarminglogic</title>
    <link>http://swarminglogic.com/</link>
    <description>SwarmingLogic: A programming development diary</description>
    <language><?=$lan?></language>';

echo $rssBegin;
?>
<?php

function rssItem($title, $link, $description, $pubDate) {
  $item="
    <item>
      <title>$title</title>
      <link>$link</link>
      <description>$description</description>
      <pubDate>$pubDate</pubDate>
      <guid>$link</guid>
    </item>";
  return $item;
}

foreach($articles as $key=>$value) {
    $url   = 'http://swarminglogic.com/articles/'.$key;
    $title = $value[0];
    $dateM  = $value[1][0];
    $dateD  = $value[1][1];
    $dateY  = $value[1][2];
    $summary = $value[2];
  echo rssItem($title, $url, $summary, "$dateD $dateM $dateY 00:00:00 -0000");
}

 ?>
<?php
echo '
  </channel>
</rss>';
 ?>