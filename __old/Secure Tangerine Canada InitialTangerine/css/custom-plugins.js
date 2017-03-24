// Silence errors for browsers that don't have console
// ---------------------------------------------------
+ function(root) {
  if (!root.console) {
    root.console = {}
    root.console.log = function() {}
    root.console.clear = function() {}
  }
}(this)

// Collapse Plugin Override
// ------------------------
!function($) {

  'use strict'; // jshint ;_;

  if ($('html').hasClass('touch')) {
      // TQA00351872
      // Description: Inconsistent collapse functionality when listening for touch events using BB device
      // Solution: fallback to click events for BB devices
      var isBB = window.navigator.userAgent.indexOf('BB10') !== -1 && window.navigator.userAgent.indexOf('Mobile') !== -1,
      touchEvent = isBB ? 'click.collapse.data-api' : 'touchend.collapse.data-api click.collapse.data-api'

      // TQA00354868
      // Desciption: collapse plugin applied to checkboxes don't work correctly on touch devices
      // Solution: seperate functionality from checkboxes to listen to change events instead
      ,
      collapse = function (evt, ref) {
        // TQA00356540
        evt.preventDefault()
        var $this = $(ref || this)
        , href
        , target = $this.attr('data-target') || evt.preventDefault() || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') //strip for ie7
        , option = $this.data('toggle') ? 'toggle' : $this.data()

        $this[$(target).height() !== 0 ? 'addClass' : 'removeClass']('collapsed') // TQA00394990
        $(target).collapse(option)
      }

      // TQA00350767
      // Description: Style-Left Hand Navigation doesn't appear (note: Clicks not registered, (or registered on a third time only), on the items in the left-hand sliding nav menu.)
      // Solution: Removed touch tolerance check
      // ------------------------------------------
      $(document)
      .off('click.collapse.data-api', '[data-toggle=collapse]')
      .on(touchEvent, '[data-toggle=collapse]', function (evt) {
        if (evt.target.nodeName === 'INPUT') {
          return
        }
        collapse(evt, this)
      })
      .on('change', 'input[data-toggle=collapse]', collapse)
    }

  // Handles double clicks on checkboxes, with attached collapse plugin (good catch wlew!)
  // -------------------------------------------------------------------------------------
  $(document)
  .on('dblclick.collapse.data-api', 'input[data-toggle=collapse]', function (evt) {
    this.checked = !this.checked
  })
  // .on('show hide', $('input[data-toggle=collapse]').data('target'), function (evt) {
    .on('show.collapse.data-api hide.collapse.data-api', $('input[data-toggle=collapse]').data('target'), function (evt) {
      $('[data-target="#' + evt.target.id + '"]').attr('disabled', 'disabled')
    })
  // .on('shown hidden', $('input[data-toggle=collapse]').data('target'), function (evt) {
    .on('shown.collapse.data-api hidden.collapse.data-api', $('input[data-toggle=collapse]').data('target'), function (evt) {
      $('[data-target="#' + evt.target.id + '"]').attr('disabled', null)
    })

  }(window.jQuery)

