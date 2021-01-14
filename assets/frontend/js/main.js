const reload = window.location.href;

(function ($) {
	"use strict";
	/*---------------------------------------
		Kenne's Preloader
---------------------------------*/
	$(window).on("load", function () {
		var wind = $(window);
		$(".loading").fadeOut("slow");
	});
	/*----------------------------------------*/
	/*   Sticky Menu Activation
	/*----------------------------------------*/
	$(window).on("scroll", function () {
		if ($(this).scrollTop() > 300) {
			$(".header-sticky").addClass("sticky");
		} else {
			$(".header-sticky").removeClass("sticky");
		}
	});
	/*----------------------------------------*/
	/*  Toolbar Button
/*----------------------------------------*/
	var $overlay = $(".global-overlay");
	$(".toolbar-btn").on("click", function (e) {
		e.preventDefault();
		e.stopPropagation();
		var $this = $(this);
		var target = $this.attr("href");
		var prevTarget = $this
			.parent()
			.siblings()
			.children(".toolbar-btn")
			.attr("href");
		$(target).toggleClass("open");
		$(prevTarget).removeClass("open");
		$($overlay).addClass("overlay-open");
	});

	/*----------------------------------------*/
	/*  Click on Documnet
/*----------------------------------------*/
	var $body = $("body");

	$body.on("click", function (e) {
		var $target = e.target;
		var dom = $(".main-wrapper").children();

		if (!$($target).is(".toolbar-btn") && !$($target).parents().is(".open")) {
			dom.removeClass("open");
			dom.find(".open").removeClass("open");
			$overlay.removeClass("overlay-open");
		}
	});

	/*----------------------------------------*/
	/*  Close Button Actions
/*----------------------------------------*/
	$(".btn-close").on("click", function (e) {
		e.preventDefault();
		var $this = $(this);
		$this.parents(".open").removeClass("open");
	});
	/*----------------------------------------*/
	/*  Offcanvas
/*----------------------------------------*/
	/*Variables*/
	var $offcanvasNav = $(
			".offcanvas-menu, .offcanvas-minicart_menu, .offcanvas-search_menu, .mobile-menu"
		),
		$offcanvasNavWrap = $(
			".offcanvas-menu_wrapper, .offcanvas-minicart_wrapper, .offcanvas-search_wrapper, .mobile-menu_wrapper"
		),
		$offcanvasNavSubMenu = $offcanvasNav.find(".sub-menu"),
		$menuToggle = $(".menu-btn"),
		$menuClose = $(".btn-close");

	/*Add Toggle Button With Off Canvas Sub Menu*/
	$offcanvasNavSubMenu
		.parent()
		.prepend(
			'<span class="menu-expand"><i class="ion-ios-plus-empty"></i></span>'
		);

	/*Close Off Canvas Sub Menu*/
	$offcanvasNavSubMenu.slideUp();

	/*Category Sub Menu Toggle*/
	$offcanvasNav.on("click", "li a, li .menu-expand", function (e) {
		var $this = $(this);
		if (
			$this
				.parent()
				.attr("class")
				.match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/) &&
			($this.attr("href") === "#" ||
				$this.attr("href") === "javascript:void(0);" ||
				$this.attr("href") === "" ||
				$this.hasClass("menu-expand"))
		) {
			e.preventDefault();
			if ($this.siblings("ul:visible").length) {
				$this.siblings("ul").slideUp("slow");
			} else {
				$this.closest("li").siblings("li").find("ul:visible").slideUp("slow");
				$this.closest("li").siblings("li").removeClass("menu-open");
				$this.siblings("ul").slideDown("slow");
				$this.parent().siblings().children("ul").slideUp();
			}
		}
		if (
			$this.is("a") ||
			$this.is("span") ||
			$this.attr("class").match(/\b(menu-expand)\b/)
		) {
			$this.parent().toggleClass("menu-open");
		} else if (
			$this.is("li") &&
			$this.attr("class").match(/\b('menu-item-has-children')\b/)
		) {
			$this.toggleClass("menu-open");
		}
	});

	$(".btn-close").on("click", function (e) {
		e.preventDefault();
		$(".mobile-menu .sub-menu").slideUp();
		$(".mobile-menu .menu-item-has-children").removeClass("menu-open");
	});
	/*----------------------------------------*/
	/*  Nice Select
/*----------------------------------------*/
	$(document).ready(function () {
		$(".nice-select").niceSelect();
	});
	/*----------------------------------------*/
	/* Kenne's Countdown
	/*----------------------------------------*/
	// Check if element exists
	$.fn.elExists = function () {
		return this.length > 0;
	};

	function makeTimer($endDate, $this, $format) {
		var today = new Date();

		var BigDay = new Date($endDate),
			msPerDay = 24 * 60 * 60 * 1000,
			timeLeft = BigDay.getTime() - today.getTime(),
			e_daysLeft = timeLeft / msPerDay,
			daysLeft = Math.floor(e_daysLeft),
			e_hrsLeft = (e_daysLeft - daysLeft) * 24,
			hrsLeft = Math.floor(e_hrsLeft),
			e_minsLeft = (e_hrsLeft - hrsLeft) * 60,
			minsLeft = Math.floor((e_hrsLeft - hrsLeft) * 60),
			e_secsLeft = (e_minsLeft - minsLeft) * 60,
			secsLeft = Math.floor((e_minsLeft - minsLeft) * 60);

		var yearsLeft = 0;
		var monthsLeft = 0;
		var weeksLeft = 0;

		if ($format != "short") {
			if (daysLeft > 365) {
				yearsLeft = Math.floor(daysLeft / 365);
				daysLeft = daysLeft % 365;
			}

			if (daysLeft > 30) {
				monthsLeft = Math.floor(daysLeft / 30);
				daysLeft = daysLeft % 30;
			}
			if (daysLeft > 7) {
				weeksLeft = Math.floor(daysLeft / 7);
				daysLeft = daysLeft % 7;
			}
		}

		var yearsLeft = yearsLeft < 10 ? "0" + yearsLeft : yearsLeft,
			monthsLeft = monthsLeft < 10 ? "0" + monthsLeft : monthsLeft,
			weeksLeft = weeksLeft < 10 ? "0" + weeksLeft : weeksLeft,
			daysLeft = daysLeft < 10 ? "0" + daysLeft : daysLeft,
			hrsLeft = hrsLeft < 10 ? "0" + hrsLeft : hrsLeft,
			minsLeft = minsLeft < 10 ? "0" + minsLeft : minsLeft,
			secsLeft = secsLeft < 10 ? "0" + secsLeft : secsLeft,
			yearsText = yearsLeft > 1 ? "years" : "year",
			monthsText = monthsLeft > 1 ? "months" : "month",
			weeksText = weeksLeft > 1 ? "weeks" : "week",
			daysText = daysLeft > 1 ? "days" : "day",
			hourText = hrsLeft > 1 ? "hrs" : "hr",
			minsText = minsLeft > 1 ? "mins" : "min",
			secText = secsLeft > 1 ? "secs" : "sec";

		var $markup = {
			wrapper: $this.find(".countdown__item"),
			year: $this.find(".yearsLeft"),
			month: $this.find(".monthsLeft"),
			week: $this.find(".weeksLeft"),
			day: $this.find(".daysLeft"),
			hour: $this.find(".hoursLeft"),
			minute: $this.find(".minsLeft"),
			second: $this.find(".secsLeft"),
			yearTxt: $this.find(".yearsText"),
			monthTxt: $this.find(".monthsText"),
			weekTxt: $this.find(".weeksText"),
			dayTxt: $this.find(".daysText"),
			hourTxt: $this.find(".hoursText"),
			minTxt: $this.find(".minsText"),
			secTxt: $this.find(".secsText"),
		};

		var elNumber = $markup.wrapper.length;
		$this.addClass("item-" + elNumber);
		$($markup.year).html(yearsLeft);
		$($markup.yearTxt).html(yearsText);
		$($markup.month).html(monthsLeft);
		$($markup.monthTxt).html(monthsText);
		$($markup.week).html(weeksLeft);
		$($markup.weekTxt).html(weeksText);
		$($markup.day).html(daysLeft);
		$($markup.dayTxt).html(daysText);
		$($markup.hour).html(hrsLeft);
		$($markup.hourTxt).html(hourText);
		$($markup.minute).html(minsLeft);
		$($markup.minTxt).html(minsText);
		$($markup.second).html(secsLeft);
		$($markup.secTxt).html(secText);
	}

	if ($(".countdown").elExists) {
		$(".countdown").each(function () {
			var $this = $(this);
			var $endDate = $(this).data("countdown");
			var $format = $(this).data("format");
			setInterval(function () {
				makeTimer($endDate, $this, $format);
			}, 0);
		});
	}

	/*----------------------------------------*/
	/*  Cart Plus Minus Button
	/*----------------------------------------*/
	$(".cart-plus-minus").append(
		'<div class="dec qtybutton"><i class="fa fa-angle-down"></i></div><div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>'
	);

	/*----------------------------------------*/
	var oldValue;
	var myTimer;
	/*----------------------------------------*/

	$(document).on("click", ".qtybutton", function () {
		clearTimeout(myTimer);
		var $button = $(this);
		var newVal;
		oldValue = $button.parent().find("input").val();

		if ($button.hasClass("inc")) {
			newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 1) {
				newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 1;
			}
		}
		$button.parent().find("input").val(newVal);
		if ($button.hasClass("custom")) {
			var url = "cart/updatecart/";
			var id = $(this).closest("tr").data("id");

			myTimer = setTimeout(function () {
				updatecart(url, id, newVal);
			}, 1000);
		}
	});

	/*----------------------------------------*/
	/* Toggle Function Active
	/*----------------------------------------*/
	// showlogin toggle
	$("#showlogin").on("click", function () {
		$("#checkout-login").slideToggle(900);
	});
	// showlogin toggle
	$("#showcoupon").on("click", function () {
		$("#checkout_coupon").slideToggle(900);
	});
	// showlogin toggle
	$("#cbox").on("click", function () {
		$("#cbox-info").slideToggle(900);
	});

	// showlogin toggle
	$("#ship-box").on("click", function () {
		$("#ship-box-info").slideToggle(1000);
	});

	/*----------------------------------------*/
	/* FAQ Accordion
	/*----------------------------------------*/
	$(".card-header a").on("click", function () {
		$(".card").removeClass("actives");
		$(this).parents(".card").addClass("actives");
	});

	/*---------------------------------------------*/
	/*  Kenne'sCounterUp
	/*----------------------------------------------*/
	$(".count").counterUp({
		delay: 10,
		time: 1000,
	});

	/*----------------------------------------*/
	/*  Kenne's Product View Mode
	/*----------------------------------------*/
	function porductViewMode() {
		$(window).on({
			load: function () {
				var activeChild = $(".product-view-mode a.active");
				var firstChild = $(".product-view-mode").children().first();
				var window_width = $(window).width();

				if (window_width < 768) {
					$(".product-view-mode a").removeClass("active");
					$(".product-view-mode").children().first().addClass("active");
					$(".shop-product-wrap")
						.removeClass("gridview-3 gridview-4 gridview-5")
						.addClass("gridview-2");
				}
			},
			resize: function () {
				var ww = $(window).width();
				var activeChild = $(".product-view-mode a.active");
				var firstChild = $(".product-view-mode").children().first();
				var defaultView = $(".product-view-mode").data("default");

				if (ww < 1200 && ww > 575) {
					if (activeChild.hasClass("grid-5")) {
						$(".product-view-mode a.grid-5").removeClass("active");
						if (defaultView == 4) {
							$(".product-view-mode a.grid-4").addClass("active");
							$(".shop-product-wrap")
								.removeClass("gridview-2 gridview-3 gridview-5")
								.addClass("gridview-4");
						}
						// else if (defaultView == 'list') {
						// 	$('.product-view-mode a.list').addClass('active');
						// 	$('.shop-product-wrap')
						// 		.removeClass('gridview-2 gridview-3 gridview-4 gridview-5')
						// 		.addClass('listview');
						// } else {
						// 	$('.product-view-mode a.grid-3').addClass('active');
						// 	$('.shop-product-wrap')
						// 		.removeClass('gridview-2 gridview-4 gridview-5')
						// 		.addClass('gridview-3');
						// }
					}
				}

				if (ww < 768 && ww > 575) {
					if (activeChild.hasClass("grid-4")) {
						$(".product-view-mode a.grid-4").removeClass("active");
						if (defaultView == "list") {
							$(".product-view-mode a.list").addClass("active");
							$(".shop-product-wrap")
								.removeClass("gridview-2 gridview-3 gridview-4 gridview-5")
								.addClass("listview");
						} else {
							$(".product-view-mode a.grid-3").addClass("active");
							$(".shop-product-wrap")
								.removeClass("gridview-2 gridview-4 gridview-5")
								.addClass("gridview-3");
						}
					}
				}
				if (activeChild.hasClass("list")) {
				} else {
					if (ww < 576) {
						$(".product-view-mode a").removeClass("active");
						$(".product-view-mode").children().first().addClass("active");
						$(".shop-product-wrap")
							.removeClass("gridview-3 gridview-4 gridview-5")
							.addClass("gridview-2");
					} else {
						if (activeChild.hasClass("grid-2")) {
							if (ww < 1200) {
								$(".product-view-mode a:not(:first-child)").removeClass(
									"active"
								);
							} else {
								$(".product-view-mode a").removeClass("active");
								$(".product-view-mode a:nth-child(2)").addClass("active");
								$(".shop-product-wrap")
									.removeClass("gridview-2 gridview-4 gridview-5")
									.addClass("gridview-3");
							}
						}
					}
				}
			},
		});
		$(".product-view-mode a").on("click", function (e) {
			e.preventDefault();

			var shopProductWrap = $(".shop-product-wrap");
			var viewMode = $(this).data("target");

			$(".product-view-mode a").removeClass("active");
			$(this).addClass("active");
			if (viewMode == "listview") {
				shopProductWrap.removeClass("grid");
			} else {
				if (shopProductWrap.not(".grid")) shopProductWrap.addClass("grid");
			}
			shopProductWrap
				.removeClass("gridview-2 gridview-3 gridview-4 gridview-5 listview")
				.addClass(viewMode);
		});
	}
	porductViewMode();

	/*----------------------------------------*/
	/*  Star Rating Js
	/*----------------------------------------*/
	$(function () {
		$(".star-rating").barrating({
			theme: "fontawesome-stars",
		});
	});

	/*-------------------------------------------------*/
	/* Sticky Sidebar
	/*-------------------------------------------------*/
	$("#sticky-sidebar").theiaStickySidebar({
		// Settings
		additionalMarginTop: 80,
	});

	/*-------------------------------------------------*/
	/* Bootstraps 4 Tooltip
	/*-------------------------------------------------*/
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});
	/*----------------------------------------*/
	/*  Slick Carousel
	/*----------------------------------------*/
	var $html = $("html");
	var $body = $("body");
	var $elementCarousel = $(".kenne-element-carousel");
	// Check if element exists
	$.fn.elExists = function () {
		return this.length > 0;
	};

	/*For RTL*/
	if ($html.attr("dir") == "rtl" || $body.attr("dir") == "rtl") {
		$elementCarousel.attr("dir", "rtl");
	}

	if ($elementCarousel.elExists()) {
		var slickInstances = [];

		/*For RTL*/
		if ($html.attr("dir") == "rtl" || $body.attr("dir") == "rtl") {
			$elementCarousel.attr("dir", "rtl");
		}

		$elementCarousel.each(function (index, element) {
			var $this = $(this);

			// Carousel Options

			var $options =
				typeof $this.data("slick-options") !== "undefined"
					? $this.data("slick-options")
					: "";

			var $spaceBetween = $options.spaceBetween
					? parseInt($options.spaceBetween, 10)
					: 0,
				$spaceBetween_xl = $options.spaceBetween_xl
					? parseInt($options.spaceBetween_xl, 10)
					: 0,
				$rowSpace = $options.rowSpace ? parseInt($options.rowSpace, 10) : 0,
				$rows = $options.rows ? $options.rows : false,
				$vertical = $options.vertical ? $options.vertical : false,
				$focusOnSelect = $options.focusOnSelect
					? $options.focusOnSelect
					: false,
				$pauseOnHover = $options.pauseOnHover ? $options.pauseOnHover : false,
				$pauseOnFocus = $options.pauseOnFocus ? $options.pauseOnFocus : false,
				$asNavFor = $options.asNavFor ? $options.asNavFor : "",
				$fade = $options.fade ? $options.fade : false,
				$autoplay = $options.autoplay ? $options.autoplay : false,
				$autoplaySpeed = $options.autoplaySpeed
					? parseInt($options.autoplaySpeed, 10)
					: 5000,
				$swipe = $options.swipe ? $options.swipe : true,
				$swipeToSlide = $options.swipeToSlide ? $options.swipeToSlide : true,
				$touchMove = $options.touchMove ? $options.touchMove : false,
				$verticalSwiping = $options.verticalSwiping
					? $options.verticalSwiping
					: true,
				$draggable = $options.draggable ? $options.draggable : true,
				$arrows = $options.arrows ? $options.arrows : false,
				$dots = $options.dots ? $options.dots : false,
				$adaptiveHeight = $options.adaptiveHeight
					? $options.adaptiveHeight
					: true,
				$infinite = $options.infinite ? $options.infinite : false,
				$centerMode = $options.centerMode ? $options.centerMode : false,
				$centerPadding = $options.centerPadding ? $options.centerPadding : "",
				$variableWidth = $options.variableWidth
					? $options.variableWidth
					: false,
				$speed = $options.speed ? parseInt($options.speed, 10) : 500,
				$appendArrows = $options.appendArrows ? $options.appendArrows : $this,
				$prevArrow =
					$arrows === true
						? $options.prevArrow
							? '<span class="' +
							  $options.prevArrow.buttonClass +
							  '"><i class="' +
							  $options.prevArrow.iconClass +
							  '"></i></span>'
							: '<button class="tty-slick-text-btn tty-slick-text-prev"><i class="ion-ios-arrow-back"></i></span>'
						: "",
				$nextArrow =
					$arrows === true
						? $options.nextArrow
							? '<span class="' +
							  $options.nextArrow.buttonClass +
							  '"><i class="' +
							  $options.nextArrow.iconClass +
							  '"></i></span>'
							: '<button class="tty-slick-text-btn tty-slick-text-next"><i class="ion-ios-arrow-forward"></i></span>'
						: "",
				$rows = $options.rows ? parseInt($options.rows, 10) : 1,
				$rtl =
					$options.rtl || $html.attr('dir="rtl"') || $body.attr('dir="rtl"')
						? true
						: false,
				$slidesToShow = $options.slidesToShow
					? parseInt($options.slidesToShow, 10)
					: 1,
				$slidesToScroll = $options.slidesToScroll
					? parseInt($options.slidesToScroll, 10)
					: 1;

			/*Responsive Variable, Array & Loops*/
			var $responsiveSetting =
					typeof $this.data("slick-responsive") !== "undefined"
						? $this.data("slick-responsive")
						: "",
				$responsiveSettingLength = $responsiveSetting.length,
				$responsiveArray = [];
			for (var i = 0; i < $responsiveSettingLength; i++) {
				$responsiveArray[i] = $responsiveSetting[i];
			}

			// Adding Class to instances
			$this.addClass("slick-carousel-" + index);
			$this
				.parent()
				.find(".slick-dots")
				.addClass("dots-" + index);
			$this
				.parent()
				.find(".slick-btn")
				.addClass("btn-" + index);

			if ($spaceBetween != 0) {
				$this.addClass("slick-gutter-" + $spaceBetween);
			}
			if ($spaceBetween_xl != 0) {
				$this.addClass("slick-gutter-xl-" + $spaceBetween_xl);
			}
			var $slideCount = null;
			$this.on("init", function (event, slick) {
				$this.find(".slick-active").first().addClass("first-active");
				$this.find(".slick-active").last().addClass("last-active");
				$slideCount = slick.slideCount;
				if ($slideCount <= $slidesToShow) {
					$this.children(".slick-dots").hide();
				}
				var $firstAnimatingElements = $(".slick-slide").find(
					"[data-animation]"
				);
				doAnimations($firstAnimatingElements);
			});

			$this.slick({
				slidesToShow: $slidesToShow,
				slidesToScroll: $slidesToScroll,
				asNavFor: $asNavFor,
				autoplay: $autoplay,
				autoplaySpeed: $autoplaySpeed,
				speed: $speed,
				infinite: $infinite,
				rows: $rows,
				arrows: $arrows,
				dots: $dots,
				adaptiveHeight: $adaptiveHeight,
				vertical: $vertical,
				focusOnSelect: $focusOnSelect,
				pauseOnHover: $pauseOnHover,
				pauseOnFocus: $pauseOnFocus,
				centerMode: $centerMode,
				centerPadding: $centerPadding,
				variableWidth: $variableWidth,
				swipe: $swipe,
				swipeToSlide: $swipeToSlide,
				touchMove: $touchMove,
				draggable: $draggable,
				fade: $fade,
				appendArrows: $appendArrows,
				prevArrow: $prevArrow,
				nextArrow: $nextArrow,
				rtl: $rtl,
				responsive: $responsiveArray,
			});

			$this.on("beforeChange", function (e, slick, currentSlide, nextSlide) {
				$this.find(".slick-active").first().removeClass("first-active");
				$this.find(".slick-active").last().removeClass("last-active");
				var $animatingElements = $(
					'.slick-slide[data-slick-index="' + nextSlide + '"]'
				).find("[data-animation]");
				doAnimations($animatingElements);
			});

			function doAnimations(elements) {
				var animationEndEvents =
					"webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
				elements.each(function () {
					var $el = $(this);
					var $animationDelay = $el.data("delay");
					var $animationDuration = $el.data("duration");
					var $animationType = "animated " + $el.data("animation");
					$el.css({
						"animation-delay": $animationDelay,
						"animation-duration": $animationDuration,
					});
					$el.addClass($animationType).one(animationEndEvents, function () {
						$el.removeClass($animationType);
					});
				});
			}

			$this.on("afterChange", function (e, slick) {
				$this.find(".slick-active").first().addClass("first-active");
				$this.find(".slick-active").last().addClass("last-active");
			});

			// Updating the sliders in tab
			$("body").on(
				"shown.bs.tab",
				'a[data-toggle="tab"], a[data-toggle="pill"]',
				function (e) {
					$this.slick("setPosition");
				}
			);
		});
		// Added mousewheel for specific slider
		$(".single-blog_slider").on("wheel", function (e) {
			e.preventDefault();

			if (e.originalEvent.deltaY < 0) {
				$(this).slick("slickNext");
			} else {
				$(this).slick("slickPrev");
			}
		});
	}
	/*----------------------------------------*/
	/*  Product Switch Color
 /*----------------------------------------*/

	$(document).on("click", ".color-list a", function (e) {
		e.preventDefault();
		var $this = $(this);
		$this.addClass("active");
		$this.siblings().removeClass("active");
		// var $navs = document.querySelectorAll('.slick-slider-nav .single-slide');
		// var $details = document.querySelectorAll('.slick-img-slider .single-slide');
		// var $btnColor = $this.data('swatch-color');
		// for (var i = 0; i < $navs.length; i++) {
		// 	var $navParent = getClosest($navs[i], '.slick-slide');
		// 	$navParent.classList.remove('slick-current');
		// 	if ($navs[i].classList.contains($btnColor)) {
		// 		$navParent.classList.add('slick-current');
		// 	}
		// }
		// for (var i = 0; i < $details.length; i++) {
		// 	var $imgParent = getClosest($details[i], '.slick-slide');
		// 	$imgParent.classList.remove('slick-current', 'slick-active', 'first-active', 'last-active');
		// 	$imgParent.style.opacity = 0;
		// 	if ($details[i].classList.contains($btnColor)) {
		// 		$imgParent.classList.add('slick-current', 'slick-active', 'first-active', 'last-active');
		// 		$imgParent.style.opacity = 1;
		// 	}
		// }
	});

	var getClosest = function (elem, selector) {
		// Element.matches() polyfill
		if (!Element.prototype.matches) {
			Element.prototype.matches =
				Element.prototype.matchesSelector ||
				Element.prototype.mozMatchesSelector ||
				Element.prototype.msMatchesSelector ||
				Element.prototype.oMatchesSelector ||
				Element.prototype.webkitMatchesSelector ||
				function (s) {
					var matches = (this.document || this.ownerDocument).querySelectorAll(
							s
						),
						i = matches.length;
					while (--i >= 0 && matches.item(i) !== this) {}
					return i > -1;
				};
		}

		for (; elem && elem !== document; elem = elem.parentNode) {
			if (elem.matches(selector)) return elem;
		}
		return null;
	};

	/*----------------------------------------*/
	/*  Sidebar Categories Menu Activation
/*----------------------------------------*/
	$(".sidebar-categories_menu li.has-sub > a").on("click", function () {
		$(this).removeAttr("href");
		var element = $(this).parent("li");
		if (element.hasClass("open")) {
			element.removeClass("open");
			element.find("li").removeClass("open");
			element.find("ul").slideUp();
		} else {
			element.addClass("open");
			element.children("ul").slideDown();
			element.siblings("li").children("ul").slideUp();
			element.siblings("li").removeClass("open");
			element.siblings("li").find("li").removeClass("open");
			element.siblings("li").find("ul").slideUp();
		}
	});

	/*--------------------------
		jQuery Zoom
	---------------------------- */
	$(".zoom").zoom();

	/*----------------------------------
	/* 	Instafeed active 
------------------------------------*/
	if ($("#Instafeed").length) {
		var feed = new Instafeed({
			get: "user",
			userId: 6665768655,
			accessToken: "6665768655.1677ed0.313e6c96807c45d8900b4f680650dee5",
			target: "Instafeed",
			resolution: "low_resolution",
			limit: 6,
			template:
				'<li><a href="{{link}}" target="_new"><img src="{{image}}" /></a></li>',
		});
		feed.run();
	}
	/*--------------------------------
    Scroll To Top
-------------------------------- */
	function scrollToTop() {
		var $scrollUp = $(".scroll-to-top"),
			$lastScrollTop = 0,
			$window = $(window);

		$window.on("scroll", function () {
			var topPos = $(this).scrollTop();
			if (topPos > $lastScrollTop) {
				$scrollUp.removeClass("show");
			} else {
				if ($window.scrollTop() > 200) {
					$scrollUp.addClass("show");
				} else {
					$scrollUp.removeClass("show");
				}
			}
			$lastScrollTop = topPos;
		});

		$scrollUp.on("click", function (evt) {
			$("html, body").animate(
				{
					scrollTop: 0,
				},
				600
			);
			evt.preventDefault();
		});
	}

	scrollToTop();

	/*------------------------------------
	        DateCountdown
	    ------------------------------------- */
	$(".DateCountdown").TimeCircles({
		direction: "Counter-clockwise",
		fg_width: 0.009,
		bg_width: 0,
		use_background: false,
		animation: "thick",
		time: {
			Days: {
				text: "Days",
				color: "#fff",
			},
			Hours: {
				text: "Hours",
				color: "#fff",
			},
			Minutes: {
				text: "Mins",
				color: "#fff",
			},
			Seconds: {
				text: "Secs",
				color: "#fff",
			},
		},
	});

	$(document).ready(function () {
		ajaxcart();

		$(document).on("click", "[detailProduk]", function () {
			var id = $(this).closest("ul").data("id");
			var dataString = "id=" + id;
			$.ajax({
				type: "GET",
				url: BASEURL + "produk/view/",
				data: dataString,
				dataType: "JSON",
				cache: false,
				beforeSend: function () {
					loader(true);
				},
				success: function (data) {
					loader(false);
					$("#produkGambar").attr("src", data.image).load();
					$("#produkNama").text(data.name);
					$("#produkHarga").html("").append(data.price);
					$("#produkInfo").html("").append(data.desc);
					$("#dataid").attr("data-id", data.id);
					if (data.warna || data.ukuran) {
						$(".color-list_area").show();
					} else {
						$(".color-list_area").hide();
					}
					$("#variasiWarna").html("").append(data.warna);
					$("#variasiUkuran").html("").append(data.ukuran);
					$(".destroy-select").niceSelect("destroy"); //destroy the plugin
					$(".destroy-select").niceSelect(); //apply again
					$("#produkModal").modal("show");
				},
			});
		});
		// $(document).on('click', '[addCart]', function() {
		// 	var url = 'cart/cart/';
		// 	var id = $(this).closest('ul').data('id');
		// 	var qty = $(this).data('qty');
		// 	insertcart(url, id, qty);
		// });
		$(document).on("click", "[addCart2]", function () {
			var url = "cart/cart/";
			var id = $(this).closest("ul").data("id");
			var qty = $('[name="quantity"]').val();

			insertcart(url, id, qty);
		});

		$(document).on("click", "[removeCart]", function () {
			var url = "cart/removecart/";
			var id = $(this).closest("li").data("id");
			removecart(url, id);
		});

		$(document).on("click", "[removeCart2]", function () {
			var url = "cart/removecart/";
			var id = $(this).closest("tr").data("id");
			var custom = true;
			Swal.fire({
				title: "Hapus Produk ?",
				text: "Produk akan dihapus dari keranjang",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Ya, hapus!",
				cancelButtonText: "Tidak",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					removecart(url, id, custom);
				}
			});
		});

		$(document).on("click", "[qtyVal]", function () {
			oldValue = $(this).val();
		});

		$(document).on("blur", "[qtyVal]", function () {
			var newValue = $(this).val();
			var url = "cart/updatecart/";
			var id = $(this).closest("tr").data("id");
			if ($(this).val().trim() == "" || $(this).val().trim() == 0) {
				Swal.fire({
					title: "Hapus Produk ?",
					text: "Produk akan dihapus dari keranjang",
					icon: "warning",
					showCancelButton: true,
					confirmButtonText: "Ya, hapus!",
					cancelButtonText: "Tidak",
					reverseButtons: true,
				}).then((result) => {
					if (result.isConfirmed) {
						url = "cart/removecart/";
						removecart(url, id, true);
					} else {
						$(this).val(oldValue);
					}
				});
			} else {
				if (newValue != oldValue) {
					updatecart(url, id, newValue);
				}
			}
		});
		$(document).on("click", "[logoutButton]", function () {
			var csrfName = $("#txt_csrfname").attr("name");
			var csrfHash = $("#txt_csrfname").val();
			$.ajax({
				url: BASEURL + "member/logout",
				type: "POST",
				data: { [csrfName]: csrfHash },
				dataType: "JSON",
				beforeSend: function () {
					loader(true);
				},
				success: function (data) {
					if (data.success) {
						swallSuccess("Berhasil!", data.message, BASEURL);
					} else {
						swallError(false, data.message);
					}
				},
				error: function () {
					swallError(false, false, reload);
				},
			});
		});
	});

	$(document).on("change", "[type=tel]", function (e) {
		$(e.target).val(
			$(e.target)
				.val()
				.replace(/[^\d\.]/g, "")
		);
	});
	$(document).on("keypress", "[type=tel]", function (e) {
		var keys;
		keys = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "."];
		return keys.indexOf(event.key) > -1;
	});
})(jQuery);

