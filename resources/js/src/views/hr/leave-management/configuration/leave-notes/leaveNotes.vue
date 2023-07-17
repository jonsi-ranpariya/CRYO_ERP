<template>
    <b-row>
        <b-col cols="12">
            <leave-editor-note
            />
        </b-col>
    </b-row>
</template>

<script>
    import { BRow, BCol } from 'bootstrap-vue'
    import leaveEditorNote from './leaveEditorNote'
    export default {
        components: {
            BRow,
            BCol,
            leaveEditorNote,
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/quill.scss';
</style>
