<template>
  <div>
    <br>
    <!-- Header: Personal Info -->

    <b-form class="mt-1">
      <b-row>
        <b-col
            cols="12"
            md="6"
            lg="5"
        >
          <b-form-group
              label="Company"
              label-for="company"
          >
            <v-select
                v-model="userFormData.company"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="companyDetailOptions"
                :clearable="false"
                input-id="company"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Mobile -->
        <b-col
            cols="12"
            md="6"
            lg="4"
        >
          <b-form-group
              label="Name"
              label-for="name"
          >
            <b-form-input
                id="name"
                v-model="userFormData.name"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Website -->
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Code"
              label-for="code"
          >
            <b-form-input
                id="website"
                v-model="userFormData.code"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <hr>
      <b-row>
        <!-- Meadia -->
        <b-media class="mb-3">
          <template #aside>
            <b-avatar
                class="ml-1"
                ref="previewEl"
                :src="userFormData.avatar"
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
              >
              <!--                                                            @input="inputImageRenderer"
              -->
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
          <b-form-group
              label="Ticket No."
              label-for="ticketNo"
          >
            <b-form-input
                id="name"
                v-model="userFormData.ticketNo"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Mobile -->
        <b-col
            cols="12"
            md="6"
            lg="4"
        >
          <b-form-group
              label="Employee Code"
              label-for="employeeCode"
          >
            <b-form-input
                id="employeeCode"
                v-model="userFormData.employeeCode"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Website -->
        <b-col
            cols="12"
            md="6"
            lg="4"
        >
          <b-form-group
              label="Title"
              label-for="title"
          >
            <v-select
                v-model="userFormData.title"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="titleOptions"
                :clearable="false"
                input-id="title"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col
            cols="12"
            md="6"
            lg="4"
        >
          <b-form-group
              label="Gender"
              label-for="gender"
              label-class="mb-1"
          >
            <b-form-radio-group
                id="gender"
                v-model="userFormData.gender"
                :options="genderOptions"
            />
          </b-form-group>
        </b-col>
        <b-col
            cols="12"
            md="6"
            lg="4"
        >
          <b-form-group
              label="Birth Date"
              label-for="birthDate"
          >
            <b-input-group>
              <cleave
                  id="birthDate"
                  v-model="userFormData.birthDate"
                  class="form-control"
                  :raw="false"
                  :options="dateFormat"
                  placeholder="DD/MM/YYYY"
                  show-decade-nav
              />
              <b-input-group-append>
                <b-form-datepicker
                    v-model="formatDates.birthDate"
                    button-only
                    @input="getDobFormatDate($event)"
                    show-decade-nav
                    size="sm"
                    nav-button-variant="primary"
                />
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>

        <b-col
            cols="12"
            md="6"
            lg="4"
        >
          <b-form-group
              label="Age"
              label-for="age"
          >
            <b-form-input
                id="age"
                v-model="userFormData.age"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <hr>
      <b-row>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Grade"
              label-for="grade"
          >
            <v-select
                v-model="userFormData.grade"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="gradeOptions"
                :clearable="false"
                input-id="grade"
            />
          </b-form-group>
        </b-col>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Branch"
              label-for="branch"
          >
            <v-select
                v-model="userFormData.branch"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="branchOptions"
                :clearable="false"
                input-id="branch"
            />
          </b-form-group>
        </b-col>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Department"
              label-for="department"
          >
            <v-select
                v-model="userFormData.department"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="departmentOptions"
                :clearable="false"
                input-id="grade"
            />
          </b-form-group>
        </b-col>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Designation"
              label-for="designation"
          >
            <v-select
                v-model="userFormData.designation"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="designationOptions"
                :clearable="false"
                input-id="branch"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Devision"
              label-for="devision"
          >
            <v-select
                v-model="userFormData.devision"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="devisionOptions"
                :clearable="false"
                input-id="devision"
            />
          </b-form-group>
        </b-col>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Unit"
              label-for="unit"
          >
            <v-select
                v-model="userFormData.unit"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="unitOptions"
                :clearable="false"
                input-id="unit"
            />
          </b-form-group>
        </b-col>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Category"
              label-for="category"
          >
            <v-select
                v-model="userFormData.category"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="categoryOptions"
                :clearable="false"
                input-id="category"
            />
          </b-form-group>
        </b-col>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Group"
              label-for="group"
          >
            <v-select
                v-model="userFormData.group"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="groupOptions"
                :clearable="false"
                input-id="group"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <hr>
      <b-row>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Joining Date"
              label-for="joiningDate"
          >
            <b-input-group>
              <cleave
                  id="joiningDate"
                  v-model="userFormData.joiningDate"
                  class="form-control"
                  :raw="false"
                  :options="dateFormat"
                  placeholder="DD/MM/YYYY"
                  show-decade-nav
              />
              <b-input-group-append>
                <b-form-datepicker
                    v-model="formatDates.joiningDate"
                    button-only
                    @input="getJoiningFormatDate($event)"
                    show-decade-nav
                    size="sm"
                    nav-button-variant="primary"
                />
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
        <b-col
            cols="12"
            md="6"
            lg="3"
        >
          <b-form-group
              label="Confirm Date"
              label-for="confirmDate"
          >
            <b-input-group>
              <cleave
                  id="joiningDate"
                  v-model="userFormData.confirmDate"
                  class="form-control"
                  :raw="false"
                  :options="dateFormat"
                  placeholder="DD/MM/YYYY"
                  show-decade-nav
              />
              <b-input-group-append>
                <b-form-datepicker
                    v-model="formatDates.confirmDate"
                    button-only
                    @input="getConfirmFormatDate($event)"
                    show-decade-nav
                    size="sm"
                    nav-button-variant="primary"
                />
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
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
  BFormInput,
  BButton,
  BMedia,
  BAvatar,
  BFormRadioGroup,
  BInputGroup,
  BInputGroupAppend,
  BFormDatepicker
} from 'bootstrap-vue'
import {ref} from '@vue/composition-api'
import vSelect from 'vue-select'
import {avatarText} from '@core/utils/filter'
import useUsersList from "./useUsersList";
import {forMatIndianDate} from "@core/utils/utils";
import Cleave from 'vue-cleave-component'

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
    BFormDatepicker,
    Cleave
  },
  setup() {
    const dateFormat = ref({
      date: true,
      delimiter: '/',
      datePattern: ['d', 'm', 'Y'],
    })
    const formatDates = ref({
      birthDate: null,
      joiningDate: null,
      confirmDate: null,
    })
    const getDobFormatDate = (date) => {
      userFormData.value.birthDate = forMatIndianDate(date)
    }
    const getJoiningFormatDate = (date) => {
      userFormData.value.joiningDate = forMatIndianDate(date)
    }
    const getConfirmFormatDate = (date) => {
      userFormData.value.confirmDate = forMatIndianDate(date)
    }
    const {resolveUserRoleVariant} = useUsersList()

    const userFormData = ref({
      company: null,
      name: null,
      code: null,
    })
    const companyDetailOptions = ref([
      {label: 'Male', value: 1},
      {label: 'Female', value: 2},
    ])
    const genderOptions = ref([
      {text: 'Male', value: 1},
      {text: 'Female', value: 2},
    ])
    const titleOptions = ref([
      {label: 'Yes', value: 1},
      {label: 'No', value: 2},
    ])
    const gradeOptions = ref([])
    const branchOptions = ref([])
    const departmentOptions = ref([])
    const designationOptions = ref([])
    const devisionOptions = ref([])
    const unitOptions = ref([])
    const categoryOptions = ref([])
    const groupOptions = ref([])
    return {
      companyDetailOptions,
      userFormData,
      avatarText,
      resolveUserRoleVariant,
      titleOptions,
      genderOptions,
      dateFormat,
      formatDates,
      getDobFormatDate,
      gradeOptions,
      branchOptions,
      departmentOptions,
      designationOptions,
      devisionOptions,
      unitOptions,
      categoryOptions,
      groupOptions,
      getJoiningFormatDate,
      getConfirmFormatDate
    }
  }
}
</script>
