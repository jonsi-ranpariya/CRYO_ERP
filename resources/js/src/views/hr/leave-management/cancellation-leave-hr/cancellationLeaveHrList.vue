<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row>
                    <b-col md="12">
                        <b-alert
                            variant="danger"
                            show
                        >
                            <h4 class="alert-heading">
                                Note:
                            </h4>
                            <div class="alert-body">
                                <span>It will not display approved leaves order than 6 months (Comparison will be done from application from date).</span><br><br>
                            </div>
                        </b-alert>
                    </b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols="12" md="6" class="justify-content-start d-flex align-items-center">
                        <b-button
                            variant="danger"
                            class="float-left "
                            @click="cancleLeave"
                        >
                            Cancel Leave HR
                        </b-button>
                    </b-col>
                    <!--------- Search ------------>
                    <b-col cols="12" md="6">
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
                <!-- Table -->
                <vue-good-table
                    @on-selected-rows-change="selectionChanged"
                    :columns="columns"
                    :rows="rows"
                    :rtl="direction"
                    :search-options="{
                        enabled: true,
                        externalQuery: searchTerm
                    }"
                    :select-options="{
                       enabled: true,
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
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
        BButton,
        BDropdown,
        BDropdownItem,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BOverlay,
        BPagination,
        BAlert
    } from 'bootstrap-vue'
    import BCardCode from "@core/components/b-card-code/BCardCode";
    import Swal from "sweetalert2";
    import axios from '@axios'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store/index'
    import {ref} from "@vue/composition-api";
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BCardCode,
            BRow,
            BCol,
            BButton,
            BDropdown,
            BDropdownItem,
            BFormGroup,
            BFormInput,
            BFormSelect,
            BOverlay,
            BPagination,
            VueGoodTable,
            BAlert
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
        setup() {
            const toast = useToast()

            const showOverlayLoading = ref(false)
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'App. ID',
                    field: 'applicationId',
                },
                {
                    label: 'Employee Code',
                    field: 'employeeCode',
                },
                {
                    label: 'Employee Name',
                    field: 'employeeName',
                },
                {
                    label: 'From Date',
                    field: 'from_date',
                },
                {
                    label: 'To Date',
                    field: 'to_date',
                },
                {
                    label: 'Apply Day',
                    field: 'total_days',
                },
                {
                    label: 'Remarks',
                    field: 'remarks',
                },
                {
                    label: 'Status',
                    field: 'status',
                },
                {
                    label: 'Leave Type',
                    field: 'leave_type',
                },
            ])


            const ItemList = ref([])
            const selectionChanged = (e, items) => {
                if (e === false) {
                    ItemList.value = ItemList.value.filter(function (e) {
                        return e !== items
                    })
                } else {
                    ItemList.value.push(items)
                }
                console.log(ItemList.value)
            }

            // const selectionChanged = (items) => {
            //
            // }

            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [
                    {
                        applicationId: '12234',
                        employeeCode: 'E0001',
                        employeeName: 'John Patel',
                        from_date: '23/03/2023',
                        to_date: '26/03/2023',
                        total_days: '4',
                        remarks: 'Leave Apply',
                        status: 'In Process',
                        leave_type: 'Casual Leave (CL)'
                    },
                    {
                        applicationId: '3443',
                        employeeCode: 'E0003',
                        employeeName: 'Shiv Patel',
                        from_date: '24/03/2023',
                        to_date: '28/03/2023',
                        total_days: '5',
                        remarks: 'Leave Approved',
                        status: 'Rejected',
                        leave_type: 'Sick Leave (sL)'
                    },
                    {
                        applicationId: '453534',
                        employeeCode: 'E0003',
                        employeeName: 'Piyu Patel',
                        from_date: '24/03/2023',
                        to_date: '25/03/2023',
                        total_days: '2',
                        remarks: 'Leave Apply',
                        status: 'cancel',
                        leave_type: 'Casual Leave (CL)'
                    },
                ]
                showOverlayLoading.value = false
            }
            refetchData()

            const cancleLeave = async () => {
                // ItemList.value = []
                // console.log(ItemList.value)
                Swal.fire({
                    title: 'Remark',
                    input: 'text',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                    inputAttributes: {
                        autocapitalize: 'off',
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    allowOutsideClick: false,
                }).then(result => {
                    if (result.isConfirmed) {
                        axios.post('/api/new/', {
                            ids: ItemList.value,
                            remarks: '',
                        })
                            .then((res) => {
                                toast({
                                    component: Toastification,
                                    position: 'top-right',
                                    props: {
                                        title: 'Cancellation Leave - HR',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Cancellation Leave for HR',
                                    },
                                })
                            })
                    }
                    if (result.isDismissed) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Cancel',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong!',
                            },
                        })
                    }
                })
            }
            return {
                cancleLeave,
                searchTerm,
                pageLength,
                rows,
                columns,
                dir,
                refetchData,
                showOverlayLoading,
                selectionChanged,
                ItemList

            }
        }
    }
</script>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
