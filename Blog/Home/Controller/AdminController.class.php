<?php
namespace Home\Controller;

use Think\Controller;

class AdminController extends Controller
{
    public function _initialize(){
        $curr_action = substr(__CONTROLLER__, 1);
        $this->assign('curr_action', $curr_action);
    }

    /*
    * ajax请求统一输出方法(子类调用 不能被重写)
    * 
    * @param array
    *
    * @return json
    **/
    final protected function _resposon($data) {
        $this->ajaxReturn($data);
    }

    /*
    * 获取post参数(子类继承 不能重写)
    *
    * @return array
    **/
    final protected function _params() {
        return $_POST;        
    }
}