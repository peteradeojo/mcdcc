<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" integrity="sha512-1k7mWiTNoyx2XtmI96o+hdjP8nn0f3Z2N4oF/9ZZRgijyV4omsKOXEnqL1gKQNPy2MTSP9rIEWGcH/CInulptA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php
  if (@$stylesheets) {
    foreach ($stylesheets as $style) {
      echo "<link rel='stylesheet' href='$style'>";
    }
  }
  ?>
  <link rel="stylesheet" href="/public/css/style.css">
  <title><?= @$title ? $title : "MC Data Collation Portal" ?></title>
</head>

<body>
  <aside id="sidenav">
    <div class="container">
      <button id="close-sidenav" class="btn btn-dark">Close</button>
      <p><a href="/">Home</a></p>
      <p>Welcome, <?= $user['firstname'] ?></p>
    </div>
  </aside>
  <main>
    <div class="container" id="topbar">
      <?php
      $flash = flash('info');
      if ($flash) {
        echo <<<_
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            $flash
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        _;
      }
      ?>
      <div class="row">
        <div class="col-sm-9">
          <button id="open-sidenav" class="btn btn-dark">Open</button>
        </div>
        <div class="col-sm-3">
          <a href="/logout.php">Log Out</a>
        </div>
      </div>
      <?php
      ?>
    </div>