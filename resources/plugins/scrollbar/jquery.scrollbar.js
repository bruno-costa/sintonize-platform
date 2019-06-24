/*!
 * Scroll Lock v3.1.3
 * https://github.com/MohammadYounes/jquery-scrollLock
 *
 * Copyright (c) 2017 Mohammad Younes
 * Licensed under GPL 3.
 */
(function(n) {
    typeof define == "function" && define.amd ? define(["jquery"], n) : n(jQuery)
  }
)(function(n) {
  "use strict";
  var i = {
    space: 32,
    pageup: 33,
    pagedown: 34,
    end: 35,
    home: 36,
    up: 38,
    down: 40
  }, r = function(t, i) {
    var u = i.scrollTop(), h = i.prop("scrollHeight"), c = i.prop("clientHeight"), f = t.originalEvent.wheelDelta || -1 * t.originalEvent.detail || -1 * t.originalEvent.deltaY, r = 0, e, o, s;
    return t.type === "wheel" ? (e = i.height() / n(window).height(),
      r = t.originalEvent.deltaY * e) : this.options.touch && t.type === "touchmove" && (f = t.originalEvent.changedTouches[0].clientY - this.startClientY),
      s = (o = f > 0 && u + r <= 0) || f < 0 && u + r >= h - c,
      {
        prevent: s,
        top: o,
        scrollTop: u,
        deltaY: r
      }
  }, u = function(n, t) {
    var u = t.scrollTop(), r = {
      top: !1,
      bottom: !1
    }, f, e;
    return r.top = u === 0 && (n.keyCode === i.pageup || n.keyCode === i.home || n.keyCode === i.up),
    r.top || (f = t.prop("scrollHeight"),
      e = t.prop("clientHeight"),
      r.bottom = f === u + e && (n.keyCode === i.space || n.keyCode === i.pagedown || n.keyCode === i.end || n.keyCode === i.down)),
      r
  }, t = function(i, r) {
    if (this.$element = i,
        this.options = n.extend({}, t.DEFAULTS, this.$element.data(), r),
        this.enabled = !0,
        this.startClientY = 0,
        this.options.unblock)
      this.$element.on(t.CORE.wheelEventName + t.NAMESPACE, this.options.unblock, n.proxy(t.CORE.unblockHandler, this));
    this.$element.on(t.CORE.wheelEventName + t.NAMESPACE, this.options.selector, n.proxy(t.CORE.handler, this));
    if (this.options.touch) {
      this.$element.on("touchstart" + t.NAMESPACE, this.options.selector, n.proxy(t.CORE.touchHandler, this));
      this.$element.on("touchmove" + t.NAMESPACE, this.options.selector, n.proxy(t.CORE.handler, this));
      if (this.options.unblock)
        this.$element.on("touchmove" + t.NAMESPACE, this.options.unblock, n.proxy(t.CORE.unblockHandler, this))
    }
    if (this.options.keyboard) {
      this.$element.attr("tabindex", this.options.keyboard.tabindex || 0);
      this.$element.on("keydown" + t.NAMESPACE, this.options.selector, n.proxy(t.CORE.keyboardHandler, this));
      if (this.options.unblock)
        this.$element.on("keydown" + t.NAMESPACE, this.options.unblock, n.proxy(t.CORE.unblockHandler, this))
    }
  }, f;
  t.NAME = "ScrollLock";
  t.VERSION = "3.1.2";
  t.NAMESPACE = ".scrollLock";
  t.ANIMATION_NAMESPACE = t.NAMESPACE + ".effect";
  t.DEFAULTS = {
    strict: !1,
    strictFn: function(n) {
      return n.prop("scrollHeight") > n.prop("clientHeight")
    },
    selector: !1,
    animation: !1,
    touch: "ontouchstart"in window,
    keyboard: !1,
    unblock: !1
  };
  t.CORE = {
    wheelEventName: "onwheel"in document.createElement("div") ? "wheel" : document.onmousewheel !== undefined ? "mousewheel" : "DOMMouseScroll",
    animationEventName: ["webkitAnimationEnd", "mozAnimationEnd", "MSAnimationEnd", "oanimationend", "animationend"].join(t.ANIMATION_NAMESPACE + " ") + t.ANIMATION_NAMESPACE,
    unblockHandler: function(n) {
      n.__currentTarget = n.currentTarget
    },
    handler: function(i) {
      var f, u, e;
      this.enabled && !i.ctrlKey && (f = n(i.currentTarget),
      (this.options.strict !== !0 || this.options.strictFn(f)) && (i.stopPropagation(),
        u = n.proxy(r, this)(i, f),
      i.__currentTarget && (u.prevent &= n.proxy(r, this)(i, n(i.__currentTarget)).prevent),
      u.prevent && (i.preventDefault(),
      u.deltaY && f.scrollTop(u.scrollTop + u.deltaY),
        e = u.top ? "top" : "bottom",
      this.options.animation && setTimeout(t.CORE.animationHandler.bind(this, f, e), 0),
        f.trigger(n.Event(e + t.NAMESPACE)))))
    },
    touchHandler: function(n) {
      this.startClientY = n.originalEvent.touches[0].clientY
    },
    animationHandler: function(n, i) {
      var r = this.options.animation[i]
        , u = this.options.animation.top + " " + this.options.animation.bottom;
      n.off(t.ANIMATION_NAMESPACE).removeClass(u).addClass(r).one(t.CORE.animationEventName, function() {
        n.removeClass(r)
      })
    },
    keyboardHandler: function(i) {
      var r = n(i.currentTarget), o = r.scrollTop(), f = u(i, r), e;
      return (i.__currentTarget && (e = u(i, n(i.__currentTarget)),
        f.top &= e.top,
        f.bottom &= e.bottom),
        f.top) ? (r.trigger(n.Event("top" + t.NAMESPACE)),
      this.options.animation && setTimeout(t.CORE.animationHandler.bind(this, r, "top"), 0),
        !1) : f.bottom ? (r.trigger(n.Event("bottom" + t.NAMESPACE)),
      this.options.animation && setTimeout(t.CORE.animationHandler.bind(this, r, "bottom"), 0),
        !1) : void 0
    }
  };
  t.prototype.toggleStrict = function() {
    this.options.strict = !this.options.strict
  }
  ;
  t.prototype.enable = function() {
    this.enabled = !0
  }
  ;
  t.prototype.disable = function() {
    this.enabled = !1
  }
  ;
  t.prototype.destroy = function() {
    this.disable();
    this.$element.off(t.NAMESPACE);
    this.$element = null;
    this.options = null
  }
  ;
  f = n.fn.scrollLock;
  n.fn.scrollLock = function(i) {
    return this.each(function() {
      var u = n(this)
        , f = typeof i == "object" && i
        , r = u.data(t.NAME);
      (r || "destroy" !== i) && (r || u.data(t.NAME, r = new t(u,f)),
      typeof i == "string" && r[i]())
    })
  }
  ;
  n.fn.scrollLock.defaults = t.DEFAULTS;
  n.fn.scrollLock.noConflict = function() {
    return n.fn.scrollLock = f,
      this
  }
});
//# sourceMappingURL=jquery-scrollLock.js.map
