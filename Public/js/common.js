$(document).ready(function () {
	$('[data-toggle="offcanvas"]').click(function () {
		$('.row-offcanvas').toggleClass('active')
	});

    //表单form ajax提交
    $("form").submit(function(e){
        var uri = $(this).attr('action');
        
        $.post(uri, $(this).serialize(), function(data){
            callSubmit(data);
        });
        return false;
    });
});

var Global = {
    /* success=成功 info=提示 warning=警告 danger=危险 */
    alert : function(msg = '', level = 'info'){
        var level_name = '提示';
        if (level == 'success') {
            level_name = '成功';
        }
        if (level == 'info') {
            level_name = '提示';
        }
        if (level == 'warning') {
            level_name = '警告';
        }
        if (level == 'danger') {
            level_name = '错误';
        }
        var html = '<div class="alert alert-'+level+' alert-dismissible fade in" style="display:none" role="alert">';
        html += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        html += "<strong>"+level_name+"：</strong> "+msg+"</div>";

        $('body').append(html);
        $('.alert').slideDown();

        setTimeout(function(){
            $('.alert').alert('close');
        }, 2000);
    },
    is_number : function(str) { // 数字
        var reg = new RegExp("^[0-9]*$");

        if (!reg.test(str)) {
            return false;
        } else {
            return true;
        }
    },
    is_not_zh : function(str) { // 数字 字母 下划线
        var reg = new RegExp("^[a-zA-Z0-9_-]+$");

        if (!reg.test(str)) {
            return false;
        } else {
            return true;
        }
    },
    is_validate : function(str) { // 特殊字符
        var strRegex = "[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]";
        var reg = new RegExp(strRegex);

        if (reg.test(str)) {
            return false;
        } else {
            return true;
        }
    }
};