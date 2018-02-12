<template>
    <admin-auth-form btn-title='Register' :isCustomerSignUp="true" :isCustomer="true" @action='doSave'>
        <div class="select customer-type">
            <select v-model="type">
                <option v-for="item in types">{{item}}
                </option>
            </select>
        </div>
    </admin-auth-form>
</template>

<script>
    import baseServices from '../services/BaseServices';
    import _ from 'lodash';

    export default {
        name: "customer-register",
        data() {
            return {
                type: 'BASIC',
                types: []
            }
        },
        async mounted() {
            const {data} = await new baseServices('/api/customer/show-types').find(null, false);
            if (data)
                this.types = this.types.concat(data);
        },
        methods: {
            async doSave(param) {
                param.type = this.type;
                const {data} = await new baseServices('/api/customer/create').save(_.pickBy(param));
                if (data)
                    window.location = '/customer/login';
            }
        }
    }
</script>