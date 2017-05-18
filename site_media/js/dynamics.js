$(document).ready(function () {

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
									LINK HIGHLIGHT
	:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    
    /*var url = window.location;
    
// Will only work if string in href matches with location
    //$('.nav-item a[href="' + url + '"]').addClass('active');

// Will also work for relative and absolute hrefs
    $('.nav-item a').filter(function () {
        return this.href == url;
    }).addClass('active');*/

    /*$(function () {
        $('.nav-item a').on('click', function () {
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');
            
        });
    });*/
    $(function(){
		$('.nav-item a').filter(function(){return this.href==location.href}).addClass('active').siblings().removeClass('active')
		$('.nav-item a').click(function(){
			$(this).parent().addClass('active').siblings().removeClass('active')	
		})
	})
});