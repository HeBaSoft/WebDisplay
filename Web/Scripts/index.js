var lastScrollTop = 0;
var scrolling = false;

function ScrollTo(element) {
	if(scrolling == false) {
		scrolling = true;
		$("body").scrollTo($("#" + element).first(), {duration: 800});
		setTimeout(function(){ scrolling = false; }, 850);
	}
}

$(document).ready(function() {

	$(window).scroll(function() {
		var st = $(this).scrollTop();
		//ScrollDown
		if (st > lastScrollTop) {
			if(st >= 0 && st <= 128) {
				ScrollTo("PageDescriptionWrapper");
			} else if (st >= $("#PageDescriptionWrapper").position().top + 0 && st <= $("#PageDescriptionWrapper").position().top + 128) {
				ScrollTo("PageInfoWrapper");
			}
		}
		lastScrollTop = st;
	});
	
});
