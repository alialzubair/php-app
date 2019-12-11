<?php
//include the import files
require  'init.php';


// make the all route and action and page in one page
$page = isset($_GET['page']) ? $_GET['page'] : 'manage';
$err = '';

/**
 * Manage page 
 * in this page can controlr the page and do some action 
 * Like Show data | Add data | Delete data | Edit data
 */
if ($page == 'manage') :
    // show susscess messages
    if (Session::exeists('success')) :
        echo '<p class="alert alert-success">' . Session::flash('success') . '</p>';
    endif;
    $row = model::get();
    ?>
    <div class="container">
        <!-- here put html -->
    </div>

<?php
    /**
     * Create :-
     *  Here you can make the form and  Add new items
     */
elseif ($page == 'create') :
    // check the POST REQUEST
    if (Input::exeist()) :
        if (Token::check(Input::get('token'))) {
            // get the var
            $field = Input::get($name);
            // validations Form
            $validate = new Validet();
            // rule of validate
            $validation = $validate->check($_POST, array(
                $name => ['required' => true, 'min' => 2, 'max' => 200]
            ));
            // pass valiadte
            if ($validation->passed()) :
                // create new items
                Model::create(['name' => $name]);
                echo Session::flash('success', 'item add successfully');
                Redirct::to('?page=manage');
            else :
                //errors validate
                foreach ($validation->errors() as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
            endif;
        }
    endif;
    ?>
    <!-- create form -->
    <div class="container">
        <h1 class="bg-dark text-center text-white mt-4 p-2">name Page</h1>
        <form method="post" action="?page=create">
            <!-- show errors  -->
            <p><?php echo $err ?></p>

            <div class="from-group">
                <?php $name = "name" ?>
                <label>Name</label>
                <input type="text" autocomplete="off" name="<?= $name ?>" class="form-control" placeholder="Write task name" value="<?php echo Input::get($name) ?>">
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
            <br>
            <div class="form-group">
                <?php $btn = 'Add Task' ?>
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
        // get id
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';

        $model = model::single($id);

        foreach ($model->result() as $t) { ?>

        <div class="container">
            <h1 class="bg-dark text-center text-white mt-4 p-2"> Edit Categires Page</h1>
            <form method="post" action="?page=edit">
                <input type="hidden" name="id" value="<?= $t->id ?>">
                <p><?php echo $err ?></p>

                <div class="from-group">
                    <?php $name = "name" ?>
                    <label>Name</label>
                    <input type="text" name="<?= $name ?>" class="form-control" placeholder="Write task name" value="<?= $t->name ?>">
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                <br>
                <div class="form-group">
                    <?php $btn = 'Edi Task' ?>
                    <input type="submit" name="Add" value="<?= $btn ?>" class="btn btn-primary btn-block">
                </div>

            </form>
        </div>
        </div>

    <?php }

        ?>


<?php
    if (Input::exeist()) :
        if (Token::check(Input::get('token'))) {
            // get the var
            $name = Input::get('name');
            $id = Input::get('id');
            $validate = new Validet();
            $validation = $validate->check($_POST, array(
                'name' => ['required' => true, 'min' => 2, 'max' => 250]
            ));
            if ($validation->passed()) :
                Tasks::Edit($id, ['name' => $name]);
                echo Session::flash('success', 'task update successfully');
                Redirct::to('?page=manage');
            else :
                foreach ($validation->errors() as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
            endif;
        }
    endif;

    /**
     * Delete  :-
     *  Here you can Delete the items
     */
elseif ($page == 'delete') :
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : '';
    Tasks::Delete($id);
    echo Session::flash('success', 'task delete successfully');
    Redirct::to('?page=manage');


    /**
     * Redirct the 404 errors page if the page not found 
     */
else :
    Redirct::to(404);
endif;
?>