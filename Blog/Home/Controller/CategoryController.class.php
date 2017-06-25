<?php
namespace Home\Controller;

use Home\Controller\AdminController;

class CategoryController extends AdminController
{
    public function index()
    {
        if (IS_POST) {
            $args           = $this->_params();
            $category_model = D('Category');
            $result         = $category_model->editCategory($args);

            $this->_resposon($result);
        }
        
        $category_model = D('Category');
        $item = $category_model->getCategoryByMemberId();
        
        $this->assign('item', $item);
        $this->display();
    }

    public function addCategory()
    {
        if (IS_POST) {
            $args           = $this->_params();
            $category_model = D('Category');
            $result         = $category_model->addCategory($args);

            $this->_resposon($result);
        }

        $this->display();
    }
}