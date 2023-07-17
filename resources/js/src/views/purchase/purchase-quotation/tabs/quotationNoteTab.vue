<template>
    <b-form @submit.prevent="submitFormData">
        <b-row>
            <b-col>
                <b-form-group
                    label="Quotation Note"
                    label-for="quotationNote"
                >
                    <b-form-textarea
                        id="quotationNote"
                        rows="3"
                        v-model="formData.quotationNote"
                    />
                </b-form-group>
            </b-col>
            <!-- Button-->
            <b-col md="12">
                <hr>
                <b-button
                    class="float-right"
                    variant="primary"
                    type="submit"
                >
                    Save
                </b-button>
            </b-col>
        </b-row>
    </b-form>
</template>
<script>
    import {ref, computed} from '@vue/composition-api'
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormTextarea,
        BButton
    } from 'bootstrap-vue'
    import router from '@/router'
    import store from '@/store'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from 'vue-toastification/composition'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormTextarea,
            BButton
        },
        props: {
            noteDetails: {
                type: Object,
                required: true
            }
        },
        setup(props) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)

            const toast = useToast()

            const formData = computed(() => props.noteDetails)

            const submitFormData = async () => {
                let submitData = {
                    id: router.currentRoute.params.id,
                    noteDetails: formData.value
                }
                await store.dispatch('purchase-store-module/updatePurchaseQuotation', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Quotation Note Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Quotation Note.',
                            },
                        })
                    } else {
                        toast({
                            component: ToastificationContent,
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
            }

            return {
                formData,
                submitFormData,
            }
        }
    }
</script>
