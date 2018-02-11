<template>
    <div class="ab-widget">
        <div class="title-section">
            <h3 class="title is-4">Add new book ma love</h3>
            <p>add book here</p>
        </div>
        <div class="control">
            <input type="text" v-model="isbn" class="input" placeholder="Book title">
        </div>
        <div class="control">
            <input type="text" v-model="title" class="input" placeholder="Book author">
        </div>
        <div class="control">
            <input type="text" v-model="author" class="input" placeholder="Book isbn">
        </div>
        <div class="control">
            <input type="text" v-model="stock" class="input" placeholder="Book price">
        </div>
        <div class="control">
            <input type="text" v-model="price" class="input" placeholder="Book stock">
        </div>
        <div class="btn-wrapper">
            <a @click="doSave" class="button is-primary">
                Add book ma love
            </a>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    import baseService from '../services/BaseServices';

    export default {
        name: "add-book-widget",
        data() {
            return {
                isbn: '',
                title: '',
                author: '',
                stock: '',
                price: ''
            }
        },
        methods: {
            async doSave() {
                const base = new baseService('/api/book/create');
                const {data} = await base.save(_.pickBy(this.$data));
                if (data)
                    window.location = '/book/' + data.id;
            }
        }
    }
</script>