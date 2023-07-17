<template>
    <div>
        <b-card-code>
            <b-tabs pills lazy>
                <b-tab active>
                    <template #title>
                        <feather-icon
                            icon="LayoutIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">General</span>
                    </template>
<!--                    <hr>-->
                    <user-administration-general-detail
                    />
                </b-tab>
                <b-tab>
                    <template #title>
                        <feather-icon
                            icon="UserIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                        />
                        <span class="d-none d-sm-inline">Contact</span>
                    </template>
<!--                    <hr>-->
                    <user-administration-contact-detail
                    />
                </b-tab>
            </b-tabs>
        </b-card-code>
    </div>
</template>
<script>
import {
    BTab,
    BTabs
} from 'bootstrap-vue'
import BCardCode from "@core/components/b-card-code/BCardCode";
import userAdministrationGeneralDetail from "./userAdministrationGeneralDetail"
import userAdministrationContactDetail from "./userAdministrationContactDetail"
export default {
    components:{
        BCardCode,
        BTabs,
        BTab,
        userAdministrationGeneralDetail,
        userAdministrationContactDetail
    }
}
</script>
