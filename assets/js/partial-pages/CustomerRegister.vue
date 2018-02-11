<template>
    <admin-auth-form btn-title='Register' :isCustomer="true" @action='doSave'/>
</template>

<script>
    import baseServices from '../services/BaseServices';
    import _ from 'lodash';

    export default {
        name: "customer-register",
        methods: {
            async doSave(param) {
                const {data} = await new baseServices('/api/customer/create').save(_.pickBy(param));
                if (data)
                    window.location = '/customer/login';
            }
        }
    }
</script>