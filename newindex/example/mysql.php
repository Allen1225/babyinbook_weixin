<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/1
 * Time: 13:19
 */
function query($sql,$db='bibtest')
{
    //$link = @mysqli_connect('127.0.0.1','root','root');
    $link = @mysqli_connect('127.0.0.1','bib','BibMysql2015');
    if(mysqli_connect_errno()){
        $tmp = array();
        $tmp = query($sql);
        return $tmp;
    }
//    mysqli_select_db($link,'bibtest');
    mysqli_select_db($link,$db);

    mysqli_set_charset($link,'utf8');
    $res = mysqli_query($link,$sql);

    if($res){
        if(mysqli_num_rows($res)){
            $tmp = array();
            while($row = mysqli_fetch_assoc($res)){   //每次从结果集中取出一条记录,没有记录了则返回NULL
                $tmp[]  = $row;
            }
            return $tmp;
        }else{
            $tmp=array();
            return $tmp;
        }
    }else{
        $tmp=array();
        return $tmp;
    }
    mysqli_close($link);

}

//操作数据库  增删改操作  返回最后插入ID  或者受影响行
function execute($sql,$db='bibtest'){
    //$link = @mysqli_connect("127.0.0.1","root","root");
    $link = @mysqli_connect('127.0.0.1','bib','BibMysql2015');
    if(!$link){
        return $list=array();
    }

    //@mysql_connect("172.17.91.195","root","chinamobile") or die(query($sql));
    mysqli_select_db($link,$db);
    mysqli_set_charset($link,'utf8');

    $result = mysqli_query($link,$sql);
    if($result){
        // mysql_insert_id()   mysql_affected_rows()
        return mysqli_insert_id()?mysqli_insert_id():mysqli_affected_rows();
    }
}


//判断否为UTF-8编码
function is_utf8($str){
    $len = strlen($str);
    for($i = 0; $i < $len; $i++){ $c = ord($str[$i]); if($c > 128){
        if(($c > 247)){
            return false;
        }elseif($c > 239){
            $bytes = 4;
        }elseif($c > 223){
            $bytes = 3;
        }elseif ($c > 191){
            $bytes = 2;
        }else{
            return false;
        }
        if(($i + $bytes) > $len){
            return false;
        }
        while($bytes > 1){
            $i++;
            $b = ord($str[$i]);
            if($b < 128 || $b > 191){
                return false;
            }
            $bytes--;
        }
    }
    }
    return true;
}
//判断是否base64加密
function is_base64($str){
//这里多了个纯字母和纯数字的正则判断
    if(@preg_match('/^[0-9]*$/',$str) || @preg_match('/^[a-zA-Z]*$/',$str)){
        return false;
    }elseif(is_utf8(base64_decode($str)) && base64_decode($str) != ''){
        return true;
    }
    return false;
}