function clearForm($form) {
	$form
		.find(":input")
		.not(":button, :submit, :reset, :hidden, :checkbox, :radio")
		.val("");
	$form.find(":checkbox, :radio").prop("checked", false);
}

function loader(stat = false) {
	var loading = $("#loading-custom");
	if (stat) {
		loading.addClass("loading-custom");
	} else {
		loading.removeClass("loading-custom");
	}
}
function targetedScroll(id) {
	var scrollTop = id ? $("#" + id).offset().top : 0;

	$("body,html").animate(
		{
			scrollTop: scrollTop,
		},
		700
	);
}
function rubah(angka) {
	var reverse = angka.toString().split("").reverse().join(""),
		ribuan = reverse.match(/\d{1,3}/g);
	ribuan = ribuan.join(".").split("").reverse().join("");
	return ribuan;
}

function ajaxcart() {
	$.ajax({
		type: "GET",
		url: BASEURL + "cart/ajaxcart/",
		dataType: "JSON",
		cache: false,
		success: function (data) {
			$("[totalHarga]")
				.html("")
				.text("Rp. " + rubah(data.total));
			// $("[subTotalCart]").html("").text('Rp. ' + rubah(data.total));
			$("[countProduk]").html("").text(data.count);
			$("[miniCount]").html("").text(data.count);
			$("[stikycount]").html("").text(data.count);
		},
		error: function () {
			swallError(false, false, reload);
		},
	});
}

