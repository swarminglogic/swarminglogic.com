function gifClicked(obj, gifpath) {
  obj.parentNode.className = obj.parentNode.className.replace('noplay','playing');
  obj.src=gifpath;
}
function gifScreenClicked(obj, gifpath) {
  obj.parentNode.children[0].src=gifpath;
  obj.parentNode.className = obj.parentNode.className.replace('noplay','playing');
}

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
        gitLink.innerHTML = "<small>Gist on GitHub</small>";
        gitLink.style.cssText = "float: right; margin-top:-20px; margin-right:5px;"
        gitLink.href=giturl;
        divtag.appendChild(gitLink);
        SyntaxHighlighter.highlight();
      }
      else {
        // alert("Error loading " + url + "\n" + xhr.status + "\n" + xhr);
      }
    }
  };
  xhr.open("GET", url, true);
  xhr.send(null);
}

function getGithubFile(divtag, repo, branch, file, lang) {
  var url = '/githubfile.php?repo='+repo+"&branch="+branch+"&file="+file;
  var giturl = 'https://github.com/swarminglogic/'+repo+'/blob/'+branch+'/'+file
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
        gitLink.innerHTML = "<small>File on GitHub</small>";
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
var githubFileDivs= $(".githubfile");
$( document ).ready( function () {
  // Gisthub gist async load
  gistDivs.each(function() {
    var gist = $(this).attr("gist");
    var file = $(this).attr("file");
    var lang = $(this).attr("lang");
    getGist($(this).get(0), gist, file, lang);
  });

  githubFileDivs.each(function() {
    var repo = $(this).attr("repo");
    var branch = $(this).attr("branch");
    var file = $(this).attr("file");
    var lang = $(this).attr("lang");
    getGithubFile($(this).get(0), repo, branch, file, lang);
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
