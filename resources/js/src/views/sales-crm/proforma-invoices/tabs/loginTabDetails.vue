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
                            v-model="piLoginDetails.createdBy"
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
                            v-model="piLoginDetails.createdDateTime"
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
                            v-model="piLoginDetails.lastModifiedBy"
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
                            v-model="piLoginDetails.modifiedDateTime"
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
                            v-model="piLoginDetails.approveUser"
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
                            v-model="piLoginDetails.approveDateTime"
                            readonly
                        />
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Stage"
                        label-for="stage"
                    >
                        <b-form-input
                            id="stage"
                            v-model="piLoginDetails.stage"
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
            piLoginDetails: {
                type: Object,
                required: true,
            },
        },
        setup() {

            const PIL_APP_STORE_MODULE_NAME = 'pi-login-module'
            // Register module
            if (!store.hasModule(PIL_APP_STORE_MODULE_NAME)) store.registerModule(PIL_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PIL_APP_STORE_MODULE_NAME)) store.unregisterModule(PIL_APP_STORE_MODULE_NAME)
            })

            const CurrentPiId = ref(router.currentRoute.params.id)

            return {
                CurrentPiId,
                required,
            }
        },

    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
