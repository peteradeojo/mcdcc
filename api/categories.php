<?php

require '../init.php';

$categories = $db->select('cards', 'code as value, title');

echo json_encode(['data' => $categories]);