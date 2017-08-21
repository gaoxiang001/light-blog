<?php
namespace Home\Controller;

use Think\Controller;

class SignController extends Controller 
{
    /*
    * sign in
    */
    public function sign_in()
    {
        if (IS_POST) {
            $args = $_POST;

            $member_model = D('Member');
            $result = $member_model->login($args);
            
            $this->ajaxReturn($result);
        }

        $this->display();
    }

    /*
    * sign up
    */
    public function sign_up()
    {
        if (IS_POST) {
            $args = $_POST;

            $result = D('Member')->register($args);
            $this->ajaxReturn($result);
        }
        $this->display();
    }

    /*
    * sign out
    */
    public function sign_out()
    {
        session('member', null);
        $this->redirect('/sign_in');
    }
}