<template>
    <b-form @submit.prevent="saveFormData">
        <b-row>
            <b-col>
                <b-form-group
                    label="Order Note"
                    label-for="orderNote"
                >
                    <b-form-textarea
                        id="orderNote"
                        rows="2"
                        v-model="formData.orderNote"
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
    import {computed} from '@vue/composition-api'
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import store from '@/store'
    import purchaseStoreModule from "../../purchaseStoreModule";
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormTextarea,
        BButton
    } from 'bootstrap-vue'

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
                required: true,
            }
        },
        setup(props) {
            const toast = useToast()
            const ITEMADDON_APP_STORE_MODULE_NAME = 'purchase-order-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, purchaseStoreModule)

            const formData = computed(() => props.noteDetails)
            const saveFormData = async () => {
                let submitData = {
                    id: router.currentRoute.params.id,
                    noteDetails: formData.value
                }
                await store.dispatch('purchase-order-store-module/updatePurchaseOrder', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Purchase Order Note Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Purchase Order.',
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
                saveFormData,
            }
        }
    }
</script>
