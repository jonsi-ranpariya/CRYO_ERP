<template>
    <div>
        <hr>
        <b-table
            :fields="documentsFields"
            :items="documentsData"
            :bordered="true"
            :hover="true"
            show-empty
            responsive
            class="mb-0 table_scroll"
        >
            <!-- A virtual column -->
            <template #cell(index)="data">
                {{ data.index + 1 }}
            </template>

            <!-- A custom formatted column -->
            <template #cell(action)="data">
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
                    <b-dropdown-item @click="openDocumentItem(data.item.documentItem)">
                        <feather-icon
                            icon="EyeIcon"
                            class="mr-50"
                        />
                        <span> View </span>
                    </b-dropdown-item>
                    <b-dropdown-item @click="deleteDocumentItem(data.item._id)">
                        <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                        />
                        <span>Delete</span>
                    </b-dropdown-item>
                </b-dropdown>
            </template>
        </b-table>

        <b-row>
            <b-col md="12">
                <hr>
                <h4>Document Detail</h4>
                <hr>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Document Name"
                    label-for="documentName"
                >
                    <b-form-input
                        type="text"
                        id="documentName"
                        v-model="formData.documentName"
                    />
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group
                    label="Select Document"
                    label-for="documentItem"
                >
                    <b-form-file
                        id="documentItem"
                        v-model="formData.documentItem"
                        @change="changeImage($event)"
                    />
                </b-form-group>
            </b-col>
            <b-col md="12">
                <hr>
                <b-button
                    variant="primary"
                    type="button"
                    @click="saveData"
                >
                    Save
                </b-button>
            </b-col>
        </b-row>
    </div>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormCheckbox,
    BFormTextarea,
    BForm,
    BDropdown,
    BDropdownItem,
    BButton,
    BFormDatepicker,
    BOverlay,
    BTable,
    BFormFile
} from 'bootstrap-vue'
import { required } from '@validations'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import router from '@/router'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { ref, onUnmounted } from '@vue/composition-api'
import bomStoreModule from '../../bomStoreModule'
import axios from '@axios'
import { getTcTodayDate, forMatIndianDate } from '@core/utils/utils'
import { useToast } from 'vue-toastification/composition'
import Swal from 'sweetalert2'
import moment from 'moment'

export default {
    components: {
        BCardCode,
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BFormGroup,
        BFormCheckbox,
        BFormInput,
        BFormTextarea,
        BForm,
        BButton,
        BDropdown,
        BDropdownItem,
        BFormDatepicker,
        vSelect,
        BOverlay,
        BTable,
        BFormFile
    },
    directives: {
        Ripple,
    },
    setup() {

        const DM_APP_STORE_MODULE_NAME = 'dm-module'
        // Register module
        if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(DM_APP_STORE_MODULE_NAME)) store.unregisterModule(DM_APP_STORE_MODULE_NAME)
        })
        const currentDrawingId = router.currentRoute.params.id

        const toast = useToast()
        const documentsFields = ref([
            {
                key: 'index',
                label: 'No'
            },
            {
                key: 'documentName',
                label: 'Document Name'
            },
            {
                key: 'upload_by',
                label: 'Upload By',
                formatter: val => val.first_name + ' ' + val.last_name
            },
            {
                key: 'created_at',
                label: 'Upload Date',
                formatter: val => forMatIndianDate(val)
            },
            {
                key: 'action',
                label: 'Actions'
            }
        ])
        const documentsData = ref([])

        const formData = ref({
            drawingId: currentDrawingId,
            documentName: null,
            documentItem: null,
        })

        const resetFormData = () => {
            formData.value.documentName = null
            formData.value.documentItem = null
        }

        const refetchData = async () => {
            await axios.get(`/api/get-drawing-master-document-data/${currentDrawingId}`)
                .then(res => {
                    documentsData.value = res.data.data
                })
        }
        refetchData()

        const changeImage = (e) => {
            e.preventDefault()
            formData.value.documentItem = e.target.files[0]
        }

        const saveData = async () => {
            if (formData.value.documentName === null) {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `Warning`,
                        icon: 'AlertCircleIcon',
                        variant: 'warning',
                        text: `Please Fill Document Name.`,
                    },
                })
            } else if (formData.value.documentItem === null) {
                toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `Warning`,
                        icon: 'AlertCircleIcon',
                        variant: 'warning',
                        text: `Please select any file.`,
                    },
                })
            } else {
                const newFormData = new FormData()
                newFormData.append('drawingId', formData.value.drawingId)
                newFormData.append('documentItem', formData.value.documentItem)
                newFormData.append('documentName', formData.value.documentName)
                await store.dispatch('dm-module/adddrawingDocuments', newFormData)
                    .then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Drawing Document Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Drawing Master Document.`,
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: `Error`,
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: `something went wrong`,
                                },
                            })
                        }
                    })
                resetFormData()
                await refetchData()
            }
        }

        const openDocumentItem = (url) => {
            window.open(url, '_blank')
        }

        const deleteDocumentItem = async (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Do It!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-outline-success',
                    cancelButton: 'btn btn-outline-danger ml-1',
                },
                buttonsStyling: false,
            })
                .then(result => {
                    if (result.isConfirmed) {
                        store.dispatch('dm-module/deletedrawingDocuments', { id: id })
                            .then(res => {
                                if (res.data.status === 200) {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Drawing Document Deleted',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Deleted Drawing Master Document.`,
                                        },
                                    })
                                } else {
                                    toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: `Error`,
                                            icon: 'AlertCircleIcon',
                                            variant: 'danger',
                                            text: `${res.data.message}`,
                                        },
                                    })
                                }
                            })
                        resetFormData()
                        refetchData()
                    }
                })
        }

        return {
            currentDrawingId,
            documentsFields,
            documentsData,
            formData,
            changeImage,
            refetchData,
            saveData,
            openDocumentItem,
            deleteDocumentItem
        }
    }
}
</script>
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
