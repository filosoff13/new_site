<?php 
require_once 'captcha_class.php';

//соединимся с БД
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'My_base');
$link = @ new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($link->connect_errno) {
    exit('Error');
}
$link->set_charset('utf-8');

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}*/

//echo "Соединение с MySQL установлено!" . PHP_EOL;
//echo "Информация о сервере: " . mysqli_get_host_info($link) . PHP_EOL;
$reg = 1;
if (isset($_POST['registrated'])) {
	$login = $_POST['login'];
	$email = $_POST['Email'];
	$password = $_POST['password'];
	$password_2 = $_POST['password_2'];
	//выполним проверку на валидность и добавим "ошибки" в массив(можно выполнить доп. проверки на поля, в частности filter_var для проверки почты)
	$err = array();
	if ($login=='') {
		$err[] = 'Введите логин!';
	}
	if ($email=='')
		//|| filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)
	 {
		$err[] = 'Введите Email!';
	}
	if ($password=='') {
		$err[] = 'Введите пароль!';
	}
	if ($password_2!=$password) {
		$err[] = 'Повторный пароль введен не верно!';
	}
	if (!Captcha::check($_POST['captcha'])){
		$err[] = 'Проверочный код введён неверно!';
	}
	if (empty($err)) {
		//нет ошибок, регистрируем		
		//шифрование
		$password = crypt("$password", 'rl');
		//$password = password_hash($password, PASSWORD_DEFAULT);
		if(mysqli_real_query($link, ("INSERT INTO users VALUES('', '$login', '$email', '$password')"))) {echo '<br/>Вы успешно зарегистрированы!';
			$reg = 2;}
	} else {
		echo '<div style="color: red;">'.array_shift($err).'</div><hr>';
		die();
	}
	
}
$link->close();
if ($reg === 1) {
?>
<form action="/signup.php" method="POST">
	<p>
		<p><stpong>Ваш логин</stpong>:</p>
		<input type="text" name="login" />
	</p>
	<p>
		<p><stpong>Ваш Email</stpong>:</p>
		<input type="Email" name="Email" value="<?=@$_POST['Email']?>"/>
	</p>	
	<p>
		<p><stpong>Ваш пароль</stpong>:</p>
		<input type="password" name="password" value="<?=@$_POST['password']?>"/>
	</p>
	<p>
		<p><stpong>Введите Ваш пароль еще раз</stpong>:</p>
		<input type="password" name="password_2" value="<?=@$_POST['password_2']?>"/>
	</p>
	<p>
		<p><stpong>Введите символы</stpong>:</p>
		<input type="text" name="captcha" />
	</p>
	<p>
		<img src='captcha.php' alt='Капча' />
	</p>
	<p>
		<button type="submit" name="registrated">Зарегистрироваться</button>
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