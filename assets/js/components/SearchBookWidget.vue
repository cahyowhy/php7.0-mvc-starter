<template>
    <div class="sb-widget">
        <div class="title-section">
            <h3 class="title is-4">
                Search book here ma love
            </h3>
            <p>Choose 1 or all of this, is up to you ma love</p>
        </div>
        <div class="control">
            <input class="input" v-model="isbn" type="text" placeholder="Search by isbn">
        </div>
        <div class="control">
            <input class="input" v-model="title" type="text" placeholder="Search by title">
        </div>
        <div class="control">
            <input class="input" v-model="author" type="text" placeholder="Search by author">
        </div>
        <div class="btn-wrapper">
            <a @click="doSearch" class="button is-primary">
                Search the book ma love
            </a>
        </div>
    </div>
</template>

<script>
    import getQueryParam from '../utils/getQueryParam';
    import _ from 'lodash';

    export default {
        name: "search-book-widget",
        data() {
            return {
                author: '',
                isbn: '',
                title: ''
            }
        },
        methods: {
            doSearch() {
                window.location = getQueryParam('/search/book?',_.pickBy(this.$data));
            }
        }
    }
</script>

<style scoped>

</style>