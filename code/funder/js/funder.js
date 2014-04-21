/**
 * Functionality specific to Funder
 *
 * Provides helper functions to enhance the theme experience.
 */

var Funder = {}

Funder.App = (function(jQuery) {
	function fixedHeader() {
		fixHeader();
	}

	return {
		init : function() {

			this.menuToggle();
			
			jQuery('#login-trigger').click(function(){
		jQuery(this).next('#login-content').slideToggle();
		jQuery(this).toggleClass('active');					
		
		if (jQuery(this).hasClass('active')) jQuery(this).find('span').html('&#x25B2;')
			else jQuery(this).find('span').html('&#x25BC;')
		})

			/*jQuery( '.login a, .register a' ).click(function(e) {
				e.preventDefault();
				
				Funder.App.fancyBox( jQuery(this), {
					items: {
						'src'  : '#' + jQuery(this).parent().attr( 'id' ) + '-wrap'
					}
				});
			});*/

			jQuery( '.fancybox' ).click( function(e) {
				e.preventDefault();

				Funder.App.fancyBox( jQuery(this ), {
					items : {
						'src'  : '#' + jQuery(this).attr( 'href' )
					}
				} );
			} );
		},

		/**
		 * Check if we are on a mobile device (or any size smaller than 980).
		 * Called once initially, and each time the page is resized.
		 */
		isMobile : function( width ) {
			var isMobile = false;

			var width = 1180;
			
			if ( jQuery(window).width() <= width )
				isMobile = true;

			return isMobile;
		},

		fancyBox : function( _this, args ) {
			jQuery.magnificPopup.open( jQuery.extend( args, {
				'type' : 'inline'
			}) );
		},

		menuToggle : function() {
			jQuery( '.menu-toggle' ).click(function(e) {
				e.preventDefault();

				jQuery( '#menu' ).slideToggle();
			});
		}
	}
}(jQuery));

Funder.Campaign = (function(jQuery) {
	function campaignGrid() {
		if ( ! jQuery().masonry )
			return;

		var container = jQuery( '#projects section' );

		if ( container.masonry() )
			container.masonry( 'reload' );
		
		container.imagesLoaded( function() {
			container.masonry({
				itemSelector : '.hentry'
			});
		});
	}

	function campaignTabs() {
		var tabs     = jQuery( '.campaign-tabs' ),
		    overview = jQuery( '.campaign-view-descrption' ),
		    tablinks = jQuery( '.sort-tabs.campaign a' );
		
		tabs.children( 'div' ).hide();
		overview.hide();

		tabs.find( ':first-child' ).show();

		tablinks.click(function(e) {
			if ( jQuery(this).hasClass( 'tabber' ) ) {
				var link = jQuery(this).attr( 'href' );
					
				tabs.children( 'div' ).hide();
				overview.show();
				tabs.find( link ).show();
				
				jQuery( 'body' ).animate({
					scrollTop: jQuery(link).offset().top - 200
				});
			}
		});
	}

	function campaignPledgeLevels() {
			
		jQuery('.single-reward-levels li').click( function(e) {
			
			e.preventDefault();

			if ( jQuery( this ).hasClass( 'inactive' ) )
				return false;

			var price = jQuery( this ).data( 'price' );

			Funder.App.fancyBox( jQuery(this), {
				items : {
					src  : '#contribute-modal-wrap'
				},
				callbacks: {
					beforeOpen : function() {
						jQuery( '#contribute-modal-wrap .edd_price_options' )
							.find( 'li[data-price="' + price + '"]' )
							.trigger( 'click' );
					}
				}
			});
		} );
	}

	function campaignWidget() {
		jQuery( 'body.campaign-widget a' ).attr( 'target', '_blank' );
	}

	return {
		init : function() {
			campaignGrid();
			campaignTabs();
			campaignPledgeLevels();
			campaignWidget();
		},

		resizeGrid : function() {
			campaignGrid();
		}
	}
} )(jQuery);

