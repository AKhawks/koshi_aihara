<html>
<head> <meta charset = "utf-8"> </head>
<title> Peanuts </title>
<h1> <font color = "blue">Peanuts広場</font> </h1>
<fieldset><font size = "4" color = "green">[ルール]<br>名前・コメント・パスワードを入力して投稿ボタンを押してね！！</fieldset><br><br></font>
<body>
<form method = "POST" action = "" target = "_top">

<?php
 $filename = "mission_2-6fin.txt";
 $name = $_POST['name'];
 $comment = $_POST['comment'];
 $new_comment = str_replace("\r\n", "<br>", $comment);
 $password = $_POST['password'];
 $delete = $_POST['delete'];
 $edinum = $_POST['edit'];

//投稿フォームから入力され、かつ編集モードではない場合
 if($_POST['toukou'] == "投稿" && $_POST['ed'] == "0")
 {
     $date = date("m-d H:i:s");
     if(file_exists($filename))
      {
       $line = file($filename);
       $num = count($line) + 1;
       }
     else
       $num = 1;
 
     $fp = fopen($filename, 'a');
     fwrite($fp, $num. "<>". $name. "<>". $new_comment. "<>". $date. "<>". $password. "<>\n");
     fclose($fp);
 }
 
  //削除番号ボタンが押された時
  //削除モード1 パス確認
 elseif($_POST['sakujo'] == "削除")
 {
?> 

  <fieldset>
  削除したい投稿番号を確認し、パスワードを入力してください。<br><br>
  削除番号<br>
  <input type = "text" name = "del_num"  size = "3" value = "<?php echo ($delete); ?>" required = "required" readonly>　
  <br>
  パスワード<br>
  <input type = "password" name = "pass_con" maxlength = "4" autofocus>
  <br>
  <input type = "submit" name = "del_post" value = "送信">
  <input type = "submit" name = "cancel_del" value = "キャンセル">
  </fieldset>
  <br><br><br>
  

<?php
   
 }

  $filename = "mission_2-6fin.txt";
  $delete = $_POST['del_num'];
  $pass_con = $_POST['pass_con'];
  
  
