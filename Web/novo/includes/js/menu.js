$(function(){

	collapsedHeight = $("#menu li").height();

    //When mouse rolls over
    $("#menu li").mouseover(function(){
        $(this).stop().animate({height:'130px'},{queue:false, duration:600, easing: 'easeOutBounce'});
    });

    //When mouse is removed
    $("#menu li").mouseout(function(){
        $(this).stop().animate({height:collapsedHeight},{
			queue:false,
			duration:600,
			easing: 'easeOutBounce',
			complete: function() {
				console.log($.colorbox.element());
			}
		});
    });

});