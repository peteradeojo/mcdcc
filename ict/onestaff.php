<div class="container">
  <h1><?= generateName($staff['firstname'], $staff['lastname']) ?></h1>
  <form action="/ict/staff.php?id=" method="post" class="row">
    <div class="form-group col-md-4">
      <label for="firstname">Firstname</label>
      <input type="text" name="firstname" id="firstname" value="<?= $staff['firstname'] ?>" class="form-control">
    </div>
  </form>
</div>