// Custom Modal Override & dynamic creation of modal windows
// ---------------------------------------------------------
!function($) {

  'use strict'; // jshint ;_;


  var Modal = function(element, options) {
    this.options = options
    this.$element = $(element)
    .delegate('[data-dismiss="modal"]', 'click.dismiss.modal', $.proxy(this.hide, this))
    this.options.remote && this.$element.find('.modal-container').load(this.options.remote)
  }
  , defaults = $.fn.modal.defaults

  Modal.prototype = $.fn.modal.Constructor.prototype

  $.fn.modal = function(option) {
    return this.each(function() {
      var $this = $(this)
      , data = $this.data('modal')
      , options = $.extend({}, defaults, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('modal', (data = new Modal(this, options)))
        if (typeof option == 'string') data[option]()
          else if (options.show) data.show()
        })
  }

  $.fn.modal.Constructor = Modal

  var $this, targetID, modal, modalContainer, fireTrackingCode = function(evt, xhr, settings) {
    if (!/command=/.test(settings.url)) {
      return
    }
    var path = settings.url
    , title = path.slice(path.indexOf('command=') + 8)

    window.ga && ga('send', 'pageview', path)
    window.dcsMultiTrack && dcsMultiTrack('DCS.dcsuri', path, 'WT.ti', title)
  }

    // Modal window auto-generation
    // ----------------------------
    $('[data-toggle=modal]').each(function() {
      $this = $(this)
      targetID = $this.data('target').replace('#', '')
      modal = document.createElement('div')
      modalContainer = document.createElement('div')
      $(modalContainer)
      .addClass('modal-container')
      .append('<div class="loader"></div>')

      $(modal)
      .attr({
        'id': targetID
        , 'class': 'modal hide fade'
        , 'tabindex': '-1'
        , 'role': 'dialog'
        , 'aria-hidden': 'true'
      })
      .append(modalContainer)
      .appendTo(document.body)
    })

  // Modal window tracking
  // ---------------------
  $(document).ajaxComplete(function(evt, xhr, settings) {
    $(this).on('shown', '.modal', function() {
      fireTrackingCode(evt, xhr, settings)
    })
  })


  // TQA00394992
  // -----------
  $(document)
  .on('show', '.modal', function () {
    $('body').addClass('modal-open')
  })
  .on('hidden', '.modal', function () {
    $('body').removeClass('modal-open')
  })

}(window.jQuery)


// Enable tooltips
// ---------------
!function($) {

  'use strict'; // jshint ;_;

  var $tooltip = $('[data-toggle=tooltip]')

  if ($('html').hasClass('touch')) {
    $tooltip.each(function(index) {
      if (/input|select|textarea/i.test(this.nodeName) || $(this).hasClass('btn') || $(this).hasClass('btn-group') || $(this).parent().hasClass('btn')) { // do not show modal tooltip when tooltip is applied to input fields or buttons
        return
      }

      var modal = document.createElement('div')
      , modalContainer = document.createElement('div')
      , modalBody = document.createElement('div')
      , modalFooter = document.createElement('div')
      , text = document.createElement('p')
      , closeBtn = document.createElement('button')

      text.innerHTML = this.getAttribute('title') || this.getAttribute('data-title')

      $(closeBtn)
      .addClass('btn btn-primary')
      .attr('data-dismiss', 'modal')
      .html('&#10006;')

      modalContainer.className = 'modal-container'

      modalBody.appendChild(text)
      modalBody.className = 'modal-body'

      modalFooter.appendChild(closeBtn)
      modalFooter.className = 'modal-footer'

      modalContainer.appendChild(modalBody)
      modalContainer.appendChild(modalFooter)

      $(modal)
      .attr({
        'id': 'tooltip-modal-' + index
        , 'class': 'modal hide fade'
        , 'tabindex': '-1'
        , 'role': 'dialog'
        , 'aria-hidden': 'true'
      })
      .append(modalContainer)
      .appendTo(document.body)
      $(this).on('click', function() {
        $('#tooltip-modal-' + index).modal('show')
      })
    })
} else {
  $tooltip.each(function() {
    var options = $.extend({
      placement: 'right'
      , trigger: 'hover focus'
      , container: 'body'
    }, $(this).data())

    $(this).tooltip(options)
  })
}

}(window.jQuery)

// slide-out navigation - @snypelife
// ---------------------------------
!function($) {

  'use strict'; // jshint ;_;

  var isOpen = false
  , windowWidth = $(window).width()
  , $view = $('.view')
  , $popoutnav = $('#popout-nav')
  , togglePopoutNav = function (evt, target) {
    isOpen = $popoutnav.hasClass('open')

    if ((evt.target.id !== 'mobile-btn-open-nav' && evt.target.parentNode.id !== 'mobile-btn-open-nav') && evt.target.id !== 'mobile-overlay') {
      return
    }
    if (evt.target.id === 'mobile-overlay' && !isOpen) {
      return
    }

    evt.preventDefault()

    var $this = target ? $(target) : $(evt.target)
    if (!isOpen) {
      $('.menu-wrapper').scrollTop(0)
      $view.on('touchstart.popoutnav click.popoutnav', function (evt) { evt.preventDefault() })
    } else {
      $view.off('touchstart.popoutnav click.popoutnav')
    }

    $popoutnav.toggleClass('open')
    $('#mobile-overlay').toggleClass('is-active')
  }

  , onRotate = function (evt) {
    switch (window.orientation) {
      case 90:
      case -90:
      (windowWidth > 767) && $popoutnav.hasClass('open') && $('.view').off('touchstart.popoutnav click.popoutnav')
      $('#mobile-overlay').addClass('is-hidden')
      break
      default:
      if ($popoutnav.hasClass('open')) {
        $('#mobile-overlay').removeClass('is-hidden')
        $('.view').on('touchstart.popoutnav click.popoutnav', function (evt) { evt.preventDefault() })
      }
      break
    }
  }

  $('<div class="mobile-overlay" id="mobile-overlay"></div>').appendTo('.frame')

  $(document)
  .on('touchend.popoutnav click.popoutnav', togglePopoutNav)
  .on('orientationchange', onRotate)

}(window.jQuery)


// dropdown to select box plugin
// -----------------------------
!function() {

  var $dropdownMenu = $('[data-toggle="dropdown"]').siblings('.dropdown-menu'),
  caret = '&nbsp;<span class="icon-caret-down"></span>',
  setupSelect = function() {
    if ($(this).siblings('select')[0]) {
      return
    }

    var select = document.createElement('select'),
    defaultOption = document.createElement('option'),
    $initializer = $(this).siblings('[data-toggle="dropdown"]'),
    defaultValue = $initializer.data('default'),
    resetCollapse = function(evt) {
      var target, $target
      for (var i = 0; i < this.options.length; i++) {
        target = this.options[i].getAttribute('data-target')
        $target = $(target)
        if (this.options[i].value === this.value) {
          if ($target.hasClass('collapse')) {
            $($this.data('target')).collapse('show')
          } else if ($target.hasClass('collapse-alt')) {
            $($this.data('target')).show()
          } else if ($target.hasClass('tab-pane')) {
            $(this).attr('data-target', target).tab('show')
          }
        } else {
          $target.hasClass('collapse') && $target.hasClass('in') && $target.collapse('hide')
        }
      }
      $(this).trigger('updated.dropdown')
    }

    if (!$initializer.data('name')) {
      return
    }

    select.className = 'hidden-desktop'
    select.name = $initializer.data('name')
    select.id = select.name
    select.size = 1

    defaultOption.text = $initializer.text()
    defaultOption.value = defaultValue || ''
    select.appendChild(defaultOption)
    $(select).attr('data-rules', $initializer.data('rules'))

    $(this).find('li').each(function() {
      var option = document.createElement('option')
      option.text = $(this).find('a').text()
      option.value = $(this).find('a').data('value')
      $(option).attr('data-target', $(this).find('a').data('target'))

      select.appendChild(option)
    })

    $(select).on('change', resetCollapse)

    $(this).parents('.btn-group').append(select)
  }, updateDropDown = function(evt) {
    evt.preventDefault()

    var $this = $(this),
    target = $this.data('target'),
    resetCollapse = function() {
      $this
      .parents('.dropdown-menu')
      .find('a')
      .each(function() {
        if (!$(this).data('target')) {
          return
        }

        $($(this).data('target')).each(function() {
          toggle(this, 'hide')
        })
        $(this).parent().removeClass('active')
      })
    }, toggle = function(self, action) {
      if (typeof action !== 'string') {
        throw 'TypeError'
      }
      if ($(self).hasClass('collapse')) {
        $(self).collapse(action)
      } else if ($(self).hasClass('collapse-alt')) {
        $(self)[action]()
      } else if ($(self).hasClass('tab-pane')) {
        $this.tab('show')
      }
    }

    $this
    .parents('.dropdown-menu')
    .siblings('[data-toggle="dropdown"]')
    .text($this.text())
        .append(caret) //update dropdown

        $this
        .parents('.dropdown-menu')
        .siblings('select')
        .val($(evt.target).data('value')) //update hidden select box
        .trigger('updated.dropdown')

        if (target) {
          resetCollapse()
          $(target).each(function() {
            toggle(this, 'show')
          })
        } else {
          $($(this).parent().siblings().find('[data-target]').data('target')).each(function() {
          ($(this).hasClass('in') || $(this).is(':visible')) && toggle(this, 'hide')
        })
        }
      }

      $dropdownMenu.each(setupSelect)

      $('[data-toggle="dropdown"]').siblings('.dropdown-menu')

      $(document).on('click.dropdown', '[data-toggle="dropdown"] + .dropdown-menu a', updateDropDown)

      $('.modal').on('shown', function() {
        $(this).find($('[data-toggle="dropdown"]').siblings('.dropdown-menu')).each(setupSelect)
      })

  // TQA00354384
  // -----------
  $(document).on('change.dropdown', '[data-toggle="dropdown"] ~ select', function(evt) {
    $(this).trigger('updated.dropdown')
    $(this).siblings('.dropdown-menu').find('[data-value=' + $(this).val() + ']').trigger('click.dropdown')
  })
}(window.jQuery)


// Bootstrap Radio Button Group - plugin for form hookup
// -----------------------------------------------------
!function($) {

  'use strict'; // jshint ;_;

  var radioButtonSelector = '[data-toggle=buttons-radio]'

  ,
  radioBtnGroupHookup = function(evt) {
    if (evt.target && evt.target.getAttribute('disabled') === 'disabled') {
      return
    }
    if (this.getAttribute('disabled') && !this.getAttribute('data-name') && !this.getAttribute('data-default') && !typeof evt !== 'number') {
      return
    }

    var $this = $(this),
    hiddenEl, hiddenSelector = '[name=' + $this.data('name') + ']',
    options = {
      name: $this.data('name'),
          'default': $this.data('default') // using object string property because of IE8 bug
        }

        , setupHidden = function(options) {
          var hidden = document.createElement('input')
          hidden.type = 'hidden'
          hidden.id = options.name
          hidden.name = options.name
          hidden.value = options['default'] || '' // using array notation because of IE8 bug
          $(hidden).attr('data-rules', $this.data('rules'))

          return hidden
        }

        , updateHidden = function(target) {
          $(hiddenSelector).val($(target).data('value'))
          .trigger('change')
          $this.trigger('updated.button.data-api')
        }

        !$this.find(hiddenSelector)[0] && $this.append(hiddenEl = setupHidden(options))

        evt.target && updateHidden(evt.target)
      }, modalSetup = function(evt) {
        var $this = $(this),
        $btnRadio = $this.find(radioButtonSelector)

        if ($btnRadio[0]) { // Check if BS radio are available, if so hook them up to form and exit out
          $btnRadio.each(radioBtnGroupHookup)
          return
        }

      $(document).ajaxSuccess(function(evt, xhr, settings) { //Listen for successful ajax event then setup BS radios
        $this.find(radioButtonSelector).each(radioBtnGroupHookup)
      })
    }

    // Fire initial setup for all available bootstrap radios
    // -----------------------------------------------------
    $(radioButtonSelector).each(radioBtnGroupHookup)


  // Event listeners
  // ---------------
  $(document).on('click.button.data-api', radioButtonSelector, radioBtnGroupHookup)
  $(document).on('show', '.modal', modalSetup)

}(window.jQuery)


// Bootstrap Radio Button Group - plugin for collapse/tab hookup
// -------------------------------------------------------------
!function($) {

  'use strict'; // jshint ;_;

  $('[data-toggle=buttons-radio]').on('click', function(evt) {
    var target = this.getAttribute('data-target') || evt.target,
    value = evt.target.getAttribute('data-value'),
    method = this.getAttribute('data-target') !== null ? 'collapse' : 'tab',
    _default = this.getAttribute('data-default'),
    trigger = this.getAttribute('data-trigger'),
    compareValues, showHide = function() {
      if ($(target).hasClass('collapse-alt')) {
        $(target)[compareValues ? 'slideDown' : 'slideUp']()[compareValues ? 'addClass' : 'removeClass']('in')
      } else {
        $(target)[method](method === 'collapse' ? (compareValues ? 'show' : 'hide') : 'show')
      }
    }

    if (!target || evt.target.getAttribute('disabled') === 'disabled' || $(evt.target).hasClass('active')) {
      return
    }

    if (_default) {
      compareValues = !$(target).hasClass('in') // check to see if collapsible area is hidden and use that bool to determine whether to open/close
      //compareValues = value.toLowerCase() !== _default.toLowerCase()

      showHide()
    } else if (trigger) {
      compareValues = value.toLowerCase() === trigger.toLowerCase()

      if ($(target).height() === 0 && !compareValues) {
        return
      }

      showHide()
    } else { // default to tab
      $(target).tab('show')
    }

  })
}(window.jQuery)


// Bootstrap Autocomplete (i.e. Typeahead) - plugin for form hookup
// ----------------------------------------------------------------
!function($) {

  'use strict'; // jshint ;_;

  var library = {}

  , createHiddenLink = function(evt) {
    var $this = $(this),
    $hiddenEl = document.createElement('input')
    $hiddenEl.type="hidden"
    $hiddenEl.value=($this.data('default') || '')
    $hiddenEl.name=$this.data('name')
    $hiddenEl.id=$this.data('name')

    $this
    .parent()
    .append($hiddenEl)
  }

  , updateHidden = function(item) {
    var value = library[item.toUpperCase()]
    $('#' + this.$element.data('name')).val(value)
    this.$element.trigger('updated.autocomplete.data-api', [item, value])

    return item
  }

  , populateAutocomplete = function() {
    var $this = $(this),
    dataSource = $this.data('source').split('|'),
    source = [],
    ruleMap = $this.data('rules'),
    rules = {}, rule = []

    for (var i = 0; i < dataSource.length; i++) {
      dataSource[i] = dataSource[i].split(':')
      library[dataSource[i][0]] = $.trim(dataSource[i][1])
      // source.push(dataSource[i][0].toProperCase())
      if ($this.attr("id")=="StreetType") {
          source.push(dataSource[i][0])
        }
      else {
        source.push(dataSource[i][0].toProperCase())
      }

    }

    if (ruleMap) {
      ruleMap = ruleMap.split(',')
      for (var i = 0; i < ruleMap.length; i += 1) {
        rule = ruleMap[i].split(':')
        rules[rule[0]] = rule[1]
      }

      var list = source.join('|').replace(/,/g, '+').replace(/[\|]/g, ',').split(',')
      for (var i = 0; i < list.length; i++) {
        list[i] = list[i].replace(/[\+]/g, ',')
      }

      rules.list = list

      $this.trigger('updated.validation.rules', [rules])
    }

    $this
    .typeahead({
      items: 10,
      minLength: $this.data('min-length') || 3,
      source: source,
      updater: updateHidden
    })
  }

  String.prototype.toProperCase = function() {
    return this.toLowerCase().replace(/^(.)|\s(.)/g,
      function($1) {
        return $1.toUpperCase()
      })
  }

  $('[data-toggle=autocomplete]').each(createHiddenLink)

  $(document)
  .on('focus.autocomplete.data-api', '[data-toggle=autocomplete]', populateAutocomplete)

  .on('shown.modal.data-api', '.modal', function () {
    $(this)
    .find('[data-toggle=autocomplete]')
    .each(createHiddenLink)
    .on('focus.autocomplete.data-api', populateAutocomplete)
  })

}(window.jQuery)


// Custom province autocomplete
//  - dynamically linked to specified country autocomplete
// -------------------------------------------------------
!function($) {

  'use strict'; // jshint ;_;


  var dataLibrary = {}, chosenCountry

  , setProvState = function($el) {
    var $hiddenEl = document.createElement('input')
    $hiddenEl.type="hidden"
    $hiddenEl.value=($el.data('default') || '')
    $hiddenEl.name=$el.data('name')
    $hiddenEl.id=$el.data('name')

    $el.parent().append($hiddenEl)
  }

  , getProvStateData = function(query, process) {
    var dataSource = this.$element.data('source').split('|'),
    parsedSource = [],
    ruleMap = this.$element.data('rules'),
    rules = {}, rule

    chosenCountry = $('#' + $(this.$element.data('dependency')).data('name')).val()

    for (var i = 0; i < dataSource.length; i++) {
      var map = $.trim(dataSource[i]).slice(3).split(':')

      if (!dataLibrary[dataSource[i].slice(0, 2)]) {
        dataLibrary[dataSource[i].slice(0, 2)] = {}
      }

      dataLibrary[dataSource[i].slice(0, 2)][$.trim(map[0])] = $.trim(map[1])

      if (dataSource[i].slice(0, 2).toUpperCase() === chosenCountry.toUpperCase()) {
        parsedSource.push(map[0].toProperCase())
      }
    }

    if (ruleMap) {
      ruleMap = ruleMap.split(',')
      for (var i = 0; i < ruleMap.length; i += 1) {
        rule = ruleMap[i].split(':')
        rules[rule[0]] = rule[1]
      }
        //rules = eval('({' + rules + '})')

        var list = parsedSource.join('|').replace(/,/g, '+').replace(/[\|]/g, ',').split(',')
        for (var i = 0; i < list.length; i++) {
          list[i] = list[i].replace(/[\+]/g, ',')
        }

        rules.list = list

        this.$element.trigger('updated.validation.rules', [rules])
      }

      process(parsedSource)
    }

    , applyAutocomplete = function() {
      var $provState = $(this),
      $hiddenEl = $('#' + $provState.data('name'))

      ,
      updateHidden = function(item) {
        $hiddenEl.val(dataLibrary[chosenCountry][item.toUpperCase()])
        return item
      }

      $provState.typeahead({
        items: 10,
        minLength: $provState.data('min-length') || 2,
        source: getProvStateData,
        updater: updateHidden
      })
    }

    , clearProvState = function(evt, item, value) {
      var $provState = $('[data-dependency=#' + evt.target.id + ']'),
      $hiddenEl = $('#' + $provState.data('name'))
      $provState.attr('disabled', (value === 'CA' || value === 'US') ? null : 'disabled')

      $provState.val('')
      $hiddenEl.val('')
    }

    , showPostalcode = function(evt, item, value) {
      var $postalCA = $('[data-postal="CA"]'),
      $postalUS = $('[data-postal="US"]'),
      $postalOther = $('[data-postal="Others"]')

      if (value === 'CA') {
        $postalCA.show()
        $postalUS.hide()
        $postalOther.hide()
      } else if (value === 'US') {
        $postalCA.hide()
        $postalUS.show()
        $postalOther.hide()
      } else {
        $postalCA.hide()
        $postalUS.hide()
        $postalOther.show()
      }
    }

    $('[data-autocomplete=province]')
    .on('focus.autocomplete.data-api', applyAutocomplete)
    .each(function() {
      setProvState($(this))
      $($(this).data('dependency')).on('updated.autocomplete.data-api', clearProvState)
      $($(this).data('dependency')).on('updated.autocomplete.data-api', showPostalcode)
      $('[data-postal="US"]').hide()
      $('[data-postal="Others"]').hide()
    })



  }(window.jQuery)

// Injector plugin - used to swap out current iframe implementation
// ----------------------------------------------------------------
!function($) {

  'use strict'; // jshint ;_;

  var Injector = function(element, options) {
    this.$element = $(element)
    this.options = $.extend({}, $.fn.injector.defaults, options)
  }

  Injector.prototype.inject = function() {
    var $el = this.$element
    $.support.cors = true
    if (this.options.remote === '' || this.options.remote === '') {
      return
    }
    else {
      $el.load(this.options.remote, function() {
        $el.trigger('injected')
      })
    }
  }

  // Injectir plugin definition
  // --------------------------
  var old = $.fn.injector

  $.fn.injector = function() {
    return this.each(function() {
      var $this = $(this),
      data = new Injector(this, $this.data())

      data.inject()
    })
  }

  $.fn.injector.defaults = {}

  $.fn.injector.Constructor = Injector


  // Injector no conflict
  // --------------------

  $.fn.injector.noConflict = function() {
    $.fn.injector = old
    return this
  }


  // Injector data-api
  // -----------------
  $(function() {
    $('[data-toggle=injector]').injector()
    $(document)
    .on('injected', '[data-toggle=injector]', function(evt) {
      if (!$(this).data('injected')) {
        $(this).find('[data-toggle=injector]').injector()
        $(this).data('injected', true)
      }
    })
  })

}(window.jQuery)


// Sticky popup footer - @snypelife
// --------------------------------
!function($) {

  'use strict'; // jshint ;_;

  var $footer = $('.footer'),
  $footerBody = $('#footer-body'),
  footerHeight = $footerBody.height(),
  closedHeight = 0,
  $window = $(window),
  $document = $(document),
  $content = $('.content'),
  onClick = function (evt) {
    evt.preventDefault()
    $footer.toggleClass('open').trigger($footer.hasClass('open') ? 'open.footer' : 'closed.footer')
    $footerBody.css('height', $footer.hasClass('open') ? footerHeight : closedHeight)
  },
  tabletCheck = function () {
    return window.matchMedia && window.matchMedia("(min-width: 767px) and (max-width: 979px)").matches
  },
  viewportCheck = function () {
    return $window.height() > ($('.mobile-header-top').outerHeight(true) + $content.outerHeight(true) + $footer.outerHeight(true))
  },
  stickFooter = function (evt) {
    $content
    .css({
    'height': '100%',
    'margin-bottom': -($('.footer').height() + $('.mobile-header-top').outerHeight(true))
    })
  },
  unstickFooter = function () {
    $content
    .css({
    'height': null,
    'margin-bottom': null
    })
  }

  $footerBody.css('height', closedHeight)
  $footer.addClass('navbar-fixed-bottom')
  $document.on('touchend.stickyfooter click.stickyfooter', '.footer-see-more', onClick)

  $window.on('orientationchange.stickyfooter resize.stickyfooter', function (evt) {
    if (tabletCheck() && viewportCheck()) {
      $document.on('transitionend.stickyfooter', stickFooter)
    } else {
      $document.off('transitionend.stickyfooter', stickFooter)
      unstickFooter()
    }
  })

  if (tabletCheck() && viewportCheck()) {
    stickFooter()
  }
}(window.jQuery)

/*!
 *  jQuery Smart Banner
 *  Copyright (c) 2012 Arnold Daniels <arnold@jasny.net>
 *  Based on 'jQuery Smart Web App Banner' by Kurt Zenisek @ kzeni.com
 *  Edits by: @snypelife <brettmrogerson@gmail.com>
 */
 !function($) {

  'use strict'; // jshint ;_;

  var SmartBanner = function(options) {
    this.origHtmlMargin = parseFloat($('html').css('margin-top')) // Get the original margin-top of the HTML element so we can take that into account
    this.options = $.extend({}, $.smartbanner.defaults, options)
    this.tap = 'touchend.smart-banner click.smart-banner'

    var standalone = navigator.standalone // Check if it's already a standalone web app or running within a webui view of an app (not mobile safari)
      , UA = navigator.userAgent

    // Detect banner type (iOS or Android)
    if (this.options.force) {
      this.type = this.options.force
    }
    else if (UA.match(/iPad|iPhone|iPod/i) != null) {
      if (UA.match(/Safari/i) != null && (UA.match(/CriOS/i) != null || window.Number(UA.substr(UA.indexOf('OS ') + 3, 3).replace('_', '.')) < 6)) {
        this.type = 'ios' // Check webview and native smart banner support (iOS 6+)
      }
    }
    else if (UA.match(/Android/i) != null) {
      this.type = 'android'
    } else if (UA.match(/Windows NT 6.2/i) != null && UA.match(/Touch/i)) { // look only for win8 touch devices
      this.type = 'windows'
    }

    // Don't show banner if device isn't iOS or Android, website is loaded in app or user dismissed banner
    if (!this.type || standalone || this.getCookie('sb-closed') || this.getCookie('sb-installed')) {
      return
    }

    // Calculate scale
    this.scale = this.options.scale == 'auto' ?
                 $(window).width() / window.screen.width :
                 this.options.scale

    if (this.scale < 1) {
      this.scale = 1
    }

    // Get info from meta data
  var meta = $(this.type === 'android' ? 'meta[name="google-play-app"]' :
               this.type === 'ios' ? 'meta[name="apple-itunes-app"]' :
               'meta[name="msApplication-ID"]');

  if (meta.length === 0) return

    // For Windows Store apps, get the PackageFamilyName for protocol launch
  if (this.type === 'windows') {
    return; // @snypelife --> Windows app will not be available at launch, when it is remove this line
    this.pfn = $('meta[name="msApplication-PackageFamilyName"]').attr('content');
    this.appId = meta.attr('content')[1]
  } else {
    this.appId = /app-id=([^\s,]+)/.exec(meta.attr('content'))[1]
  }

  this.title = this.options.title ? this.options.title : $('title').text().replace(/\s*[|\-·].*$/, '')
  this.author = this.options.author ? this.options.author :
                ($('meta[name="author"]').length ? $('meta[name="author"]').attr('content') :
                 window.location.hostname)

    // Create banner
    this.create()
    this.show()
    this.listen()
  }

  SmartBanner.prototype = {
    constructor: SmartBanner

  , create: function() {
      // https://itunes.apple.com/ca/app/tangerine-mobile-banking/id
      // https://play.google.com/store/apps/details?id=
      var iconURL
        , link = (this.options.url ? this.options.url :
                 (this.type === 'windows' ? 'ms-windows-store:PDP?PFN=' + this.pfn :
                 (this.type === 'android' ? 'market://details?id=' :
                 'https://itunes.apple.com/' + this.options.appStoreLanguage + '/app/id')) + this.appId)
        , inStore = this.options.price ? this.options.price + ' - ' +
                    (this.type === 'android' ? this.options.inGooglePlay :
                    this.type === 'ios' ? this.options.inAppStore :
                    this.options.inWindowsStore) : ''
        , gloss = this.options.iconGloss === null ? (this.type === 'ios') : this.options.iconGloss

      $('.view').prepend('<div id="smartbanner" class="smartbanner ' + this.type + '">' +
                          '<div class="sb-container">' +
                            '<a href="#" class="sb-close">&times;</a>' +
                            '<span class="sb-icon"></span>' +
                            '<div class="sb-info">' +
                              '<strong>' + this.title + '</strong>' +
                              '<span>' + this.author + '</span>' +
                              '<span>' + inStore + '</span>' +
                            '</div>' +
                            '<a href="' + link + '" class="sb-button">' +
                              '<span>' + this.options.button + '</span>' +
                            '</a>' +
                          '</div>' +
                         '</div>')

      if (this.options.icon) {
        iconURL = this.options.icon
      }
      else if ($('link[rel="apple-touch-icon-precomposed"]').length > 0) {
        iconURL = $('link[rel="apple-touch-icon-precomposed"]').attr('href')
        if (this.options.iconGloss === null) {
          gloss = false
        }
      }
      else if ($('link[rel="apple-touch-icon"]').length > 0) {
        iconURL = $('link[rel="apple-touch-icon"]').attr('href')
      }
      else if ($('meta[name="msApplication-TileImage"]').length > 0) {
        iconURL = $('meta[name="msApplication-TileImage"]').attr('content')
      }
      // redundant because ms docs show two case usages
      else if ($('meta[name="msapplication-TileImage"]').length > 0) {
        iconURL = $('meta[name="msapplication-TileImage"]').attr('content')
      }

      if (iconURL) {
        $('#smartbanner .sb-icon').css('background-image', 'url(' + iconURL + ')')
        if (gloss) {
          $('#smartbanner .sb-icon').addClass('gloss')
        }
      } else {
        $('#smartbanner').addClass('no-icon')
      }

      this.bannerHeight = $('#smartbanner').outerHeight() + 2

      if (this.scale > 1) {
        $('#smartbanner').css({
          'top': parseFloat($('#smartbanner').css('top')) * this.scale
        , 'height': parseFloat($('#smartbanner').css('height')) * this.scale
        })

        $('#smartbanner .sb-container').css({
          '-webkit-transform': 'scale(' + this.scale + ')'
        , '-msie-transform': 'scale(' + this.scale + ')'
        , '-moz-transform': 'scale(' + this.scale + ')'
        , 'width': $(window).width() / this.scale
        })

      }
    }

  , listen: function() {
      $('#smartbanner .sb-close').on(this.tap, $.proxy(this.close, this))
      $('#smartbanner .sb-button').on(this.tap, $.proxy(this.install, this))
    }

  , show: function (callback) {
      /*$('#smartbanner')
              .stop()
              .animate({top:0},this.options.speedIn)
              .addClass('shown')
            $('html').animate({
                marginTop: this.origHtmlMargin + (this.bannerHeight * this.scale)
              }
              , this.options.speedIn
              , 'swing'
              , callback)*/
    }

  , hide: function (callback) {
      /*$('#smartbanner').stop().css({
                height: 0//-1 * this.bannerHeight * this.scale
              }
              , this.options.speedOut)*/
      $('#smartbanner')
      .collapse('hide')
      .on('hidden', function() {
        $(this).addClass('hidden')
      })
            //.addClass('is-hidden')
            //.removeClass('shown')
            /*$('html').animate({
                      marginTop: this.origHtmlMargin
                    }
                    , this.options.speedOut
                    , 'swing'
                    , callback)*/
    }

  , close: function (evt) {
      evt.preventDefault()
      this.hide()
      this.setCookie('sb-closed', 'true', this.options.daysHidden)
    }

  , install: function () {
    this.hide()
    this.setCookie('sb-installed', 'true', this.options.daysReminder)
  }

  , setCookie: function (name, value, exdays) {
    var exdate = new Date()
    exdate.setDate(exdate.getDate() + exdays)
    value = escape(value) + ((exdays == null) ? '' : '; expires=' + exdate.toUTCString())
    document.cookie = name + '=' + value + '; path=/;'
  }

  , getCookie: function (name) {
    var i, x, y, ARRcookies = document.cookie.split(";")
    for (i = 0; i < ARRcookies.length; i++) {
      x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="))
      y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1)
      x = x.replace(/^\s+|\s+$/g, "")
      if (x == name) {
        return unescape(y)
      }
    }
    return null
  }
}

$.smartbanner = function(option) {
  var $window = $(window),
  data = $window.data('typeahead'),
  options = typeof option == 'object' && option
  if (!data) $window.data('typeahead', (data = new SmartBanner(options)))
    if (typeof option == 'string') data[option]()
  }

  // override these globally if you like (they are all optional)
  $.smartbanner.defaults = {
    title: null // What the title of the app should be in the banner (defaults to <title>)
  , author: null // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
  , price: 'FREE' // Price of the app
  , appStoreLanguage: 'ca' // Language code for App Store
  , inAppStore: 'On the App Store' // Text of price for iOS
  , inGooglePlay: 'In Google Play' // Text of price for Android
  , inWindowsStore: 'In the Windows Store' //Text of price for Windows
  , icon: null // The URL of the icon (defaults to <meta name="apple-touch-icon">)
  , iconGloss: null // Force gloss effect for iOS even for precomposed
  , button: 'View' // Text for the install button
  , url: null // The URL for the button. Keep null if you want the button to link to the app store.
  , scale: 'auto' // Scale based on viewport size (set to 1 to disable)
  , speedIn: 300 // Show animation speed of the banner
  , speedOut: 400 // Close animation speed of the banner
  , daysHidden: 15 // Duration to hide the banner after being closed (0 = always show banner)
  , daysReminder: 90 // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
  , force: null // Choose 'ios', 'android' or 'windows'. Don't do a browser check, just always show this banner
  }

  $.smartbanner.Constructor = SmartBanner

  $(function() {
    $.smartbanner({
      // TQA350884
      // Defect: Smartbanner always appears
      // Solution: set days to be hidden when closed and viewed to be higher than 0
      // --------------------------------------------------------------------------
      daysHidden: 14,
      daysReminder: 30,
      scale: 1,
      title: 'Tangerine'
    })
  })

}(window.jQuery)


