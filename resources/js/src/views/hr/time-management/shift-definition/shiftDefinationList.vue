<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row class="mb-1">
                    <b-col cols="12" md="8" class="d-flex justify-content-start align-items-center">
                        <b-button
                            variant="primary"
                            :to="{ name: 'add-shift-definition'}"
                        > Add Shift Definition
                        </b-button>
                        <b-button
                            variant="primary"
                            @click="openCopyShiftModal"
                            class="ml-1"
                        >
                            Copy Shift
                        </b-button>
                        <b-button
                            variant="primary"
                            class="ml-1"
                            :to="{name: 'additional-shift-rule'}"
                        >
                            Additional Shift Rule
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
                          <b-dropdown-item :to="{name: 'edit-shift-definition', params:{id: props.row._id}}">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                          </b-dropdown-item>
                          <b-dropdown-item @click="deleteShiftDefinition(props.row._id)">
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
        <!--Copy Shift Modal-->
        <b-modal
            cancel-variant="danger"
            id="copyShiftModal"
            no-close-on-backdrop
            ref="copyShiftModal"
            ok-title="Save"
            size="lg"
            title="Copy Shift"
        >
            <br>
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
                            <span>Following data will not be copied. Reporting Time, Leaving Time, Cutoff Time, Half Day Late Cut off Time, Remark,
                                  Available for Shift change request, This Shift Is Weekly Off And Do not consider Half day option while making Leave Application.</span><br><br>
                            <span>Existing Slab Setting will be removed and New Slab Setting will be copied from From Shift.</span>
                        </div>
                    </b-alert>
                    <hr>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="From Shift"
                                label-for="from_shift"
                            >
                                <v-select
                                    v-model="formData.from_shift"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="formShiftOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Shift"
                                    id="from_shift"
                                />
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="To Shift"
                                label-for="to_shift"
                            >
                                <v-select
                                    v-model="formData.to_shift"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="toShiftOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                    placeholder="Select Shift"
                                    id="to_shift"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
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
        BAlert
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
            vSelect
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
        setup({copyShiftModal}) {
            copyShiftModal = ref()
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })

            const formShiftOptions = ref([])
              /*  axios.get('/api/new/')
                .then(res => {
                    formShiftOptions.value = res.data.data
                })*/
            const toShiftOptions = ref([])
             /*   axios.get('/api/new/')
                    .then(res => {
                        toShiftOptions.value = res.data.data
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
                    field: 'shift_code',
                },
                {
                    label: 'In Time',
                    field: 'in_time',
                },
                {
                    label: 'Out Time',
                    field: 'out_time',
                },
                {
                    label: 'Cutoff Time',
                    field: 'cutOff_time',
                },
                {
                    label: 'In Cutoff Time',
                    field: 'in_cutOff_time',
                },
                {
                    label: 'Out Cutoff Time',
                    field: 'out_cutOff_time',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const formData = ref({
                form_shift: null,
                to_shift: null,
            })

            const openCopyShiftModal = () => {
                copyShiftModal.value.show();
            }


            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [{
                    shift_code: 'A1',
                    in_time: '9:30',
                    out_time: '6:30 PM',
                    cutOff_time: '8:45 AM',
                    in_cutOff_time: '03-Mar-23 08:46 AM',
                    out_cutOff_time: '04-Mar-23 04:15 AM'
                }]
                showOverlayLoading.value = false
            }
            refetchData()

            const deleteShiftDefinition = async (id) => {
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
                deleteShiftDefinition,
                openCopyShiftModal,
                copyShiftModal,
                formData,
                formShiftOptions,
                toShiftOptions
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
