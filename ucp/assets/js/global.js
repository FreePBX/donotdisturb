var DonotdisturbC = UCPMC.extend({
	init: function(){
	},
	settingsDisplay: function() {
		$('#dndenable').change(function() {
			$.post( "index.php?quietmode=1&module=donotdisturb&command=enable", {enable: $(this).is(':checked'), ext: ext}, function( data ) {
				$('#module-Donotdisturb .message').text(data.message).addClass('alert-'+data.alert).fadeIn('fast', function() {
					$(this).delay(5000).fadeOut('fast', function() {
						$('.masonry-container').packery();
					});
				});
				$('.masonry-container').packery();
			});
		});
	},
	settingsHide: function() {
		$('#dndenable').off('change');
	}
});
var Donotdisturb = new DonotdisturbC();
