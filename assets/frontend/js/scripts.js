
// When Window Loaded.
$(window).on("load", function() {
  "use strict";
  $(".page-loader").fadeOut('fast');

  //*********************************************
  //  MOBILE & BROWSER DETECTERS
  //*********************************************

  // Control of the functions exists
  $.fn.exists = function() {
    return this.length > 0;
  };

  // Check the device for mobile or desktop
  if (
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    ) ||
    $(window).width() < 769
  ) {
    var mobile = true;
  } else {
    var mobile = false;
  }

  // Check the browsers
  // Opera 8.0+
  var isOpera =
      (!!window.opr && !!opr.addons) ||
      !!window.opera ||
      navigator.userAgent.indexOf(" OPR/") >= 0,
    // Firefox 1.0+
    isFirefox = typeof InstallTrigger !== "undefined",
    // Safari 3.0+ "[object HTMLElementConstructor]"
    isSafari =
      /constructor/i.test(window.HTMLElement) ||
      (function(p) {
        return p.toString() === "[object SafariRemoteNotification]";
      })(!window["safari"] || safari.pushNotification),
    // Internet Explorer 6-11
    isIE = /*@cc_on!@*/ false || !!document.documentMode,
    // Edge 20+
    isEdge = !isIE && !!window.StyleMedia,
    // Chrome 1+
    isChrome =
      /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor),
    // Blink engine detection
    isBlink = (isChrome || isOpera) && !!window.CSS,
    // Parallax effects for selected browsers
    isParallaxBrowsers = isOpera || isFirefox || isBlink || isChrome;

  // Add .ite-browser class if browsing with internet explorer.
  if (isIE) {
    $("body").addClass("ie-browser");
  }

  // If mobile device - DO ANYTHING FOR ONLY MOBILE
  if (mobile === true) {
    //Make scrollable parallax backgrounds
    $(".bg-parallax").addClass("bg-parallax-mobiled");
    // Add/Remove class with hover
    if ($("#side-dotted-navigation").exists()) {
      var self = $("#side-dotted-navigation");
      $("body section:not(.nav-menu), div").on("touch touchstart", function() {
        $(self).addClass("spy");
      });
      $(self).on("touch touchstart touchend", function() {
        $(self).removeClass("spy");
      });
      $('#side-dotted-navigation:not(".spy")').on("touch", function() {
        $(self).addClass("spy");
      });
    }
    $(".hero-slider").height($(window).outerHeight());
    //do something else for mobile devices

    // If not mobile device DO ANYTHING FOR ONLY DESKTOPS
  } else {
    //Ready skrollr effects
    var s = skrollr.init({
      forceHeight: false,
      smoothScrolling: false
    });

    //Set the parallax items
    $("body").addClass("stable");
    $(window).on("scroll", function() {
      if ($("body").hasClass("stable")) {
        //Refresh parallax effect
        setTimeout(function() {
          if (isParallaxBrowsers) {
            s.refresh();
          }
        }, 100);
        $(window).trigger("resize");
        $("body").removeClass("stable");
      }
    });

    $("#extranav").ready(function() {
      //Show and hide extra Navigation
      function showHideExtraNav() {
        var nowPos = $(window).scrollTop();
        //Extra navigation variations
        var extranav = $("#extranav"),
          showExNav = extranav.attr("data-showme"),
          hideExNav = extranav.attr("data-hideme");
        if ($(hideExNav).exists() && $(showExNav).exists()) {
          var showSection = $(showExNav).offset().top,
            hideSection = $(hideExNav).offset().top;
          if ($(window).width() > 700) {
            if (nowPos >= showSection - 60 && nowPos <= hideSection - 60) {
              $(extranav)
                .slideDown(150)
                .removeClass("hiding");
            } else {
              $(extranav)
                .addClass("hiding")
                .slideUp(150);
            }
          }
        } else {
          $(extranav)
            .slideDown(150)
            .removeClass("hiding")
            .find("ul.nav")
            .html(
              "Extra Navigation is here! Please check the data-showme and data-hideme areas. This page does not have those links."
            );
        }
      }
      $(window).on("scroll", function() {
        showHideExtraNav();
      });
    });

    //Do something else for only large screen devices
  }

  //*********************************************
  //  Detect Retina Screens and use retina logo
  //*********************************************
  //Detect retina screen type
  function isRetina() {
    return (
      (window.matchMedia &&
        (window.matchMedia(
          "only screen and (min-resolution: 124dpi), only screen and (min-resolution: 1.3dppx), only screen and (min-resolution: 48.8dpcm)"
        ).matches ||
          window.matchMedia(
            "only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3)"
          ).matches)) ||
      (window.devicePixelRatio && window.devicePixelRatio > 1.3)
    );
  }
  //Add .retina-device class to body if the device is retina. And change images for retina screens
  if (isRetina()) {
    $("body").addClass("retina-device");
    $("[data-retina-image]").each(function() {
      var $this = $(this),
        $itemWidth = $(this).width(),
        $rtnIMG = $(this).attr("data-retina-image");
      $(this)
        .attr("src", $rtnIMG)
        .css({ width: $itemWidth + "px" });
    });
  }
  //Add .has-retina-logo class to body if navigation has retina logo
  if ($(".retina-logo").exists()) {
    $("body").addClass("has-retina-logo");
  }

  //*********************************************
  //  QUADRA SPECIAL EFFECTS AND FEATURES
  //*********************************************

  //Get screen size of device
  $.fn.getDeviceWidth = function() {
    if ($(window).width() > 1200) {
      $("body")
        .not(".device-xl")
        .removeClass("device-lg device-md device-sm device-xs device-xxs")
        .addClass("device-xl");
    }
    if ($(window).width() > 992 && $(window).width() < 1200) {
      $("body")
        .not(".device-lg")
        .removeClass(
          "device-xl device-lg device-md device-sm device-xs device-xxs"
        )
        .addClass("device-lg");
    }
    if ($(window).width() > 768 && $(window).width() < 992) {
      $("body")
        .not(".device-md")
        .removeClass(
          "device-xl device-lg device-md device-sm device-xs device-xxs"
        )
        .addClass("device-md");
    }
    if ($(window).width() > 576 && $(window).width() < 768) {
      $("body")
        .not(".device-sm")
        .removeClass(
          "device-xl device-lg device-md device-sm device-xs device-xxs"
        )
        .addClass("device-sm");
    }
    if ($(window).width() > 480 && $(window).width() < 576) {
      $("body")
        .not(".device-xs")
        .removeClass(
          "device-xl device-lg device-md device-sm device-xs device-xxs"
        )
        .addClass("device-xs");
    }
    if ($(window).width() < 480) {
      $("body")
        .not(".device-xxs")
        .removeClass(
          "device-xl device-lg device-md device-sm device-xs device-xxs"
        )
        .addClass("device-xxs");
    }
  };
  $("body").getDeviceWidth();

  //Put background images to mobile
  if ($(window).width() < 769) {
    $("[data-mobile-background]").each(function() {
      var bgSRC = $(this).data("mobile-background");
      $(this)
        .addClass("bg-mobiled")
        .css({
          "background-image": "url(" + bgSRC + ")",
          "background-size": "cover !important"
        });
    });
  }
  //Lazy Load
  if ($("[data-original]").exists()) {
    $("[data-original]").lazyload({
      threshold: 1000
    });
  }
  //Play buttons for iframe videos
  if ($(".video-trigger").exists()) {
    $(".video-trigger").each(function() {
      var target = $(this).find("iframe"),
        trigger = $(this).find(".video-play-trigger"),
        src = $(target).data("src");
      $(trigger).on("click", function(ev) {
        $(target).attr("src", src);
        ev.preventDefault();
        $(this)
          .delay(200)
          .fadeOut(500);
      });
    });
  }

  //Quadra Alert on page
  $(".qdr-alert-trigger").each(function() {
    var self = $(this),
      target = $(self).data("target"),
      timer;
    $(self).on("click", function() {
      clearTimeout(timer);
      $(target)
        .fadeOut(0)
        .stop()
        .clearQueue();
      setTimeout(function() {
        $(target).fadeIn(300);
      }, 1);
      timer = setTimeout(function() {
        $(target).fadeOut(300);
      }, 3000);
    });
  });

  //Stay Page
  $(".stay").on("click", function(e) {
    e.preventDefault();
  });

  //Cookie Modal close with checkbox
  var my_cookie = $.cookie($(".modal-check").attr("name")),
    cookieModal = $("#cookie-modal");
  if (my_cookie && my_cookie == "true") {
    $(this).prop("checked", my_cookie);
  } else {
    $(cookieModal).modal("show");
  }
  $(".modal-check").change(function() {
    $.cookie($(this).attr("name"), $(this).prop("checked"), {
      path: "/",
      expires: 1
    });
  });

  //Cookie Modal Classic
  if (
    ($.cookie("no_thanks") == null && $("#cookie-alert").exists()) ||
    $("#cookie-modal").exists()
  ) {
    // Show the modal, with delay func.
    $.fn.show_modal = function() {
      $("#cookie-alert").modal({ backdrop: "static", keyboard: false });
      $(".modal-backdrop.show:not(.fade)").removeClass("modal-backdrop");
      $("body").addClass("cookie-alert-active");
    };
    // Set delay func. time in milliseconds
    setTimeout(function() {
      $(window).show_modal();
    }, 3000);
  }
  // On click of specified class (e.g. 'nothanks'), trigger cookie, which expires in 100 years
  $.fn.closeCookieAlert = function() {
    $.cookie("no_thanks", "true", { expires: 1, path: "/" });
    $("body").removeClass("cookie-alert-active");
    $("#cookie-alert").hide();
  };
  $("#cookie-alert .close").on("click", function() {
    $("body").closeCookieAlert();
  });
  $(document).keyup(function(e) {
    if (e.keyCode == 27) {
      $("body").closeCookieAlert();
    }
  });

  //Quadra Hovers;
  $(".qdr-hover").each(function() {
    var qdrText = $(this).html();
    $(this).empty();
    $(this).append("<span class='qdr-details'></span>");
    $(this)
      .find("span.qdr-details")
      .html(qdrText);
  });
  $(".qdr-hover-3").each(function() {
    var qdrText = $(this).html();
    $(this).empty();
    $(this).append("<span class='qdr-details'></span>");
    $(this)
      .find("span.qdr-details")
      .html(qdrText);
  });
  //Clearfix class for the boxes and cols
  $(".boxes").addClass("clearfix");
  $('[class*="qdr-col-"]').addClass("clearfix");
  //Add data-color option to everything, for example; data-color="#333"
  $("[data-color]").each(function() {
    var clrSRC = $(this).data("color");
    $(this).css({ color: clrSRC });
  });
  $("[data-bgcolor]")
    .not(".tp-bgimg")
    .not(".rev-slidebg")
    .each(function() {
      var clrSRC = $(this).data("bgcolor");
      $(this).css({ "background-color": clrSRC });
    });
  //QDR moving items
  if ($(".moving-container").exists()) {
    if (
      navigator.userAgent.indexOf("Safari") != -1 &&
      navigator.userAgent.indexOf("Chrome") == -1
    ) {
    } else {
      $(".moving-container").each(function() {
        var selector = $(this).find(".moving");
        $(this).hover3d({
          selector: selector,
          shine: false,
          perspective: 1500,
          sensitivity: 85,
          invert: false
        });
      });
    }
  }
  //Mouse animation for portfolio images
  if ($(".styled-portfolio.parallax").exists()) {
    if ($(window).width() > 630) {
      $(".styled-portfolio.parallax .cbp-item").each(function(i, el) {
        $(this).on("mouseenter", function(e) {
          var currentX = "",
            currentY = "",
            movementConstant = 0.1;
          var item = $(this);
          $(item).mousemove(function(e) {
            if (currentX == "") currentX = e.pageX;
            var xdiff = e.pageX - currentX;
            currentX = e.pageX;
            if (currentY == "") currentY = e.pageY;
            var ydiff = e.pageY - currentY;
            currentY = e.pageY;
            $(item)
              .find(".cbp-caption-defaultWrap")
              .each(function(i, el) {
                var movement = (i + 1) * (xdiff * movementConstant),
                  movementy = (i + 1) * (ydiff * movementConstant),
                  newX = $(el).position().left + movement,
                  newY = $(el).position().top + movementy;
                $(el)
                  .find("img")
                  .css({
                    "-webkit-transform":
                      "translate(" + newX + "px," + newY + "px) scale(1.06)"
                  });
              });
          });
        });
        $(this).on("mouseleave", function(e) {
          $(this)
            .find("img")
            .css({ "-webkit-transform": "translate(0px,0px) scale(1.0)" });
        });
      });
    }
  }
  //Call fitvids
  if ($(".fitvids").exists()) {
    $(".fitvids").fitVids();
  }
  //Call YTPlayer - you should include ytplayer's js and css files to your file.
  if ($("[data-property]").exists()) {
    $(".player").YTPlayer();
  }
  //Strip timeline scripts
  if ($(".timeline-container").exists()) {
    $(".timeline-container").each(function() {
      var $this = $(this);
      $(this)
        .find(".dates div")
        .each(function() {
          var eventID = $(this).data("event-id"),
            activeDate = $($this).data("active-date");
          //Add Classes to selected item
          $($this)
            .find("#" + activeDate)
            .addClass("active");
          $($this)
            .find('[data-event-id="' + activeDate + '"]')
            .addClass("active");
          //Item on hover
          $(this).mouseenter(function() {
            $($this)
              .find("#" + activeDate)
              .removeClass("active");
            $($this)
              .find("#" + eventID)
              .addClass("active");
            $($this)
              .find('[data-event-id="' + activeDate + '"]')
              .removeClass("active");
          });
          //Get back active class
          $(this).mouseleave(function() {
            $($this)
              .find("#" + activeDate)
              .addClass("active");
            $($this)
              .find('[data-event-id="' + activeDate + '"]')
              .addClass("active");
            $($this)
              .find("#" + eventID)
              .removeClass("active");
            $($this)
              .find("#" + activeDate)
              .addClass("active");
          });
        });
    });
  }
  //Progress Bars
  if ($(".progress-bar").exists()) {
    $(".progress-bar").each(function() {
      var $this = $(this);
      $($this).waypoint(
        function() {
          var dataSource = $($this).attr("data-value");
          $($this).animate({ width: dataSource + "%" }, 300);
          this.destroy();
        },
        { offset: "100%" }
      );
    });
  }
  //.vertical-center
  $.fn.verticalPosition = function() {
    // Calculate Vertical Center
    $(".vertical-center").each(function() {
      var itemH = $(this).height();
      $(this).css({ "margin-top": -itemH / 2 });
    });
  };
  $("body").verticalPosition();
  //Call Tooltip
  $('[data-toggle="tooltip"], .tooltip-item').each(function() {
    var self = $(this),
      prnt = $(self).parent();
    $(self).tooltip({ html: true, container: prnt });
  });
  //Active me - you can add this class to active with click and disable with click another area.
  $(".active-me-with-click").each(function() {
    var item = $(this);
    $(window).on("click touchstart touch", function(event) {
      $(item).removeClass("active");
    });
    $(item).on("click touch", function() {
      $(item).toggleClass("active");
      return false;
    });
  });
  //Call popovers
  $('[data-toggle="popover"]').each(function() {
    var self = $(this),
      prnt = $(self).parent();
    $(self).popover({ html: true, container: prnt });
  });
  //Call InfoCard
  $("[data-infocard]").each(function() {
    //Variations
    var item = $(this),
      target = $(this).data("infocard"),
      timer;
    //MouseEnter
    $(item).on("mouseenter", function() {
      $(target).addClass("active");
      clearTimeout(timer);
      $(".icon-navigation").addClass("passive");
    });
    $(target).on("mouseenter", function() {
      $(target).addClass("active");
      clearTimeout(timer);
      $(".icon-navigation").addClass("passive");
    });
    //MouseLeave
    $(item).on("mouseleave", function() {
      timer = setTimeout(function() {
        $(target).removeClass("active");
        $(".icon-navigation").removeClass("passive");
      }, 250);
    });
    $(target).on("mouseleave", function() {
      timer = setTimeout(function() {
        $(target).removeClass("active");
        $(".icon-navigation").removeClass("passive");
      }, 250);
    });
  });
  //Animated Gradient Efffects
  $("[data-gradient-bg]").each(function() {
    var grSRC = $(this).data("gradient-bg"),
      grSize = $(this).data("gradient-size");
    $(this).css({
      background: "linear-gradient(90deg," + grSRC + ")",
      "background-size": grSize + "%" + grSize + "%"
    });
  });
  //Quadra Modal
  if ($("#quadra_fixed_modal").exists()) {
    $.fn.qfmScript = function() {
      $("#quadra_fixed_modal:not(.hiding)").each(function() {
        //Open and Close Modal
        var $qfm = $(this),
          $qfmtop = $(this).find(".quadra_fixed_modal_top"),
          $qfmtitle = $(this).find("#qfm_title"),
          $qfmbutton = $(this).find("#qfm_button");
        $(".quadra_fixed_modal_top, .qfm-trigger").on("click", function() {
          $qfm.toggleClass("active force-show");
          $("body").toggleClass("qdr-modal-open");
          $qfmtop.delay(400).toggleClass("open_modal");
          $qfmtitle.delay(100).fadeToggle(900);
          $qfmbutton.delay(100).fadeToggle(900);
          $qfm.animate({ scrollTop: 0 }, "fast");
          return false;
        });
        //Close the QFM with press ESC.
        $(document).keyup(function(e) {
          if (e.keyCode == 27) {
            $qfm.removeClass("active force-show");
            $("body").removeClass("qdr-modal-open");
            $qfmtop.delay(400).removeClass("open_modal");
            $qfmtitle.delay(100).fadeOut(900);
            $qfmbutton.delay(100).fadeIn(900);
            $qfm.animate({ scrollTop: 0 }, "fast");
          }
        });
        //caches a jQuery object containing the header element
        function showHideQFM() {
          if ($qfm.data("showme") && $qfm.data("hideme")) {
            //get positions
            var showMe = $qfm.data("showme"),
              hideMe = $qfm.data("hideme"),
              winHeight = $(window).outerHeight(),
              showMeP = $(showMe).offset().top,
              hideMeP = $(hideMe).offset().top,
              nowP = $(this).scrollTop();
            //Show and hide Modal
            if (nowP >= showMeP - winHeight && nowP <= hideMeP - winHeight) {
              $qfm.addClass("clickable");
              $(".drop-msg, #back-to-top").addClass("qfm-time");
            } else {
              $qfm.removeClass("clickable");
              $(".drop-msg, #back-to-top").removeClass("qfm-time");
            }
          }
        }
        window.onscroll = showHideQFM;
      });
    };
    $(window).qfmScript();
  }

  //Hide Modal
  $("#qfm_button span.hide-modal").on("click touch", function() {
    $("#quadra_fixed_modal")
      .removeClass(".active .clickable")
      .addClass("hiding");
    $("body").addClass("qfm-hiding");
    $(".drop-msg, #back-to-top")
      .removeClass("qfm-time")
      .addClass("modal-hiding");
    return false;
  });

  //Sidebar
  if ($(".sidebar").exists()) {
    $(".sidebar")
      .sidebar("attach events", ".sidebar-button", "show")
      .sidebar("setting", "transition", "overlay");
  }
  //Quick Contact Form Scripts
  $(window).on("click touchstart touch", function(event) {
    $(".quick-contact-form")
      .fadeOut("fast")
      .removeClass("active");
    $("body").removeClass("quick-contact-form-active");
  });
  $(".drop-msg, .quick-contact-form-trigger").on("click touch", function() {
    $(".quick-contact-form")
      .fadeToggle("fast")
      .toggleClass("active");
    $("body").toggleClass("quick-contact-form-active");
    return false;
  });
  $(
    ".quick-contact-form, .drop-msg, .quick-contact-form-trigger, #error_message"
  ).on("click touch touchstart", function(event) {
    event = event || window.event;
    event.stopPropagation();
  });

  //.waypoint-active class for waypoint items
  if ($(".waypoint").exists()) {
    $(".waypoint").each(function() {
      var $this = $(this);
      $($this).waypoint(
        function() {
          $($this).addClass("waypoint-active");
        },
        { offset: "75%" }
      );
    });
  }

  //Fixed Footer Options
  if ($("footer.footer-fixed").exists()) {
    var footer = $("footer.footer-fixed"),
      footerH = $(footer).outerHeight();
    $(
      '<div class="fullwidth bg-transparent footer-keeper" style="height:' +
        footerH +
        'px;"></div> '
    ).insertAfter(footer);
    $("body").addClass("footer-fixed-page");
    $(window).resize(function() {
      var footerH = $(footer).outerHeight();
      $(".footer-keeper").height(footerH);
    });
  }

  //Dropdown Effect - get value to button
  $("button.dropdown-toggle + .dropdown-menu").each(function() {
    var target = "#" + $(this).attr("aria-labelledby"),
      self = $(this);
    $(self)
      .find("li")
      .on("click", function() {
        var cache = $(target).children();
        var detail = $(this)
          .find("div")
          .html();
        $(target)
          .text(detail)
          .append(cache);
      });
  });
  // Quantity up-down clicks
  $(".quantity").each(function() {
    var minus = $(this).find(".minus"),
      plus = $(this).find(".plus"),
      numbers = $(this).find(".numbers");
    $(plus).on("click", function() {
      $(numbers).val(parseInt($(numbers).val(), 10) + 1);
    });
    $(minus).on("click", function() {
      $(numbers).val(parseInt($(numbers).val(), 10) - 1);
    });
  });

  //Text Typer
  if ($("#type").exists()) {
    $("#type").typed({
      // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
      stringsElement: $("#type-get"),
      typeSpeed: 10,
      backDelay: 800,
      loop: true,
      contentType: "html", // or text
      // defaults to false for infinite loop
      loopCount: false,
      showCursor: true,
      resetCallback: function() {
        newTyped();
      }
    });
  }
  if ($(".text-typer").exists()) {
    $(".text-typer").each(function() {
      var self = $(this),
        delay = $(self).data("delay"),
        speed = $(self).data("speed");
      $(self).typed({
        // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
        stringsElement: $(self).find(".text-get"),
        typeSpeed: speed,
        backDelay: delay,
        loop: true,
        contentType: "html", // or text
        // defaults to false for infinite loop
        loopCount: false,
        showCursor: true,
        resetCallback: function() {
          newTyped();
        }
      });
    });
  }
  //Text Rotator
  if ($(".text-rotator").exists()) {
    $(".text-rotator").each(function() {
      var animateType = $(this).attr("data-animation"),
        speed = $(this).attr("data-speed");
      $(this).Morphext({
        animation: animateType,
        separator: ",",
        speed: speed
      });
    });
  }
  //Twitter Feed
  if ($(".twitter-feed").exists()) {
    $(".twitter-feed").each(function() {
      var twitterFeeder = $(this),
        username = $(twitterFeeder).data("username"),
        count = $(twitterFeeder).data("count"),
        gap = $(twitterFeeder).data("gap");
      $(twitterFeeder).html("Loading Tweets...");
      $.getJSON("php/twitter.php?un=" + username + "&count=" + count, function(
        data
      ) {
        $(twitterFeeder).empty();
        var items = [];
        $.each(data, function(key, val) {
          items.push(
            "<li id='" +
              key +
              "'><a href='https://twitter.com/goldeyes/status/" +
              val.id +
              "' target='_blank'><i class='fa fa-twitter'></i><span class='tweetText'>" +
              val.text +
              "</span>...<span class='postDate'>Posted on " +
              val.date +
              "</span></a></li>"
          );
        });
        $("<ul/>", { class: "twitter-list", html: items.join("") }).appendTo(
          twitterFeeder
        );
        $(twitterFeeder)
          .find("ul.twitter-list")
          .addClass("gap-" + gap + "");
        if ($(".twitter-feed").hasClass("slider")) {
          var sliderFeeder = $(".twitter-feed.slider");
          $(sliderFeeder)
            .find("ul.twitter-list")
            .addClass("twitter-slider circle-dots")
            .slick({
              dots: true,
              arrows: false,
              slidesToShow: 1,
              slidesToScroll: 1,
              adaptiveHeight: true
            });
        }
        $(twitterFeeder)
          .find(".tweetText")
          .text(function(index, currentText) {
            return currentText.substr(0, 125);
          });
      });
    });
  }
  //Click effect
  $(function() {
    var ink, d, x, y;
    $(".click-effect").on("click", function(e) {
      if ($(this).find(".ink").length === 0) {
        $(this).prepend("<span class='ink'></span>");
      }
      ink = $(this).find(".ink");
      ink.removeClass("clicked");
      if (!ink.height() && !ink.width()) {
        d = Math.max($(this).outerWidth(), $(this).outerHeight());
        ink.css({ height: d, width: d });
      }
      x = e.pageX - $(this).offset().left - ink.width() / 2;
      y = e.pageY - $(this).offset().top - ink.height() / 2;
      ink.css({ top: y + "px", left: x + "px" }).addClass("clicked");
    });
  });

  //*********************************************
  //  NAVIGATION SCRIPTS
  //*********************************************

  // Navigation Scroll Calling - You can select the Offset
  $(".nav>li>a").addClass("nav-link");
  $("body").scrollspy({ target: ".nav-menu", offset: 200 });
  $("body").scrollspy({ target: "menus", offset: 250 });

  //Sticky Navigation Scripts
  $("#navigation.sticky").sticky({ topSpacing: 0 });
  //Make Dropdown
  $("#navigation .dropdown-toggle").each(function() {
    $(this).on("mouseenter", function() {
      var $this = $(this),
        $item = $($this).find(">.dropdown-menu");
      $($item).show(0);
      //Check screen sizes, dropdown width and heights
      var navTop = $("#navigation").offset().top,
        navHeight = $("#navigation").outerHeight(),
        itemTop = $($item).offset().top - navTop + navHeight,
        itemWidth = $($this).outerWidth(),
        itemHeight = $($item).outerHeight(),
        wWidth = $(window).outerWidth(),
        wHeight = $(window).outerHeight(),
        ofRight = wWidth - ($item.offset().left + $item.outerWidth()),
        thisRight = wWidth - ($this.offset().left + $this.outerWidth()),
        ofBottom = wHeight - (itemTop + $item.outerHeight());
      if (ofRight < 30) {
        if (
          $($item).hasClass("mega-menu") &&
          !$("#navigation").hasClass("side-menu")
        ) {
          $($item)
            .addClass("to-left")
            .css({ right: -thisRight + 50 + "px" });
        } else {
          $($item)
            .removeClass("to-right to-center")
            .addClass("to-left");
        }
      }
      if (ofBottom < 10) {
        if (
          !$($item).hasClass("mega-menu") &&
          !$("#navigation").hasClass("side-menu") &&
          $(this).closest(".dropdown-menu").length > 0
        ) {
          $($item).css({ top: wHeight - (itemTop + itemHeight) + 50 + "px" });
        }
      } else {
        if ($(this).closest(".dropdown-menu").length > 0) {
          $($item).css({ top: "0px" });
        } else {
          $($item).css({ top: "100%" });
        }
      }
      $("#navigation .dropdown-toggle")
        .not(this)
        .not($(this).parents(".dropdown-toggle"))
        .not($(this).find(".dropdown-toggle"))
        .find(".dropdown-menu")
        .stop(true, true)
        .hide(0);
    });
    $(this).on("mouseleave", function() {
      var $this = $(this),
        $item = $($this).find(">.dropdown-menu");
      if (!$(this).parents(".dropdown-toggle").length) {
        $($item)
          .stop(true, true)
          .delay(600)
          .hide(0);
      } else {
        $($item).hide(0);
      }
      if ($(this).closest(".dropdown-menu").length > 0) {
        $($item).css({ top: "0px" });
      } else {
        $($item).css({ top: "100%" });
      }
    });
    $("#navigation .nav>li:not(.dropdown-toggle)").on("mouseenter", function() {
      $("#navigation .nav>.dropdown-toggle>.dropdown-menu")
        .stop(true, true)
        .hide(0);
    });
  });
  //Calculate dropdown positions of side menus
  $("#navigation.side-menu .dropdown-toggle").each(function() {
    $(this).on("mouseenter", function() {
      var $this = $(this),
        $item = $($this).find(">.dropdown-menu"),
        navTop = $("#navigation").offset().top,
        itemTop = $item.offset().top,
        itemHeight = $item.height(),
        wHeight = $(window).height(),
        itemPos = wHeight - (itemTop - navTop) - itemHeight;
      if (itemPos < 0) {
        $($item).css({ top: +itemPos - 20 + "px" });
      }
    });
  });
  //Dropdown to center
  $(".to-center").each(function() {
    var menuW = $(this).outerWidth();
    if ($(window).width() > 1200) {
      $(this).css({ left: -menuW / 2 + 40 + "px" });
    }
  });
  //Find item notes and add item-noted class to "a" tags.
  if ($("#navigation .item-note").exists()) {
    $("#navigation .nav-menu .item-note").each(function() {
      $(this)
        .closest("a")
        .addClass("item-noted");
    });
  }

  $(".mega-menu").css({ "max-width": $(window).width() - 40 + "px" });
  $(window).resize(function() {
    $(".mega-menu").css({ "max-width": $(window).width() - 40 + "px" });
  });

  //Modern Navigation Options (Jump and Shrink)
  var $navigationJump = $("#navigation.modern.jump");
  var navigationShrink = $("#navigation.modern.shrink");
  //Stability Class for scroll effects
  $($navigationJump).addClass("stability");
  //Get Logo Source
  var normalIMG = $("#navigation .logo img:not(.retina-logo)"),
    firstLogo = $(normalIMG).attr("src"),
    secondLogo = $(normalIMG).data("second-logo"),
    retinaIMG = $("#navigation .logo img.retina-logo"),
    firstRetinaLogo = $(retinaIMG).attr("src"),
    secondRetinaLogo = $(retinaIMG).data("second-logo");
  //Set the navigation position
  window.scrollBy(0, -1);

  //Options for Shrink Navigation
  $.fn.shrinkActive = function() {
    $(navigationShrink).addClass("scrolled");
    $(navigationShrink)
      .find(normalIMG)
      .attr("src", secondLogo);
    $(navigationShrink)
      .find(retinaIMG)
      .attr("src", secondRetinaLogo);
  };
  $.fn.shrinkDisable = function() {
    $(navigationShrink).removeClass("scrolled");
    $(navigationShrink)
      .find(normalIMG)
      .attr("src", firstLogo);
    $(navigationShrink)
      .find(retinaIMG)
      .attr("src", firstRetinaLogo);
  };

  //Get back first navigation
  $.fn.scrollUpNav = function() {
    $navigationJump
      .removeClass("scrolled nav_up")
      .addClass("stability")
      .find(normalIMG)
      .attr("src", firstLogo);
    $($navigationJump)
      .find(retinaIMG)
      .attr("src", firstRetinaLogo);
  };
  //Get scrolled navigation
  $.fn.scrollDownNav = function() {
    if ($navigationJump.hasClass("stability")) {
      $navigationJump.addClass("nav_up");
      setTimeout(function() {
        $navigationJump.addClass("scrolled");
      }, 0);
      setTimeout(function() {
        $($navigationJump)
          .find(normalIMG)
          .attr("src", secondLogo);
        $($navigationJump)
          .find(retinaIMG)
          .attr("src", secondRetinaLogo);
      }, 100);
      setTimeout(function() {
        $navigationJump.removeClass("nav_up stability");
      }, 200);
      $("#navigation.jump.pagetopped .logo img:not(.retina-logo)").attr(
        "src",
        secondLogo
      );
      $("#navigation.jump.pagetopped .logo img.retina-logo").attr(
        "src",
        secondRetinaLogo
      );
    }
  };

  $(window).on("scroll", function() {
    var $navigationJumpNorm = $("#navigation.jump.scrolled:not(.pagetopped)");
    //Change the navigation type
    if ($("#pagetop").exists()) {
      var $pagetopH = $("#pagetop").height() * 3;
      if ($(this).scrollTop() > $pagetopH) {
        $("#navigation").scrollDownNav();
      } else {
        $("#navigation").scrollUpNav();
      }
      if ($(this).scrollTop() > $pagetopH * 3) {
        $($navigationJump).addClass("show");
      } else {
        $($navigationJump).removeClass("show");
      }
    } else {
      if ($(window).scrollTop() > 100) {
        $("#navigation").scrollDownNav();
      } else {
        $("#navigation").scrollUpNav();
      }
    }
    if ($(this).scrollTop() > 0) {
      if (!$(navigationShrink).hasClass("scrolled")) {
        $(navigationShrink).shrinkActive();
      }
    } else {
      if ($(navigationShrink).hasClass("scrolled")) {
        $(navigationShrink).shrinkDisable();
      }
    }
    //Use Shrink Navigation With Sticky
    if ($("#navigation-sticky-wrapper").exists()) {
      if (
        $("#navigation-sticky-wrapper").hasClass("is-sticky") &&
        $(this).scrollTop() > 100
      ) {
        $(navigationShrink).shrinkActive();
      } else {
        $(navigationShrink).shrinkDisable();
      }
    }
  });

  //Mobile Options
  // Add menu icon for mobile navigation
  $(
    '<div class="mobile-nb"><div class="hamburger-menu"><div class="top-bun"></div><div class="meat"></div><div class="bottom-bun"></div></div></div>'
  ).insertAfter("#navigation div.logo");
  // Show/Hide mobile navigation
  $(".mobile-nb").on("click", function() {
    setTimeout(function() {
      $("#mobile-navigation").addClass("active");
    }, 300);
    $("#mobile-navigation-closer").fadeIn();
  });
  // Create mobile navigation and get elements
  $(
    '<div id="mobile-navigation" class="nav-menu"><div class="mb-close"></div><div class="nav-el"></div><div class="pagetop"></div></div>'
  ).insertAfter("#navigation");
  var $navMenus = $("#navigation .nav-menu, #punch-navigation").html(),
    $navEl = $("#navigation .nav-elements").html(),
    $navTop = $("#pagetop").html();
  //Get navigation menus
  $($navMenus).insertBefore("#mobile-navigation .nav-el");
  //Get all values If nav menus more than 1
  if ($("#navigation .columns .nav-menu").length > 1) {
    var $lastMenu = $("#navigation .nav-menu:last-child > ul").html();
    $($lastMenu).insertAfter("#mobile-navigation .nav li:last-child");
  }
  //Get navigation elements - search button select language .etc
  $("#mobile-navigation .nav-el").append($navEl);
  //Get Pagetop
  if ($("#pagetop").exists()) {
    $("#mobile-navigation .pagetop").append($navTop);
  }
  //Move the search button
  if ($("#mobile-navigation .search-form-trigger").exists()) {
    $("#mobile-navigation .search-form-trigger").appendTo(
      "#mobile-navigation .nav-el"
    );
  }
  //Move search form to mobile navigation from sidemenu
  if ($("#navigation.side-menu .search").exists()) {
    $("#mobile-navigation .nav-el").append(
      '<a href="#" class="search-form-trigger"><i class="fa fa-search"></i></a>'
    );
  }
  if ($("#navigation.side-menu .menu-bottom").exists()) {
    var mBottom = $("#navigation.side-menu .menu-bottom").html();
    $("#mobile-navigation .pagetop").append(mBottom);
  }
  var $desktopLogo = $("#navigation .logo img").attr("src");
  $.fn.changeMobileLogo = function() {
    if ($(window).width() < 1120) {
      var $mobileLogo = $("#navigation .logo img").attr("data-mobile-logo");
      if (typeof $mobileLogo !== typeof undefined && $mobileLogo !== false) {
        $("#navigation .logo img").attr("src", $mobileLogo);
      }
    } else {
      $("#navigation .logo img").attr("src", $desktopLogo);
    }
  };
  $(window).changeMobileLogo();
  //Close Mobile Navigation
  $(
    '<div id="mobile-navigation-closer"></div><textarea id="math" style="display:none;"></textarea>'
  ).insertAfter("#mobile-navigation");
  $("#mobile-navigation-closer, .search-form-trigger, .mb-close").on(
    "click",
    function() {
      $("#mobile-navigation").removeClass("active");
      setTimeout(function() {
        $("#mobile-navigation-closer").fadeOut();
      }, 300);
    }
  );
  //Make Dropdown for mobile
  $("#mobile-navigation li.dropdown-toggle > a").append("<i></i>");
  $("#mobile-navigation .dropdown-toggle>a")
    .not(".cart-item")
    .on("click touch", function() {
      $(this)
        .toggleClass("showing")
        .closest("li")
        .find("> ul.dropdown-menu")
        .slideToggle({ duration: 300, easing: "easeInOutQuart" });
      return false;
    });

  //Pagetop collaboration with navigation
  if ($(window).width() > 1120) {
    $("#pagetop").each(function() {
      var itemH = $(this).outerHeight(),
        bigNav = $("#navigation.modern").not(".sticky, .static");
      bigNav.addClass("pagetopped").css("margin-top", itemH + "px");
    });
  }
  //See links inside the page for smooth scroll
  $(
    "a[href^='#']:not([href='#']):not(.no-scroll):not([data-slide]):not([data-toggle])"
  ).on("click touch", function(event) {
    var $anchor = $(this),
      headerOffset = $("#navigation").data("offset"),
      $target = $($anchor).attr("href");
    event.preventDefault();
    if ($($target).length) {
      if ($("#navigation").length) {
        $("html, body")
          .stop()
          .animate(
            {
              scrollTop:
                $($anchor.attr("href")).offset().top - headerOffset + "px"
            },
            1150,
            "easeInOutExpo"
          );
      } else {
        $("html, body")
          .stop()
          .animate(
            { scrollTop: $($anchor.attr("href")).offset().top },
            900,
            "easeInOutExpo"
          );
      }
    }
  });

  //Back to top
  $("a[href='#top']").on("click", function() {
    $("html, body")
      .stop()
      .animate({ scrollTop: 0 }, 1400, "easeInOutExpo");
  });
  //Hide with scroll down - Back to top button - hide-on-home elements
  if (
    $(".hide-by-scroll").exists() ||
    $("#back-to-top").exists() ||
    $(".hide-on-home").exists()
  ) {
    // hide #back-to-top first
    $("#back-to-top, .hide-on-home").hide();
    // show hide subnav depending on scroll direction
    var position = $(window).scrollTop();
    $(window).on("scroll touchmove", function() {
      var scroll = $(window).scrollTop();
      if (scroll > position - 1 && scroll > 700) {
        $(".hide-by-scroll").addClass("hiding");
      } else {
        $(".hide-by-scroll").removeClass("hiding");
      }
      position = scroll;
      if ($(window).scrollTop() + $(window).height() === $(document).height()) {
        $(".hide-by-scroll").removeClass("hiding");
      }
      // fade in #back-top
      // You can add .hide-on-home class to any fixed item. It will be unvisible on home and visible when you scroll down.
      if ($(this).scrollTop() > 500) {
        $("#back-to-top, .hide-on-home").fadeIn();
      } else {
        $("#back-to-top, .hide-on-home").fadeOut();
      }
    });
  }
  $(".hide-by-click").on("click", function() {
    $(this).fadeOut("slow");
  });

  //*********************************************
  //  Side Dotted Navigation
  //*********************************************
  // Add/Remove class with hover
  if ($("#side-dotted-navigation").exists()) {
    var self = $("#side-dotted-navigation");
    $(self).on("mouseenter", function() {
      $(this).removeClass("spy");
    });
    $(self).on("mouseleave", function() {
      $(this).addClass("spy");
    });
    $(self).on("click touch touchstart", function() {
      event = event || window.event;
      event.stopPropagation();
    });
  }
  //*********************************************
  //  Punch Navigation Scripts
  //*********************************************
  //Show Punch navigation
  $.fn.showPunchNavigation = function() {
    // Calculate Vertical Center
    $("#punch-navigation").addClass("activated");
    $("#punch-navigation .shadow").fadeIn(300);
    $("body").addClass("o-hidden");
    $(".top-elements, .bottom-elements, div.navblock *")
      .delay(950)
      .fadeIn(300);
    $("body").calculateWidth();
  };
  //Hiding navigation scripts
  $.fn.hidePunchNavigation = function() {
    $(".top-elements, .bottom-elements, div.navblock>*").fadeOut(300);
    $("#punch-navigation .shadow")
      .delay(1000)
      .fadeOut(300);
    setTimeout(function() {
      $("#punch-navigation").addClass("closing");
      $("body").removeClass("o-hidden");
      $("body").calculateWidth();
    }, 100);
    setTimeout(function() {
      $("#punch-navigation").removeClass("closing activated");
    }, 1400);
  };
  //Call punch nav with ".punch-navigation-trigger" class. You can show it with a lot of buttons in the page.
  $(".punch-navigation-trigger").on("click", function() {
    if (!$("#punch-navigation").hasClass("activated")) {
      $("body").showPunchNavigation();
    } else {
      $("body").hidePunchNavigation();
    }
    //Trigger mobile nav
    if ($(window).width() < 1120) {
      setTimeout(function() {
        $("#mobile-navigation").animate({ left: "0px" }, 400, "easeOutSine");
      }, 300);
      $("#mobile-navigation-closer").fadeIn();
    }
  });
  //Close the Punch navigation with press ESC.
  $(document).keyup(function(e) {
    if (e.keyCode === 27) {
      if ($("#punch-navigation").hasClass("activated")) {
        $("body").hidePunchNavigation();
      }
    }
  });
  //Close the Punch navigation before change the page.
  $("#punch-navigation .navblock a")
    .not(".nav-title, .nav-subtitle")
    .on("click", function() {
      var Exlink = this.getAttribute("href");
      // Close the navigation
      $("body").hidePunchNavigation();
      setTimeout(function() {
        document.location.href = Exlink;
      }, 1500);
      return false;
    });
  $("#punch-navigation a.nav-title").on("click", function() {
    return false;
  });
  //End punch navigation scripts

  //Search Form Fullscreen
  if ($(".fs-searchform").exists()) {
    var trigger = $(".search-form-trigger"),
      form = $(".fs-searchform");
    $(trigger).on("click touch", function(event) {
      $(form).addClass("active");
      setTimeout(function() {
        $(".fs-searchform input").focus();
      }, 900);
      return false;
    });
    $(".form-bg").on("click", function() {
      $(".fs-searchform").removeClass("active");
    });
    //Close the form with press ESC.
    $(document).keyup(function(e) {
      if (e.keyCode === 27) {
        $(".fs-searchform").removeClass("active");
      }
    });
    $(".fs-searchform a").on("click", function() {
      var Exlink = this.getAttribute("href");
      // Close the navigation
      $(".fs-searchform").removeClass("active");
      setTimeout(function() {
        document.location.href = Exlink;
      }, 500);
      return false;
    });
  }

  //*********************************************
  //  CONTACT FORM VALIDATE SCRITPS
  //*********************************************

  //Contact Form Settings
  var rnuma = Math.floor(Math.random() * 5);
  var rnumb = Math.floor(Math.random() * 5);
  var sum = rnuma + rnumb;
  $("#math").html(sum);
  $("#verify").attr("placeholder", rnuma + "+" + rnumb + "= ?");
  var validator = $("#contact_form, .quick_form, #newsletter_form");

  // Check for file size on advanced forms
  var maxSize = $(validator).attr("data-max-file-size"),
    fileSizeError = $(validator).attr("data-max-file-size-error");
  $.validator.addMethod(
    "filesize",
    function(value, element, param) {
      return this.optional(element) || element.files[0].size <= param;
    },
    $("<span id='max_size'>" + fileSizeError + "</<span>").appendTo(
      ".inputfile + label"
    )
  );

  // Validate Contact Form
  $(validator).each(function() {
    var sendBtn = $(this).find(":submit"),
      $this = $(this),
      timer = window.setTimeout(3500);
    // Classic Quadra Validate
    $(this).validate({
      ignore: ".ignore",
      rules: {
        verify: { equalTo: "#math" },
        hiddenRecaptcha: {
          required: function() {
            if (grecaptcha.getResponse() === "") {
              $(".g-recaptcha").addClass("error_warning");
              return true;
            } else {
              $(".g-recaptcha").removeClass("error_warning");
              return false;
            }
          }
        },
        userfile: {
          required: true,
          filesize: maxSize // Max 3mb
        }
      },
      onfocusout: false,
      showErrors: function(map, list) {
        this.currentElements.removeClass("error_warning");
        this.currentElements
          .closest(".border-effect")
          .removeClass("error_warning");
        $.each(list, function(index, error) {
          window.clearTimeout(timer);
          $(error.element).addClass("error_warning");
          $(error.element)
            .closest(".border-effect")
            .addClass("error_warning");
          $("div#error_message")
            .fadeIn(300)
            .clearQueue();
          $("div#error_message").on("click", function() {
            $(this).fadeOut("fast");
            window.clearTimeout(timer);
          });
          timer = window.setTimeout(function() {
            $("div#error_message").fadeOut("fast");
          }, 3500);
        });
      },
      submitHandler: function(form) {
        $(sendBtn)
          .not(".loading")
          .addClass("loading")
          .append("<span class='loader'></span>");
        $.ajax({
          url: form.action,
          type: form.method,
          data: new FormData($(form)[0]),
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            $("div#error_message").fadeOut("fast");
            $('#dynamic_text').html(data);
            $("div#submit_message").fadeIn("fast");
            $(validator)
              .find(".inputfile + label span")
              .empty();
            setTimeout(function() {
              $("div#submit_message").fadeOut("fast");
            }, 5000);
            $(sendBtn).removeClass("loading");
            $(validator).trigger("reset");
          }
        });
      }
    });
  });

  //*********************************************
  //  SUBSCRIBE FORMS
  //*********************************************

  // Subscribe Forms
  var $newsletterForm = $("form#newsletter_form"),
    sendBtn = $($newsletterForm).find("button");

  $($newsletterForm).validate({
    showErrors: function() {
      this.currentElements.removeClass("error_warning");
      this.currentElements
        .closest(".border-effect")
        .removeClass("error_warning");
    },
    submitHandler: function() {
      $(sendBtn)
        .not(".loading")
        .addClass("loading")
        .append("<span class='loader'></span>");
      $.ajax({
        url: $newsletterForm.action,
        type: $newsletterForm.method,
        data: $newsletterForm.serialize(),
        cache: false,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function() {
          $("div#error_message").removeClass("active");
          $("div#submit_message").addClass("active");
          setTimeout(function() {
            $("div#submit_message").removeClass("active");
          }, 5000);
          $(sendBtn).removeClass("loading");
          $($newsletterForm).trigger("reset");
        }
      });
    }
  });

  // Alerts with clicks
  $(".qdr-alert-trigger").each(function() {
    var self = $(this),
      target = $(self).data("target"),
      timer;
    $(self).on("click", function() {
      clearTimeout(timer);
      $(target)
        .fadeOut(0)
        .stop()
        .clearQueue();
      setTimeout(function() {
        $(target).fadeIn(300);
      }, 1);
      timer = setTimeout(function() {
        $(target).fadeOut(300);
      }, 3000);
    });
  });

  //Create border effect toggle for the input and textareas
  jQuery("span.border-effect").each(function() {
    var $this = $(this);
    $($this)
      .find("*")
      .on("blur", function() {
        $($this).removeClass("active");
      })
      .on("focus", function() {
        $($this).addClass("active");
      });
  });

  //*********************************************
  //  LIGHTBOXES
  //*********************************************
  //Lightbox Gallery Class for containers. All "a" links will work for lightbox with click.
  //Also you can add .no-lightbox claass for no-lightbox links.
  $.fn.callLightboxGallery = function() {
    $(".lightbox_gallery").lightGallery({
      selector: "a:not(.no-lightbox)",
      download: true,
      speed: 400,
      loop: true,
      controls: true,
      thumbWidth: 100,
      thumbContHeight: 100,
      thumbnail: true,
      thumbMargin: 8,
      share: true,
      cssEasing: "cubic-bezier(0.645, 0.045, 0.355, 1)",
      loadYoutubeThumbnail: true,
      youtubeThumbSize: "default",
      iframeMaxWidth: "75%",
      loadVimeoThumbnail: true,
      vimeoThumbSize: "thumbnail_medium",
      youtubePlayerParams: {
        modestbranding: 1,
        showinfo: 0,
        rel: 0,
        controls: 0
      },
      vimeoPlayerParams: { byline: 0, portrait: 0, color: "A90707" }
    });
    $(".lightbox_gallery:not(.no-lightbox)").addClass("lightboxed");
  };
  if ($(".lightbox_gallery").exists()) {
    $(window).callLightboxGallery();
  }

  //Only .lightbox_selected classes will work in .lightbox_selected container
  $.fn.callLightboxSelected = function() {
    $(".lightbox_selected").lightGallery({
      selector: "a.lightbox_item",
      download: true,
      speed: 500,
      loop: true,
      controls: true,
      thumbWidth: 100,
      thumbContHeight: 100,
      thumbMargin: 8,
      thumbnail: true,
      share: true,
      cssEasing: "cubic-bezier(0.645, 0.045, 0.355, 1)",
      loadYoutubeThumbnail: true,
      youtubeThumbSize: "default",
      loadVimeoThumbnail: true,
      iframeMaxWidth: "75%",
      vimeoThumbSize: "thumbnail_medium",
      youtubePlayerParams: {
        modestbranding: 1,
        showinfo: 0,
        rel: 0,
        controls: 0
      },
      vimeoPlayerParams: { byline: 0, portrait: 0, color: "A90707" }
    });
  };
  if ($(".lightbox_selected").exists()) {
    $(window).callLightboxSelected();
  }

  //You can add .lightbox classes to single elements
  $.fn.callLightbox = function() {
    $(".lightbox").lightGallery({
      selector: "this",
      download: true,
      thumbWidth: 100,
      thumbContHeight: 100,
      thumbnail: true,
      share: true,
      loadYoutubeThumbnail: true,
      youtubeThumbSize: "default",
      iframeMaxWidth: "75%",
      loadVimeoThumbnail: true,
      youtubePlayerParams: {
        modestbranding: 1,
        showinfo: 0,
        rel: 0,
        controls: 0
      },
      vimeoPlayerParams: { byline: 0, portrait: 0, color: "A90707" }
    });
  };
  if ($(".lightbox").exists()) {
    $(window).callLightbox();
  }

  //*********************************************
  //  SLIDERS
  //*********************************************

  //Slider for twin sections
  if ($(".slider-for").exists()) {
    $(".slider-for").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      touchThreshold: 150,
      fade: true,
      asNavFor: ".slider-nav"
    });
  }
  //Navigation to .slider-for
  if ($(".slider-nav").exists()) {
    $(".slider-nav").slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      asNavFor: ".slider-for",
      touchThreshold: 150,
      dots: false,
      arrows: false,
      centerMode: true,
      focusOnSelect: true
    });
  }
  if ($(".news-slider").exists()) {
    $(".news-slider").slick({
      dots: false,
      arrows: true,
      infinite: true,
      touchThreshold: 150,
      fade: true,
      slidesToShow: 1,
      prevArrow:
        '<button type="button" data-role="none" class="slick-prev qdr-hover" tabindex="0" role="button"></button>',
      nextArrow:
        '<button type="button" data-role="none" class="slick-next qdr-hover" tabindex="0" role="button"></button>',
      slidesToScroll: 1
    });
  }
  if ($(".background-slider").exists()) {
    $(".background-slider").slick({
      dots: false,
      arrows: false,
      infinite: true,
      autoplay: true,
      touchThreshold: 150,
      fade: true,
      slidesToShow: 1,
      slidesToScroll: 1
    });
    $(".slider-next-trigger").on("click", function() {
      $(".background-slider").slick("slickNext");
    });
    $(".slider-prev-trigger").on("click", function() {
      $(".background-slider").slick("slickPrev");
    });
  }
  //Image slider with dots and arrows - Usable within another slider
  if ($(".image-slider").exists()) {
    $(".image-slider")
      .slick({
        dots: true,
        arrows: true,
        infinite: true,
        fade: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        touchThreshold: 20,
        adaptiveHeight: true
      })
      .on("afterChange", function(event, slick) {
        $(".custom-slider").slick("slickSetOption", "swipe", true);
      });
  }
  //Custom slider
  if ($(".custom-slider").exists()) {
    $(".custom-slider").each(function() {
      var $this = $(this);
      $($this)
        .slick({
          //Default Options
          fade: false,
          dots: false,
          arrows: false,
          autoplay: false,
          autoplaySpeed: 3000,
          pauseOnHover: true,
          lazyLoad: "ondemand",
          infinite: true,
          rtl: false,
          edgeFriction: 0,
          easing: "linear",
          touchThreshold: 150,
          speed: 400,
          slidesToShow: 3,
          initialSlide: 0,
          draggable: false,
          adaptiveHeight: true,
          variableWidth: false,
          prevArrow:
            '<button type="button" data-role="none" class="slick-prev" tabindex="0" role="button"></button>',
          nextArrow:
            '<button type="button" data-role="none" class="slick-next" tabindex="0" role="button"></button>',
          centerMode: false,
          slidesToScroll: 1,
          setPosition: 1,
          swipe: true,
          touchMove: true,
          responsive: [
            {
              breakpoint: 992,
              settings: { slidesToShow: 2, slidesToScroll: 1 }
            },
            {
              breakpoint: 600,
              settings: { slidesToShow: 1, slidesToScroll: 1 }
            }
          ]
        })
        .on("afterChange", function(event, slick, currentSlide) {
          if ($($this).hasClass("hero-slider")) {
            var items = $(".hero-slider .animated"),
              current = $(".hero-slider .slick-current .animated"),
              nCurrent = $(
                ".hero-slider .slick-slide:not(.slick-current) .animated"
              );
            Waypoint.refreshAll();
            $(current).each(function() {
              var item = $(this),
                animation = item.data("animation"),
                animationDelay = item.data("animation-delay");
              setTimeout(function() {
                item.addClass(animation + " visibleme");
              }, animationDelay);
            });
            $(nCurrent).each(function() {
              var item = $(this),
                animation = item.data("animation");
              item.removeClass(animation + "visibleme");
            });
            $(".slick-current video").each(function() {
              this.play();
            });
            $(".slick-slide:not(.slick-current) video").each(function() {
              this.pause();
            });
            $($this)
              .find(".slick-slide.slick-current .slide-img .scale-timer")
              .addClass("scaling");
          }
        })
        .on("beforeChange", function(event, slick, currentSlide, nextSlide) {
          Waypoint.refreshAll();
          $(items).removeClass("visible");
          var nCurrent = $(
              ".hero-slider .slick-slide:not(.slick-current) .animated"
            ),
            items = $(".hero-slider .animated");
          $(nCurrent).each(function() {
            var item = $(this),
              animation = item.data("animation"),
              animationDelay = item.data("animation-delay");
            $(item).removeClass(animation + " visibleme");
          });
          $($this)
            .find(".slick-slide:not(slick-current) .slide-img .scale-timer")
            .removeClass("scaling");
        });
    });
    //Block drag the .custom-slider when sliding images.
    $(".image-slider, .image-slider-navs, .image-slider-dots").on(
      "touchstart touchmove touchend",
      function() {
        $(".custom-slider").slick("slickSetOption", "swipe", false);
      }
    );
    $(".custom-slider").on("touchstart touchmove touchend", function() {
      $(".custom-slider").slick("slickSetOption", "swipe", true);
    });

    $(".slick-slider.calculate-height .slick-track").addClass(
      "calculate-height"
    );
    $(window).resize(function() {
      $(".slick-slider.calculate-height .slick-track").addClass(
        "calculate-height"
      );
    });
  }

  //Hero slider Ready
  if ($(".hero-slider").exists()) {
    //Work for window load
    $(".hero-slider .slick-slide:not(.slick-current) .animated").removeClass(
      "visible"
    );
    $(".slick-slide.slick-current .slide-img .scale-timer").addClass("scaling");
    $(".hero-slider .slick-current .animated").each(function() {
      var item = $(this),
        animation = item.data("animation"),
        animationDelay = item.data("animation-delay");
      $(item).removeClass(animation);
      setTimeout(function() {
        item.addClass(animation + " visibleme");
      }, animationDelay);
    });
    //Next&Prev with external buttons
    $(".hero-slider-next").on("click", function() {
      $(".hero-slider").slick("slickNext");
    });
    $(".hero-slider-prev").on("click", function() {
      $(".hero-slider").slick("slickPrev");
    });
  }
  //Navigation to .slider-for
  if ($(".nav-to-custom-slider").exists()) {
    $(".nav-to-custom-slider").slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      asNavFor: ".custom-slider",
      dots: false,
      touchThreshold: 50,
      arrows: false,
      centerMode: false,
      focusOnSelect: true
    });
  }
  //Background color changer
  if ($("[data-background-color-selector]").exists()) {
    $("[data-background-color-selector]").each(function() {
      var $this = $(this),
        colorSource = $($this).attr("data-background-color-selector"),
        colorHome = $("#home").attr("data-background-color-selector");
      $this.waypoint(
        function(direction) {
          if (direction === "down") {
            $(".bg-changeable").css({ "background-color": "#" + colorSource });
            $(".changeable-border").css({ "border-color": "#" + colorSource });
          }
        },
        { offset: "60%" }
      );
      $this.waypoint(
        function(direction) {
          if (direction === "up") {
            $(".bg-changeable").css({ "background-color": "#" + colorSource });
            $(".changeable-border").css({ "border-color": "#" + colorSource });
          }
        },
        { offset: "-90%" }
      );
      $(window).on("scroll", function() {
        if ($(window).scrollTop() < 10) {
          $(".bg-changeable").css({ "background-color": "#" + colorHome });
          $(".changeable-border").css({ "border-color": "#" + colorHome });
        }
      });
    });
  }

  //Modal edition for slider
  $(".modal").each(function() {
    var $this = $(this),
      $slider = $(this).find(".slick-slider");
    $($this).on("show.bs.modal", function(e) {
      setTimeout(function() {
        $($slider).addClass("modal-active");
      }, 4000);
      if ($(window).width() > 992) {
        setTimeout(function() {
          $($slider).slick("refresh");
        }, 300);
      } else {
        setTimeout(function() {
          $($slider).resize();
        }, 400);
      }
    });
    $($this).on("hidden.bs.modal", function(e) {
      setTimeout(function() {
        $($slider).removeClass("modal-active");
      }, 400);
    });
  });

  //*********************************************
  // Refresh parallax effect, lightbox, icon navigation when click portfolio filters
  //*********************************************
  $(
    '.cbp-l-loadMore-button, [data-toggle]:not([data-toggle="popover"]), .cbp-filter-item, .cbp-l-loadMore-link'
  ).on("click", function() {
    setTimeout(function() {
      if (isParallaxBrowsers && mobile === false) {
        var s = skrollr.init({ forceHeight: false });
        s.refresh();
        $(".icon-navigation").addClass("slow");
      }
      Waypoint.refreshAll();
    }, 500);
    setTimeout(function() {
      $(".icon-navigation").removeClass("slow");
    }, 1400);
  });
  function detectWindowHeightChange(elm, callback) {
    var lastHeight = elm.clientHeight,
      newHeight;
    (function run() {
      newHeight = elm.clientHeight;
      if (lastHeight != newHeight) callback();
      lastHeight = newHeight;
      if (elm.onElementHeightChangeTimer)
        clearTimeout(elm.onElementHeightChangeTimer);
      elm.onElementHeightChangeTimer = setTimeout(run, 200);
    })();
  }
  detectWindowHeightChange(document.body, function() {
    if ($(".cbp-item:last-child").hasClass("cbp-item-loading")) {
      if ($(".lightbox_gallery").exists()) {
        $(".lightbox_gallery")
          .data("lightGallery")
          .destroy(true);
        $(window).callLightboxGallery();
      }
      if ($(".lightbox_selected").exists()) {
        $(".lightbox_selected")
          .data("lightGallery")
          .destroy(true);
        $(window).callLightboxSelected();
      }
      if ($(".lightbox").exists()) {
        $(".lightbox")
          .data("lightGallery")
          .destroy(true);
        $(window).callLightbox();
      }
    }
  });

  //*********************************************
  //  VIDEO COMPATIBILITY ON SLICK SLIDER
  //*********************************************

  //Slick slider video option
  $(".slick-slider").on("beforeChange", function(
    event,
    slick,
    currentSlide,
    nextSlide
  ) {
    var current = $(this).find(".slick-current iframe");
    setTimeout(function() {
      current.attr("src", current.attr("src"));
    }, 1000);
    var dataSettings = $(this).data("slider-options") || {};
  });

  //Calculate Items Width
  $.fn.calculateWidth = function() {
    $(".calculate-width").each(function() {
      var $this = $(this),
        tagCount = $(this)
          .find("> *")
          .not(".no-calculate").length,
        tags = $(this)
          .find("> *")
          .not(".no-calculate"),
        contWidth = $(this).width();
      $(this).addClass("clearfix");
      $(tags)
        .addClass("width-calculated")
        .css({ width: contWidth / tagCount + "px" });
    });
  };
  $("body").calculateWidth();

  //Quadra Interactive Packages Scripts
  if ($(".interactive-packages").exists()) {
    $(".interactive-packages .steps .step").each(function() {
      var itemNr = $(".step").index(this) + 1,
        $this = $(this),
        stepW = $this.width(),
        startWith = $(".interactive-packages .steps").attr("data-startWith");
      $(".selector").css({ right: stepW / 2 + "px" });
      $(".interactive-packages .package_title span.title_selector").text(
        $(startWith).data("name")
      );
      //Get texts
      $(
        ".interactive-packages .package-boxes .box1 span.box-title-selector"
      ).text($(startWith).data("box1"));
      $(
        ".interactive-packages .package-boxes .box2 span.box-title-selector"
      ).text($(startWith).data("box2"));
      $(
        ".interactive-packages .package-boxes .box3 span.box-title-selector"
      ).text($(startWith).data("box3"));
      $(
        ".interactive-packages .package-boxes .box4 span.box-title-selector"
      ).text($(startWith).data("box4"));
      //Get elements when click
      $this.on("click", function() {
        var stepWidth = $(".steps .step").width();
        $(".interactive_bar").css({ width: itemNr * stepWidth + "px" });
        $(".interactive-packages .title").removeClass("active");
        $(".interactive-packages .title:nth-child(" + itemNr + ")").addClass(
          "active"
        );
        $(".interactive-packages .package_title span.title_selector").text(
          $this.data("name")
        );
        $(
          ".interactive-packages .package-boxes .box1 span.box-title-selector"
        ).text($this.data("box1"));
        $(
          ".interactive-packages .package-boxes .box2 span.box-title-selector"
        ).text($this.data("box2"));
        $(
          ".interactive-packages .package-boxes .box3 span.box-title-selector"
        ).text($this.data("box3"));
        $(
          ".interactive-packages .package-boxes .box4 span.box-title-selector"
        ).text($this.data("box4"));
      });
    });
  }

  //*********************************************
  //  WINDOW RESIZE FUNCTION
  //*********************************************

  // Quadra Functions when window resizing.
  $(window).resize(function() {
    //Vertical Center Function
    $("body").verticalPosition();
    //Vertical Center Function
    $("body").makeFullscreen();
    //Make Fullscreen
    $(".bodywidth").width($(window).width());
    //Calculate Width
    $("body").calculateWidth();
    //Get device width
    $("body").getDeviceWidth();
    //Animated Items
    $("body").animatedItems();
    //Calculate Height
    $(".calculate-height").calculateHeight();
    //Make Min Height Full
    $(".mnh-full").css({ "min-height": $(window).height() + "px" });
    //Make Height Full
    $(".height-full").css({ height: $(window).height() + "px" });
    //Mega menu position calculating
    $(".to-center").each(function() {
      var menuW = $(this).outerWidth();
      if ($(window).width() > 1200) {
        $(this).css({ left: -menuW / 2 + 40 + "px" });
        $(".mega-menu").removeClass("mini-screen");
      }
      if ($(window).width() < 1200) {
        $(this).css({ left: -menuW / 3 + 150 + "px" });
        $(".mega-menu").addClass("mini-screen");
      }
    });
    if ($(window).width() > 1120) {
      $("#pagetop").each(function() {
        var itemH = $(this).outerHeight(),
          bigNav = $("#navigation.modern").not(".sticky, .static");
        bigNav.addClass("pagetopped").css("margin-top", itemH + "px");
      });
    } else {
      $("#navigation.modern")
        .not(".sticky, .static")
        .css({ "margin-top": 0 });
    }
    //Change background images for large and small screens
    if ($(window).width() < 769) {
      $("[data-mobile-background]").each(function() {
        var bgSRC = $(this).data("mobile-background");
        $(this).css({
          "background-image": "url(" + bgSRC + ")",
          "background-size": "cover !important"
        });
      });
    } else {
      $("[data-background]").each(function() {
        var bgSRC = $(this).data("background");
        $(this)
          .removeClass("bg-mobiled")
          .css({ "background-image": "url(" + bgSRC + ")" });
      });
    }
    //do something else
  });
  //Close the page loader
  var $pageloader = $(".page-loader");
  // setTimeout(function() {
  //   $pageloader.addClass("page-loader--fading-out");
  // }, 100);
    // $pageloader
    //   .removeClass("page-loader--fading-out")
    //   .addClass("page-loader--hidden");
  // setTimeout(function() {
  // }, 600);

  //Before window unload
  $(
    "a:not(a[href^='#']):not([href='#']):not(.no-scroll):not(.lightbox):not(.lightbox_item):not([data-slide]):not([data-toggle]):not([target]):not(.cbp-lightbox):not(.cbp-singlePage):not(.cbp-l-loadMore-link):not(.more-post-button):not([rel]):not(.nl-field-toggle)"
  ).on("click touch", function() {
    var Exlink = this.getAttribute("href"),
      $elem = $(this);
    if (/\.(?:jpg|jpeg|gif|png|mp3|mp4)$/i.test($(this).attr("href"))) {
    } else {
      if ($elem.parents(".lightbox_gallery, #punch-navigation").length) {
      } else {
        $pageloader
          .removeClass("page-loader--hidden")
          .addClass("page-loader--fading-in hide-anim");
        setTimeout(function() {
          document.location.href = Exlink;
        }, 400);
        if (mobile === true || isSafari || isFirefox) {
          setTimeout(function() {
            $pageloader.hide();
          }, 1200);
        }
        return false;
      }
    }
  });

  //Animated Items for desktops
  $.fn.animatedItems = function() {
    if ($(window).width() > 1024 && mobile === false) {
      $(".animated")
        .not(".hero-slider .animated")
        .each(function() {
          var item = $(this),
            animation = item.data("animation");
          $(item).waypoint(
            function() {
              if (!item.hasClass("visible")) {
                var animationDelay = item.data("animation-delay");
                if (animationDelay) {
                  setTimeout(function() {
                    item.addClass(animation + " visible");
                  }, animationDelay);
                } else {
                  item.addClass(animation + " visible");
                }
              }
            },
            { offset: "90%" }
          );
        });
    } else {
      $(".animated")
        .not(".hero-slider .animated")
        .addClass("visible");
    }
  };
  $("body").animatedItems();

  //Animated Backgrounds for desktops
  $(".bg-animated, .bg-animated-reverse, .bg-animated-vertical").each(
    function() {
      $("<div class='bg-animator'></div>").appendTo(this);
    }
  );

  //Same Height Items
  $.fn.calculateHeight = function() {
    $(".calculate-height").each(function() {
      var maxHeight = -1;
      $(this)
        .find(">*")
        .css({ height: "auto" })
        .each(function() {
          if ($(this).outerHeight() > maxHeight) {
            maxHeight = $(this).outerHeight();
          }
        });
      $(this)
        .find(">*")
        .outerHeight(maxHeight);
    });
  };
  $(".calculate-height").calculateHeight();

  //Sticky Items
  if ($(".sticky-item").exists()) {
    $(".sticky-item").each(function() {
      var spacing = $(this).data("top-spacing");
      $(this).sticky({ topSpacing: spacing });
    });
  }

  //Sticky elements to containers
  if ($(".sticky-container").exists()) {
    $(".sticky-container").each(function() {
      //Variations
      var $stick = $(this),
        $width = $($stick).width(),
        $stickTop = $($stick).offset().top,
        $container = $($stick).data("fix-container"),
        $contStart = $($container).offset().top,
        $contEnd = $($container).height() - $($stick).height(),
        $spacing = $($stick).data("top-spacing"),
        $endValue =
          $contStart + $($container).outerHeight() - $($stick).height();
      //Screen Positions
      $(window).on("scroll", function() {
        $.fn.makeSticky = function() {
          var now = $(window).scrollTop() + $spacing;
          if (now < $stickTop) {
            $($stick)
              .css({
                top: "0px",
                position: "absolute",
                "max-width": $width + "px"
              })
              .addClass("before-cont")
              .removeClass("on-cont after-cont");
          }
          if (now > $stickTop) {
            $($stick)
              .css({
                top: $spacing + "px",
                position: "fixed",
                "max-width": $width + "px"
              })
              .addClass("on-cont")
              .removeClass("before-cont after-cont");
          }
          if (now > $endValue) {
            $($stick)
              .css({
                top: $contEnd + "px",
                position: "absolute",
                "max-width": $width + "px"
              })
              .addClass("after-cont")
              .removeClass("before-cont on-cont");
          }
        };
        if ($($container).has($stick) && $(window).width() > 1000) {
          $($stick).makeSticky();
        }
      });
    });
  }

  //Call Ajax
  if ($("[data-ajax-load]").exists()) {
    $("[data-ajax-load]").each(function() {
      var value = $(this).data("ajax-load"),
        $this = $(this);
      $(this)
        .empty()
        .load(value, function() {
          if ($($this).hasClass("ajax-slider")) {
            var $sldr = $(this).find(".custom-slider");
            $sldr.slick();
          }
        });
    });
  }

  //*********************************************
}); //  END WINDOW LOAD FUNCTION
//*********************************************

