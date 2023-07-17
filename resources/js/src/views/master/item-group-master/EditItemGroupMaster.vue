<template>
    <b-card-code>
        <validation-observer ref="simpleRules">
            <b-form>
                <b-row>
                    <b-col md="4">
                        <b-form-group>
                            <validation-provider
                                #default="{ errors }"
                                name="Code"
                                rules="required|max:4"
                            >
                                <label for="groupCode">Code <span
                                    class="text-danger erp_required_star">*</span></label>

                                <b-form-input
                                    id="groupCode"
                                    v-model="partyFormData.groupCode"
                                    placeholder="Code"
                                    v-uppercaseInput
                                    trim
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="8">
                        <b-form-group>
                            <validation-provider
                                #default="{ errors }"
                                name="Description"
                                rules="required"
                            >
                                <label for="groupDescription">Description <span
                                    class="text-danger erp_required_star">*</span></label>

                                <b-form-input
                                    id="groupDescription"
                                    v-model="partyFormData.groupDescription"
                                    placeholder="Description"
                                    v-uppercaseInput
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col md="12">
                        <b-form-group
                            label="Remark"
                            label-for="groupRemark"
                        >
                            <b-form-textarea
                                id="groupRemark"
                                placeholder="Remark"
                                rows="2"
                                v-model="partyFormData.groupRemark"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="User Rights"
                            label-for="groupUsers"
                        >
                            <v-select
                                v-model="partyFormData.groupUsers"
                                multiple
                                taggable
                                push-tags
                                placeholder="Select user Right"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="userOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="groupUsers"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="GL A/c"
                            label-for="groupGlAccount"
                        >
                            <v-select
                                v-model="partyFormData.groupGlAccount"
                                taggable
                                push-tags
                                placeholder="Select GL Account"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="GlAccountOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="groupGlAccount"
                            />
                        </b-form-group>
                    </b-col>

                    <b-col md="4">
                        <b-form-group
                            label="Sales Target Group"
                            label-for="groupSalesTargetGroup"
                        >
                            <v-select
                                v-model="partyFormData.groupSalesTargetGroup"
                                taggable
                                push-tags
                                placeholder="Select Sales Target Group"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="SalesTargetOption"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="groupSalesTargetGroup"
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
                            Submit
                        </b-button>

                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>

    </b-card-code>
</template>

<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BFormInput, BFormTextarea, BForm, BButton, BTab, BTabs,
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import {ref, onUnmounted} from '@vue/composition-api'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import store from '@/store'
    import itemStoreModule from '../itemStoreModule'
    import axios from '@axios'
    import Swal from 'sweetalert2'
    import {uppercaseInput} from "@core/utils/utils";

    export default {
        components: {
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BForm,
            BButton,
            BTab,
            BTabs,
            vSelect,
        },
        directives: {
            Ripple,
            uppercaseInput,
        },
        data() {
            const userOptions = []

            const SalesTargetOption = []

            const GlAccountOption = []

            return {
                userOptions,
                SalesTargetOption,
                GlAccountOption,
            }
        },
        methods: {

            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {

                        axios.post('/api/item-group-master-exist',
                            {
                                id: router.currentRoute.params.id,
                                groupCode: this.partyFormData.groupCode
                            }
                        ).then(res => {
                            if (res.data.data === true) {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Item Group Code ' + this.partyFormData.groupCode + ' Already Exist!',
                                })

                            } else {

                                // save Data

                                store.dispatch('item-group-module/UpdateItemGroupMaster', this.partyFormData).then(response => {

                                    //console.log(response);

                                    if (response.status = 200) {

                                        this.$router.push({name: 'item-group-master'})

                                        this.$toast({
                                            component: ToastificationContent,
                                            position: 'top-right',
                                            props: {
                                                title: 'Item Group Edited',
                                                icon: 'CheckSquareIcon',
                                                variant: 'success',
                                                text: `You have successfully Edited Group ${this.partyFormData.groupCode}.`,
                                            },
                                        })
                                    }

                                })
                            }
                        })

                    }
                })
            },
        },
        setup() {

            const ITEMGROUP_APP_STORE_MODULE_NAME = 'item-group-module'

            // Register module
            if (!store.hasModule(ITEMGROUP_APP_STORE_MODULE_NAME)) store.registerModule(ITEMGROUP_APP_STORE_MODULE_NAME, itemStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(ITEMGROUP_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMGROUP_APP_STORE_MODULE_NAME)
            })

            const partyFormData = ref({
                id: null,
                groupCode: null,
                groupDescription: null,
                groupRemark: null,
                groupGlAccount: null,
                groupSalesTargetGroup: null,
                groupUsers: null,
            })

            store.dispatch('item-group-module/fetchItemGroupDetail', {id: router.currentRoute.params.id})
                .then(response => {
                    //console.log(response.data)
                    partyFormData.value = response.data.data
                    partyFormData.value.id = response.data.data._id
                    delete partyFormData.value._id

                })
                .catch(error => {
                    if (error.response.status === 404) {
                        partyFormData.value = undefined
                    }
                })

            return {
                partyFormData,
                required,
            }
        },
        created() {

            //Get All Users

            this.$http.get('/api/get-users-options').then(res => {

                this.userOptions = res.data.data

            })

            //Get All Sales Targe Options

            this.$http.get('/api/get-item-sales-target-group-options').then(res => {

                this.SalesTargetOption = res.data.data

            })

            //Get All Group Ledger
            this.$http.get('/api/get-account-ledger-options').then(res => {
                this.GlAccountOption = res.data.data
            })
        },
    }
</script>
