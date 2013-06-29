<!-- Syntax Highlighter
================================================== -->
<script type="text/javascript" src="/sh/scripts/shCore.js"></script>
<?php
   $addLatex = false;
   foreach ( $lang as $val) {
     if($val == "Latex") {
       $addLatex = true;
       continue;
     }
     echo '<script type="text/javascript" src="/sh/scripts/shBrush'.$val.'.js"></script>
';
   }
?>
<link type="text/css" rel="Stylesheet" href="/sh/styles/shCore.css"/>
<link type="text/css" rel="Stylesheet" href="/sh/styles/shCoreDefault.css"/>
<script type="text/javascript">SyntaxHighlighter.all();</script>

<?php
if( $addLatex )
  $this->load->view('parser/latex');
?>