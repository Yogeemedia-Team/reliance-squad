// Custom JS
var n = jQuery.noConflict();
function isotopAutoSet() {
    "use strict";
    // Testimonials
    jQuery(".testimonial-carousel").each(function() {
        "use strict";
            n(".testimonial-carousel .elementor-widget-wrap").addClass("owl-carousel");
            n(".testimonial-carousel .elementor-widget-wrap").owlCarousel({
                navigation: false,
                pagination: true,
                autoplay:3000,
                items: 1,
                itemsLarge: [1400, 1],
                itemsDesktop: [1200, 1],
                itemsDesktopSmall: [979, 1],
                itemsTablet: [600, 1],
                itemsMobile: [479, 1]
            })
    });	
    // Blog      
    jQuery(".blog-carousel").each(function() {
        "use strict";
        if (n(this).attr("id")) {
            var e = n(this).attr("id").replace("_blog_carousel", "");
            n(".blog-carousel").addClass("owl-carousel");
            n(".blog-carousel").owlCarousel({
                navigation: true,
                pagination: false,
                items: e,
                itemsLarge: [1400, e],
                itemsDesktop: [1200, e],
                itemsDesktopSmall: [979, 2],
                itemsTablet: [600, 2],
                itemsMobile: [479, 1]
            })
        }
    });
    // Woo categories
    jQuery(".category-carousel").each(function() {
        "use strict";
        if (n(this).attr("id")) {
            var e = n(this).attr("id").replace("_category_carousel", "");
            n(".category-carousel").addClass("owl-carousel");
            n(".category-carousel").owlCarousel({
                navigation: true,
                pagination: false,
                items: e,
                itemsLarge: [1400, e],
                itemsDesktop: [1200, e],
                itemsDesktopSmall: [979, 3],
                itemsTablet: [640, 2],
                itemsMobile: [479, 1]
            })
        }
    });

   // Products
    jQuery(".woo-carousel").each(function() {
        "use strict";
        if (n(this).attr("id")) {
            var e = n(this).attr("id").replace("_woo_carousel", "");
            var t = n(this).find("ul.products .product").length;
            if (t > e) {
                n(this).find("ul.products").addClass("owl-carousel");
                n(this).find("ul.products").owlCarousel({
                    navigation: true,
                    pagination: false,
                    afterAction: function(el){
                        //remove class active
                        this
                        .$owlItems
                        .removeClass('first active')
                        let a = 1;
                        //add class active
                        this
                        .$owlItems //owl internal $ object containing items
                        .eq(this.currentItem)
                        .addClass('first active')  
                        
                        //remove class active
                        this
                        .$owlItems
                        .removeClass('last active')
                        let b = 1;
                        let z = e -b;
                        //add class active
                        this
                        .$owlItems //owl internal $ object containing items
                        .eq(this.currentItem + z)
                        .addClass('last active')     
                    },
                    items: e,
                    itemsLarge: [1400, 5],
                    itemsDesktop: [1250, 4],
                    itemsDesktopSmall: [979, 3],
                    itemsTablet: [640, 2],
                    itemsMobile: [478, 1]
                })
            }
        }
    });

    //single-product-carousel
    function singleproductcarousel() {
        "use strict";
        jQuery('.product .flex-control-thumbs').addClass('owl-carousel');
        jQuery(".product .flex-control-thumbs").owlCarousel({
            navigation: true,
            pagination: false,
            items: 4,
            itemsDesktop: [1299, 3],
            itemsDesktopSmall: [991, 3],
            itemsTablet: [600, 2],
            itemsMobile: [320, 1]
        });
    }
    jQuery(document).ready(function() {  "use strict";  singleproductcarousel() });
    jQuery(window).load(function() {  "use strict";	singleproductcarousel() });
    jQuery(window).resize(function() {  "use strict";singleproductcarousel()}); 
}
jQuery(window).on('load',function() {  "use strict";  isotopAutoSet()});
jQuery(window).resize(function() { "use strict"; isotopAutoSet()});

