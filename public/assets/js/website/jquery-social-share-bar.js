/**
 * jquery-social-share-bar
 * Copyright: Jesse Nieminen, Viima Solutions Oy
 * 
 * License: MIT
 * --------------------
 * Modified from https://github.com/ewebdev/jquery-share
 */

(function ($, window, undefined) {
    "use strict";
  
    $.fn.share = function (method) {
  
      var helpers = {
        channels: {
          facebook: {url: 'https://www.facebook.com/RoyalExpressMyanmar/'},
          linkedin: {url: 'https://www.linkedin.com/company/royal-express'},
          youtube: {url: 'https://www.youtube.com/channel/UCinpOtElQdvB86f8_wT9mJA'},
          instagram: {url: 'https://www.instagram.com/royalexpress_mm'},
          telegram:{url:'https://t.me/RoyalExpressMM'},
          viber:{url:'https://bit.ly/3uVrLMv'}
        
        }
      };
  
      var methods = {
  
        init: function (options) {
          this.share.settings = $.extend({}, this.share.defaults, options);
  
          var settings = this.share.settings,
            pageTitle = settings.title || document.title || '',
            pageUrl = settings.pageUrl || window.location.href,
            pageDesc = settings.pageDesc || $('head > meta[name="description"]').attr("content") || '',
            position = settings.position || 'left',
            theme = settings.theme || 'circle',
            animate = settings.animate === false ? false : true,
            u = encodeURIComponent(pageUrl),
            t = encodeURIComponent(pageTitle);
  
          // Each instance of this plugin
          return this.each(function () {
            var $element = $(settings.containerTemplate(settings)).appendTo($(this)),
              id = $element.attr("id"),
              d = pageDesc.substring(0, 250),
              href;
  
            // Add class for positioning and animation of the widget
            $(this).addClass(position);
            if (animate) {
              $(this).addClass('animate');
            }
  
            // Add class for theming the widget
            $element.addClass(theme);
  
            // Append HTML for each network button
            for (var item in settings.channels) {
              item = settings.channels[item];
              href = helpers.channels[item].url;
              href = href.replace('|u|', u).replace('|t|', t).replace('|d|', d)
                .replace('|140|', t.substring(0, 130));
              $(settings.itemTemplate({provider: item, href: href, itemTriggerClass: settings.itemTriggerClass})).appendTo($element);
            }
  
            // Bind click
            $element.on('click', '.' + settings.itemTriggerClass, function (e) {
              e.preventDefault();
              var top = (screen.height / 2) - (settings.popupHeight / 2),
                left = (screen.width / 2) - (settings.popupWidth / 2);
              window.open($(this).data('href') || $(this).attr('href'), 't', 'toolbar=0,resizable=1,status=0,copyhistory=no,width=' + settings.popupWidth + ',height=' + settings.popupHeight + ',top=' + top + ',left=' + left);
            });
  
          });// End plugin instance
  
        }
      };
  
      if (methods[method]) {
        return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
      } else if (typeof method === 'object' || !method) {
        return methods.init.apply(this, arguments);
      } else {
        $.error('Method "' + method + '" does not exist in social plugin');
      }
  
    };
  
    $.fn.share.defaults = {
      popupWidth: 640,
      popupHeight: 528,
      channels: ['facebook', 'linkedin', 'youtube', 'instagram','telegram','viber'],
      itemTriggerClass: 'js-share',
      containerTemplate: function (props) {
        return '<ul class="sharing-providers"></ul>';
      },
  
      itemTemplate: function (props) {
        var iconClasses = {
          'facebook': 'fa fa-facebook',
          'linkedin': 'fa fa-linkedin',
          'youtube': 'fa fa-youtube',
          'instagram': 'fa fa-instagram',
          'telegram': 'fa fa-send',
          'viber': 'fab fa-viber',
        }
  
        // Special handling for email and Google+
        var providerName = props.provider === 'email' ? 'email' : props.provider === 'googleplus' ? 'Google+' : props.provider.charAt(0).toUpperCase() + props.provider.slice(1);
  
        return '<li class="' + props.provider + '">' +
          '<a href="'+ props.href +'" target="_blank"' +
          '<i class="' + iconClasses[props.provider] + '"></i>' +
          '</a>' +
          '</li>';
      }
    };
  
    $.fn.share.settings = {};
    
  
  })(jQuery, window);
  
  
  
  