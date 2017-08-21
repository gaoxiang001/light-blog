<?php
/*
* @author gaox
* 
* nav model
**/
namespace Home\Model;

use Think\Model;

class SiteModel extends Model
{
    private $m;

    public function __construct()
    {
        $this->m = M('site');
    }

    /*
    * get site
    **/
    public function getSiteDetail($member_id = '', $fields = '')
    {
        if ($member_id == '') {
            return false;
        }

        if ($fields == '') {
            $field = 'site_title, site_domain, site_slogan, site_remark, site_is_comment';
        } else {
            $field = $fields;
        }
        $info = $this->m
            ->where(['fk_member_id' => $member_id])
            ->field($field)
            ->find();

        return $info;
    }

    /*
    * save site
    */
    public function saveSite($data)
    {
        $result = ['code' => 1];
        
        if (!prohibitSite($data['site_domain'])) {
            $result['code'] = '1006';
            getErrCode($result);

            return $result;
        }

        $chk_domian_where = [
            'fk_member_id' => ['NEQ', $data['fk_member_id']],
            'site_domain'  => ['EQ', $data['site_domain']]
        ];
        $chk_domian = $this->m
            ->where($chk_domian_where)
            ->count();
        if ($chk_domian > 0) {
            $result['code'] = '1006';
            getErrCode($result);

            return $result;
        }

        $count = $this->m->where(['fk_member_id' => $data['fk_member_id']])->count();
        if ($count > 0) { // update
            $update = $this->m->where(['fk_member_id' => $data['fk_member_id']])->save($data);
        } else { // add
            $update = $this->m->add($data);
        }

        if ($update === false) {
            $result['code'] = '0001';
        }

        getErrCode($result);

        return $result;
    }
}
