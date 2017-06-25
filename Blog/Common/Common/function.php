<?php

/*
* 密码编码
* 
* @param string $pass
* 
* @return string encode $pass
*/
function getEnCodePass($pass) {
    return md5(md5(sha1($pass)));
}

/*
* 错误码
**/
function getErrCode(&$data) {
    $code = [
        '1' => 'scueess',
        // 用户相关        
        '1001' => '用户名或者密码错误',
        // 分类管理
        '2001' => '添加分类失败',
        '2002' => '修改失败',
    ];
    $data['msg'] = $code[$data['code']];

    return $data;
}
