<?php
//include the import files
require  'init.php';
$user = new User();
//check  the user isLogged
if ($user->isLoggedIn()) {
    ?>
    <div class="container">
        <p class="text-danger">Hello <a href="#" class="text-success"> <?php echo $user->data()->username; ?></a> !</p>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </div>

<?php
} else { 
   Redirct::to('index.php');
}

// make the all route and action and page in one page
$page = isset($_GET['page']) ? $_GET['page'] : 'manage';
$err = '';

/**
 * Manage page 
 * in this page can controlr the page and do some action 
 * Like Show data | Add data | Delete data | Edit data
 */
if ($page == 'manage') :
	if (Session::exeists('success')) :
		echo '<p class="alert alert-success">' . Session::flash('success') . '</p>';
	endif;
	$cat = Post::get();
	?>
	<div class="container">
		<a class="btn btn-primary btn-block mt-4" href="?page=create">Add New Categire</a>
		<div class="card-body ">
			<?php foreach ($cat->result() as $c) : ?>
				<h1><?= $c->cat_name ?></h1>
				<p><?= $c->create_at  ?></p>
				<a class="btn btn-danger btn-block" href="?page=delete&id=<?php echo $c->id ?>">Delete</a>
				<a class="btn btn-success btn-block" href="?page=edit&id=<?= $c->id ?>">Edit</a>
			<?php endforeach ?>
		</div>
	</div>

<?php
	/**
	 * Create :-
	 *  Here you can make the form and  Add new items
	 */
elseif ($page == 'create') :
	if (Input::exeist()) :
		if (Token::check(Input::get('token'))) {
			// get the var
			$name_cat = Input::get('categoryName');
			$validate = new Validet();
			$validation = $validate->check($_POST, array(
				'categoryName' => ['required' => true, 'min' => 2, 'max' => 20]
			));
			if ($validation->passed()) :
				Post::create(['cat_name' => $name_cat]);
				echo Session::flash('success', 'cat add successfully');
				Redirct::to('?page=manage');
			else :
				foreach ($validation->errors() as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
			endif;
		}
	endif;
	?>

	<div class="container">
		<h1 class="bg-dark text-center text-white mt-4 p-2">Categires Page</h1>
		<form method="post" action="?page=create">
			<p><?php echo $err ?></p>

			<div class="from-group">
				<?php $name = "categoryName" ?>
				<label>Name</label>
				<input type="text" name="<?= $name ?>" class="form-control" placeholder="Write category name" value="<?php echo Input::get('categoryName') ?>">
			</div>
			<input type="hidden" name="token" value="<?php echo Token::generate() ?>">
			<br>
			<div class="form-group">
				<?php $btn = 'Add category' ?>
				<input type="submit" name="Add" value="<?= $btn ?>" class="btn btn-primary btn-block">
			</div>

		</form>
	</div>

	<?php

		/**
		 * Edit :-
		 *  Here you can Edit new items
		 */
	elseif ($page == 'edit') :
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : '';

		$cat = Post::single($id);

		foreach ($cat->result() as $c) { ?>

		<div class="container">
			<h1 class="bg-dark text-center text-white mt-4 p-2"> Edit Categires Page</h1>
			<form method="post" action="?page=edit">
				<input type="hidden" name="id" value="<?= $c->id ?>">
				<p><?php echo $err ?></p>

				<div class="from-group">
					<?php $name = "categoryName" ?>
					<label>Name</label>
					<input type="text" name="<?= $name ?>" class="form-control" placeholder="Write category name" value="<?= $c->cat_name ?>">
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate() ?>">
				<br>
				<div class="form-group">
					<?php $btn = 'Edit category' ?>
					<input type="submit" name="edit" value="<?= $btn ?>" class="btn btn-primary btn-block">
				</div>

			</form>
		</div>

	<?php }

		?>


<?php
	if (Input::exeist()) :
		if (Token::check(Input::get('token'))) {
			// get the var
			$name_cat = Input::get('categoryName');
			$id = Input::get('id');
			$validate = new Validet();
			$validation = $validate->check($_POST, array(
				'categoryName' => ['required' => true, 'min' => 2, 'max' => 20]
			));
			if ($validation->passed()) :
				Post::Edit($id, ['cat_name' => $name_cat]);
				echo Session::flash('success', 'cat update successfully');
				Redirct::to('?page=manage');
			else :
				foreach ($validation->errors() as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
			endif;
		}
	endif;
	// Post::Edit($id, ['cat_name' => $name_cat]);
	// echo Session::flash('success', 'cat update successfully');
	// Redirct::to('?page=manage');
	/**
	 * Delete  :-
	 *  Here you can Delete the items
	 */
elseif ($page == 'delete') :
	$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : '';
	Post::Delete($id);
	echo Session::flash('success', 'cat delete successfully');
	Redirct::to('?page=manage');


	/**
	 * Redirct the 404 errors page if the page not found 
	 */
else :
	Redirct::to(404);
endif;
?>