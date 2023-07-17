<template>
    <div>
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <div class="d-flex">
                    <feather-icon
                        icon="HomeIcon"
                        size="19"
                    />
                    <h4 class="mb-0 ml-50">
                        Bank Information
                    </h4>
                </div>
                <br>
                <b-row>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="Beneficiary Name"
                            rules=""
                        >
                            <b-form-group
                                label="Beneficiary Name"
                                label-for="beneficiary_name"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="beneficiary_name"
                                    placeholder="Beneficiary Name"
                                    v-model="userFormData.beneficiary_name"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="Bank Name"
                            rules=""
                        >
                            <b-form-group
                                label="Bank Name"
                                label-for="bank_name"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="bank_name"
                                    placeholder="Bank Name"
                                    v-model="userFormData.bank_name"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="Bank Account No"
                            rules=""
                        >
                            <b-form-group
                                label="Bank A/C No"
                                label-for="bank_account_no"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="bank_account_no"
                                    placeholder="Account No"
                                    type="number"
                                    v-model="userFormData.bank_account_no"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="Branch Name"
                            rules=""
                        >
                            <b-form-group
                                label="Branch Name"
                                label-for="branch_name"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="branch_name"
                                    placeholder="Branch Name"
                                    v-model="userFormData.branch_name"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="Branch Code"
                            rules=""
                        >
                            <b-form-group
                                label="Branch Code"
                                label-for="branch_code"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="branch_code"
                                    placeholder="Branch Code"
                                    v-model="userFormData.branch_code"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="IFS Code"
                            rules=""
                        >
                            <b-form-group
                                label="IFS Code"
                                label-for="ifs_code"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="ifs_code"
                                    placeholder="IFS Code"
                                    v-model="userFormData.ifs_code"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="MICR Code"
                            rules=""
                        >
                            <b-form-group
                                label="MICR Code"
                                label-for="micr_code"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="micr_code"
                                    placeholder="MICR Code"
                                    v-model="userFormData.micr_code"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="SWIFT Code"
                            rules=""
                        >
                            <b-form-group
                                label="SWIFT Code"
                                label-for="swift_code"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="swift_code"
                                    placeholder="SWIFT Code"
                                    v-model="userFormData.swift_code"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="I BAN Number"
                            rules=""
                        >
                            <b-form-group
                                label="I BAN Number"
                                label-for="i_ban_number"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="i_ban_number"
                                    placeholder="I BAN Number"
                                    v-model="userFormData.i_ban_number"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <hr>
                <b-row>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="Employee Type"
                            rules=""
                        >
                            <b-form-group
                                label="Employee Type"
                                label-for="employee_type"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.employee_type"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="employeeTypeOptions"
                                    :clearable="false"
                                    input-id="employee_type"
                                    placeholder="Select Type"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="8">
                        <validation-provider
                            #default="validationContext"
                            name="Remarks"
                            rules=""
                        >
                            <b-form-group
                                label="Remarks"
                                label-for="employee_remarks"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-textarea
                                    id="employee_remarks"
                                    v-model="userFormData.employee_remarks"
                                    rows="2"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <hr>
                <b-row>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="PAN No."
                            rules=""
                        >
                            <b-form-group
                                label="PAN No."
                                label-for="pan_number"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="pan_number"
                                    placeholder="PAN No"
                                    v-model="userFormData.pan_number"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="UAN No."
                            rules=""
                        >
                            <b-form-group
                                label="UAN No."
                                label-for="uan_number"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="uan_number"
                                    placeholder="UAN No"
                                    v-model="userFormData.uan_number"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="PRAN No."
                            rules=""
                        >
                            <b-form-group
                                label="PRAN No."
                                label-for="pran_number"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="pran_number"
                                    placeholder="PRAN No"
                                    v-model="userFormData.pran_number"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="Aadhar No."
                            rules=""
                        >
                            <b-form-group
                                label="Aadhar No."
                                label-for="aadhar_number"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="aadhar_number"
                                    placeholder="Aadhar No"
                                    v-model="userFormData.aadhar_number"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Group Join Date"
                            rules=""
                        >
                            <b-form-group
                                label="Group Join Date"
                                label-for="group_join_Date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="group_join_Date"
                                        v-model="userFormData.group_join_Date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.group_join_Date"
                                            button-only
                                            @input="getGroupJoinFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="Surcharge"
                            rules=""
                        >
                            <b-form-group
                                label="Surcharge"
                                label-for="surcharge"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.surcharge"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="surchargeOptions"
                                    :clearable="false"
                                    input-id="surcharge"
                                    placeholder="Select Surcharge"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="Gratuity Code"
                            rules=""
                        >
                            <b-form-group
                                label="Gratuity Code"
                                label-for="gratuity_Code"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="gratuity_Code"
                                    placeholder="Gratuity Code"
                                    v-model="userFormData.gratuity_Code"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row><hr>
                <div class="d-flex">
                    <feather-icon
                        icon="ArchiveIcon"
                        size="19"
                    />
                    <h4 class="mb-0 ml-50">
                        Employees' Provident Fund
                    </h4>
                </div><br>
                <b-row>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="PF"
                            rules=""
                        >
                            <b-form-group
                                label="PF"
                                label-for="provident_fund"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.provident_fund"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="providentFundOptions"
                                    :clearable="false"
                                    input-id="provident_fund"
                                    placeholder="Select PF"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="PF No."
                            rules=""
                        >
                            <b-form-group
                                label="PF No."
                                label-for="provident_fund_number"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="provident_fund_number"
                                    placeholder="PF No"
                                    v-model="userFormData.provident_fund_number"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="FPF No."
                            rules=""
                        >
                            <b-form-group
                                label="FPF No."
                                label-for="family_pension_fund_number"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="family_pension_fund_number"
                                    placeholder="FPF No"
                                    v-model="userFormData.family_pension_fund_number"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="3">
                        <validation-provider
                            #default="validationContext"
                            name="VPF %"
                            rules=""
                        >
                            <b-form-group
                                label="VPF %"
                                label-for="voluntary_provident_fund_persent"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="voluntary_provident_fund_persent"
                                    placeholder="VPF %"
                                    v-model="userFormData.voluntary_provident_fund_persent"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="PF Join Date"
                            rules=""
                        >
                            <b-form-group
                                label="PF Join Date"
                                label-for="provident_fund_join_Date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="provident_fund_join_Date"
                                        v-model="userFormData.provident_fund_join_Date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.provident_fund_join_Date"
                                            button-only
                                            @input="getPfJoinFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="PF Remarks"
                            rules=""
                        >
                            <b-form-group
                                label="PF Remarks"
                                label-for="provident_fund_remarks"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-textarea
                                    id="provident_fund_remarks"
                                    v-model="userFormData.provident_fund_remarks"
                                    rows="2"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row><hr>
                <div class="d-flex">
                    <feather-icon
                        icon="BoxIcon"
                        size="19"
                    />
                    <h4 class="mb-0 ml-50">
                        Employees' State Insurance Scheme
                    </h4>
                </div><br>
                <b-row>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="ESIC"
                            rules=""
                        >
                            <b-form-group
                                label="ESIC"
                                label-for="emp_state_insurance_scheme"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.emp_state_insurance_scheme"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="providentFundOptions"
                                    :clearable="false"
                                    input-id="emp_state_insurance_scheme"
                                    placeholder="Select ESIC"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="ESIC No."
                            rules=""
                        >
                            <b-form-group
                                label="ESIC No."
                                label-for="emp_state_insurance_scheme_no"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="emp_state_insurance_scheme_no"
                                    placeholder="ESIC No"
                                    v-model="userFormData.emp_state_insurance_scheme_no"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="4">
                        <validation-provider
                            #default="validationContext"
                            name="ESIC IMP Code"
                            rules=""
                        >
                            <b-form-group
                                label="ESIC IMP Code"
                                label-for="emp_state_insurance_scheme_imp_code"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="emp_state_insurance_scheme_imp_code"
                                    placeholder="ESIC IMP Code"
                                    v-model="userFormData.emp_state_insurance_scheme_imp_code"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="ESIC IMP Name"
                            rules=""
                        >
                            <b-form-group
                                label="ESIC IMP Name"
                                label-for="emp_state_insurance_scheme_imp_name"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="emp_state_insurance_scheme_imp_name"
                                    placeholder="ESIC IMP Name"
                                    v-model="userFormData.emp_state_insurance_scheme_imp_name"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="ESIC Remarks"
                            rules=""
                        >
                            <b-form-group
                                label="ESIC Remarks"
                                label-for="emp_state_insurance_scheme_remarks"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-textarea
                                    id="emp_state_insurance_scheme_remarks"
                                    v-model="userFormData.emp_state_insurance_scheme_remarks"
                                    rows="2"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row><hr>
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="P.T."
                            rules=""
                        >
                            <b-form-group
                                label="P.T."
                                label-for="p_t"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.p_t"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="ptOptions"
                                    :clearable="false"
                                    input-id="p_t"
                                    placeholder="Select PT"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="P.T. No."
                            rules=""
                        >
                            <b-form-group
                                label="P.T. No."
                                label-for="pt_number"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="pt_number"
                                    placeholder="PT No"
                                    v-model="userFormData.pt_number"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row><hr>
                <b-col md="12">
                    <b-button
                        type="submit"
                        variant="primary"
                        class="float-right"
                    >
                        Save
                    </b-button>
                </b-col>
            </b-form>
        </validation-observer>
    </div>
