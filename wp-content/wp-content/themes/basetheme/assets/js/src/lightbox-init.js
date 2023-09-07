/* global SimpleLightbox */
/**
 * File lightbox-init.js.
 * Gets Lightbox working for the Theme.
 */

(function() {
	'use strict';
	var thebaseThemeLightbox = {
		checkImage: function( element ) {
			return /(png|jpg|jpeg|gif|tiff|bmp)$/.test(
				element.getAttribute( 'href' ).toLowerCase().split( '?' )[0].split( '#' )[0]
			);
		},
		findImages: function() {
			var foundLinks = document.querySelectorAll( 'a[href]:not(.tb-no-lightbox):not(.custom-link):not(.kb-gallery-item-link):not(.tb-core-gallery-lightbox)' );
			if ( ! foundLinks.length ) {
				return;
			}
			if ( foundLinks ) {
				for ( let i = 0; i < foundLinks.length; i++ ) {
					if ( thebaseThemeLightbox.checkImage( foundLinks[ i ] ) ) {
						foundLinks[ i ].classList.add( 'tb-lightbox' );
						new SimpleLightbox({
							elements: [ foundLinks[ i ] ],
						});
					}
				}
			}
		},
		findGalleries: function() {
			var foundGalleries = document.querySelectorAll( '.wp-block-gallery' );
			if ( ! foundGalleries.length ) {
				return;
			}
			if ( foundGalleries ) {
				for ( let i = 0; i < foundGalleries.length; i++ ) {
					var foundLinks = foundGalleries[ i ].querySelectorAll( '.blocks-gallery-item a' );
					if ( ! foundLinks.length ) {
						return;
					}
					if ( foundLinks ) {
						for ( let i = 0; i < foundLinks.length; i++ ) {
							if ( thebaseThemeLightbox.checkImage( foundLinks[ i ] ) ) {
								foundLinks[ i ].classList.add( 'tb-core-gallery-lightbox' );
							}
						}
					}
					if ( foundGalleries[ i ] ) {
						new SimpleLightbox({
							elements: foundGalleries[ i ].querySelectorAll( '.blocks-gallery-item a' ),
						});
					}
				}
			}
		},
		/**
		 * Initiate the script to process all
		 */
		initAll: function() {
			thebaseThemeLightbox.findGalleries();
			thebaseThemeLightbox.findImages();
		},
		// Initiate the menus when the DOM loads.
		init: function() {
			if ( typeof SimpleLightbox == 'function' ) {
				thebaseThemeLightbox.initAll();
			} else {
				var initLoadDelay = setInterval( function(){ if ( typeof SimpleLightbox == 'function' ) { thebaseThemeLightbox.initAll(); clearInterval(initLoadDelay); } }, 200 );
			}
		}
	}
	if ( 'loading' === document.readyState ) {
		// The DOM has not yet been loaded.
		document.addEventListener( 'DOMContentLoaded', thebaseThemeLightbox.init );
	} else {
		// The DOM has already been loaded.
		thebaseThemeLightbox.init();
	}
})();
