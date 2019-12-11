<?php

//include the import files
require  'init.php';

// check the submit
if (Input::exeist()) {
	//check token
	if (Token::check(Input::get('token'))) {
		// make validate
		$validate = new Validet();
		$validation = $validate->check($_POST, [
			'username' => ['required' => true],
			'password' => ['required' => true]
		]);
		//check the validate pass
		if ($validation->passed()) {
			$user_name = Input::get('username');
			$password = Input::get('password');
			//log user
			$user = new User();

			$login = $user->login($user_name, $password);
			if ($login) {

				Redirct::to('index.php');
			} else {
				echo "<p>sorry some thing wrong</p>";
			}
		} else {
			//display  the err
			foreach ($validation->errors() as $err) {
				?>
				<div class='alert alert-danger'><?php echo $err; ?></div>
<?php
			}
		}
	}
}
?>
<div class="container">
	<h1 class="text-center">login page</h1>
	<div class="card bg-dark text-white">
		<div class="card-header  card-info">
			<div class="card-title">login form</div>
		</div>
		<div class="card-body">
			<form method="post" action="login.php">

				<div class="from-group">
					<?php $name = "username" ?>
					<label>User Name</label>
					<input type="text" name="<?php echo $name ?>" class="form-control" palcehorder="enter your name" aoutcomplte="off">
				</div>
				<div class="from-group">
					<?php $name = "password" ?>
					<label>Password</label>
					<input type="password" name="<?php echo $name ?>" class="form-control" palcehorder="enter your name" aoutcomplte="off">
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate() ?>">
				<div class="form-group">
					<input type="submit" name="Login" value="Login" class="btn btn-primary btn-block">
				</div>

			</form>

		</div>

	</div>

</div>