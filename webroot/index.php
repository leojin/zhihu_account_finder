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
    $result_file_1 = $root . '/data/rst/' . $fetch_id_1 . '_' . $fetch_id_2;
    $result_file_2 = $root . '/data/rst/' . $fetch_id_2 . '_' . $fetch_id_1;

    if (file_exists($result_file_1)) {
        $datastr = file_get_contents($result_file_1);
    } elseif (file_exists($result_file_2)) {
        $datastr = file_get_contents($result_file_2);
    } else {
        echo 'rst file error';
        exit;
    }

    $data = json_decode($datastr, true);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Result</title>
</head>
<body>
<table border="1">
<tr>
    <th>性别</th>
    <th>昵称</th>
    <th>头像</th>
    <th>主页</th>
    <th>bio</th>
    <th>赞同</th>
    <th>感谢</th>
    <th>提问</th>
    <th>回答</th>
</tr>
<?php foreach ($data as $ins) :?>
<tr>
    <td>
        <?php if (isset($ins['gender'])):?>
        <?=$ins['gender']?>
        <?php endif;?>
    </td>
    <td>
        <?php if (isset($ins['title'])):?>
        <?=$ins['title']?>
        <?php endif;?>
    </td>
    <td>
        <?php if (isset($ins['img_local'])):?>
        <img src="<?=$ins['img_local']?>" width="50" height="50"/>
        <?php endif;?>
    </td>
    <td>
        <?php if (isset($ins['link'])):?>
        <a target="_blank" href="<?=$ins['link']?>"><?=$ins['link']?></a>
        <?php endif;?>
    </td>
    <td>
        <?php if (isset($ins['bio'])):?>
        <?=$ins['bio']?>
        <?php endif;?>
    </td>
    <td>
        <?php if (isset($ins['num_agree'])):?>
        <?=$ins['num_agree']?>
        <?php endif;?>
    </td>
    <td>
        <?php if (isset($ins['num_thx'])):?>
        <?=$ins['num_thx']?>
        <?php endif;?>
    </td>
    <td>
        <?php if (isset($ins['num_question'])):?>
        <?=$ins['num_question']?>
        <?php endif;?>
    </td>
    <td>
        <?php if (isset($ins['num_answer'])):?>
        <?=$ins['num_answer']?>
        <?php endif;?>
    </td>
</tr>
<?php endforeach;?>
</table>
</body>
</html>