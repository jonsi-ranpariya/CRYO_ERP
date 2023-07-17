<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row class="mb-1">
                    <b-col cols="12" md="9" class="d-flex justify-content-start align-items-center">
                        <b-button
                            variant="primary"
                            :to="{ name: 'add-additional-shift-rule'}"
                        > Add Additional Shift Rule
                        </b-button>
                        <b-button
                            variant="primary"
                            class="ml-1"
                            @click="openCopyShiftModal"
                        >
                            Copy Rule
                        </b-button>
                        <b-button
                            variant="primary"
                            class="ml-1"
                            @click="openImportShiftRuleModal"
                        >
                            Import Additional Shift Rules
                        </b-button>
                    </b-col>
                    <!-- ---------------search ---------------->
                    <b-col cols="12" md="3">
                        <div class="custom-search d-flex justify-content-end">
                            <b-form-group>
                                <div class="d-flex align-items-center">
                                    <label class="mr-1 mt-1">Search</label>
                                    <b-form-input
                                        v-model="searchTerm"
                                        placeholder="Search"
                                        type="text"
                                        class=" mt-1 d-inline-block"
                                    />
                                </div>
                            </b-form-group>
                        </div>
                    </b-col>
                </b-row>
                <!-- ---------------- table --------------------------------->
                <vue-good-table
                    :columns="columns"
                    :rows="rows"
                    :rtl="direction"
                    :search-options="{
                    enabled: true,
                    externalQuery: searchTerm }"
                    :select-options="{
                        enabled: false,
                        selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                        selectionInfoClass: 'custom-class',
                        selectionText: 'rows selected',
                        clearSelectionText: 'clear',
                        disableSelectInfo: true, // disable the select info panel on top
                        selectAllByGroup: true,
                      }"
                    :pagination-options="{
                        enabled: true,
                        perPage:pageLength
                    }"
                >
                    <template
                        slot="table-row"
                        slot-scope="props"
                    >

                        <!-- Column: Action -->
                        <span v-if="props.column.field === 'action'">
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
                          <b-dropdown-item :to="{name: 'edit-additional-shift-rule', params:{id: props.row._id}}">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                          </b-dropdown-item>
                          <b-dropdown-item @click="deleteAdditionalShiftRuleData(props.row._id)">
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
                                    :options="['3','5','10']"
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

        <!--   Modal for Copy Shift  -->
        <b-modal
            cancel-variant="danger"
            id="copyShiftModal"
            no-close-on-backdrop
            ref="copyShiftModal"
            ok-title="Save"
            size="sm"
            title="Copy Shift Rule"
        >
            <!-- scrollable-->
            <br>
            <b-row>
                <b-col md="12">
                    <b-row>
                        <b-col md="12">
                            <b-form-group
                                label="Shift"
                                label-for="select_shift"
                            >
                                <v-select
                                    v-model="formData.select_shift"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="shiftOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Shift"
                                    id="select_shift"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <br>
        </b-modal>
        <!-- IMPORT ADDITIONAL SHIFT MODAL-->
        <b-modal
            cancel-variant="danger"
            id="importAdditionalShiftRuleModal"
            no-close-on-backdrop
            ref="importAdditionalShiftRuleModal"
            scrollable
            :ok-disabled="true"
            size="lg"
            title="Import Additional Shift Rule"
        >
            <br>
            <b-row>
                <b-col md="12">
                    <b-form-group
                        label=""
                        label-for="importExcel"
                    >
                        <b-form-file
                            placeholder="Choose a file here..."
                            no-drop
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                            id="importExcel"
                            v-model="shiftFormData.importFile"
                            @change="getItemData($event)"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
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
            <br>
        </b-modal>

    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code/BCardCode'
    import {
        BButton,
        BCol,
        BDropdown,
        BDropdownItem,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BOverlay,
        BPagination,
        BRow,
        BFormFile
    } from 'bootstrap-vue'
    import {VueGoodTable} from 'vue-good-table'
    import {onUnmounted, ref} from '@vue/composition-api'
    import store from '@/store/index'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import {useToast} from "vue-toastification/composition";
    // import hrmsStoreModule from "../../../hrmsStoreModule";
    import Swal from "sweetalert2";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            VueGoodTable,
            BRow,
            BCol,
            BButton,
            BFormGroup,
            BFormInput,
            BPagination,
            BFormSelect,
            BDropdown,
            BDropdownItem,
            BCardCode,
            BOverlay,
            vSelect,
            BFormFile
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
        setup({copyShiftModal, importAdditionalShiftRuleModal}) {
            copyShiftModal = ref()
            importAdditionalShiftRuleModal = ref()
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })

            const uploadButton = ref({
                text: 'Upload File',
                isDisabled: false
            })

            const shiftOptions = ref([])
            /*  axios.get('/api/new/')
                 .then(res => {
                   formShiftOptions.value = res.data.data
           })*/

            const showOverlayLoading = ref(false)

            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Shift Code',
                    field: 'shiftCode',
                },
                {
                    label: 'Order Number',
                    field: 'orderNumber',
                },
                {
                    label: 'Update Values',
                    field: 'update_values',
                },
                {
                    label: 'Condition',
                    field: 'condition',
                },
                {
                    label: 'Is Active',
                    field: 'isActive',
                },
                {
                    label: 'Rule Remark',
                    field: 'rule_remark',
                },
                {
                    label: 'For Day Locked',
                    field: 'for_day_locked',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const formData = ref({
                select_shift:null,
            })

            const shiftFormData = ref({
                importFile:null,
            })

            const getItemData = (e) => {
                e.preventDefault()
                shiftFormData.value.importFile = e.target.files[0]
            }

            const downloadSampleFile = async () => {
             /* await axios.get('/import/').then((res) => {
                    let link = document.createElement('a');
                    document.body.appendChild(link);
                    link.href = res.data.path;
                    link.click();
                });*/
            }

            const openCopyShiftModal = () => {
                copyShiftModal.value.show();
            }

            const openImportShiftRuleModal = () => {
                importAdditionalShiftRuleModal.value.show();
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [
                    {
                        shiftCode: 'AW',
                        orderNumber: '1',
                        update_values: 'TotHrs>0',
                        condition: 'TotHrs>0',
                        isActive: 'YES',
                        rule_remark: 'In Process',
                        for_day_locked: 'YES'
                    }
                ]
                showOverlayLoading.value = false
            }
            refetchData()

            const deleteAdditionalShiftRuleData = async (id) => {
                /*   Swal.fire({
                       title: 'Are you sure?',
                       text: "Delete Additional Shift Rule",
                       icon: 'warning',
                       showCancelButton: true,
                       confirmButtonText: 'Yes, do it!',
                       cancelButtonText: 'No, keep it!',
                       customClass: {
                           confirmButton: 'btn btn-primary',
                           cancelButton: 'btn btn-outline-danger ml-1',
                       },
                       buttonsStyling: false,
                   }).then(result => {
                       if (result.value) {
                           store.dispatch(`hr-store-module/deleteAdditionalShiftRule`, {id: id}).then(res => {
                               if (res.status === 200) {
                                   toast({
                                       component: Toastification,
                                       position: 'top-right',
                                       props: {
                                           title: 'Additional Shift Rule Deleted',
                                           icon: 'CheckSquareIcon',
                                           variant: 'success',
                                           text: 'You have successfully Deleted Additional Shift Rule',
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
                           })
                           refetchData()
                       }
                   })*/
            }

            return {
                showOverlayLoading,
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
                deleteAdditionalShiftRuleData,
                openCopyShiftModal,
                uploadButton,
                openImportShiftRuleModal,
                copyShiftModal,
                shiftOptions,
                formData,
                shiftFormData,
                importAdditionalShiftRuleModal,
                getItemData,
                downloadSampleFile
            }
        },
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
