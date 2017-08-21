<?php
/*
* @author gaox
* 
* nav model
**/
namespace Home\Model;

use Think\Model;

class NavModel extends Model
{
    private $m;

    public function __construct()
    {
        $this->m = M('nav');
    }

    /*
    * get nav
    *
    * @param int $member_id
    * @param int $nav_id is null
    *
    * @return array
    */
    public function getNav($member_id, $nav_id = 0)
    {
        $where = [
            'fk_member_id'  => $member_id,
            'nav_is_delete' => 0
        ];
        if ($nav_id != 0) {
            $where['nav_id'] = $nav_id;
        }

        $item = $this->m
            ->where($where)
            ->field('nav_id, nav_title, nav_sort')
            ->order('nav_sort asc')
            ->select();

        if ($nav_id != 0) {
            return $item[0];
        }

        return $item;
    }

    /*
    * save nav
    *
    * @param array
    *
    * @return int row
    */
    public function saveNav($data)
    {
        if (!isset($data) || empty($data)) {
            return false;
        }
        if (isset($data['nav_id']) && !empty($data['nav_id'])) {
            $row_id = $this->m->save($data);
        } else {
            $count = $this->m
                ->where(['fk_member_id' => $data['fk_member_id'], 'nav_is_delete' => 0])
                ->count();
                
            if ($count >= 6) {
                $result = ['code' => '4001'];
                getErrCode($result);

                return $result;
            }

            $row_id = $this->m->add($data);
        }
        
        if ($row_id === false) {
            $result = ['code' => '0001'];
        } else {
            $result = ['code' => '1', 'nav_id' => $row_id];
        }
        getErrCode($result);

        return $result;
    }

    /*
    * delete nav
    * 
    * @param int $nav_id
    *
    * @return array
    */
    public function delNav($data)
    {
        if (!isset($data['nav_id']) || empty($data['nav_id'])) {
            $result = ['code' => '0003'];
            getErrCode($result);
            return $result;
        }

        $del_data = [
            'nav_id'        => $data['nav_id'],
            'nav_is_delete' => 1
        ];
        $row_id = $this->m->save($del_data);

        if ($row_id === false) {
            $result = ['code' => '0003'];
        } else {
            $result = ['code' => '1', 'nav_id' => $row_id];
        }
        getErrCode($result);

        return $result;
    }
}
