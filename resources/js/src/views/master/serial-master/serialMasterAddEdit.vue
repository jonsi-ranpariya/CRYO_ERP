<template>
    <div>
        <b-sidebar
            id="add-new-serial-master-sidebar"
            :visible="$store.state.serialMasterStore.isAddNewUserSidebarActive"
            bg-variant="white"
            sidebar-class="sidebar-lg"
            shadow
            no-header
            right
            backdrop
            @hidden="(val) => resetFormData(val)"
        >
            <template #default="{ hide }">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                    <h5 class="mb-0">
                        Add/Edit Serial
                    </h5>
                    <feather-icon
                        class="ml-1 cursor-pointer"
                        icon="XIcon"
                        size="16"
                        @click="hide"
                    />
                </div>

                <!-- BODY -->
                <validation-observer
                    #default="{ handleSubmit }"
                    ref="refFormObserver"
                >
                    <!-- Form -->
                    <b-form
                        class="p-2"
                        @submit.prevent="handleSubmit(submitFormData)"
                        @reset.prevent="resetForm"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Description"
                            rules="required"
                        >
                            <b-form-group>
                                <label for="description">
                                    Description
                                    <span class="text-danger erp_required_star">*</span>
                                </label>
                                <b-form-input
                                    id="description"
                                    v-model="formData.description"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Initial"
                            rules="required"
                        >
                            <b-form-group>
                                <label for="initial">
                                    Initial
                                    <span class="text-danger erp_required_star">*</span>
                                </label>
                                <b-form-input
                                    id="initial"
                                    v-model="formData.initial"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Starting Number"
                            rules="required"
                        >
                            <b-form-group>
                                <label for="startingNumber">
                                    Starting Number
                                    <span class="text-danger erp_required_star">*</span>
                                </label>
                                <b-form-input
                                    id="startingNumber"
                                    v-model="formData.startingNumber"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Ending Number"
                            rules="required"
                        >
                            <b-form-group>
                                <label for="endingNumber">
                                    Ending Number
                                    <span class="text-danger erp_required_star">*</span>
                                </label>
                                <b-form-input
                                    id="endingNumber"
                                    v-model="formData.endingNumber"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                            #default="validationContext"
                            name="Current Number"
                            rules="required"
                        >
                            <b-form-group>
                                <label for="currentNumber">
                                    Current Number
                                    <span class="text-danger erp_required_star">*</span>
                                </label>
                                <b-form-input
                                    id="currentNumber"
                                    v-model="formData.currentNumber"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>

                        <b-row>
                            <b-col md="12">
                                <hr>
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    variant="primary"
                                    class="mr-2"
                                    type="submit"
                                >
                                    Save
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </template>
        </b-sidebar>
    </div>
</template>
<script>
import {
    BSidebar,
    BRow,
    BCol,
    BForm,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BFormInvalidFeedback,
    BButton,
    BInputGroup,
    BInputGroupPrepend
} from 'bootstrap-vue';
import {ValidationProvider, ValidationObserver} from 'vee-validate';
import vSelect from "vue-select";
import Ripple from 'vue-ripple-directive'
import {uppercaseInput} from "@core/utils/utils";
import {computed} from '@vue/composition-api';
import {useToast} from "vue-toastification/composition";
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue';
import {required} from '@validations';
import formValidation from '@core/comp-functions/forms/form-validation';
import store from '@/store';

export default {
    components: {
        BSidebar,
        BRow,
        BCol,
        BForm,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormInvalidFeedback,
        BButton,
        vSelect,
        BInputGroup,
        BInputGroupPrepend,
        // Form Validation
        ValidationProvider,
        ValidationObserver,
    },
    directives: {
        Ripple,
        uppercaseInput,
    },
    props: {
        serialFormData: {
            required: true,
            type: Object
        }
    },
    setup(props, {emit}) {
        const toast = useToast();

        const formData = computed(() => props.serialFormData);

        const resetFormData = async (val = false) => {
            await store.commit('serialMasterStore/sideBarShowHide', val);
            emit('resetFormData', true);
        }

        const submitFormData = async () => {
            if (formData.value._id === null) {
                await store.dispatch('serialMasterStore/insertSerialMaster', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Serial Created',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Created New Serial.`,
                            },
                        });
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
                        });
                    }
                });
            } else {
                await store.dispatch('serialMasterStore/updateSerialMaster', formData.value).then((res) => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Serial Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: `You have successfully Updated New Serial.`,
                            },
                        });
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
                        });
                    }
                });
            }
            await resetFormData();
            await store.dispatch('serialMasterStore/listSerialMaster');
        }

        const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData);

        return {
            formData,
            resetFormData,
            submitFormData,

            //validations
            required,
            refFormObserver,
            getValidationState,
            resetForm,
        }
    }
}
</script>
