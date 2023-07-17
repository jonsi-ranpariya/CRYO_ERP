<template>
    <b-overlay
        :show="$store.state.hrMasterStoreModule.showOverlayLoading"
        rounded="sm"
    >
        <div>
            <branch-master-add-edit
                :branchFormData.sync="formData"
                 @resetFormData="resetFormData()"
            />

            <b-card-code>
                <b-row class="mb-2">
                    <b-col
                        cols="12"
                        md="6"
                        class="d-flex align-items-center justify-content-start"
                    >
                        <b-button
                            variant="primary"
                            @click="addEditBranchMaster"
                        >
                            Add Branch
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
                                        v-model="tableData.searchTerm"
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
                    :columns="tableData.columns"
                    :rows="$store.getters['hrMasterStoreModule/getBranchMasterList']"
                    :line-numbers="true"
                    :rtl="direction"
                    :search-options="{
                        enabled: true,
                        externalQuery: tableData.searchTerm
                    }"
                    :select-options="{
                        enabled: false,
                        selectOnCheckboxOnly: true,
                        selectionInfoClass: 'custom-class',
                        selectionText: 'rows selected',
                        clearSelectionText: 'clear',
                        disableSelectInfo: true,
                        selectAllByGroup: true,
                    }"
                    :pagination-options="{
                        enabled: true,
                        perPage:tableData.pageLength
                    }"
                >
                    <template
                        slot="table-row"
                        slot-scope="props"
                    >

                        <!-- Column: Action -->
                        <span v-if="props.column.field === 'action'"><span>
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
                              <b-dropdown-item @click="editBranchMaster(props.row)">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                              </b-dropdown-item>
                              <b-dropdown-item @click="deleteBranchMasterData(props.row._id)">
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
                                    v-model="tableData.pageLength"
                                    :options="['5','10','20','50']"
                                    class="mx-1"
                                    @input="(value)=>props.perPageChanged({currentPerPage:value})"
                                />
                                <span class="text-nowrap"> of {{ props.total }} entries </span>
                            </div>
                            <div>
                                <b-pagination
                                    :value="1"
                                    :total-rows="props.total"
                                    :per-page="tableData.pageLength"
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
</template>
<script>
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {
        BPagination,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BDropdown,
        BDropdownItem,
        BButton,
        BRow,
        BCol,
        BOverlay
    } from 'bootstrap-vue';
    import {ref, onUnmounted, onMounted} from '@vue/composition-api';
    import {VueGoodTable} from 'vue-good-table';
    import store from '@/store';
    import branchMasterAddEdit from "./branchMasterAddEdit";
    import hrMasterStoreModule from "../hrMasterStoreModule";
    import Swal from "sweetalert2";
    import Toastification from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from "vue-toastification/composition";

    export default {
        components: {
            branchMasterAddEdit,
            hrMasterStoreModule,
            BCardCode,
            VueGoodTable,
            BButton,
            BRow,
            BCol,
            BPagination,
            BFormGroup,
            BFormInput,
            BFormSelect,
            BDropdown,
            BDropdownItem,
            BOverlay
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
            const toast = useToast();

            const STORE_APP_STORE_MODULE_NAME = 'hr-master-store-module'
            onMounted(() => {
                if (!store.hasModule(STORE_APP_STORE_MODULE_NAME)) store.registerModule(STORE_APP_STORE_MODULE_NAME, hrMasterStoreModule)
            });
            onUnmounted(() => {
                if (store.hasModule(STORE_APP_STORE_MODULE_NAME)) store.unregisterModule(STORE_APP_STORE_MODULE_NAME)
            });
            store.dispatch('hrMasterStoreModule/listBranchMaster');

            const tableData = ref({
                columns: [
                    {label: 'Branch', field: 'branch'},
                    {label: 'Action', field: 'action'},
                ],
                searchTerm: '',
                pageLength: 5,
                dir: false
            });

            const blankFormData = {
                _id: null,
                branch: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)));

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const addEditBranchMaster = async () => {
                await store.commit('hrMasterStoreModule/sideBarShowHide', true);
            }

            const editBranchMaster = async (data) => {
                formData.value = data;
                await store.commit('hrMasterStoreModule/sideBarShowHide', true);
            }
            const deleteBranchMasterData = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Branch Master",
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
                        store.dispatch('hrMasterStoreModule/deleteBranchMaster', {id: id})
                            .then(res => {
                                if (res.status === 200) {
                                    toast({
                                        component: Toastification,
                                        position: 'top-right',
                                        props: {
                                            title: 'Branch Master Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: 'You have successfully Deleted Branch Master',
                                        },
                                    })
                                }
                            }).catch(() => {
                            toast({
                                component: Toastification,
                                position: 'top-right',
                                props: {
                                    title: `Error`,
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Internal server error.',
                                },
                            });
                        });
                        store.dispatch('hrMasterStoreModule/listBranchMaster');
                        // refetchData()
                    }
                })
            }
            return {
                formData,
                resetFormData,
                addEditBranchMaster,
                editBranchMaster,
                deleteBranchMasterData,
                tableData
                // refetchData,
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