function showcart() {
	$.ajax({
		type: "GET",
		url: BASEURL + "cart/show/",
		dataType: "JSON",
		cache: false,
		beforeSend: function () {
			loader(true);
		},
		success: function (data) {
			loader(false);
			if (data.cart != "") {
				$("[cartShow]").html("").append(data.cart);
			} else {
				$("[cartShow]")
					.html("")
					.append(
						" <tr><td colspan='7'><i>Upss. Troli masih kosong. Yuk belanja terlebih dahulu..</i></td></tr>"
					);
			}
			$("[jumlahBarang] > span")
				.html("")
				.text(data.jumlahBarang + " Item");
			$("[totalBerat] > span")
				.html("")
				.text(data.beratBarang + " Gram");
			$("[totalBarang] > span")
				.html("")
				.text("Rp. " + rubah(data.totalBarang));
		},
		error: function (x) {
			swallError(x.status, x.statusText);
		},
	});
}

function insertcart(url, id, qty, custom = false) {
	var csrfName = $("#txt_csrfname").attr("name");
	var csrfHash = $("#txt_csrfname").val();
	var variasiWarna = $(".color-list_area #variasiWarna");
	var variasiUkuran = $(".color-list_area #variasiUkuran");
	var variasiWarnaId = "";
	var variasiUkuranId = "";
	if ($.trim(variasiWarna.html()).length) {
		variasiWarnaId = variasiWarna.find(".active").data("id");
		if (!variasiWarnaId) {
			swallError("Opps..", "Silahkan pilih warna yang tersedia..");
			return false;
		}
	}

	if ($.trim(variasiUkuran.html()).length) {
		variasiUkuranId = variasiUkuran.find(".active").data("id");
		if (!variasiUkuranId) {
			swallError("Opps..", "Silahkan pilih ukuran yang tersedia..");
			return false;
		}
	}
	$.ajax({
		url: BASEURL + url + id,
		type: "POST",
		data: {
			[csrfName]: csrfHash,
			qty: qty,
			warnaId: variasiWarnaId,
			ukuranId: variasiUkuranId,
		},
		dataType: "JSON",
		beforeSend: function () {
			loader(true);
		},
		success: function (data) {
			loader(false);
			$("#txt_csrfname").val(data.csrfNewHash);
			if (data.success) {
				ajaxcart();
				Swal.fire({
					title: "Berhasil Ditambah ke Keranjang",
					text: data.message,
					icon: "success",
					showCancelButton: true,
					confirmButtonColor: "#007bff",
					cancelButtonColor: "#17a2b8",
					cancelButtonText: "Lanjut Belanja",
					confirmButtonText: "Lihat Keranjang",
				}).then((result) => {
					if (result.isConfirmed) {
						document.location.href = BASEURL + "cart";
					}
				});
			} else {
				swallError(false, data.message);
			}
		},
		error: function () {
			swallError(false, false, reload);
		},
	});
}