jQuery(window).on('load', function() {
    "use strict";
    var $height = 0 ;
    jQuery(".product-action-wrap").each(function(){
   if((jQuery(this).height())>$height){
    $height = jQuery(this).height();
    }
    });
    jQuery("ul.products.woo-archive-action-on-hover .woo-archive-outer").each(function(){
    jQuery(this).css("margin-bottom",-$height - 6);
    jQuery(this).css("padding-bottom",$height + 6);
	jQuery("ul.align-buttons-bottom .product-action-wrap").css("bottom", -$height - 6);
    });

    jQuery('.thebase-show-sidebar-btn').on("click",function() { 
        jQuery(".primary-sidebar").toggleClass("active");
        jQuery(this).toggleClass("active");
    });
    jQuery('.thebase-hide-sidebar-btn .thebase-svg-iconset').on("click",function() { 
        jQuery(".primary-sidebar").removeClass("active");
        jQuery('.thebase-show-sidebar-btn').removeClass("active");
    });
    

});
jQuery('.widget_block').on("click",function() {
    jQuery('.product-categories').slideToggle("slow");
});
// zoom Gallery
function singleproductcarousel() {
    "use strict";
    jQuery('.product .flex-control-thumbs').addClass('owl-carousel');
    jQuery(".product .flex-control-thumbs").owlCarousel({
        navigation: true,
        pagination: false,
        items: 4,
        itemsDesktop: [1299, 3],
        itemsDesktopSmall: [991, 3],
        itemsTablet: [600, 2],
        itemsMobile: [320, 1]
    });
}
jQuery(window).on('load',function() {  "use strict";singleproductcarousel() });
jQuery(window).resize(function() {  "use strict";singleproductcarousel()});
jQuery(document).ready(function() {  "use strict";singleproductcarousel()});

jQuery(document).ready(function(){ 
    jQuery('#instafeed').owlCarousel({
        items: 3, 
        autoPlay: true,
        singleItem: false,
        navigation: true,
        navigationText: ['<i class="prev fa fa-arrow-left"></i>', '<i class="next fa fa-arrow-right"></i>'],
        pagination:false,
        itemsDesktop: [1500, 5],
        itemsDesktopSmall: [1200, 4],
        itemsTablet: [991, 3],
        itemsMobile: [767, 2]
    });
});

// JS toggle for sidebar and footer
function SidebarFooterToggle() {
    "use strict";
    jQuery('footer .widget h3,footer .widget .widget-title ,footer .woocommerce-shipping-calculator .shipping-calculator-button').parent().addClass('toggled-off');
    jQuery('footer .widget h3,footer .widget .widget-title ,footer .woocommerce-shipping-calculator .shipping-calculator-button').on("click", function() {
        if (jQuery(this).parent().hasClass('toggled-on')) {
            jQuery(this).parent().removeClass('toggled-on');
            jQuery(this).parent().addClass('toggled-off');
        } else {
            jQuery(this).parent().addClass('toggled-on');
            jQuery(this).parent().removeClass('toggled-off');
        }
        return (false);
    });
}
jQuery(document).ready(function() {
    "use strict";
    SidebarFooterToggle()
});
// // JS for adding treeview in navigationMenu sidebar product category
// function leftCatMenu() {
//     "use strict";
//     jQuery('.primary-sidebar .wc-block-product-categories-list-item').addClass('treeview-list');
//     jQuery(".primary-sidebar .wc-block-product-categories-list-item.treeview-list").treeview({
//         animated: "slow",
//         collapsed: true,
//         unique: true
//     });
//     jQuery('.treeview-list a.active').parent().removeClass('expandable');
//     jQuery('.treeview-list a.active').parent().addClass('collapsable');
//     jQuery('.treeview-list .collapsable ul').css('display', 'block');
// }
// jQuery(document).ready(function() {
//     "use strict";
//     leftCatMenu()
// });

// jQuery(document).ready(function() { "use strict";
//     jQuery(".wc-block-product-categories-list ul").addClass("toggle-block");
//     jQuery(".wc-block-product-categories-list-item").click(function() { 
//         jQuery(".wc-block-product-categories-list-item ul.wc-block-product-categories-list").slideToggle("slow");
//    });
// });
// jQuery(".wc-block-product-categories-list").addClass('sidebar-category-inner');  
// // zoom Gallery
// function archivegallery() {
//     "use strict";
//     jQuery('.archive-gallery-thumb').addClass('owl-carousel');
//     jQuery(".archive-gallery-thumb").owlCarousel({
//         navigation: false,
//         pagination: false,
//         items: 3,
//         itemsDesktop: [1299, 3],
//         itemsDesktopSmall: [991, 3],
//         itemsTablet: [600, 2],
//         itemsMobile: [320, 1],
//         loop:true,
//     });
// }
// owl.on('translated.owl.carousel', function(event) {

//     var now_src = $('.owl-carousel').find('.owl-item.active img').attr('src');
//    $('.archive-gallery-thumb').attr('src', now_src);
// })
// jQuery(window).on('load',function() {  "use strict";archivegallery() });
// jQuery(window).resize(function() {  "use strict";archivegallery()});



