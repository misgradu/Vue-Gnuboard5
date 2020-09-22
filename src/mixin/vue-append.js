(function () {
  var vueAppend = {}

  var fireEvent = function (element, event) {
    if (document.createEventObject) {
      // for ie
      var evt = document.createEventObject();
      return element.fireEvent('on' + event, evt)
    } else {
      // eslint-disable-next-line no-redeclare
      var evt = document.createEvent('HTMLEvents');
      evt.initEvent(event, true, true);
      return !element.dispatchEvent(evt);
    }
  };


  var slice = [].slice,
    singleTagRE = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
    tagExpanderRE = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/ig,
    table = document.createElement('table'),
    fragmentRE = /^\s*<(\w+|!)[^>]*>/,
    tableRow = document.createElement('tr'),
    containers = {
      'tr': document.createElement('tbody'),
      'tbody': table,
      'thead': table,
      'tfoot': table,
      'td': tableRow,
      'th': tableRow,
      '*': document.createElement('div')
    };
  // eslint-disable-next-line no-unused-vars
  var fragment = function (html, name, properties) {
    var dom, container
    // A special case optimization for a single tag
    if (singleTagRE.test(html)) dom = document.createElement(RegExp.$1)

    if (!dom) {
      if (html.replace) html = html.replace(tagExpanderRE, "<$1></$2>")
      if (name === undefined) name = fragmentRE.test(html) && RegExp.$1
      if (!(name in containers)) name = '*'

      container = containers[name]
      container.innerHTML = '' + html
      dom = slice.call(container.childNodes).map(function (child) {
        return container.removeChild(child)
      })
    }

    return dom
  }

  function traverseNode(node, fun) {
    fun(node)
    for (var key in node.childNodes) {
      traverseNode(node.childNodes[key], fun)
    }
  }

  var append = async function (nodes, target, cb) {
    var Idx = 0;
    var scripts = [];
    // eslint-disable-next-line no-undef
    for await (_node of nodes) {
      // eslint-disable-next-line no-undef
      var node = _node.cloneNode(true);
      if (document.documentElement !== target && document.documentElement.contains(target)) {
        traverseNode(target.insertBefore(node, null), function (el) {
          if (el.nodeName != null && el.nodeName.toUpperCase() === 'SCRIPT' && (!el.type || el.type === 'text/javascript')) {
            scripts.push(el);
          } 
        });
      }
    }

    const execute = async function () {
      var script = scripts[Idx];
      let s = document.createElement('script');
      if(typeof script == "undefined") return false;
      if(script.src) {
        s.setAttribute('src', script.src);
        s.onload = function() {
          Idx++;
          if(scripts.length - 1 >= Idx) execute();
        }
        document.head.appendChild(s);
      }else{
        window['eval'].call(document.body, script.innerHTML);
        //target['eval'].call(target, document.body.innerHTML);
        Idx++;
        if(scripts.length == Idx) cb();
        else execute();
      }
    }   
    execute();
  }

  var exec = function (el, val) {
    if (val) {
      try {
        el.innerHTML = '';
        append(fragment(val), el, function cb() {
          fireEvent(el, 'appended');
        })
      } catch (e) {
        fireEvent(el, 'appenderr');
        console.error(e);
      }
    }
  }

  // exposed global options
  vueAppend.config = {};

  vueAppend.install = function (Vue) {
    Vue.directive('append', {
      inserted: function (el, data) {
        exec(el, data.value);
      },
      componentUpdated: function (el, data) {
        if (data.value !== data.oldValue) {
          exec(el, data.value);
        }
      }
    })
  }

  if (typeof exports == "object") {
    module.exports = vueAppend;
  // eslint-disable-next-line no-undef
  } else if (typeof define == "function" && define.amd) {
    // eslint-disable-next-line no-undef
    define([], function () {
      return vueAppend
    });
  } else if (window.Vue) {
    window.VueAppend = vueAppend;
    // eslint-disable-next-line no-undef
    Vue.use(vueAppend);
  }
})();