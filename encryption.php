<?php

function shablon($text){
    $stable="opjzlXZJYBaisQVKnfPIwxEubCSAGUtMqhODeyFHRTNgdLWkrvmc!@#$%^&*()_+=-0 987654321";
    $dtable="kGjJoysNmWCVSPlAdMHKtaQrTLnDfbhORzuFpEeiZIcXUvxwgBqY-1!47)^ $*08=5@6%#2+3&(_9";
    $result="";
    for($i=0;$i<strlen($text);++$i){
        $in=strpos($stable,$text[$i]);
        if($in > -1){
            $result.=$dtable[$in];
        }
        else{
            $result.=$text[$i];
        }
    }
    return $result;   
}
function addCrc($data){
    $c=0;
    for($i=0;$i<strlen($data);++$i){
        if($data[$i]==='1')
            ++$c;
    }
    return "$data".decbin($c);
}
//echo shablon('hello world!');
//echo(addCrc('h11el1lo world!1'));
?>