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
        '1'    => 'scueess',
        '0001' => '添加失败',
        '0002' => '修改失败',
        '0003' => '删除失败',
        // 用户相关        
        '1001' => '用户名或者密码错误',
        '1002' => '用户名重复',
        '1003' => '邮箱已被绑定啦~',
        '1004' => '原密码错误',
        '1005' => '两次密码不一致',
        '1006' => '个性域名与其他人重复啦！',
        // 分类管理
        '2001' => '添加分类失败',
        '2002' => '修改失败',
        // 文章相关
        '3001' => '请选择分类',
        '3002' => '请填写文章标题',
        '3003' => '请填写文章内容',
        // 设置相关
        '4001' => '最多只能创建6个导航哦！',
    ];
    $data['msg'] = $code[$data['code']];

    return $data;
}

/*
* 禁止设置的二级域名
*/
function prohibitSite($domain = '') {
    if ($domain == '') {
        return true;
    }

    $site_arr = C('SITE');
    foreach ($site_arr as $key => $value) {
        if ($value == $domain) {
            return false;
        }
    }
    
    return true;
}
