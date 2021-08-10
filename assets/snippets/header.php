<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css" integrity="sha512-F7WyTLiiiPqvu2pGumDR15med0MDkUIo5VTVyyfECR5DZmCnDhti9q5VID02ItWjq6fvDfMaBaDl2J3WdL1uxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php
  foreach ($stylesheets as $style) {
    echo "<link rel='stylesheet' href='$style'>";
  }
  ?>
  <link rel="stylesheet" href="/public/css/style.css">
  <title><?= @$title ? $title : "MC Data Collation Portal" ?></title>
</head>

<body>
  <aside id="sidenav">
    <div class="container">
      <p><a href="/">Home</a></p>
      <p>Welcome, <?= $user['firstname'] ?></p>
    </div>
  </aside>
  <main>
    <div class="container" id="topbar">
      <div class="row">
        <div class="s9">
        </div>
        <div class="s3">
          <a href="/logout.php">Log Out</a>
        </div>
      </div>
      <?php
      ?>
    </div>