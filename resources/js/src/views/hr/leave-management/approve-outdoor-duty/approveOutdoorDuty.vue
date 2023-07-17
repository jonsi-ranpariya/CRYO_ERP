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
                    <in-process-outdoor-duty-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <b-badge pill variant="light text-dark">1</b-badge>
                        <span class="d-none d-sm-inline ml-1">Approved</span>
                    </template>
                    <hr>
                    <approved-outdoor-duty-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <b-badge pill variant="light text-dark">2</b-badge>
                        <span class="d-none d-sm-inline ml-1">Rejected</span>
                    </template>
                    <hr>
                    <rejected-outdoor-duty-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <b-badge pill variant="light text-dark">3</b-badge>
                        <span class="d-none d-sm-inline ml-1">Lapsed</span>
                    </template>
                    <hr>
                    <lapsed-outdoor-duty-list
                    />
                </b-tab>

                <b-tab>
                    <template #title>
                        <b-badge pill variant="light text-dark">10</b-badge>
                        <span class="d-none d-sm-inline ml-1">All</span>
                    </template>
                    <hr>
                    <all-outdoor-duty-list
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
    import inProcessOutdoorDutyList from './tabs/inProcessOutdoorDutyList'
    import approvedOutdoorDutyList from './tabs/approvedOutdoorDutyList'
    import rejectedOutdoorDutyList from './tabs/rejectedOutdoorDutyList'
    import lapsedOutdoorDutyList from './tabs/lapsedOutdoorDutyList'
    import allOutdoorDutyList from './tabs/allOutdoorDutyList'
    export default {
        components: {
            BCardCode,
            BTab,
            BTabs,
            BBadge,
            inProcessOutdoorDutyList,
            approvedOutdoorDutyList,
            rejectedOutdoorDutyList,
            lapsedOutdoorDutyList,
            allOutdoorDutyList
        }
    }
</script>
