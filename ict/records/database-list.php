<h1>Databases</h1>

<table class='table table-striped' id="databases-table">
  <thead>
    <tr>
      <th>Database</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $DATABASES = $db->query('SHOW DATABASES');
    // print_r($DATABASES);
    foreach ($DATABASES as $database) {
      echo "<tr><td><a href='cleanup.php?database=$database[Database]'>$database[Database]</a></td></tr>";
    }
    ?>
  </tbody>
</table>