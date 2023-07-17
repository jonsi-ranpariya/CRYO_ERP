<template>
    <div>
        <b-row>
            <b-col md="6">
                <b-form-group
                    label="Created By"
                    label-for="createdBy"
                >
                    <b-form-input
                        id="createdBy"
                        v-model="loginData.createdBy"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Created Date & Time"
                    label-for="createdDateTime"
                >
                    <b-form-input
                        id="createdDateTime"
                        v-model="loginData.createdDateTime"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Modified By"
                    label-for="modifiedBy"
                >
                    <b-form-input
                        id="modifiedBy"
                        v-model="loginData.modifiedBy"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Modified Date & Time"
                    label-for="modifiedDateTime"
                >
                    <b-form-input
                        id="modifiedDateTime"
                        v-model="loginData.modifiedDateTime"
                        disabled
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Approved By"
                    label-for="approvedBy"
                >
                    <b-form-input
                        id="approvedBy"
                        v-model="loginData.approvedBy"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Approved Date & Time"
                    label-for="approvedDateTime"
                >
                    <b-form-input
                        id="approvedDateTime"
                        v-model="loginData.approvedDateTime"
                        disabled
                    />
                </b-form-group>
                <b-form-group
                    label="Stage"
                    label-for="stage"
                >
                    <b-form-input
                        id="stage"
                        v-model="loginData.stage"
                        disabled
                    />
                </b-form-group>
                <div v-if="loginData.stage === 'Rejected'">
                    <b-form-group
                        label="Reject Reason"
                        label-for="rejectReason"
                    >
                        <b-form-textarea
                            id="rejectReason"
                            rows="3"
                            v-model="loginData.stageReason"
                            disabled
                        />
                    </b-form-group>
                </div>
            </b-col>
        </b-row>
    </div>
</template>
<script>
import {
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BFormTextarea
} from "bootstrap-vue";
import purchaseStoreModule from '../../purchaseStoreModule'
import store from '@/store'

export default {
    components: {
        BFormGroup,
        BFormInput,
        BRow,
        BCol,
        BFormTextarea
    },
    props: {
        loginData: {
            type: Object,
            required: true
        }
    },
    setup() {
        const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
        if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)
    }
}
</script>
