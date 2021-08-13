<div class="container">
  <h1><?= generateName($staff['firstname'], $staff['lastname']) ?></h1>
  <form action="/ict/staff.php?id=<?= $staff['id'] ?>" method="post" class="row">
    <div class="form-group col-sm-4">
      <label for="title">Title</label>
      <select name="title" id="title" class="form-control">
        <?php
        $titles = ['Mr.', 'Mrs.', 'Dr.', 'Dr(Mrs).'];
        for ($i = 0; $i < count($titles); $i += 1) {
          echo "<option value='$titles[$i]'";
          if ($titles[$i] == $staff['title']) {
            echo " selected";
          }
          echo ">$titles[$i]</option>";
        }
        ?>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="username">Username</label>
      <input type="text" id="username" readonly value="<?= $staff['username'] ?>" class="form-control">
    </div>
    <div class="row">
      <div class="form-group col-md-4">
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname" class="form-control" value="<?= $staff['firstname'] ?>" required>
      </div>
      <div class="form-group col-md-4">
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $staff['lastname'] ?>" required>
      </div>
      <div class="form-group col-md-4">
        <label for="middlename">Middlename</label>
        <input type="text" name="middlename" id="middlename" value="<?= @$staff['middlename'] ?>" class="form-control">
      </div>
      <div class="form-group col-md-4">
        <label for="phone">Phone Number</label>
        <input type="text" name="phone" id="phone" required="required" value="<?= $staff['phone'] ?>" class="form-control">
      </div>
      <div class="form-group col-md-4">
        <label for="email">E-mail Address</label>
        <input type="email" id="email" name="email" required="required" value="<?= $staff['email'] ?>" class="form-control"></input>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
  </form>
</div>