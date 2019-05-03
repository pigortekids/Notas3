<?php
$url = 'http://172.18.0.4/public/index.php';
$contents = file_get_contents($url);
if($contents !== false){
    echo $contents;
}else{
    echo "ERRADO";
}//http://localhost:8081/public/index.php