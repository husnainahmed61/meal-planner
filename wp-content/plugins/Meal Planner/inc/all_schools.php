<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schools";
    $rating_table = $wpdb->prefix . "schools_rating";

$regionCode = $_GET['regionCode'];
$regionName = $_GET['region'];
$type = $_GET['type'];

?>
<?php

//------------------------------------------------------------------- INTERACTIVE MAP ------------------------------------------------------------------- 

    if (empty($_GET['school_id'])) { ?>
        
        <div class="row">
    <div class="col-md-8">
        <div id="world-map" style="height: 250px; margin-top:20px"></div>        
    </div>
    <div class="col-md-4">
        <p>Schulform</p>
        <?php
        if (isset($regionName) && !empty($regionName)) {
            $type_of_school =  $wpdb->get_results($wpdb->prepare(
                    "SELECT
                        DISTINCT type_of_school
                    FROM
                        ".$table_name."
                    WHERE
                        region LIKE %s;",
                    '%' . $wpdb->esc_like($regionName) . '%'
                ));
            foreach ($type_of_school as $key => $value) {
                ?>
                <a href="?region=<?=$regionName?>&regionCode=<?=$regionCode?>&type=<?=$value->type_of_school?>"><?=$value->type_of_school?></a><br>

                <?php
            }
        }

        ?>
    </div>
</div>

 <?php   }
 ?>

<br>
  <script>
    $(function(){
        var regCode = "<?=$regionCode?>";
      	var myCustomColors = {
        'AT-1': '#8a8a8a', //BURGENLAND
        'AT-2': '#8a8a8a', //KÄRNTEN
        'AT-3': '#8a8a8a', //NÖ
        'AT-4': '#8a8a8a', //OÖ
        'AT-5': '#8a8a8a', //SALZBURG
        'AT-6': '#8a8a8a', //STMK
        'AT-7': '#22252C', //TIROL
        'AT-8': '#8a8a8a', //VORARLBERG
        'AT-9': '#8a8a8a' //WIEN
    };
      $('#world-map').vectorMap(
        {
            map: 'at_mill',
            backgroundColor: 'white',
            series: {
             regions: [{
                    attribute: 'fill'
                }]
            },
            regionStyle: {
            initial: {
                fill: '#e4e4e4',
                "fill-opacity": 1,
                stroke: 'none',
                "stroke-width": 0,
                "stroke-opacity": 1
            },
            selected:{
                 fill: "#ff5252"
                }

            },
            zoomOnScroll : false,
              selectedColor: '#00ff26',
              scaleColors: ['#b6d6ff', '#005ace'],
            zoomButtons : false,
            regionsSelectable: true,
            regionsSelectableOne : true,
            setSelectedRegions : regCode,
            onRegionClick: function (event, code) {
                var url ='';


          /* Here We are getting Map Object */
          var map=$('#world-map').vectorMap('get', 'mapObject');

          /* Here Using Map Object we are using Inbuilt GetRegionName 
          function TO Get Regionname for a region Code */
          //map.setSelectedRegions(regCode);
          var regionName = map.getRegionName(code);


          console.log("Code: "+code+"<br/>");
          console.log("Region Name: "+regionName+"<br/>");
          url = document.location.protocol +"//"+ document.location.hostname + document.location.pathname+"?region="+regionName+"&regionCode="+code;
          //alert(url);

          //url = (window.location.href+"?region="+regionName+"&regionCode="+code);
          window.location = url;

        }
        });

                /* Here We are getting Map Object */
          var map=$('#world-map').vectorMap('get', 'mapObject');
            if (regCode) {
                // the variable is defined
                //alert();
                map.setSelectedRegions(regCode);
            }
            map.series.regions[0].setValues(myCustomColors);
          /* Here Using Map Object we are using Inbuilt GetRegionName 
          function TO Get Regionname for a region Code */
          // if (regCode !== null || regCode!=='') {
              
          // }
          
    });
  </script>
<style>
/*------------------------------------------------------------------- CSS STYLING ------------------------------------------------------------------- 
*/
	
.ratings_lesen{
	    background-color: #171b3a;
	font-size: 16px;
    padding: 15px 30px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
	color: white;
	  transition: all .3s;
	 transition-duration: .3s;
    transition-property: transform;
	}
	.rating_lesen:hover{
		transform: scale(1.1); 
	}
		
	
/* 
  ##Device = Desktops
  ##Screen = 1281px to higher resolution desktops
*/

@media (min-width: 1281px) { 
  .custom-row {
    min-height: 350px;
  } 
      h3 {
  font-size: 24px;
}
          h2 {
  font-size: 24px;
}
}

/* 
  ##Device = Laptops, Desktops
  ##Screen = B/w 1025px to 1280px
*/
@media (min-width: 1025px) and (max-width: 1280px) {
   .custom-row {
    min-height: 350px;
  }
      h3 {
  font-size: 21px;
}
          h2 {
  font-size: 21px;
}
}

/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/
@media (min-width: 320px) and (max-width: 480px) {
    .custom-row {
    min-height: auto;
  }
  h3 {
  font-size: 21px;
}
}

/* Load more */
.load-more{
    font-size: 25px;
    text-align: center;
    color: #0f0f0f;
    padding: 10px 0px;
    font: Roboto;
}

.load-more:hover{
    cursor: pointer;
}
h3{
    text-align: center;
}
.rating-loading{
    width:25px;
    height:25px;
    font-size:0;
    color:#fff;
    background:url(../img/loading.gif) top left no-repeat;border:none
    }
