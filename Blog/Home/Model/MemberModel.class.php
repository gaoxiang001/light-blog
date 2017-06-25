<?php
/*
* @author gaox
* 
* member model
**/
namespace Home\Model;

use Think\Model;

class MemberModel extends Model
{
    /*
    * console login
    * 
    * @param string args['user_name']
    * @param string args['pass_word']
    * 
    * @return
    **/
    public function login($args)
    {
        $member_model = M('member');
        $member_name  = $args['user_name'];
        $member_pass  = getEnCodePass($args['pass_word']);
        $result       = [];

        $where = [
            'member_name' => $member_name,
            'member_pass' => $member_pass
        ];

        $info = $member_model->field('member_id, member_name')->where($where)->find();
        if (empty($info)) {
            $result['code'] = '1001';
        } else {
            $result['code'] = '1';
            $result['data'] = $info;
            session('member', $info);
        }
        getErrCode($result);

        return $result;
    }
}
