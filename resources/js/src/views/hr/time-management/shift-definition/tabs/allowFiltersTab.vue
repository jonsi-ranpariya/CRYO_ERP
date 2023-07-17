<template>
    <div>
        <b-form @submit.prevent="saveFormData">
            <b-row>
                <b-col md="12">
                    <b-alert
                        variant="danger"
                        show
                    >
                        <h4 class="alert-heading">
                            Note:
                        </h4>
                        <div class="alert-body">
                            <span>Select any one cost center from Attendance Standard Settings Once any cost center is allocated to the shift definition,
                                 shift will be visible to only those Manager who are assigned with the same cost center.</span><br><br>
                        </div>
                    </b-alert>
                    <hr>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Group"
                        label-for="group"
                    >
                        <v-select
                            v-model="formData.group"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="groupOptions"
                            :clearable="false"
                            placeholder="Select Group"
                            input-id="group"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Grade"
                        label-for="grade"
                    >
                        <v-select
                            v-model="formData.grade"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="gradeOptions"
                            :clearable="false"
                            input-id="grade"
                            placeholder="Select Grade"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Branch"
                        label-for="branch"
                    >
                        <v-select
                            v-model="formData.branch"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="branchOptions"
                            :clearable="false"
                            input-id="branch"
                            placeholder="Select Branch"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Department"
                        label-for="department"
                    >
                        <v-select
                            v-model="formData.department"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="departmentOptions"
                            :clearable="false"
                            input-id="grade"
                            placeholder="Select Department"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Division"
                        label-for="division"
                    >
                        <v-select
                            v-model="formData.division"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="divisionOptions"
                            :clearable="false"
                            placeholder="Select Division"
                            input-id="division"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Unit"
                        label-for="unit"
                    >
                        <v-select
                            v-model="formData.unit"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="unitOptions"
                            :clearable="false"
                            input-id="unit"
                            placeholder="Select Unit"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="4">
                    <b-form-group
                        label="Category"
                        label-for="category"
                    >
                        <v-select
                            v-model="formData.category"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="categoryOptions"
                            :clearable="false"
                            placeholder="Select Category"
                            input-id="category"
                        />
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group
                        label="Designation"
                        label-for="designation"
                    >
                        <v-select
                            v-model="formData.designation"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="designationOptions"
                            :clearable="false"
                            placeholder="Select Designation"
                            input-id="branch"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <hr>
            <b-col md="12">
                <b-button
                    variant="primary"
                    class="float-right ml-2"
                    type="submit"
                >
                    Save
                </b-button>
                <b-button
                    variant="primary"
                    class="float-right"
                >
                    Clear Selection
                </b-button>
            </b-col>
        </b-form>
    </div>
</template>
<script>
    import {
        BRow,
        BForm,
        BCol,
        BFormGroup,
        BButton,
        BAlert
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import {ref, computed} from "@vue/composition-api";
    import axios from '@axios'
    import {useToast} from "vue-toastification/composition";
    import hrmsStoreModule from "../../../hrmsStoreModule";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'
    export default {
        components: {
            BRow,
            BForm,
            BCol,
            vSelect,
            BFormGroup,
            BButton,
            BAlert
        },
        props: {
            filterDetails: {
                type: Object,
                required: true
            }
        },
        setup(props){
                /*
             const toast = useToast()
             const ITEMADDON_APP_STORE_MODULE_NAME = 'hr-store-module'
             if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, hrmsStoreModule)
               */

            const formData = computed(() => props.filterDetails)

            const gradeOptions = ref([])
            axios.get('/api/new/get-grade-master')
                .then(res => {
                    gradeOptions.value = res.data
                })

            const branchOptions = ref([])
            axios.get('/api/new/get-hr-branch-master')
                .then(res => {
                    branchOptions.value = res.data
                })

            const departmentOptions = ref([])
            axios.get('/api/new/get-hr-department-master')
                .then(res => {
                    departmentOptions.value = res.data
                })

            const divisionOptions = ref([])
            axios.get('/api/new/get-division-master')
                .then(res => {
                    divisionOptions.value = res.data
                })

            const unitOptions = ref([])
            axios.get('/api/new/get-unit-master')
                .then(res => {
                    unitOptions.value = res.data
                })

            const categoryOptions = ref([])
            axios.get('/api/new/get-category-master')
                .then(res => {
                    categoryOptions.value = res.data
                })

            const groupOptions = ref([])
            axios.get('/api/new/get-group-master')
                .then(res => {
                    groupOptions.value = res.data
                })

            const designationOptions = ref([])
            axios.get('/api/new/get-hr-designation-master')
                .then(res => {
                    designationOptions.value = res.data
                })

            const saveFormData = async () => {
                console.log(formData.value)
                /*  let submitData = {
                    id: router.currentRoute.params.id,
                    filterDetails: formData.value
                }
                await store.dispatch('hr-store-module/updateShiftDefinition', submitData).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Filters Updated',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Updated Filters.',
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
                })*/
            }

            return {
                gradeOptions,
                groupOptions,
                divisionOptions,
                categoryOptions,
                unitOptions,
                departmentOptions,
                branchOptions,
                designationOptions,
                formData,
                saveFormData
            }
        }
    }
</script>
