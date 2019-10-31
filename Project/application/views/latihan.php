<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
    foreach ($datas as $data) {
        $obj = $data;
        echo $data['owner']['login'];   
    ?>
        <!-- <li> <?=$data['owner']['login'];?> <li> -->
    

    <?php
    }
    ?>
</body>
</html>