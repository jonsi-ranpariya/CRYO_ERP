<template>
    <div>
        <b-card-code>
            <b-tabs pills>
                <b-tab active>
                    <template #title>
                        <b-badge pill variant="light text-dark">4</b-badge>
                        <span class="d-none d-sm-inline ml-1">In Process</span>
                    </template>
                    <hr>
                    <in-process-leave-encashment-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <b-badge pill variant="light text-dark">1</b-badge>
                        <span class="d-none d-sm-inline ml-1">Approved</span>
                    </template>
                    <hr>
                    <approved-leave-encashment-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <b-badge pill variant="light text-dark">2</b-badge>
                        <span class="d-none d-sm-inline ml-1">Rejected</span>
                    </template>
                    <hr>
                    <rejected-leave-encashment-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <b-badge pill variant="light text-dark">3</b-badge>
                        <span class="d-none d-sm-inline ml-1">Lapsed</span>
                    </template>
                    <hr>
                    <lapsed-leave-encashment-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <b-badge pill variant="light text-dark">10</b-badge>
                        <span class="d-none d-sm-inline ml-1">All</span>
                    </template>
                    <hr>
                    <all-leave-encashment-list
                    />
                </b-tab>

            </b-tabs>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BTabs,
        BTab,
        BBadge
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import inProcessLeaveEncashmentList from './tabs/lapsedLeaveEncashmentList'
    import approvedLeaveEncashmentList from './tabs/approvedLeaveEncashmentList'
    import rejectedLeaveEncashmentList from './tabs/rejectedLeaveEncashmentList'
    import lapsedLeaveEncashmentList from './tabs/lapsedLeaveEncashmentList'
    import allLeaveEncashmentList from './tabs/allLeaveEncashmentList'

    export default {
        components: {
            BCardCode,
            BTab,
            BTabs,
            BBadge,
            inProcessLeaveEncashmentList,
            approvedLeaveEncashmentList,
            rejectedLeaveEncashmentList,
            lapsedLeaveEncashmentList,
            allLeaveEncashmentList,
        }

    }
</script>

