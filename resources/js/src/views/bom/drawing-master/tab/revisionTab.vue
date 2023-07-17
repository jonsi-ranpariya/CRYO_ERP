<template>
    <div>
        <hr>
        <b-table
            :fields="RevisionFields"
            :items="listOfRevisions"
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
                    <b-dropdown-item @click="editRevisionData(data.item)">
                        <feather-icon
                            icon="Edit2Icon"
                            class="mr-50"
                        />
                        <span>Edit</span>
                    </b-dropdown-item>
                    <b-dropdown-item @click="deleteRevisionData(data.item._id)">
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
                <h4>Revision Detail</h4>
                <hr>
            </b-col>
        </b-row>

        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Revision"
                            label-for="drawingRev"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Revision"
                                rules="required"
                            >
                                <b-form-input
                                    id="drawingRev"
                                    v-model="RevisionFormData.drawingRev"
                                    placeholder="Revision"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Revision Date"
                            label-for="drawingRevDate"
                        >
                            <b-input-group>
                               <b-input-group-prepend>
                                    <b-form-datepicker
                                        v-model="formatDates.drawingRevDate"
                                        button-only
                                        @input="getRevisionFormateDate($event)"
                                        show-decade-nav
                                        size="sm"
                                        nav-button-variant="primary"
                                    />
                                </b-input-group-prepend>
                                <cleave
                                    id="drawingRevDate"
                                    v-model="RevisionFormData.drawingRevDate"
                                    class="form-control"
                                    :raw="false"
                                    :options="dateFormat"
                                    placeholder="DD/MM/YYYY"
                                    show-decade-nav
                                />
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Remark / Note"
                            label-for="drawingRevNote"
                        >
                            <b-form-textarea
                                id="drawingRevNote"
                                v-model="RevisionFormData.drawingRevNote"
                                rows="1"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <!-- submit and reset -->
                    <b-col>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1"
                            @click.prevent="validationForm"
                        >
                            Add / Save Revision
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
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
        BFormFile,
        BInputGroup,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, onUnmounted} from '@vue/composition-api'
    import bomStoreModule from '../../bomStoreModule'
    import axios from '@axios'
    import {getTcTodayDate, forMatIndianDate} from '@core/utils/utils'
    import Cleave from 'vue-cleave-component'

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
            BFormFile,
            Cleave,
            BInputGroup,
            BInputGroupPrepend
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const hasIdExist = this.containsKey(this.RevisionFormData, '_id')
                        if (hasIdExist) {
                            this.RevisionFormData.id = this.RevisionFormData._id
                            delete this.RevisionFormData._id
                            store.dispatch('dm-module/updateDrawingRevision', this.RevisionFormData).then(response => {
                                if (response.status === 200) {

                                    this.refetchRevisionData()

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Revision Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Revision : ${this.RevisionFormData.drawingRev}.`,
                                        },
                                    })

                                    this.resetRevisionFormData()
                                }
                            })
                        } else {
                            store.dispatch('dm-module/addDrawingRevision', this.RevisionFormData).then(response => {
                                if (response.status === 200) {
                                    this.refetchRevisionData()

                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Revision Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Revision : ${this.RevisionFormData.drawingRev}.`,
                                        },
                                    })

                                    this.resetRevisionFormData()
                                }
                            })
                        }
                    }
                })
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
            deleteRevisionData(id) {
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
                        store.dispatch(`dm-module/deleteDrawingRevision`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.refetchRevisionData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Revision Deleted Successfully`,
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
                                        text: `something went wrong`,
                                    },
                                })
                            }
                        })
                    }
                })
            }
        },
        setup() {

            const DM_APP_STORE_MODULE_NAME = 'dm-module'
            // Register module
            if (!store.hasModule(DM_APP_STORE_MODULE_NAME)) store.registerModule(DM_APP_STORE_MODULE_NAME, bomStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(DM_APP_STORE_MODULE_NAME)) store.unregisterModule(DM_APP_STORE_MODULE_NAME)
            })
            const CurrentDrawingId = ref(router.currentRoute.params.id)

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                drawingRevDate: null,
            })

            const getRevisionFormateDate = (date) => {
                RevisionFormData.value.drawingRevDate = forMatIndianDate(date)
            }

            const RevisionFields = ref([
                {
                    key: 'index',
                    label: 'Sr.No',
                },
                {
                    key: 'drawingRev',
                    label: 'Drg Rev',
                },
                {
                    key: 'drawingRevDate',
                    label: 'Rev. Date',
                },

                {
                    key: 'drawingRevNote',
                    label: 'Note',
                },
                {
                    key: 'action',
                    label: 'Action',
                },
            ])

            const listOfRevisions = ref([])
            axios.get(`/api/get-drawing-master-revision/${CurrentDrawingId.value}`).then(res => {
                if (res.data.data) {
                    listOfRevisions.value = res.data.data
                }
            })

            const refetchRevisionData = async () => {
                await axios.get(`/api/get-drawing-master-revision/${CurrentDrawingId.value}`).then(res => {
                    listOfRevisions.value = res.data.data
                })
            }

            const RevisionFormData = ref({
                id: null,
                drawingId: CurrentDrawingId.value,
                drawingRev: null,
                drawingRevDate: forMatIndianDate(getTcTodayDate()),
                drawingRevNote: null,
            })

            const resetRevisionFormData = () => {
                RevisionFormData.value = {
                    id: null,
                    drawingId: CurrentDrawingId.value,
                    drawingRev: null,
                    drawingRevDate: forMatIndianDate(getTcTodayDate()),
                    drawingRevNote: null,
                }
            }

            const editRevisionData = (RevisionEditdata) => {
                RevisionFormData.value = RevisionEditdata
            }
            return {
                CurrentDrawingId,
                RevisionFields,
                listOfRevisions,
                RevisionFormData,
                refetchRevisionData,
                resetRevisionFormData,
                editRevisionData,
                forMatIndianDate,
                required,
                getRevisionFormateDate,
                dateFormat,
                formatDates
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
