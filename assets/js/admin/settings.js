( function ( $ ) {
	$( window ).ready( function(){
		$( '.loading-settings' ).remove();

		// Set first tab as active.
		$( '.cocart header a.tab:first-of-type' ).addClass( 'active' );

		// Show first settings section.
		$( '.cocart #settings-form h2:first-of-type' ).addClass( 'active' );
		$( '.cocart #settings-form table:first-of-type' ).addClass( 'active' );

		// If page loaded with hash, display settings section.
		if ( window.location.hash != false ) {
			var section = window.location.hash.split('#')[1] + '-settings';

			$( '.cocart header a.tab' ).removeClass( 'active' );
			$( '.cocart #settings-form h2' ).removeClass( 'active' );
			$( '.cocart #settings-form table' ).removeClass( 'active' );

			$( '.cocart header a.tab[data-target=' + section + ']' ).addClass( 'active' );
			$( '.cocart #settings-form h2#' + section ).addClass( 'active' );
			$( '.cocart #settings-form table#' + section ).addClass( 'active' );
		}

		// Change to settings section on navigation click.
		$( '.cocart header a.tab' ).click( function(e){
			var section = $(this).data("target");

			$( '.cocart header a.tab' ).removeClass( 'active' );
			$( '.cocart #settings-form h2' ).removeClass( 'active' );
			$( '.cocart #settings-form table' ).removeClass( 'active' );

			$( '.cocart header a.tab[data-target=' + section + ']' ).addClass( 'active' );
			$( '.cocart #settings-form h2#' + section ).addClass( 'active' );
			$( '.cocart #settings-form table#' + section ).addClass( 'active' );
		});
	});

	$( document ).ready( function(){
		$( 'input[type="submit"]#save-cocart' ).click( function(e){
			// Prevent Default functionality
			e.preventDefault();

			// Empties save results from previous save.
			$( '.save-results' ).empty();

			// Disable save button until Ajax completed.
			$( this ).prop( 'disabled', true );

			// Salt Key validation.
			var skip_salt = false;

			var salt_key = $( 'input[type="text"]#salt_key' ).val();

			// Check if salt key is already hashed so we don't hash a hash.
			var is_salt_hashed = salt_key.match( /^[a-f0-9]{32}$/gi ) ? true : false;

			if ( is_salt_hashed ) {
				console.log( 'Salt key is already hashed! Skipped saving field.' );
				skip_salt = true;
			}

			// If salt key field is disabled then it's defined, so we don't save this field.
			if ( $( 'input[type="text"]#salt_key' ).prop( 'disabled' ) ) {
				console.log( 'Salt key is already hashed in wp-config.php file! Skipped saving field.' );
				skip_salt = true;
			}

			// Prepare posted data.
			var ignore_fields = [ 'cocart-settings', '_wpnonce', '_wp_http_referer' ];
			var formData      = $( '#settings-form' ).serializeArray().reduce((obj, field) => {
				if ( $.inArray( field.name, ignore_fields ) === -1 ) {
					if ( field.name === 'salt_key' && skip_salt === true ) {
						console.log( 'Salt key has not changed!' );
					} else {
						obj[field.name] = field.value;
					}
				}

				return obj;
			}, {});

			//var settings = $( 'input[name="cocart-settings"]' ).val();

			// Save settings.
			$.ajax({
				method: 'POST',
				url: cocart_params.root + 'cocart/settings/save?_wpnonce=' + cocart_params.nonce,
				data: JSON.stringify( formData, null, ' ' ),
				contentType: 'application/json; charset=utf-8',
				dataType: 'json',
				success: function( response ) {
					$( '.save-results' ).html( '<div class="notice notice-success"></div>' );
					$( '.notice-success' ).append( "<p><strong>" + cocart_params.saved_message + "</strong></p>" ).show();

					if ( typeof response['general']['salt_key'] !== "undefined" ) {
						$( 'input[type="text"]#salt_key' ).val( response['general']['salt_key'] );
					}
				},
				error: function( xhr ) {
					var errorMessage = xhr.status + ': ' + xhr.statusText;

					$( '.save-results' ).html( '<div class="notice notice-error"></div>' );
					$( '.notice-error' ).append( "<p><strong>" + errorMessage + "</strong></p>" ).show();
				},
				complete: function() {
					// Re-enable save button now Ajax is complete.
					$( 'input[type="submit"]#save-cocart' ).prop( 'disabled', false );

					// Hide notice after 5 seconds.
					setTimeout( function() {
						$( '.notice' ).hide( 'slow' );
					}, 5000 );
				}
			});
		});
	});
} )( jQuery, cocart_params );
