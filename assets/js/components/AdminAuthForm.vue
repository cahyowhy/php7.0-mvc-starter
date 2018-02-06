<template>
    <form>
        <div class="field">
            <div class="control">
                <input v-model="username" class="input is-large" type="email" placeholder="Your Admin Username">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <input v-model="password" class="input is-large" type="password" placeholder="Your Password">
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
    export default {
        name: "admin-auth-form",
        props: {
            btnTitle: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                username: '',
                password: ''
            }
        },
        methods: {
            doSave() {
                this.$emit('action', this.$data);
            }
        }
    }
</script>

<style scoped>

</style>