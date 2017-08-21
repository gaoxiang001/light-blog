<?php
namespace Home\Controller;

use Think\Controller;

class ErrController extends Controller
{
    /*
    * 404
    */
    public function notFound()
    {
        $this->display('/Common/404');
    }
}