var DonotdisturbC = UCPMC.extend({
	init: function(){
		this.stopPropagation = {};
	},
	prepoll: function() {
		var exts = [];
		$(".grid-stack-item[data-rawname=donotdisturb]").each(function() {
			exts.push($(this).data("widget_type_id"));
		});
		return exts;
	},
	poll: function(data) {
		var self = this;
		var change = function(extension, state, el) {
			if(!el.length) {
				return;
			}
			var current = el.is(":checked");
			if(state && !current) {
				self.stopPropagation[extension] = true;
				el.bootstrapToggle('on');
				self.stopPropagation[extension] = false;
			} else if(!state && current) {
				self.stopPropagation[extension] = true;
				el.bootstrapToggle('off');
				self.stopPropagation[extension] = false;
			}
		};
		$.each(data.states, function(ext,v) {
			var state = (v == "YES") ? true : false;

			change(ext, state, $(".grid-stack-item[data-rawname=donotdisturb][data-widget_type_id='"+ext+"'] input[name='dndenable']"));
			change(ext, state, $(".widget-extra-menu[data-module='donotdisturb'][data-widget_type_id='"+ext+"'] input[name='dndenable']"));
		});
	},
	displayWidget: function(widget_id,dashboard_id) {
		var self = this;
		$("div[data-id='"+widget_id+"'] .widget-content input[type='checkbox']").change(function(e) {
			var extension = $("div[data-id='"+widget_id+"']").data("widget_type_id"),
					checked = $(this).is(':checked');
			if(typeof self.stopPropagation[extension] !== "undefined" && self.stopPropagation[extension]) {
				return;
			}
			self.saveSettings(extension, {enable: checked}, function(data) {
				var el = $(".widget-extra-menu[data-module='donotdisturb'][data-widget_type_id='"+extension+"'] input[name='dndenable']");
				if(el.length) {
					if(checked) {
						el.bootstrapToggle('on');
					} else {
						el.bootstrapToggle('off');
					}
				}
			});
		});
	},
	saveSettings: function(extension, data, callback) {
		var self = this;
		self.stopPropagation[extension] = true;
		data.ext = extension;
		data.module = "donotdisturb";
		data.command = "enable";
		$.post( UCP.ajaxUrl, data, callback).always(function() {
			self.stopPropagation[extension] = false;
		});
	},
	displaySimpleWidget: function(widget_type_id) {
		var self = this;
		$(".widget-extra-menu[data-module=donotdisturb] input[type='checkbox']").change(function(e) {
			var extension = widget_type_id,
					checked = $(this).is(':checked');
			if(typeof self.stopPropagation[extension] !== "undefined" && self.stopPropagation[extension]) {
				return;
			}
			self.saveSettings(extension, {enable: $(this).is(':checked')}, function(data){
				if (data.status) {
					//update elements on the current dashboard if there are any
					var el = $(".grid-stack-item[data-rawname='donotdisturb'][data-widget_type_id='"+extension+"'] input[name='dndenable']");
					if(el.length) {
						if(checked) {
							el.bootstrapToggle('on');
						} else {
							el.bootstrapToggle('off');
						}
					}
				}
			});
		});
	}
});