.rating-container .rating-stars
    {position:relative;
    cursor:pointer;
    vertical-align:middle;
    display:inline-block;
    overflow:hidden;
    white-space:nowrap
         }
         .rating-container .rating-input
         {position:absolute;
         cursor:pointer;
         width:100%;
         height:1px;
         bottom:0;left:0;
         font-size:1px;
         border:none;
         background:0 0;
         padding:0;
         margin:0
         }
         .rating-disabled .rating-input,.rating-disabled .rating-stars
         {
             cursor:not-allowed
             
         }
         .rating-container .star{
             display:inline-block;
             margin:0 3px;
             text-align:center
         }
         .rating-container .empty-stars{
             color:#aaa
         }
         .rating-container .filled-stars
         {
             position:absolute;
             left:0;
             top:0;
             margin:auto;
             color:#fde16d;
             white-space:nowrap;
             overflow:hidden;
             -webkit-text-stroke:1px #777;
             text-shadow:1px 1px #999
         }
             .rating-rtl
             {
                 float:right
                 
             }
             .rating-animate .filled-stars
             {
                 transition:width .25s ease;
                 -o-transition:width .25s ease;
                 -moz-transition:width .25s ease;-webkit-transition:width .25s ease
             }
             .rating-rtl .filled-stars
             {left:auto;right:0;-moz-transform:matrix(-1,0,0,1,0,0) translate3d(0,0,0);-webkit-transform:matrix(-1,0,0,1,0,0) translate3d(0,0,0);-o-transform:matrix(-1,0,0,1,0,0) translate3d(0,0,0);
             transform:matrix(-1,0,0,1,0,0) translate3d(0,0,0)}.rating-rtl.is-star 
             .filled-stars{
                 right:.06em
                 
             }
             .rating-rtl.is-heart .empty-stars{
                 margin-right:.07em
                 
             }
             .rating-lg{
                 font-size:3.91em
                 
             }
             .rating-md{
                 font-size:2.7em
                 
             }
             .rating-sm{
                 font-size:2.5em
                 
             }
             .rating-xs{
                 font-size:2em
                 
             }
             .rating-xl{
             font-size:4.89em
                 
             }
             .rating-container .clear-rating{
                 color:#aaa;
                 cursor:not-allowed;
                 display:inline-block;
                 vertical-align:middle;
                 font-size:60%;
                 padding-right:5px
                 
             }
             .clear-rating-active{
                 cursor:pointer!important
                 
             }
             .clear-rating-active:hover{
                 color:#843534
                 
             }
             .rating-container .caption{
                 color:#999;
                 display:inline-block;
                 vertical-align:middle;
                 font-size:60%;
                 margin-top:-.6em;
                 margin-left:5px;
                 margin-right:0
                 
             }
             .rating-rtl .caption{
                 margin-right:5px;
                 margin-left:0
                 
             }
             @media print{.rating-container .clear-rating{
                 display:none
                 
             }
         
             }
</style>
<style type="text/css">
    .fa, .fas {
    color: black;
    font-size: xx-large;
}
</style>



