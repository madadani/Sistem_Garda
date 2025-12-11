<?php
$names = ["Jöhn Dœ","张伟","Éléonore","Михаил"];
foreach($names as $n){
    if(function_exists("iconv")){
        $t = @iconv("UTF-8", "ASCII//TRANSLIT", $n);
        echo $n . " -> " . ($t === false ? "[iconv failed]" : $t) . PHP_EOL;
    } else {
        echo "iconv missing" . PHP_EOL;
        break;
    }
}
