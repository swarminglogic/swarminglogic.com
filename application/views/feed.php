<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
   xmlns:admin="http://webns.net/mvcb/"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:content="http://purl.org/rss/1.0/modules/content/">

   <channel>
   <title>swarminglogic.com</title>
   <link>http://swarminglogic.com-</link>
   <description>SwarmingLogic: A software developer\'s notes</description>
   <language>en-en</language>
   <creator>contact@swarminglogic.com</creator>

<?php

function rssItem($title, $link, $description, $pubDate) {
  $item="
    <item>
      <title>$title</title>
      <link>$link</link>
      <description>".$description."</description>
      <pubDate>$pubDate</pubDate>
      <guid>$link</guid>
    </item>";
  return $item;
}
      /* <description><![CDATA[ ".character_limiter($description, 200)." ]]></description> */

foreach($articles as $key=>$value) {
    $url   = 'http://swarminglogic.com/article/'.$key;
    $title = "[Article] ".strip_tags($value[0]);
    $dateM  = str_replace(array(' ','&nbsp;'),'',$value[1][0]);
    $dateD  = str_replace(array(' ','&nbsp;'),'',$value[1][1]);
    $dateY  = $value[1][2];
    $summary = $value[2];
  echo rssItem($title, $url, $summary, "$dateD $dateM $dateY 00:00:00 -0000");
}

foreach($jottings as $key=>$value) {
    $url   = 'http://swarminglogic.com/jotting/'.$key;
    $title = "[Jotting] ".strip_tags($value[0]);
    $dateM  = str_replace(array(' ','&nbsp;'),'',$value[1][0]);
    $dateD  = str_replace(array(' ','&nbsp;'),'',$value[1][1]);
    $dateY  = $value[1][2];
    $summary = $value[2];
  echo rssItem($title, $url, $summary, "$dateD $dateM $dateY 00:00:00 -0000");
}


 ?>

    </channel>
</rss>
