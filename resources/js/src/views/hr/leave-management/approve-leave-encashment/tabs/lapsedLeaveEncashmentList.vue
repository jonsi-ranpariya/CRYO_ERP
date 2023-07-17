<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-row class="mb-1">
                <!-- ---------------search ---------------->
                <b-col cols="12">
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
                          <b-dropdown-item @click="approveLeave(props.row)">
                            <feather-icon
                                icon="CheckSquareIcon"
                                class="mr-50"
                            />
                            <span>Approved</span>
                          </b-dropdown-item>
                          <b-dropdown-item :to="{ name: 'edit-approve-leave-encashment', params: { id: props.row._id} }">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
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
                        <div class="d-flex align-items-center mb-0 mt-1 ml-1">
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
        </b-overlay>
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
        BRow
    } from 'bootstrap-vue'
    import {VueGoodTable} from 'vue-good-table'
    import {onUnmounted, ref} from '@vue/composition-api'
    import store from '@/store/index'
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

            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Leave Type',
                    field: 'leave_type',
                },
                {
                    label: 'Encashment Days',
                    field: 'encashment_days',
                },
                {
                    label: 'Remark',
                    field: 'remark',
                },
                {
                    label: 'Status',
                    field: 'status',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [
                    {
                        leave_type: 'Privilege Leave (CL)',
                        encashment_days: '34',
                        remark: 'Leave Apply',
                        status: 'In Process',
                    }
                ]
                showOverlayLoading.value = false
            }
            refetchData()

            const approveLeave = async (data) => {
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Leave is",
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Yes, Approve!',
                    denyButtonText: 'No, Decline!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-outline-success',
                        cancelButton: 'btn btn-outline-danger ml-1',
                        denyButton: 'btn btn-outline-warning ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.isConfirmed) {
                        acceptDeclineEvent(data, 2)
                    }
                    if (result.isDenied) {
                        acceptDeclineEvent(data, 3)
                    }
                    if (result.isDismissed) {
                        toast({
                            component: Toastification,
                            position: 'top-right',
                            props: {
                                title: 'Cancel',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'You have abort the task!',
                            },
                        })
                    }
                })
            }
            const acceptDeclineEvent = async (data, status) => {}

            return {
                showOverlayLoading,
                searchTerm,
                pageLength,
                dir,
                columns,
                rows,
                approveLeave,
                acceptDeclineEvent
            }
        },
    }

</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-good-table.scss';
</style>
