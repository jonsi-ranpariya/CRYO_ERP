<template>
    <b-sidebar
        id="add-new-party-group-master-sidebar"
        :visible="isEditNewItemMakeMasterSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @change="(val) => $emit('update:is-edit-new-item-make-master-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Edit Item Make
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>
            <!--Body-->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onUpdate)"
                    @reset.prevent="resetForm"
                >
                    <!-- Group Name -->
                    <validation-provider
                        #default="validationContext"
                        name="Make"
                        rules="required"
                    >
                        <b-form-group>

                            <label for="make">Make <span
                                class="text-danger erp_required_star">*</span></label>

                            <b-form-input
                                id="make"
                                v-model="itemMakeMasterData.makeName"
                                v-uppercaseInput
                                autofocus
                                :state="getValidationState(validationContext)"
                                placeholder="Make"
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
                            Update
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hide"
                        >
                            Cancel
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
    import { ref } from '@vue/composition-api'
    import {required, alphaNum, email} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import store from '@/store'
    import Ripple from 'vue-ripple-directive'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import { useToast } from 'vue-toastification/composition'
    import axios from '@axios'
    import Swal from 'sweetalert2'
    import {uppercaseInput} from "@core/utils/utils";

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
            uppercaseInput,
        },
        model: {
            prop: ['isEditNewItemMakeMasterSidebarActive','itemMakeMasterData'],
            event: 'update:is-edit-new-item-make-master-sidebar-active',
        },
        props: {
            isEditNewItemMakeMasterSidebarActive: {
                type: Boolean,
                required: true,
            },
            itemMakeMasterData: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                required,
                alphaNum,
                email,
            }
        },
        setup(props, { emit }) {
            const toast = useToast()

            const blankItemData = {
                id: '',
                makeName: '',
            }

            const itemData = ref(JSON.parse(JSON.stringify(blankItemData)))

            const resetgroupData = () => {
                itemData.value = JSON.parse(JSON.stringify(blankItemData))
            }

            const onSubmit = () => {

            }

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetgroupData)

            return {
                itemData,
                onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,
            }
        },
        methods: {
            onUpdate(){

                axios.post('/api/item-make-master-exist',
                    {
                        id: this.itemMakeMasterData.id,
                        makeName: this.itemMakeMasterData.makeName
                    }
                ).then(res => {
                    if (res.data.data === true) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Make ' + this.itemMakeMasterData.makeName + ' Already Exist!',
                        })

                    } else {

                        // save Data

                        store.dispatch('item-make-master/updateItemMakeMaster', this.itemMakeMasterData).then(response => {
                            if (response.status == 200){
                                this.$emit('update:is-edit-new-item-make-master-sidebar-active', false)
                                this.$toast({
                                    component: ToastificationContent,
                                    props: {
                                        title: 'Item Make Master Update',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Update Item Make`,
                                    },
                                })
                                store.dispatch('item-make-master/fetchItemMakeMasterList')
                            }else{
                                this.$toast({
                                    component: ToastificationContent,
                                    props: {
                                        title: 'error',
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: `Something went wrong`
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
