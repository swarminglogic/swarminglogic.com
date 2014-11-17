<?php
$GLOBALS['page'] = $page;
/*
 * Use to get image source from folder structure images/articles/$page/$filename
 *
 * @param  string $filename Image filename
 * @param  string $page     Article page id
 * @param  string $prefix   Optional prefix, defaults to '/'.
 * @return string           Image source path, based on the article id.
 */
function imgsrc($filename, $prefix='/') {
  global $page;
  return $prefix.'images/entries/'.$page.'/'.$filename;
}


/*
 * Outputs html code to wrap an animated gif which plays onclick,
 * and until then displays a still image, with a semi-transparent
 * pattern overlayed with the message "Click to play".
 *
 * @param  string $firstFrameFile Filename of first frame image.
 * @param  string $gifFile        Filename of gif to be played.
 * @param  string $page           Article page id
 */
function gifimage($firstFrameFile, $gifFile) {
  global $page;
  $imgfolder='/images/entries/'.$page.'/';

  $size=getimagesize(imgsrc($firstFrameFile, ''));
  $width=$size[0];

  echo '<div class="gifimage noplay">';
  echo '<img width="100%" style="max-width: '.$width.'px" src="'.$imgfolder.$firstFrameFile.'" ';
  echo "onclick=\"gifClicked(this, '".$imgfolder.$gifFile."' )\"/>";
  echo '<div style="max-width: '.$width.'px;" class="gifplaybox" ';
  echo "onclick=\"gifScreenClicked(this, '".$imgfolder.$gifFile."')\"";
  echo '><div class="gifplaytext">Click to play</div></div>';
  echo '</div>';
}

/*
 * Util function for creating headings in the article.
 * It registers headings with ids, so that they can added to the
 * table of contents in the sidebar, automatically.
 *
 * Example use -> ToC result
 * heading (5. "1.BLABLA")           -> 1.BLABLA
 * heading (5. "1.BLABLA", true)     -> 1.BLABLA
 * heading (5. "1.BLABLA", false)    ->
 * heading (5. "1.BLABLA", "2.fooo") -> 1.fooo
 *
 * Optionals:
 *  # Alternate title can be set for the ToC.
 *  # ToC registering is optional
 *  # An alternate id is also possible for animated scrolling.
 *
 * @param  int         $wght   The header weight, 1,2,..,5 corresponding to h1,h2,..,h5
 * @param  string      $text   Header title.
 * @param  bool/string $tocEntry False:    Entry is omitted from toc
                                 True:     ToC entry is same as $text
                                 [string]: ToC entry is set to [string]
 * @param  string      $altid  Alternative id, use for linking within article.
 */
function heading($wght, $text, $tocEntry=true, $altid='') {
  $intoc = true;
  if (is_bool($tocEntry)) {
    if ($tocEntry) {
      $alttoc = $text;
    } else {
      $intoc = false;
    }
  } else {
    $alttoc = $tocEntry;
  }

  if ($intoc) {
    global $toc;
    global $tocCount;
    $tocCount = $tocCount + 1;
    $id= empty($altid) ? "toc$tocCount" : $altid;
    $toc[] = array($id, $wght, $alttoc);
    echo '<span id="'.$id.'"><h'.$wght.'>'.$text.'</h'.$wght.'></span>
';
  }
  else if ($altid !== '') {
    echo '<span id="'.$altid.'"><h'.$wght.'>'.$text.'</h'.$wght.'></span>
';
  }
  else {
    echo '<span><h'.$wght.'>'.$text.'</h'.$wght.'></span>
';
  }
}


function wiki($blob, $text) {
  return '<a href="http://en.wikipedia.org/wiki/'.$blob.'">'.$text.'</a>';
}

function shBegin($lang, $other="") {
  return '<script type="syntaxhighlighter" class="brush: '.$lang.'; '.$other.'"><![CDATA[';
}

function shEnd() {
  return ']]></script>';
}

?>
