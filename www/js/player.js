var player;
function onYouTubeIframeAPIReady() {
	player = new YT.Player('videobox-container', {
		events: {
			'onStateChange': onPlayerStateChange
		}
	});
}

function onPlayerStateChange(event){
	if($(window).width() >= 992){
		if(event.data == YT.PlayerState.PLAYING){
			$('#videobox-title').fadeOut(1000);
			$('#videobox-description').fadeOut(1000);
		}
		if(event.data == YT.PlayerState.PAUSED){
			$('#videobox-title').fadeIn(1000);
			$('#videobox-description').fadeIn(1000);
		}
	}
}