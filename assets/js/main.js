// compoenents
import BookItem from './components/BookItem';
import SearchBookWidget from './components/SearchBookWidget';
import AddBookWidget from './components/AddBookWidget';
import AdminAuthForm from './components/AdminAuthForm';

// partial-pages
import AdminRegister from './partial-pages/AdminRegister';
import AdminLogin from './partial-pages/AdminLogin';

var Turbolinks = require('turbolinks');
window.Vue = require('vue').default;

Vue.component('book-item', BookItem);
Vue.component('search-book-widget', SearchBookWidget);
Vue.component('add-book-widget', AddBookWidget);
Vue.component('admin-auth-form', AdminAuthForm);

Vue.component('admin-register', AdminRegister);
Vue.component('admin-login', AdminLogin);
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