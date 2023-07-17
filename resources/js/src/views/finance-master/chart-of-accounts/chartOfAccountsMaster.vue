<template>
    <b-card-code>
        <div>
            <div class="text-right">
           <!-- <b-button variant="outline-danger">Reload Page</b-button> -->
                <b-button variant="outline-primary" v-b-modal.modal-primary>Add New Account</b-button>
            </div>
            <hr>

            <TreeNode v-for="node in nodes" :key="node.id" :node="node" :itemData="formData"/>
            <add-chart-of-account-modal :itemId="''"/>
        </div>

    </b-card-code>
</template>

<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow, BCol, BFormGroup, BForm, BButton, BModal, VBModal, BCardText, BCardBody, BFormInput
    } from 'bootstrap-vue'
    import {required} from '@validations'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ref, onUnmounted} from '@vue/composition-api'
    import financeMasterStoreModule from '../financeMasterStoreModule'
    import TreeNode from './TreeNode'
    import AddChartOfAccountModal from "./addChartOfAccountModal";

    export default {
        components: {
            AddChartOfAccountModal,
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BForm,
            BButton,
            vSelect,
            TreeNode,
            BModal,
            BCardText,
            BCardBody,
            BFormInput
        },
        directives: {
            'b-modal': VBModal,
            Ripple,
        },
        data() {
            return {
                required,
            }
        },
        setup() {
            const COACC_APP_STORE_MODULE_NAME = 'master-add'
            // Register module
            if (!store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.registerModule(COACC_APP_STORE_MODULE_NAME, financeMasterStoreModule)
            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(COACC_APP_STORE_MODULE_NAME)) store.unregisterModule(COACC_APP_STORE_MODULE_NAME)
            })

            const blankFormData = {
                groupCode: '',
                groupName: '',
                sequenceNo: '',
                isLastLevel: 'No',
            }

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetGroupData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetGroupData)

            return {
                formData,

                refFormObserver,
                getValidationState,
                resetForm,
                resetGroupData,
            }
        },
        mounted() {
            store.dispatch(`master-add/fetchChartOfAccounts`)
        },
        created() {},
        computed: {
            nodes() {
                return this.$store.getters["financeMasterStoreModule/getChartAccountList"]
            }
        }
    }
</script>