// Print plugin
// ------------

!function($) {

  'use strict'; // jshint ;_;

  var tap = $('html').hasClass('touch') ? 'touchend' : 'click'

  $(document).on(tap, '[data-toggle=print]', function(evt) {
    evt.preventDefault()
    window.print()
  })

}(window.jQuery)


// Sidebar collapse listeners
// --------------------------

!function($) {

  'use strict'; // jshint ;_;

  var $sidebarCollapse = $('#sidebar-left .sidebar-left-actions [data-toggle=collapse]'),
  animating = false

  $sidebarCollapse.on('click', function(evt) {
    if (!animating) {
      animating = true
      $(this).parent().toggleClass('opened')
    }
  })

  $sidebarCollapse.each(function() {
    $($(this).attr('href')).on('shown hidden', function(evt) {
      animating = false
    })
  })
}(window.jQuery)


// Manage Orange Alerts Custom Scripts
// -----------------------------------

!function($) {

  'use strict'; // jshint ;_;

  if (!$('#orange-alerts')[0]) {
    return
  }
  $('[name=DisableAll]').on('change', function(evt) {
    $($(this).data('target')).collapse(this.id === 'orange-alerts-choice-yes' ? 'show' : 'hide')
  })
}(window.jQuery)

!function ($) {

  'use strict'; // jshint ;_;

  var $btnTitle
    , $this
    , $target
    , target
    , collapseLoop = function () {
        $this = $(this)
        target = $this.data('target')
        $btnTitle = $this.find('.btn-dynamic-title')

        $(target).data('callee', {
          $el: $this
        , currText: $btnTitle.text()
        , altText: $btnTitle.data('alt-title')
        }).on('hide show', toggleTitle)
      }
    , toggleTitle = function (evt) {
      var callee = $(this).data('callee')
        callee.$el.find('.btn-dynamic-title').text(callee.altText)
        callee.altText = callee.currText
        callee.currText = callee.$el.find('.btn-dynamic-title').text()
      }

    // Added to Orange Alerts
    //$('#orange-alerts [data-toggle=collapse]').each(collapseLoop)

    // Added to CSA Options
    // $('.general-setting .account-details-header [data-toggle=collapse]').each(collapseLoop)

    $('.btn-dynamic-title').parent().each(collapseLoop)

  }(window.jQuery)


