<?php

use Validator\Validator;

require '../init.php';

if (!isset($_GET['id'])) {
  header("Location: /rec/patients.php");
}

if (!empty($_POST)) {
  if (!isset($_GET['id'])) {
    $_SESSION['info'] = ['message' => 'Patient could not be identified'];
    header("Location: /rec/patients.php");
    exit();
  }
  $cardnumber = Validator::validatePatientNumber($_GET['id']);
  if ($cardnumber) {
    $firstname = Validator::validateName($_POST['firstname']);
    $lastname = Validator::validateName($_POST['lastname']);
    $middlename = Validator::validateName($_POST['middlename']);
    // echo $middlename;exit();
    $birthdate = Validator::validateDate($_POST['birthdate']);
    $phone = Validator::validatePhone($_POST['phone']);
    $email = Validator::validateEmail($_POST['email']);
    $religion = Validator::validateOptions($_POST['religion'], ['christian', 'islam', 'other']);
    $state = Validator::validateName($_POST['state']);
    $gender = Validator::validateOptions($_POST['gender'], [0, 1]);
    $zipcode = Validator::validateZipCode($_POST['zipcode']);
    try {
      $db->update('patients', ['firstname' => $firstname, 'lastname' => $lastname, 'middlename' => $middlename, 'phone' => $phone, 'update_time' => date('Y-m-d H:i:s')], "cardnumber='$cardnumber'");

      $db->update('patient_details', ['email' => $email, 'religion' => $religion, 'state' => $state, 'gender' => $gender, 'birthdate' => $birthdate, 'zipcode' => $zipcode], "cardnumber='$cardnumber'");
    } catch (Exception $e) {
      // echo $e->getMessage();
      flash('info', $e->getMessage());
    } finally {
      header("Location: /rec/patient.php?id=$cardnumber");
    }
  } else {
    $_SESSION['info'] = ['message' => 'Patient could not be identified'];
    header("Location: /rec/patients.php");
  }
  exit();
}

$patientId = Validator::validatePatientNumber($_GET['id']);
$patient = $db->join('patients', [['left', 'patient_details as pd', 'patients.cardnumber = pd.cardnumber']], 'patients.firstname,patients.lastname,patients.middlename,patients.phone,patients.cardnumber, patients.create_time as patient_init, pd.*', "patients.cardnumber = '$patientId'")[0];

$patient['name'] = "$patient[lastname] $patient[firstname]";

// print_r($patient);

$title = $patient['name'];

$stylesheets = ['https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css'];
require '../snippets/header.php';

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7">
      <h1><?= $patient['name'] ?></h1>
      <a href="/rec/patients.php">Back to Patients</a>
      <div class="container">
        <h3>History</h3>
        <div class="d-flex mb-2">
          <div class="col-9">
            <h3>Appointments</h3>
          </div>
          <div class="col-3">
            <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#appointmentModal">Book</button>
          </div>
        </div>
        <ul id="appointments-display" class="list-group">

        </ul>
      </div>
    </div>

    <!-- Patient Details Edit Form -->
    <div class="col-md-5 p-4">
      <form action="?id=<?= $patientId ?>" method="POST">
        <div class="form-group">
          <label for="firstname">Firstname</label>
          <input type="text" name="firstname" id="firstname" class="form-control" value="<?= $patient['firstname'] ?>" required>
        </div>
        <div class="form-group">
          <label for="lastname">Lastname</label>
          <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $patient['lastname'] ?>" required>
        </div>
        <div class="form-group">
          <label for="middlename">Middlename</label>
          <input type="text" name="middlename" id="middlename" class="form-control" value="<?= @$patient['middlename'] ?>">
        </div>
        <div class="form-group">
          <label for="birthdate">Date of Birth</label>
          <input type="date" name="birthdate" id="birthdate" class="form-control" value=<?= $patient['birthdate'] ?>>
        </div>
        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="text" name="phone" id="phone" class="form-control" value="<?= $patient['phone'] ?>">
        </div>
        <div class="form-group">
          <label for="email">E-mail Address</label>
          <input type="email" name="email" id="email" class="form-control" value="<?= $patient['email'] ?>">
        </div>
        <div class="form-group">
          <label for="religion">Religion</label>
          <select name="religion" id="religion" class="form-control" data-type="selectize">
            <option value="christian">Christianity</option>
            <option value="islam">Islam</option>
            <option value="other">Other</option>
          </select>
        </div>
        <div class="form-group">
          <label for="state">State</label>
          <select name="state" id="state" class="form-control" data-type="selectize">
            <option value="ekiti">Ekiti</option>
          </select>
        </div>
        <div class="form-group">
          <label for="zipcode">Zip/Postal Code</label>
          <input type="text" name="zipcode" id="zipcode" class="form-control" value="<?= $patient['zipcode'] ?>">
        </div>
        <div class="form-group">
          <label for="gender">Gender</label>
          <div class="form-check-inline">
            <label for="male">
              <input type="radio" name="gender" id="male" value="1" class="form-check-input" <?= $patient['gender'] === '1' ? 'checked' : '' ?> required> Male
            </label>
            <label for="female">
              <input type="radio" name="gender" id="female" value="0" class="form-check-input" <?= $patient['gender'] === '0' ? 'checked' : '' ?> required> Female
            </label>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>

</div>

<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appointmentModalLabel">Book Appointment</h5>
        <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
      </div>
      <div class="modal-body container">
        <form action="appointments.php?data=new&id=<?= $patientId ?>" method="post">
          <div class="form-group">
            <label for="id">Patient Number</label>
            <input type="text" name="id" id="id" readonly value="<?= $patientId ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" required min="<?= date('Y-m-d') ?>">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
$scripts = ['https://cdnjs.cloudflare.com/ajax/libs/qs/6.10.1/qs.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js', '/rec/main.js'];
require '../snippets/footer.php';
