<?php
header('Content-Type: text/html; charset=UTF-8'); //文字コード指定

//DBに接続
$dsn = 'データベース名; charset=UTF-8';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //exceptionを投げるようにする

/*
//一旦テーブル削除
$sql="drop table onotest";
$res=$pdo->query($sql);
*/

/*
//テーブル作成
$sql = "CREATE TABLE test"
      . "("
      . "id INT AUTO_INCREMENT PRIMARY KEY,"
      . "name char(32),"
      . "comment TEXT,"
      ."date datetime,"
      ."pass char(32)"
      . ");";
$res = $pdo->query($sql);
*/

//データの挿入機能
if(empty($_POST['name_e'])){
  if(!empty($_POST['comment'])){
    if(!empty($_POST['password'])){
      if(!empty($_POST['name'])){
 $sql = $pdo->prepare("INSERT INTO test(id,name,comment,date,pass)VALUES(:id,:name,:comment,:date,:pass)");
                $sql->bindParam(':id', $id, PDO::PARAM_INT);
                $sql->bindParam(':name', $name, PDO::PARAM_STR);
                $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql->bindParam(':date', $date, PDO::PARAM_STR);
                $sql->bindParam(':pass', $password, PDO::PARAM_STR);
                $name=$_POST['name'];
                $comment=$_POST['comment'];
                $date=date("Y/m/d H:i:s");
                $password=$_POST['password'];
                $sql->execute();
      }
    }
  }
}elseif(!empty($_POST['name_e'])){
  if(!empty($_POST['comment'])){
    if(!empty($_POST['password'])){
      if(!empty($_POST['name'])){
         $id_2=$_POST['name_e'];
         $name_2=$_POST['name'];
         $comment_2=$_POST['comment'];
         $date_2=date("Y/m/d H:i:s");
         $password_2=$_POST['password'];

         $sql="update test set name='$name_2',comment='$comment_2',date='$date_2',pass='$password_2' where id=$id_2";
         $result=$pdo->query($sql);

      }
    }
  }
}

//削除機能
if(!empty($_POST['delete'])){
  if(!empty($_POST['d_pass'])){
    $sql='SELECT *FROM test';
    $results=$pdo->query($sql);
    foreach($results as $row){
      if($_POST['delete']==$row['id']){
        if($_POST['d_pass']==$row['pass']){
        $d_num=$_POST['delete'];
        $d_name=" ";
        $d_kome='削除されました。';
        $d_date=date("Y/m/d H:i:s");
 
        $sql="update test set name='$d_name',comment='$d_kome',date='$d_date' where id=$d_num";
        $result=$pdo->query($sql);

        }
      }
    }
  }
}

//編集機能
//再表示させる機能
if(!empty($_POST['edit'])){
  $sql='SELECT *FROM test';
  $results=$pdo->query($sql);
  foreach($results as $row){
    if($row['id']==$_POST['edit']){
      if($row['pass']==$_POST['e_pass']){
        $e_num=$row['id'];
        $e_name=$row['name'];
        $e_kome=$row['comment'];
        $e_pass=$row['pass'];
      }
    }
  }
}



?>


<DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type='text/css'>
.sample{
 position:relative;
 font-weight:bold;
 font-size:24px;
}

.sample:after{
 content:"";
 display:block;
 height:8px;
 width:100%;
 background:rgba(129,194,250,0.5);
 position:absolute;
 bottom:4px;
}
</style>
<title>mission_4(3).php</title>
</head>

<body>
<h3 class="sample">簡易掲示板</h3>
<form method="POST" action="mission_4(3).php"> 
<input type="text" name="name" placeholder="名前"
value="<?php echo $e_name; ?>"/><br>
<input type="text" name="comment" placeholder="コメント"
value="<?php echo $e_kome; ?>"/>
<input type="hidden" name="name_e" value="<?php echo $e_num; ?>"/><br>
<input type="text" name="password" placeholder="パスワード"
 value="<?php echo $e_pass; ?>"> 
<input type="submit" value="送信"><br>
</form>

<form method="POST" action="mission_4(3).php">
<input type="text" name="delete" placeholder="削除対象番号"><br>
<input type="text" name="d_pass" placeholder="パスワード">
<input type="submit" value="削除"><br>
</form>

<form method="POST" action="mission_4(3).php">
<input type="text" name="edit" placeholder="編集対象番号"><br>
<input type="text" name="e_pass" placeholder="パスワード">
<input type="submit" value="編集">
</form>

<?php
try {
    $sql = 'SELECT * FROM test';
    $results = $pdo->query($sql);
    foreach ($results as $row) {
        echo $row['id'] . ',';
        echo $row['name'] . ',';
        echo $row['comment']  . ',';
        echo $row['date'] . '<br>';
    }

} catch (PDOException $e) {
    print($e->getMessage());
}
$pdo = null;
?>
</body>
</html>


