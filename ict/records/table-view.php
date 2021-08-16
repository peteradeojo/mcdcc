<h1><?= $table ?></h1>

<div class="container">
  <h3>Query: Execute a query </h3>
  <p>This can be potentially destrcutive</p>
  <form id="query-exec">
    <input type="text" name="query" class="form-control">
  </form>
</div>

<table class='overflow-auto' id="table">
  <thead>
    <tr>
      <?php
      $theads = $db->query("SHOW COLUMNS IN $table");
      foreach ($theads as $th) {
        echo "<th>$th[Field]</th>";
      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
    $data = $db->select(table: $table);
    // print_r($data);
    foreach ($data as $datum) {
      echo "<tr>";
      foreach ($theads as $column) {
        extract($column);
        echo "<td>$datum[$Field]</td>";
      }
      echo "</tr>";
    }
    ?>
  </tbody>
</table>