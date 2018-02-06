import Cookies from 'js-cookie';
import _ from 'lodash';

export default class CommonServices {
    static setToken(token) {
        Cookies.set('token', token, {expires: 1});
        return !_.isNil(CommonServices.getToken());
    }

    static removeToken() {
        Cookies.remove('token');
        return _.isNil(CommonServices.getToken());
    }

    static getToken() {
        return Cookies.get('token');
    }
}