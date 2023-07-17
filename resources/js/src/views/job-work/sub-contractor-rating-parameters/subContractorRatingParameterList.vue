<template>
    <div>
        <b-card-code>
            <b-tabs pills lazy>
                <b-tab active>
                    <template #title>
                        <feather-icon
                            icon="UserIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">Delivery Parameters</span>
                    </template>
                    <hr>
                    <delivery-detail-tab
                    />
                </b-tab>
                <b-tab>
                    <template #title>
                        <feather-icon
                            icon="LayoutIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">QC Parameters</span>
                    </template>
                    <hr>
                    <qc-parameters
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>
    </div>
</template>
<script>
    import {
        BTabs,
        BTab
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import deliveryDetailTab from "./tabs/deliveryDetailTab";
    import qcParameters from "./tabs/qcParameters";


    export default {
        components: {
            BCardCode,
            BTabs,
            BTab,
            deliveryDetailTab,
            qcParameters
        }
    }
</script>
