/*
 * SimpleModal Contact Form
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */

jQuery(function ($) {
	
	var contact = {
		message: null,
		init: function () {
			$('.report-but').on('click' , function (e) {
                            console.log('t');
				e.preventDefault();
                                
                                var postid =  $(this).data('id');

				// load the contact form using ajax
				// load the contact form using ajax
				$.post(gamesreport.ajaxurl, {action: 'report_game_form', gameid:postid }, function(data){
					// create a modal dialog with the data
					$(data).modal({
						closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
						position: ["15%",],
						overlayId: 'contact-overlay',
						containerId: 'contact-container',
						onOpen: contact.open,
						onShow: contact.show,
						onClose: contact.close
					});
				});
	
				});
			
		},
		open: function (dialog) {
			// dynamically determine height
			var h = 350;
		

			var title = $('#contact-container .contact-title').html();
			$('#contact-container .contact-title').html(gamesreport.loading);
			dialog.overlay.fadeIn(200, function () {
				dialog.container.fadeIn(200, function () {
					dialog.data.fadeIn(200, function () {
						$('#contact-container .contact-content').fadeIn(200,
						 function () {
							$('#contact-container .contact-title').html(title);
							$('#contact-container form').fadeIn(200, function () {
								$('#contact-container #contact-name').focus();

								$('#contact-container .contact-cc').click(function () {
									var cc = $('#contact-container #contact-cc');
									cc.is(':checked') ? cc.attr('checked', '') : cc.attr('checked', 'checked');
								});
							});
						});
					});
				});
			});
		},
		show: function (dialog) {
			$('#contact-container .contact-send').click(function (e) {
				e.preventDefault();
				// validate form
				if (contact.validate()) {
					var msg = $('#contact-container .contact-message');
					msg.fadeOut(function () {
						msg.removeClass('contact-error').empty();
					});
					$('#contact-container .contact-title').html(gamesreport.sending);
					$('#contact-container form').fadeOut(200);
					$('#contact-container .contact-content').animate({
						height: '80px'
					}, function () {
						$('#contact-container .contact-loading').fadeIn(200, function () {
							$.ajax({
								url: gamesreport.ajaxurl,
								data: $('#contact-container form').serialize() + '&action=report_game',
								type: 'post',
								cache: false,
								dataType: 'html',
								success: function (data) {
									$('#contact-container .contact-loading').fadeOut(200, function () {
										$('#contact-container .contact-title').html('Thank you!');
										msg.html(data).fadeIn(200);
									});
								},
								error: contact.error
							});
						});
					});
				}
				else {
					if ($('#contact-container .contact-message:visible').length > 0) {
						var msg = $('#contact-container .contact-message div');
						msg.fadeOut(200, function () {
							msg.empty();
							contact.showError();
							msg.fadeIn(200);
						});
					}
					else {
						
							$('#contact-container .contact-message').fadeIn(200, contact.showError);
					}
					
				}
			});
		},
		close: function (dialog) {
			$('#contact-container .contact-message').fadeOut();
			$('#contact-container .contact-title').html(gamesreport.goodbye);
			$('#contact-container form').fadeOut(200);
			$('#contact-container .contact-content').fadeIn(200, function () {
				dialog.data.fadeOut(200, function () {
					dialog.container.fadeOut(200, function () {
						dialog.overlay.fadeOut(200, function () {
							$.modal.close();
						});
					});
				});
			});
		},
		error: function (xhr) {
			alert(xhr.statusText);
		},
		validate: function () {
			contact.message = '';
			if (!$('#contact-container #contact-name').val()) {
				contact.message += gamesreport.nameerror;
			}

			var email = $('#contact-container #contact-email').val();
			if (!email) {
				contact.message += gamesreport.emailerror;
			}
			else {
				if (!contact.validateEmail(email)) {
					contact.message += gamesreport.emailerror2;
				}
			}

			if (!$('#contact-container #contact-message').val()) {
				contact.message +=gamesreport.messageerror;
			}
			
			if($('input#report-code').length > 0){
				
				if (!$('input#report-code').val()) {
					contact.message +='Empty capcha';
				} else {
					if (!contact.validateCaptcha()) {
						contact.message += 'wrong capcha';
					}
				}
			}	

			if (contact.message.length > 0) {
				return false;
			}
			else {
				return true;
			}
		},
		validateEmail: function (email) {
			var at = email.lastIndexOf("@");

			// Make sure the at (@) sybmol exists and  
			// it is not the first or last character
			if (at < 1 || (at + 1) === email.length)
				return false;

			// Make sure there aren't multiple periods together
			if (/(\.{2,})/.test(email))
				return false;

			// Break up the local and domain portions
			var local = email.substring(0, at);
			var domain = email.substring(at + 1);

			// Check lengths
			if (local.length < 1 || local.length > 64 || domain.length < 4 || domain.length > 255)
				return false;

			// Make sure local and domain don't start with or end with a period
			if (/(^\.|\.$)/.test(local) || /(^\.|\.$)/.test(domain))
				return false;

			// Check for quoted-string addresses
			// Since almost anything is allowed in a quoted-string address,
			// we're just going to let them go through
			if (!/^"(.+)"$/.test(local)) {
				// It's a dot-string address...check for valid characters
				if (!/^[-a-zA-Z0-9!#$%*\/?|^{}`~&'+=_\.]*$/.test(local))
					return false;
			}

			// Make sure domain contains only valid characters and at least one period
			if (!/^[-a-zA-Z0-9\.]*$/.test(domain) || domain.indexOf(".") === -1)
				return false;	

			return true;
		},
		showError: function () {
			$('#contact-container .contact-message')
				.html($('<div class="contact-error"></div>').append(contact.message))
				.fadeIn(200);
		},
		
		validateCaptcha: function()
			{
			    
			    responseField = $("input#report-code").val();
			    hashField = $("input#hashcode").val();
			    		    
			 	
			    var html = $.ajax({
			        type: "POST",
			        url: gamesreport.ajaxurl,
			        data: "hash="+hashField+"&code=" + responseField+ '&action=checkcapcha',
			        async: false,
			        cache: false
			        }).responseText;
			 
			    //console.log( html );
			    if(html == "success") {
			        //Add the Action to the Form
			       return true;
			    } else {
			        return false;
			        Recaptcha.reload();
			    }
			}   
		
		
	};

	contact.init();

});