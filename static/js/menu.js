function ready(fn) {
    if (document.readyState != 'loading'){
        fn();
    } else if (document.addEventListener) {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        document.attachEvent('onreadystatechange', function() {
            if (document.readyState != 'loading')
                fn();
        });
    }
}

function on(el, eventName, handler) {
    if (el.addEventListener) {
        el.addEventListener(eventName, handler);
    } else {
        el.attachEvent('on' + eventName, function(){
            handler.call(el);
        });
    }
}

function toggleClass(el, className){
    if (el.classList) {
        el.classList.toggle(className);
    } else {
        var classes = el.className.split(' ');
        var existingIndex = -1;
        for (var i = classes.length; i--;) {
            if (classes[i] === className)
                existingIndex = i;
        }

        if (existingIndex >= 0)
            classes.splice(existingIndex, 1);
        else
            classes.push(className);

        el.className = classes.join(' ');
    }
}

function hasClass(el, className){
    if (el.classList)
        return el.classList.contains(className);
    else
        return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
}

function removeClass(el, className){
    if (el.classList)
        el.classList.remove(className);
    else
        el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
}

function addClass(el, className){
    if( ! hasClass(el, className)){
        toggleClass(el, className);
    }
}

function $(id) {
    return document.getElementById(id);
}

ready(function(){

    var Menu = {

        btn : $('btn-mobile-menu-toggle'),
        page: $('wrap'),
        menu: $('mobile-nav'),
        animating: false,
        visible: false,

        toggle: function(){
            Menu.animating = true;
            addClass(Menu.page, 'animating');

            Menu.menu.style.display = 'block';

            if(Menu.visible){
                addClass(Menu.page, 'right');
            }else{
                addClass(Menu.page, 'left');
            }
        },


        transitionend: function(){
            if(Menu.animating){
                Menu.animating = false;
                removeClass(Menu.page, 'animating');
                Menu.menu.style.display = Menu.visible ? 'none' : 'block';

                Menu.visible = !Menu.visible;

                toggleClass(Menu.page, 'menu-visible');
                removeClass(Menu.page, 'left');
                removeClass(Menu.page, 'right');
            }
        }

    };

    if(Menu.btn != null){
        on(Menu.btn, 'click', Menu.toggle);

        on(Menu.page, 'transitionend', Menu.transitionend);
        on(Menu.page, 'webkitTransitionEnd', Menu.transitionend);
        on(Menu.page, 'otransitionend', Menu.transitionend);
        on(Menu.page, 'MSTransitionEnd', Menu.transitionend);
    }
});

