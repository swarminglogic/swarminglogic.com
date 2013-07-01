<div class="clear" style="margin-bottom:2em"></div>
<a name="comments"></a>

<div class="container sixteen columns">
<hr class="comments" style="width:78%"/>

<?php heading(3, 'Comments', '', false, 'toc-comments'); ?>

<?php
echo validation_errors();
if ($is_form_submitted and !$captcha_status_ok)
  echo "Invalid captcha! Please try again.<br/>";
?>

<?php
$postPID = "";
if((isset($_GET['parentId']) and $_GET['parentId'] >= 0))
  $postPID = "?parentId=".$_GET['parentId'];
echo form_open('articles/'.$page.$postPID.'#comments'); ?>

<?php
$this->load->helper('captcha');
$vals = array('word' => rand(100, 999),
              'img_path' => './images/captcha/',
              'img_url' => '/images/captcha/',
              'img_width' => 55,
              'img_height' => 25,
              'expiration' => 1800
              );


$cap = create_captcha($vals);
$data = array('captcha_time' => $cap['time'],
              'ip_address' => $this->input->ip_address(),
              'word' => $cap['word']
              );
$query = $this->db->insert_string('captcha', $data);
$this->db->query($query);
?>

<div class="three columns">
  <div class="formfield">Name</div>
  <input class="fname" type="text" name="name" maxlength="29" placeholder="(required)" value=
         "<?php echo set_value('name'); ?>"/>
</div>

<div class="three columns">
  <div class="formfield"><div class="apopup formpopup">Are you human?<i>Type the three numbers you see in the image.</br>If you are a robot, I mean no offense.</i></div></div>
  <div class="two columns alpha">
    <input style="display:inline;" type="text" name="captcha"
           placeholder="enter numbers:" value="" size="20"/>
  </div>
  <div class="one column omega">
    <div class="captcha">
      <?php echo $cap['image']; ?>
    </div>
  </div>
</div>

<div class="three columns">
  <div class="formfield apopup formpopup">Email Address (?)<i>Email address will <b>not</b> be disclosed.<br/>This is for me to get in touch. <br/>(to answer questions,  stalk you, etc.)</i></div>
    <input type="text" name="email" placeholder="(optional)"
         value="<?php echo set_value('email'); ?>"/>
</div>

<div class="three columns">
  <div class="formfield apopup formpopup">Link <i>Want to leave a link <br/>to your website, twitter or similar?</i></div>
  <input type="text" name="web" placeholder="(optional)"
         value="<?php echo set_value('web'); ?>"/>
</div>

<div class="clear"></div>
<div class="twelve columns">
  <div style="position:relative; top:-10px;">
    <div class="formfield">Comment</div>
<textarea style="width:100%;" name="ctext" rows="6" placeholder="Type comment here."><?php echo set_value('ctext'); ?></textarea>
<input type="hidden" name="pid" value="<?php echo isset($_GET['parentId']) ? $_GET['parentId'] : -1;?>">

<input type="submit" value="Submit comment" /></div>
</form>
</div> <!-- Twelve columns. -->

<div class="clear"></div>

<hr class="comments" style="width:78%"/>
<div class="twelve columns">
<?php
$this->load->model('article_comments');
class CommentWriter
{
  private $basecomments_;
  private $depth_;
  private $comment_module;
  private $page_;

  public function __construct($commentModule, $page) {
    $this->comment_module = $commentModule;
    $this->depth_ = 0;
    $this->page_ = $page;
    $this->basecomments_ = $this->comment_module->get_base_comments($page);
  }

  private function pDate($comment, $long=false) {
    $date = $comment['created_time'];
    $time = strtotime($date);

    $timeNow = strtotime("now");
    if ($timeNow < strtotime("+4 weeks", $time)) {
      return $this->comment_module->time_since($time)." ago";
    }
    else {
      if ($long)
        /* return date("l F jS Y - g:ia", $time); */
        return date("l M jS Y", $time);
      else
        /* return date("F jS Y - g:ia", $time); */
        return date("M jS Y", $time);
    }
  }

  private function dOff($depth) {
    switch ($depth) {
    case 0:
      break;
    case 1:
      return "offset-one";
      break;
    case 2:
      return "offset-two";
      break;
    case 3:
      return "offset-three";
      break;
    default:
      return "offset-four";
      break;
    }
  }

  private function printComment($comment, $depth) {
    echo '<div class="comment '.$this->dOff($depth).'">';
    echo '<div class="cheader">';
    if ($comment['web'])
      echo '<div class="cname"><a href="'.$comment['web'].'">'.$comment['name'].'</a></div>';
    else
      echo '<div class="cname">'.$comment['name'].'</div>';
    echo '<div class="cdate">'.$this->pDate($comment).'</div>';
    echo '</div class>'; // cheader
    echo '<div class="cbody">';
    echo '<div class="ctext">'.$comment['text'].'</div>';
    echo '<div class="creply"><a href="'.current_url().
      '?parentId='.$comment['id'].'#comments">reply</a></div>';
    echo '</div>'; // cbody
    echo '</div>'; // comment
    echo "</br/>";
  }

  private function depthFirst($comment, $depth) {
    $this->printComment($comment, $depth);
    $currentId = $comment['id'];
    $childComments = $this->comment_module->get_child_comments($this->page_,
                                                               $currentId);

    if (sizeof($childComments) == 0) {
      return; // No children
    }

    foreach($childComments as $child) {
      $this->depthFirst($child, $depth + 1);
    }
  }

  public function printComments() {
    foreach($this->basecomments_ as $comment) {
      $this->depth_ = 0;
      $this->depthFirst($comment, 0);
    }
  }
}

$t = new CommentWriter($this->article_comments, $page);
$t->printComments();

?>
</div>
</div>





