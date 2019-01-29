if (typeof jQuery === 'undefined') {
	throw new Error('BEL-CMS requires jQuery')
}

(function($) {
	"use strict";

	$('[data-toggle="tooltip"]').tooltip();

	if ($("#bel_cms_copyleft").length) {
		$('body').append('<a id="bel_cms_copyleft" style="display:none" href="https://bel-cms.be" title="BEL-CMS">Powered by Bel-CMS</a>');
	}

	$('.alertAjaxForm').submit(function(event) {
		event.preventDefault();
		bel_cms_alert_box($(this), 'POST');
	});

	$('.alertAjaxLink').click(function(event) {
		event.preventDefault();
		bel_cms_alert_box($(this), 'GET');
	});

	tinymce.init({
		selector: "textarea",
		fullpage_default_encoding: "UTF-8",
		plugins: "link, image, fullpage, textcolor, tinymcespellchecker, print",
		format: "textcolor, forecolor",
		link_list: [
			{title: 'PalaceWaR', value: 'https://palacewar.eu'},
			{title: 'Bel-CMS', value: 'https://bel-cms.be'}
  		],
		toolbar: "insertfile a11ycheck undo redo | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image | print",
		textcolor_cols: "5",  		
		image_caption: true,
		browser_spellcheck: true,
		language_url : '/assets/plugins/tinymce/plugins/langs/fr_FR.js',
		language: 'fr_FR',
	});

	_initFacebook();

	bel_cms_private_message();

})(jQuery);

function bel_cms_private_message () {
	var currentLink = $(location).attr('pathname').replace('/', '').toLowerCase();
	if (currentLink == 'blog' || currentLink == '' || currentLink == 'home' || currentLink == 'index.html') {
		var link = "Inbox/countUnreadMessage?json";
		$.getJSON(link, {
			format: "json"
		}).done(function(data) {
			if (data >= 1) {
				bel_cms_create_div_message();
				$("#bel_cms_private_message").modal('show');
			}
		});
	}
}
function bel_cms_create_div_message () {
	var $body = $('body');
	html  = '<div class="modal fade" id="bel_cms_private_message" tabindex="-1" role="dialog" aria-hidden="true">';
	html += '<div class="modal-dialog modal-dialog-centered" role="document">';
	html += '<div class="modal-content">';
	html += '<div class="modal-header">';
	html += '<h5 class="modal-title">Message priver</h5>';
	html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
	html += '<span aria-hidden="true">&times;</span>';
	html += '</button>';
	html += '</div>';
	html += '<div class="modal-body">';
	html += '<p>Vous avez un message priver</p>';
	html += '<p><a href="Inbox" title="Message priver">Lire le message</a></p>';
	html += '</div>';
	html += '<div class="modal-footer">';
	html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	$body.append(html);
}
/*###################################
# Function Alert box
###################################*/
function bel_cms_alert_box (objet, type) {
	/* Get Url */
	if (objet.attr('href')) {
		var url = objet.attr('href');
	} else if (objet.attr('action')) {
		var url = objet.attr('action');
	} else if (objet.data('url')) {
		var url = objet.data('url');
	} else {
		alert('No link sets');
	}
	/* serialize data */
	if ($(objet).is('form')) {
		var dataValue  = $(objet).serialize();
	} else if (objet.data('data') == 'undefined'){
		var dataValue  = objet.data('data');
	}
	/* remove div#alrt_bel_cms is exists */
	if ($('#alrt_bel_cms').height()) {
		$('#alrt_bel_cms').remove();
	}
	$('body').append('<div id="alrt_bel_cms">Chargement...</div>');
	$('#alrt_bel_cms').animate({ top: 0 }, 500);
	/* start ajax */
	$.ajax({
		type: type,
		url: url,
		data: dataValue,
		success: function(data) {
			var data = $.parseJSON(data);
			console.log(data);
			/* refresh page */
			if (data.redirect == undefined) {
				var redirect = false;
			} else {
				var redirect = true;
			}
			/* type color */
			if (data.type == undefined) {
				var type = 'blue';
			} else {
				var type = data.type;
			}
			/* link return */
			if (redirect) {
				setTimeout(function() {
					document.location.href=data.redirect;
				}, 3250);
			}
			/* add text */
			$('#alrt_bel_cms').addClass(type).empty().append(data.text);
		},
		error: function() {
			alert('Error function ajax');
		},
		beforeSend:function() {
			$('body').append('<div id="alrt_bel_cms">Chargement...</div>');
			$('#alrt_bel_cms').animate({ top: 0 }, 500);
		},
		complete: function() {
			$('textarea').val('');
			$('input:text').val('');
			bel_cms_alert_box_end(3);
		}
	});
}
/*###################################
# Function end Alert box
###################################*/
function bel_cms_alert_box_end (time) {
	parseInt(time);

	var time = time * 1000;

	setTimeout(function() {
		$('#alrt_bel_cms').animate({ top: '-35px' }, 300, function() {
			$(this).remove();
		});
	}, time);
}
function _initFacebook() {
	var $body = $('body');

	var self = this;

	$body.append('<div id="fb-root"></div>');

	(function (d, s, id) {
		if (location.protocol === 'file:') {
			return;
		}
		var js = void 0,
			fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {
			return;
		}
		js = d.createElement(s);js.id = id;
		js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8";
		fjs.parentNode.insertBefore(js, fjs);
	})(document, 'script', 'facebook-jssdk');

	// resize on facebook widget loaded
	window.fbAsyncInit = function () {
		FB.Event.subscribe('xfbml.render', function () {
		   // self.debounceResize(); annuler manque jQuery ui
		});
	};
}
