jQuery(document).ready(function($){
	changePage ();
	deleteAvatar ();

	$('.bel_cms_jquery_avatar_sel').click(function(event) {
		event.preventDefault();
		var href = $(this).attr('href').replace('#', '');

		/* remove div#alrt_bel_cms is exists */
		if ($('#alrt_bel_cms').height()) {
			$('#alrt_bel_cms').remove();
		}
		/* start ajax */
		$.ajax({
			type: 'POST',
			url: 'User/send&json',
			data: "send=changeavatar&value=" + href,
			success: function(data) {
				var data = $.parseJSON(data);
				/* type color */
				if (data.type == undefined) {
					var type = 'warning';
				} else {
					var type = data.type;
				}
				/* add text */
				$('#alrt_bel_cms').addClass(type).empty().append(data.text);
			},
			error: function() {
				alert('Error function ajax');
			},
			beforeSend:function() {
				$('body').append('<div id="alrt_bel_cms">Loading...</div>');
				$('#alrt_bel_cms').animate({ top: 0 }, 500);
			},
			complete: function() {
				$('#bel_cms_user_avatar > img').attr('src', href);
				bel_cms_alert_box_end(1);
			}
		});
		return false;
	});
});

function deleteAvatar() {
	$('.bel_cms_jquery_avatar_del').click(function(event) {
		event.preventDefault();
		var href = $(this).attr('href').replace('#', '');
		var trId = $(this).data('id');
		/* start ajax */
		$.ajax({
			type: 'POST',
			url: 'User/send&ajax',
			data: "send=deleteavatar&value="+href,
			success: function(data) {
				$('#alert_ajax').empty().append(data);
				$(trId).remove();
			},
			beforeSend:function() {
				$('#alert_ajax').empty().append('Loading...');
			},
			complete: function() {
				bel_cms_alert_box_end(1);
			}
		});
	});
}

function changePage() {
	$('#bel_cms_user_main_left_menu li a ').click(function(event) {
		event.preventDefault();
		$('#bel_cms_user_main_left_menu li').removeClass('active');
		var id = $(this).attr('href').replace('#', '');
		if (document.getElementById(id)) {
			$('#bel_cms_user_main_right > div').animate({
				opacity: 0,
			},
			250, function () {
				$('#bel_cms_user_main_right > div').removeClass('active');
				$('#bel_cms_user_main_right > div#' + id).animate({
					opacity: 1,
				},
				250).addClass('active');
			});
			$('#bel_cms_user_main_left_menu li').each(function() {
				$(this).removeClass('active');
			});
			$(this).parent().addClass('active');
		} else {
			$('#bel_cms_user_main_right > div').removeClass('active');
			$('#bel_cms_user_main_left_menu li').first().addClass('active');
			$('#bel_cms_user_main_right > div').animate({
				opacity: 0,
			},
			250, function () {
				$('#bel_cms_user_main_right > div').first().animate({
					opacity: 1,
				},
				250).addClass('active');
			});

			$('body').prepend('<div id="bel_cms_box_alert_jquery" class="red">No Exists link</div>');
			$('#bel_cms_box_alert_jquery').animate({
				bottom: 0,
			},250);

			bel_cms_alert_box_end(1);

		}
	});
}
