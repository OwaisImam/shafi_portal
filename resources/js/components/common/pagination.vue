<script>
export default {
    props: {
        pills: {
            type: Boolean,
            default: true
        },
        ex4Rows: {
            type: Number,
            default: 0
        },
        rows: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
        }
    }
}
</script>

<template>
    <div class="mt-3">
        <BPagination v-model="ex4CurrentPage" :pills="pills" :total-rows="ex4Rows" align="end" />

    </div>
</template>
