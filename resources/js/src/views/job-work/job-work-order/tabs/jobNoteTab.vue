<template>
    <div>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col>
                    <b-form-group
                        label="Job Order Note"
                        label-for="jobOrderNote"
                    >
                        <b-form-textarea
                            id="jobOrderNote"
                            rows="3"
                            v-model="formData.jobOrderNote"
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
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormTextarea,
        BButton
    } from 'bootstrap-vue'
    import {computed} from '@vue/composition-api'
    import router from '@/router'
    import store from '@/store'
    import {useToast} from "vue-toastification/composition";
    import jobWorkStoreModule from "../../jobWorkStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

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
            noteDetail: {
                type: Object,
                required: true,
            }
        },
        setup(props) {
            const ITEMADDON_APP_STORE_MODULE_NAME = 'note-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)

            const toast = useToast()
            const formData = computed(() => props.noteDetail)
            const saveFormData = async () => {
                let submitData = {
                    _id: router.currentRoute.params.id,
                    noteDetail: formData.value
                }
                await store.dispatch('note-store-module/updateJobWorkOrder', submitData).then(res => {
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
                saveFormData,
            }
        }
    }
</script>
