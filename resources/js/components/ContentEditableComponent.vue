<template>
    <div class="border-bottom border-dark" style="outline: none" contenteditable="true" @blur="emitChange">
        {{ content }}
    </div>
</template>



<script>
    export default {
        props: ['content'],
        methods: {
            emitChange (ev) {
                this.$emit('update', ev.target.textContent)
                }
            }
    }
</script>
