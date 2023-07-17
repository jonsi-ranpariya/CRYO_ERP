<template>
    <b-card-code>
        <b-tabs pills>
            <b-tab active>
                <template #title>
                    <span class="d-none d-sm-inline">Reconciliation</span>
                </template>
                <hr>
                <reconciliation-list
                />
            </b-tab>
            <b-tab>
                <template #title>
                    <span class="d-none d-sm-inline">Delete Reconciliation</span>
                </template>
                <hr>
                <delete-reconciliation
                />
            </b-tab>
        </b-tabs>
    </b-card-code>
</template>

<script>
    import {
        BRow,
        BCol,
        BTabs,
        BTab,
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import reconciliationList from './tabs/reconciliationList'
    import deleteReconciliation from './tabs/deleteReconciliation'

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BTabs,
            BTab,
            deleteReconciliation,
            reconciliationList
        },
    }
</script>

