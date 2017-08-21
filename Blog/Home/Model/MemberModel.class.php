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

        $field = [
            'site_domain',
            'member_id',
            'member_name',
            'member_nick',
            'member_avatar',
            'member_sex',
            'member_email'
        ];

        $info = $member_model
                    ->join('left join t_site AS site ON site.fk_member_id=t_member.member_id')
                    ->field($field)
                    ->where($where)
                    ->find();

        if (!empty($info['member_avatar']) && $info['member_avatar'] != '') {
            $info['member_avatar'] = C("IMG").$info['member_avatar'];
        }
        if (!isset($info['site_domain']) && !empty($info)) {
            $info['site_domain'] = '';
        }
        

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

    /*
    * register
    * 
    * @param string args['user_nick']
    * @param string args['user_name']
    * @param string args['pass_word']
    * 
    * @return int ['code' => 'err code', 'member_id' => 1]
    **/
    public function register($args)
    {
        $member_model = M('member');
        $result       = ['code' => 1];
        $member_name  = $args['user_name'];
        $member_nick  = $args['user_nick'];
        $member_pass  = getEnCodePass($args['pass_word']);

        $count = $member_model->where("member_name='{$member_name}'")->count();
        if ($count > 0) {
            $result['code'] = '1002';
            getErrCode($result);

            return $result;
        }

        $data = [
            'member_name'     => $member_name,
            'member_pass'     => $member_pass,
            'member_nick'     => $member_nick,
            'member_add_time' => date('Y-m-d H:i:s')
        ];
        $member_id = $member_model->add($data);

        if (!$member_id) {
            $result['code'] = '0001';
        } else {
            $result['member_id'] = $member_id;
        }
        getErrCode($result);
        
        //category nav
        $nav_data = [
            'fk_member_id' => $member_id,
            'nav_title'    => 'Home',
            'nav_sort'     => 0,
            'nav_add_time' => date('Y-m-d H:i:s')
        ];
        D('Nav')->saveNav($nav_data);

        return $result;
    }

    /*
    * editMember
    */
    public function editMember($data)
    {
        $member_model = M('member');
        $result       = ['code' => 1];

        if (isset($data['member_email']) && !empty($data['member_email'])) {
            $where = [
                'member_email'     => ['EQ' => $data['member_email']],
                'member_is_delete' => ['EQ' => 0],
                'member_id'        => ['NEQ' => $data['member_id']]
            ];
            $mail_cnt = $member_model
                ->where($where)
                ->count();
            if ($mail_cnt > 0) {
                $result['code'] = '1003';
                getErrCode($result);

                return $result;
            }
        }
        
        $update = $member_model->save($data);

        if ($update === false) {
            $result['code'] = '0002';
        }

        // update session
        foreach ($data as $key => $value) {
            if ($key == 'member_avatar') {
                session("member.{$key}", C('IMG').$value);
            } else {
                session("member.{$key}", $value);
            }
        }

        getErrCode($result);

        return $result;
    }

    /*
    * edit password
    */
    public function editPassword($data)
    {
        $member_model = M('member');
        $result       = ['code' => 1];

        if ($data['member_pass'] != $data['confirm_pass']) {
            $result['code'] = '1004';
            getErrCode($result);

            return $result;
        }

        // validate old password
        $old_where = [
            'member_id' => $data['member_id'],
            'member_pass' => getEnCodePass($data['old_pass'])
        ];
        $validate_old = $member_model
            ->where($old_where)
            ->count();
        if ($validate_old == 0) {
            $result['code'] = '1004';
            getErrCode($result);

            return $result;
        }

        $edit_data = [
            'member_id'   => $data['member_id'],
            'member_pass' => getEnCodePass($data['member_pass'])
        ];
        $update = $member_model->save($edit_data);

        if ($update === false) {
            $result['code'] = '0002';
        }
        getErrCode($result);

        return $result;
    }

    /*
    * 根据二级域名获取站点信息
    */
    public function getSite($where)
    {
        $field = [
            'member_id',
            'member_nick',
            'site_title',
            'site_slogan',
            'site_remark',
            'site_is_comment'
        ];
        $result = M('site')
            ->join('right join t_member ON t_member.member_id=t_site.fk_member_id')
            ->field($field)
            ->where($where)
            ->find();
        
        return $result;
    }
}
