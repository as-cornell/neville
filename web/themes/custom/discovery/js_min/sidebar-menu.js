!function(a){a(".nav-toggle--sidebar").on({click:function(){var e=a(this);a(e).toggleClass("active"),a(e).next().toggleClass("shown")}}),a(".subnav-toggle--sidebar").on({click:function(){var e=a(this);a(e).toggleClass("active"),a(e).next().toggleClass("shown")}}),a(".nav--main-opener").prev().attr("aria-haspopup","true"),a(".subNav a").attr("tabindex",-1),a(".subNavToggle").click((function(e){var t=a(this),n=a(t.parent()),s=a(t.prev());a(this).toggleClass("rotated");var o=a(t.next());console.log(s),o.hasClass("expanded")?(a(o).removeClass("expanded"),a(n).removeClass("expanded"),t.next().find("a").attr("tabindex",-1)):(a(o).addClass("expanded"),a(n).addClass("expanded"),t.next().find("a").removeAttr("tabindex",-1))}))}(jQuery);