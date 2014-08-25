<?php
$languages = array("Bash", "Plain");
$data['lang'] = $languages;
$this->load->view('parser/code', $data);
$data['cclicense'] = 'by';
?>

<div>
  <div id="article_page" class="twelve columns" data-target="#toc">
    <?php heading(2, 'nicekill: Killing unix processes nicely','Top',true); ?>
    <p>
    Terminating processes on unix is done through termination signals.  The
    signal tells the process that it has been asked to terminate, and allows it
    to clean up after itself. There is an exception to this, and thas is the <ccode>SIGKILL</ccode> (which
    might as well have been named <ccode>SIGMURDER</ccode>), which doesn't give the process
    any way to catch, or ignore this "request". As such, it should be a last resort.
    </p>
    <p>
    Which other signals would be better to use? Let's look at the relevant ones.<br/>
    From the <?=wiki('Unix_signal', 'wikipedia page')?>:
    </p>

    <blockquote>
      <b><ccode>SIGKILL</ccode></b><br/>
    The <ccode>SIGKILL</ccode> signal is sent to a process to cause it to terminate
    immediately (kill). In contrast to <ccode>SIGTERM</ccode> and <ccode>SIGINT</ccode>,
    this signal cannot be caught or ignored, and the receiving process cannot
    perform any clean-up upon receiving this signal.
    </blockquote>
    <p class="pushup"><ccode>read:</ccode> Ask-no-questions brutal termination.</p>

    <blockquote>
      <b><ccode>SIGINT</ccode></b><br/>
    The <ccode>SIGINT</ccode> signal is sent to a process by its controlling terminal when a
    user wishes to interrupt the process. This is typically initiated by
    pressing <ccode>Control-C</ccode>.
    </blockquote>
    <p class="pushup"><ccode>read:</ccode> Process has been told to terminate
    by the user, with a very stern voice.</p>


    <blockquote>
      <b><ccode>SIGHUP</ccode></b><br/>
    The <ccode>SIGHUP</ccode> signal is sent to a process when its controlling terminal is
    closed. It was originally designed to notify the process of a serial line
    drop (a hangup). In modern systems, this signal usually means that the
    controlling pseudo or virtual terminal has been closed. Many daemons will
    reload their configuration files and reopen their logfiles instead of
    exiting when receiving this signal.
    </blockquote>
    <p class="pushup"><ccode>read:</ccode> Controlling terminal closed. A
    process will typically not ignore this.</p>

    <blockquote>
      <b><ccode>SIGTERM</ccode></b><br/>
    The <ccode>SIGTERM</ccode> signal is sent to a process to request its
    termination. Unlike the <ccode>SIGKILL</ccode> signal, it can be caught and
    interpreted or ignored by the process. This allows the process to perform
    nice termination releasing resources and saving state if appropriate. It
    should be noted that <ccode>SIGINT</ccode> is nearly identical to
      <ccode>SIGTERM</ccode>.
    </blockquote>
    <p class="pushup"><ccode>read:</ccode> If it doesn't inconvenience you,
    would you be so kind as to finish up? Pretty please?</p>


    <?php heading(4, '1. In which order should it be done?', '1. Which order?'); ?>
    <p>If you are set on terminating a process, it should be requested in the
    order of nicest, to just-make-it-happen.</p>

    <p>If <ccode>SIGTERM</ccode> closes up shop, it's without a doubt the best
      outcome, which means that it should be the first thing to try. Obviously, <ccode>SIGKILL</ccode> should
    be avoided when possible, so that comes last. Then there is
      <ccode>SIGINT</ccode> and <ccode>SIGUP</ccode>, where the
    former is considered a very strong request, meaning that it should probably
    be used after <ccode>SIGUP</ccode>.
    </p>

    <p>In summary, <ccode>SIGTERM</ccode>, <ccode>SIGUP</ccode>, <ccode>SIGINT</ccode>, and lastly
      <ccode>SIGKILL</ccode>.
    </p>


    <?php heading(4, '2. Automated script'); ?>
    <p>It would be nice to have a script to attempt this, and also give each
    signal a few seconds to enacs.<br/>The following bash script does just that.</p>

    <div class="externgist" lang="bash" gist="8666556" file="nicekill.sh"></div>

    <div style="height:200px;" class="clear"></div>


  </div>
  <?php
  global $toc;
  $data['toc'] = $toc;
  $this->load->view('sidebar', $data); ?>
</div>
