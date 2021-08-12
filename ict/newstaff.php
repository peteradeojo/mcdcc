<?php

use Validator\Validator;

require '../init.php';

if ($_POST) {
  $avail_offices = $db->select('offices', 'o_id as officeid');
  $avail_offices = array_map(function ($office) {
    return $office['officeid'];
  }, $avail_offices);
  $title = Validator::validateOptions($_POST['title'], ['mr.', 'mrs.', 'mr.', 'dr(mrs).']);
  $email = Validator::validateEmail($_POST['email']);
  $phone = Validator::validatePhone($_POST['phone']);
  $firstname = Validator::validateName($_POST['firstname']);
  $lastname = Validator::validateName($_POST['lastname']);
  $officeid = Validator::validateOptions($_POST['officeid'], $avail_offices);
  $username = Validator::validateUsername($_POST['username']);
  $post = Validator::sanitize($_POST['post']);
  $password = sha1(Validator::sanitize($_POST['password']));

  try {
    //code...
    $db->insert('staff', [
      'title' => $title,
      'email' => $email,
      'phone' => $phone,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'officeid' => $officeid,
      'username' => $username,
      'post' => $post,
      'password' => $password,
    ]);

    echo json_encode(['ok' => true]);
  } catch (Exception $th) {
    echo json_encode(['error' => $th->getMessage()]);
  }
  // echo json_encode($_POST);
  exit();
}

require '../assets/snippets/header.php';
?>
<div class="container">
  <h1>New Staff</h1>
  <form action="/ict/newstaff.php" method="post" id="new-staff-form">
    <div class="form-group col-sm-4">
      <label for="title">Title</label>
      <select name="title" id="title" class="form-control">
        <option value="Mr.">Mr.</option>
        <option value="Mrs.">Mrs.</option>
        <option value="Dr.">Dr.</option>
        <option value="Dr (Mrs).">Dr (Mrs).</option>
      </select>
    </div>
    <div class="row">
      <div class="form-group col-md-4">
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname" class="form-control" required>
      </div>
      <div class="form-group col-md-4">
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" id="lastname" class="form-control" required>
      </div>
      <div class="form-group col-md-4">
        <label for="middlename">Middlename</label>
        <input type="text" name="middlename" id="middlename" class="form-control">
      </div>
      <div class="form-group col-md-4">
        <label for="phone">Phone Number</label>
        <input type="text" name="phone" id="phone" required="required" class="form-control">
      </div>
      <div class="form-group col-md-4">
        <label for="email">E-mail Address</label>
        <input type="email" id="email" name="email" required="required" class="form-control"></input>
      </div>
      <div class="form-group col-md-7">
        <label for="office">Office</label>
        <select name="officeid" id="office" class="form-control">
          <?php
          $offices = $db->select('offices');
          foreach ($offices as $office) {
            # code...
            echo "<option value='$office[o_id]'>$office[title]</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="post">Position</label>
        <input type="text" name="post" id="post" required="required" class="form-control">
      </div>
      <div class="form-group col-md-6">
        <label for="username">Select Username</label>
        <input type="text" name="username" id="username" required="required" class="form-control">
      </div>
      <div class="form-group col-md-6">
        <label for="password">Select Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </form>
</div>
<?php

$scripts = ['/ict/main.js'];
require '../assets/snippets/footer.php';
