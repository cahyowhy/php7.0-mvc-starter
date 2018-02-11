<template>
    <admin-auth-form btn-title='Login' :isCustomer="true" @action='doSave'/>
</template>

<script>
    import baseServices from '../services/BaseServices';
    import commonServices from '../services/CommonServices';
    import _ from 'lodash';

    export default {
        name: "customer-register",
        methods: {
            async doSave(param) {
                const {data} = await new baseServices('/api/customer/validate').save(_.pickBy(param));
                if (data && commonServices.setToken(data['token']))
                    window.location = '/';
            }
        }
    }
</script>