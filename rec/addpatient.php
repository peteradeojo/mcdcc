<?php

use Validator\Validator;

require '../init.php';
if ($_POST) {
  // foreach ($_POST as $key => $value) {
  //   echo "$key, $value<br/>";
  // }
  // echo "<br><br>";
  $firstname = Validator::validateName($_POST['firstname']);
  $lastname = Validator::validateName($_POST['lastname']);
  $middlename = Validator::validateName($_POST['middlename']);
  $birthdate = Validator::validateDate($_POST['birthdate']);
  $state = Validator::validateName($_POST['state']);
  $email = Validator::validateEmail($_POST['email']);
  $phone = Validator::validatePhone($_POST['phone']);
  $zipcode = Validator::validateZipCode($_POST['zipcode']);
  // $city = Validator::validateName($_POST['city']);
  $street = Validator::validateName($_POST['street']);
  $gender = Validator::validateOptions($_POST['gender'], ['1', '0']);
  $cardnumber = Validator::validatePatientNumber($_POST['cardnumber']);
  $religion = Validator::validateOptions($_POST['religion'], ['christianity', 'islam', 'other']);

  $action = $db->multiInsert(
    [
      'patients' => [
        'cardnumber' => "'$cardnumber'",
        'firstname' => "'$firstname'",
        'lastname' => "'$lastname'",
        'phone' => "'$phone'",
      ],
      'patient_details' => [
        'cardnumber' => "'$cardnumber'",
        'email' => "'$email'",
        'religion' => "'$religion'",
        'state' => "'$state'",
        'street' => "'$street'",
        'zipcode' => "'$zipcode'",
        'gender' => "'$gender'",
        // 'city' => "'$city'",
      ]
    ]
  );

  // if ($a)
  header("Location: /rec/patients.php");
  exit();
}
$title = 'New Record | MCDCC';
$stylesheets = ['https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css'];
require '../assets/snippets/header.php';

?>
<div class="container">
  <h1>New Record</h1>
  <!-- <div class="col-sm-6"> -->
  <form action="" method="post" class="row">
    <div class="form-group col-md-4">
      <label for='firstname'>Firstname</label>
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
    <div class="form-group col-sm-6 col-md-3">
      <label for="birthdate">Date of Birth</label>
      <input type="date" name="birthdate" id="birthdate" class="form-control" required>
    </div>
    <div class="form-group col-sm-6 col-md-5">
      <label for="phone">Phone Number</label>
      <input type="text" name="phone" id="phone" class="form-control">
    </div>
    <div class="form-group col-md-4">
      <label for="religion">Religion</label>
      <select id="religion" class="form-control" placeholder="Pick a religion" data-type="selectize" name='religion'>
        <option value="christianity">Christian</option>
        <option value="islam">Islam</option>
        <option value="other">Other</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="email">E-mail Address</label>
      <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="form-group col-md-4">
      <label for="state">State</label>
      <select name="state" id="state" placeholder="Select a state" class="form-control" data-type="selectize">
        <option value="ekiti">Ekiti</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="zipcode">Zip Code</label>
      <input type="number" name="zipcode" id="zipcode" class="form-control">
    </div>
    <div class="form-group">
      <label for="street">Street</label>
      <input type="text" name="street" id="street" class="form-control">
    </div>
    <div class="form-group">
      <label for="gender">Gender</label>
      <div class="form-check-inline">
        <label for="male">
          <input type="radio" name="gender" id="male" value="1" class="form-check-input" checked> Male
        </label>
        <label for="female">
          <input type="radio" name="gender" id="female" value="0" class="form-check-input"> Female
        </label>
      </div>
    </div>
    <div class="form-group col-md-6">
      <label for="category">Card Type</label>
      <select name="category" id="category" required="required" class="form-control" placeholder="Select a category" data-type="selectize" data-src="/api/categories.php">
        <!-- <option disabled selected></option> -->
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="cardnumber">Card Number</label>
      <input type="text" name="cardnumber" id="cardnumber" class="form-control" readonly required>
      <button type="button" class="btn btn-danger mt-1" id="generate-number">Generate Card Number</button>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-dark">Submit</button>
    </div>
  </form>
  <!-- </div> -->
</div>
<?php

$scripts = ['https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js', '/rec/main.js'];
require '../assets/snippets/footer.php';