// Select all plugin
// -----------------
!function($) {

  'use strict'; // jshint ;_;

  var SelectAll = function(element, options) {
    this.$element = $(element)
    this.options = $.extend({}, $.fn.selectAll.defaults, options)
    if (this.options.parent) {
      this.$parent = $(this.options.parent)
    }
  }

  SelectAll.prototype.toggle = function () {
    var $title = this.$parent.find(this.options.titleElement),
    currentTitle = $title.text()

    this.$parent.find('[type=checkbox]').prop('checked', this.$element.prop('checked'))
    $title.text(this.options.altTitle)
    this.$element.data('alt-title', currentTitle)
  }

  SelectAll.prototype.update = function ($group) {
    if ($group.not(':checked').length !== 0) {
      this.$element.prop('checked', null)
    }
    else {
      this.$element.prop('checked', true)
    }
  }

  // Select all PLUGIN DEFINITION
  // ---------------------------

  var old = $.fn.selectAll

  $.fn.selectAll = function (option, param) {
    return this.each(function() {
      var t = this,
      sa = new SelectAll(t, $(t).data())
      if (typeof option === 'string') sa[option](param)
    })
  }


  $.fn.selectAll.defaults = {
    parent: false,
    titleElement: '.select-all-dynamic-title',
    altTitle: 'Select none'
  }

  $.fn.selectAll.Constructor = SelectAll


  // Select all NO CONFLICT
  // ----------------------

  $.fn.selectAll.noConflict = function() {
    $.fn.selectAll = old
    return this
  }

  $('[data-select-all=enable]').each(function () {
    var $this = $(this)
    , $selectGroup = $this
    .parents(this.getAttribute('data-parent'))
    .find('[type="checkbox"]:not([data-select-all])')

    if (this.nodeName.toLowerCase() === 'input' && !this.name) {
      this.name = this.id
    }

    $selectGroup.on('change.selectall', function () {
      $this.trigger('update.selectall', [$selectGroup])
    })
  })

  $(document)
  .on('change.selectall', '[data-select-all=enable]', function (evt) {
    $(this).selectAll('toggle')
  })
  .on('update.selectall', '[data-select-all=enable]', function (evt, param) {
    $(this).selectAll('update', param)
  })

}(window.jQuery)


