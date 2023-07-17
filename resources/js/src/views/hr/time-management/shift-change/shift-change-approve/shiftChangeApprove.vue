<template>
    <b-card-code>
        <b-tabs pills>
            <b-tab active>
                <template #title>
                    <b-badge pill variant="light text-dark">4</b-badge>
                    <span class="d-none d-sm-inline ml-1">In Process</span>
                </template>
                <hr>
                <in-process-leave-list
                />
            </b-tab>

            <b-tab>
                <template #title>
                    <b-badge pill variant="light text-dark">1</b-badge>
                    <span class="d-none d-sm-inline ml-1">Approved</span>
                </template>
                <hr>
                <approved-leave-list
                />
            </b-tab>

            <b-tab>
                <template #title>
                    <b-badge pill variant="light text-dark">2</b-badge>
                    <span class="d-none d-sm-inline ml-1">Rejected</span>
                </template>
                <hr>
                <rejected-leave-list
                />
            </b-tab>

            <b-tab>
                <template #title>
                    <b-badge pill variant="light text-dark">3</b-badge>
                    <span class="d-none d-sm-inline ml-1">Lapsed</span>
                </template>
                <hr>
                <lapsed-leave-list
                />
            </b-tab>

            <b-tab>
                <template #title>
                    <b-badge pill variant="light text-dark">10</b-badge>
                    <span class="d-none d-sm-inline ml-1">All</span>
                </template>
                <hr>
                <all-leave-list
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
        BBadge
    } from 'bootstrap-vue'
    import inProcessLeaveList from "./tabs/inProcessLeaveList"
    import approvedLeaveList from "./tabs/approvedLeaveList"
    import rejectedLeaveList from "./tabs/rejectedLeaveList"
    import lapsedLeaveList from "./tabs/lapsedLeaveList"
    import allLeaveList from "./tabs/allLeaveList"
    import BCardCode from "@core/components/b-card-code/BCardCode";

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BTabs,
            BTab,
            BBadge,
            inProcessLeaveList,
            approvedLeaveList,
            rejectedLeaveList,
            lapsedLeaveList,
            allLeaveList
        },
    }
</script>

