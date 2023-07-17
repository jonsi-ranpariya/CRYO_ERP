<template>
    <div>
        <!-- Stats Card Vertical -->
        <b-row class="match-height">
            <b-col
                xl="2"
                md="4"
                sm="6"
            >
                <statistic-card-vertical
                    icon="AlertCircleIcon"
                    statistic="12"
                    statistic-title="Mandatory"
                    color="primary"
                />
            </b-col>
            <span class="mt-5"> + </span>
            <b-col
                xl="2"
                md="4"
                sm="6"
            >
                <statistic-card-vertical
                    color="primary"
                    icon="AlignJustifyIcon"
                    statistic="1"
                    statistic-title="Optional"
                />
            </b-col>
            <span class="mt-5"> = </span>
            <b-col
                xl="2"
                md="4"
                sm="6"
            >
                <statistic-card-vertical
                    color="primary"
                    icon="ShoppingBagIcon"
                    statistic="13"
                    statistic-title="Total Holidays Defined"
                />
            </b-col>
            <b-col
                xl="2"
                md="4"
                sm="6"
            >
                <statistic-card-vertical
                    color="primary"
                    icon="CalendarIcon"
                    statistic="14"
                    statistic-title="Total Holidays Available in Setup"
                />
            </b-col>
            <b-col
                xl="2"
                md="4"
                sm="6"
            >
                <statistic-card-vertical
                    color="primary"
                    icon="GridIcon"
                    statistic="1"
                    statistic-title="Need to Define More"
                />
            </b-col>
        </b-row>

        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-row class="mb-1">
                    <b-col cols="12" md="3" class="d-flex justify-content-start align-items-center">
                        <b-button
                            variant="primary"
                            :to="{ name: 'add-holiday-master'}"
                        > Add Holiday Master
                        </b-button>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                        >
                            <v-select
                                v-model="formData.calendar_name"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="calenderNameOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Name"
                                id="calendar_name"
                                class="mt-2"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="2">
                        <b-form-group
                        >
                            <v-select
                                v-model="formData.year"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="yearOptions"
                                :clearable="false"
                                :reduce="val => val.value"
                                placeholder="Select Year"
                                id="year"
                                class="mt-2"
                            />
                        </b-form-group>
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
                          <b-dropdown-item :to="{name: 'edit-holiday-master', params:{id: props.row._id}}">
                            <feather-icon
                                icon="Edit2Icon"
                                class="mr-50"
                            />
                            <span>Edit</span>
                          </b-dropdown-item>
                          <b-dropdown-item @click="deleteHolidayMaster(props.row._id)">
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
        BCard,
        BCardText,
        BCardBody,
        BMediaBody
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
    import StatisticCardVertical from "@core/components/statistics-cards/StatisticCardVertical";
    import moment from "moment";

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
            StatisticCardVertical,
            BCard,
            BCardText,
            BCardBody,
            BMediaBody
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
            // const toast = useToast()
            // //using store module
            // const SE_APP_STORE_MODULE_NAME = 'hr-store-module'
            // if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, hrmsStoreModule)
            // onUnmounted(() => {
            //     if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            // })

            const calenderNameOptions = ref([
                {label: 'Holiday_Factory', value: 1},
                {label: 'Holiday_Staff', value: 2},
            ])

            let year = {
                currentYear: moment().year(),
                lastYear: moment().subtract(1, 'year').year(),
                secondLastYear: moment().subtract(2, 'year').year(),
            }

            const yearOptions = ref([
                {
                    label: `${year.currentYear}`,
                    value: `${year.currentYear}`
                },
                {
                    label: `${year.lastYear}`,
                    value: `${year.lastYear}`
                },
                {
                    label: `${year.secondLastYear}`,
                    value: `${year.secondLastYear}`
                }
            ])

            const showOverlayLoading = ref(false)

            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref(5)
            const dir = ref(false)
            const rows = ref([])
            const columns = ref([
                {
                    label: 'Date',
                    field: 'date',
                },
                {
                    label: 'Calendar Name',
                    field: 'calendar_name',
                },
                {
                    label: 'Holiday Name',
                    field: 'holiday_name',
                },
                {
                    label: 'Holiday Type',
                    field: 'holiday_type',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ])

            const formData = ref({
                calendar_name: 1,
                year: `${year.currentYear}`,
            })

            const refetchData = async () => {
                showOverlayLoading.value = true
                rows.value = [{
                    date: '12/02/2023',
                    calendar_name: 'Holiday_Factory_2020',
                    holiday_name: 'Makarsankranti',
                    holiday_type: 'Optional',
                }]
                showOverlayLoading.value = false
            }
            refetchData()

            const deleteHolidayMaster = async (id) => {
                /*  Swal.fire({
                      title: 'Are you sure?',
                      text: "Delete Holiday Master",
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
                          store.dispatch(`hr-store-module/deleteHolidayMaster`, {id: id}).then(res => {
                              if (res.status === 200) {
                                  toast({
                                      component: Toastification,
                                      position: 'top-right',
                                      props: {
                                          title: 'Holiday Master Deleted',
                                          icon: 'CheckSquareIcon',
                                          variant: 'success',
                                          text: 'You have successfully Deleted Holiday Master,
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
                deleteHolidayMaster,
                calenderNameOptions,
                yearOptions,
                formData
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
