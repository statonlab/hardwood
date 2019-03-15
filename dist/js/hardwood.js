/**
 * Make elastic search tables display two rows of the last column
 * and allow for a show more button.
 */
(function ($) {
  $(function () {
    var window_height = $(window).height() || 0,
        header_height = $('#navigation').outerHeight() || 0,
        footer_height = ($('#footer').outerHeight() || 0) + ($('.main-footer').outerHeight() || 0);
    $('#main').css('min-height', window_height - (header_height + footer_height) - 30);


    $('#elasticsearch_hits_table tr td:nth-of-type(2)').each(function () {
      var text = $(this).html();
      var array = text.split('<br>');

      if (array.length > 2) {
        var div = $('<div />', {});
        div.append(array.shift() + '<br>' + array.shift());
        var hidden = $('<div />', {'class': 'hidden-hit'}).css('display', 'none');
        hidden.append(array.join('<br>'));
        div.append(hidden);
        div.append('<br>');
        var btn = $('<button />', {
          'type': 'button',
          'class': 'btn btn-secondary btn-sm'
        }).html('Show More')
            .click(function (e) {
              e.preventDefault();

              var hidden_hit = hidden;
              if (hidden_hit.hasClass('is_open')) {
                hidden_hit.removeClass('is_open');
                hidden_hit.slideUp();
                btn.html('Show More');
              }
              else {
                hidden_hit.slideDown();
                hidden_hit.addClass('is_open');
                btn.html('Show Less');
              }
            });
        div.append(btn);
        $(this).html(div);
      }
    });

    // Add table responsive to divs that contain tables as a direct child
    $('div').has('table').last().addClass('table-responsive');

    $('#block-tripal-elasticsearch-website-search-category .es-category-item').each(function () {
      $(this).css('position', 'relative');
      var text = $(this).text().split(' ');
      var num = text.pop();
      text = text.join(' ').split('_').join(' ');
      var span = $('<span />', {'class': 'float-right'}).text(num.replace('(', '').replace(')', ''));
      span.css({
        position: 'absolute',
        right: 0,
        top: 0,
        backgroundColor: '#fff'
      });

      if ($(this).hasClass('active')) {
        $(this).css('color', '#000');
        span.html('<i class="fa fa-check"></i>');
      }
      else {
        span.css({
          backgroundColor: '#e6e6e6',
          borderRadius: 10,
          paddingTop: 2,
          paddingBottom: 2,
          paddingLeft: 7,
          paddingRight: 7,
          fontSize: 12,
          color: '#999'
        });
      }

      $(this).html(text);
      $(this).append(span);
    });

    $('.es-search-form-in-title .btn, .es-search-form-in-home .btn, .elasticsearch-search-input .btn').each(function () {
      var attributes = {};
      for (var i = 0; i < this.attributes.length; i++) {
        attributes[this.attributes[i].nodeName] = this.attributes[i].nodeValue;
      }

      var searchButton = $('<button />', attributes).html('<i class="fa fa-search"></i>');
      $(this).replaceWith(searchButton);
    });

    $('.elasticsearch-search-input .form-control').attr('style', '');

    $(document).on('elasticsearch.completed', function (event) {
      $('.elastic-result-block-footer a').attr('class', 'btn btn-primary');
    });

    $('.tripal_pane').not('.hideTripalPane').each(function () {
      var c = $(this).attr('class');
      var field = c.match(/^tripal_pane-fieldset-(.*$)/) || [];
      if (field.length === 2) {
        $('#' + field[1].split(' ')[0]).addClass('active');
      }
    });

    $(document).on('tripal_ds_pane_expanded', function () {
      if (typeof Event !== 'undefined') {
        window.dispatchEvent(new Event('resize'));
      }
      else {
        // Support IE
        var event = window.document.createEvent('UIEvents');
        event.initUIEvent('resize', true, false, window, 0);
        window.dispatchEvent(event);
      }
    });
  });


  /**
   * Allow dropdown menus to open by hover on bigger devices.
   */


  $(function () {
    $('.navbar .last > .dropdown-menu').addClass('dropdown-menu-right');
    $('.navbar .dropdown > .nav-link').click(function (e) {
      if ($(window).width() > 992) {
        var href = $(this).attr('href');
        if (href !== '#') {
          return window.location.href = href;
        }
      }
    });

    $('.navbar .dropdown').hover(function () {
      if ($(window).width() > 992) {
        $(this).find('.dropdown-menu').fadeIn(100);
      }
    }, function () {
      if ($(window).width() > 992) {
        $(this).find('.dropdown-menu').fadeOut(100);
      }
    });
  });


  /**
   * Re-implement Tripal DS
   */

  $(function () {
    function TripalDS() {
      this.init();
      this.openDefaultPane();
    }

    /**
     * Initiate TripalDS.
     */
    TripalDS.prototype.init = function () {
      var links = $('.tripal_pane-toc-list-item-link');
      var _that = this;

      links.each(function () {
        var id = '.tripal_pane-fieldset-' + $(this).attr('id');
        if ($(id).length === 0) {
          $(this).parents('.views-row').first().remove();
          return;
        }

        if ($(id).children().not('.field-group-format-title').text().trim().length === 0) {
          $(this).parents('.views-row').first().remove();
        }
      });

      links.unbind('click');
      links.on('click', function (e) {
        e.preventDefault();

        // Add active class to the element that was just clicked
        $(this).parents('.ds-left')
            .find('.tripal_pane-toc-list-item-link.active')
            .removeClass('active');
        $(this).addClass('active');

        var pane = $('.tripal_pane-fieldset-' + $(this).attr('id'));
        if (pane.is('.hideTripalPane')) {
          $('.tripal_pane').not('.hideTripalPane').addClass('hideTripalPane');
          pane.removeClass('hideTripalPane');
          var event = $.Event('tripal_ds_pane_expanded');
          $(this).trigger(event);

          var id = $(this).attr('id');
          _that.pushToHistory(id);
          $('input[type="hidden"][name="tripal_pane"]').attr('value', id);
        }
      });
    };

    /**
     * Show the pane that's selected in the url.
     */
    TripalDS.prototype.openDefaultPane = function () {
      var params = this.getURLParameters().filter(function (param) {
        return param.name.toLowerCase() === 'tripal_pane';
      });

      var pane_id = params.length > 0 ? params[0].value : null;

      if (!pane_id) {
        // We are done here
        return;
      }

      // Find the wanted pane and its link
      var $pane_link = $('#' + pane_id);

      if (!$pane_link || $pane_link.length === 0) {
        if (window.console) {
          console.warn('Given pane id does not exist: ' + pane_id + '. Please check the url for more info.');
        }

        return;
      }

      // Disable the active link
      $('.ds-left')
          .find('.tripal_pane-toc-list-item-link.active')
          .removeClass('active');

      // Hide the active pane
      $('.ds-right .showTripalPane').removeClass('showTripalPane').addClass('hideTripalPane');

      // Click the link!
      $pane_link.trigger('click');
    };

    /**
     * Get the URL params
     *
     * @return {Array}
     */
    TripalDS.prototype.getURLParameters = function () {
      // Check browser href for a pane to open
      var params = window.location.search;
      if (params.length > 0) {
        // remove the "?" char
        var qIndex = params.indexOf('?');
        if (qIndex !== -1) {
          params = params.slice(qIndex + 1, params.length);
        }

        // split it into array
        return params.split('&').map(function (param) {
          var broken = param.split('=');
          if (broken.length === 2) {
            return {
              name: broken[0],
              value: broken[1]
            };
          }
          else if (broken.length === 1) {
            return {
              name: broken[0],
              value: null
            };
          }
          else {
            return null;
          }
        });
      }

      return [];
    };

    /**
     * Push the new state to history
     *
     * @param {String} id The id of the pane's link
     */
    TripalDS.prototype.pushToHistory = function (id) {
      var params = this.getURLParameters();
      var added = false;
      for (var i = 0; i < params.length; i++) {
        if (params[i] && params[i].name === 'tripal_pane') {
          params[i].value = id;
          added = true;
        }
      }

      if (!added) {
        params.push({
          name: 'tripal_pane',
          value: id
        });
      }

      var query = [];
      for (i = 0; i < params.length; i++) {
        var param = params[i];
        query.push(param.name + '=' + param.value);
      }

      query = query.join('&');

      if (window.history) {
        var state = window.history.state;
        var title = document.title;
        var path = window.location.pathname;
        window.history.replaceState(state, title, path + '?' + query);
      }
    };

    return new TripalDS();
  });

  $(function () {
    $('.help-button-trigger').click(function (e) {
      e.preventDefault();

      var parent = $(this).parents('.help-button-block').first();
      var content = parent.find('.help-button-content');

      if (parent.hasClass('open')) {
        content.slideUp(function () {
          parent.removeClass('open');
        });

        return;
      }

      parent.addClass('open');
      content.slideDown();
    });
  });

  $(function () {
    let opened = init();

    if (!opened) {
      $('#open-survey-modal').fadeIn();
    }


    function init() {
      var ds = window.localStorage;
      // ds.removeItem('hardwoods.survey');

      if (!ds) {
        return false;
      }

      $('#open-survey-modal').click(function () {
        $('#survey-modal').modal('show');
        $(this).fadeOut();
      });

      $('#give-feedback-btn').click(function () {
        $('#survey-modal').modal('hide');
      });

      $('#survey-modal').on('hide.bs.modal', function () {
        ds.setItem('hardwoods.survey', (new Date()).valueOf());
        $('#open-survey-modal').fadeIn();
      });

      var item = ds.getItem('hardwoods.survey');
      // 30 days
      var seconds = 1000 * 60 * 60 * 60 * 24 * 30;
      if (item) {
        item = parseInt(item);

        if ((new Date()).valueOf() > (item + seconds)) {
          ds.removeItem('hardwoods.survey');
        }
        else {
          return false;
        }
      }

      setTimeout(function () {
        $('#survey-modal').modal('show');
      }, 1000);
      return true;
    }

    // function fix_styling($item) {
    //   if ($item.children().length > 0) {
    //     $item.children().each(function () {
    //       fix_styling($(this));
    //     });
    //   }
    //   else {
    //     $item.html($item.html().replace(/_/g, '_<wbr>'));
    //   }
    // }
    //
    // $('td, th').each(function () {
    //   var $this = $(this);
    //   if ($this.text().length > 40) {
    //     $this.children().each(function () {
    //       fix_styling($(this));
    //     });
    //   }
    // });
  });
})(jQuery);
