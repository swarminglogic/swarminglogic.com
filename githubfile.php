<?php
//
// Page that allows loading files from external domain (gist.github.com)
// For usage with asynchronus loading with JS.
// Example: /gist.php?gist=5623057&file=autobuild.sh
//

header('Content-type: text/plain');
$url = 'https://raw.githubusercontent.com/swarminglogic/'.$_GET["repo"].'/'.$_GET["branch"].'/'.$_GET["file"];
$handle = fopen($url, "r");
if ($handle) {
  while (!feof($handle)) {
    $buffer = fgets($handle, 4096);
    echo $buffer;
  }
  fclose($handle);
}
?>
