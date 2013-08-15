<?php

/*
 * Use to get image source from folder structure images/articles/$page/$filename
 *
 * @param  string $filename Image filename
 * @param  string $page     Article page id
 * @param  string $prefix   Optional prefix, defaults to '/'.
 * @return string           Image source path, based on the article id.
 */
function imgsrc($filename, $page, $prefix='/') {
  return $prefix.'images/articles/'.$page.'/'.$filename;
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
function gifimage($firstFrameFile, $gifFile, $page) {
  $imgfolder='/images/articles/'.$page.'/';

  $size=getimagesize(imgsrc($firstFrameFile, $page, ''));
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
 * Optionals:
 *  # Alternate title can be set for the ToC.
 *  # ToC registering is optional
 *  # An alternate id is also possible for animated scrolling.
 *
 * @param  int    $wght   The header weight, 1,2,..,5 corresponding to h1,h2,..,h5
 * @param  string $text   Header title.
 * @param  string $alttoc Alternative content (uses $text if empty)
 * @param  bool   $intoc  If false, it's omitted from ToC.
 * @param  string $altid  Alternative id, use for linking within article.
 */
function heading($wght, $text, $alttoc='', $intoc=true, $altid='') {
  if ($alttoc == '')
  $alttoc = $text;

  if ($intoc) {
    global $toc;
    global $tocCount;
    $tocCount = $tocCount + 1;
    $id="toc$tocCount";
    $toc[] = array($id, $wght, $alttoc);
    echo '<a id="'.$id.'"><h'.$wght.'>'.$text.'</h'.$wght.'></a>
';
  }
  else if ($altid !== '') {
    echo '<a id="'.$altid.'"><h'.$wght.'>'.$text.'</h'.$wght.'></a>
';
  }
  else {
    echo '<a><h'.$wght.'>'.$text.'</h'.$wght.'></a>
';
  }
}
?>
