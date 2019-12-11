<?php
include 'init.php';

?>
<div class="container">
  <h1 class="text-center">Sing In page</h1>
  <div class="card bg-dark text-white">
    <div class="card-header  card-info">
      <div class="card-title">Register Form</div>
      <form>
        <div class="from-group">
          <?php $name = "username" ?>
          <label>User name</label>
          <input type="text" name="<?php echo $name ?>" class="form-control" palcehorder="enter your name" aoutcomplte="off">
        </div>
        <div class="from-group">
          <?php $name = "emli" ?>
          <label>Email</label>
          <input type="email" name="<?php echo $name ?>" class="form-control" palcehorder="enter your name" aoutcomplte="off">
        </div>
        <div class="from-group">
          <?php $name = "age" ?>
          <label>Age</label>
          <input type="number" name="<?php echo $name ?>" class="form-control" palcehorder="enter your name" aoutcomplte="off">
        </div>
        <div class="from-group">
          <?php $name = "phone" ?>
          <label>Phone</label>
          <input type="tel" name="<?php echo $name ?>" class="form-control" palcehorder="enter your name" aoutcomplte="off">
        </div>
        <div class="from-group">
          <?php $name = "password" ?>
          <label>Password</label>
          <input type="password" name="<?php echo $name ?>" class="form-control" palcehorder="enter your name" aoutcomplte="off">
        </div>
        <br>
        <div class="form-group">
          <input type="submit" name="Login" value="Login" class="btn btn-primary btn-block">
        </div>

      </form>

    </div>

  </div>

</div>