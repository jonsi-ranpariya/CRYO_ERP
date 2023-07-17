<template>
    <div>
        <app-collapse accordion type="border">
            <app-collapse-item title="Search Area">
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="Item Category"
                            label-for="itemCategory"
                        >
                            <v-select
                                id="itemCategory"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="itemCategoryOptions"
                                :clearable="true"
                                input-id="itemCategory"
                                placeholder="Select category"
                                v-model="searchFormData.itemCategory"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Item Group"
                            label-for="itemGroup"
                        >
                            <v-select
                                id="itemGroup"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="itemGroupOptions"
                                input-id="itemGroup"
                                placeholder="Select item group"
                                v-model="searchFormData.itemGroup"
                                :clearable="true"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Item Type"
                            label-for="itemType"
                        >
                            <v-select
                                input-id="itemType"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="itemTypeOptions"
                                :reduce="val => val.value"
                                :clearable="true"
                                placeholder="Select item type"
                                v-model="searchFormData.itemType"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="Main Group"
                            label-for="mainGroup"
                        >
                            <v-select
                                id="mainGroup"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="groupOptions"
                                :clearable="true"
                                :reduce="val => val.value"
                                placeholder="Select item main group"
                                v-model="searchFormData.itemMainGroup"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Sub Group"
                            label-for="subGroup"
                        >
                            <v-select
                                id="subGroup"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="groupOptions"
                                :clearable="true"
                                :reduce="val => val.value"
                                placeholder="Select item sub group"
                                v-model="searchFormData.itemSubGroup"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="2">
                        <b-form-group
                            label="Item Code"
                            label-for="itemCode"
                        >
                            <b-form-input
                                id="itemCode"
                                v-model="searchFormData.itemCode"
                                v-uppercase-input
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Item Description"
                            label-for="itemDescription"
                        >
                            <b-form-input
                                id="itemDescription"
                                v-model="searchFormData.itemDescription"
                                v-uppercase-input
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Detail Description"
                            label-for="itemDetailDescription"
                        >
                            <b-form-input
                                id="itemDetailDescription"
                                v-model="searchFormData.itemDetailDescription"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="Drawing No."
                            label-for="itemDrawingNumber"
                        >
                            <b-form-input
                                id="itemDrawingNumber"
                                v-model="searchFormData.itemDrawingNumber"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="12">
                        <hr>
                        <b-button
                            type="button"
                            variant="primary"
                            class="float-right"
                            @click="applyFilter"
                        >
                            <feather-icon
                                icon="FilterIcon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Apply</span>
                        </b-button>
                        <b-button
                            type="button"
                            variant="danger"
                            class="float-right mr-1"
                            @click="resetSearchFormData"
                        >
                            <feather-icon
                                icon="Trash2Icon"
                                size="16"
                                class="mr-0 mr-sm-50"
                            />
                            <span class="d-none d-sm-inline">Clear</span>
                        </b-button>
                    </b-col>
                </b-row>
            </app-collapse-item>
        </app-collapse>
        <!-- Component Area -->
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code class="mt-1">
                <b-row class="mb-2">
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start"
                    >
                        <b-button
                            variant="primary"
                            :to="{name : 'add-item-master'}"
                        >
                            Add Item
                        </b-button>
