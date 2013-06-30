<?php
if(isset($pageWrapperDiv)) {
  echo '        </div>
';
}
?>
	</div><!-- container -->
</div> <!-- wrapper -->
	<script src="/javascripts/jquery-1.10.1.min.js"></script>
	<script src="/javascripts/scrollspy.js"></script>

<?php if(isset($hasSidebar) && $hasSidebar) { ?>
<script type="text/javascript">
function getGist(divtag, gist, file, lang) {
  var url = '/gist.php?gist='+gist+"&file="+file;
  var giturl = 'https://gist.github.com/swarminglogic/' + gist;
  divtag.innerHTML = '';
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function (aEvt) {
    if (xhr.readyState == 4) {
      if(xhr.status == 200) {
        var pre = document.createElement("pre");
        pre.className = "brush: " + lang + ";";
        pre.innerHTML = xhr.responseText;
        divtag.className = "prettyprint";
        divtag.appendChild(pre);

        var gitLink = document.createElement("a");
        gitLink.innerHTML = "Gist on GitHub";
        gitLink.style.cssText = "float: right; margin-top:-20px; margin-right:5px;"
        gitLink.href=giturl;
        divtag.appendChild(gitLink);
        SyntaxHighlighter.highlight();
      }
      else {
        alert("Error loading " + url + "\n" + xhr.status + "\n" + xhr);
      }
    }
  };
  xhr.open("GET", url, true);
  xhr.send(null);
}

var gistDivs= $(".externgist");
$( document ).ready( function () {
  // Gisthub gist async load
  gistDivs.each(function() {
    var gist = $(this).attr("gist");
    var file = $(this).attr("file");
    var lang = $(this).attr("lang");
    getGist($(this).get(0), gist, file, lang);
  });

  // Sidebar scroller
  var top = $('#sidebar_id').offset().top - parseFloat($('#sidebar_id').css('margin-top').replace(/auto/, 0));
  $(window).scroll(function (event) {
    // what the y position of the scroll is
    var y = $(this).scrollTop();
    // whether that's below the form
    if (y >= top - 40) {
      // if so, ad the fixed class
      $('#sidebar_id').addClass('fixed');
    } else {
      // otherwise remove it
      $('#sidebar_id').removeClass('fixed');
    }
  });
  $(window).trigger('scroll');
});
</script>
<?php } ?>
</body>
</html>