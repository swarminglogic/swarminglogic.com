<?php
$rssBegin='<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
  <channel>
    <title>swarminglogic</title>
    <link>http://swarminglogic.com/</link>
    <description>SwarmingLogic: A programming development diary</description>
    <language>en</language>';


$content='';

/*
<item><title>Balloon Internet</title><link>http://xkcd.com/1226/</link><description>&lt;img src="http://imgs.xkcd.com/comics/balloon_internet.png" title="I run a business selling rural internet access. My infrastructure consists of a bunch of Verizon wifi hotspots that I sign up for and then cancel at the end of the 14-day return period." alt="I run a business selling rural internet access. My infrastructure consists of a bunch of Verizon wifi hotspots that I sign up for and then cancel at the end of the 14-day return period." /&gt;</description><pubDate>Mon, 17 Jun 2013 04:00:00 -0000</pubDate><guid>http://xkcd.com/1226/</guid></item>
*/


echo $rssBegin;

?>
<?php
$content='';

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

echo $content;
 ?>
<?php
echo '
  </channel>
</rss>';
 ?>