/******************************************************************************************************

    DATEPICKERS

    Datepickers can be called using data-datepicker="datepicker"

    Optimized variations are included below:

    1. Regular
    2. Optimized for birthdays
    3. Optimized for ASP end dates

    ******************************************************************************************************/
    !function($) {

  'use strict'; // jshint ;_;

  //$(function () { //removed because all js is at bottom of doc anyways
    var defaultDatepicker = function () {
          var altField = $(this).next()

          $(this).datepicker({
            dateFormat: 'dd/mm/yy',
            altField: altField,
            altFormat: 'ddmmyy',
            beforeShow: positionOverride
          })
        }
      , ymDropdownDatepicker = function () {
          var altField = $(this).next(),
          thisYear = (new Date).getFullYear(),
          endYear = thisYear - 120 // 120 years before today

          $(this).datepicker({
            dateFormat: 'dd/mm/yy',
            altField: altField,
            altFormat: 'ddmmyy',
            changeMonth: true,
            changeYear: true,
            yearRange: endYear + ':' + thisYear,
            beforeShow: positionOverride
          });
        }
        , ymfDropdownDatepicker = function () {
            var altField = $(this).next(),
            thisYear = (new Date).getFullYear(),
            endYear = thisYear + 50 // 50 years later

            $(this).datepicker({
              dateFormat: 'dd/mm/yy',
              altField: altField,
              altFormat: 'ddmmyy',
              changeMonth: true,
              changeYear: true,
              yearRange: thisYear + ':' + endYear,
              beforeShow: positionOverride
            });
          }
        , datepickerInModal = function () {
            $(this).find('[data-datepicker]').attr('readonly', 'readonly')
            $(this).find('[data-datepicker="datepicker"]').each(defaultDatepicker)
            $(this).find('[data-datepicker="datepicker-ym"]').each(ymDropdownDatepicker)
            $(this).find('[data-datepicker="datepicker-ymf"]').each(ymfDropdownDatepicker)
          }

        , positionOverride = function (element, datepicker) {
            var resetPosition = function () {
              var touch = $('html').hasClass('touch') && window.matchMedia("(max-width: 767px)").matches
              , $el = $(element)
              , dpPosition = 'absolute'//touch ? 'relative' : 'absolute'
              , dpTop = $el.outerHeight() + ($el.offset().top - $el.parent().offset().top)
              , inTableAndTablet = $el.parents('.table')[0] && window.matchMedia("(min-width: 767px) and (max-width: 979px)").matches
              , dpLeft = inTableAndTablet ? $el.offset().left - 80 : 0

              datepicker.dpDiv
              .css({
                left: dpLeft,
                position: dpPosition,
                top: dpTop,
                zIndex: 1004
              })
              .attr('data-controller', element.id)
              .insertAfter(element)
            }

            setTimeout(resetPosition, 0)
          }

      $(document).on('focus.datepicker click.datepicker touchend.datepicker', '[data-datepicker], .hasDatepicker', function (evt) {
        evt.preventDefault()
        $(this).datepicker('show')
      })


  // set datepicker input to be read-only to kill keyboard on mobile
  $('[data-datepicker]').attr('readonly', 'readonly').parent().css('position', 'relative')

  // Datepicker is formatted nicely for the user but set in a friendly format for IT
  $('[data-datepicker="datepicker"]').each(defaultDatepicker)

  // Datepicker for choosing a month and year from a dropdown for the past; ideal for birthdays
  $('[data-datepicker="datepicker-ym"]').each(ymDropdownDatepicker)

  // Datepicker for choosing a month and year from a dropdown for the future; ideal for setting ASP end dates
  $('[data-datepicker="datepicker-ymf"]').each(ymfDropdownDatepicker)

  // handles datepickers in modals
  $('.modal').on('shown', datepickerInModal)
}(window.jQuery)