//削除モード2 最終確認
 if($_POST['del_post'] == "送信")
{
  ?>
 
 
 <fieldset>
  <font color = "red">本当に削除しますか？</font><br><br>
  <input type = "submit" name = "del_yes" value = "はい">    <input type = "submit" name = "del_no" value = "いいえ">
 </fieldset>
  <br><br><br>
  <input type = "hidden" name = "delnum" value = "<?php echo ($delete) ?>">
  <input type = "hidden" name = "passcon" value = "<?php echo ($pass_con) ?>">
  
  
  <?php
}
  $filename = "mission_2-6fin.txt";
  $deletefin = $_POST['delnum'];
  $del_pass = $_POST['passcon'];
  
  //削除モード3 実行
 if($_POST['del_yes'] == "はい")
{
  $post = explode("<>", file_get_contents($filename));
  $post_passnum = ($deletefin * 5) - 1;
   if($del_pass == $post[$post_passnum])
  {
  
  $posts = file($filename);
  $target =  $deletefin - 1;
  array_splice($posts, $target, 1, $deletefin. "<>". "". "<>". "この投稿は削除されました。". "<>".  "". "<>". "$del_pass".  "<>\n");
  $newdata = implode("", $posts);
  $fp = fopen($filename, 'w');
  fwrite($fp, $newdata);
  fclose($fp);
  }
  else
   echo ("<FONT COLOR=\"RED\">パスワードが違うよ！！やり直し！</FONT>". "<br><br><br>");
}


 //編集番号ボタンが押された時
 //編集モード1 パス確認
 elseif($_POST['hensyu'] == "編集")
{
   
?>
  
  <fieldset>
  編集したい投稿番号を確認し、パスワードを入力してください。<br><br>
  編集番号<br>
  <input type = "text" name = "edinumfin"  size = "3" value = "<?php echo ($edinum); ?>" required = "required" readonly>
  <br>
  パスワード<br>
  <input type = "password" name = "edipasscon" maxlength = "4" autofocus>
  <br>
  <input type = "submit" name = "ediex" value = "送信">
  <input type = "submit" name = "cancel_edi" value = "キャンセル">
  </fieldset>
  <br><br><br>
  
<?php
  
}
 $filename = "mission_2-6fin.txt";
 $edifinnum = $_POST['edinumfin'];
 $ediconpass = $_POST['edipasscon'];

 //編集モード2 ブラウザでの編集作業
 if($_POST['ediex'] == "送信")
{
  $exarray = explode("<>", file_get_contents($filename));
  $array_passnum = ($edifinnum * 5) - 1;
  
  if($ediconpass == $exarray[$array_passnum])
  {
    echo("<FONT COLOR=\"RED\" SIZE = \"6\">氏名・コメント・パスワードを再度入力してね！！</FONT>". "<br /><br /><br />");
    $key = key;
    for($t = 0; $t < count($exarray); $t++)
   {
    if($t == ($edifinnum - 1) * 5)
     {
     $tt = $t + 1;
     $ttt = $t + 2;
     $ediname = $exarray[$tt];
     $edicomment = str_replace("<br>", "", $exarray[$ttt]);
     }
   }
  }
  else
  {
   echo ("<FONT COLOR=\"RED\">パスワードが違うよ！！やり直し！</FONT>". "<br><br><br>");
   }
 
}

  //投稿フォームから入力され、かつ編集モード2でkeyが生成されている場合
  //編集モード3 編集実行
 elseif($_POST['ed'] == "key")
{
   $edifinnum = $_POST['ednum'];
   
   $posts2 = file($filename);
   $afname = $_POST['name'];
   $afcomment = $_POST['comment'];
   $afdate = date("m-d H:i:s");
   $afpass = $_POST['password'];
   $new_afcomment = str_replace("\r\n", "<br>", $afcomment);
   
   $targets = $edifinnum - 1;
   array_splice($posts2, $targets, 1, $edifinnum. "（編集済み）<>". $afname. "<>". $new_afcomment. "<>". $afdate. "<>". $afpass. "<>\n");
   $newafdata = implode("", $posts2);
   $fp = fopen($filename, 'w');
   fwrite($fp, $newafdata);
   fclose($fp);
   
}


 //テキストファイルが存在していたら、投稿を表示
 if(file_exists($filename))
 {
  $ret_array = explode("<>", file_get_contents($filename));

  for($i = 0; $i < count($ret_array); ++$i)
   {
    if($i % 5 == 4)
     echo "";
    else
     echo ($ret_array[$i] . "<br />\n");
   }
  
  }
?>


</form>
<form method = "POST" action = "" target = "_top">
<fieldset>
<font color = "blue" size = "4">[投稿]</font>
<br>
氏名  <br>
<input type = "text" name = "name" placeholder = "例) スヌーピー" value = "<?php 
if(!empty($ediname))
echo ($ediname); ?>"
required = "required">
<br>
コメント  <br>
<textarea name = "comment" rows = "4" cols = "40" placeholder = "例) こんにちは" required>
<?php 
if(!empty($edicomment))
echo ($edicomment);
?>
</textarea>
<br>
パスワード(＊半角英数字4桁)　<br>
<input type = "password" name = "password"  minlength = "4" maxlength = "4" required = "required">
<br>
<input type = "submit" name = "toukou" value = "投稿">
<input type = "hidden" name = "ed" value = 
"<?php 
if(!empty($key))
{echo ($key);}
else
{echo ("0");}
 ?>">
 <input type = "hidden" name = "ednum" value = "<?php echo ($edifinnum); ?>">
 <br>
 </form>
</fieldset>

<br>
<form method = "POST" action = "" target = "_top">
<fieldset>
<font color = "red" size = "4">[削除]</font>
番号(＊半角) <br>
<input type = "number" name = "delete" required>
<br>
<input type = "submit" name = "sakujo" value = "削除">
<br>
<br>
</form>
<form method = "POST" action = "" target = "_top">
<font color = "green" size = "4">[編集]</font>
番号(＊半角) <br>
<input type = "number" name = "edit" required>
<br>
<input type = "submit" name = "hensyu" value = "編集">
<br>
</form>
</fieldset>
 
 
</body>
</html>