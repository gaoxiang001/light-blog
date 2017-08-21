<?php
/*
* @author gaox
* 
* article model
**/
namespace Home\Model;

use Think\Model;

class ArticleModel extends Model
{
    private $m;

    public function __construct()
    {
        $this->m = M('article');
    }

    /*
    * add article
    */
    public function add($data)
    {
        $result = ['code' => '1'];
        

        if ($data['fk_category_id'] == '') {
            $result['code'] = '3001';
        }
        if ($data['article_title'] == '') {
            $result['code'] = '3002';
        }
        if ($data['article_content'] == '') {
            $result['code'] = '3003';
        }
        if ($result['code'] > '1') {
            getErrCode($result);
            return $result;
        }
        
        $article_id = $this->m->add($data);
        if ($article_id) {
            $result['data']['article_id'] = $article_id;
        } else {
            $result['code'] = '0001';
        }
        getErrCode($result);

        return $result;
    }

    /*
    * list article
    */
    public function articlList($uid, $nav_id, $p)
    {
        $p         = $p?$p:1;
        $page_size = 25;

        $where = [
            't_article.fk_member_id'      => $uid,
            't_article.article_is_delete' => 0
        ];

        if ($nav_id != 0) {
            $where['t_article.fk_nav_id'] = $nav_id;
        }

        $field = [
            'article_id',
            'article_title',
            'article_remark',
            'article_add_time',
            'category_name'
        ];

        $count = $this->m
            ->join('left join t_category as c ON t_article.fk_category_id=c.category_id')
            ->where($where)
            ->count();

        // 实例化分页类 传入总记录数和每页显示的记录数
        $page = new \Think\Page($count, $page_size, ['u' => $uid]);

        $page->url = "/u/{$uid}/p/".urlencode('[PAGE]');
        
        $show = $page->show();// 分页显示输出

        $item = $this->m
            ->join('left join t_category as c ON t_article.fk_category_id=c.category_id')
            ->where($where)
            ->field($field)
            ->page($p.','.$page_size)
            ->order('article_add_time desc')
            ->select();
        
        return ['item' => $item, 'page_show' => $show];
    }

    /*
    * detail article
    */
    public function getDetailById($id = '')
    {
        $where = [
            'article_id'        => $id,
            'article_is_delete' => 0
        ];

        $field = [
            'article_id',
            'article_title',
            'article_content',
            'article_add_time',
            'category_name',
            'article_type',
            'article_source'
        ];

        $item = $this->m
            ->join('left join t_category as c ON t_article.fk_category_id=c.category_id')
            ->where($where)
            ->field($field)
            ->find();

        return $item;
    }

    /*
    * 类别分组总共文章数量
    */
    public function getCategoryGroup($member_id)
    {
        $where = [
            't_article.fk_member_id'      => $member_id,
            't_article.article_is_delete' => 0
        ];

        $result = $this->m
            ->join('left join t_category as c ON t_article.fk_category_id=c.category_id')
            ->where($where)
            ->field('count(1) AS total, category_id, category_name')
            ->group('fk_category_id')
            ->order('total desc')
            ->select();

        return $result;
    }
}
