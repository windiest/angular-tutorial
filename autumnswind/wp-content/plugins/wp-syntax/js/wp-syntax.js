jQuery(document).ready(function($)
{
	$('.wp_syntax').bind(
	{
		mouseover: function()
		{
			var w = $(this).find('table').outerWidth();
			var hw = $(document).width() - $(this).offset().left - 20;
			
			/*
			 * Test code.
			 */
			/*var left, top;
			left = $(this).offset().left;
			top = $(this).offset().top;
			
			$(this)
				.appendTo('body')
				.css({
				'position': 'absolute',
				'left': left + 'px',
				'top': top + 'px'
			});
			*/
			
			if(w > $(this).outerWidth())
				$(this).css({'position':'relative', 'z-index':'9999', 'box-shadow':'5px 5px 5px #888', 'width':(w > hw ? hw : w)+'px'});
		},
		mouseout: function()
		{
			//$(this).removeAttr('style');
		}					
	});
});