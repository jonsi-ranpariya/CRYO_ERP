<template>
    <div>
        <!-- Main Area -->
        <b-card-code>
            <b-overlay
                :show="showOverlayLoading"
                rounded="sm"
            >
                <validation-observer ref="simpleRules" #default="{ handleSubmit }">
                    <b-form @submit.prevent="handleSubmit(submitForm)">
                        <b-row>
                            <b-col md="6">
                                <validation-provider
                                    #default="{ errors }"
                                    name="Item Code"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Item Code"
                                        label-for=""
                                        :state="errors.length > 0 ? false:null"
                                    >

                                        <v-select
                                            placeholder="Select Item"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="itemListOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="itemCode"
                                            @input="getItemDetails($event)"
                                            v-model="formData.itemCode"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Item Description"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Item Description"
                                        label-for="itemDescription"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="itemDescription"
                                            v-model="formData.itemDescription"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Add Description"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Add. Description"
                                        label-for="addDescription"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="addDescription"
                                            v-model="formData.addDescription"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Drawing Number"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Drawing Number"
                                        label-for="drawingNumber"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="drawingNumber"
                                            v-model="formData.drawingNumber"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <validation-provider
                                    #default="validationContext"
                                    name="Drawing Revision"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Drawing Revision"
                                        label-for="drawingRevision"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-input
                                            id="drawingRevision"
                                            v-model="formData.drawingRevision"
                                            type="number"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>

                                <validation-provider
                                    #default="{ errors }"
                                    name="UOM"
                                    rules=""
                                >
                                    <b-form-group
                                        label="UOM"
                                        label-for="uom"
                                        :state="errors.length > 0 ? false:null"
                                    >
                                        <v-select
                                            placeholder="Select UOM"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="uomListOptions"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="uom"
                                            v-model="formData.uom"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                    </b-form-group>
                                </validation-provider>
                                <validation-provider
                                    #default="validationContext"
                                    name="Detail Description"
                                    rules=""
                                >
                                    <b-form-group
                                        label="Detail Description"
                                        label-for="detailDescription"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <b-form-textarea
                                            id="detailDescription"
                                            rows="3"
                                            v-model="formData.detailDescription"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="12">
                                <b-button
                                    type="submit"
                                    variant="primary"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-overlay>
        </b-card-code>
        <!-- Modal Area -->
        <b-modal
            id="confirmationModal"
            ref="confirmationModal"
            title="Select Options"
            ok-title="Yes"
            cancel-title="No"
            cancel-variant="danger"
            no-close-on-backdrop
            scrollable
            centered
            hide-footer
            size="lg"
        >
            <hr>
            <b-table
                :fields="modalTable.columns"
                :items="modalTable.rows"
                :bordered="true"
                :hover="true"
                show-empty
                responsive
                class="table_scroll"
            >
                <template #cell(action)="data">
                    <b-button
                        size="sm"
                        type="button"
                        variant="primary"
                        @click="selectBomItem(data.item._id)"
                    >
                        select
                    </b-button>
                </template>
            </b-table>
        </b-modal>
    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BFormCheckbox,
    BForm,
    BButton,
    BFormDatepicker,
    BOverlay,
    BFormInvalidFeedback,
    BTable
} from 'bootstrap-vue'
import { required } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import router from '@/router'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import { ref, onUnmounted } from '@vue/composition-api'
import axios from '@axios'
import bomStoreModule from '../bomStoreModule'
import Swal from 'sweetalert2'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormTextarea,
        BForm,
        BButton,
        BFormDatepicker,
        BOverlay,
        BFormInvalidFeedback,
        BTable,
        vSelect
    },
    directives: {
        Ripple,
    },
    setup({ confirmationModal }) {
        const DM_APP_STORE_MODULE_NAME = 'bom-module'
        // Register module
        if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(DM_APP_STORE_MODULE_NAME)) store.unregisterModule(DM_APP_STORE_MODULE_NAME)
        })

        const toast = useToast()

        confirmationModal = ref()

        const modalTable = ref({
            columns: [
                {
                    key: 'action',
                    label: ''
                },
                {
                    key: 'bomNumber',
                    label: 'BOM No.'
                },
                {
                    key: 'bomVersion',
                    label: 'Version'
                },
                {
                    key: 'bomDescription',
                    label: 'BOM Description'
                }
            ],
            rows: []
        })

        const blankFormData = {
            itemCode: null,
            itemDescription: null,
            addDescription: null,
            drawingNumber: null,
            drawingRevision: null,
            uom: null,
            detailDescription: null,
            bomVersionId: null,
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const showOverlayLoading = ref(true)

        const itemListOptions = ref([])
        axios.get('/api/new/get-item-master-filter-options')
            .then(res => {
                itemListOptions.value = res.data.data
                showOverlayLoading.value = false
            })

        const uomListOptions = ref([])
        showOverlayLoading.value = true
        axios.get('/api/get-uom-master-options')
            .then(res => {
                uomListOptions.value = res.data.data
                showOverlayLoading.value = false
            })

        const getItemDetails = async (id) => {
            await axios.get('/api/item-master/'.concat(id))
                .then(res => {
                    formData.value.itemCode = res.data.data._id
                    formData.value.itemDescription = res.data.data.itemDescription
                    formData.value.detailDescription = res.data.data.itemDetails?.detailDescription ?? null
                    formData.value.addDescription = res.data.data.itemDetails?.description ?? null
                    formData.value.drawingNumber = res.data.data.itemDetails?.drawingNumber ?? null
                    formData.value.drawingRevision = res.data.data.itemDetails?.revision ?? null
                    formData.value.uom = res.data.data.uom
                })
        }

        const submitForm = async () => {
            /* await axios.get(`/api/is-bom-exist/${formData.value.itemCode}`)
                .then((res) => {
                    if (res.data.data === true) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'Copy BOM Version?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, do it!',
                            cancelButtonText: 'No, keep it!',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                                cancelButton: 'btn btn-outline-danger ml-1',
                            },
                            buttonsStyling: false,
                        })
                            .then((result) => {
                                if (result.value) {
                                    axios.get(`/api/get-bom-version-from-item-code/${formData.value.itemCode}`)
                                        .then((res) => {
                                            modalTable.value.rows = res.data.data
                                        })
                                    confirmationModal.value.show()
                                } else {
                                    saveData()
                                }
                            })
                    } else {
                        saveData()
                    }
                }) */
            await saveData()
        }

        const selectBomItem = async (id) => {
            formData.value.bomVersionId = id
            confirmationModal.value.hide()
            await saveData();
        }

        const saveData = async () => {
            await store.dispatch('bom-module/addBillOfMaterial', formData.value)
                .then(res => {
                    if (res.data.status === 200) {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'Bill Of Material Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Bill Of Master',
                            },
                        })
                    } else {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'Something went wrong',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong',
                            },
                        })
                    }
                    router.push({
                        name: 'edit-bill-of-material',
                        params: {
                            id: res.data.data._id
                        }
                    })
                })
            resetFormData()
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        return {
            showOverlayLoading,
            itemListOptions,
            uomListOptions,
            getItemDetails,
            confirmationModal,
            modalTable,
            formData,
            resetFormData,
            submitForm,
            selectBomItem,

            refFormObserver,
            getValidationState,
            resetForm
        }
    }
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
<style lang="scss" scoped>
@import '~@core/scss/base/bootstrap-extended/include';
@import '~@core/scss/base/components/variables-dark';

.dark-layout {
    div ::v-deep .card .card-body {
        .b-overlay {
            .bg-light {
                background-color: $theme-dark-body-bg !important;
            }
        }
    }
}
</style>
