/* 
#ADS
//////////////////////////////////////////////////////
* Ripped off of jquery.dfp.js: http://github.com/coop182/jquery.dfp.js
* but w/ some inspiration from http://motherboard.vice.com/en_us
*/
(function($) {

	LS.dfpAds = {
		count: 0,
		rendered: 0,
		initial_ads_loaded: false,
		ajax_ads_queue: [],
		dfp_is_loaded: false,
		dfp_is_started: false,
		ads_could_never_be_initilized: false,
		ad_blocker: false,
		ads: [],
		$adCollection: null,
		/**
		 * Call the google DFP script - there is a little bit of error detection in here to detect
		 * if the dfp script has failed to load either through an error or it being blocked by an ad
		 * blocker... if it does not load we execute a dummy script to replace the real DFP.
		 *
		 * @param {Object} options
		 * @param {Array} $adCollection
		 */
		dfp_loader: function() {
			LS.dfpAds.dfp_is_loaded = LS.dfpAds.dfp_is_loaded || $('script[src*="googletagservices.com/tag/js/gpt.js"]').length;
			window.googletag = window.googletag || {};
			window.googletag.cmd = window.googletag.cmd || [];
			(function(){
				var gads = document.createElement('script');
				gads.async = true;
				var useSSL = 'https:' == document.location.protocol;
				gads.src = (useSSL ? 'https:' : 'http:') +
				   '//www.googletagservices.com/tag/js/gpt.js';
				var node = document.getElementsByTagName('script')[0];
				node.parentNode.insertBefore(gads, node);
			})();

		},

		// generate random number based ID
		get_ID: function(adSlot, count) {
			for (var c = "", d = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", e = 14; e > 0; --e) {
				c += d[Math.round(Math.random() * (d.length - 1))];
				return adSlot + "-" + c + "-" + Date.now() + "-" + count;
			}
		},
		// get name of adunit based on data-adunit in html
		get_name: function($adUnit) {
			var adUnitName = $adUnit.data('adunit');
			return adUnitName;
		},

		// get adunit mapping based on data-mapping in html
		get_mapping: function($adUnit) {
			var adUnitMapping = $adUnit.data('mapping');
			return adUnitMapping;
		},

		init: function() {
			var self = this;
			self.$adCollection = $('.adunit:not(.adunit-loaded)');
			this.dfp_loader();
			this.create_ads();
			this.close_mobile_sticky_ad();
			// this.display_ads();
		},

		refresh: function() {
			var self = this;
			self.$adCollection = $('.adunit:not(.adunit-loaded)');
			this.create_ads();
		},


		ad_targeting_sizes: {
			mapping_horizontal: function() {
				return window.googletag.sizeMapping()
				.addSize([980, 1], [
					[970, 250],
					[728, 90]
				]).addSize([740, 1], [
					[728, 90]
				]).addSize([0, 1], [
					[300, 250],
				]).build();
			},
			mapping_horizontal_top: function() {
				return window.googletag.sizeMapping()
				.addSize([980, 1], [
					[970, 250],
					[728, 90]
				]).addSize([740, 1], [
					[728, 90]
				]).addSize([0, 1], [
					[320, 50]
				]).build();
			},
			mapping_horizontal_desktop: function() {
				return window.googletag.sizeMapping()
				.addSize([0, 0], [
				]).addSize([1024, 1], [
					[970, 250],
					[728, 90]
				]).addSize([740, 1], [
					[728, 90]
				]).build();
			},
			mapping_vertical: function() {
				return window.googletag.sizeMapping()
				.addSize([1024, 1], [
					[300, 600],
					[300, 250]
				]).addSize([740, 1], [
					[728, 90]
				]).addSize([0, 1], [
					[300, 250], 
				]).build();
			},
			mapping_slideshow: function() {
				return window.googletag.sizeMapping()
				.addSize([0, 1], [
					[300, 250], 
				]).build();
			},
		},
		ad_slots: {
			horizontal: {
				dimensions: [
					[970, 250],
					[728, 90], 
					[300, 250]
				],
				targeting_sizes: "mapping_horizontal",
			},
			horizontal_top: {
				dimensions: [
					[970, 250],
					[728, 90], 
					[320, 50]
				],
				targeting_sizes: "mapping_horizontal_top",
			},
			vertical: {
				dimensions: [
					[300, 600],
					[300, 250],
					[728, 90]
				],
				targeting_sizes: "mapping_vertical",
			},
			slideshow: {
				dimensions: [
					[300, 250]
				],
				targeting_sizes: "mapping_slideshow",
			},
		},
		config: {
			dfp_account: "21680537470",
			ad_unit: "",
			googletag: false,
			targeting: {},
			dfp_options: {
				set_category_exclusion: [],
				// set_location: false,
				enable_single_request: true,
				collapse_empty_divs: true,
				set_url_targeting: true,
				disable_publisher_console: false,
				disable_initial_load: true,
				no_fetch: false
			},
			callbacks: {
				after_all_ads_loaded: false
			}
		},

		_configure_dfp: function() {
			LS.dfpAds.dfp_is_started = true;
			window.googletag.cmd.push(function() {

				// if (LS.dfpAds.config.dfp_options.set_url_targeting) {
				// 	var urlTargeting = LS.dfpAds.get_url_targeting();
				// 	$.extend(true, LS.dfpAds.config.dfp_options.set_url_targeting, {
				// 		inURL: urlTargeting.inURL,
				// 		keyword: urlTargeting.keyword,
				// 		locationKeywords: urlTargeting.locationKeywords,
				// 		filters: urlTargeting.filters,
				// 		dirtype: urlTargeting.dirtype,
				// 		isSingleQuery: urlTargeting.isSingleQuery,
				// 		isSearchLanding: urlTargeting.isSearchLanding
				// 	});
				// }

				LS.dfpAds.config.dfp_options && window.googletag.cmd.push(function() {
					$.extend(true, window.googletag, LS.dfpAds.config.googletag);
				});

				LS.dfpAds.config.dfp_options.collapse_empty_divs && 
					window.googletag.pubads().collapseEmptyDivs(); 

				// var targeting = $.extend({}, window.dfp_targeting, urlTargeting);

				var targeting = window.dfp_targeting;

				$.each(targeting, function (k, v) {
					window.googletag.pubads().setTargeting(k, v);
				});

				LS.dfpAds.config.dfp_options.disable_publisher_console && 
					window.googletag.pubads().disablePublisherConsole();

				// Infinite Scroll / 'Load More' requires SRA
				LS.dfpAds.config.dfp_options.enable_single_request &&
					window.googletag.pubads().enableSingleRequest();

				// Disable initial load, we will use refresh() to fetch ads.
				// Calling this function means that display() calls just
				// register the slot as ready, but do not fetch ads for it.
				LS.dfpAds.config.dfp_options.disable_initial_load &&
					window.googletag.pubads().disableInitialLoad();

				LS.dfpAds.config.dfp_options.no_fetch && 
					window.googletag.pubads().noFetch();

				googletag.pubads().addEventListener('slotRenderEnded', function(event) {
					LS.dfpAds.rendered++;
					var $adUnit = $('#' + event.slot.getSlotId().getDomId());
					var display = event.isEmpty ? 'none' : 'block';

					// if the div has been collapsed but there was existing content expand the
					// div and reinsert the existing content.
					var $existingContent = $adUnit.data('existingContent');
					if (display === 'none' && $.trim($existingContent).length > 0 &&
						dfpOptions.collapseEmptyDivs === 'original') {
						$adUnit.show().html($existingContent);
						display = 'block display-original';
					}

					$adUnit.removeClass('display-none').addClass('display-' + display).addClass('adunit-loaded');

				});

				// Enable services
				window.googletag.enableServices();

			});
		},
		create_ads: function() {

			LS.dfpAds._configure_dfp();

			googletag.cmd.push(function() {

			LS.dfpAds.$adCollection.each(function() {
				var googletag = window.googletag;

				// create ad for each adunit on page
				var $adUnit = $(this);

				LS.dfpAds.count++;

				var adUnitName = LS.dfpAds.get_name($adUnit);
				var ID = LS.dfpAds.get_ID(adUnitName, LS.dfpAds.count);
				adSlot_object = LS.dfpAds.ad_slots[adUnitName];

				// hide internal html until adunit finishes rendering
				$adUnit.html('').addClass('display-none');

				// mapping = adSlot_object.targeting_sizes;
				mapping = LS.dfpAds.get_mapping($adUnit);
					mappingvar = LS.dfpAds.get_mapping($adUnit);
					// mappingvar = adSlot_object.targeting_sizes;
					isMapped = false;

					 // Sets responsive size mapping for just THIS ad unit if it has been specified
					mappingvar && LS.dfpAds.ad_targeting_sizes[mapping] && 
						(isMapped = LS.dfpAds.ad_targeting_sizes[mappingvar].call()),

					$adUnit.attr('id', ID);

					googleAdUnit = googletag.defineSlot(
						'/' + LS.dfpAds.config.dfp_account +'/' + adUnitName,
						adSlot_object.dimensions,
						ID
					)
					.defineSizeMapping(isMapped)
					.addService(googletag.pubads());


					googletag.cmd.push(function() {
						googletag.display(ID);
						googletag.pubads().refresh([googleAdUnit]);
					});
				});
			});

		},
		close_mobile_sticky_ad: function() {
			$('.js-adunit-close').click(function() {
				$('.adunit-wrapper').hide();
			});
			// hide wrapper when ad not loaded 
			$('.adunit--horizontal.adunit--top.display-none').parent('.adunit-wrapper').hide();
		},
		/*
		Inject ads between paragraphs on mobile and story pages w/o sidebar
		*/
		inject_ads: function() {
			$('.layout--full-width .story__content p:nth-child(10n)').each(function() {
				if ( $(this).nextAll().length > 3 && $(this).text().length > 30 ) {
				// if the last injected ad has 3 or fewer paragraphs after it, don't show
					$(this).after('<div class="adunit adunit--horizontal" data-adunit="MissEllie_horizontal" data-mapping="mapping_horizontal"></div>');
				};
			});
			enquire.register(LS.breakpoint_small_only, function() {
				$('.layout--with-sidebar .story__content p:nth-child(7n)').each(function() {
					if ( $(this).nextAll().length > 3 && $(this).text().length > 30 ) {
					// if the last injected ad has 3 or fewer paragraphs after it, don't show
						$(this).after('<div class="adunit adunit--horizontal" data-adunit="MissEllie_horizontal" data-mapping="mapping_horizontal"></div>');
					};
				});
			});
		},

		/*
		sticky scrolling behavior for header and sidebars
		- sidebar ads are sticky until they hit the top of a widget
		- only for sidebar ads on stories w/ sidebar layout
		- plugin: scrolltofixed, https://github.com/bigspotteddog/ScrollToFixed
		*/
		sticky_ads: function() {
			if ($('.js-stickyStop').length > 0) {
				var $padding = 30;
				var $sidebarAd = $('.js-sticky:not(.scroll-to-fixed-fixed)');

				$sidebarAd.each(function(){
					$this = $(this);
					var $ad_height = $this.height();
					var $ad_parent = $this.parents('.js-stickyParent');
					$limit = $ad_parent.next('.js-stickyStop').offset().top - $ad_height - ($padding * 2);

					if ( $ad_height < $ad_parent.height() ){
						$this.scrollToFixed({
							'marginTop': LS.stickyNavHeight + $padding,
							'limit': $limit
						});
					} //endif
				}); //each
			};
		},
	}; // LS.dfpAds

})(jQuery);
