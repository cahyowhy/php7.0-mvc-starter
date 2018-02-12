<template>
    <div class="book-page">
        <div class="box">
            <book-item :book="book"/>
        </div>

        <div v-if="isbookHasCustomer">
            <h2 class="title is-4">Borrowed by</h2>
            <div class="columns">
                <user-item v-for="customer in book.customers"
                           :key="customer.id" :customer="customer"
                           class="column is-4 is-pulled-left"/>
            </div>
        </div>

        <div v-if="hasBorrow">
            <div class="notification has-borrow">
                Anda telah meminjam buku ini
            </div>
        </div>
        <borrow-book v-else @save="doSave" :book_id="book.id"/>
    </div>
</template>

<script>
    import commonServices from '../services/CommonServices';
    import lodash from 'lodash';

    export default {
        name: "show-book",
        props: {
            book: {
                type: Object,
                default: function () {
                    return {
                        id: 0,
                        customers: []
                    }
                }
            }
        },
        data() {
            return {
                hasBorrow: false
            }
        },
        computed: {
            isbookHasCustomer() {
                return this.book.customers.length > 0;
            }
        },
        mounted() {
            const user = commonServices.getUser();

            if (!lodash.isEmpty(user)) {
                const customerBorrowedBook = this.book.customers.filter((item) => item.id === user.id);
                this.hasBorrow = customerBorrowedBook.length > 0;
            }
        },
        methods: {
            doSave(param = null) {
                this.book.customers = this.book.customers.concat(commonServices.getUser());
                //temporary cause line 62 doesnt affect everything
                window.location.reload();
            }
        }
    }
</script>

<style scoped>

</style>