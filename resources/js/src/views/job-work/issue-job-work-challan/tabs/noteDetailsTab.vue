<template>
    <div>
        <b-form  @submit.prevent="saveFormData">
            <b-row>
                <b-col>
                    <b-form-group
                        label="Remark"
                        label-for="jobChallanRemark"
                    >
                        <b-form-textarea
                            id="jobChallanRemark"
                            rows="2"
                            v-model="formData.jobChallanRemark"
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
        BButton,
    } from 'bootstrap-vue'
    import {computed} from "@vue/composition-api";
    import jobWorkStoreModule from "../../jobWorkStoreModule";
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import store from '@/store'

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
            const ITEMADDON_APP_STORE_MODULE_NAME = 'note-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, jobWorkStoreModule)

            const toast = useToast()

            const formData = computed(() => props.noteDetails)
            const saveFormData = async () => {
                let submitData = {
                    _id: router.currentRoute.params.id,
                    noteDetails: formData.value
                }
                await store.dispatch('note-store-module/updateIssueJobWorkOrderChallan', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Work Challan Note Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Job Work Challan Note.',
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
                saveFormData
            }
        }
    }
</script>
