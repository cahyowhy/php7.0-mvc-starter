import Cookies from 'js-cookie';
import _ from 'lodash';

export default class CommonServices {
    static getExpiresCookie() {
        // expires in 2 hours
        return new Date(new Date().getTime() + 120 * 60 * 1000);
    }

    static setUser(user) {
        Cookies.set('user', user, {expires: this.getExpiresCookie()});
        return !_.isEmpty(CommonServices.getUser());
    }

    static setToken(token) {
        Cookies.set('token', token, {expires: this.getExpiresCookie()});
        return !_.isNil(CommonServices.getToken());
    }

    static setEmail(email) {
        Cookies.set('email', email, {expires: this.getExpiresCookie()});
        return !_.isNil(CommonServices.getEmail());
    }

    static removeCookies() {
        Cookies.remove('token');
        Cookies.remove('email');
        Cookies.remove('user');
        return _.isNil(CommonServices.getToken()) && _.isNil(CommonServices.getEmail());
    }

    static getToken() {
        return Cookies.get('token');
    }

    static getUser() {
        const user = Cookies.getJSON('user');

        if (typeof user !== "object") {
            return {};
        } else {
            return user;
        }
    }

    static getEmail() {
        return Cookies.get('email');
    }
}