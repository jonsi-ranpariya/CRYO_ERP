<template>
    <div>
        <!-- table Data -->
        <b-row>
            <b-col md="12">
                <b-table
                    responsive="sm"
                    :fields="table.fields"
                    :items="table.data"
                    :bordered="true"
                    :hover="true"
                    show-empty
                    class="table_scroll"
                    :busy="isBusy"
                    selectable
                    select-mode="single"
                    @row-selected="onRowSelect"
                >
                    <!--Loader-->
                    <template #table-busy>
                        <div class="text-center my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>
                    <!-- A virtual column -->
                    <template #cell(index)="data">
                        {{ data.index + 1 }}
                    </template>

                    <!-- A custom formatted column -->
                    <template #cell(processDesc)="data">
                        <span class="text-nowrap">{{ data.value}}</span>
                    </template>

                    <!-- A custom formatted column -->
                    <template #cell(action)="data">
                        <b-dropdown
                            variant="link"
                            toggle-class="text-decoration-none"
                            no-caret
                        >
                            <template v-slot:button-content>
                                <feather-icon
                                    icon="MoreVerticalIcon"
                                    size="16"
                                    class="text-body align-middle mr-25"
                                />
                            </template>
                            <b-dropdown-item @click="selectProcessItem(data.item._id)">
                                <feather-icon
                                    icon="CheckSquareIcon"
                                    class="mr-50"
                                />
                                <span>Select</span>
                            </b-dropdown-item>
                            <b-dropdown-item @click="deleteProcessData(data.item._id)">
                                <feather-icon
                                    icon="TrashIcon"
                                    class="mr-50"
                                />
                                <span>Delete</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>

                    <!-- Selection Area -->
                    <template #cell(rowSelected)="{ rowSelected }">
                        <template v-if="rowSelected">
                            <span aria-hidden="true">&check;</span>
                            <span class="sr-only">Selected</span>
                        </template>
                        <template v-else>
                            <span aria-hidden="true">&nbsp;</span>
                            <span class="sr-only">Not selected</span>
                        </template>
                    </template>

                </b-table>
                <hr>
            </b-col>
        </b-row>
        <!-- table close-->

        <validation-observer #default="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(saveFormData)">
                <b-row>
                    <b-col md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Process"
                            rules="required"
                        >
                             <b-form-group
                                label="Select Process"
                                label-for="processDescription"
                                :state="getValidationState(validationContext)"
                            >
                                <v-select
                                    v-model="formData.process"
                                    placeholder="Select Process"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="processDesOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="processDescription"
                                    @input="getProcssSheetDetail($event)"
                                />
                                <small class="text-danger">{{ validationContext.errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                        <b-form-group
                            label="Process Description"
                            label-for="processDesc"
                        >
                            <b-form-input
                                id="processDesc"
                                v-model="formData.processDescription"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Machine Number"
                            label-for="machineNumber"
                        >
                            <b-form-input
                                v-model="formData.machineNumber"
                                id="machineNumber"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Operator"
                            label-for="operator"
                        >
                            <b-form-input
                                v-model="formData.operator"
                                id="operator"
                            />
                        </b-form-group>

                        <b-row cols="12 ">
                            <b-col md="6">
                                <b-form-group
                                    label="Quantity"
                                    label-for="quantity"
                                >
                                    <b-form-input
                                        v-model="formData.quantity"
                                        id="quantity"
                                        @keyup="calculateProcessAmount"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Pending Qty"
                                    label-for="pendingQty"
                                >
                                    <b-form-input
                                        v-model="formData.pendingQty"
                                        id="pendingQty"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Accepted Qty"
                                    label-for="acceptedQty"
                                >
                                    <b-form-input
                                        v-model="formData.acceptedQty"
                                        id="acceptedQty"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Rejected Qty"
                                    label-for="rejectedQty"
                                >
                                    <b-form-input
                                        v-model="formData.rejectedQty"
                                        id="rejectedQty"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="R/W Qty"
                                    label-for="rwQty"
                                >
                                    <b-form-input
                                        v-model="formData.rwQty"
                                        id="rwQty"
                                        readonly
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Insp. Instruction"
                            label-for="inspInstruction"
                        >
                            <b-form-textarea
                                v-model="formData.inspInstruction"
                                id="inspInstruction"
                                rows="2"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Inspection By"
                            label-for="inspectionBy"
                        >
                            <b-form-input
                                v-model="formData.inspectionBy"
                                id="inspectionBy"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Inspection Level"
                            label-for="inspectionLevel"
                        >
                            <b-form-input
                                v-model="formData.inspectionLevel"
                                id="inspectionLevel"
                            />
                        </b-form-group>
                        <b-form-group
                            label="Special Tool"
                            label-for="specialTool"
                        >
                            <b-form-input
                                v-model="formData.specialTool"
                                id="specialTool"
                            />
                        </b-form-group>
                        <b-row cols="12">
                            <b-col md="6">
                                <b-form-group
                                    label="Wt Loss %"
                                    label-for="wtLoss"
                                >
                                    <b-form-input
                                        v-model="formData.wtLoss"
                                        id="wtLoss"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Mat. Wt."
                                    label-for="matWt"
                                >
                                    <b-form-input
                                        v-model="formData.matWt"
                                        id="matWt"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Scrap Tolerance (%)"
                                    label-for="scrapTolerance"
                                >
                                    <b-form-input
                                        v-model="formData.scrapTolerance"
                                        id="scrapTolerance"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="No. Of Hr"
                                    label-for="noOfHr"
                                >
                                    <b-form-input
                                        v-model="formData.noOfHr"
                                        id="noOfHr"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-form-group
                            label="Remark"
                            label-for="processRemark"
                        >
                            <b-form-textarea
                                v-model="formData.remark"
                                id="processRemark"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-col md="12">
                    <hr>
                    <div v-if="isProcessButtonShow">
                        <b-button
                            variant="primary"
                            @click="openModalIssueItem"
                        >
                            Show Issue Items
                        </b-button>
                        <b-button
                            variant="primary"
                            @click="openModal"
                        >
                            Process(Inside)
                        </b-button>
                        <b-button
                            variant="primary"
                            @click="openModalProcessOut"
                        >
                            Process(OutSide)
                        </b-button>
                    </div>
                    <div v-if="isButtonShow">
                        <b-button
                            class="float-right"
                            variant="primary"
                            type="submit"
                        >
                            save Process
                        </b-button>
                    </div>

                </b-col>
                <br>
            </b-form>
        </validation-observer>
        <!--Modal-->
        <b-modal
            id="processInSideModal"
            title="Select Item"
            size="xl"
            no-close-on-backdrop
            ref="processInSideModal"
            scrollable
            cancel-variant="danger"
            @ok="saveProcessInSideSideData"
        >
            <validation-observer>
                <b-form>
                    <b-row>
                        <b-col md="6">
                            <validation-provider
                                #default="validationContext"
                                name="Operator Name"
                                rules="required"
                            >
                                <b-form-group
                                    label="Operator Name"
                                    label-for="operatorName"
                                >
                                    <v-select
                                        v-model="formDataProcess.InSideOperatorName"
                                        placeholder="Select Process"
                                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                        :options="processDesOptions"
                                        :reduce="val => val.value"
                                        :clearable="false"
                                        input-id="InSideOperatorName"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                        {{ validationContext.errors[0] }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>

                            <!--  radio Buttons-->
                            <b-row>
                                <b-col md="12">
                                    <b-form-group
                                        label="Type"
                                        label-for="selectType"
                                    >
                                        <div class="demo-inline-spacing">
                                            <b-form-radio
                                                name="selectBatch"
                                                value="1"
                                                v-model="formDataProcess.selectBatch"
                                            >
                                                New
                                            </b-form-radio>
                                            <b-form-radio
                                                name="selectBatch"
                                                value="2"
                                                v-model="formDataProcess.selectBatch"
                                            >
                                                ReWork
                                            </b-form-radio>
                                        </div>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Date"
                                            label-for="operatorDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="InSideOperatorDate"
                                                    v-model="formDataProcess.InSideOperatorDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.InSideOperatorDate"
                                                        button-only
                                                        @input="getInSideOperatorFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Total Availabel Qty"
                                        label-for="totalAvlQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcess.InSideTotalAvlQty"
                                            id="InSideTotalAvlQty"
                                            type="number"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Issue Quntity"
                                        label-for="issueQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcess.InSideIssueQty"
                                            id="InSideIssueQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Process Cost"
                                        label-for="processCost"
                                    >
                                        <b-form-input
                                            v-model="formDataProcess.inSideProcessCost"
                                            id="inSideProcessCost"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>

                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Accept Quntity"
                                        label-for="acceptQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcess.inSideAcceptQty"
                                            id="inSideAcceptQty"
                                            type="number"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Reject Qty"
                                        label-for="rejectQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcess.inSideRejectQty"
                                            id="inSideRejectQty"
                                            type="number"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="No Of Hr"
                                        label-for="noOfHr"
                                    >
                                        <b-form-input
                                            v-model="formDataProcess.inSideNoOfHr"
                                            id="inSideNoOfHr"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="R/W Qty"
                                        label-for="rwQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcess.inSideRwQty"
                                            id="inSideRwQty"
                                            type="number"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Remark"
                                label-for="processRemark"
                            >
                                <b-form-textarea
                                    v-model="formDataProcess.inSideRemark"
                                    id="inSideRemark"
                                />
                            </b-form-group>
                        </b-col>
                        <hr>
                        <!-- Button-->
                        <b-col md="12">
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <b-form-group
                                label="M/C"
                                label-for="machineNo"
                            >
                                <v-select
                                    v-model="formDataProcess.InSideMachineNo"
                                    placeholder="Select Machine"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="machineOptions"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="InSideMachineNo"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="2"></b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Standard"
                                label-for="standard"
                            ></b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Standard Total"
                                label-for="standardTotal"
                            ></b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-form-group
                                label="Actual"
                                label-for="actual"
                            ></b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-form-group
                                label="Difference"
                                label-for="difference"
                            ></b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="2">
                            <b-form-group
                                label="Seup Time(Min.)"
                                label-for="setupTime"
                            ></b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-input
                                v-model="formDataProcess.standardSetTime"
                                id="standardSetTime"
                                type="number"
                                @keyup="calculateTimeAmount"

                            />
                        </b-col>
                        <b-col md="3">
                            <b-form-input
                                v-model="formDataProcess.standardTotalSetTime"
                                id="standardTotalSetTime"
                                type="number"
                                @keyup="calculateTimeAmount"
                            />
                        </b-col>
                        <b-col md="2">
                            <b-form-input
                                v-model="formDataProcess.actualSetTime"
                                id="actualSetTime"
                                type="number"
                                @keyup="calculateTimeAmount"
                            />
                        </b-col>
                        <b-col md="2">
                            <b-form-input
                                v-model="formDataProcess.differenceSetTime"
                                id="differenceSetTime"
                                type="number"
                            />
                        </b-col>
                    </b-row>
                    <br>
                    <b-row>
                        <b-col md="2">
                            <b-form-group
                                label="Process Time(Min.)"
                                label-for="processTime"
                            ></b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-input
                                v-model="formDataProcess.standardProcessTime"
                                id="standardProcessTime"
                                type="number"
                                @keyup="calculateTimeAmount"
                            />
                        </b-col>
                        <b-col md="3">
                            <b-form-input
                                v-model="formDataProcess.standardTotalProcessTime"
                                id="standardTotalProcessTime"
                                type="number"
                                @keyup="calculateTimeAmount"
                            />
                        </b-col>
                        <b-col md="2">
                            <b-form-input
                                v-model="formDataProcess.actualProcessTime"
                                id="actualProcessTime"
                                type="number"
                                @keyup="calculateTimeAmount"
                            />
                        </b-col>
                        <b-col md="2">
                            <b-form-input
                                v-model="formDataProcess.differenceProcessTime"
                                id="differenceProcessTime"
                                type="number"
                            />
                        </b-col>
                    </b-row>
                    <br>
                    <b-row>
                        <b-col md="2">
                            <b-form-group
                                label="Total Time(Min.)"
                                label-for="processTime"
                            ></b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-input
                                v-model="formDataProcess.standardTotalTime"
                                id="standardTotalTime"
                                type="number"
                            />
                        </b-col>
                        <b-col md="3">
                            <b-form-input
                                v-model="formDataProcess.standardTotalTolTime"
                                id="standardTotalTolTime"
                                type="number"
                            />
                        </b-col>
                        <b-col md="2">
                            <b-form-input
                                v-model="formDataProcess.actualTotalTime"
                                id="actualTotalTime"
                                type="number"
                            />
                        </b-col>
                        <b-col md="2">
                            <b-form-input
                                v-model="formDataProcess.differenceTotalTime"
                                id="differenceTotalTime"
                                type="number"
                            />
                        </b-col>
                        <b-col md="1"></b-col>
                    </b-row>
                    <br>
                    <b-row>
                        <b-col md="2">
                            <b-form-group
                                label="Process Cost/Hr"
                                label-for="processCost"
                            ></b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-form-input
                                v-model="formDataProcess.standardProcess"
                                id="standardProcess"
                                type="number"
                            />
                        </b-col>
                        <b-col md="0.5"></b-col>
                        <b-col md="1.5">
                            <b-form-group
                                label="Access Qty"
                                label-for="accessQty"
                            ></b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-input
                                v-model="formDataProcess.accessQty"
                                id="accessQty"
                                type="number"
                            />
                        </b-col>
                        <b-col md="3">
                            <b-button
                                class="mb"
                                variant="primary"
                            >
                                Generate Access Qty
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-modal>

        <b-modal
            id="processOutsideModal"
            title="Select Item"
            size="xl"
            no-close-on-backdrop
            ref="processOutsideModal"
            scrollable
            cancel-variant="danger"
            @ok="saveProcessOutSideData"
        >
            <b-row>
                <b-col md="12">
                    <hr>
                    <b-table
                        responsive
                        :fields="modalTables.processOutSideFields"
                        :items="modalTables.processOutSideData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>
                        <!-- A virtual column -->
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                        <!-- A custom formatted column -->
                        <template #cell(action)="data">
                            <b-dropdown
                                variant="link"
                                toggle-class="text-decoration-none"
                                no-caret
                            >
                                <template v-slot:button-content>
                                    <feather-icon
                                        icon="MoreVerticalIcon"
                                        size="16"
                                        class="text-body align-middle mr-25"
                                    />
                                </template>
                                <b-dropdown-item @click="editProcessOutData(data.item)">
                                    <feather-icon
                                        icon="Edit2Icon"
                                        class="mr-50"
                                    />
                                    <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="deleteProcessOutData(data.item._id)">
                                    <feather-icon
                                        icon="TrashIcon"
                                        class="mr-50"
                                    />
                                    <span>Delete</span>
                                </b-dropdown-item>
                            </b-dropdown>
                        </template>
                    </b-table>
                </b-col>
            </b-row>
            <hr>
            <validation-observer>
                <b-form>
                    <b-col md="10">
                        <b-form-group
                            label="Select Sub-Contractor"
                            label-for="selectSubContractor"
                        >
                            <div class="demo-inline-spacing">
                                <b-form-radio
                                    name="OutSideSelectBatch"
                                    value="1"
                                    v-model="formDataProcessOut.OutSideSelectBatch"
                                >
                                    Party Master
                                </b-form-radio>
                                <b-form-radio
                                    name="OutSideSelectBatch"
                                    value="2"
                                    v-model="formDataProcessOut.OutSideSelectBatch"
                                >
                                    Job Work Rate Master
                                </b-form-radio>
<!--                                   v-on:change="onChange($event)"-->
                            </div>
                        </b-form-group>
                    </b-col>
                    <br>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                     <validation-provider
                                        #default="validationContext"
                                        name="Sub-Contractor Code"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Sub-Contractor Code"
                                            label-for="subContractorCode"
                                        >
                                            <v-select
                                                placeholder="Select No"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="subContractorOption"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="subContractorCode"
                                                v-model="formDataProcessOut.OutSideSubContractorCode"
                                                @input="getSubContrctorDetails($event)"
                                                :state="getValidationState(validationContext)"
                                            />
                                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                                {{validationContext.errors[0]}}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Sub-Contractor Name"
                                        label-for="subContractorName"
                                    >
                                        <b-form-input
                                            id="subContractorName"
                                            v-model="formDataProcessOut.OutSideSubContractorName"
                                            readonly
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Date"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Date"
                                            label-for="operatorDate"
                                        >
                                            <b-input-group>
                                                <cleave
                                                    id="operatorDate"
                                                    v-model="formDataProcessOut.OutSideOperatorDate"
                                                    class="form-control"
                                                    :raw="false"
                                                    :options="dateFormat"
                                                    placeholder="DD/MM/YYYY"
                                                    show-decade-nav
                                                />
                                                <b-input-group-append>
                                                    <b-form-datepicker
                                                        v-model="formatDates.OutSideOperatorDate"
                                                        button-only
                                                        @input="getOperatorFormateDate($event)"
                                                        show-decade-nav
                                                        size="sm"
                                                        nav-button-variant="primary"
                                                    />
                                                </b-input-group-append>
                                            </b-input-group>
                                            <b-form-invalid-feedback>
                                                {{ validationContext.errors[0] }}
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Challan No"
                                        label-for="challanNo"
                                    >
                                        <b-form-input
                                            v-model="formDataProcessOut.outSideChallanNo"
                                            id="challanNo"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Issue Quntity"
                                        label-for="issueQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcessOut.outSideIssueQty"
                                            id="outSideIssueQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Total Availabel Qty"
                                        label-for="totalAvlQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcessOut.outSideTotalAvlQty"
                                            id="outSideTotalAvlQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>

                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Accept Quntity"
                                        label-for="acceptQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcessOut.outSideAcceptQty"
                                            id="outSideAcceptQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Reject Qty"
                                        label-for="rejectQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcessOut.outSideRejectQty"
                                            id="outSideRejectQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Process Cost"
                                        label-for="processCost"
                                    >
                                        <b-form-input
                                            v-model="formDataProcessOut.outSideProcessCost"
                                            id="outSideProcessCost"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="R/W Qty"
                                        label-for="rwQty"
                                    >
                                        <b-form-input
                                            v-model="formDataProcessOut.outSideRwQty"
                                            id="outSideRwQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Remark"
                                label-for="processRemark"
                            >
                                <b-form-textarea
                                    v-model="formDataProcessOut.outSideRemark"
                                    id="outSideRemark"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="12">
                            <hr>
                            <h5>Report</h5>
                            <hr>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="3">
                            <b-form-checkbox>
                                Origibnal for Recipient
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="3">
                            <b-form-checkbox>
                                Duplicate For Transpoter
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="3">
                            <b-form-checkbox>
                                Triplicate For Supplier
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="3"></b-col>
                    </b-row>
                    <br>
                    <b-row>
                        <b-col md="2">
                            <b-form-checkbox>
                                Formate2
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="2">
                            <b-form-checkbox>
                                With Conv
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="4">
                            <b-form-checkbox>
                                Report With Only Issue Items
                            </b-form-checkbox>
                        </b-col>
                        <b-col md="4">
                            <b-form-checkbox>
                                Print First Process Issue Items
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                    <br>
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Page"
                                label-for="page"
                            >
                                <v-select
                                    placeholder="Select Page"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="pageOption"
                                    :reduce="val => val.value"
                                    :clearable="false"
                                    input-id="page"
                                />
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col class="d-flex mt-1">
                            <b-form-checkbox
                            >
                                Header Image
                            </b-form-checkbox>
                            <b-form-checkbox
                                class="ml-2"
                            >
                                Footer Image
                            </b-form-checkbox>
                        </b-col>
                    </b-row>
                    <br>
                    <b-row>
                        <b-col md="3"></b-col>
                        <b-col md="3">
                            <b-button
                                class="float-right"
                                variant="primary"
                            >
                                Generate Challan
                            </b-button>
                        </b-col>
                        <b-col md="3">
                            <b-button
                                class="float-right"
                                variant="primary"
                            >
                                Preview Challan
                            </b-button>
                        </b-col>
                        <b-col md="3">
                            <b-button
                                class="float-right"
                                variant="primary"
                            >
                                Preview Issue Slip
                            </b-button>
                        </b-col>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-modal>
        <!--Wo Modal-->
        <b-modal
            id="showIssueItemModal"
            title="Select Item"
            size="xl"
            no-close-on-backdrop
            ref="showIssueItemModal"
            scrollable
            cancel-variant="danger"
            @ok="saveIssueItemFormData"
        >
            <b-row>
                <b-col md="12">
                    <hr>
                    <b-table
                        responsive
                        :fields="modalsTables.issueItemFields"
                        :items="modalsTables.issueItemData"
                        :bordered="true"
                        :hover="true"
                        show-empty
                        class="table_scroll"
                    >
                        <!-- Loader -->
                        <template #table-busy>
                            <div class="text-center my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>
                        <!-- A virtual column -->
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                        <!-- A custom formatted column -->
                        <template #cell(action)="data">
                            <b-dropdown
                                variant="link"
                                toggle-class="text-decoration-none"
                                no-caret
                            >
                                <template v-slot:button-content>
                                    <feather-icon
                                        icon="MoreVerticalIcon"
                                        size="16"
                                        class="text-body align-middle mr-25"
                                    />
                                </template>
                                <b-dropdown-item @click="editIssueItemData(data.item)">
                                    <feather-icon
                                        icon="Edit2Icon"
                                        class="mr-50"
                                    />
                                    <span>Edit</span>
                                </b-dropdown-item>
                                <b-dropdown-item @click="deleteIssueItemData(data.item._id)">
                                    <feather-icon
                                        icon="TrashIcon"
                                        class="mr-50"
                                    />
                                    <span>Delete</span>
                                </b-dropdown-item>
                            </b-dropdown>
                        </template>
                    </b-table>
                </b-col>
            </b-row>
            <hr>
            <validation-observer>
                <b-form>
                    <b-row>
                        <b-col md="6">
                            <b-row>
                                <b-col md="6">
                                    <validation-provider
                                        #default="validationContext"
                                        name="Item Code"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Item Code"
                                            label-for="itemCode"
                                        >
                                            <v-select
                                                v-model="formDataIssue.issueItemCode"
                                                placeholder="Select Status"
                                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                                :options="itemCodeOptions"
                                                :reduce="val => val.value"
                                                :clearable="false"
                                                input-id="itemCode"
                                                @input="getItemDetails($event)"
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
                                        name="Item Description"
                                        rules="required"
                                    >
                                        <b-form-group
                                            label="Item Description"
                                            label-for="itemDescription"
                                            :state="getValidationState(validationContext)"
                                        >
                                            <b-form-input
                                                v-model="formDataIssue.issueItemDescription"
                                                id="itemDescription"
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
                                    <b-form-group
                                        label="Add Description"
                                        label-for="addDescription"
                                    >
                                        <b-form-textarea
                                            id="addDescription"
                                            rows="2"
                                            v-model="formDataIssue.issueItemAddDescription"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Detail Description"
                                        label-for="detailDescription"
                                    >
                                        <b-form-textarea
                                            id="detailDescription"
                                            readonly
                                            rows="2"
                                            v-model="formDataIssue.issueItemDetailDescription"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Drawing No."
                                        label-for="itemDrawingNo"
                                    >
                                        <b-form-input
                                            id="itemDrawingNo"
                                            readonly
                                            v-model="formDataIssue.issueItemDrawingNo"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Drawing Revision"
                                        label-for="itemRevision"
                                    >
                                        <b-form-input
                                            id="itemRevision"
                                            readonly
                                            v-model="formDataIssue.issueItemRevision"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Required Quntity"
                                        label-for="requiredQty"
                                    >
                                        <b-form-input
                                            v-model="formDataIssue.issueRequiredQty"
                                            id="requiredQty"
                                            type="number"
                                            @keyup="calculateAmount"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Required Qty(Conv)"
                                        label-for="requiredQtyConv"
                                    >
                                        <b-form-input
                                            v-model="formDataIssue.issueRequiredQtyConv"
                                            id="requiredQtyConv"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>

                        <b-col md="6">
                            <b-form-group
                                label="Issue Qty"
                                label-for="issueQty"
                            >
                                <b-form-input
                                    v-model="formDataIssue.issueItemQty"
                                    id="issueQty"
                                    type="number"
                                />
                            </b-form-group>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="UOM"
                                        label-for="uom"
                                    >
                                        <v-select
                                            v-model="formDataIssue.issueItemUom"
                                            placeholder="Select uom"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="uomOption"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="uom"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Conv UOM"
                                        label-for="convUom"
                                    >
                                        <v-select
                                            v-model="formDataIssue.issueItemConvUom"
                                            placeholder="Select uom"
                                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                            :options="convUomOPtion"
                                            :reduce="val => val.value"
                                            :clearable="false"
                                            input-id="convUom"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Conv.Factor"
                                        label-for="convFactor"
                                    >
                                        <b-form-input
                                            v-model="formDataIssue.issueItemConvFactor"
                                            id="itemConvFactor"
                                            @keyup="calculateAmount"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Conv. Qty"
                                        label-for="convQty"
                                    >
                                        <b-form-input
                                            v-model="formDataIssue.issueItemConvQty"
                                            id="itemConvQty"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6">
                                    <b-form-group
                                        label="Current Stock"
                                        label-for="currentStock"
                                    >
                                        <b-form-input
                                            v-model="formDataIssue.issueCurrentStock"
                                            id="currentStock"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Stock At Sub-Contractor"
                                        label-for="stockSunContractor"
                                    >
                                        <b-form-input
                                            v-model="formDataIssue.issueStockSubContractor"
                                            id="stockSubContractor"
                                            type="number"
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                label="Remark"
                                label-for="processRemark"
                            >
                                <b-form-textarea
                                    v-model="formDataIssue.issueItemremark"
                                    id="itemremark"
                                />
                            </b-form-group>
                        </b-col>
                        <hr>
                    </b-row>
                </b-form>
            </validation-observer>
        </b-modal>
    </div>
</template>

<script>
    import {
        BCol,
        BRow,
        BForm,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BButton,
        BFormDatepicker,
        BTable,
        BSpinner,
        BDropdown,
        BDropdownItem,
        BFormInvalidFeedback,
        BFormRadio,
        BFormCheckbox,
        BInputGroup,
        BInputGroupAppend
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import jobCardStoreModule from "../../jobCardStoreModule";
    import {onUnmounted, ref, computed} from "@vue/composition-api";
    import store from '@/store'
    import axios from '@axios'
    import {useToast} from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import router from '@/router'
    import Ripple from "vue-ripple-directive";
    import Swal from "sweetalert2";
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {required} from '@validations'
    // import {forMatIndianDate} from '@core/utils/utils'
    import {getTcTodayDate, forMatIndianDate} from "@core/utils/utils";
    import Cleave from 'vue-cleave-component'

    export default {
        components: {
            BCol,
            BRow,
            BForm,
            BFormGroup,
            BFormInput,
            BFormTextarea,
            BButton,
            BFormDatepicker,
            BTable,
            BSpinner,
            BDropdown,
            BDropdownItem,
            BFormInvalidFeedback,
            vSelect,
            ValidationProvider,
            ValidationObserver,
            BFormRadio,
            BFormCheckbox,
            BInputGroup,
            BInputGroupAppend,
            Cleave
        },
        directives: {
            Ripple,
        },
        props: {
            jobCardBomNumber: {
                type: String,
            },
        },
        setup(props, {processInSideModal, processOutsideModal, showIssueItemModal}) {
            processInSideModal = ref()
            processOutsideModal = ref()
            showIssueItemModal = ref()
            //toast alert
            const toast = useToast()
            // const selectBatch = ref('work')
            const jobDataBomNumber = computed(() => props.jobCardBomNumber)

            const SE_APP_STORE_MODULE_NAME = 'job-card-process-detail'
            if (!store.hasModule(SE_APP_STORE_MODULE_NAME)) store.registerModule(SE_APP_STORE_MODULE_NAME, jobCardStoreModule)
            onUnmounted(() => {
                if (store.hasModule(SE_APP_STORE_MODULE_NAME)) store.unregisterModule(SE_APP_STORE_MODULE_NAME)
            })


            const selectBatch = ref('work')

            //create table loader
            const isBusy = ref(false)
            const pageOption = ref([
                {label: 'Blank Page', value: 1},
                {label: 'Latter Pad', value: 2}
            ])
            const uomOption = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                uomOption.value = res.data.data
            })
            const convUomOPtion = ref([])
            axios.get('/api/get-uom-master-options').then(res => {
                convUomOPtion.value = res.data.data
            })
            const itemCodeOptions = ref([])
            axios.get('/api/get-item-master-options').then(res => {
                itemCodeOptions.value = res.data.data
            })
            const machineOptions = ref([])
            axios.get('/api/new/get-machine-master-option').then(res => {
                machineOptions.value = res.data.data
            })

            const dateFormat = ref({
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y'],
            })

            const formatDates = ref({
                OutSideOperatorDate: null,
                InSideOperatorDate: null,
            })

            const getOperatorFormateDate = (date) => {
                formDataProcessOut.value.OutSideOperatorDate = forMatIndianDate(date)
            }
            //            const formDataProcess = ref({

            const getInSideOperatorFormateDate = (date) => {
                formDataProcess.value.InSideOperatorDate = forMatIndianDate(date)
            }

            //process sheet list
            const processDesOption = ref([])
            axios.get('/api/new/get-process-sheet-list-process-option').then(res => {
                // console.log(res.data.data)
                processDesOption.value = res.data.data
            })

            const getProcssSheetDetail = async (id) => {
                await axios.get(`/api/process-sheet-list/${id}`).then(res => {
                    formData.value.machineNumber = res.data.data.machineNo
                    formData.value.processDescription = res.data.data.processDesc
                    formData.value.inspInstruction = res.data.data.inspectionInst
                    formData.value.inspectionBy = res.data.data.inspectionBy
                    formData.value.inspectionLevel = res.data.data.inspectionLevel
                    formData.value.specialTool = res.data.data.specialTool
                    formData.value.wtLoss = res.data.data.wtLossPer
                    formData.value.matWt = res.data.data.matWt
                    formData.value.scrapTolerance = res.data.data.scrapTolerancePer
                    formData.value.processId = res.data.data.processId
                    formData.value.processItemId = res.data.data.processItemId
                    formData.value.processSheetId = res.data.data.processSheetId

                })
            }
            const processDesOptions = ref([])
            axios.get('/api/new/get-operator-master-option').then(res => {
                // console.log(res.data.data)
                processDesOptions.value = res.data.data
            })
            const getSubContrctorDetails = async (id) => {
                await axios.get(`/api/party/edit/${id}`).then(res => {
                    formDataProcessOut.value.OutSideSubContractorName = res.data.data?.partyName ?? null
                })
            }
            const getItemDetails = async (id) => {
                await axios.get(`/api/item-master/${id}`).then(res => {
                    formDataIssue.value.issueItemUom = res.data.data?.uom_details?.uom ?? null
                    formDataIssue.value.issueItemDescription = res.data.data?.itemDescription
                    formDataIssue.value.issueItemConvUom = res.data.data?.convUom
                    formDataIssue.value.issueItemAddDescription = res.data.data?.itemDetails?.description ?? null
                    formDataIssue.value.issueItemDetailDescription = res.data.data?.itemDetails?.detailDescription ?? null
                    formDataIssue.value.issueItemDrawingNo = res.data.data?.itemDetails?.drawingNumber ?? null
                    formDataIssue.value.issueItemRevision = res.data.data?.itemDetails?.revision ?? null
                    formDataIssue.value.issueItemConvQty = res.data.data?.convQty
                    formDataIssue.value.issueItemConvFactor = res.data.data?.cFactor
                    formDataIssue.value.issueItemremark = res.data.data?.itemDetails?.remarkNote ?? null
                })
            }
            //table Process OutSide
            const modalTables = ref({
                processOutSideFields: [
                    {
                        key: 'index',
                        label: 'No'
                    },
                    {
                        key: 'OutSideSubContractorName',
                        label: 'Sub-Contractor Name'
                    },
                    {
                        key: 'OutSideOperatorDate',
                        label: 'Date'
                    },
                    {
                        key: 'outSideIssueQty',
                        label: 'Issue Qty'
                    },
                    {
                        key: 'outSideAcceptQty',
                        label: 'Accept Qty'
                    },
                    {
                        key: 'outSideRejectQty',
                        label: 'Reject Qty'
                    },
                    {
                        key: 'outSideRwQty',
                        label: 'RW Qty'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    },
                ],
                processOutSideData: [],
            })
            //table Show Issue Item
            const modalsTables = ref({
                issueItemFields: [
                    {
                        key: 'index',
                        label: 'No'
                    },
                    {
                        key: 'item_name.itemCode',
                        label: 'Item Code'
                    },
                    {
                        key: 'issueItemDescription',
                        label: 'Item Description'
                    },
                    {
                        key: 'issueItemUom',
                        label: 'UOM'
                    },
                    {
                        key: 'issueRequiredQty',
                        label: 'Quntity'
                    },
                    {
                        key: 'issueItemQty',
                        label: 'Issue Qty'
                    },
                    {
                        key: 'pendingQty',
                        label: 'Pending Qty'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    },
                ],
                issueItemData: [],
            })
            //table Process Details
            const table = ref({
                fields: [
                    {
                        key: 'rowSelected',
                        label: ''
                    },
                    {
                        key: 'index',
                        label: 'No'
                    },
                    // {
                    //     key: 'ProcessDate',
                    //     label: 'DT & Shift',
                    // },
                    {
                        key: 'processDescription',
                        label: 'Process Description'
                    },
                    {
                        key: 'machineNumber',
                        label: 'Machine Number'
                    },
                    {
                        key: 'operator',
                        label: 'Operator'
                    },
                    {
                        key: 'inspInstruction',
                        label: 'Insp. Instruction'
                    },
                    {
                        key: 'quantity',
                        label: 'Quantity '
                    },
                    {
                        key: 'rejectedQty',
                        label: 'Reject Qty '
                    },
                    {
                        key: 'acceptedQty',
                        label: 'Accept Qty'
                    },
                    {
                        key: 'noOfHr',
                        label: 'Hrs.'
                    },
                    {
                        key: 'pendingQty.',
                        label: 'Pending Qty.'
                    },
                    {
                        key: 'rwQty',
                        label: 'RW Qty.'
                    },
                    {
                        key: 'action',
                        label: 'Action'
                    },
                ],
                data: [],
            })

            const subContractorOption = ref([])
            axios.get('/api/party/get-master-options').then(res => {
                subContractorOption.value = res.data.data
            })




            // const OutSideSelectBatch = ref ('')
            //
            // const onChange = async () => {
            //     if(formDataProcessOut.value.OutSideSelectBatch === 2){
            //         axios.get('/api/new/get-operator-master-option').then(res => {
            //             subContractorOption.value = res.data.data
            //         })
            //     }else{
            //         axios.get('/api/party/get-master-options').then(res => {
            //             subContractorOption.value = res.data.data
            //         })
            //     }
            // }


            //Button Hide and Show
            const isButtonShow = ref(true)
            const isProcessButtonShow = ref(false)

            //Form Process Details
            const blankFormData = {
                processId:null,
                processItemId:null,
                processSheetId:null,
                bomId: null,
                _id: null,
                jobId: router.currentRoute.params.id,
                machineNumber: null,
                process: null,
                processDescription: null,
                operator: null,
                quantity: null,
                pendingQty: null,
                acceptedQty: null,
                rejectedQty: null,
                rwQty: null,
                inspInstruction: null,
                inspectionBy: null,
                inspectionLevel: null,
                specialTool: null,
                wtLoss: null,
                matWt: null,
                scrapTolerance: null,
                noOfHr: null,
                remark: null,
            }
            //Form Process OutSide
            const formDataProcessOut = ref({
                processId: null,
                _id: null,
                jobId: router.currentRoute.params.id,
                OutSideSelectBatch: 1,
                OutSideSubContractorCode: null,
                OutSideSubContractorName: null,
                OutSideOperatorDate: forMatIndianDate(getTcTodayDate()),
                outSideChallanNo: null,
                outSideIssueQty: null,
                outSideTotalAvlQty: null,
                outSideAcceptQty: null,
                outSideRejectQty: null,
                outSideProcessCost: null,
                outSideRwQty: null,
                outSideRemark: null,
            })
            //Form Process Inside
            const formDataProcess = ref({
                processId: null,
                jobId: router.currentRoute.params.id,
                InSideOperatorName: null,
                selectBatch: 1,
                InSideOperatorDate: forMatIndianDate(getTcTodayDate()),
                InSideTotalAvlQty: null,
                InSideIssueQty: null,
                inSideAcceptQty: null,
                inSideRejectQty: null,
                inSideNoOfHr: null,
                inSideRwQty: null,
                inSideProcessCost: null,
                inSideRemark: null,
                InSideMachineNo: null,
                standardSetTime: null,
                standardTotalSetTime: null,
                actualSetTime: null,
                differenceSetTime: null,
                standardProcessTime: null,
                standardTotalProcessTime: null,
                actualProcessTime: null,
                differenceProcessTime: null,
                standardTotalTime: null,
                standardTotalTolTime: null,
                actualTotalTime: null,
                differenceTotalTime: null,
                standardProcess: null,
                accessQty: null,
            })
            //Form Show Issue Item
            const formDataIssue = ref({
                processId: null,
                _id: null,
                jobId: router.currentRoute.params.id,
                issueItemCode: null,
                issueItemDescription: null,
                issueItemAddDescription: null,
                issueItemDetailDescription: null,
                issueItemDrawingNo: null,
                issueItemRevision: null,
                issueRequiredQty: null,
                issueRequiredQtyConv: null,
                issueItemQty: null,
                issueItemUom: null,
                issueItemConvUom: null,
                issueItemConvFactor: null,
                issueItemConvQty: null,
                issueCurrentStock: null,
                issueStockSubContractor: null,
                issueItemremark: null,
            })

            const formData = ref(JSON.parse(JSON.stringify(blankFormData)))

            const resetFormData = () => {
                formData.value = JSON.parse(JSON.stringify(blankFormData))
                formDataIssue.value = JSON.parse(JSON.stringify(formDataIssue.value))
                formDataProcess.value = JSON.parse(JSON.stringify(formDataProcess.value))
                formDataProcessOut.value = JSON.parse(JSON.stringify(formDataProcessOut.value))
            }
            const calculateAmount = () => {
                formDataIssue.value.issueRequiredQtyConv = formDataIssue.value.issueRequiredQty * formDataIssue.value.issueItemConvFactor
                formDataIssue.value.issueItemQty = formDataIssue.value.issueRequiredQty
            }

            const calculateTimeAmount = () => {
                formDataProcess.value.standardTotalSetTime = formDataProcess.value.standardSetTime
                formDataProcess.value.differenceSetTime = formDataProcess.value.actualSetTime - formDataProcess.value.standardSetTime
                formDataProcess.value.standardProcessTime = formDataProcess.value.standardSetTime
                formDataProcess.value.standardTotalProcessTime = formDataProcess.value.standardProcessTime
                formDataProcess.value.differenceProcessTime = formDataProcess.value.actualProcessTime - formDataProcess.value.standardTotalProcessTime
                formDataProcess.value.standardTotalTime = parseFloat(formDataProcess.value.standardSetTime) + parseFloat(formDataProcess.value.standardProcessTime)
                formDataProcess.value.standardTotalTolTime = parseFloat(formDataProcess.value.standardTotalSetTime) + parseFloat(formDataProcess.value.standardTotalProcessTime)
                formDataProcess.value.actualTotalTime = parseFloat(formDataProcess.value.actualSetTime) + parseFloat(formDataProcess.value.actualProcessTime)
                formDataProcess.value.differenceTotalTime = parseFloat(formDataProcess.value.differenceSetTime) + parseFloat(formDataProcess.value.differenceProcessTime)
                // formDataProcess.value.standardProcess = parseFloat(formDataProcess.value.standardSetTime / 60).toFixed(2) * parseFloat(formDataProcess.value.actualTotalTime).toFixed(2)
                // formDataProcess.value.inSideProcessCost = parseFloat(formDataProcess.value.standardProcess).toFixed(2)
                formDataProcess.value.inSideProcessCost = parseFloat((formDataProcess.value.actualSetTime / formDataProcess.value.InSideIssueQty) + (formDataProcess.value.actualProcessTime))
                // formDataProcess.value.inSideProcessCost = formDataProcess.value.inSideProcessCost + formDataProcess.value.actualProcessTime
            }
            //Edit Process Details
            // const editProcessData = (data) => {
            //     formData.value = data
            //     isButtonShow.value = true
            //     isProcessButtonShow.value = false
            // }
            //Edit Show issue item
            const editIssueItemData = (data) => {
                formDataIssue.value = data
            }
            //Edit process OutSide
            const editProcessOutData = (data) => {
                formDataProcessOut.value = data
            }
            //Select process Details
            const selectProcessItem = (id) => {
                formDataIssue.value.processId = id
                formDataProcessOut.value.processId = id
                formDataProcess.value.processId = id
                isButtonShow.value = false
                isProcessButtonShow.value = true
            }

                const onRowSelect = (items) => {
                if(items.length > 0){
                    formData.value._id = items[0]._id
                    formData.value.process = items[0].process ?? null
                    formData.value.machineNumber = items[0].machineNumber ?? null
                    formData.value.processDescription = items[0].processDescription ?? null
                    formData.value.operator = items[0].operator ?? null
                    formData.value.quantity = items[0].quantity ?? null
                    formData.value.pendingQty = items[0].pendingQty ?? null
                    formData.value.acceptedQty = items[0].acceptedQty ?? null
                    formData.value.rejectedQty = items[0].rejectedQty ?? null
                    formData.value.rwQty = items[0].rwQty ?? null
                    formData.value.inspInstruction = items[0].inspInstruction ?? null
                    formData.value.inspectionBy = items[0].inspectionBy ?? null
                    formData.value.inspectionLevel = items[0].inspectionLevel ?? null
                    formData.value.specialTool = items[0].specialTool ?? null
                    formData.value.wtLoss = items[0].wtLoss ?? null
                    formData.value.matWt = items[0].matWt ?? null
                    formData.value.scrapTolerance = items[0].scrapTolerance ?? null
                    formData.value.noOfHr = items[0].noOfHr ?? null
                    formData.value.remark = items[0].remark ?? null
                }else{
                    resetFormData()
                }
            }
            //Fatch Process OutSid
            const refetchDataProcessOut = async () => {
                isBusy.value = true
                await axios.get(`/api/new/job-card-process-outside`).then(res => {
                    // console.log(res.data.data)
                    modalTables.value.processOutSideData = res.data.data
                })
                isBusy.value = false
            }

            //Fatch Show ISsue Item
            const refetchDataShow = async () => {
                isBusy.value = true
                await axios.post(`/api/new/get-issue-items-process`, {
                    jobCardId: router.currentRoute.params.id,
                    processId: formDataIssue.value.processId,
                }).then(res => {
                    modalsTables.value.issueItemData = res.data.data
                })
                isBusy.value = false
            }

            //Fatch Process Details
            const refetchData = async () => {
                isBusy.value = true
                await axios.get('/api/get-job-cards-process-details-list/'.concat(router.currentRoute.params.id)).then(res => {
                    // console.log(res.data.data)
                    table.value.data = res.data.data
                })
                isBusy.value = false
            }
            refetchData()

            const openModal = () => {
                processInSideModal.value.show();
            }
            const openModalProcessOut = async () => {
                await refetchDataProcessOut()
                processOutsideModal.value.show();
            }
            const openModalIssueItem = async () => {
                await refetchDataShow()
                showIssueItemModal.value.show();
            }
            const calculateProcessAmount = () => {
                formData.value.pendingQty = formData.value.quantity
            }

            //Save Process OutSide
            const saveProcessOutSideData = async () => {
                if (formDataProcessOut.value._id === null) {
                    await store.dispatch('job-card-process-detail/addJobCardProcessOutSide', formDataProcessOut.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Process Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Job Card Process OutSide',
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
                } else {
                    await store.dispatch('job-card-process-detail/updateJobCardProcessOutSide', formDataProcessOut.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Process OutSide Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Job Card Process OutSide.`,
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
                }
                resetFormData()
                await refetchDataProcessOut()
            }
            //Save Process InSide
            const saveProcessInSideSideData = async () => {
                await store.dispatch('job-card-process-detail/addJobCardProcessInSide', formDataProcess.value).then(res => {
                    if (res.status === 200) {
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: 'Job Card Proces Inside Added',
                                icon: 'CheckSquareIcon',
                                variant: 'success',
                                text: 'You have successfully Added Job Card Proces Inside',
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
                    resetFormData()
                })
            }
            //Save show Issue Item
            const saveIssueItemFormData = async () => {
                if (formDataIssue.value._id === null) {
                    await store.dispatch('job-card-process-detail/addShowIssueItems', formDataIssue.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Proces Issue Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: 'You have successfully Added Job Card Proces Issue Item',
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
                } else {
                    await store.dispatch('job-card-process-detail/updateShowIssueItems', formDataIssue.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Proces Issue Item Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Update Job Card Proces Issue Item.`,
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
                }
                resetFormData()
                await refetchDataShow()
            }

            //Save Process Details
            const saveFormData = async () => {
                formData.value.bomId = jobDataBomNumber.value;
                if (formData.value._id === null) {
                    await store.dispatch('job-card-process-detail/addJobCardProcessDetails', formData.value).then(res => {
                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Process Added',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Added Job Card Process.`,
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
                } else {
                    await store.dispatch('job-card-process-detail/updateProcessDetails', formData.value).then(res => {

                        if (res.status === 200) {
                            toast({
                                component: ToastificationContent,
                                position: 'top-right',
                                props: {
                                    title: 'Job Card Process Details Updated',
                                    icon: 'CheckSquareIcon',
                                    variant: 'success',
                                    text: `You have successfully Updated Job Card Process Details.`,
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
                }
                resetFormData()
                await refetchData()
            }

            //delete Process Details
            const deleteProcessData = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Card Process",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, keep it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch('job-card-process-detail/deleteProcessDetails', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Card Process Detail Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Job Card Process Detail.`,
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
                        resetFormData()
                        refetchData()
                    }
                })
            }
            //delete Show Issue Item
            const deleteIssueItemData = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Card Process Issue Item",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, keep it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch('job-card-process-detail/deleteShowIssueItems', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Card Process Issue Item Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Job Card Process Issue Item.`,
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
                        resetFormData()
                        refetchDataShow()
                    }
                })
            }
            //delete Process OutSide
            const deleteProcessOutData = async (id) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete Job Card Process OutSide",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, keep it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        store.dispatch('job-card-process-detail/deleteJobCardProcessOutSide', {id: id}).then(res => {
                            if (res.status === 200) {
                                toast({
                                    component: ToastificationContent,
                                    position: 'top-right',
                                    props: {
                                        title: 'Job Card  Process OutSide Deleted',
                                        icon: 'CheckSquareIcon',
                                        variant: 'success',
                                        text: `You have successfully Deleted Job Card  Process OutSide.`,
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
                        resetFormData()
                        refetchDataProcessOut()
                    }
                })
            }
            const {refFormObserver, getValidationState, resetForm} = formValidation(resetFormData)

            return {
                isBusy,
                isButtonShow,
                isProcessButtonShow,
                jobDataBomNumber,
                table,
                refetchData,
                formData,
                saveFormData,
                deleteProcessData,
                deleteIssueItemData,
                resetFormData,
                processDesOption,
                required,
                refFormObserver,
                getValidationState,
                resetForm,
                openModal,
                processInSideModal,
                openModalProcessOut,
                modalTables,
                processOutsideModal,
                saveProcessInSideSideData,
                saveProcessOutSideData,
                pageOption,
                showIssueItemModal,
                openModalIssueItem,
                modalsTables,
                saveIssueItemFormData,
                uomOption,
                convUomOPtion,
                itemCodeOptions,
                getItemDetails,
                selectProcessItem,
                calculateAmount,
                formDataIssue,
                refetchDataShow,
                formDataProcess,
                editIssueItemData,
                subContractorOption,
                getSubContrctorDetails,
                formDataProcessOut,
                refetchDataProcessOut,
                editProcessOutData,
                deleteProcessOutData,
                machineOptions,
                selectBatch,
                processDesOptions,
                calculateTimeAmount,
                // checked
                getProcssSheetDetail,
                calculateProcessAmount,
                dateFormat,
                formatDates,
                getOperatorFormateDate,
                getInSideOperatorFormateDate,
                // onChange,
                // OutSideSelectBatch
                onRowSelect
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-sweetalert.scss';
</style>
