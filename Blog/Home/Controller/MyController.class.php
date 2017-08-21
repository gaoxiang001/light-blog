<?php
namespace Home\Controller;

use Home\Controller\CommonController;

class MyController extends CommonController 
{
    // public function _initialize(){
    //     $this->is_login();
    // }

    /*
    * basic
    */
    public function basic()
    {
        $this->is_login();
        
        if (IS_POST) {
            $args = $_POST;

            $args['fk_member_id'] = session('member.member_id');
            $result = D('Site')->saveSite($args);

            if (!empty($args['member_avatar'])) {
                $member_data = [
                    'member_id'     => session('member.member_id'),
                    'member_avatar' => $args['member_avatar']
                ];
                D("Member")->editMember($member_data);
            }

            $this->ajaxReturn($result);
        }
        

        $info = D('Site')->getSiteDetail(session('member.member_id'));
        $this->assign('info', $info);
        $this->display();
    }

    /*
    * profile
    */
    public function profile()
    {
        $this->is_login();

        if (IS_POST) {
            $args = $_POST;
            $args['member_id'] = session('member.member_id');

            $result = D("Member")->editMember($args);

            $this->ajaxReturn($result);
        }

        $this->display();
    }

    /*
    * manager
    */
    public function manager()
    {
        $this->is_login();

        if (IS_POST) {
            $args              = $_POST;
            $args['member_id'] = session('member.member_id');
            $result            = D('Member')->editPassword($args);

            $this->ajaxReturn($result);
        }
        $this->display();
    }

    /*
    * site
    */
    public function site()
    {
        $this->is_login();

        if (IS_POST) {
            $args = $_POST;
            if ($args['type'] == 'nav') {
                // if (empty($args['nav_sort'])) {
                //     $args['nav_sort'] = 1;
                // }

                $args = array_merge(
                    $args,
                    [
                        'fk_member_id' => session('member.member_id'),
                        'nav_add_time' => date('Y-m-d H:i:s')
                    ]
                );
                unset($args['type']);

                $result = D("Nav")->saveNav($args);
                

                $this->ajaxReturn($result);
            }

            if ($args['type'] == 'del') {
                $result = D('Nav')->delNav($args);

                $this->ajaxReturn($result);
            }
        }
        $Nav_model = D('Nav');
        $item = $Nav_model->getNav(session('member.member_id'));

        $this->assign('item', $item);
        $this->display();
    }
}