/**
 * File search.js.
 *
 * Handles toggling the search form in the header.
 */
( function() {
	var container, button, form, toggled;

	container = document.getElementById( 'search' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	form = container.getElementsByTagName( 'form' )[0];

	// Hide search toggle button if form is missing and return early.
	if ( 'undefined' === typeof form ) {
		button.style.display = 'none';
		return;
	}

	form.setAttribute( 'aria-expanded', 'false' );

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			form.setAttribute( 'aria-expanded', 'false' );
		} else {
			
			// Remove toggle class from any other open toggleable elements
			toggled = document.getElementsByClassName( 'toggled' );
			Array.prototype.forEach.call( toggled, function( el ) {
				el.className = el.className.replace( ' toggled', '' );
			});
			
			// Then add toggled class to associated element
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			form.setAttribute( 'aria-expanded', 'true' );
		}
	};


} )();
