<template>
    <div>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <validation-observer
                    #default="{ handleSubmit }"
                    ref="refFormObserver"
                >
                    <!-- Form -->
                    <b-form
                        @submit.prevent="handleSubmit(saveTemplateData)"
                        @reset.prevent="resetForm"
                    >
                        <b-row>
                            <b-col md="8">
                                <validation-provider
                                    #default="validationContext"
                                    name="Template"
                                    rules="required"
                                >
                                    <b-form-group>

                                        <label for="template">Template <span
                                            class="text-danger erp_required_star">*</span></label>

                                        <b-form-input
                                            id="template"
                                            v-model="templateData.templateName"
                                            :state="getValidationState(validationContext)"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="4">
                                <validation-provider
                                    #default="validationContext"
                                    name="Active"
                                    rules="required"
                                >
                                    <b-form-group
                                        label="Active"
                                        label-for="active"
                                        :state="getValidationState(validationContext)"
                                    >
                                        <v-select
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="statusOption"
                                            :clearable="false"
                                            input-id="active"
                                            :reduce="val => val.value"
                                            v-model="templateData.status"
                                        />
                                        <b-form-invalid-feedback>
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    type="submit"
                                    variant="primary"
                                >
                                    Save Template
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <b-table
                    :fields="tableData.fields"
                    :items="tableData.rows"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    responsive
                    class="mb-0 table_scroll"
                >
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
                      <b-dropdown-item @click="editTermsConditionItem(data.item)">
                        <feather-icon
                            icon="Edit2Icon"
                            class="mr-50"
                        />
                        <span>Edit</span>
                      </b-dropdown-item>
                      <b-dropdown-item @click="deleteTermsConditionItem(data.item._id)">
                        <feather-icon
                            icon="TrashIcon"
                            class="mr-50"
                        />
                        <span>Delete</span>
                      </b-dropdown-item>
                    </b-dropdown>
                        </span>
                    </template>
                </b-table>
            </b-card-code>
        </b-overlay>
        <b-overlay
            :show="showOverlayLoading"
            rounded="sm"
        >
            <b-card-code>
                <!-- BODY -->
                <validation-observer #default="{ handleSubmit }">
                    <!-- Form -->
                    <b-form @submit.prevent="handleSubmit(saveTermsItems)"
                    @reset.prevent="resetForm"
                    >
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Group"
                                    label-for="tcGroup"
                                >
                                    <v-select
                                        v-model="userformData.tcGroup"
                                        placeholder="Select Group"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="termConditionGroupOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        id="tcGroup"
                                        @input="getTermsConditionDetail($event)"
                                    />
                                </b-form-group>
                                <validation-provider
                                    #default="validationContext"
                                    name="Group Name"
                                    rules="required"
                                >
                                    <b-form-group
                                        :state="getValidationState(validationContext)"
                                    >
                                        <label>Group Name<span
                                            class="text-danger erp_required_star">*</span></label>
                                        <b-form-input
                                            id="groupName"
                                            v-model="userformData.groupName"
                                        />
                                        <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </validation-provider>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Description"
                                    label-for="tcDescription"
                                >
                                    <b-form-textarea
                                        id="tcDescription"
                                        v-model="userformData.tcDescription"
                                        rows="2"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    class="float-right"
                                    type="submit"
                                    variant="primary"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card-code>
        </b-overlay>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BButton,
        BOverlay,
        BFormTextarea,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem
    } from 'bootstrap-vue'
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {onUnmounted, ref} from "@vue/composition-api";
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import masterStoreModule from "../masterStoreModule";
    import Ripple from "vue-ripple-directive"
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import axios from '@axios'
    import router from '@/router'
    import {useToast} from "vue-toastification/composition";
    import Toastification from "@core/components/toastification/ToastificationContent.vue";
    import Swal from "sweetalert2";

    export default {
        components: {
            BCardCode,
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            vSelect,
            ValidationObserver,
            ValidationProvider,
            BButton,
            BOverlay,
            BFormTextarea,
            BTable,
            BSpinner,
            BDropdown,
            BDropdownItem
        },
        directives: {
            Ripple,
        },
        setup() {
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'terms-condition-template-master'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, masterStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })
            const showOverlayLoading = ref(false)

            const statusOption = ref([
                {label: 'Yes', value: 1},
                {label: 'No', value: 2},
            ])
            const termConditionGroupOptions = ref([])
            axios.get('/api/get-term-condition-detail-with-group-options').then(res => {
                termConditionGroupOptions.value = res.data.data
            })
            const getTermsConditionDetail = async (id) => {
                await axios.get(`/api/term-condition-detail-master/${id}`).then(res => {
                    userformData.value.tcDescription = res.data.data.tcGroupDescription
                    userformData.value.groupName = res.data.data.tc_group_details.groupDescription
                })
            }
            // return $this->billingItems()->with('tcDetails')->get();
            const tableData = ref({
                fields: [
                    {
                        key: 'tc_details.tcGroupCode',
                        label: 'Group'
                    },
                    {
                        key: 'groupName',
                        label: 'Group Name'
                    },
                    {
                        key: 'tcDescription',
                        label: 'Group Description'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    }
                ],
                rows: []
            })

            const templateData = ref({
                id: null,
                templateName: null,
                status: null,
            })
            const blankData = {
                id: null,
                templateId: router.currentRoute.params.id,
                tcGroup: null,
                groupName: null,
                tcDescription: null,
            }
            const userformData = ref(JSON.parse(JSON.stringify(blankData)))

            const resetFormData = () => {
                templateData.value = JSON.parse(JSON.stringify(templateData.value))
                userformData.value = JSON.parse(JSON.stringify(blankData))
            }
            const editTermsConditionItem = (data) => {
                userformData.value.id = data._id
                userformData.value.tcGroup = data.tcGroup
                userformData.value.groupName = data.groupName
                userformData.value.tcDescription = data.tcDescription
            }

            const refetchData = async () => {
                showOverlayLoading.value = true
                await axios.get(`/api/term-condition-template-master/${router.currentRoute.params.id}`).then(res => {
                    templateData.value.id = res.data.data._id
                    templateData.value.status = res.data.data.status
                    templateData.value.templateName = res.data.data.templateName
                    tableData.value.rows = res.data.data.billing_items
                    showOverlayLoading.value = false
                })
            }
            refetchData()

            const deleteTermsConditionItem = async (id) => {
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
                        store.dispatch('terms-condition-template-master/deleteTermConditionTemplateItemMaster', {id: id}).then(res => {
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

            const saveTermsItems = async () => {
                if (userformData.value.id === null) {
                    await store.dispatch('terms-condition-template-master/addTermConditionTemplateItemMaster', userformData.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Terms & Condition Template Item Created',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Created Terms & Condition Template Item`,
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Abort',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: `Something went wrong`,
                                },
                            })
                        }
                    })
                } else {
                    await store.dispatch('terms-condition-template-master/updateTermConditionTemplateItemMaster', userformData.value).then(res => {
                        if (res.data.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Terms & Condition Template Itemm Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Terms & Condition Template Item`,
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Abort',
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: `Something went wrong`,
                                },
                            })
                        }
                    })
                }
                resetFormData()
                await refetchData()
            }

            const saveTemplateData = async () => {
                await store.dispatch('terms-condition-template-master/updateTermsConditionTemplateMaster', templateData.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Terms & Condition Template Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated Terms & Condition Template`,
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Error',
                                icon: 'AlertCircleIcon',
                                variant: 'danger',
                                text: 'Something went wrong!',
                            },
                        })
                    }
                    router.push({name: 'term-condition-template-master'})
                })
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)
            return {
                templateData,
                resetFormData,
                saveTemplateData,
                refFormObserver,
                getValidationState,
                resetForm,
                required,
                statusOption,
                showOverlayLoading,
                refetchData,
                termConditionGroupOptions,
                tableData,
                getTermsConditionDetail,
                saveTermsItems,
                userformData,
                editTermsConditionItem,
                deleteTermsConditionItem
                // refetchTermsItem
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