//Get Background Image
$("[data-background]")
  .not(".bg-mobiled")
  .each(function() {
    var bgSRC = $(this).data("background");
    var self = $(this);
    $(this).css({ "background-image": "url(" + bgSRC + ")" });
    $(self).ready(function() {
      setTimeout(function() {
        $(self).addClass("loaded");
      }, 50);
    });
  });

//Side menu trigger for body
$("body")
  .has("#navigation.side-menu.left")
  .addClass("left-side-menu-active");
$("body")
  .has("#navigation.side-menu.right")
  .addClass("right-side-menu-active");
$("body")
  .has("#navigation.mini-side-menu.left")
  .addClass("left-mini-side-menu-active");
$("body")
  .has("#navigation.mini-side-menu.right")
  .addClass("right-mini-side-menu-active");

// Parallax backgrounds
$(".bg-parallax").each(function() {
  var $this = $(this);
  $($this)
    .closest("section, .parallax-container")
    .addClass("o-hidden relative z-index-1");
});

//Make Fullscreen
$.fn.makeFullscreen = function() {
  if (
    $("body").has("#navigation.side-menu") ||
    $("body").has("#mini-side-menu")
  ) {
    $(".fullscreen")
      .width($("#content").width())
      .height($(window).height());
  } else {
    $(".fullscreen")
      .width($(window).width())
      .height($(window).height());
  }
};
$("body").makeFullscreen();

