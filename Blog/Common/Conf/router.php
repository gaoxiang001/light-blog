<?php
return [
    'URL_ROUTER_ON'         =>  true,
    'URL_ROUTE_RULES'       => [ //定义路由规则
        'detail/:uid/:id' => array('Index/detail', 'status=1'), // 文章详情页
        'u/:uid'          => 'Index/index', // 文章列表页
        'error_404'       => 'Err/notFound', // 404页面
        'sign_in'         => 'Sign/sign_in', //登录页面
        'sign_up'         => 'Sign/sign_up', //注册页面
    ], 
    'URL_HTML_SUFFIX'       =>'',//伪静态后缀
];