function updatecart(url, id, qty, custom = false) {
	var csrfName = $("#txt_csrfname").attr("name");
	var csrfHash = $("#txt_csrfname").val();
	$.ajax({
		url: BASEURL + url + id,
		type: "POST",
		data: { [csrfName]: csrfHash, qty: qty },
		dataType: "JSON",
		beforeSend: function () {
			loader(true);
		},
		success: function (data) {
			loader(false);
			$("#txt_csrfname").val(data.csrfNewHash);
			if (data.success) {
				ajaxcart();
				showcart();
				swallSuccess("Pembaruan Keranjang", data.message);
			} else {
				swallError(false, data.message);
			}
		},
		error: function () {
			swallError(false, false, reload);
		},
	});
}

function removecart(url, id, custom = false) {
	var csrfName = $("#txt_csrfname").attr("name");
	var csrfHash = $("#txt_csrfname").val();
	$.ajax({
		url: BASEURL + url,
		type: "POST",
		data: { [csrfName]: csrfHash, rowid: id },
		dataType: "JSON",
		beforeSend: function () {
			loader(true);
		},
		success: function (data) {
			loader(false);
			$("#txt_csrfname").val(data.csrfNewHash);
			if (data.success) {
				ajaxcart();
				if (custom) {
					showcart();
				}
				const Toast = Swal.mixin({
					toast: true,
					position: "top-end",
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
						toast.addEventListener("mouseenter", Swal.stopTimer);
						toast.addEventListener("mouseleave", Swal.resumeTimer);
					},
				});

				Toast.fire({
					icon: "success",
					title: data.message,
				});
			} else {
				swallError(false, data.message);
			}
		},
		error: function () {
			swallError(false, false, reload);
		},
	});
}

