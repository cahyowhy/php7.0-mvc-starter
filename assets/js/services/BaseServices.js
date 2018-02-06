/**
 * Created by cahyo on 10/23/17.
 */

import Axios from 'axios'

export default class {
    constructor(api) {
        this.api = api
        this.token = null

        this.method = {
            get: 'GET',
            post: 'POST',
            put: 'PUT',
            delete: 'DELETE'
        }
    }

    find(param = null) {
        if (param !== null) {
            let url = `${this.api}`
            if (typeof param === 'object') {
                let query = '?'
                url = url + vueInstane.$getQueryParam(query, param)
            } else if (typeof param === 'string' || typeof param === 'number') {
                url = `${url}/${param}`
            } else {
                url = `${url}?all=1`
            }

            return this.service(this.method.get, url)
        }
    }

    save(body, param = null) {
        let api = this.api
        if (param !== null) api = `${api}/${param}`
        return this.service(this.method.post, api, body)
    }

    update(body, param = null) {
        return this.service(this.method.put, `${this.api}/${param}`, body)
    }

    service(method, url, data = null, jsonContent = true) {
        if (data !== null) {
            try {
                data = JSON.parse(data)
            } catch (err) {
                data = JSON.stringify(data)
            }
        }

        const headers = this.token === null ? {
            'Content-Type': 'application/json'
        } : {
            'Content-Type': 'application/json',
            'Authorization': this.token
        };

        return Axios({
            method,
            url,
            headers,
            timeout: 3000,
            data
        }).then((response) => response)
            .catch((err) => console.log(err))
    }
}