/******************************************************************************************************
  DISABLED DATEPICKERS

  Extension for Bootstrap and jQuery UI datepicker

  USAGE

    HTML

    1. Add data-disable="disable" to the radio element that you want to control disabling
    2. Add data-disable-group="GroupName" to the radio button to specify which group it'll disable
    3. Add data-disabled-group="GroupName" to each datepicker you want to be part of the disabling group

    ******************************************************************************************************/
    !function($) {

  'use strict'; // jshint ;_;

  var init = function() {
    $('[data-disable]').on('change.disableme', findDisabled)
    $('[data-disable]:checked').trigger('change.disableme')
  }, modalInit = function() {
    $(this).find('[data-disable]').on('change.disableme', findDisabled)
    $(this).find('[data-disable]:checked').trigger('change.disableme')
  }

  , findDisabled = function(evt) {
    var state = $(this).data('disable')
      // Disable and Enable form elements based on radio selection
      // Get grouped form elements
      ,
      disabledGroup = $(this).data('disable-group')
        // Get disabled elements
        ,
        $target = $('[data-disabled-group="' + $(this).data('disable-group') + '"]') // data-disabled-group === data-target

        $target
        .attr('disabled', state === 'enable' ? null : 'disabled')
        .datepicker(state)[state === 'enable' ? 'removeClass' : 'addClass']('uneditable-input')
      }

  init() // initializer

  $('.modal').on('shown', modalInit) // Applies disabled field code to fields within modals manually

}(window.jQuery);


// DoubleSafe PassMark Phrase Script
// ---------------------------------
!function($) {

  'use strict'; // jshint ;_;

  if (!$('#doublesafe-new-phrase-input')[0]) {
    return
  }

  var $input = $('#doublesafe-new-phrase-input'),
  $count = $('#doublesafe-new-phrase-count'),
  maxLength = parseInt($input.prop('maxlength'), 10)

  $input.on('keyup', function(evt) {
    $count.text(maxLength - this.value.length)
  })
}(window.jQuery)

// DoubleSafe PassMark Picture Script
// ----------------------------------
!function($) {

  'use strict'; // jshint ;_;

  if (!$('#doublesafe-new-images')[0]) {
    return
  }

  var $imgList = $('#doublesafe-new-images'),
  $imgListLinks = $imgList.find('a'),
  $inputIndex = $('#imgIndx'),
  activeClass = 'active'

  $imgList.on('click', 'a', function(evt) {
    if (!$(this).hasClass('double-safe-generate-images')) {
      evt.preventDefault()
      $imgListLinks.removeClass(activeClass)
      $(this).addClass(activeClass)
      $inputIndex.val($(this).prop('href').split('?imgIndx=')[1])
    }
  })

}(window.jQuery)


