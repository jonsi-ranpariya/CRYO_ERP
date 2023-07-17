<template>
    <div>
        <hr>
        <b-table
            :fields="TermConditionFields"
            :items="listOfTermConditions"
            :bordered="true"
            :hover="true"
            show-empty
            responsive
            class="mb-0"
            selectable
            select-mode="single"
            @row-selected="onRowSelected"
        >
            <!-- A virtual column -->
            <template #cell(index)="data">
                {{ data.index + 1 }}
            </template>

            <!-- A custom formatted column -->
            <template #cell(termGroupName)="data">
                <span class="text-nowrap">{{ data.value}}</span>
            </template>

            <!-- A custom formatted column -->
            <template #cell(termDetail)="data">
                <span class="text-nowrap">{{ data.value}}</span>
            </template>

            <!-- A custom formatted column -->
            <template #cell(action)="data">
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
              <b-dropdown-item @click="deletePiTermCond(data.item._id)">
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

        <b-row>
            <b-col md="12">
                <hr>
                <h4>Term & Condition Details</h4>
                <hr>
            </b-col>
        </b-row>

        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="12">
                        <b-form-group
                            label="Select Group"
                            label-for="termConditionId"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Select Group"
                                rules="required"
                            >
                                <v-select
                                    v-model="piTermConditionData.termConditionId"
                                    placeholder="Select Group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="TermConditionOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    v-on:input="getTermConditionDetails(piTermConditionData.termConditionId)"
                                    input-id="termConditionId"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Term & Condition"
                            label-for="termGroupDetail"
                        >
                            <b-form-textarea
                                id="termGroupDetail"
                                v-model="piTermConditionData.termDetail"
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
                            Add / Save Term Condition
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
        BTable
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import router from '@/router'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {ref, computed, onUnmounted} from '@vue/composition-api'
    import salesStoreModule from '../../salesStoreModule'
    import axios from '@axios'

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
            BTable
        },
        directives: {
            Ripple,
        },
        methods: {
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        const hasIdExist = this.containsKey(this.piTermConditionData, '_id')
                        if (hasIdExist) {
                            this.piTermConditionData.id = this.piTermConditionData._id
                            delete this.piTermConditionData._id
                            store.dispatch('pit-module/updatePiTermCondition', this.piTermConditionData).then(response => {
                                if (response.status === 200) {
                                    this.resetTermConditionFormData()
                                    this.refetchTermConditionData()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Term Condition Edited',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Edited Business Type : ${this.piTermConditionData.termGroupName}.`,
                                        },
                                    })
                                }
                            })
                        } else {
                            store.dispatch('pit-module/addPiTermCondition', this.piTermConditionData).then(response => {
                                if (response.status === 200) {
                                    this.resetTermConditionFormData()
                                    this.refetchTermConditionData()
                                    this.$toast({
                                        component: ToastificationContent,
                                        position: 'top-right',
                                        props: {
                                            title: 'Term Condition Created',
                                            icon: 'CheckSquareIcon',
                                            variant: 'success',
                                            text: `You have successfully Created New Term Condition : ${this.piTermConditionData.termGroupName}.`,
                                        },
                                    })
                                }
                            })
                        }
                    }
                })
            },
            containsKey(obj, key) {
                return Object.keys(obj).includes(key)
            },
            deletePiTermCond(id) {
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
                        store.dispatch(`pit-module/deletePiTermCondition`, {id}).then(response => {
                            if (response.data.status === 200) {
                                this.refetchTermConditionData()
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Deleted`,
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `Term Condition Deleted Successfully`,
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
            const PIT_APP_STORE_MODULE_NAME = 'pit-module'
            // Register module
            if (!store.hasModule(PIT_APP_STORE_MODULE_NAME)) store.registerModule(PIT_APP_STORE_MODULE_NAME, salesStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PIT_APP_STORE_MODULE_NAME)) store.unregisterModule(PIT_APP_STORE_MODULE_NAME)
            })

            const CurrentPiId = ref(router.currentRoute.params.id)
            const TermConditionOptions = ref([])
            const TermConditionFields = ref([
                {
                    key: 'rowSelected',
                    label: ''
                },
                {
                    key: 'index',
                    label: 'Sr.No',
                },
                {
                    key: 'termGroupName',
                    label: 'Group Name',
                },
                {
                    key: 'termDetail',
                    label: 'Term & Condition',
                },
                {
                    key: 'action',
                    label: 'Action',
                },
            ])

            const listOfTermConditions = ref([])
            axios.get(`/api/get-pi-term-condition/${CurrentPiId.value}`).then(res => {
                if (res.data.data) {
                    listOfTermConditions.value = res.data.data
                }
            })

            const refetchTermConditionData = async () => {
                await axios.get(`/api/get-pi-term-condition/${CurrentPiId.value}`).then(res => {
                    listOfTermConditions.value = res.data.data
                })
            }

            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                TermConditionOptions.value = res.data.data
            })

            const piTermConditionData = ref({
                id: null,
                pInvoiceId: CurrentPiId.value,
                termConditionId: null,
                termGroupName: null,
                termDetail: null,
            })

            const onRowSelected = (items) => {
                if (items.length > 0) {
                    piTermConditionData.value._id = items[0]._id
                    piTermConditionData.value.pInvoiceId = items[0].pInvoiceId
                    piTermConditionData.value.termConditionId = items[0].termConditionId ?? null
                    piTermConditionData.value.termGroupName = items[0].termGroupName ?? null
                    piTermConditionData.value.termDetail = items[0].termDetail ?? null
                } else {
                    resetTermConditionFormData()
                }
            }

            const resetTermConditionFormData = () => {
                piTermConditionData.value = {
                    id: null,
                    pInvoiceId: CurrentPiId.value,
                    termConditionId: null,
                    termGroupName: null,
                    termDetail: null,
                }
            }

            const getTermConditionDetails = async (val) => {
                await axios.get(`/api/get-term-condition-detail-with-group-details/${val}`).then(res => {
                    if (res.data.data) {
                        piTermConditionData.value.termDetail = res.data.data.tcGroupDescription
                        piTermConditionData.value.termGroupName = res.data.data.tc_group_details.groupDescription
                    }
                })
            }

            return {
                CurrentPiId,
                TermConditionFields,
                listOfTermConditions,
                piTermConditionData,
                refetchTermConditionData,
                resetTermConditionFormData,
                getTermConditionDetails,
                TermConditionOptions,
                required,
                onRowSelected
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
