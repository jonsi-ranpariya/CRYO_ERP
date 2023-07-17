<template>
    <b-overlay
        :show="showOverlayLoading"
        rounded="sm"
    >
    <b-card-code>
        <b-row class="mb-1">
            <b-col cols="12" md="6" class="d-flex justify-content-start align-items-center">
                <b-button
                    variant="primary"
                    :to="{name:'add-term-condition-template-master'}"
                > Add Terms & Condition Template
                </b-button>
            </b-col>

            <!-- ---------------search ---------------->
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
        <!--table-->
        <vue-good-table
            :columns="tableData.fields"
            :rows="tableData.rows"
            :line-numbers="true"
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
                        perPage:tableData.perPage
                    }"
        >
            <template
                slot="table-row"
                slot-scope="props"
            >
                <!-- Column: Name -->
                <span
                    v-if="props.column.field === 'status'"
                    class="text-nowrap"
                >
                          <span v-if="props.row.status === 1 ">
                              <b-badge variant="success">
                                  Active
                              </b-badge>
                          </span>
                          <span v-else-if="props.row.status === 2 ">
                              <b-badge variant="danger">
                                  Inactive
                              </b-badge>
                          </span>
                          <span v-else></span>
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
                              <b-dropdown-item  :to="{name: 'edit-term-condition-template-master',params: {id: props.row._id}}">
                                <feather-icon
                                    icon="Edit2Icon"
                                    class="mr-50"
                                />
                                <span>Edit</span>
                              </b-dropdown-item>
                              <b-dropdown-item  @click="deleteTermsConditionTemplate(props.row._id)">
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
            pagination
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
                            v-model="tableData.perPage"
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
                            :per-page="tableData.perPage"
                            first-number
                            last-number
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
</template>
<script>
    import BCardCode from '../../../@core/components/b-card-code/BCardCode'
    import {  BRow,
        BCol,
        BButton,
        BFormGroup,
        BFormInput,
        BPagination,
        BFormSelect,
        BDropdown,
        BDropdownItem,
  BOverlay,
        BBadge,
    } from 'bootstrap-vue'
    import  {VueGoodTable} from 'vue-good-table'
    import {onUnmounted, ref} from '@vue/composition-api'
    import axios from '@axios'
    import masterStoreModule from "../masterStoreModule";
    import {useToast} from "vue-toastification/composition";
    import Toastification from "@core/components/toastification/ToastificationContent.vue";
    import store from '@/store'
    import Swal from "sweetalert2";
    export default {
        components:{
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
            BBadge,
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

            const ITEMADDON_APP_STORE_MODULE_NAME = 'terms-condition-template-master'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, masterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })

            const showOverlayLoading = ref(false)
            //search
            const searchTerm = ref('')
            //pagination
            const pageLength = ref('')
            const dir = ref(false)
            const tableData = ref({
                fields: [
                    {
                        label: 'Template',
                        field: 'templateName',
                    },
                    {
                        label: 'Status',
                        field: 'status',
                    },
                    {
                        label: 'Action',
                        field: 'action',
                        sortable: false,
                    },
                ],
                rows: [],
                perPage: 5,
            })

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get('/api/term-condition-template-master').then(res => {
                    tableData.value.rows = res.data.data
                })
                showOverlayLoading.value = false
            }
            refetchData()

            const deleteTermsConditionTemplate = async (id) =>{
                await Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Terms Condition Template",
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
                        store.dispatch('terms-condition-template-master/deleteTermsConditionTemplateMaster', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: Toastification,
                                    position: 'top-right',
                                    props: {
                                        title: 'Terms Condition Template Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Terms Condition Template',
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
                })
            }
            return {
                searchTerm,
                pageLength,
                dir,
                tableData,
                refetchData,
                showOverlayLoading,
                deleteTermsConditionTemplate
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