function swallError(title = false, text = false, link = false) {
	if (title === false) {
		title = "Terjadi Kesalahan";
	}
	if (text === false) {
		text = "Silahkan refresh halaman ini terlebih dahulu!";
	}
	Swal.fire(title, text, "warning").then(() => {
		if (link !== false) {
			document.location.href = link;
		}
	});
}

function swallSuccess(title, text, link = false) {
	Swal.fire(title, text, "success").then(() => {
		if (link !== false) {
			document.location.href = link;
		}
	});
}

function SimpanMaster(form, url) {
	var csrfName = $("#txt_csrfname").attr("name");
	var csrfHash = $("#txt_csrfname").val();
	var formData = new FormData(form);
	formData.append([csrfName], csrfHash);
	$.ajax({
		url: url,
		type: "POST",
		data: formData,
		contentType: false,
		cache: false,
		processData: false,
		dataType: "json",
		beforeSend: function () {
			loader(true);
		},
		success: function (x) {
			loader(false);
			$("#txt_csrfname").val(x.csrfNewHash);
			if (x.success) {
				swallSuccess(x.label, x.message, reload);
			} else {
				swallError(x.label, x.message);
			}
			return false;
		},
		error: function (x) {
			swallError(x.status, x.statusText);
			return false;
		},
	}).done(function () {
		return false;
	});
	return false;
}