// Address change form
// -------------------
!function($) {

  'use strict'; // jshint ;_;

  var $mailAddress = $('[data-address="mail-address"]'),
  $mailTarget = $('[data-address="target"]')
    //Date picker
    ,
    $disableMe = $('[data-disable="disableme"]'),
    $disableTarget = $('[data-target="disableme"]'),
    onSame = function(evt) {
      if ($(this).is(':checked')) {
        $mailTarget
        .addClass("in")
      } else {
        $mailTarget
        .removeClass("in")
        .find(':input').val(null)
      }
    }

    , onDiffDate = function(evt) {
      if ($(this).is(':checked')) {
        $disableTarget.removeAttr('disabled', 'disabled').removeClass('uneditable-input');
      } else {
        $disableTarget.attr('disabled', 'disabled').val(null).addClass('uneditable-input');
      }
    }

    $mailAddress.on('click', onSame)
    $disableMe.on('click', onDiffDate)

    $('.ui-datepicker').find('*').addClass('problem-fix')


  }(window.jQuery);


// Loader plugin definition
// ------------------------
!function($, mod) {

  'use strict'; // jshint ;_;

  var Loader = function(element) {
    this.$element = $(element)
    this.loaderLoop = null
  }

  Loader.prototype = {

    show: function() {
      var $el = this.$element

      $el.removeClass('hidden')

      //legacy fallback
      if (!mod.cssanimations) {
        var xPos = 0,
        loop = function() {
          xPos -= xPos > (-220) ? $el.width() : (-220);
          $el.css('backgroundPositon', xPos + 'px 0px');
        }
        this.loaderLoop = setInterval(loop, 40);
      }
    }

    ,
    hide: function() {
      var $el = this.$element
      $el.addClass('hidden')

      //legacy fallback
      if (!mod.cssanimations) {
        clearInterval(this.loaderLoop)
      }
    }
  }

  /* LOADER PLUGIN DEFINITION
  * ========================== */

  var old = $.fn.loader

  $.fn.loader = function(option) {
    return this.each(function() {
      var t = this,
      l = new Loader(t)
      if (typeof option === 'string') l[option]()
    })
  }

  $.fn.loader.Constructor = Loader


  /* COLLAPSE NO CONFLICT
  * ==================== */

  $.fn.loader.noConflict = function() {
    $.fn.loader = old
    return this
  }

  $(function() {
    $('.loader').loader('show')
  })

}(window.jQuery, Modernizr)


// ASP ROADBLOCK CALCULATOR
// ------------------------

// the following code was taken from the SIT environment
!function($) {
  var $calculator = $('.asp-setup-calculator'),
  el_total = $('#asp-total'),
  active = 'active',
  ENGLISH = $('html').prop('lang') === 'en-CA',
  freqList = {
    weekly: 52,
    biweekly: 26,
    monthly: 12
  }, toMoney = function(amount, precision) {
    var ts = ENGLISH ? ',' : ' ',
    ds = ENGLISH ? '.' : ',',
    pre = ENGLISH ? '$' : '',
    suf = ENGLISH ? '' : ' $'

    return pre + amount.toFixed(precision !== undefined ? precision : 2).replace(/(\d)(?=(\d{3})+\b)/g, '$1' + ts).replace(/\./g, ds) + suf
  }, updateTotal = function() {
    var amount = $('[data-name=ASPAmountCalc] .active').data('value'),
    frequency = freqList[$('[data-name=ASPFrequency] .active').data('value').toLowerCase()],
    total = toMoney(parseInt(amount, 10) * parseInt(frequency, 10), 0)
        //Update total
        $('#asp-total').html(total)
      }

      $calculator.on('updated.button.data-api', updateTotal)
    }(window.jQuery)


// SVG WITH PNG FALLBACK
// ---------------------
!function(mod) {
  if (!mod.svg) {
    $('img[src$=".svg"]').attr('src', function() {
      return $(this).attr('src').replace('.svg', '.png');
    });
  }
}(window.Modernizr)


// SELECT ALL WHEN FOCUSING FIELD
// ------------------------------
!function($) {
  $('[data-toggle="selectAll"]').focus(function() {
    var $this = $(this);
    $this.select();

    // Chrome fix to prevent further mouseup
    $this.mouseup(function() {
      $this.unbind("mouseup");
      return false;
    });

  });
}(window.jQuery)


// Progress bars
// -------------
!function($) {
  var applyProgress = function() {
    var $this = $(this),
    progress = $this.data('progress')

    $this
    .css('width', progress)
    .text(progress)
  }

  $('.progress [data-progress]').each(applyProgress)
}(window.jQuery)



// Placeholder attribute fallback
// ------------------------------
!function($) {
  if ('placeholder' in document.createElement('input')) {
    return
  }

  var createPlaceholder = function() {
    var $this = $(this)
    , $parent = $this.parent()
    , $placeholder = $('<span class="input-placeholder-fallback"></span>')
    , defaultValue = $this.val()

      //  Account for inputs with BS input appends - TQA00396370
      , inputPrefixWidth = $this.prev('.add-on')[0] ? $this.prev('.add-on').outerWidth() : 0

      $placeholder
      .css({
        paddingTop: $this.css('padding-top'),
        paddingLeft: parseInt($this.css('padding-left').replace(/px/g, '')) +
        parseInt($this.css('margin-left').replace(/px/g, '')) +
        inputPrefixWidth
      })
      .text($(this).attr('placeholder'))

      $placeholder.on('click', function(evt) {
        $this.focus()
      })

      $this.after($placeholder)
      $parent.css('position', 'relative')

      if (defaultValue) {
        $placeholder.addClass('is-hidden')
      }
    }, hidePlaceholder = function(evt) {
      $(this).siblings('.input-placeholder-fallback').addClass('is-hidden')
    }, showPlaceholder = function(evt) {
      if (this.value === '' && !$(this).hasClass('hasDatepicker')) {
        $(this).siblings('.input-placeholder-fallback').removeClass('is-hidden')
      }
    }

    $('[placeholder]')
    .each(createPlaceholder)
    .on('focus', hidePlaceholder)
    .on('focusout', showPlaceholder)
  }(window.jQuery)



// Collapse alternatives
// --------------------
!function($) {
  // Collapse toggle
  // For use instead of the default collapse if there is a dropdown inside of the collapsed element.
  // the '.collapse' uses overflow: hidden causing the dropdown inside the collapsed element to be hidden
  // this uses jQuery show/hide (display: none/block)
  // works like tabs
  // use data-toggle="collapse-alt" on clickable element
  // use data-target="#target-element"
  // add the class "collapse-alt" to div#target-element
  var $collapseAlt = $('.collapse-alt')
  $collapseAlt.hide();

  var $collapseAltToggle = $('[data-toggle="collapse-alt"]')

  var collapseAltLoad = function() {
    $collapseAltToggle.each(function() {
      var $this = $(this),
      target = $this.data('target')

        // collapse-alt fix for collapse-alts with checkboxes
        $(target)[($this.is(':checked')) ? 'slideDown' : 'slideUp'](100)
      })
  }

  var toggleCollapseAlt = function(evt) {
    var $this = $(this),
    target = $this.data('target')

    $this.parents('.btn-group').removeClass('open')

      // don't break the checkboxes
      if (evt.target.nodeName === 'INPUT') {
        $(target).slideToggle(100)
        return
      } else {
        $(target).slideToggle(100)
      }

      evt.preventDefault()
    }

  // event handlers
  $(collapseAltLoad)
  // with inputs
  $(document)
  .on('change', '[data-toggle="collapse-alt"]', toggleCollapseAlt)
  .on('click', '[data-toggle="collapse-alt"]' , function (evt) {
    if (evt.target.nodeName === 'INPUT') {
      return
    }
    toggleCollapseAlt(evt)
  })

  // Collapse open only
  $('.collapse-open').hide();
  $('[data-toggle="collapse-open"]').on('click', function(evt) {
    var target = $(this).attr('data-target')
    $(target).slideDown(100)
    return false
  })

}(window.jQuery)