</template>
<script>
    import {
        BForm,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BFormTextarea,
        BInputGroup,
        BInputGroupAppend,
        BFormDatepicker,
        BButton
    } from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {required} from '@validations'
    import vSelect from 'vue-select'
    import {computed, ref, onUnmounted} from '@vue/composition-api'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Cleave from 'vue-cleave-component'
    import {forMatIndianDate} from "@core/utils/utils";
    import userStoreModule from "../userStoreModule";
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            ValidationProvider,
            ValidationObserver,
            vSelect,
            BFormTextarea,
            BFormInvalidFeedback,
            BInputGroup,
            BInputGroupAppend,
            BFormDatepicker,
            Cleave,
            BButton
        },
        props:{
            userStatutoryDetails:{
                type: Object,
                required: true,
            }
        },
        setup(props) {
            /*
            const toast = useToast()

            const ITEMADDON_APP_STORE_MODULE_NAME = 'users-store-module'
            if (!store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.registerModule(ITEMADDON_APP_STORE_MODULE_NAME, userStoreModule)
            onUnmounted(() => {
                if (store.hasModule(ITEMADDON_APP_STORE_MODULE_NAME)) store.unregisterModule(ITEMADDON_APP_STORE_MODULE_NAME)
            })
            */

            const employeeTypeOptions = ref([
                {label: 'Reset', value: 1},
            ])

            const surchargeOptions = ref([
                {label: 'Yes', value: 1},
                {label: 'No', value: 2}
            ])

            const providentFundOptions = ref([
                {label: 'Yes', value: 1},
                {label: 'No', value: 2}
            ])

            const ptOptions = ref([
                {label: 'Yes', value: 1},
                {label: 'No', value: 2}
            ])

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                group_join_Date: null,
                provident_fund_join_Date: null,
            })

            const getGroupJoinFormatDate = (date) => {
                userFormData.value.group_join_Date = forMatIndianDate(date)
            }

            const getPfJoinFormatDate = (date) => {
                userFormData.value.provident_fund_join_Date = forMatIndianDate(date)
            }

            const userFormData = computed(() => props.userStatutoryDetails)

            const resetFormData = () => {
                userFormData.value = JSON.parse(JSON.stringify(blankFormData))
            }

            const saveFormData = async () => {
                console.log(userFormData.value)
                /* let submitData = {
                     _id: router.currentRoute.params.id,
                     userStatutoryDetails: userFormData.value
                 }*/
                /*     await store.dispatch('users-store-module/updateUserManagementDetail', submitData).then((res) => {
                         if (res.status === 200) {
                             toast({
                                 component: ToastificationContent,
                                 position: 'top-right',
                                 props: {
                                     title: 'user Statutory Detail updated',
                                     icon: 'CheckSquareIcon',
                                     variant: 'success',
                                     text: `You have successfully Updated User Statutory Detail.`,
                                 },
                             })
                         } else {
                             toast({
                                 component: ToastificationContent,
                                 position: 'top-right',
                                 props: {
                                     title: 'Error',
                                     icon: 'AlertCircleIcon',
                                     variant: 'danger',
                                     text: 'Something went wrong!',
                                 },
                             })
                         }

                     })
                 */
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                /*Form Data*/
                saveFormData,
                userFormData,

                /* Validations */
                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                required,

                /* Option */
                employeeTypeOptions,
                surchargeOptions,
                providentFundOptions,
                ptOptions,

                /* date Format */
                dateFormat,
                getGroupJoinFormatDate,
                getPfJoinFormatDate,
                formatDates,

            }
        }
    }
</script>
