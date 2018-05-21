<?php
//$mysqli = @ new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//if ($mysqli->connect_errno) exit('Ошибка соединения с БД');
$reg = 1;
if (isset($_POST['log_in'])) {
	//соединимся с БД
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'My_base');
	try {$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
	
	} catch (Exception $e) {
	exit('Ошибка соединения с БД');
	}
	$login = $_POST['login'];
	$password = $_POST['password'];
	//шифрование

	//hash_equals($hashed_password, crypt($password, $hashed_password))

	//$password = password_hash($password, PASSWORD_DEFAULT);
		
    //$mysqli->set_charset('utf8');

	$query = "SELECT * FROM `users` WHERE `login`='$login'"; 
	$query = $pdo->prepare($query);
	$query->execute([$login]);
	$row = $query->fetch();
	//print_r($query); 
	//$res = $pdo->query($query);
	//print_r($res);  

	if (password_verify($password, $row['password']))
	 	{
		echo "Добро пожаловать, $login";
		$reg = 2;} else{echo 'Не верный логин и/или пароль';
		}
    /*$result_set = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."' AND `password`='".$password."'");

    $table = [];
    while (($row = $result_set->fetch_assoc()) != false) {
        $table[] = $row;
        print_r($row);
    }

//print_r($table);
    if($login == $table['login'] && $password == $table['password'])
 	{
		echo '<br/>Вы ввошли';
		$reg = 2;} else{echo "nooooo";
		}*/
	
}
//$mysqli->close();
if ($reg === 1) {
?>
<form action="/login.php" method="POST">
	<p>
		<p><stpong>Ваш логин</stpong>:</p>
		<input type="text" name="login" value="">
	</p>	
	<p>
		<p><stpong>Ваш пароль</stpong>:</p>
		<input type="password" name="password" value="">
	</p>
	<p>
		<button type="submit" name="log_in">Войти</button>
	</p>

</form>
<?php } else{ ?>
<!DOCTYPE html>
<html>
<head>
	<title>Крестики нолики</title>
	<style type="text/css">
		body {
		background: url(krestiki-noliki.png);
		background-repeat: no-repeat;
		background-size: cover; 
	}
	</style>
</head>
<body>
	<font size="20">
	<a href="/game.php">Играть в крестики нолики</a>		
	</font>

</body>
</html>
<?php }?>