<!--                        <b-button
                            variant="primary"
                            type="button"
                            class="ml-1"
                            @click="openModal"
                        >
                            Import Item
                        </b-button>-->
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                    >
                        <!-- search input -->
                        <div class="custom-search d-flex justify-content-end">
                            <b-form-group>
                                <div class="d-flex align-items-center">
                                    <label class="mr-1">Search</label>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Search"
                                        type="text"
                                        class="d-inline-block"
                                    />
                                </div>
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>

                <!-- table -->
                <vue-good-table
                    :columns="columns"
                    :rows="rows"
                    :rtl="direction"
                    :search-options="{
                enabled: true,
                externalQuery: searchTerm
            }"
                    :select-options="{
                enabled: false,
                selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                selectionInfoClass: 'custom-class',
                selectionText: 'rows selected',
                clearSelectionText: 'clear',
                disableSelectInfo: true, // disable the select info panel on top
                selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
            }"
                    :pagination-options="{
                enabled: true,
                perPage:pageLength
            }"
                    :line-numbers="true"
                >
                    <template
                        slot="table-row"
                        slot-scope="props"
                    >

                        <!-- Column: Name -->
                        <span
                            v-if="props.column.field === 'itemCode'"
                            class="text-nowrap"
                        >

                  <span class="text-nowrap"></span>
                </span>

                        <span
                            v-if="props.column.field === 'itemGroupLabel'"
                            class="text-nowrap"
                        >

                  <span class="text-nowrap">{{ props.row.itemGroup.label }}</span>
                </span>

                        <span
                            v-if="props.column.field === 'itemCategoryLabel'"
                            class="text-nowrap"
                        >

                  <span class="text-nowrap">{{ props.row.itemCategory.label }}</span>
                </span>

                        <!-- Column: Action -->
                        <span v-else-if="props.column.field === 'action'">
                  <span>
                    <b-dropdown
                        variant="link"
                        toggle-class="text-decoration-none"
                        no-caret
                    >
                      <template v-slot:button-content>
                        <feather-icon
                            icon="MoreVerticalIcon"
                            size="16"
                            class="text-body align-middle mr-25"
                        />
                      </template>
                      <b-dropdown-item @click="copyItemMasterData(props.row._id)">
                        <feather-icon
                            icon="CopyIcon"
                            class="mr-50"
                        />
                        <span>Repeat</span>
                      </b-dropdown-item>
                      <b-dropdown-item
                          :to="{ name: 'edit-item-master', params: { id: props.row._id} }"
                      >
                        <feather-icon
                            icon="Edit2Icon"
                            class="mr-50"
                        />
                        <span>Edit</span>
                      </b-dropdown-item>
                      <b-dropdown-item @click="deleteItemMasterData(props.row._id)">
                        <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                        />
                        <span>Delete</span>
                      </b-dropdown-item>
                    </b-dropdown>
                  </span>
                </span>

                        <!-- Column: Common -->
                        <span v-else>
                  {{ props.formattedRow[props.column.field] }}
                </span>
                    </template>
                    <!-- pagination -->
                    <template
                        slot="pagination-bottom"
                        slot-scope="props"
                    >
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-center mb-0 mt-1">
                        <span class="text-nowrap ">
                          Showing 1 to
                        </span>
                                <b-form-select
                                    v-model="pageLength"
                                    :options="['5','10','25','50','100']"
                                    class="mx-1"
                                    @input="(value)=>props.perPageChanged({currentPerPage:value})"
                                />
                                <span class="text-nowrap"> of {{ props.total }} entries </span>
                            </div>
                            <div>
                                <b-pagination
                                    :value="1"
                                    :total-rows="props.total"
                                    :per-page="pageLength"
                                    first-number
                                    last-number
                                    align="right"
                                    prev-class="prev-item"
                                    next-class="next-item"
                                    class="mt-1 mb-0"
                                    @input="(value)=>props.pageChanged({currentPage:value})"
                                >
                                    <template #prev-text>
                                        <feather-icon
                                            icon="ChevronLeftIcon"
                                            size="18"
                                        />
                                    </template>
                                    <template #next-text>
                                        <feather-icon
                                            icon="ChevronRightIcon"
                                            size="18"
                                        />
                                    </template>
                                </b-pagination>
                            </div>
                        </div>
                    </template>
                </vue-good-table>
            </b-card-code>
        </b-overlay>
        <!-- Modal -->
        <b-modal
            id="modal-xl"
            size="lg"
            title="Import Item master"
            ref="importModal"
            scrollable
            no-close-on-esc
            no-close-on-backdrop
            hide-footer
        >
            <div class="m-1" v-if="progressBar.max > 0">
                <label>Please wait... ,Data inserting in process...</label>
                <b-progress
                    :max="progressBar.max"
                    class="progress-bar-info"
                >
                    <b-progress-bar
                        :value="progressBar.progressValue"
                        :label="`${((progressBar.progressValue / progressBar.max) * 100).toFixed(2)}%`"
                        variant="info"
                    />
                </b-progress>
            </div>
            <validation-observer
                ref="validateRules"
                #default="{ handleSubmit }"
            >
                <b-form
                    @submit.prevent="handleSubmit(submitFormData)"
                >
                    <validation-provider
                        #default="validationContext"
                        name="File"
                        rules="required"
                    >
                        <b-form-group
                            label=""
                            label-for="itemMasterExcel"
                            :state="getValidationState(validationContext)"
                        >
                            <b-form-file
                                placeholder="Choose a file here..."
                                no-drop
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                id="itemMasterExcel"
                                :state="getValidationState(validationContext)"
                                v-model="formData.importFile"
                                @change="getItemData($event)"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <hr>
                    <b-row>
                        <b-col md="6">
                            <b-button
                                variant="primary"
                                type="button"
                                @click="downloadSampleFile"
                            >
                                Download Sample File
                            </b-button>
                        </b-col>
                        <b-col md="6">
                            <b-button
                                variant="primary"
                                type="submit"
                                class="float-right"
                                :disabled="uploadButton.isDisabled"
                            >
                                {{ uploadButton.text }}
                            </b-button>
                        </b-col>
                    </b-row>

                </b-form>
            </validation-observer>
        </b-modal>
    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code/BCardCode.vue'
