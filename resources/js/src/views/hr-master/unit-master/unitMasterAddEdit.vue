<template>
    <b-sidebar
        id="add-new-serial-master-sidebar"
        :visible="$store.state.hrMasterStoreModule.isAddNewUserSidebarActive"
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
                    Add/Edit Unit
                </h5>
                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />
            </div>


            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(saveFormData)"
                    @reset.prevent="resetForm"
                >

                    <validation-provider
                        #default="validationContext"
                        name="Unit"
                        rules="required"
                    >
                        <b-form-group>
                            <label for="unit">Unit <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="unit"
                                v-model="formData.unit"
                                :state="getValidationState(validationContext)"
                                v-uppercase-input
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            Save Data
                        </b-button>
                    </div>
                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>

<script>
    import {BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton} from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {computed, ref} from '@vue/composition-api'
    import {required} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import {uppercaseInput} from "../../../@core/utils/utils";
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue';


    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,
            vSelect,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
            uppercaseInput,
        },
        props: {
            unitFormData: {
                required: true,
                type: Object
            }
        },
        setup(props, {emit}) {
            const toast = useToast();

            const formData = computed(() => props.unitFormData);

            const resetFormData = async (val = false) => {
                await store.commit('hrMasterStoreModule/sideBarShowHide', val);
                emit('resetFormData', true);
            }

            const saveFormData = async () => {
                if (formData.value._id === null) {
                    await store.dispatch('hrMasterStoreModule/insertUnitMaster', formData.value)
                        .then((res) => {
                            if (res.status === 201) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: "Added",
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: 'You have successfully Created New Unit Master',
                                    },
                                });
                            }
                        }).catch(() => {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: `Error`,
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Internal server error.',
                                },
                            });
                        });
                } else {
                    await store.dispatch('hrMasterStoreModule/updateUnitMaster', formData.value)
                        .then((res) => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Unit Updated',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Updated Unit Master.`,
                                    },
                                });
                            }
                        }).catch(() => {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: `Error`,
                                    icon: 'AlertCircleIcon',
                                    variant: 'danger',
                                    text: 'Internal server error.',
                                },
                            });
                        });
                }
                await resetFormData();
                await store.dispatch('hrMasterStoreModule/listUnitMaster');
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                formData,
                refFormObserver,
                getValidationState,
                resetForm,
                saveFormData,
                required,
                resetFormData
            }
        }
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-user-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>

