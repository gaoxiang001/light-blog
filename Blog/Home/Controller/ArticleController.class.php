<?php
namespace Home\Controller;

use Home\Controller\CommonController;

class ArticleController extends CommonController 
{
    public function _initialize(){
        
    }

    /*
    * write
    */
    public function write()
    {
        $this->is_login();

        if (IS_POST) {
            $args = $_POST;
            $data = [
                'fk_member_id'     => session('member.member_id'),
                'fk_category_id'   => $args['category_id'],
                'fk_nav_id'        => $args['nav_id'],
                'article_type'     => $args['atc_type'],
                'article_source'   => $args['atc_source'],
                'article_title'    => $args['atc_title'],
                'article_remark'   => $args['atc_remark'],
                'article_content'  => $args['content'],
                'article_add_time' => date('Y-m-d H:i:s')
            ];
            $result = D('Article')->add($data);

            $this->ajaxReturn($result);
        }

        // 获取分类
        $category_item = D('Category')->getCategoryByMemberId(session('member.member_id'));

        $item = D('Nav')->getNav(session('member.member_id'));
        
        $this->assign('category_item', $category_item);
        $this->assign('item', $item);
        $this->display();
    }
}