<template>
    <admin-auth-form btn-title='Login' @action='doSave'/>
</template>

<script>
    import baseServices from '../services/BaseServices';
    import commonServices from '../services/CommonServices';
    import _ from 'lodash';

    export default {
        name: "admin-register",
        methods: {
            async doSave(param) {
                const {data} = await new baseServices('/admin/validate').save(_.pickBy(param));
                if (data && commonServices.setToken(data['token']))
                    window.location = '/';
            }
        }
    }
</script>