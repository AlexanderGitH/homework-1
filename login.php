<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Регистрация и авторизация</title>
		<link rel="stylesheet" href="/style.css" />
	</head>
	<body>
		<form action="login.php" method="POST">

			<p>
				<p><strong>Логин</strong>:</p>
				<input type="text" name="login" value="<?php echo @$data['login']; ?>">
			</p>

			<p>
				<p><strong>Пароль</strong>:</p>
				<input type="password" name="password">
			</p>

			<p>
				<button type="submit">Войти</button>
			</p>

		</form>
	</body>
</html>