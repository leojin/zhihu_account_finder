<?php

$queryString = $_SERVER['QUERY_STRING'];
$queryStringArr = explode('_', $queryString);

if (2 != count($queryStringArr)) {
    echo 'input error';
    exit(0);
}

foreach ($queryStringArr as $idx => $ins) {
    $queryStringArr[$idx] = (int)$ins;
    if ($queryStringArr[$idx] <= 0) {
        echo 'format error';
        exit(0);
    }
}

$fetch_id_1 = $queryStringArr[0];
$fetch_id_2 = $queryStringArr[1];

$root = dirname(dirname(__FILE__));
$fetch_file_1 = $root . '/data/fetch/' . $fetch_id_1;
$fetch_file_2 = $root . '/data/fetch/' . $fetch_id_2;

if (!file_exists($fetch_file_1) ||
    !file_exists($fetch_file_2)) {
    echo 'fetch file error';
    exit(0);
}

$list1 = json_decode(file_get_contents($fetch_file_1), true);
$list2 = json_decode(file_get_contents($fetch_file_2), true);

$map_1 = array();
$map_2 = array();

foreach ($list1 as $idx => $ins) {
    if (isset($ins['link'])) {
        $map_1[$ins['link']] = $idx;
    }
}

foreach ($list2 as $idx => $ins) {
    if (isset($ins['link'])) {
        $map_2[$ins['link']] = $idx;
    }
}

$map_rst = array_intersect_key($map_1, $map_2);
$list_rst = array();
foreach ($map_rst as $ins) {
    $tmp = $list1[$ins];
    if (isset($tmp['img'])) {
        $imgPath = $root . '/webroot/img/' . basename($tmp['img']);
        if (!file_exists($imgPath)) {
            $imgData = file_get_contents($tmp['img']);
            file_put_contents($imgPath, $imgData);
        }
        $tmp['img_local'] = '/img/' . basename($tmp['img']);
    }
    $list_rst[] = $tmp;
}

$fileOut = $root . '/data/rst/' . $fetch_id_1 . '_' . $fetch_id_2;

file_put_contents($fileOut, json_encode($list_rst));

echo '<a href="/?' . $fetch_id_1 . '_' . $fetch_id_2 . '">查看结果</a>';