<template>
    <div class="auth-wrapper auth-v2">
        <b-row class="auth-inner m-0">
            <!-- Brand logo-->
            <!--<b-link class="brand-logo">
                <vuexy-logo/>
                <h2 class="brand-text text-primary ml-1">
                    CRYO ERP
                </h2>
            </b-link>-->
            <!-- /Brand logo-->

            <!-- Left Text-->
            <b-col
                lg="8"
                class="d-none d-lg-flex align-items-center p-5"
            >
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                    <b-img
                        fluid
                        :src="imgUrl"
                        alt="Login V2"
                    />
                </div>
            </b-col>
            <!-- /Left Text-->
            <!-- Login-->
            <b-col
                lg="4"
                class="d-flex align-items-center auth-bg px-2 p-lg-5"
            >
                <b-col
                    sm="8"
                    md="6"
                    lg="12"
                    class="px-xl-2 mx-auto"
                >
                    <b-card-title
                        class="mb-1 font-weight-bold"
                        title-tag="h2"
                    >
                        Welcome to Cryo ERP
                    </b-card-title>

                    <b-alert
                        variant="primary"
                        show
                    >
                    </b-alert>
                    <!-- form -->
                    <validation-observer
                        ref="loginForm"
                        #default="{invalid}"
                    >
                        <b-form
                            class="auth-login-form mt-2"
                            @submit.prevent="login"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Company"
                                rules="required"
                            >
                                <b-form-group
                                    label="Company"
                                    label-for="company"
                                    :state="errors.length > 0 ? false:null"
                                >
                                    <v-select
                                        placeholder="Select Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="companyListOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="company"
                                        v-model="company"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                </b-form-group>
                            </validation-provider>
                            <validation-provider
                                #default="{ errors }"
                                name="Year"
                                rules="required"
                            >
                                <b-form-group
                                    label="Year"
                                    label-for="year"
                                    :state="errors.length > 0 ? false:null"
                                >
                                    <v-select
                                        placeholder="Select Type"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="financialYear"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="year"
                                        v-model="selectedYear"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                </b-form-group>
                            </validation-provider>

                            <!-- email -->
                            <b-form-group
                                label="User ID"
                                label-for="username"
                            >
                                <validation-provider
                                    #default="{ errors }"
                                    name="Username"
                                    rules="required"
                                >
                                    <b-form-input
                                        id="username"
                                        v-model="userUsername"
                                        :state="errors.length > 0 ? false:null"
                                        name="username"
                                        placeholder="USERNAME"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </validation-provider>
                            </b-form-group>

                            <!-- forgot password -->
                            <b-form-group>
                                <div class="d-flex justify-content-between">
                                    <label for="password">Password</label>
                                    <!-- <b-link :to="{name:'auth-forgot-password'}">
                                         <small>Forgot Password?</small>
                                     </b-link>-->
                                </div>
                                <validation-provider
                                    #default="{ errors }"
                                    name="Password"
                                    vid="password"
                                    rules="required"
                                >
                                    <b-input-group
                                        class="input-group-merge"
                                        :class="errors.length > 0 ? 'is-invalid':null"
                                    >
                                        <b-form-input
                                            id="password"
                                            v-model="password"
                                            :state="errors.length > 0 ? false:null"
                                            class="form-control-merge"
                                            :type="passwordFieldType"
                                            name="password"
                                            placeholder="Password"
                                        />
                                        <b-input-group-append is-text>
                                            <feather-icon
                                                class="cursor-pointer"
                                                :icon="passwordToggleIcon"
                                                @click="togglePasswordVisibility"
                                            />
                                        </b-input-group-append>
                                    </b-input-group>
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </validation-provider>
                            </b-form-group>

                            <!-- checkbox -->
                            <b-form-group>
                                <b-form-checkbox
                                    id="remember-me"
                                    v-model="status"
                                    name="checkbox-1"
                                >
                                    Remember Me
                                </b-form-checkbox>
                            </b-form-group>

                            <!-- submit buttons -->
                            <b-button
                                type="submit"
                                variant="primary"
                                block
                                :disabled="invalid"
                            >
                                Sign in
                            </b-button>
                        </b-form>
                    </validation-observer>
                </b-col>
            </b-col>
            <!-- /Login-->
        </b-row>
    </div>