<script type="text/javascript">

 !function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof module&&module.exports?module.exports=e(require("jquery")):e(window.jQuery)}(function(e){"use strict";e.fn.ratingLocales={},e.fn.ratingThemes={};var t,a;t={NAMESPACE:".rating",DEFAULT_MIN:0,DEFAULT_MAX:5,DEFAULT_STEP:.5,isEmpty:function(t,a){return null===t||void 0===t||0===t.length||a&&""===e.trim(t)},getCss:function(e,t){return e?" "+t:""},addCss:function(e,t){e.removeClass(t).addClass(t)},getDecimalPlaces:function(e){var t=(""+e).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);return t?Math.max(0,(t[1]?t[1].length:0)-(t[2]?+t[2]:0)):0},applyPrecision:function(e,t){return parseFloat(e.toFixed(t))},handler:function(e,a,n,r,i){var l=i?a:a.split(" ").join(t.NAMESPACE+" ")+t.NAMESPACE;r||e.off(l),e.on(l,n)}},a=function(t,a){var n=this;n.$element=e(t),n._init(a)},a.prototype={constructor:a,_parseAttr:function(e,a){var n,r,i,l,s=this,o=s.$element,c=o.attr("type");if("range"===c||"number"===c){switch(r=a[e]||o.data(e)||o.attr(e),e){case"min":i=t.DEFAULT_MIN;break;case"max":i=t.DEFAULT_MAX;break;default:i=t.DEFAULT_STEP}n=t.isEmpty(r)?i:r,l=parseFloat(n)}else l=parseFloat(a[e]);return isNaN(l)?i:l},_parseValue:function(e){var t=this,a=parseFloat(e);return isNaN(a)&&(a=t.clearValue),!t.zeroAsNull||0!==a&&"0"!==a?a:null},_setDefault:function(e,a){var n=this;t.isEmpty(n[e])&&(n[e]=a)},_initSlider:function(e){var a=this,n=a.$element.val();a.initialValue=t.isEmpty(n)?0:n,a._setDefault("min",a._parseAttr("min",e)),a._setDefault("max",a._parseAttr("max",e)),a._setDefault("step",a._parseAttr("step",e)),(isNaN(a.min)||t.isEmpty(a.min))&&(a.min=t.DEFAULT_MIN),(isNaN(a.max)||t.isEmpty(a.max))&&(a.max=t.DEFAULT_MAX),(isNaN(a.step)||t.isEmpty(a.step)||0===a.step)&&(a.step=t.DEFAULT_STEP),a.diff=a.max-a.min},_initHighlight:function(e){var t,a=this,n=a._getCaption();e||(e=a.$element.val()),t=a.getWidthFromValue(e)+"%",a.$filledStars.width(t),a.cache={caption:n,width:t,val:e}},_getContainerCss:function(){var e=this;return"rating-container"+t.getCss(e.theme,"theme-"+e.theme)+t.getCss(e.rtl,"rating-rtl")+t.getCss(e.size,"rating-"+e.size)+t.getCss(e.animate,"rating-animate")+t.getCss(e.disabled||e.readonly,"rating-disabled")+t.getCss(e.containerClass,e.containerClass)},_checkDisabled:function(){var e=this,t=e.$element,a=e.options;e.disabled=void 0===a.disabled?t.attr("disabled")||!1:a.disabled,e.readonly=void 0===a.readonly?t.attr("readonly")||!1:a.readonly,e.inactive=e.disabled||e.readonly,t.attr({disabled:e.disabled,readonly:e.readonly})},_addContent:function(e,t){var a=this,n=a.$container,r="clear"===e;return a.rtl?r?n.append(t):n.prepend(t):r?n.prepend(t):n.append(t)},_generateRating:function(){var a,n,r,i=this,l=i.$element;n=i.$container=e(document.createElement("div")).insertBefore(l),t.addCss(n,i._getContainerCss()),i.$rating=a=e(document.createElement("div")).attr("class","rating-stars").appendTo(n).append(i._getStars("empty")).append(i._getStars("filled")),i.$emptyStars=a.find(".empty-stars"),i.$filledStars=a.find(".filled-stars"),i._renderCaption(),i._renderClear(),i._initHighlight(),n.append(l),i.rtl&&(r=Math.max(i.$emptyStars.outerWidth(),i.$filledStars.outerWidth()),i.$emptyStars.width(r)),l.appendTo(a)},_getCaption:function(){var e=this;return e.$caption&&e.$caption.length?e.$caption.html():e.defaultCaption},_setCaption:function(e){var t=this;t.$caption&&t.$caption.length&&t.$caption.html(e)},_renderCaption:function(){var a,n=this,r=n.$element.val(),i=n.captionElement?e(n.captionElement):"";if(n.showCaption){if(a=n.fetchCaption(r),i&&i.length)return t.addCss(i,"caption"),i.html(a),void(n.$caption=i);n._addContent("caption",'<div class="caption">'+a+"</div>"),n.$caption=n.$container.find(".caption")}},_renderClear:function(){var a,n=this,r=n.clearElement?e(n.clearElement):"";if(n.showClear){if(a=n._getClearClass(),r.length)return t.addCss(r,a),r.attr({title:n.clearButtonTitle}).html(n.clearButton),void(n.$clear=r);n._addContent("clear",'<div class="'+a+'" title="'+n.clearButtonTitle+'">'+n.clearButton+"</div>"),n.$clear=n.$container.find("."+n.clearButtonBaseClass)}},_getClearClass:function(){var e=this;return e.clearButtonBaseClass+" "+(e.inactive?"":e.clearButtonActiveClass)},_toggleHover:function(e){var t,a,n,r=this;e&&(r.hoverChangeStars&&(t=r.getWidthFromValue(r.clearValue),a=e.val<=r.clearValue?t+"%":e.width,r.$filledStars.css("width",a)),r.hoverChangeCaption&&(n=e.val<=r.clearValue?r.fetchCaption(r.clearValue):e.caption,n&&r._setCaption(n+"")))},_init:function(t){var a,n=this,r=n.$element.addClass("rating-input");return n.options=t,e.each(t,function(e,t){n[e]=t}),(n.rtl||"rtl"===r.attr("dir"))&&(n.rtl=!0,r.attr("dir","rtl")),n.starClicked=!1,n.clearClicked=!1,n._initSlider(t),n._checkDisabled(),n.displayOnly&&(n.inactive=!0,n.showClear=!1,n.showCaption=!1),n._generateRating(),n._initEvents(),n._listen(),a=n._parseValue(r.val()),r.val(a),r.removeClass("rating-loading")},_initEvents:function(){var e=this;e.events={_getTouchPosition:function(a){var n=t.isEmpty(a.pageX)?a.originalEvent.touches[0].pageX:a.pageX;return n-e.$rating.offset().left},_listenClick:function(e,t){return e.stopPropagation(),e.preventDefault(),e.handled===!0?!1:(t(e),void(e.handled=!0))},_noMouseAction:function(t){return!e.hoverEnabled||e.inactive||t&&t.isDefaultPrevented()},initTouch:function(a){var n,r,i,l,s,o,c,u,d=e.clearValue||0,p="ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch;p&&!e.inactive&&(n=a.originalEvent,r=t.isEmpty(n.touches)?n.changedTouches:n.touches,i=e.events._getTouchPosition(r[0]),"touchend"===a.type?(e._setStars(i),u=[e.$element.val(),e._getCaption()],e.$element.trigger("change").trigger("rating.change",u),e.starClicked=!0):(l=e.calculate(i),s=l.val<=d?e.fetchCaption(d):l.caption,o=e.getWidthFromValue(d),c=l.val<=d?o+"%":l.width,e._setCaption(s),e.$filledStars.css("width",c)))},starClick:function(t){var a,n;e.events._listenClick(t,function(t){return e.inactive?!1:(a=e.events._getTouchPosition(t),e._setStars(a),n=[e.$element.val(),e._getCaption()],e.$element.trigger("change").trigger("rating.change",n),void(e.starClicked=!0))})},clearClick:function(t){e.events._listenClick(t,function(){e.inactive||(e.clear(),e.clearClicked=!0)})},starMouseMove:function(t){var a,n;e.events._noMouseAction(t)||(e.starClicked=!1,a=e.events._getTouchPosition(t),n=e.calculate(a),e._toggleHover(n),e.$element.trigger("rating.hover",[n.val,n.caption,"stars"]))},starMouseLeave:function(t){var a;e.events._noMouseAction(t)||e.starClicked||(a=e.cache,e._toggleHover(a),e.$element.trigger("rating.hoverleave",["stars"]))},clearMouseMove:function(t){var a,n,r,i;!e.events._noMouseAction(t)&&e.hoverOnClear&&(e.clearClicked=!1,a='<span class="'+e.clearCaptionClass+'">'+e.clearCaption+"</span>",n=e.clearValue,r=e.getWidthFromValue(n)||0,i={caption:a,width:r,val:n},e._toggleHover(i),e.$element.trigger("rating.hover",[n,a,"clear"]))},clearMouseLeave:function(t){var a;e.events._noMouseAction(t)||e.clearClicked||!e.hoverOnClear||(a=e.cache,e._toggleHover(a),e.$element.trigger("rating.hoverleave",["clear"]))},resetForm:function(t){t&&t.isDefaultPrevented()||e.inactive||e.reset()}}},_listen:function(){var a=this,n=a.$element,r=n.closest("form"),i=a.$rating,l=a.$clear,s=a.events;return t.handler(i,"touchstart touchmove touchend",e.proxy(s.initTouch,a)),t.handler(i,"click touchstart",e.proxy(s.starClick,a)),t.handler(i,"mousemove",e.proxy(s.starMouseMove,a)),t.handler(i,"mouseleave",e.proxy(s.starMouseLeave,a)),a.showClear&&l.length&&(t.handler(l,"click touchstart",e.proxy(s.clearClick,a)),t.handler(l,"mousemove",e.proxy(s.clearMouseMove,a)),t.handler(l,"mouseleave",e.proxy(s.clearMouseLeave,a))),r.length&&t.handler(r,"reset",e.proxy(s.resetForm,a),!0),n},_getStars:function(e){var t,a=this,n='<span class="'+e+'-stars">';for(t=1;t<=a.stars;t++)n+='<span class="star">'+a[e+"Star"]+"</span>";return n+"</span>"},_setStars:function(e){var t=this,a=arguments.length?t.calculate(e):t.calculate(),n=t.$element,r=t._parseValue(a.val);return n.val(r),t.$filledStars.css("width",a.width),t._setCaption(a.caption),t.cache=a,n},showStars:function(e){var t=this,a=t._parseValue(e);return t.$element.val(a),t._setStars()},calculate:function(e){var a=this,n=t.isEmpty(a.$element.val())?0:a.$element.val(),r=arguments.length?a.getValueFromPosition(e):n,i=a.fetchCaption(r),l=a.getWidthFromValue(r);return l+="%",{caption:i,width:l,val:r}},getValueFromPosition:function(e){var a,n,r=this,i=t.getDecimalPlaces(r.step),l=r.$rating.width();return n=r.diff*e/(l*r.step),n=r.rtl?Math.floor(n):Math.ceil(n),a=t.applyPrecision(parseFloat(r.min+n*r.step),i),a=Math.max(Math.min(a,r.max),r.min),r.rtl?r.max-a:a},getWidthFromValue:function(e){var t,a,n=this,r=n.min,i=n.max,l=n.$emptyStars;return!e||r>=e||r===i?0:(a=l.outerWidth(),t=a?l.width()/a:1,e>=i?100:(e-r)*t*100/(i-r))},fetchCaption:function(e){var a,n,r,i,l,s=this,o=parseFloat(e)||s.clearValue,c=s.starCaptions,u=s.starCaptionClasses;return o&&o!==s.clearValue&&(o=t.applyPrecision(o,t.getDecimalPlaces(s.step))),i="function"==typeof u?u(o):u[o],r="function"==typeof c?c(o):c[o],n=t.isEmpty(r)?s.defaultCaption.replace(/\{rating}/g,o):r,a=t.isEmpty(i)?s.clearCaptionClass:i,l=o===s.clearValue?s.clearCaption:n,'<span class="'+a+'">'+l+"</span>"},destroy:function(){var a=this,n=a.$element;return t.isEmpty(a.$container)||a.$container.before(n).remove(),e.removeData(n.get(0)),n.off("rating").removeClass("rating rating-input")},create:function(e){var t=this,a=e||t.options||{};return t.destroy().rating(a)},clear:function(){var e=this,t='<span class="'+e.clearCaptionClass+'">'+e.clearCaption+"</span>";return e.inactive||e._setCaption(t),e.showStars(e.clearValue).trigger("change").trigger("rating.clear")},reset:function(){var e=this;return e.showStars(e.initialValue).trigger("rating.reset")},update:function(e){var t=this;return arguments.length?t.showStars(e):t.$element},refresh:function(t){var a=this,n=a.$element;return t?a.destroy().rating(e.extend(!0,a.options,t)).trigger("rating.refresh"):n}},e.fn.rating=function(n){var r=Array.apply(null,arguments),i=[];switch(r.shift(),this.each(function(){var l,s=e(this),o=s.data("rating"),c="object"==typeof n&&n,u=c.theme||s.data("theme"),d=c.language||s.data("language")||"en",p={},h={};o||(u&&(p=e.fn.ratingThemes[u]||{}),"en"===d||t.isEmpty(e.fn.ratingLocales[d])||(h=e.fn.ratingLocales[d]),l=e.extend(!0,{},e.fn.rating.defaults,p,e.fn.ratingLocales.en,h,c,s.data()),o=new a(this,l),s.data("rating",o)),"string"==typeof n&&i.push(o[n].apply(o,r))}),i.length){case 0:return this;case 1:return void 0===i[0]?this:i[0];default:return i}},e.fn.rating.defaults={theme:"",language:"en",stars:5,filledStar:'<i class="glyphicon glyphicon-star"></i>',emptyStar:'<i class="glyphicon glyphicon-star-empty"></i>',containerClass:"",size:"md",animate:!0,displayOnly:!1,rtl:!1,showClear:!0,showCaption:0,starCaptionClasses:{.5:"label label-danger",1:"label label-danger",1.5:"label label-warning",2:"label label-warning",2.5:"label label-info",3:"label label-info",3.5:"label label-primary",4:"label label-primary",4.5:"label label-success",5:"label label-success"},clearButton:'<i class="glyphicon glyphicon-minus-sign"></i>',clearButtonBaseClass:"clear-rating",clearButtonActiveClass:"clear-rating-active",clearCaptionClass:"label label-default",clearValue:null,captionElement:null,clearElement:null,hoverEnabled:!0,hoverChangeCaption:0,hoverChangeStars:!0,hoverOnClear:!0,zeroAsNull:!0},e.fn.ratingLocales.en={defaultCaption:"{rating} Stars",
    starCaptions:{.5:"Half Star",1:"One Star",1.5:"One & Half Star",2:"Two Stars",2.5:"Two & Half Stars",3:"Three Stars",3.5:"Three & Half Stars",4:"Four Stars",4.5:"Four & Half Stars",5:"Five Stars"},clearButtonTitle:"Clear",clearCaption:"Not Rated"},e.fn.rating.Constructor=a,e(document).ready(function(){var t=e("input.rating");t.length&&t.removeClass("rating-loading").addClass("rating-loading").rating()})});
</script>

            <script type="text/javascript">
$(document).ready(function(){
//------------------------------------------------------------------- LOAD MORE FUNCTION ------------------------------------------------------------------- 

    $('.load-more').click(function(){
        var row = Number($('#row').val());
        var allcount = Number($('#all').val());
        var rowperpage = 14;
        row = row + rowperpage;

        if(row <= allcount){
            $("#row").val(row);

            $.ajax({
                url: "<?=WPAC_PLUGIN_DIR . 'inc/get_load_more.php' ?>",
                type: 'post',
                data: {row:row},
                beforeSend:function(){
                    $(".load-more").text("Lade Schulen...");
                },
                success: function(response){
                    console.log(response);
                    // Setting little delay while displaying new content
                    setTimeout(function() {
                        // appending posts after last post with class="post"
                        $(".post:last").after(response).show().fadeIn("slow");

                        var rowno = row + rowperpage;

                        // checking row value is greater than allcount or not
                        if(rowno > allcount){

                            // Change the text and background
                            $('.load-more').text("Hide");
                            $('.load-more').hide();

                            $('.load-more').css("background","darkorchid");
                        }else{
                            $(".load-more").text("Mehr Laden");
                        }
                    }, 1000);

                }
            });
        }else{
            $('.load-more').text("Lade Schulen...");

            // Setting little delay while removing contents
            setTimeout(function() {

                // When row is greater than allcount then remove all class='post' element after 3 element
                $('.post:nth-child(3)').nextAll('.post').remove();

                // Reset the value of row
                $("#row").val(0);

                // Change the text and background
                $('.load-more').text("Load more");
                $('.load-more').css("background","#15a9ce");
                
            }, 1000);
        }

    });

});
//opening the Rating fields
jQuery(document).ready(function() {
   jQuery( ".target" ).click(function() {
	   $("#titel").hide(); // Hide page titel when opening the Rating fields
	   $(".trennlinie").hide(); // Hide page titel when opening the Rating fields
	   $("#world-map").hide(); // Hide map when opening the Rating fields
	   $(".col-md-4").hide(); // Hide Schulform when opening the Rating fields
		jQuery('html,body').animate({ scrollTop: 0 }, 'slow'); //scroll to top when rating fields gets opened
	   
			
  //alert( "Handler for .click() called." );
  jQuery("#main_div").hide(500);
  jQuery("#search_div").hide(500);
  jQuery("#rating_div").show(500);
  jQuery(".back_button").show(500);

  var id = jQuery(this).attr("data_id");
  jQuery(".formData").val(id);
  // jQuery(this).attr("value_id").val(id);
  // jQuery(".data_id").val("Dolly Duck");
  //alert(id);

});
jQuery( ".back_button" ).click(function() {
  //alert( "Handler for .click() called." );
  jQuery("#main_div").show(500);
  jQuery("#search_div").show(500);
  jQuery("#rating_div").hide(500);
  jQuery(".back_button").hide(500);

});

//------------------------------------------------------------------- MESSAGES AND FUNCTIONS ------------------------------------------------------------------- 

	
jQuery( ".submit_rating_button" ).click(function() {
            var school_id = jQuery( "#school_id" ).val();
            var comment1 = jQuery( "#comment1" ).val();
            var rating1 = jQuery( "#input-1" ).val();
            var comment2 = jQuery( "#comment2" ).val();
            var rating2 = jQuery( "#input-2" ).val();
            var comment3 = jQuery( "#comment3" ).val();
            var rating3 = jQuery( "#input-3" ).val();
            var comment4 = jQuery( "#comment4" ).val();
            var rating4 = jQuery( "#input-4" ).val();
            var comment5 = jQuery( "#comment5" ).val();
            var rating5 = jQuery( "#input-5" ).val();
            var user_email = jQuery( "#user_email" ).val();

            if (user_email == '') 
            {
                //alert("Email Adresse ist erforderlich!");
                Swal.fire({
                  type: 'warning',
                  title: 'Achtung',
                  text: 'Du musst deine Mail-Adresse eingeben!'
                })
                return;
            }
              //alert(singleValues );

              var submit = 'submit';
                jQuery.ajax({
                type : "post",
                url : "<?=WPAC_PLUGIN_DIR . 'inc/submit_school_rating.php' ?>",
                data : {
                        school_id : school_id,
                        comment1 : comment1,
                        rating1 : rating1,
                        comment2 : comment2,
                        rating2 : rating2,
                        comment3 : comment3,
                        rating3 : rating3,
                        comment4 : comment4,
                        rating4 : rating4,
                        comment5 : comment5,
                        rating5 : rating5,
                        user_email : user_email,
                        submit : submit
                      } ,
                success: function(res) {
                    console.log(res);

						//----- ERROR MESSAGE | ALREAYDY SUBMITTED -----
                        if (res == 2) {
                          Swal.fire({
                              type: 'error',
                              title: 'Fehler',
                              text: 'Du hast schon eine Bewertung abgesendet!',
                              footer: '<a href="whatsapp://send?text=Hey, bewerte auch du deine Schule auf GradeYourSchool! Bei GradeYourSchool kannst du deine Schule bewerten um zukünftigen SchülerInnen die Schulwahl leichter zu machen. Und das Ganze passiert auch noch anonym. Also bewerte auch du!🌟">Informiere deine Freunde über uns! <ion-icon name="logo-whatsapp"></ion-icon></a>'
                            })
                        }
						//----- SUCCESS MESSAGE -----
                        if (res == 1) { 
                            Swal.fire({
                              title: 'Erfolgreich abgesendet!',
                              text: "Du wirst gleich weitergeleitet..",
                              type: 'success',
                              footer: '<a href="whatsapp://send?text=Hey, bewerte auch du deine Schule auf GradeYourSchool! Bei GradeYourSchool kannst du deine Schule bewerten um zukünftigen SchülerInnen die Schulwahl leichter zu machen. Und das Ganze passiert auch noch anonym. Also bewerte auch du!🌟">Informiere deine Freunde über uns! <ion-icon name="logo-whatsapp"></ion-icon></a>',
                              timer: 3000,
                              onBeforeOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                  Swal.getContent().querySelector('strong')
                                    .textContent = Swal.getTimerLeft()
                                }, 100)
                              },
                              onClose: () => {
                                clearInterval(timerInterval)
                              }
                            }).then((result) => {
                              if (
                                /* Read more about handling dismissals below */
                                result.dismiss === Swal.DismissReason.timer
                              ) {
                                window.location.href = "https://gradeyourschool.at/schulen/?school_id="+school_id;
                                console.log('I was closed by the timer')
                              }
})
                        }
						//----- ERROR MESSAGE | NOT FOUND -----
                        if (res == 0) {
                            Swal.fire({
                              type: 'error',
                              title: 'Ups...',
                              text: 'Deine Schule wurde leider nicht gefunden!',
                              footer: '<a href="https://gradeyourschool.at/kontakt">Bitte informiere uns darüber!</a>'
                            })
                        }
                                      

                },
				//----- ERROR MESSAGE | UNKNOWN ERROR -----
                error: function(data) {
                     Swal.fire({
                              type: 'error',
                              title: 'ERROR',
                              text: 'Leider ist beim absenden deiner Bewertung ein Fehler aufgetreten!',
                              footer: '<a href="https://gradeyourschool.at/kontakt">Bitte informiere uns darüber!</a>'
                            })
                },
            });

});
var first_input,second_input,third_input,fourth_input,total_sum;
$('#input-1').on('rating.change', function() {
            
            first_input = $('#input-1').val();
            second_input = $('#input-2').val();
            third_input = $('#input-3').val();
            fourth_input = $('#input-4').val();
            total_sum = first_input+second_input+third_input+fourth_input;

            jQuery("#input-5").val(total_sum);

        });
$('#input-2').on('rating.change', function() {
            
    //var filled = jQuery(".filled-stars").attr("width").val();
            //alert("The selected rating is: " + $('#input-2').val());
        });
$('#input-3').on('rating.change', function() {
            
    //var filled = jQuery(".filled-stars").attr("width").val();
            //alert("The selected rating is: " + $('#input-3').val());
        });
$('#input-4').on('rating.change', function() {
            
    //var filled = jQuery(".filled-stars").attr("width").val();
            //alert("The selected rating is: " + $('#input-4').val());
        });
});         

            </script>
