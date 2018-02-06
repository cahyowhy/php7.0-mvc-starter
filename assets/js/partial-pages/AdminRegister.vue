<template>
    <admin-auth-form btn-title='Register' @action='doSave'/>
</template>

<script>
    import baseServices from '../services/BaseServices';
    import _ from 'lodash';

    export default {
        name: "admin-register",
        methods: {
            async doSave(param) {
                const {data} = await new baseServices('/admin/create').save(_.pickBy(param));
                if (data)
                    window.location = '/admin/login';
            }
        }
    }
</script>