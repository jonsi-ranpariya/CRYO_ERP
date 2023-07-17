<template>
    <b-col md="12">
        <b-tabs
            pills
            lazy
        >
            <b-tab active>
                <template #title>
                    <feather-icon
                        icon="DatabaseIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">BOM</span>
                </template>
                <bom-tab />
            </b-tab>
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="ActivityIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Process Details</span>
                </template>
                <process-details-tab />
            </b-tab>
        </b-tabs>
    </b-col>
</template>
<script>
    import BCardCode from '@core/components/b-card-code'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormCheckbox,
        BForm,
        BButton,
        BFormDatepicker,
        BOverlay,
        BFormInvalidFeedback,
        BTable,
        BDropdown,
        BDropdownItem,
        BSpinner,
        BTabs,
        BTab
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import BomTab from "./tabs/bomTab";
    import ProcessDetailsTab from "./tabs/processDetailsTab";

    export default {
        components: {
            ProcessDetailsTab,
            BomTab,
            BCardCode,
            ValidationProvider,
            ValidationObserver,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BFormCheckbox,
            BFormTextarea,
            BForm,
            BButton,
            BFormDatepicker,
            BOverlay,
            BFormInvalidFeedback,
            BTable,
            BDropdown,
            BDropdownItem,
            BSpinner,
            BTabs,
            BTab,
            vSelect
        }
    }
</script>
