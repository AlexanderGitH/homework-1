<?php
	header("Content-Type: text/html; charset=utf-8");
	define("USERS_LOG", "users.xml");
	
	$data = $_POST;
	if( isset($data['do_signup'])){
		$errors = array();
		if(($data['login']) == '' ){
			$errors[] = 'Введите логин!';
		}
		if(($data['password']) == '' ){
			$errors[] = 'Введите пароль!';
		}
		if(($data['password_2']) != $data['password'] ){
			$errors[] = 'Повторный пароль не совпадает!';
		}
		if(($data['email']) == '' ){
			$errors[] = 'Введите Email!';
		}
		if(($data['name']) == '' ){
			$errors[] = 'Введите имя!';
		}
		
		if( empty($errors) ){
			// если нет ошибки, то регистрируем
			if($_SERVER["REQUEST_METHOD"]=="POST"){
			$login = stripslashes(trim(strip_tags($_POST["login"])));
			$password = stripslashes(trim(strip_tags($_POST["password"])));
			$email = stripslashes(trim(strip_tags($_POST["email"])));
			$name = stripslashes(trim(strip_tags($_POST["name"])));
			
			
			function generateSalt(){ // ф-ия создания "соли"
				$salt = '';
				$length = rand(5,10); //длина соли (от 5 до 10 символов)
				for($i=0; $i<$length; $i++) {
					$salt .= chr(rand(33,126)); //символ из ASCII-table
				}
				return $salt;
			}
			
			$salt = generateSalt();
			
			$password = md5($data['password'] . $salt);  //шифруем пароль
			
			
			
			$dom = new domDocument("1.0", "utf-8"); // Создаём XML-документ
			$dom->formatOutput = true;  // в XML-документе будет красивый вывод
			$dom->preserveWhiteSpace = false; // в XML-документе будет красивый вывод
			if(!file_exists(USERS_LOG)){
				$root = $dom->createElement("users"); // Создаём корневой элемент
				$dom->appendChild($root);
			}else{
				$dom->load(USERS_LOG); // Если XML-документ есть, то мы его загружаем
				$root = $dom->documentElement;
			}
			$l = $dom->createElement("login",$login);  //создаем login пользователя
			$p = $dom->createElement("password",$password);
			$e = $dom->createElement("email",$email);
			$n = $dom->createElement("name",$name);
			$s = $dom->createElement("salt",$salt);
			$user = $dom->createElement("user");  // Создаём узел "user"
			$user->appendChild($l); // Добавляем в узел "user" узел "login"
			$user->appendChild($p); // Добавляем в узел "user" узел "password"
			$user->appendChild($e); // Добавляем в узел "user" узел "email"
			$user->appendChild($n); // Добавляем в узел "user" узел "name"
			$user->appendChild($s);
			$root->appendChild($user); // Добавляем в корневой узел "users" узел "user"
			$dom->save("users.xml"); // Сохраняем полученный XML-документ в файл
			echo '<div id="signup">Вы успешно зарегестрированы!</div><hr>';
		}
		}else{
			echo '<div id="errors">'.array_shift($errors).'</div><hr>';
		}
	}
?>



	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="/script.js"></script>-->

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Регистрация и авторизация</title>
		<link rel="stylesheet" href="/style.css" />
	</head>
	<body>
	
		<form id="registerForm" action="/signup.php" method="POST">

		<p>
			<p><strong>Ваш логин</strong>:</p>
			<input type="text" name="login" value="<?php echo $data['login']; ?>">
		</p>

		<p>
			<p><strong>Ваш пароль</strong>:</p>
			<input type="password" name="password">
		</p>

		<p>
			<p><strong>Введите Ваш пароль еще раз</strong>:</p>
			<input type="password" name="password_2">
		</p>

		<p>
			<p><strong>Ваш Email</strong>:</p>
			<input type="email" name="email" value="<?php echo $data['email']; ?>">
		</p>

		<p>
			<p><strong>Ваше имя</strong>:</p>
			<input type="text" name="name" value="<?php echo $data['name']; ?>">
		</p>

		<p>
			<button type="submit" name="do_signup">Зарегистрироваться</button>
		</p>

		</form>
		
	</body>
</html>