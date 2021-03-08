<template>
    <div>
        <div class="card shadow-sm bg-white rounded-lg">
            <h4 class="sticky-top position-absolute ml-2 mt-1">
                <span v-if="book.rating" class="badge badge-success shadow-sm">-{{ book.rating }}%</span>
                <span class="badge badge-secondary shadow-sm">{{ book.price }} &euro;</span>
                <span v-if="book.new" class="badge badge-warning shadow-sm">New</span>
            </h4>
            <router-link v-if="book.id" :to="{ name: 'books.show', params: { book_id: book.id } }">
                <img class="mx-auto pt-5" v-bind:src="'/' + book.image" :title="book.title" width="50%" />
            </router-link>

            <div class="card-body p-2">
                <p class="card-text">
                    <b>{{ book.title }}</b>
                </p>
            </div>
            <div class="card-footer p-3">
                <span v-for="i in 10" :class="{'text-warning rating-star' : i <= book.rating,
                                                        'rating-star' : i > book.rating}">
                    &#9733;
                </span>
                <hr />
                {{ book.genres }}
                <hr />
                {{ book.authors }}
                <hr />
            </div>
        </div>
    </div>
</template>
<script>
export default{
    props: ['book'],
}
</script>