// Duplicate form rows
// --------------------------------------
!function($) {
  var $table = $('#table-income, [data-table-income]'),
  // $row = $table.find('tbody tr:first-child').first().clone()
  $row = $table.find('tbody tr[data-clone]').clone()

  var inc = 1,
  addRow = function(evt) {
    evt.preventDefault()
    inc = inc + 1
    var $newRow = $row.clone().attr('data-index', inc)
    $newRow.find('input,select').each(function() {
      if ($(this).attr('type') === 'text') {
        $(this).val('');
      }
      var name = $(this).attr('name')
      $(this).attr({
          'name': name //+ inc
          ,
          'id': name + inc
        })
    })

    $(this).parents('tr').before($newRow);

    var $tooltip = $('[data-toggle=tooltip]');

    $tooltip.each(function() {
      var options = $.extend({
        placement: 'right',
        trigger: 'hover focus',
        container: 'body'
      }, $(this).data())

      $(this).tooltip(options)
    });
    // $('.table-row-remove')

      // $(this).tooltip(options)

    }, removeRow = function(evt) {
      evt.preventDefault()
      $(this).parents('tr').remove()
      $(".tooltip").remove()
    }

    $table.each(function() {
      $(this).on('click', '[data-duplicate-add]', addRow)
      $(this).on('click', '.table-row-remove', removeRow)
    })
  }(window.jQuery)


// Change this to this content dynamically
// ----------------------------------------------------------
!function($) {
  /*
      clicking any attribute with data-change with save this value and dynamically
      update the contents of "data-change-group-target"

      for use with dropdowns

      1. add data-change-group="GROUP_NAME" to the ul.dropdown-menu
      2. add data-change="New String" to the clickable string-changer
      3. add data-change-target to the element whose contents will be replaced
         by the new string

      currently works if there's only one group. will need to be extended to
      support multiple groups
      */
      $('[data-change]').click(function() {
    // finding the new string
    $this = $(this)
    var changeGroup = $this.parents('.dropdown-menu').data('change-group')
    var str = $this.data('change')
    var dropDownText = $this.html() + ' <span class="icon-caret-down">'

    // update the dropdown menu text to show option selected
    $this
    .parents('.btn-group')
    .find('[data-toggle="dropdown"]')
    .html(dropDownText)

    // finding the target and replacing its contents
    $('[data-change-target]').html(str)

  })
    }(window.jQuery)


// Upload Document Page (Add extra upload input)
// ------------------------------

!function($) {
  var $secondDoc = $('[data-file="add"]'),
  $addfile = $('[data-upload="addfile"]'),
  $removeSecondDoc = $('[data-file="remove"]'),
  onRemove = function(evt) {
    $secondDoc.addClass('hidden')
    $addfile.removeClass('hidden')
  }, addFile = function(evt) {
    $secondDoc.val(null).removeClass('hidden')
    $secondDoc.find("input").val(null)
    $addfile.addClass('hidden')
  }

  $addfile.on('click', addFile)
  $removeSecondDoc.on('click', onRemove)

}(window.jQuery)


// Hide print ability on mobile devices
// ------------------------------------
!function($) {

  'use strict'; // jshint ;_;

  if ($('html').hasClass('touch')) {
    $('.icon-print').parents('a').hide()
    //TQA00354897
    $('[data-toggle="print"]').hide()
  }
}(window.jQuery)


// RSP WITHDRAWAL CALCULATORS
// --------------------------
!function($) {
  var rspCalcs = $('.form-rsp-withdrawal .calculators [data-calculate]'),
    hiddenClass = 'is-hidden' // TQA00355748

    function disableCalcFields() {
      $('.form-rsp-withdrawal input[type="text"]').attr('disabled', 'disabled')
    }

    // Hide the calculators
  rspCalcs.addClass(hiddenClass) // TQA00355748

  // Disable fields
  disableCalcFields()

  // Show calculator if checked by default
  $('.form-rsp-withdrawal .calculators input[type="radio"]:checked').each(function() {
    // Show the calculator
    $(this).parent().parent().find('[data-calculate]').removeClass(hiddenClass) // TQA00355748

    // Focus the amount field
    $(this).parent().parent().find('input[type="text"]').removeAttr('disabled').removeAttr('readonly').focus();
  });


  // Show calculator if changed to be checked
  $('.form-rsp-withdrawal .calculators input[type="radio"]').change(function() {
    // Hide calculators
    rspCalcs.addClass(hiddenClass) // TQA00355748

    // Disable fields
    disableCalcFields();

    // Show the calculator
    $(this).parent().parent().find('[data-calculate]').removeClass(hiddenClass) // TQA00355748

    // Focus the amount field
    $(this).parent().parent().find('input[type="text"]').removeAttr('disabled').focus();
  });

  $('.calculate-link').attr('style', '') // remove any inline styles
}(window.jQuery)


!function($) {
  $('#collapseOne').on('shown', function() {
    $('#radio1').prop('checked', true);
  });

  $('#collapseTwo').on('shown', function() {
    $('#radio2').prop('checked', true);
  });

  $('#collapseThree').on('shown', function() {
    $('#radio3').prop('checked', true);
  });
}(window.jQuery)

// Sony tablet targeting
// ---------------------
!function ($) {
  var UA = navigator.userAgent
  // add sony-android class to Sony Xperia
  // if (/SGP/i.test(UA) && /android/i.test(UA)) {
  //  $('html').addClass('sony-android')
  // }

  // add sony-android class to all androids - TQA00390832
  if (/android/i.test(UA)) {
    $('html').addClass('sony-android')
  }
}(window.jQuery)


// Click to Chat functionality
// ---------------------------
!function ($) {
  'use strict';

  var c = 0
  , t
  , timer_is_on = 0
  , stop_threshold = 25
  , lang = $('html').prop('lang') === 'fr-CA' ? 'fr' : 'en'
  , getChatButton = function (data) {
      var state = data && data.IsLiveChatActive > 0
      $('#chat-available')[state ? 'removeClass' : 'addClass']('is-hidden')
      $('#chat-unavailable')[state ? 'addClass' : 'removeClass']('is-hidden')
    }
  , chatAvailEvent2 = function () {
      $.ajax({
        url: 'https://tng-eng.frontlinesvc.com/ci/ajaxCustom/inChatHours'
        , dataType: 'jsonp'
        , success: getChatButton
      })
      return true
    }

  , timedCount = function () {
    try {
      if (!chatAvailEvent2()) {}
        else {
          c = stop_threshold
        }
      }
      catch (err) {
        c++
        if (c < stop_threshold) {
          t = setTimeout(timedCount, 1000)
        }
      }
    }
    , startAutoCheck = function (evt) {
      if (!timer_is_on) {
        timer_is_on = 1
        timedCount()
      }
    }

  window.getChatButton = getChatButton

  $(document)
  .on('open.footer', '.footer', startAutoCheck)
  .on('click.live-chat touchend.live-chat', '#chat-available > a', function (evt) {
    evt.preventDefault()
    window.dcsMultiTrack && window.dcsMultiTrack('DCS.dcsuri', '/' + lang + '/ChatClick.html', 'WT.ti', lang + ' - Live Chat')
    window.open('http://tng-eng.frontlinesvc.com/app/chat/chat_landing/prod/24','chat','menubar=1,resizable=1,width=350,height=450')
  })

  if ($(window).width() < 980) {
    startAutoCheck()
  }

}(window.jQuery)
