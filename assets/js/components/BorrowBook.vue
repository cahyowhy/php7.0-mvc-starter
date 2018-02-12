<template>
    <div class="borrow-book-component">
        <div class="field">
            <div class="control">
                <p class="title is-6">Start day</p>
                <!-- sometimes doesnt work on another browser, iam using chrome btw -->
                <input v-model="start" class="input is-primary" type="date" placeholder="mm/dd/yyyy">
            </div>
        </div>
        <div class="field">
            <div class="control">
                <p class="title is-6">Return this book at</p>
                <!-- sometimes doesnt work on another browser, iam using chrome btw -->
                <input v-model="end" class="input is-primary" type="date" placeholder="mm/dd/yyyy">
            </div>
        </div>
        <div class="btn-wrp">
            <a class="button is-primary" @click="doSave">Save</a>
        </div>
    </div>
</template>

<script>
    import baseServices from '../services/BaseServices';
    import lodash from 'lodash';
    import commonServices from '../services/CommonServices';

    export default {
        name: "borrow-book",
        data() {
            return {
                start: new Date(),
                end: new Date()
            }
        },
        props: {
            book_id: {
                type: [Number, String],
                default: 0
            }
        },
        methods: {
            async doSave() {
                const user = commonServices.getUser();
                if (lodash.isNil(user)) {
                    alert('you must logged in first');
                } else {
                    const book_id = this.book_id;
                    const body = Object.assign(this.$data, {customer_id: user['id'], book_id});

                    const {data} = await new baseServices('/api/book/borrow').save(body);
                    if (data) {
                        alert('simpan data berhasil');
                        this.$emit('save', data);
                    }
                }
            }
        }
    }
</script>