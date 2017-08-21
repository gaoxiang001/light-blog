<?php
namespace Home\Controller;

use Home\Controller\CommonController;

class IndexController extends CommonController 
{
    public function index()
    {
        $p             = $_GET['p'];
        $uid           = $this->uid;
        $nav_id        = $_GET['nid']?$_GET['nid']:0;
        $article_model = D('Article');
        
        // 获取文章
        $article_list = $article_model->articlList($uid, $nav_id, $p);

        // 获取导航
        $nav_item = D('Nav')->getNav($uid);

        // 获取文章分类数量
        $article_group = $article_model->getCategoryGroup($uid);

        $this->assign('article_group', $article_group);
        $this->assign('nav_item', $nav_item);
        $this->assign('uid', $uid);
        $this->assign('result', $article_list);
        $this->display();
    }

    public function detail()
    {
        $article_id   = $_GET['id'];
        $article_type = [
            '1' => '原创',
            '2' => '转载',
            '3' => '翻译'
        ];

        $article_model = D('Article');
        $info = $article_model->getDetailById($article_id);
        $info['subtitle'] = $article_type[$info['article_type']].' ';
        $info['subtitle'] .= date("Y/m/d", strtotime($info['article_add_time']));

        $this->assign('info', $info);
        $this->display();
    }
}