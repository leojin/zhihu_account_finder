<?php

$data = $_POST['data'];
$answer_id = (int)$_POST['id'];

if ('' == $data) {
    exit(0);
}

if ($answer_id <= 0) {
    exit(0);
}

$root = dirname(dirname(__FILE__));

$file = $root . '/data/fetch/' . $answer_id;

file_put_contents($file, $data);

$ret = array(
    'err' => 0,
    'file' => $file,
);

echo json_encode($ret);
