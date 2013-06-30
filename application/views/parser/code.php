<?php
   $addLatex = false;
   $addSh = false;
   $shText = '<script type="text/javascript" src="/sh/scripts/shCore.js"></script>
';

   foreach ( $lang as $val) {
     if($val == "Latex" or $val == "latex") {
       $addLatex = true;
       continue;
     }
     $addSh = true;
     $shText .= '<script type="text/javascript" src="/sh/scripts/shBrush'.$val.'.js"></script>
';
   }
   $shText .= '<link type="text/css" rel="Stylesheet" href="/sh/styles/shCore.css"/>
<link type="text/css" rel="Stylesheet" href="/sh/styles/shThemeSwarmingLogic2.css"/>
<script type="text/javascript">SyntaxHighlighter.all();
</script>';

   if ($addSh or $addLatex) {
     echo "  <!-- Languages
  ================================================== -->
";

   }

   if ($addSh) {
     echo $shText;
   }

   if ($addLatex) {
     $this->load->view('parser/latex');
   }
?>

