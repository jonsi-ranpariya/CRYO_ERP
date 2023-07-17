<template>
    <b-form @submit.prevent="submitFormData">
        <b-row>
            <b-col md="12">
            <hr>
            </b-col>
            <b-col md="6">
                <h4>History Details</h4>
            </b-col>
            <b-col md="6">
                <b-button
                    variant="primary"
                    type="button"
                    class="float-right"
                    @click="addNewHistory"
                >
                    Add History
                </b-button>
            </b-col>
        <!-- Start Table Section-->
        <b-col md="12">
            <hr>
            <b-table
                responsive="sm"
                :fields="fields"
                :items="rows"
                :bordered="true"
                :hover="true"
                show-empty
                selectable
                select-mode="single"
                @row-selected="onRowSelected"
            >
                <template #empty="scope">
                    <h5 class="text-center text-uppercase">No Item Details Available</h5>
                </template>
                <template #cell(srNo)="data">
                    {{ data.index + 1 }}
                </template>
                <template
                    #cell(action)="data"
                >
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
                        <b-dropdown-item @click="selectHistory(data.item)">
                          <feather-icon
                              icon="CheckSquareIcon"
                              class="mr-50"
                          />
                          <span>Select</span>
                        </b-dropdown-item>
                        <b-dropdown-item @click="deleteHistory(data.item._id)">
                          <feather-icon
                              icon="TrashIcon"
                              class="mr-50"
                          />
                          <span>Delete</span>
                        </b-dropdown-item>
                        </b-dropdown>
                    </span>
                </template>

                <!-- Selection Area -->
                <template #cell(rowSelected)="{ rowSelected }">
                    <template v-if="rowSelected">
                        <span aria-hidden="true">&check;</span>
                        <span class="sr-only">Selected</span>
                    </template>
                    <template v-else>
                        <span aria-hidden="true">&nbsp;</span>
                        <span class="sr-only">Not selected</span>
                    </template>
                </template>

            </b-table>
        </b-col>
        <!-- End Table Section-->
        <b-col md="12">
            <hr>
        </b-col>
        <b-col md="12">
<!--            <b-form-group-->
<!--                label="Date"-->
<!--                label-for="date"-->
<!--            >-->
<!--                <flat-pickr-->
<!--                    v-model="formData.date"-->
<!--                    class="form-control"-->
<!--                    :config="{dateFormat: 'd-m-Y'}"-->
<!--                />-->
<!--            </b-form-group>-->
            <b-form-group
                label="Date"
                label-for="date"
            >
                <b-input-group>
                    <b-input-group-prepend>
                        <b-form-datepicker
                            v-model="formatDates.date"
                            button-only
                            @input="getPoItemFormateDate($event)"
                            show-decade-nav
                            size="sm"
                            nav-button-variant="primary"
                            disabled
                        />
                    </b-input-group-prepend>
                    <cleave
                        id="date"
                        v-model="formData.date"
                        class="form-control"
                        :raw="false"
                        :options="dateFormat"
                        placeholder="DD/MM/YYYY"
                        show-decade-nav
                        disabled
                    />
                </b-input-group>
            </b-form-group>
            <b-form-group
                label="History"
                label-for="history"
            >
                <b-form-textarea
                    v-model="formData.history"
                    id="history"
                />
            </b-form-group>
        </b-col>
        <b-col md="12">
            <hr>
            <b-button
                class="float-right"
                variant="primary"
                type="submit"
                v-if="isButtonShow"
            >
                {{ itemButton }}
            </b-button>
        </b-col>
    </b-row>
    </b-form>
</template>
<script>
    import {
        BButton,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormTextarea,
        BFormInvalidFeedback,
        BDropdown,
        BDropdownItem,
        BInputGroup,
        BFormDatepicker,
        BInputGroupPrepend
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required, numeric, email} from '@validations'
    import {ref, onUnmounted} from '@vue/composition-api'
    import {ValidationProvider, ValidationObserver, validate} from 'vee-validate'
    import salesStoreModule from "../../salesStoreModule";
    import flatPickr from 'vue-flatpickr-component'
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'

    export default {
        components: {
            BButton,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            BFormTextarea,
            BFormInvalidFeedback,
            BDropdown,
            BDropdownItem,
            vSelect,
            flatPickr,
            Cleave,
            ValidationProvider,
            ValidationObserver,
            BInputGroup,
            BFormDatepicker,
            BInputGroupPrepend
        },
        data(){
            const refetchData = () => {
                this.$store.dispatch('sales-module/getHistory', { id : router.currentRoute.params.id}).then(res => {
                    this.rows = res.data.data
                })
            }

            return {
                fields: [
                    {
                        key: 'rowSelected',
                        label: ''
                    },
                    {
                        key: 'srNo',
                        label: 'No'
                    },
                    {
                        key: 'date',
                        label: 'Date'
                    },
                    {
                        key: 'history',
                        label: 'History'
                    },
                    {
                        key: 'user.first_name',
                        label: 'CreatedBy'
                    },
                    {
                        key: 'action',
                        label: 'Actions'
                    },
                ],
                rows: [],
                itemButton: "Save",
                isButtonShow: true,
                refetchData
            }
        },
        created(){
            this.refetchData()
        },
        setup() {
            const toast = useToast()
            const APP_STORE_MODULE_NAME = 'sales-module'
            if (!store.hasModule(APP_STORE_MODULE_NAME)) store.registerModule(APP_STORE_MODULE_NAME, salesStoreModule)
            onUnmounted(() => {
                if (store.hasModule(APP_STORE_MODULE_NAME)) store.unregisterModule(APP_STORE_MODULE_NAME)
            })
            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                date: null,
            })

            const getPoItemFormateDate = (date) => {
                formData.value.date = forMatIndianDate(date)
            }

            const partyDetailFormData = {
                id: null,
                salesIqID: router.currentRoute.params.id,
                date:forMatIndianDate(getTcTodayDate()),
                history: null,
            }

            const formData = ref(JSON.parse(JSON.stringify(partyDetailFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(partyDetailFormData))
            }

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    formData.value.id = items[0]._id
                    formData.value.date = items[0].date ?? null
                    formData.value.history = items[0].history ?? null
                } else {
                    resetGroupData()
                }
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetGroupData)
            return {
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
                dateFormat,
                formatDates,
                getPoItemFormateDate,
                onRowSelected
            }
        },
        methods: {
            addNewHistory(){
                this.resetGroupData()
                this.isButtonShow = true
                this.itemButton = "Save"
            },
            selectHistory(data){
                this.formData = data
                this.isButtonShow = false
            },
            submitFormData(){
                if (this.formData.id === null){
                    store.dispatch('sales-module/addHistory', this.formData).then(response => {
                        this.refetchData()
                        this.resetGroupData()
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'History Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Added History.`,
                            },
                        })
                    })
                }else{
                    store.dispatch('sales-module/updateHistory', this.formData).then(response => {
                        this.refetchData()
                        this.resetGroupData()
                        this.itemButton = "Save"
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'History Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated History.`,
                            },
                        })
                    })
                }
            },
            deleteHistory(id){
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
                        store.dispatch(`sales-module/deleteHistory`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.refetchData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'History Delete Successfully',
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
        }
    }
</script>
<style lang="scss">
    @import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>
<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
