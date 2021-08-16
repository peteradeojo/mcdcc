<h1><?= $database ?></h1>

<table class='table table-striped' id="tables">
  <thead>
    <tr>
      <th>Tables</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $tables = $db->query('SHOW TABLES');
    // print_r($tables);
    foreach ($tables as $table) {
      echo "<tr><td><a href='cleanup.php?database=$database&table=$table[Tables_in_maternalchild]'>$table[Tables_in_maternalchild]</a></td></tr>";
    }
    ?>
  </tbody>
</table>