</template>

<script>
/* eslint-disable global-require */
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
    BAlert,
    BButton,
    BCardText,
    BCardTitle,
    BCol,
    BForm,
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BImg,
    BInputGroup,
    BInputGroupAppend,
    BLink,
    BRow,
    VBTooltip,
} from 'bootstrap-vue'
import useJwt from '@/auth/jwt/useJwt'
import { email, required } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import { getHomeRouteForLoggedInUser } from '@/auth/utils'
import vSelect from 'vue-select'

import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
    directives: {
        'b-tooltip': VBTooltip,
    },
    components: {
        BRow,
        BCol,
        BLink,
        BFormGroup,
        BFormInput,
        BInputGroupAppend,
        BInputGroup,
        BFormCheckbox,
        BCardText,
        BCardTitle,
        BImg,
        BForm,
        BButton,
        BAlert,
        vSelect,
        VuexyLogo,
        ValidationProvider,
        ValidationObserver,
    },
    mixins: [togglePasswordVisibility],
    data() {
        return {
            status: '',
            password: '',
            userUsername: '',
            company: '',
            selectedYear: '',
            companyListOptions: [],
            financialYear: [
                {
                    label: new Date().getFullYear() - 1 + '-' + new Date().getFullYear(),
                    value: new Date().getFullYear() - 1 + '-' + new Date().getFullYear()
                },
                {
                    label: new Date().getFullYear() + '-' + (new Date().getFullYear() + 1),
                    value: new Date().getFullYear() + '-' + (new Date().getFullYear() + 1)
                },
            ],
            sideImg: require('@/assets/images/pages/login-v2.svg'),

            // validation rules
            required,
            email,
        }
    },
    computed: {
        passwordToggleIcon() {
            return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
        },
        imgUrl() {
            if (store.state.appConfig.layout.skin === 'dark') {
                // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                this.sideImg = require('@/assets/images/pages/login-v2-dark.svg')
                return this.sideImg
            }
            return this.sideImg
        },
    },
    beforeCreate() {
        this.$http.get('/api/administration/get-company-list-options')
            .then((res) => {
                this.companyListOptions = res.data.data
            })
    },
    methods: {
        login() {
            this.$refs.loginForm.validate()
                .then(success => {
                    if (success) {
                        useJwt
                            .login({
                                username: this.userUsername,
                                password: this.password,
                                companyId: this.company,
                                year: this.selectedYear,
                            })
                            .then(response => {
                                const { userData } = response.data
                                if (userData) {
                                    useJwt.setToken(response.data.accessToken)
                                    //useJwt.setRefreshToken(response.data.refreshToken)
                                    localStorage.setItem('userData', JSON.stringify(userData))
                                    this.$ability.update(userData.ability)

                                    // ? This is just for demo purpose as well.
                                    // ? Because we are showing eCommerce app's cart items count in navbar
                                    //this.$store.commit('app-ecommerce/UPDATE_CART_ITEMS_COUNT', userData.extras.eCommerceCartItemsCount)

                                    // ? This is just for demo purpose. Don't think CASL is role based in this case, we used role in if condition just for ease
                                    this.$router.replace(getHomeRouteForLoggedInUser(userData.role))
                                        .then(() => {
                                            this.$toast({
                                                component: ToastificationContent,
                                                position: 'top-right',
                                                props: {
                                                    title: `Welcome ${userData.fullName || userData.username}`,
                                                    icon: 'CoffeeIcon',
                                                    variant: 'success',
                                                    text: `You have successfully logged in as ${userData.role}. Now you can start to explore!`,
                                                },
                                            })
                                        })
                                }
                            })
                            .catch(error => {
                                //this.$refs.loginForm.setErrors(error.response.data.error)
                                this.$toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: `Invalid Credentials`,
                                        icon: 'AlertCircleIcon',
                                        variant: 'danger',
                                        text: `Email address or password is wrong !`,
                                    },
                                })
                            })
                    }
                })
        },
    },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/pages/page-auth.scss';
</style>
