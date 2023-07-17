<template>
    <div>
        <app-collapse accordion type="border">
            <app-collapse-item title="Search Area">
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="Party Code"
                            label-for="party-code"
                        >
                            <b-form-input
                                id="party-code"
                                placeholder="Party Code"
                                v-model="searchFormData.partyCode"
                                v-uppercase-input
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Party Name"
                            label-for="party-name"
                        >
                                <b-form-input
                                    id="party-name"
                                    v-model="searchFormData.partyName"
                                    placeholder="Party Name"
                                    v-uppercase-input
                                />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Party Type"
                            label-for="party-type"
                        >
                            <v-select
                                v-model="searchFormData.partyType"
                                placeholder="Select Party Type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="PartyTypeOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="party-type"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="Party Status"
                            label-for="partyStatus"
                        >
                            <v-select
                                placeholder="Select Party Status"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="PartyStatusOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                v-model="searchFormData.partyStatus"
                                input-id="partyStatus"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="District‌"
                            label-for="party-city"
                        >
                                <v-select
                                    placeholder="Select District‌"
                                    v-model="searchFormData.partyCity"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="cityOptions"
                                    :clearable="false"
                                    input-id="party-city"
                                />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                            <b-form-group
                                label="State"
                                label-for="party-state"
                            >
                                <v-select
                                    placeholder="Select State"
                                    v-model="searchFormData.partyState"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="stateOptions"
                                    :clearable="false"
                                    input-id="party-state"
                                />
                            </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="Branch"
                            label-for="branch"
                        >
                            <v-select
                                placeholder="Select Party Branch"
                                v-model="searchFormData.partyBranch"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="branchOption"
                                :clearable="false"
                                input-id="branch"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Company Profile"
                            label-for="company-profile"
                        >
                            <b-form-textarea
                                id="company-profile"
                                placeholder="Company Profile"
                                rows="1"
                                v-model="searchFormData.profile"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col md="4"></b-col>
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
        <!--lIST TABLE-->
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
        <div>
            <b-card-code class="mt-1">
                <b-row class="mb-2">
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start"
                    >
                        <!-- Add New Party Button -->
                        <b-button
                            variant="primary"
                            :to="{ name: 'add-party-master'}"
                            v-if="$can('create','party-master')"
                        >
                            Add New Party
                        </b-button>
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
                >
                    <template
                        slot="table-row"
                        slot-scope="props"
                    >
                        <!-- Column: Name -->
                        <span v-if="props.column.field === 'partyBranchLabel'">
                            <span class="text-nowrap" v-if="props.row.partyBranch !== null">{{ props.row.partyBranch.label }}</span>
                            <span class="text-nowrap" v-else>N/A</span>
                        </span>
                        <span v-if="props.column.field === 'CompanyProfile'">
                            <span class="text-nowrap" v-if="typeof (props.row.companyProfile) === 'object'">{{ props.row.companyProfile.profile }}</span>
                            <span class="text-nowrap" v-else>N/A</span>
                        </span>
                        <span v-if="props.column.field === 'city'">
                            <span class="text-nowrap" v-if="typeof (props.row.partyDetails) === 'object' && props.row.partyDetails.partyCity !== null">{{ props.row.partyDetails.partyCity.label }}</span>
                            <span class="text-nowrap" v-else>N/A</span>
                        </span>
                        <span v-if="props.column.field === 'state'">
                            <span class="text-nowrap" v-if="typeof (props.row.partyDetails) === 'object' && props.row.partyDetails.partyState !== null">{{ props.row.partyDetails.partyState.label }}</span>
                            <span class="text-nowrap" v-else>N/A</span>
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
                              <b-dropdown-item :to="{ name: 'edit-party-master', params: { id: props.row._id} }">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                              </b-dropdown-item>
                              <b-dropdown-item @click="deleteMyCurrentErpData(props.row._id)">
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
        </div>
    </b-overlay>
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
        BOverlay,
        BFormTextarea
    } from 'bootstrap-vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {VueGoodTable} from 'vue-good-table'
    import store from '@/store'
    import partyStoreModule from '../partyStoreModule'
    import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
    import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
    import axios from '@axios'
    import vSelect from 'vue-select'
    import {uppercaseInput} from "@core/utils/utils";
    import {useToast} from "vue-toastification/composition";

    export default {
        components: {
            BCardCode,
            VueGoodTable,
            BOverlay,
            BAvatar,
            BBadge,
            BButton,
            BRow,
            BCol,
            BPagination,
            BFormGroup,
            BFormInput,
            BFormSelect,
            BDropdown,
            BDropdownItem,
            AppCollapse,
            AppCollapseItem,
            vSelect,
            BFormTextarea
        },
        directives: {
            uppercaseInput,
        },
        data() {
            return {
                pageLength: 5,
                dir: false,
                searchTerm: '',
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
        setup() {
            const  showOverlayLoading = ref(false)
            const toast = useToast()
            const PARTY_APP_STORE_MODULE_NAME = 'party-master-module'
            if (!store.hasModule(PARTY_APP_STORE_MODULE_NAME)) store.registerModule(PARTY_APP_STORE_MODULE_NAME, partyStoreModule)
            onUnmounted(() => {
                if (store.hasModule(PARTY_APP_STORE_MODULE_NAME)) store.unregisterModule(PARTY_APP_STORE_MODULE_NAME)
            })
            const PartyTypeOption = ref([])
                axios.get('/api/get-party-type-options').then(res => {
                    PartyTypeOption.value = res.data.data
                })
            const PartyStatusOption = ref([
                {label: 'Created', value: 'Created'},
                {label: 'Trial', value: 'Trial'},
                {label: 'Approved', value: 'Approved'},
                {label: 'Rejected', value: 'Rejected'}
            ])
            const cityOptions = ref([])
            axios.get('/api/get-city-options').then(res => {
                cityOptions.value = res.data.data
            })
            const stateOptions = ref([])
            axios.get('/api/get-state-options').then(res => {
                stateOptions.value = res.data.data
            })
            const branchOption = ref([])
            axios.get('/api/get-branch-master-options').then(res => {
                branchOption.value = res.data.data
            })

            const columns = ref([
                {
                    label: 'Party Code',
                    field: 'partyCode',
                },
                {
                    label: 'Party Name',
                    field: 'partyName',
                },
                {
                    label: 'District',
                    field: 'city',
                },
                {
                    label: 'State',
                    field: 'state',
                },
                {
                    label: 'Branch Code',
                    field: 'partyBranchLabel',
                },
                {
                    label: 'Company Profile',
                    field: 'CompanyProfile',
                },
                {
                    label: 'Party Type',
                    field: 'party_type_name',
                },
                {
                    label: 'Party Status',
                    field: 'partyStatus',
                },
                {
                    label: 'Action',
                    field: 'action',
                },
            ]);
            const rows = ref([])

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get('/api/party/get').then((res) => {
                    rows.value = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const blankSearchForm = {
                partyCode:null,
                partyName:null,
                partyType:null,
                partyStatus:null,
                partyCity:null,
                partyState:null,
                partyBranch:null,
                profile:null,
            }
            const searchFormData = ref(JSON.parse(JSON.stringify(blankSearchForm)));

            const resetSearchFormData = async () => {
                searchFormData.value = JSON.parse(JSON.stringify(blankSearchForm));
                await refetchData();
            }
            const applyFilter = async () => {
                showOverlayLoading.value = true
                await axios.post('/api/new/get-party-master-list-filter', searchFormData.value).then(res =>{
                    rows.value = res.data.data
                }).catch((error) => {
                    toast({
                        component: ToastificationContent,
                        position: 'top-right',
                        props: {
                            title: `Error: ${error.response.status}`,
                            icon: 'AlertCircleIcon',
                            variant: 'danger',
                            text: error.response.statusText,
                        },
                    });
                });
                showOverlayLoading.value = false
            }
            return{
                showOverlayLoading,
                refetchData,
                columns,
                rows,
                searchFormData,
                resetSearchFormData,
                PartyTypeOption,
                PartyStatusOption,
                cityOptions,
                stateOptions,
                branchOption,
                applyFilter
            }
        },
        methods: {
            deleteMyCurrentErpData(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch(`party-master-module/deletePartyMaster`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.refetchData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Party Master Delete Successfully`,
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
                                        text: response.data.message,
                                    },
                                })
                            }
                        })
                    }
                })
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
