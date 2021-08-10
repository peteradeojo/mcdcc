<?php

use Validator\Validator;

require '../init.php';
if ($_POST) {
  foreach ($_POST as $key => $value) {
    echo "$key: $value<br>";
    $firstname = Validator::validateName($_POST['firstname']);
    $lastname = Validator::validateName($_POST['lastname']);
    $middlename = Validator::validateName($_POST['middlename']);
  }
  exit();
}
$title = 'New Record | MCDCC';
$stylesheets = [];
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
      <select id="religion" class="form-control">
        <option value="christianity">Christian</option>
        <option value="islam">Islam</option>
        <option value="other">Other</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="state">State</label>
      <input type="text" list="states" name="state" id="state" class="form-control">
      <datalist id="states">
        <option value="ekiti">Ekiti</option>
      </datalist>
    </div>
    <div class="form-group col-md-4">
      <label for="city">City</label>
      <input list="cities" class="form-control" id="city" name="city">
      <datalist id="cities"></datalist>
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
          <input type="radio" name="gender" id="male" class="form-check-input" checked> Male
        </label>
        <label for="female">
          <input type="radio" name="gender" id="female" class="form-check-input"> Female
        </label>
      </div>
    </div>
    <div class="form-group col-md-6">
      <label for="category">Card Type</label>
      <select name="category" id="category" class="form-control" required="required">
        <option value="per">Personal Card</option>
        <option value="anc">Antenatal Card</option>
        <option value="fam">Family Card</option>
        <option value="ped">Pediatrics Card</option>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="cardnumber">Card Number</label>
      <input type="text" name="cardnumber" id="cardnumber" class="form-control" readonly>
      <button type="button" class="btn btn-danger mt-1" id="generate-number">Generate Card Number</button>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-dark">Submit</button>
    </div>
  </form>
  <!-- </div> -->
</div>
<?php

$scripts = ['/rec/main.js'];
require '../assets/snippets/footer.php';
