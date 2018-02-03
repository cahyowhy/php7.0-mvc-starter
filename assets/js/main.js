import BookItem from './components/BookItem';
import SearchBookWidget from './components/SearchBookWidget';

var Turbolinks = require('turbolinks');
window.Vue = require('vue').default;

Vue.component('book-item', BookItem);
Vue.component('search-book-widget', SearchBookWidget);
Vue.mixin(require('./mixins/vue-turbolinks'));

let el = '#app';

Turbolinks.start();
initApp();

function initApp() {

    if (window.isInitAppPreview) {
        return
    }
    window.isInitAppPreview = true;

    let loadAppPreview = function(e) {
        if (!document.querySelector(el)) {
            return
        }
        if (e.type == 'pageshow' && window.appPreview && !window.appPreview._isDestroyed) {
            return
        }

        window.appPreview = new Vue({
            el
        })
    };

    document.addEventListener("turbolinks:load", loadAppPreview);
    window.addEventListener("pageshow", loadAppPreview);

    document.addEventListener("turbolinks:before-cache", function() {
        if (!document.querySelector(el)) {
            return
        }
        if (window.appPreview) {
            window.appPreview.$destroy()
        }
    });
}