<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{
    protected $domain;
    protected $site = [];
    protected $uid;

    public function _initialize(){
        // 获取二级域名
        $domain_arr = explode(".", $_SERVER['HTTP_HOST']);
        if ($domain_arr[0] == 'www') {
            // TOTD: 会修改-------
            $this->display('/Home/index');
            die();
        }
        $this->domain = $domain_arr[0];
        
        // uid
        $this->uid = $_GET['uid'];
        
        // 获取站点信息
        $this->getSite(); 
        $this->assign('site', $this->site);
    }

    /*
    * 获取站点信息
    */
    final protected function getSite()
    {
        // 站点基本信息
        if ($this->domain == 'blog') {
            if (empty($this->uid)) {
                $uid = session('member.member_id');
            } else {
                $uid = $this->uid;
            }
            $where = ['member_id' => $uid];
        } else {
            $where = ['site_domain' => $this->domain];
        }
        $site_arr = D('Member')->getSite($where);

        if (empty($site_arr)) {
            $this->redirect('/error_404', [], 0, '页面跳转中...');
        }
        $this->uid  = $site_arr['member_id'];
        $this->site['basic'] = $site_arr;
        
        // 导航信息
        $nav_item = D('Nav')->getNav($this->uid);
        foreach ($nav_item as $key => &$value) {
            if ($this->domain != 'blog') {
                if ($value['nav_sort'] == 0) {
                    $href = '/';
                } else {
                    $href = "/u/{$this->uid}/nid/{$value['nav_id']}";
                }
            } else {
                if ($value['nav_sort'] == 0) {
                    $href = "/u/{$this->uid}";
                } else {
                    $href = "/u/{$this->uid}/nid/{$value['nav_id']}";
                }
            }
            $value['href'] = $href;
        }

        $this->site['nav'] = $nav_item;
    }

    /*
    * is login(子类调用 不能被重写)
    * 
    * @param null
    *
    * @return null
    **/
    final protected function is_login() {
        $member = session('member');
        if (!isset($member)) {
            $this->redirect('/sign_in', [], 0, '页面跳转中...');
        }
    }

    /*
    * upload images
    */
    public function upload()
    {
        $upload            = new \Think\Upload();
        $upload->maxSize   = 3145728;
        $upload->exts      = ['jpg', 'gif', 'png', 'jpeg'];
        $upload->rootPath  = './Uploads/';
        $upload->autoSub   = true;
        $upload->subName   = '';
        $upload->savePath  = date('Y').'/'.date('m').'/'.date('d').'/';
        

        $info   = $upload->upload();
        $result = ['code' => 1];
        if(!$info) {
            $result['code'] = '0';
            $result['msg']  = $upload->getError();

            $this->ajaxReturn($result);
        }else{// 上传成功
            if ($_GET['editorid'] == 'myEditor') { // 富文本上传图片
                $result = [
                    'originalName' => $info->name,
                    'name'         => $info['upfile']['savename'],
                    'url'          => C('IMG').$info['upfile']['savepath'].$info['upfile']['savename'],
                    'size'         => $info['size'],
                    'state'        => 'SUCCESS'
                ];
                echo json_encode($result);exit();
            } else {
                $result['msg']  = 'success';
                $result['data'] = [
                    'url'    => C('IMG').$info['file']['savepath'].$info['file']['savename'],
                    'avatar' => $info['file']['savepath'].$info['file']['savename']
                ];
            }
            $this->ajaxReturn($result);
        }
    }
}