<?php 
	
//------------------------------------------------------------------- VIEW RATING ------------------------------------------------------------------- 

if (isset($_GET['school_id']) && !empty($_GET['school_id'])) {
    //print_r($_GET['school_id']);
     $ratings =  $wpdb->get_results("SELECT ".$rating_table.".*,".$table_name.".school_name,".$table_name.".school_Address,".$table_name.".country_code FROM ".$rating_table." LEFT JOIN ".$table_name." ON ".$table_name.".id = ".$rating_table.".school_id WHERE ".$rating_table.".school_id=".$_GET['school_id']."");
     //echo "<pre>";
     //print_r($ratings);
     if (isset($ratings) && !empty($ratings)) {
              foreach ($ratings as $key => $value) {
?>

<script>$("#not_av").hide(); // Hide nicht vorhanden when opening the Rating fields</script>
 <div class="card">
  <div class="card-header">
    <p><?=date("d.m.Y H:i", strtotime($value->created_at))?></p>
    <div class="row">
        <div class="col-sm-2">
            <img src="https://image.flaticon.com/icons/svg/167/167707.svg" style="width: 50px;height: 50px;border-radius: 50%;">
        </div>
        <div class="col-sm-10">
            <p><?=$value->school_name?> - <?=$value->school_Address.', '.$value->country_code?></p>
        </div>
   
    </div>
    
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-sm-6">
            <h5 class="card-title">Lehrerkollegium</h5>
        
            <?php 
            $average = explode('.', (string)$value->q1_rating); //floor();
            //print_r($average);
           //$rem_rat = 5-$average;
           //var_dump($rem_rat);
            for ($i=0; $i <$average[0] ; $i++) { ?>
               <i class="fa fa-star" aria-hidden="true"></i>
            <?php } 
                if (isset($average[1])) {
              ?>
               <i class="fa fa-star-half-o" aria-hidden="true"></i>
           <?php }
           ?>
            <p class="card-text"><?=$value->q1_comment?></p>
        </div>
        <div class="col-sm-6">
            <h5 class="card-title">Ausstattung / Modernheit</h5>
            <?php 
            $average = explode('.', (string)$value->q2_rating); //floor($value->q2_rating);
           // $rem_rat = 5-$average;
            for ($i=0; $i <$average[0] ; $i++) { ?>
               <i class="fa fa-star" aria-hidden="true"></i>
            <?php }
            if (isset($average[1])) { ?>
               <i class="fa fa-star-half-o" aria-hidden="true"></i>
           <?php } 
           ?>
            <p class="card-text"><?=$value->q2_comment?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-6">
            <h5 class="card-title">Freizeitaktivitäten / Angebot</h5>
            <?php 
            $average = explode('.', (string)$value->q3_rating); // floor($value->q3_rating);
           //$rem_rat = 5-$average;
            for ($i=0; $i <$average[0] ; $i++) { ?>
               <i class="fa fa-star" aria-hidden="true"></i>
            <?php }
             if (isset($average[1])) { ?>
               <i class="fa fa-star-half-o" aria-hidden="true"></i>
           <?php }
           ?>
            <p class="card-text"><?=$value->q3_comment?></p>
        </div>
        <div class="col-sm-6">
            <h5 class="card-title">Cafetaria / Nahrungsangebot</h5>
            <?php 
            $average = explode('.', (string)$value->q4_rating); // floor($value->q4_rating);
           //$rem_rat = 5-$average;
            for ($i=0; $i <$average[0] ; $i++) { ?>
               <i class="fa fa-star" aria-hidden="true"></i>
            <?php }
             if (isset($average[1])) { ?>
               <i class="fa fa-star-half-o" aria-hidden="true"></i>
           <?php  }
           ?>
            <p class="card-text"><?=$value->q4_comment?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <h5 class="card-title">Gesamtwertung</h5>
            <?php 
            $average = explode('.', (string)$value->average_rating); //floor($value->average_rating);
            for ($i=0; $i <$average[0] ; $i++) { ?>
               <i class="fa fa-star" aria-hidden="true"></i>
            <?php } 
            if (isset($average[1])) {  ?>
               <i class="fa fa-star-half-o" aria-hidden="true"></i>
           <?php }
           ?>
            <p class="card-text"><?=$value->main_comment?></p>
        </div>
        
    </div>
  </div>
</div>
     <?php
}
     }
//------------------------------------------------------------------- NO RATING AVAIBLE ------------------------------------------------------------------- 
     else{
        echo "<center><h4>Es tut uns leid, aber es wurden keine Bewertungen gefunden.</h4></center>";
     }
} 
else
//------------------------------------------------------------------- SEARCHFORM ------------------------------------------------------------------- 
{ ?>
<div id="main_div">    

<?php    if (isset($_POST['search_query'])) { //--------- SCHOOL FOUND ---------
        //print_r($_POST['search_query']);
        $results =  $wpdb->get_results($wpdb->prepare(
                    "SELECT
                        *
                    FROM
                        ".$table_name."
                    WHERE
                        school_name LIKE %s;",
                    '%' . $wpdb->esc_like($_POST['search_query']) . '%'
                ));
        if (empty($results)) { //--------- SCHOOL NOT FOUND ---------
            ?>
            <script>
                Swal.fire({
                  type: 'error',
                  title: 'Ups...',
                  text: 'Deine Schule wurde leider nicht gefunden!',
                  footer: '<a href="https://gradeyourschool.at/kontakt/schulen-korrektur/">Bitte informiere uns darüber!</a>'
                })
            </script>   

            <?php
        }

    }
    else{
        //$results = $wpdb->get_results( "SELECT * FROM ".$table_name."", OBJECT );
        if (isset($regionName) && !empty($regionName)) {
            //echo "i min";
             if (isset($regionName) && !empty($regionName) && isset($type) && !empty($type)) {
                 $results =  $wpdb->get_results("SELECT * FROM $table_name WHERE region ='$regionName' 
                    AND type_of_school = '$type'");
             }
             else
             {
                $results =  $wpdb->get_results("SELECT * FROM $table_name WHERE region ='$regionName'");   
             }
             
        }
        else{
             $rowperpage = 14;
             $main_page = 1;
             $results =  $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY country_code limit 0,".$rowperpage);

             $all_results =  $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY country_code");
             $allcount = count($all_results);
             
        }

        
    }
    
    // echo "<pre>";
    // print_r($results);
    // exit();
    if (isset($results) && !empty($results)) {
?> 

<?php       
    foreach ($results as $key => $value) {
    // echo "<pre>";
    // print_r($value);
    // exit;
?>

	<div class="col-sm-6 post" style="cursor: pointer;">
<div class="card mb-3" >
  <div class="row custom-row" style="margin-left:0px;">
    <div class="col-md-4"> <img src="<?=$value->school_image;?>" class="school-image" alt="school-image"> </div>
    <div class="col-md-8">
      <div class="card-body target" data_id="<?=$value->id?>">
        <!-- <span class="float-right"><i class="text-warning fa fa-star"></i></span>
        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
        <span class="float-right"><i class="text-warning fa fa-star"></i></span> -->
        <h3 class="card-title" style="text-align: inherit;"><?=$value->school_name;?></h3>
        <?php 
        $table_name = $wpdb->prefix . "schools_rating";
        //$results = $wpdb->get_results( "SELECT * FROM ".$table_name."", OBJECT );
         $res =  $wpdb->get_results("SELECT AVG(average_rating) AS average FROM ".$table_name." WHERE school_id =".$value->id);
       // echo "<pre>";
       // print_r($res[0]->average);
       $average = round($res[0]->average);
       $rem_rat = 5-$average;
        for ($i=0; $i <$average ; $i++) { ?>
           <i class="fa fa-star" aria-hidden="true"></i>
        <?php } for ($i=0; $i <$rem_rat ; $i++) { ?>
           <i class="fa fa-star-o" aria-hidden="true"></i>
       <?php  } 
       ?>
       
       <!-- <i class="fa fa-star-o" aria-hidden="true"></i>
        <i class="fa fa-star-half-o" aria-hidden="true"></i> -->
        <p class="card-text">Schulform: <?=$value->type_of_school;?></p>
        <p class="card-text"><small class="text-muted">Adresse: <?=$value->school_Address.', '.$value->country_code;?></small></p>
        
        
      </div>
      <form method="get" action="" class="bewertung_button">
        <input type="hidden" name="school_id" value="<?=$value->id?>">
        <button id="ratings_lesen" type="submit" style="font-size: 16px; padding: 5px 20px;-webkit-border-radius: 4px;";>Bewertungen lesen</button>
        </form>
    </div>

  </div>
</div>
</div>

<?php
}
?>
<?php 
    if ($main_page == 1) { ?>
        <h1 class="load-more">Mehr laden</h1>
        <input type="hidden" id="row" value="0">
        <input type="hidden" id="all" value="<?php echo $allcount; ?>"> 
<?php    }
?>

</div>
<?php } ?> 
<?php } 
//------------------------------------------------------------------- USER RATING FIELDS ------------------------------------------------------------------- 
?>

<div id="rating_div" class="value_id" style="display: none;">
    <div class="container">
        <div class="row" style="margin-top: 20px">
            <div class="col-sm-12 col-sm-offset-4" >
                <div class="form-group" >
                  <input class="col-sm-4" type="text" name="user_email" id="user_email" placeholder="&#9993; Mail-Adresse" autocomplete="on">
                </div>
                
            </div>
        </div>
        <br>
        <div class="row" style="margin-top: 20px">
            <div class="col-sm-6">
                <div class="form-group">
                    <h3 for="comment"><b>Lehrerkollegium:</b></h3>
                  <textarea  class="form-control" rows="5" id="comment1" placeholder="Wie sind deine Lehrerinnen und Lehrer? Viel junges Personal? Strenge Lehrkräfte? Schreib mal drauf los."></textarea>
                </div>
                <input id="input-1" type="number" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="0">         
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <h3 for="comment"><b>Ausstattung / Modernheit:</b></h3>
                  <textarea class="form-control" rows="5" id="comment2" placeholder="Wie ist die Ausstattung und Zustand deiner Schule? Sind die Computersäle modern?"></textarea>
                </div>
                <input id="input-2" type="number" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="0">         
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-sm-6">
                <div class="form-group">
                   <h3 for="comment"><b>Freizeitaktivitäten / Angebot:</b></h3>
                  <textarea class="form-control" rows="5" id="comment3" placeholder="Wie sieht es mit Freigegenständen bei euch aus? Habt ihr viel Auswahl?"></textarea>
                </div>
                <input id="input-3" type="number" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="0">         
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <h3 for="comment"><b>Cafetaria / Nahrungsangebot:</b></h3>
                  <textarea class="form-control" rows="5" id="comment4" placeholder="Besitzt ihr eine eigene Cafeteria? Habt ihr Getränkeautomaten? Erzähl doch mal..."></textarea>
                </div>
                <input id="input-4" type="number" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="0">         
            </div>
        </div>
        <br>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                  <h3 for="comment"><b>Gesamtwertung:</b></h3>
                  <textarea class="form-control" rows="5" id="comment5" placeholder="Wieso bewertest du deine Schule so wie du sie bewertet hast? Bitte begründe deine Bewertung."></textarea>
                </div>
                <input id="input-5" type="number" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="0">         
            </div>
        </div>
        <hr>
          
        <div class="row">
            <div class="col-sm-12 col-sm-offset-4" >
                
                <input type="submit" value="Absenden" class="submit_rating_button col-sm-4" style="background-color: #000000;
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: 0px 0px 0px 0px;
    padding: 15px 45px 15px 45px;
	margin-top: 10px;">           
            </div>
        </div>
   
    
   </div>
    <input type="hidden" value="" name="" id="school_id" class="formData">
</div>

<?php

    
?>