Funder.Checkout = (function(jQuery) {
	return function() {
		jQuery( '.contribute, .contribute a' ).click(function(e) {
			e.preventDefault();

			Funder.App.fancyBox( jQuery(this), {
				items : {
					'src' : '#contribute-modal-wrap'
				}
			});
		});
	}
}(jQuery));

jQuery(document).ready(function(jQuery) {
	Funder.App.init();
	Funder.Campaign.init();
	Funder.Checkout();

	jQuery( window ).on( 'resize', function() {
		Funder.Campaign.resizeGrid();
	});
	
	/**
	 * Repositions the window on jump-to-anchor to account for
	 * navbar height.
	 */
	var funderAdjustAnchor = function() {
		if ( window.location.hash )
			window.scrollBy( 0, -150 );
	};

	jQuery( window ).on( 'hashchange', funderAdjustAnchor );
});

	// Jquery Toogle
	 jQuery(document).ready(function(){
            jQuery("#toggl").click(function(){
                jQuery("#panel").slideToggle("slow");
                jQuery("#home-page-featured").slideToggle("slow");
                jQuery(this).toggleClass('latest_top');
            });
        });
	// Advance Search	
	jQuery('#advanced-search').hide();
    jQuery('#advanced-search-button').click(function(event) {
        /* Preventing default link action */
        event.preventDefault();
        jQuery('#default-search').slideToggle('fast');
        jQuery('#advanced-search').slideToggle('fast');
        jQuery(this).toggleClass('expanded');
    });	

	// Slider 
	
	jQuery(document).ready(function(){
        var slider = jQuery(".slider").slider({
            change: function () {
/*                var value = jQuery(this).slider("option", "value");
                jQuery(this).find(".ui-slider-handle").text(value+'%');*/
            },
            slide: function () {
/*                var value = jQuery(this).slider("option", "value");
                jQuery(this).find(".ui-slider-handle").text(value+"%");*/
            }
        });
/*        slider.each(function(index){
            var el = slider.get(index);
            var value = jQuery(el).slider("value");
            jQuery(el).slider("value", value);
        });*/
    });	
	
	// Color box
	jQuery(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
        jQuery(".group1").colorbox({rel:'nofollow',scalePhotos:'false'});
    });
	// Place holder 
	jQuery(function() {
        jQuery('input, textarea').placeholder();
    });
	
	// Dynamic Select
	    jQuery(function(){
        // bind change event to select
        jQuery('#dynamic_select').bind('change', function () {
            var url = jQuery(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
	
	/***
	 Filter for the portfolio items
	***/
	jQuery('#portfolio-filter input').click(function() {

		jQuery('#portfolio-filter input').removeClass('current');
		jQuery(this).addClass('current');
		var filter = jQuery(this).attr('id');
		if ( filter === 'all' ) {
			jQuery('.portfolio-listing').slideDown('fast');
			jQuery('.portfolio-listing-small').slideDown('fast');
		} else {
			jQuery('.portfolio-listing').slideUp('fast');
			jQuery('.portfolio-listing-small').slideUp('fast');
			jQuery('.portfolio-listing.' + filter).slideDown('fast');
			jQuery('.portfolio-listing-small.' + filter).slideDown('fast');
		}
	});

// Sticky Navigation
jQuery(document).ready(function () {
    // fix sub nav on scroll
    var jQuerywin = jQuery(window),
        jQuerynav = jQuery('.header-wrapper'),
        navTop = jQuery('.header-wrapper').length && jQuery('.header-wrapper').offset().top + 98,
        isFixed = 0
        processScroll()
        jQuerywin.on('scroll', processScroll)

        function processScroll() {
            var i, scrollTop = jQuerywin.scrollTop()
            if (scrollTop >= navTop && !isFixed) {
                isFixed = 1
                jQuerynav.addClass('subnav-fixed')
                jQuery('body').addClass('with-subnav')
            } else if (scrollTop <= navTop && isFixed) {
                isFixed = 0
                jQuerynav.removeClass('subnav-fixed')
                jQuery('body').removeClass('with-subnav')
            }
        }
});