import {
    BAvatar,
    BBadge,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BDropdown,
    BDropdownItem,
    BButton,
    BRow,
    BCol,
    BFormFile,
    BFormInvalidFeedback,
    BForm,
    BOverlay,
    BProgress,
    BProgressBar
} from 'bootstrap-vue'
import { VueGoodTable } from 'vue-good-table'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ref, onUnmounted, onMounted } from '@vue/composition-api'
import store from '@/store'
import masterStoreModule from '../masterStoreModule'
import router from '@/router'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { required } from '@validations'
import axios from '@axios'
import { useToast } from 'vue-toastification/composition'
import vSelect from 'vue-select'
import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
import { uppercaseInput } from '@core/utils/utils'

export default {
    components: {
        BCardCode,
        BAvatar,
        BBadge,
        BPagination,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BDropdown,
        BDropdownItem,
        BButton,
        BRow,
        BCol,
        BFormFile,
        BFormInvalidFeedback,
        BForm,
        VueGoodTable,
        BOverlay,
        BProgress,
        BProgressBar,
        AppCollapse,
        AppCollapseItem,
        vSelect,
        ValidationProvider,
        ValidationObserver,
    },
    directives: {
        uppercaseInput,
    },
    data() {
        return {
            pageLength: 10,
            dir: false,
            searchTerm: '',
        }
    },
    setup({ importModal }) {
        const APP_STORE_MODULE_NAME = 'master-add'
        onMounted(() => {
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, masterStoreModule)
        })
        onUnmounted(() => {
            if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
        })
        const toast = useToast()

        const showOverlayLoading = ref(false)

        importModal = ref()

        const columns = ref([
            {
                label: 'Item Code',
                field: 'itemCode',
            },
            {
                label: 'Item Name',
                field: 'itemDescription',
            },
            {
                label: 'Item Make',
                field: 'make',
            },
            {
                label: 'Item Category',
                field: 'itemCategoryLabel',
            },
            {
                label: 'Group Name',
                field: 'itemGroupLabel',
            },
            {
                label: 'Action',
                field: 'action',
            },
        ])

        const rows = ref([])

        const itemCategoryOptions = ref([])
        axios.get('/api/get-item-category-options')
            .then((res) => {
                itemCategoryOptions.value = res.data.data
            })

        const itemGroupOptions = ref([])
        axios.get('/api/get-item-group-master-options')
            .then((res) => {
                itemGroupOptions.value = res.data.data
            })

        const itemTypeOptions = ref([
            {
                label: 'Sales',
                value: 1
            },
            {
                label: 'Purchase',
                value: 2
            },
            {
                label: 'General',
                value: 3
            },
            {
                label: 'Service',
                value: 4
            }
        ])

        const groupOptions = ref([])
        axios.get('/api/get-item-main-sub-group-options')
            .then((res) => {
                groupOptions.value = res.data.data
            })

        const refetchData = async () => {
            showOverlayLoading.value = true
            await axios.get('/api/item-master')
                .then((res) => {
                    rows.value = res.data.data
                })
            showOverlayLoading.value = false
        }
        refetchData()

        const uploadButton = ref({
            text: 'Upload File',
            isDisabled: false
        })

        const openModal = () => {
            importModal.value.show()
        }

        const blankFormData = {
            importFile: null
        }

        const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

        const resetFormData = () => {
            formData.value = JSON.parse(JSON.stringify(blankFormData))
        }

        const getItemData = (e) => {
            e.preventDefault()
            formData.value.importFile = e.target.files[0]
        }

        const progressBar = ref({
            progressValue: 0,
            max: 0
        })

        const submitFormData = async () => {
            uploadButton.value.text = 'Please wait...'
            uploadButton.value.isDisabled = true
            const newFormData = new FormData()
            newFormData.append('importFile', formData.value.importFile)
            await axios.post('/import/item-master', newFormData)
                .then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'File Uploaded',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Upload file ${res.data.data.name}.`,
                            },
                        })
                        importModal.value.hide()
                        refetchData()
                    }
                })
                .catch(() => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: `Error`,
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: `Internal server error`,
                        },
                    })
                })
            uploadButton.value.text = 'Upload File'
            uploadButton.value.isDisabled = false
        }

        const downloadSampleFile = async () => {
            await axios.get('/import/item-master-sample-file-download')
                .then((res) => {
                    let link = document.createElement('a')
                    document.body.appendChild(link)
                    link.href = res.data.path
                    link.click()
                })
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetFormData)

        const blankSearchForm = {
            itemCategory: null,
            itemGroup: null,
            itemType: null,
            itemMainGroup: null,
            itemSubGroup: null,
            itemCode: null,
            itemDescription: null,
            itemDetailDescription: null,
            itemDrawingNumber: null,
        }

        const searchFormData = ref(JSON.parse(JSON.stringify(blankSearchForm)))

        const resetSearchFormData = async () => {
            searchFormData.value = JSON.parse(JSON.stringify(blankSearchForm))
            await refetchData()
        }

        const applyFilter = async () => {
            showOverlayLoading.value = true
            await axios.post('/api/item-master-list-filter', searchFormData.value)
                .then((res) => {
                    rows.value = res.data.data
                })
                .catch((error) => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: `Error: ${error.response.status}`,
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: error.response.statusText,
                        },
                    })
                })
            showOverlayLoading.value = false
        }

        return {
            showOverlayLoading,
            columns,
            rows,
            //options
            itemCategoryOptions,
            itemGroupOptions,
            itemTypeOptions,
            groupOptions,

            refetchData,
            uploadButton,
            importModal,
            openModal,
            formData,
            resetFormData,
            getItemData,
            submitFormData,
            progressBar,
            downloadSampleFile,

            refFormObserver,
            getValidationState,
            resetForm,
            required,

            searchFormData,
            resetSearchFormData,
            applyFilter
        }
    },
    computed: {
        direction() {
            if (store.state.appConfig.isRTL) {
                this.dir = true
                return this.dir
            }
            this.dir = false
            return this.dir
        },
    },
    methods: {
        async deleteItemMasterData(id) {
            await this.$swal({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        store.dispatch(`master-add/deleteItemMaster`, { id })
                            .then(response => {
                                if (response.data.status === 200) {
                                    this.refetchData()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'Item Master Delete Successfully',
                                        },
                                    })
                                } else {
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: `Error`,
                                            icon: 'AlertCircleIcon',
                                            variant: 'danger',
                                            text: `something went wrong`,
                                        },
                                    })
                                }
                            })
                    }
                })
        },
        async copyItemMasterData(id) {
            await this.$swal({
                title: 'Are you sure?',
                text: 'Copy this item master data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, copy it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.value) {
                        store.dispatch(`master-add/copyItemMaster`, { id })
                            .then(response => {
                                if (response.data.status === 200) {
                                    this.refetchData()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Copied',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'Item Master data copied Successfully',
                                        },
                                    })
                                    router.push({
                                        name: 'edit-item-master',
                                        params: { id: response.data.data._id }
                                    })
                                } else {
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: `Error`,
                                            icon: 'AlertCircleIcon',
                                            variant: 'danger',
                                            text: `something went wrong`,
                                        },
                                    })
                                }
                            })
                    }
                })
        },
    }
}
</script>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
<style lang="scss">
@import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
