<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            :to="{name:'assign-unassign-attendance-group'}"
                        >
                            Assign/ Unassign Attendance Group
                        </b-button>
                        <b-button
                            variant="primary"
                            class="ml-2"
                            @click="openAttendanceGmasterImportModal"
                        >
                                Attendance Group Master - Import
                        </b-button>
                        <b-button
                            variant="primary"
                            class="ml-2"
                            :to="{name: 'convert-ot-co-utility'}"
                        >
                            Convert OT to CO+ Utility
                        </b-button>
                    </b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col md="12">
                        <b-button
                            variant="primary"
                            @click="openAssignGmasterImportModal"
                        >
                            Assign Attendance Group - Import
                        </b-button>
                        <b-button
                            variant="primary"
                            class="ml-3"
                            :to="{name:'assign-shift-to-attendance-group'}"
                        >
                            Assign Shift To Attendance Group
                        </b-button>
                        <b-button
                            variant="primary"
                            class="ml-2"
                            :to="{name:'assign-shift-to-employee'}"
                        >
                            Assign Shift to Employee
                        </b-button>
                    </b-col>
                </b-row>
            </b-card-code>
            <b-card-code>
                <b-row class="mb-1">
                    <b-col cols="12" md="8" class="d-flex justify-content-start align-items-center">
                        <b-button
                            variant="primary"
                            :to="{ name: 'add-attendance-group'}"
                        > Add Attendance Group
                        </b-button>
                    </b-col>
                    <!-- ---------------search ---------------->
                    <b-col cols="12" md="4">
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
                          <b-dropdown-item :to="{name: 'edit-attendance-group', params:{id: props.row._id}}">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                          </b-dropdown-item>
                          <b-dropdown-item @click="deleteAttendanceGroup(props.row._id)">
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
        <!--   Attendance Group Master Modal  -->
        <b-modal
            cancel-variant="danger"
            id="AttendanceGroupMasterModal"
            no-close-on-backdrop
            ref="AttendanceGroupMasterModal"
            ok-title="Save"
            hide-footer
            size="lg"
            scrollable
            title="Attendance Group Master"
        >
            <br>
            <b-row>
                <b-col md="12">
                    <b-form-group
                        label=""
                        label-for="importExcelFile"
                    >
                        <b-form-file
                            placeholder="Choose a file here..."
                            no-drop
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                            id="importExcelFile"
                            v-model="attendanceFormData.importAttendanceFile"
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
                        @click="downloadAssignFile"
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

        <!--  Assign Attendance Group -->
        <b-modal
            cancel-variant="danger"
            id="assignAttendanceGroupModal"
            no-close-on-backdrop
            ref="assignAttendanceGroupModal"
            ok-title="Save"
            hide-footer
            size="lg"
            scrollable
            title="Assign Attendance Group"
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
                            v-model="assignFormData.importAssignAttenFile"
                            @change="getAssignData($event)"
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
        BAlert,
        BFormFile
    } from 'bootstrap-vue'
    import {VueGoodTable} from 'vue-good-table'
    import {onUnmounted, ref} from '@vue/composition-api'
    import store from '@/store/index'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import hrmsStoreModule from "../../hrmsStoreModule";
    import Swal from "sweetalert2";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from "vue-toastification/composition";

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
            BAlert,
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
        setup({AttendanceGroupMasterModal, assignAttendanceGroupModal}) {
            AttendanceGroupMasterModal = ref()
            assignAttendanceGroupModal = ref()
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


            const showOverlayLoading = ref(false)

            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Attendance Group',
                    field: 'attendance_group',
                },
                {
                    label: 'Full Day Hours ',
                    field: 'full_day_hours',
                },
                {
                    label: 'Half Day Hours ',
                    field: 'half_day_hours',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const attendanceFormData = ref({
                importAttendanceFile: null,
            })
            const assignFormData = ref({
                importAssignAttenFile: null,
            })

            const openAssignGmasterImportModal = () => {
                assignAttendanceGroupModal.value.show();
            }
            const openAttendanceGmasterImportModal = () => {
                AttendanceGroupMasterModal.value.show();
            }

            const getItemData = (e) => {
                e.preventDefault()
                attendanceFormData.value.importAttendanceFile = e.target.files[0]
            }
            const getAssignData = (e) => {
                e.preventDefault()
                assignFormData.value.importAssignAttenFile = e.target.files[0]
            }
            const downloadSampleFile = async () => {
                /* await axios.get('/import/').then((res) => {
                       let link = document.createElement('a');
                       document.body.appendChild(link);
                       link.href = res.data.path;
                       link.click();
                   });*/
            }
            const downloadAssignFile = async () => {
                /* await axios.get('/import/').then((res) => {
                       let link = document.createElement('a');
                       document.body.appendChild(link);
                       link.href = res.data.path;
                       link.click();
                   });*/
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [{
                    attendance_group: 'A1',
                    full_day_hours: '2',
                    half_day_hours: '4',
                }]
                showOverlayLoading.value = false
            }
            refetchData()

            const deleteAttendanceGroup = async (id) => {
                /*  Swal.fire({
                      title: 'Are you sure?',
                      text: "Delete Shift Definition",
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
                          store.dispatch(`hr-store-module/deleteShiftDefinition`, {id: id}).then(res => {
                              if (res.status === 200) {
                                  toast({
                                      component: Toastification,
                                      position: 'top-right',
                                      props: {
                                          title: 'Shift Definition Deleted',
                                          icon: 'CheckSquareIcon',
                                          variant: 'success',
                                          text: 'You have successfully Deleted Shift Definition',
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
                deleteAttendanceGroup,
                AttendanceGroupMasterModal,
                assignAttendanceGroupModal,
                openAssignGmasterImportModal,
                openAttendanceGmasterImportModal,
                attendanceFormData,
                assignFormData,
                uploadButton,
                downloadSampleFile,
                downloadAssignFile,
                getItemData,
                getAssignData
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
