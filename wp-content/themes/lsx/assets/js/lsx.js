var lsx=Object.create(null);!function(e,o,s,t){"use strict";var n=e(s),i=e(o),l=o.innerHeight||s.documentElement.clientHeight||s.body.clientHeight,a=o.innerWidth||s.documentElement.clientWidth||s.body.clientWidth;lsx.add_class_browser_to_html=function(){if("undefined"!=typeof platform){var o="chrome";null!==platform.name&&(o=platform.name.toLowerCase());var s="69";null!==platform.version&&(s=platform.version.toLowerCase()),e("html").addClass(o).addClass(s)}},lsx.add_class_sidebar_to_body=function(){e("#secondary").length>0&&e("body").addClass("has-sidebar")},lsx.add_class_bootstrap_to_table=function(){var o=e("table#wp-calendar");o.length>0&&o.addClass("table")},lsx.navbar_toggle_handler=function(){e(".navbar-toggle").parent().on("click",function(){var o=e(this);o.toggleClass("open")})},lsx.fix_bootstrap_menus_dropdown=function(){e(".navbar-nav .dropdown, #top-menu .dropdown").on("show.bs.dropdown",function(){a<1200&&(e(this).siblings(".open").removeClass("open").find("a.dropdown-toggle").attr("data-toggle","dropdown"),e(this).find("a.dropdown-toggle").removeAttr("data-toggle"))}),a>1199&&e(".navbar-nav li.dropdown a, #top-menu li.dropdown a").each(function(){e(this).removeClass("dropdown-toggle"),e(this).removeAttr("data-toggle")}),i.resize(function(){a>1199?e(".navbar-nav li.dropdown a, #top-menu li.dropdown a").each(function(){e(this).removeClass("dropdown-toggle"),e(this).removeAttr("data-toggle")}):e(".navbar-nav li.dropdown a, #top-menu li.dropdown a").each(function(){e(this).addClass("dropdown-toggle"),e(this).attr("data-toggle","dropdown")})})},lsx.replace_wc_classnames=function(){e(".wc-tabs").removeClass("wc-tabs").addClass("nav-tabs"),e(".tabs").removeClass("tabs").addClass("nav wc-tabs")},lsx.fix_bootstrap_menus_dropdown_click=function(){a<1200&&(e(".navbar-nav .dropdown .dropdown > a, #top-menu .dropdown .dropdown > a").on("click",function(o){e(this).parent().hasClass("open")||(e(this).parent().addClass("open"),e(this).next(".dropdown-menu").dropdown("toggle"),o.stopPropagation(),o.preventDefault())}),e(".navbar-nav .dropdown .dropdown .dropdown-menu a, #top-menu .dropdown .dropdown > a").on("click",function(e){s.location.href=this.href}))},lsx.fix_lazyload_envira_gallery=function(){e(".lazyload, .lazyloaded").length>0&&"object"==typeof envira_isotopes&&i.scroll(function(){e(".envira-gallery-wrap").each(function(){var o=e(this).attr("id");o=o.replace("envira-gallery-wrap-",""),"object"==typeof envira_isotopes[o]&&envira_isotopes[o].enviratope("layout")})})},lsx.set_main_menu_as_fixed=function(){var o=!1;a>1199&&e("body").hasClass("top-menu-fixed")&&n.on("scroll",function(s){!1===o&&(e(lsx_params.stickyMenuSelector).scrollToFixed({marginTop:function(){var o=e("#wpadminbar");return o.length>0?o.outerHeight():0},minWidth:768,preFixed:function(){e(this).addClass("scrolled")},preUnfixed:function(){e(this).removeClass("scrolled")}}),o=!0)})},lsx.set_search_form_effect_mobile=function(){n.on("click","header.navbar #searchform button.search-submit",function(o){if(a<1200){o.preventDefault();var s=e(this).closest("form");s.hasClass("hover")?s.submit():(s.addClass("hover"),s.find(".search-field").focus())}}),n.on("blur","header.navbar #searchform .search-field",function(o){if(a<1200){var s=e(this).closest("form");s.removeClass("hover")}})},lsx.search_form_prevent_empty_submissions=function(){n.on("submit","#searchform",function(o){""===e(this).find('input[name="s"]').val()&&o.preventDefault()}),n.on("blur","header.navbar #searchform .search-field",function(o){if(a<1200){var s=e(this).closest("form");s.removeClass("hover")}})},lsx.build_slider_lightbox=function(){e("body:not(.single-tour-operator) .gallery").slickLightbox({caption:function(o,s){return e(o).find("img").attr("alt")}})},lsx.init_wc_slider=function(){var o=e(".lsx-woocommerce-slider");o.each(function(o,s){var t=e(this),n=4,i=4,l=3,a=3,r=1,c=1;t.find(".lsx-woocommerce-review-slot").length>0&&(n=2,i=2,l=2,a=2),t.closest("#secondary").length>0&&(n=1,i=1,l=1,a=1),t.on("init",function(e,o){o.options.arrows&&o.slideCount>o.options.slidesToShow&&t.addClass("slick-has-arrows")}),t.on("setPosition",function(e,o){o.options.arrows?o.slideCount>o.options.slidesToShow&&t.addClass("slick-has-arrows"):t.removeClass("slick-has-arrows")}),t.slick({draggable:!1,infinite:!0,swipe:!1,cssEase:"ease-out",dots:!0,slidesToShow:n,slidesToScroll:i,responsive:[{breakpoint:992,settings:{slidesToShow:l,slidesToScroll:a,draggable:!0,arrows:!1,swipe:!0}},{breakpoint:768,settings:{slidesToShow:r,slidesToScroll:c,draggable:!0,arrows:!1,swipe:!0}}]})}),e('a[href="#tab-bundled_products"]').length>0&&n.on("click",'a[href="#tab-bundled_products"]',function(o){e("#tab-bundled_products .lsx-woocommerce-slider").slick("setPosition")})},lsx.remove_gallery_img_width_height=function(){e(".gallery-size-full img").each(function(){var o=e(this);o.removeAttr("height"),o.removeAttr("width")})},lsx.do_scroll=function(o){var s=o.href.replace(/^[^#]*(#.+$)/gi,"$1"),t=e(s),n=parseInt(t.offset().top),i=-100;e("html, body").animate({scrollTop:n+i},800)},lsx.fix_wc_elements=function(o){e(".woocommerce-MyAccount-content .api-manager-changelog, .woocommerce-MyAccount-content .api-manager-download").each(function(){var o=e(this);o.children("br:first-child").remove(),o.children("hr:first-child").remove(),o.children("hr:last-child").remove(),o.children("br:last-child").remove()}),e(".woocommerce-form__label-for-checkbox.checkbox").removeClass("checkbox"),e(s.body).on("updated_checkout",function(){e(".woocommerce-form__label-for-checkbox.checkbox").removeClass("checkbox")})},lsx.fix_caldera_form_modal_title=function(){e("[data-remodal-id]").each(function(){var o=e(this),s=e('[data-remodal-target="'+o.attr("id")+'"]'),t=s.text();o.find('[role="field"]').first().before("<div><h4>"+t+"</h4></div>")})},lsx.wc_footer_bar_toggle_handler=function(){e(".lsx-wc-footer-bar-link-toogle").on("click",function(o){o.preventDefault(),e(".lsx-wc-footer-bar-form").slideToggle(),e(".lsx-wc-footer-bar").toggleClass("lsx-wc-footer-bar-search-on")})},lsx.wc_fix_messages_visual=function(){e(".woocommerce-message,.woocommerce-info,.woocommerce-error,.woocommerce-noreviews,.woocommerce_message,.woocommerce_info,.woocommerce_error,.woocommerce_noreviews,p.no-comments,.stock,.woocommerce-password-strength").each(function(){var o=e(this);0!==o.find(".button").length&&(o.wrapInner('<div class="lsx-woocommerce-message-text"></div>'),o.addClass("lsx-woocommerce-message-wrap"),o.find(".button").appendTo(o))})},lsx.wc_fix_subscribe_to_replies_checkbox=function(){e('input[name="subscribe_to_replies"]').removeClass("form-control")},lsx.wc_add_quick_view_close_button=function(){e("body").on("quick-view-displayed",function(o){0===e(".pp_content_container").children(".close").length&&e(".pp_content_container").prepend('<button type="button" class="close">&times;</button>')}),n.on("click",".pp_content_container .close",function(o){e.prettyPhoto.close()})},lsx.wc_fix_subscriptions_empty_message=function(){""===e(".first-payment-date").text()&&e(".first-payment-date").remove()},lsx.sensei_courses_empty_thumbnail=function(){e(".course-thumbnail").each(function(){e.trim(e(this).html()).length||e(this).addClass("course-thumbnail-empty")})},lsx.sensei_course_participants_widget_more=function(){e("body").hasClass("sensei")&&(e(".sensei-course-participant").each(function(){e(this).hasClass("show")&&(e(this).addClass("sensei-show"),e(this).removeClass("show")),e(this).hasClass("hide")&&(e(this).addClass("sensei-hide"),e(this).removeClass("hide"))}),e(".sensei-view-all-participants a").on("click",function(){e(this).hasClass("clicked")?e(this).removeClass("clicked"):e(this).addClass("clicked"),e(".sensei-course-participant.sensei-hide").each(function(){e(this).hasClass("sensei-clicked")?e(this).removeClass("sensei-clicked"):e(this).addClass("sensei-clicked")})}))},lsx.woocommerce_filters_mobile=function(){e("body").hasClass("woocommerce-js")&&e(".lsx-wc-filter-toggle").on("click",function(){e(this).toggleClass("lsx-wc-filter-toggle-open"),e(this).hasClass("lsx-wc-filter-toggle-open")?(e('.lsx-wc-filter-block div[class^="wp-block-woocommerce-"][class$="-filter"]').each(function(){e(this).attr("id","lsx-wc-filter-child-open")}),e(".lsx-wc-filter-block .wp-block-woocommerce-product-search").each(function(){e(this).attr("id","lsx-wc-filter-child-open")})):(e('.lsx-wc-filter-block div[class^="wp-block-woocommerce-"][class$="-filter"]').each(function(){e(this).attr("id","lsx-wc-filter-child-close")}),e(".lsx-wc-filter-block .wp-block-woocommerce-product-search").each(function(){e(this).attr("id","lsx-wc-filter-child-close")}))})},i.resize(function(){l=o.innerHeight||s.documentElement.clientHeight||s.body.clientHeight,a=o.innerWidth||s.documentElement.clientWidth||s.body.clientWidth}),n.ready(function(){lsx.navbar_toggle_handler(),lsx.add_class_browser_to_html(),lsx.add_class_sidebar_to_body(),lsx.add_class_bootstrap_to_table(),lsx.set_main_menu_as_fixed(),lsx.search_form_prevent_empty_submissions(),lsx.remove_gallery_img_width_height(),lsx.replace_wc_classnames(),lsx.init_wc_slider(),lsx.fix_wc_elements(),lsx.fix_caldera_form_modal_title(),lsx.wc_footer_bar_toggle_handler(),lsx.wc_fix_messages_visual(),lsx.wc_fix_subscribe_to_replies_checkbox(),lsx.wc_add_quick_view_close_button(),lsx.wc_fix_subscriptions_empty_message(),lsx.sensei_courses_empty_thumbnail(),lsx.sensei_course_participants_widget_more(),lsx.woocommerce_filters_mobile()}),i.load(function(){lsx.fix_bootstrap_menus_dropdown(),lsx.fix_bootstrap_menus_dropdown_click(),lsx.fix_lazyload_envira_gallery(),lsx.set_search_form_effect_mobile(),lsx.build_slider_lightbox(),e("body.preloader-content-enable").addClass("html-loaded")})}(jQuery,window,document);