$(function(){
    //表单form ajax提交
    $("form").submit(function(e){
        var uri = $(this).attr('action');
        
        $.post(uri, $(this).serialize(), function(data){
            callSubmit(data);
        });
        return false;
    });

    // 添加分类
    $(".cate-name-ipt").keyup(function(){
        var cate_name = $(this).val();
        if (cate_name.length > 1) {
            submitShow();
        } else {
            submitHide();
        }
    });

    // submit可用
    function submitShow() {
        $(".btn-submit").removeAttr('disabled'); 
    }

    // submit不可用
    function submitHide() {
        $(".btn-submit").attr('disabled','disabled');
    }
    
});