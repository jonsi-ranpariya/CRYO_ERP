<template>
    <b-card-code>
        <b-row>
            <b-col md="12">
                <h5>Replace Item In BOM</h5>
                <hr>
                <b-form-group
                    label="Old Item"
                    label-for="oldItem"
                >
                    <v-select
                        placeholder="Select Old Item"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="itemListOptions"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="oldItem"
                        @input="getItemDetails($event)"
                        v-model="formData.oldItem"
                    />
                </b-form-group>
                <b-form-group
                    label="New Item"
                    label-for="newItem"
                >
                    <v-select
                        placeholder="Select New Item"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="itemListOptions"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="newItem"
                        v-model="formData.newItem"
                    />
                </b-form-group>
                <div v-if="showTable">
                    <hr>
                    <b-table
                        responsive="sm"
                        :fields="bomRows"
                        :items="bomData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
                        :busy="isBusy"
                    >
                        <!--Loader-->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>

                        <!--Index-->
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                    </b-table>
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <b-button
                                variant="primary"
                                @click="submitData"
                            >
                                Replace
                            </b-button>
                        </b-col>
                    </b-row>
                </div>
            </b-col>
        </b-row>
    </b-card-code>
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
    BTable,
    BDropdown,
    BDropdownItem,
    BSpinner,
    BTabs,
    BTab,
    BFormRadioGroup,
    BInputGroup
} from 'bootstrap-vue'
import { required } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'
import router from '@/router'
import Toastification from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import { ref, computed, onUnmounted } from '@vue/composition-api'
import axios from '@axios'
import moment from 'moment'
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
        BDropdown,
        BDropdownItem,
        BSpinner,
        BTabs,
        BTab,
        BFormRadioGroup,
        BInputGroup,
        vSelect
    },
    setup() {
        const DM_APP_STORE_MODULE_NAME = 'bom-module'
        // Register module
        if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(DM_APP_STORE_MODULE_NAME)) store.unregisterModule(DM_APP_STORE_MODULE_NAME)
        })
        const toast = useToast()

        const itemListOptions = ref([])
        axios.get('/api/get-item-master-options')
            .then(res => {
                itemListOptions.value = res.data.data
            })

        const showTable = ref(false)

        const isBusy = ref(true)

        const bomRows = ref([
            {
                key: 'item_details.itemCode',
                label: 'Item Code'
            },
            {
                key: 'itemDescription',
                label: 'Item Description'
            },
            {
                key: 'version_details.bomNumber',
                label: 'BOM Number'
            },
            {
                key: 'version_details.bomVersion',
                label: 'Version'
            },
            {
                key: 'version_details.bomDescription',
                label: 'Version Description'
            }
        ])
        const bomData = ref([])

        const formData = ref({
            oldItems: [],
            oldItem: null,
            newItem: null,
        })

        const getItemDetails = async (id) => {
            formData.value.oldItems = []
            isBusy.value = true
            await axios.get(`/api/get-bom-items/${id}`)
                .then(res => {
                    bomData.value = res.data.data
                    showTable.value = true

                    if (res.data.data.length > 0) {
                        res.data.data.forEach((item) => {
                            formData.value.oldItems.push({
                                bomId: item.bomId,
                                versionId: item.versionId,
                                itemCode: item.itemCode,
                            })
                        })
                    }
                })
            isBusy.value = false
        }

        const resetPageData = () => {
            showTable.value = false
            isBusy.value = false
            formData.value.oldItems = []
            formData.value.oldItem = null
            formData.value.newItem = null
            bomData.value = []
        }

        const submitData = async () => {
            if (formData.value.newItem !== null) {
                isBusy.value = true
                await Swal.fire({
                    title: 'Are you sure?',
                    text: 'Replace All Bill Of Material Items',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                })
                    .then(result => {
                        if (result.value) {
                            axios.post('/api/replace-bom-items', formData.value)
                                .then(res => {
                                    if (res.data.status === 200) {
                                        toast({
                                            component: Toastification,
                                            position: 'top-right',
                                            props: {
                                                title: 'Items Replaced',
                                                icon: 'CheckSquareIcon',
                                                variant: 'success',
                                                text: 'You have successfully Replaced All Bill Of Material Item',
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
                                    resetPageData()
                                })
                        } else {
                            isBusy.value = false
                        }
                    })
            } else {
                toast({
                    component: Toastification,
                    position: 'top-right',
                    props: {
                        title: 'Warning',
                        icon: 'AlertCircleIcon',
                        variant: 'warning',
                        text: 'Please select new item.',
                    },
                })
            }
        }

        return {
            itemListOptions,
            showTable,
            isBusy,
            bomRows,
            bomData,
            getItemDetails,
            formData,
            resetPageData,
            submitData,
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
