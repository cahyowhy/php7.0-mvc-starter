<template>
    <article class="media">
        <div class="media-left">
            <figure class="image is-64x64">
                <img src="https://bulma.io/images/placeholders/128x128.png" alt="Image">
            </figure>
        </div>
        <div class="media-content">
            <div class="content">
                <p>
                    <a :href="`/book/${book.id}`"><strong>{{ book.title }}</strong></a>
                    <small>@{{ book.author }}</small>
                    <small>stock {{ book.stock }}</small>
                    ,
                    <small>isbn: {{ book.isbn }}</small>
                </p>
                <p>Buy this book with only ${{ book.price }}</p>
            </div>
        </div>
    </article>
</template>

<script>
    export default {
        name: "book-item",
        props: {
            book: {
                type: Object,
                default: function () {
                    return {
                        id: '',
                        title: '',
                        author: '',
                        stock: '',
                        isbn: '',
                        price: ''
                    }
                }
            }
        }
    }
</script>