<template>
    <div>
        <br>
        <!-- Header: Personal Info -->
        <validation-observer #default="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(saveFormData)" class="mt-1">
                <b-row>
                    <!-- Meadia -->
                    <b-media class="mb-3">
                        <template #aside>
                            <b-avatar
                                class="ml-1"
                                ref="previewEl"
                                :src="userFormData.userImages"
                                :text="avatarText(userFormData.fullName)"
                                :variant="`light-${resolveUserRoleVariant(userFormData.role)}`"
                                size="90px"
                                rounded
                            />
                        </template>
                        <h4 class="mb-1">
                            {{ userFormData.fullName }}
                        </h4>
                        <div class="d-flex flex-wrap">
                            <b-button
                                variant="primary"
                                @click="$refs.refInputEl.click()"
                            >
                                <input
                                    ref="refInputEl"
                                    type="file"
                                    class="d-none"
                                    @input="inputImageRenderer"
                                >
                                <span class="d-none d-sm-inline">Update</span>
                                <feather-icon
                                    icon="EditIcon"
                                    class="d-inline d-sm-none"
                                />
                            </b-button>
                            <b-button
                                variant="outline-secondary"
                                class="ml-1"
                            >
                                <span class="d-none d-sm-inline">Remove</span>
                                <feather-icon
                                    icon="TrashIcon"
                                    class="d-inline d-sm-none"
                                />
                            </b-button>
                        </div>
                    </b-media>
                </b-row>
                <b-row>
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Ticket No."
                            rules=""
                        >
                            <b-form-group
                                label="Ticket No."
                                label-for="ticketNo"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="name"
                                    placeholder="Ticket No"
                                    v-model="userFormData.ticketNo"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>

                    <!-- Field: Mobile -->
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Employee Code"
                            rules=""
                        >
                            <b-form-group
                                label="Employee Code"
                                label-for="employee_code"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="employee_code"
                                    placeholder="Employee Code"
                                    v-model="userFormData.employee_code"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>

                    <!-- Field: Website -->
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Title"
                            rules=""
                        >
                            <b-form-group
                                label="Title"
                                label-for="title"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.title"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="titleOptions"
                                    :clearable="false"
                                    input-id="title"
                                    placeholder="Select Title"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Gender"
                            rules=""
                        >
                            <b-form-group
                                label="Gender"
                                label-for="gender"
                                label-class="mb-1"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-radio-group
                                    id="gender"
                                    v-model="userFormData.gender"
                                    :options="genderOptions"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Birth Date"
                            rules=""
                        >
                            <b-form-group
                                label="Birth Date"
                                label-for="birth_date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="birth_date"
                                        v-model="userFormData.birth_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.birthDate"
                                            button-only
                                            @input="getDobFormatDate($event)"
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

                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Age"
                            rules=""
                        >
                            <b-form-group
                                label="Age"
                                label-for="age"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="age"
                                    v-model="userFormData.age"
                                    type="number"
                                    placeholder="Age"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Grade"
                            rules=""
                        >
                            <b-form-group
                                label="Grade"
                                label-for="grade"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.grade"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="gradeOptions"
                                    :clearable="false"
                                    input-id="grade"
                                    placeholder="Select Grade"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Branch"
                            rules=""
                        >
                            <b-form-group
                                label="Branch"
                                label-for="branch"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.branch"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="branchOptions"
                                    :clearable="false"
                                    input-id="branch"
                                    placeholder="Select Branch"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Department"
                            rules=""
                        >
                            <b-form-group
                                label="Department"
                                label-for="department"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.department"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="departmentOptions"
                                    :clearable="false"
                                    input-id="grade"
                                    placeholder="Select Department"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Designation"
                            rules=""
                        >
                            <b-form-group
                                label="Designation"
                                label-for="designation"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.designation"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="designationOptions"
                                    :clearable="false"
                                    input-id="branch"
                                    placeholder="Select Desination"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Division"
                            rules=""
                        >
                            <b-form-group
                                label="Division"
                                label-for="division"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.division"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="divisionOptions"
                                    :clearable="false"
                                    placeholder="Select Division"
                                    input-id="division"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Unit"
                            rules=""
                        >
                            <b-form-group
                                label="Unit"
                                label-for="unit"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.unit"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="unitOptions"
                                    :clearable="false"
                                    input-id="unit"
                                    placeholder="Select Unit"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Category"
                            rules=""
                        >
                            <b-form-group
                                label="Category"
                                label-for="category"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.category"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="categoryOptions"
                                    :clearable="false"
                                    placeholder="Select Category"
                                    input-id="category"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Group"
                            rules=""
                        >
                            <b-form-group
                                label="Group"
                                label-for="group"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.group"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="groupOptions"
                                    :clearable="false"
                                    placeholder="Select Group"
                                    input-id="group"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Joining Date"
                            rules=""
                        >
                            <b-form-group
                                label="Joining Date"
                                label-for="joining_date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="joining_date"
                                        v-model="userFormData.joining_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.joining_date"
                                            button-only
                                            @input="getJoiningFormatDate($event)"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Confirm Date"
                            rules=""
                        >
                            <b-form-group
                                label="Confirm Date"
                                label-for="confirm_date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="confirm_date"
                                        v-model="userFormData.confirm_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.confirm_date"
                                            button-only
                                            @input="getConfirmFormatDate($event)"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Probation Date"
                            rules=""
                        >
                            <b-form-group
                                label="Probation Date"
                                label-for="probation_date"
                            >
                                <b-input-group>
                                    <b-input-group-prepend>
                                        <b-form-datepicker
                                            v-model="formatDates.probation_date"
                                            button-only
                                            @input="getProbationFormatDate($event)"
                                            show-decade-nav
                                            size="sm"
                                            nav-button-variant="primary"
                                            :state="getValidationState(validationContext)"
                                        />
                                    </b-input-group-prepend>
                                    <cleave
                                        id="probation_date"
                                        v-model="userFormData.probation_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                </b-input-group>
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Last Increment Give on"
                            rules=""
                        >
                            <b-form-group
                                label="Last Increment Give on"
                                label-for="last_increment_date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="last_increment_date"
                                        v-model="userFormData.last_increment_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.last_increment_date"
                                            button-only
                                            @input="getIncrementFormatDate($event)"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Resion Offer Date"
                            rules=""
                        >
                            <b-form-group
                                label="Resion Offer Date"
                                label-for="resign_offer_date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="resign_offer_date"
                                        v-model="userFormData.resign_offer_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.resign_offer_date"
                                            button-only
                                            @input="getResionFormatDate($event)"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Employee Status"
                            rules=""
                        >
                            <b-form-group
                                label="Employee Status"
                                label-for="employee_status"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.employee_status"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="employeeStatusOptions"
                                    :clearable="false"
                                    placeholder="Select Status"
                                    input-id="employee_status"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Last Work Date"
                            rules=""
                        >
                            <b-form-group
                                label="Last Work Date"
                                label-for="last_work_date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="lastWorkDate"
                                        v-model="userFormData.last_work_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.last_work_date"
                                            button-only
                                            @input="getLastWorkDate($event)"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="F & F"
                            rules=""
                        >
                            <b-form-group
                                label="F & F"
                                label-for="f_and_F_date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="f_and_F_Date"
                                        v-model="userFormData.f_and_F_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.f_and_F_date"
                                            button-only
                                            @input="getFandfDate($event)"
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
                </b-row>
                <hr>
                <b-row>
                    <b-col
                        cols="12"
                        md="6"
                        lg="5"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Old Employee Code"
                            rules=""
                        >
                            <b-form-group
                                label="Old Employee Code"
                                label-for="old_employee_code"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.old_employee_code"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="oldEmployeeCodeOptions"
                                    :clearable="false"
                                    placeholder="Select Code"
                                    input-id="old_employee_code"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="4"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Payment Mode"
                            rules=""
                        >
                            <b-form-group
                                label="Payment Mode"
                                label-for="payment_mode"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="userFormData.payment_mode"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="paymentModeOptions"
                                    :clearable="false"
                                    placeholder="Select Mode    "
                                    input-id="payment_mode"
                                    :state="getValidationState(validationContext)"
                                />
                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Service Yrs. Months"
                            rules=""
                        >
                            <b-form-group
                                label="Service Yrs. Months"
                                label-for="service_years_month"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-input
                                    id="service_years_month"
                                    v-model="userFormData.service_years_month"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="3"
                    >
                        <b-form-checkbox
                            class="mb-2"
                            v-model="userFormData.freeze_payment"
                            name="freeze_payment"
                        >
                            Freeze Payment
                        </b-form-checkbox>
                        <validation-provider
                            #default="validationContext"
                            name="Freeze Date"
                            rules=""
                        >
                            <b-form-group
                                label="Freeze Date"
                                label-for="freeze_date"
                                :state="getValidationState(validationContext)"
                            >
                                <b-input-group>
                                    <cleave
                                        id="freeze_date"
                                        v-model="userFormData.freeze_date"
                                        class="form-control"
                                        :raw="false"
                                        :options="dateFormat"
                                        placeholder="DD/MM/YYYY"
                                        show-decade-nav
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-input-group-append>
                                        <b-form-datepicker
                                            v-model="formatDates.freeze_date"
                                            button-only
                                            @input="getFreezeFormatDate($event)"
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
                    <b-col
                        cols="12"
                        md="6"
                        lg="9"
                    >
                        <validation-provider
                            #default="validationContext"
                            name="Freeze Reason"
                            rules=""
                        >
                            <b-form-group
                                label="Freeze Reason"
                                label-for="freeze_reason"
                                :state="getValidationState(validationContext)"
                            >
                                <b-form-textarea
                                    name="freeze_reason"
                                    v-model="userFormData.freeze_reason"
                                    id="freeze_reason"
                                    rows="3"
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
                    <b-col md="12">
                        <hr>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1 float-right"
                        >
                            Salary Structure
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            class="mr-1 float-right"
                        >
                            Save
                        </b-button>
                    </b-col>
                </b-row>
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
        BButton,
        BMedia,
        BAvatar,
        BFormRadioGroup,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend,
        BFormDatepicker,
        BFormCheckbox,
        BFormTextarea,
        BFormInvalidFeedback
    } from 'bootstrap-vue'
    import {computed, ref, onUnmounted} from '@vue/composition-api'
    import vSelect from 'vue-select'
    import {avatarText} from '@core/utils/filter'
    import useUsersList from "../useUsersList";
    import {forMatIndianDate, getTcTodayDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'
    import Ripple from "vue-ripple-directive";
    import {useInputImageRenderer} from '@core/comp-functions/forms/form-utils'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ValidationObserver, ValidationProvider} from 'vee-validate'
    import {required} from '@validations'
    import userStoreModule from "../userStoreModule";
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import axios from '@axios'

    export default {
        components: {
            BForm,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BButton,
            vSelect,
            BMedia,
            BAvatar,
            BFormRadioGroup,
            BInputGroup,
            BInputGroupAppend,
            BInputGroupPrepend,
            BFormDatepicker,
            BFormCheckbox,
            BFormTextarea,
            Cleave,
            BFormInvalidFeedback,
            ValidationObserver,
            ValidationProvider
        },
        directives: {
            Ripple,
        },
        props: {
            userGeneralDetails: {
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

            const {resolveUserRoleVariant} = useUsersList()

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })
            const formatDates = ref({
                birth_date: null,
                joining_date: null,
                confirm_date: null,
                probation_date: null,
                last_increment_date: null,
                resign_offer_date: null,
                last_work_date: null,
                f_and_F_date: null,
                freeze_date: null,
            })
            const getDobFormatDate = (date) => {
                userFormData.value.birth_date = forMatIndianDate(date)
            }
            const getJoiningFormatDate = (date) => {
                userFormData.value.joining_date = forMatIndianDate(date)
            }
            const getConfirmFormatDate = (date) => {
                userFormData.value.confirm_date = forMatIndianDate(date)
            }
            const getProbationFormatDate = (date) => {
                userFormData.value.probation_date = forMatIndianDate(date)
            }
            const getIncrementFormatDate = (date) => {
                userFormData.value.last_increment_date = forMatIndianDate(date)
            }
            const getResionFormatDate = (date) => {
                userFormData.value.resign_offer_date = forMatIndianDate(date)
            }
            const getLastWorkDate = (date) => {
                userFormData.value.last_work_date = forMatIndianDate(date)
            }
            const getFandfDate = (date) => {
                userFormData.value.f_and_F_date = forMatIndianDate(date)
            }
            const getFreezeFormatDate = (date) => {
                userFormData.value.freeze_date = forMatIndianDate(date)
            }


            const genderOptions = ref([
                {text: 'Male', value: 1},
                {text: 'Female', value: 2},
                {text: 'Other', value: 3},
            ])
            const titleOptions = ref([
                {label: 'Mr.', value: 1},
                {label: 'Mrs.', value: 2},
                {label: 'Ms.', value: 3},
                {label: 'Shri', value: 4},
                {label: 'Smt.', value: 5},
                {label: 'Dr.', value: 6},
                {label: 'CA', value: 7},
            ])
            const employeeStatusOptions = ref([
                {label: 'Active', value: 1},
            ])

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

            const designationOptions = ref([])
            axios.get('/api/new/get-hr-designation-master')
                .then(res => {
                    designationOptions.value = res.data
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

            const oldEmployeeCodeOptions = ref([])
            const paymentModeOptions = ref([
                {label: 'Cheque', value: 1},
                {label: 'Bank', value: 2},
                {label: 'Cash', value: 3},
                {label: 'DD', value: 4},
            ])

            const serviceYearsMonthOptions = ref([])

            // ? Demo Purpose => Update image on click of update
            const refInputEl = ref(null)
            const previewEl = ref(null)

            const {inputImageRenderer} = useInputImageRenderer(refInputEl, base64 => {
                // eslint-disable-next-line no-param-reassign

                console.log("Image Base64", base64)

                userFormData.value.userImages = base64

            })

            const userFormData = computed(() => props.userGeneralDetails)

            const resetFormData = () => {
                userFormData.value = JSON.parse(JSON.stringify(blankFormData))
            }
            const saveFormData = async () => {
                console.log(userFormData.value)
                /* let submitData = {
                     _id: router.currentRoute.params.id,
                     userGeneralDetails: userFormData.value
                 }*/
                /*     await store.dispatch('users-store-module/updateUserManagementDetail', submitData).then((res) => {
                         if (res.status === 200) {
                             toast({
                                 component: ToastificationContent,
                                 position: 'top-right',
                                 props: {
                                     title: 'user General Detail updated',
                                     icon: 'CheckSquareIcon',
                                     variant: 'success',
                                     text: `You have successfully Updated User General Detail.`,
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
                /*validations*/
                resetFormData,
                refFormObserver,
                getValidationState,
                resetForm,
                required,

                /*user Image*/
                refInputEl,
                previewEl,
                inputImageRenderer,
                avatarText,
                resolveUserRoleVariant,

                /*Form Data*/
                userFormData,
                saveFormData,

                /*Date Format*/
                dateFormat,
                formatDates,
                getDobFormatDate,
                getJoiningFormatDate,
                getConfirmFormatDate,
                getProbationFormatDate,
                getIncrementFormatDate,
                getResionFormatDate,
                getLastWorkDate,
                getFandfDate,
                getFreezeFormatDate,

                /* Option */
                titleOptions,
                genderOptions,
                gradeOptions,
                branchOptions,
                departmentOptions,
                designationOptions,
                divisionOptions,
                unitOptions,
                categoryOptions,
                groupOptions,
                employeeStatusOptions,
                oldEmployeeCodeOptions,
                paymentModeOptions,
                serviceYearsMonthOptions,
            }
        }
    }
</script>
