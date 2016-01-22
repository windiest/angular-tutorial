<h3>数据同步</h3>
<div id="ds-export">
	<p class="status"><a href="javascript:void(0)" class="button" onclick="fireExport();return false;">同步评论到多说</a></p>
</div>
<script type="text/javascript">
function fireExport(){
	var $ = jQuery;
    $('#ds-export').html('<p class="status"></p>');
    //$('#ds-export .status').removeClass('ds-export-fail').addClass('ds-exporting').html('处理中...');
    exportProgress('users', 0);
    return false;
}

function exportProgress(dataName, offset){
	var $ = jQuery, limit = 100;
	var lang = {'users':'用户', 'posts':'文章', 'comments':'评论'};
    $('#ds-export .status').html('正在同步' + lang[dataName] + '，已完成' + offset + ' <img src="<?php echo self::$pluginDirUrl . 'images/waiting.gif';?>" />');
	$.post(
        ajaxurl,
        {action: 'duoshuo_export_' + dataName, offset: offset, limit: limit},
        function(response) {
        	switch (response.result){
        	case 'success':
	        	if (response.status == 'complete'){
	            	switch (dataName){
	            	case 'users':
	                	exportProgress('posts', 0);
	                	break;
	            	case 'posts':
	                	exportProgress('comments', 0);
	                	break;
	            	case 'comments':
	                	$('#ds-export .status').removeClass('ds-exporting').addClass('ds-exported').html('同步完成');
	                default:
	            	}
	        	}
	        	else if (response.status == 'partial'){
	        		exportProgress(dataName, offset + limit);
	        	}
	        	break;
        	case 'failed':
	        default:
		        alert(response.message);
        	}
            /*
            switch (response.result) {
                case 'success':
                    status.html(response.msg).attr('rel', response.last_comment_id);
                    switch (response.status) {
                        case 'partial':
                            dsq_import_comments();
                            break;
                        case 'complete':
                            status.removeClass('dsq-importing').addClass('dsq-imported');
                            break;
                    }
                break;
                case 'fail':
                    status.parent().html(response.msg);
                    dsq_fire_import();
                break;
            }*/
        },
        'json'
    );
}
</script>