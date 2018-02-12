<template>
    <form>

        <div v-if="isCustomer">
            <div class="field">
                <div class="control">
                    <input v-model="email" class="input is-large" type="email"
                           placeholder='Fill with email'>
                </div>
            </div>
            <div v-if="isCustomerSignUp">
                <div class="field">
                    <div class="control">
                        <input v-model="firstname" class="input is-large"
                               placeholder='your firstname'>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input v-model="surname" class="input is-large"
                               placeholder='your surname'>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="field">
                <div class="control">
                    <input v-model="username" class="input is-large" type="email"
                           placeholder='Fill with username'>
                </div>
            </div>
        </div>

        <slot/>

        <div class="field">
            <div class="control">
                <input v-model="password" class="input is-large" type="password"
                       placeholder="Your Password">
            </div>
        </div>

        <div class="field">
            <label class="checkbox">
                <input type="checkbox">
                Remember me
            </label>
        </div>
        <a @click="doSave" class="button is-block is-info is-large">
            {{btnTitle}}
        </a>
    </form>
</template>

<script>
    import lodash from 'lodash';

    export default {
        name: "admin-auth-form",
        props: {
            btnTitle: {
                type: String,
                default: ''
            },
            isCustomer: {
                type: Boolean,
                default: false
            },
            isCustomerSignUp: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                username: '',
                email: '',
                firstname: '',
                surname: '',
                password: ''
            }
        },
        methods: {
            doSave() {
                if (this.isCustomer) {
                    if (!this.isCustomerSignUp){
                        this.$emit('action', lodash.pick(this.$data, ['email', 'password']));
                    } else {
                        this.$emit('action', lodash.omit(this.$data, ['username']));
                    }
                } else {
                    this.$emit('action', lodash.pick(this.$data, ['username', 'password']));
                }
            }
        }
    }
</script>

<style scoped>

</style>