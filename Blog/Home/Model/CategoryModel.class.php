<?php
/*
* @author gaox
* 
* category model
**/
namespace Home\Model;

use Think\Model;

class CategoryModel extends Model
{
    private $m;

    public function __construct()
    {
        $this->m = M('category');
    }

    public function getCategoryByMemberId($member_id = '')
    {
        $item = $this->m
            ->where("(fk_member_id={$member_id} OR fk_member_id=0) AND category_delete=0")
            ->field('category_id, category_name, category_add_time')
            ->order('category_add_time asc')
            ->select();

        return $item;
    }

    /*
    * add category
    */
    public function addCategory($args)
    {
        $result = [];
        $data = [
            'fk_member_id'      => session('member.member_id'),
            'category_name'     => $args['category_name'],
            'category_add_time' =>date('Y-m-d H:i:s', time())
        ];
        
        $category_id = $this->m->add($data);
        if ($category_id) {
            $result['code'] = 1;
            $result['data']['category_id'] = $category_id;
        } else {
            $result['code'] = '2001';
        }
        getErrCode($result);

        return $result;
    }

    /*
    * edit category
    */
    public function editCategory($args)
    {
        $result = ['code' => 1];
        $data = ['category_id' => $args['category_id']];

        if (isset($args['category_name'])) {
            $data['category_name'] = $args['category_name'];
        }

        if (isset($args['category_delete'])) {
            $data['category_delete'] = $args['category_delete'];
        }

        $update = $this->m->save($data);
        if ($update === false) {
            $result['code'] = '2002';
        }
        getErrCode($result);

        return $result;
    }
}
