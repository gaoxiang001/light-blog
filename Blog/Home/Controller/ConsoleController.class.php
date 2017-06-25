<?php
namespace Home\Controller;

use Think\Controller;

class ConsoleController extends AdminController
{
    public function index()
    {
        $category_model = D('Category');
        $item = $category_model->getCategoryByMemberId();
        
        $this->assign('item', $item);
        $this->display();
    }

    /*
    * console login
    * 
    * @param string user_name
    * @param string pass_word
    * 
    * @return
    **/
    public function login()
    {
        if (IS_POST) {
            $args = $this->_params();

            $member_model = D('Member');
            $result = $member_model->login($args);
            
            $this->_resposon($result);
        }

        $this->display();
    }
}