<template>
    <b-card-code>
        <b-row class="mb-2">
            <b-col
                cols="12"
                md="6"
                class="d-flex align-items-center justify-content-start"
            >
                <permission-management-add
                    :isAddPermissionManagementSidebarActive.sync="isAddPermissionManagementSidebarActive"
                    :permission-form-data.sync="permissionFormData"
                    @refetch-data="refetchData"
                />
                <b-button
                    variant="primary"
                    @click="addNewPermission"
                >
                    Add New Permission
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
            :rtl="false"
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
                      <b-dropdown-item @click="getPermissionManagementData(props.row)">
                        <feather-icon
                            icon="Edit2Icon"
                            class="mr-50"
                        />
                        <span>Edit</span>
                      </b-dropdown-item>
                      <b-dropdown-item @click="deletePermissionManagementData(props.row._id)">
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
                            :options="['5','10','20', '50', '100']"
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
} from 'bootstrap-vue'
import { VueGoodTable } from 'vue-good-table'
import { ref } from '@vue/composition-api'
import permissionManagementAdd from './permissionManagementAdd'
import axios from '@axios'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import Swal from 'sweetalert2'

export default {
    components: {
        permissionManagementAdd,
        BCardCode,
        VueGoodTable,
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
    },
    setup() {
        const isAddPermissionManagementSidebarActive = ref(false)

        const toast = useToast()

        const pageLength = ref(5)

        const columns = ref([
            {
                label: 'Permission Name',
                field: 'name',
            },
            {
                label: 'Action',
                field: 'action',
            },
        ])

        const rows = ref([])

        const searchTerm = ref('')

        const refetchData = async () => {
            await axios.get('/api/permission-management')
                .then((res) => {
                    rows.value = res.data.data
                })
        }
        refetchData()

        const permissionFormData = ref({
            _id: null,
            name: null
        })

        const addNewPermission = () => {
            permissionFormData.value._id = null
            permissionFormData.value.name = null
            isAddPermissionManagementSidebarActive.value = true
        }

        const getPermissionManagementData = (data) => {
            permissionFormData.value._id = data._id
            permissionFormData.value.name = data.name
            isAddPermissionManagementSidebarActive.value = true
        }

        const deletePermissionManagementData = async (id) => {
            await Swal.fire({
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
                    axios.delete(`/api/permission-management/${id}`)
                        .then((res) => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Permission Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Deleted Permission.',
                                    },
                                })
                            } else {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Warning',
                                        icon: 'CheckSquareIcon',
                                        variant: 'warning',
                                        text: 'Something Went Wrong.',
                                    },
                                })
                            }
                            refetchData();
                        })
                        .then((error) => {
                            if (error) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Error',
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: 'Internal Server Error.',
                                    },
                                })
                            }
                        })
                }
            })
        }

        return {
            isAddPermissionManagementSidebarActive,
            pageLength,
            columns,
            rows,
            searchTerm,
            refetchData,
            addNewPermission,
            getPermissionManagementData,
            deletePermissionManagementData,
            permissionFormData
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
