<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr>
                <h4>Export Details</h4>
                <hr>
            </b-col>
        </b-row>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Export Ref"
                            label-for="exportRef"
                        >
                            <b-form-input
                                id="exportRef"
                                v-model="otherTabData.exportRef"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Other Ref"
                            label-for="otherRef"
                        >
                            <b-form-input
                                id="otherRef"
                                v-model="otherTabData.otherRef"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Pre-Carriage By"
                            label-for="preCarriageBy"
                        >
                            <b-form-input
                                id="preCarriageBy"
                                v-model="otherTabData.preCarriageBy"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Vessel"
                            label-for="vessel"
                        >
                            <b-form-input
                                id="vessel"
                                v-model="otherTabData.vessel"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Port Of Discharge"
                            label-for="portOfDischarge"
                        >
                            <b-form-input
                                id="portOfDischarge"
                                v-model="otherTabData.portOfDischarge"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Place Of Receipt"
                            label-for="placeOfReceipt"
                        >
                            <b-form-input
                                id="placeOfReceipt"
                                v-model="otherTabData.placeOfReceipt"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Port Of Loading"
                            label-for="portOfLoading"
                        >
                            <b-form-input
                                id="portOfLoading"
                                v-model="otherTabData.portOfLoading"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Final Destination"
                            label-for="finalDestination"
                        >
                            <b-form-input
                                id="finalDestination"
                                v-model="otherTabData.finalDestination"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Note"
                            label-for="note"
                        >
                            <b-form-textarea
                                id="note"
                                v-model="otherTabData.note"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="item Desc Title"
                            label-for="itemDescTitle"
                        >
                            <b-form-textarea
                                id="itemDescTitle"
                                v-model="otherTabData.itemDescTitle"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Add / Save Export Detail
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
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
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../../salesStoreModule'
    import axios from '@axios'
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
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const SubmitFormData = {
                            id: this.CurrentPiId,
                            otherDetail: this.otherTabData,
                        }
                        console.log(SubmitFormData)
                        store.dispatch('pi-exp-module/updateProformaInvoice', SubmitFormData).then(response => {
                            if (response.status === 200) {
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Export Detail Edited',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Edited Export Detail`,
                                    },
                                })
                            }
                        })
                    }
                })
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
        },
        props: {
            otherTabData: {
                type: Object,
                required: true,
            }
        },
        setup() {

            const PIEXP_APP_STORE_MODULE_NAME = 'pi-exp-module'
            // Register module
            if (!store.hasModule(PIEXP_APP_STORE_MODULE_NAME)) store.registerModule(PIEXP_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PIEXP_APP_STORE_MODULE_NAME)) store.unregisterModule(PIEXP_APP_STORE_MODULE_NAME)
            })

            const CurrentPiId = ref(router.currentRoute.params.id)


            return {
                CurrentPiId,
                required,
            }
        },
    }
</script>
