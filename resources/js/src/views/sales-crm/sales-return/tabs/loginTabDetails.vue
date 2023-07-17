<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
            </b-col>
        </b-row>
        <b-form>
            <b-row>
                <b-col md="12">
                    <h4>Login Details</h4>
                    <hr>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Created By"
                        label-for="createdBy"
                    >
                        <b-form-input
                            id="createdBy"
                            v-model="srLoginDetails.createdBy"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Date & Time"
                        label-for="createdDateTime"
                    >
                        <b-form-input
                            id="createdDateTime"
                            v-model="srLoginDetails.createdDateTime"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Last Modified By"
                        label-for="lastModifiedBy"
                    >
                        <b-form-input
                            id="lastModifiedBy"
                            v-model="srLoginDetails.lastModifiedBy"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Date & Time"
                        label-for="modifiedDateTime"
                    >
                        <b-form-input
                            id="modifiedDateTime"
                            v-model="srLoginDetails.modifiedDateTime"
                            readonly
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
                            v-model="srLoginDetails.approveUser"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Date & Time"
                        label-for="approveDateTime"
                    >
                        <b-form-input
                            id="approveDateTime"
                            v-model="srLoginDetails.approveDateTime"
                            readonly
                        />
                    </b-form-group>
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormTextarea,
        BForm,
        BDropdown,
        BDropdownItem,
        BButton,
        BFormDatepicker,
        BOverlay,
        BTable
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import {ref, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../../salesStoreModule'
    import moment from 'moment'

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormCheckbox,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BDropdown,
            BDropdownItem,
            BFormDatepicker,
            vSelect,
            BOverlay,
            BTable
        },
        directives: {
            Ripple,
        },
        props: {
            srLoginDetails: {
                type: Object,
                required: true,
            },
        },
        setup() {

            const SRL_APP_STORE_MODULE_NAME = 'sr-login-module'
            // Register module
            if (!store.hasModule(SRL_APP_STORE_MODULE_NAME)) store.registerModule(SRL_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(SRL_APP_STORE_MODULE_NAME)) store.unregisterModule(SRL_APP_STORE_MODULE_NAME)
            })

            const CurrentSrId = ref(router.currentRoute.params.id)

            return {
                CurrentSrId,
                required,
            }
        },

    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