//Make Bodywidth
$(".bodywidth").width($(window).width());
//Make Min Height Full
$(".mnh-full").css({ "min-height": $(window).height() + "px" });
//Make Height Full
$(".height-full").css({ height: $(window).height() + "px" });
//Count To
$.fn.countTo = function(options) {
  // merge the default plugin settings with the custom options
  options = $.extend({}, $.fn.countTo.defaults, options || {});

  // how many times to update the value, and how much to increment the value on each update
  var loops = Math.ceil(options.speed / options.refreshInterval),
    increment = (options.to - options.from) / loops;

  return $(this).each(function() {
    var _this = this,
      loopCount = 0,
      value = options.from,
      interval = setInterval(updateTimer, options.refreshInterval);

    function updateTimer() {
      value += increment;
      loopCount++;
      $(_this).html(
        value.toFixed(options.decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      );

      if (typeof options.onUpdate === "function") {
        options.onUpdate.call(_this, value);
      }

      if (loopCount >= loops) {
        clearInterval(interval);
        value = options.to;

        if (typeof options.onComplete === "function") {
          options.onComplete.call(_this, value);
        }
      }
    }
  });
};
$.fn.countTo.defaults = {
  from: 0, // the number the element should start at
  to: 100, // the number the element should end at
  speed: 1000, // how long it should take to count between the target numbers
  refreshInterval: 100, // how often the element should be updated
  decimals: 0, // the number of decimal places to show
  onUpdate: null, // callback method for every time the element is updated,
  onComplete: null // callback method for when the element finishes updating
};
// Count options
$(".fact").each(function() {
  $(this).waypoint(
    function() {
      var dataSource = $(this.element).attr("data-source");
      //Count Factors Options
      $(this.element)
        .find(".factor")
        .countTo({
          from: 0,
          to: dataSource,
          speed: 2000,
          refreshInterval: 25
        });
      this.destroy();
    },
    { offset: "100%" }
  );
});
// Digits for numbers (.digits class).
$.fn.digits = function() {
  return this.each(function() {
    $(this).text(
      $(this)
        .text()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    );
  });
};
$(".digits").digits();

if ($(".countdown").length > 0) {
  $(".countdown").each(function() {
    var $this = $(this),
      Dtimer = $(this).attr("data-time");
    //Countdowns
    CountDownTimer(Dtimer);
    //Countdown Scripts
    function CountDownTimer(dt) {
      var end = new Date(dt),
        _second = 1000,
        _minute = _second * 60,
        _hour = _minute * 60,
        _day = _hour * 24,
        _year = _day * 365,
        timer,
        cls = $($this);
      function showRemaining() {
        var now = new Date();
        var distance = end - now;
        //Finished Timer
        if (distance < 0) {
          clearInterval(timer);
          $($this).html("EXPIRED");
          return;
        }
        //Math for times
        var years = Math.floor(distance / _year),
          days = Math.floor((distance % _year) / _day),
          hours = Math.floor((distance % _day) / _hour),
          minutes = Math.floor((distance % _hour) / _minute),
          seconds = Math.floor((distance % _minute) / _second);

        if (String(hours).length < 2) {
          hours = 0 + String(hours);
        }
        if (String(minutes).length < 2) {
          minutes = 0 + String(minutes);
        }
        if (String(seconds).length < 2) {
          seconds = 0 + String(seconds);
        }

        var datestr =
          '<div class="countdowns"><div class="year"><span class="time">' +
          years +
          "</span>" +
          '<span class="datename"> years</span>' +
          '</div><span class="dot">:</span>' +
          '<div><span class="time">' +
          days +
          "</span>" +
          '<span class="datename"> days </span>' +
          '</div><span class="dot">:</span>' +
          '<div><span class="time">' +
          hours +
          "</span>" +
          '<span class="datename"> hours </span>' +
          '</div><span class="dot">:</span>' +
          '<div><span class="time">' +
          minutes +
          "</span>" +
          '<span class="datename"> minutes </span>' +
          '</div><span class="dot">:</span>' +
          '<div><span class="time">' +
          seconds +
          "</span>" +
          '<span class="datename"> seconds </span></div></div>';
        $($this).html(datestr);
        if (years < 1) {
          $($this)
            .find(".year, .year + .dot")
            .hide();
        }
      }
      showRemaining(), (timer = setInterval(showRemaining, 1000));
    }
  });
}
