<?php

use App\Actions\ItemMaster\ItemMasterListFilterAction;
use App\Actions\MasterGst\GetChallanInvoiceItemAmountAction;
use App\Http\Controllers\Administration\CompanyController;
use App\Http\Controllers\Administration\PermissionController;
use App\Http\Controllers\Administration\RoleManagement;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Bom\BillOfMaterialController;
use App\Http\Controllers\Bom\BillOfMaterialVersionController;
use App\Http\Controllers\Bom\BomVersionItemController;
use App\Http\Controllers\Bom\BomVersionProcessController;
use App\Http\Controllers\Bom\DrawingDocumentsController;
use App\Http\Controllers\Bom\DrawingMasterController;
use App\Http\Controllers\Bom\DrawingRevisionController;
use App\Http\Controllers\Despatch\NewChallanInvoiceBillingTermController;
use App\Http\Controllers\Despatch\NewChallanInvoiceController;
use App\Http\Controllers\Despatch\NewChallanInvoiceItemController;
use App\Http\Controllers\Despatch\NewChallanInvoicePackingController;
use App\Http\Controllers\Despatch\NewChallanInvoiceShippingController;
use App\Http\Controllers\Despatch\NewChallanInvoiceTermConditionController;
use App\Http\Controllers\Finance\BudgetMasterController;
use App\Http\Controllers\Finance\ChartOfAccountsController;
use App\Http\Controllers\Finance\ChequePrintingFormatMasterController;
use App\Http\Controllers\Finance\CostCenterMasterController;
use App\Http\Controllers\Finance\GeneralLedgerAccountsController;
use App\Http\Controllers\Finance\NarrationMasterController;
use App\Http\Controllers\Finance\PaymentModeMasterController;
use App\Http\Controllers\Finance\TdsMasterController;
use App\Http\Controllers\GST\MasterGstController;
use App\Http\Controllers\Inventory\MaterialIssueController;
use App\Http\Controllers\invoice\InvoiceController;
use App\Http\Controllers\Item\ItemAddonDetailController;
use App\Http\Controllers\Item\ItemAddonTypeController;
use App\Http\Controllers\Item\ItemCategoryController;
use App\Http\Controllers\Item\ItemGroupMasterController;
use App\Http\Controllers\Item\ItemHsnSacMasterController;
use App\Http\Controllers\Item\ItemMainSubGroupController;
use App\Http\Controllers\Item\ItemSaleTargetGroupController;
use App\Http\Controllers\JobWork\IssueJobWorkChallanController;
use App\Http\Controllers\JobWork\IssueJobWorkChallanItemsController;
use App\Http\Controllers\JobWork\JobWorkOrderBillingTermController;
use App\Http\Controllers\JobWork\JobWorkOrderController;
use App\Http\Controllers\JobWork\JobWorkOrderItemsController;
use App\Http\Controllers\JobWork\JobWorkOrderTermConditionController;
use App\Http\Controllers\Master\BankController;
use App\Http\Controllers\Master\BillingMasterController;
use App\Http\Controllers\Master\BillingTemplateItemsMasterController;
use App\Http\Controllers\Master\BillingTemplateMasterController;
use App\Http\Controllers\Master\BranchMasterController;
use App\Http\Controllers\Master\BusinessTypeController;
use App\Http\Controllers\Master\CertificateTypesController;
use App\Http\Controllers\Master\CityMasterController;
use App\Http\Controllers\Master\CountryMasterController;
use App\Http\Controllers\Master\CurrencyController;
use App\Http\Controllers\Master\DefaultBillingTemplateController;
use App\Http\Controllers\Master\DefaultTermsConditionController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\DesignationController;
use App\Http\Controllers\Master\DocumentFooterController;
use App\Http\Controllers\Master\DocumentHeaderController;
use App\Http\Controllers\Master\DocumentTypeController;
use App\Http\Controllers\Master\DutyDrawbackMasterController;
use App\Http\Controllers\Master\EnquiryReferenceController;
use App\Http\Controllers\Master\ExpenseController;
use App\Http\Controllers\Master\IndustryTypeController;
use App\Http\Controllers\Master\InvoiceTypeController;
use App\Http\Controllers\Master\IsoApiDocMasterController;
use App\Http\Controllers\Master\ItemMakeController;
use App\Http\Controllers\Master\ItemMasterController;
use App\Http\Controllers\Master\LeadStageMasterController;
use App\Http\Controllers\Master\LeadTitleMasterController;
use App\Http\Controllers\Master\MachineController;
use App\Http\Controllers\Master\NoteController;
use App\Http\Controllers\Master\OperatorController;
use App\Http\Controllers\Master\PackingController;
use App\Http\Controllers\Master\PartyTypesController;
use App\Http\Controllers\Master\PaymentDeductionController;
use App\Http\Controllers\Master\ProcessController;
use App\Http\Controllers\Master\ProgressStageMasterController;
use App\Http\Controllers\Master\PurchaseTypeController;
use App\Http\Controllers\Master\QuotationTypeController;
use App\Http\Controllers\Master\ReasonController;
use App\Http\Controllers\Master\SalesOrderTypeController;
use App\Http\Controllers\Master\SerialMasterController;
use App\Http\Controllers\Master\StateMasterController;
use App\Http\Controllers\Master\StoreMasterController;
use App\Http\Controllers\Master\TaskMasterController;
use App\Http\Controllers\Master\TaxFormsMasterController;
use App\Http\Controllers\Master\TaxMasterController;
use App\Http\Controllers\Master\TermsConditionDetailsController;
use App\Http\Controllers\Master\TermsConditionGroupController;
use App\Http\Controllers\Master\TermsConditionTemplateController;
use App\Http\Controllers\Master\UnitMeasurment;
use App\Http\Controllers\Mrp\DeliveryScheduleController;
use App\Http\Controllers\Mrp\IndentApprovalController;
use App\Http\Controllers\Mrp\ManualPlanningController;
use App\Http\Controllers\Mrp\MinimumLevelShortageController;
use App\Http\Controllers\Mrp\PendingIndentController;
use App\Http\Controllers\Mrp\WoAllocationController;
use App\Http\Controllers\Mrp\WoAssemblyComponentController;
use App\Http\Controllers\Mrp\WoPurchaseItemController;
use App\Http\Controllers\Mrp\WoWiseAssemblyComponentController;
use App\Http\Controllers\Mrp\WoWisePurchaseItemController;
use App\Http\Controllers\Partymaster\BillingTermController;
use App\Http\Controllers\Partymaster\ContactPersonController;
use App\Http\Controllers\Partymaster\DeliveryAddressController;
use App\Http\Controllers\Partymaster\PartygroupController;
use App\Http\Controllers\Partymaster\PartyMasterController;
use App\Http\Controllers\Partymaster\TermAndConditionController;
use App\Http\Controllers\ProductionPlanning\JobCardProcessDetailsController;
use App\Http\Controllers\ProductionPlanning\JobCardReturnShopController;
use App\Http\Controllers\ProductionPlanning\JobCardReturnShopItemController;
use App\Http\Controllers\ProductionPlanning\JobCardsController;
use App\Http\Controllers\ProductionPlanning\ProcessSheetListController;
use App\Http\Controllers\ProductionPlanning\ProcessSheetMasterController;
use App\Http\Controllers\ProductionPlanning\WoRequisitionController;
use App\Http\Controllers\ProductionPlanning\WoRequisitionItemsController;
use App\Http\Controllers\ProductionPlanning\WorkOrderController;
use App\Http\Controllers\ProductionPlanning\WorkOrderItemAssemblyController;
use App\Http\Controllers\ProductionPlanning\WorkOrderItemController;
use App\Http\Controllers\ProductionPlanning\WorkOrderItemRoutingController;
use App\Http\Controllers\ProductionPlanning\WorkOrderNoteController;
use App\Http\Controllers\ProductionPlanning\WorkOrderRoutingController;
use App\Http\Controllers\Purchase\PurchaseCostingController;
use App\Http\Controllers\Purchase\PurchaseCostingItemsController;
use App\Http\Controllers\Purchase\PurchaseEnquiryController;
use App\Http\Controllers\Purchase\PurchaseEnquiryItemDetailController;
use App\Http\Controllers\Purchase\PurchaseEnquiryVendorDetailController;
use App\Http\Controllers\Purchase\PurchaseOrderBillingTermController;
use App\Http\Controllers\Purchase\PurchaseOrderController;
use App\Http\Controllers\Purchase\PurchaseOrderItemController;
use App\Http\Controllers\Purchase\PurchaseOrderTermConditionController;
use App\Http\Controllers\Purchase\PurchaseQuotationBillingController;
use App\Http\Controllers\Purchase\PurchaseQuotationController;
use App\Http\Controllers\Purchase\PurchaseQuotationItemsController;
use App\Http\Controllers\Purchase\PurchaseQuotationTermConditionController;
use App\Http\Controllers\SalesCrm\PiBillingTermsController;
use App\Http\Controllers\SalesCrm\PiTermConditionController;
use App\Http\Controllers\SalesCrm\ProformaInvoiceController;
use App\Http\Controllers\SalesCrm\ProformaInvoiceItemsController;
use App\Http\Controllers\SalesCrm\SalesDeliveryScheduleController;
use App\Http\Controllers\SalesCrm\SalesEnquiryController;
use App\Http\Controllers\SalesCrm\SalesHistoryController;
use App\Http\Controllers\SalesCrm\SalesItemDetailsController;
use App\Http\Controllers\SalesCrm\SalesOrderAgentController;
use App\Http\Controllers\SalesCrm\SalesOrderBillingTermsController;
use App\Http\Controllers\SalesCrm\SalesOrderChecklistController;
use App\Http\Controllers\SalesCrm\SalesOrderController;
use App\Http\Controllers\SalesCrm\SalesOrderHistoryController;
use App\Http\Controllers\SalesCrm\SalesOrderItemsController;
use App\Http\Controllers\SalesCrm\SalesOrderPaymentScheduleController;
use App\Http\Controllers\SalesCrm\SalesOrderStagesController;
use App\Http\Controllers\SalesCrm\SalesOrderTermConditionController;
use App\Http\Controllers\SalesCrm\SalesQuotationController;
use App\Http\Controllers\SalesCrm\SalesReturnController;
use App\Http\Controllers\SalesCrm\SalesReturnItemsController;
use App\Http\Controllers\SalesCrm\SrBillingTermsController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\UserManagementController;
use App\Models\JobWork\JobWorkOrderBillingTerm;
use App\Models\Master\ItemMaster;
use App\Models\ProductionPlanning\ProcessSheetMaster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    $id = $request->user()->id;
    DB::enableQueryLog();
    $user = User::with(['permissions' => fn ($q) => [
        $q->where('model_id', $id)
    ]])->find($id);
    dd([
        $user,
        DB::getQueryLog()
    ]);
})->middleware('auth:sanctum');

Route::post('/jwt/login', [AuthenticationController::class, 'login']);
Route::get('administration/get-company-list-options', [CompanyController::class, 'getCompanyOptions']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/jwt/logout', [AuthenticationController::class, 'logout']);

    //Invoice Routes
    Route::group(['prefix' => 'invoice'], function () {
        Route::get('get', [InvoiceController::class, 'show']);
        Route::POST('store', [InvoiceController::class, 'store']);
        Route::get('edit/{id}', [InvoiceController::class, 'edit']);
        Route::POST('update', [InvoiceController::class, 'update']);
        Route::get('destroy/{id}', [InvoiceController::class, 'destroy']);
    });

    /*
     |--------------------------------------------------------------------------|
     | Party Master Routes START
     |--------------------------------------------------------------------------|
    */
    Route::group(['prefix' => 'party'], function () {
        Route::get('get', [PartyMasterController::class, 'show']);
        Route::POST('store', [PartyMasterController::class, 'store']);
        Route::get('edit/{id}', [PartyMasterController::class, 'edit']);
        Route::POST('update', [PartyMasterController::class, 'update']);
        Route::get('destroy/{id}', [PartyMasterController::class, 'destroy']);
        Route::get('check-name/{name}', [PartyMasterController::class, 'checkPartyNameExist']);
        Route::get('check-name-with-id/{id}/{name}', [PartyMasterController::class, 'checkPartyNameExistWithId']);
        Route::resource('contact-person', ContactPersonController::class);
        Route::get('/get-party-contacts/{id}', [ContactPersonController::class, 'getDataPartyWise']);
        Route::get('/get-party-contacts-options/{id}', [ContactPersonController::class, 'getPartyWiseContactOptions']);
        Route::get('/get-all-party-contacts-options', [ContactPersonController::class, 'getAllContactOptions']);
        Route::resource('term-condition', TermAndConditionController::class);
        Route::get('/get-party-term-condition/{id}', [TermAndConditionController::class, 'getDataPartyWise']);
        Route::resource('/billing-term', BillingTermController::class);
        Route::get('/get-party-billing-term/{id}', [BillingTermController::class, 'getPartyWiseBillingTerm']);
        Route::resource('/delivery-address', DeliveryAddressController::class);
        Route::get('/get-party-delivery-address/{id}', [DeliveryAddressController::class, 'getPartyWiseDeliveryAddress']);
        Route::get('/get-master-options', [PartyMasterController::class, 'getPartyMasterOptions']);
        Route::get('/get-master-customer-options', [PartyMasterController::class, 'getPartyMasterOnlyCustomerOptions']);
        Route::get('/get-master-without-customer-options', [PartyMasterController::class, 'getPartyMasterWithoutCustomerOptions']);
        Route::get('/get-master-vendor-options', [PartyMasterController::class, 'getPartyMasterOnlyVendorOptions']);
        Route::get('/get-master-transporter-options', [PartyMasterController::class, 'getPartyMasterOnlyTransPorterOptions']);
    });
    /*
     |--------------------------------------------------------------------------|
     | Party Master Routes END
     |--------------------------------------------------------------------------|
    */

    Route::resource('party-group', PartygroupController::class);
    Route::get('get-party-group-options', [PartygroupController::class, 'getAllPartyGroup']);
    Route::resource('item-master', ItemMasterController::class);
    Route::post('get-item-group-code', [ItemMasterController::class, 'getGroupCodeCount']);
    Route::post('item-name-exist', [ItemMasterController::class, 'checkItemNameExist']);
    Route::post('item-name-exist-with-id', [ItemMasterController::class, 'checkItemNameExistWithId']);
    Route::get('get-item-master-options', [ItemMasterController::class, 'getItemOptions']);
    Route::post('get-item-master-with-filter', [ItemMasterController::class, 'getItemMasterWithFilter']);
    Route::post('copy-item-master-data', [ItemMasterController::class, 'copyItemMasterItem']);
    Route::post('item-master-list-filter', ItemMasterListFilterAction::class);
    Route::resource('item-make-master', ItemMakeController::class);
    Route::post('item-make-master-exist', [ItemMakeController::class, 'checkItemMakeExist']);
    Route::get('get-item-make-master-options', [ItemMakeController::class, 'getItemMakeOptions']);
    Route::resource('uom-master', UnitMeasurment::class);
    Route::post('uom-master-exist', [UnitMeasurment::class, 'checkUomExist']);
    Route::get('get-uom-master-options', [UnitMeasurment::class, 'getUomOptions']);
    Route::resource('party-type-master', PartyTypesController::class);
    Route::post('party-type-master-exist', [PartyTypesController::class, 'checkPartyTypesExist']);
    Route::get('get-party-type-options', [PartyTypesController::class, 'getPartyTypeOptions']);
    Route::resource('certificate-type-master', CertificateTypesController::class);
    Route::post('certificate-type-master-exist', [CertificateTypesController::class, 'checkCertificateTypesExist']);
    Route::resource('business-type-master', BusinessTypeController::class);
    Route::get('get-party-business-type-options', [BusinessTypeController::class, 'getPartyBusinessTypeOptions']);
    Route::post('business-type-master-exist', [BusinessTypeController::class, 'checkBusinessTypeExist']);
    Route::resource('department-master', DepartmentController::class);
    Route::get('get-department-options', [DepartmentController::class, 'getDepartment']);
    Route::apiresource('designation-master', DesignationController::class);
    Route::get('get-designation-master-by-name/{name}', function (Request $request) {
        return getDesignationMasterByName($request->name);
    });
    Route::get('get-designation-options', [DesignationController::class, 'getDesignation']);
    Route::resource('currency-master', CurrencyController::class);
    Route::get('get-currency-options', [CurrencyController::class, 'getCurrencies']);
    Route::resource('country-master', CountryMasterController::class);
    Route::get('get-country-options', [CountryMasterController::class, 'getCountry']);
    Route::resource('state-master', StateMasterController::class);
    Route::get('get-state-options', [StateMasterController::class, 'getStates']);
    Route::get('get-state-by-country', [StateMasterController::class, 'getStatesByCountry']);
    Route::resource('city-master', CityMasterController::class);
    Route::get('get-city-by-state', [CityMasterController::class, 'getCityByState']);
    Route::get('get-city-options', [CityMasterController::class, 'getCityOptions']);
    Route::resource('enquiry-reference', EnquiryReferenceController::class);
    Route::get('get-enquiry-ref-options', [EnquiryReferenceController::class, 'getAllEnqRefMaster']);
    Route::resource('quotation-type', QuotationTypeController::class);
    Route::get('quotation-type-options', [QuotationTypeController::class, 'getQuotationOption']);
    Route::resource('lead-title-master', LeadTitleMasterController::class);
    Route::resource('lead-stage-master', LeadStageMasterController::class);
    Route::get('get-all-lead-stage', [LeadStageMasterController::class, 'getAllLeadStage']);
    Route::get('get-lead-stage-by-type', [LeadStageMasterController::class, 'LeadStageByStageTypeMaster']);
    Route::resource('industries-type-master', IndustryTypeController::class);
    Route::get('get-industry-type-options', [IndustryTypeController::class, 'getAllIndustryType']);
    Route::resource('purchase-type', PurchaseTypeController::class);
    Route::resource('reason-type', ReasonController::class);
    Route::get('get-quotation-reason-master-options', [ReasonController::class, 'getQuotationReasonMaster']);
    Route::get('get-city-options', [CityMasterController::class, 'getCities']);
    Route::get('get-city-by-state', [CityMasterController::class, 'getCityByState']);
    Route::resource('document-header', DocumentHeaderController::class);
    Route::post('document-sales-header-options', [DocumentHeaderController::class, 'getSalesHeadersOptions']);
    Route::resource('document-footer', DocumentFooterController::class);
    Route::post('document-sales-footer-options', [DocumentFooterController::class, 'getSalesFootersOptions']);
    Route::resource('note-master', NoteController::class);
    Route::resource('machine-master', MachineController::class);

    //User Management
    Route::get('get-users-options', [UserManagementController::class, 'getAllUsers']);
    Route::get('get-users-details/{id}', [UserManagementController::class, 'show']);
    Route::get('get-users-list', [UserManagementController::class, 'index']);
    Route::get('get-users-name-options', [UserManagementController::class, 'getUsersName']);
    Route::post('users', [UserManagementController::class, 'store']);
    Route::put('users/{id}', [UserManagementController::class, 'update']);
    Route::delete('users/{id}', [UserManagementController::class, 'destroy']);

    //Permission Management
    Route::apiResource('permission-management', PermissionController::class);
    Route::get('get-permissions-all-options', [PermissionController::class,'getAllPermissions']);
    Route::apiResource('role-management', RoleManagement::class);
    Route::get('get-role-all-options', [RoleManagement::class,'getAllRoleOptions']);

    Route::resource('process-master', ProcessController::class);
    Route::get('get-process-master-option', [ProcessController::class, 'getProcessOptions']);
    Route::resource('operator-master', OperatorController::class);
    Route::resource('packing-master', PackingController::class);
    Route::resource('payment-deduction-master', PaymentDeductionController::class);
    Route::resource('expense-master', ExpenseController::class);
    Route::resource('document-type-master', DocumentTypeController::class);
    Route::resource('bank-master', BankController::class);
    Route::resource('store-master', StoreMasterController::class);
    Route::get('get-store-master-options', [StoreMasterController::class, 'getStoreOptions']);
    Route::resource('item-category', ItemCategoryController::class);
    Route::get('get-item-category-options', [ItemCategoryController::class, 'getAllItemCategory']);
    Route::post('item-category-exist', [ItemCategoryController::class, 'checkItemCategoryNameExist']);
    Route::resource('tds-master', TdsMasterController::class);
    Route::get('get-tds-options', [TdsMasterController::class, 'getAllTdsTypes']);
    Route::resource('payment-mode-master', PaymentModeMasterController::class);
    Route::get('get-payment-mode-options', [PaymentModeMasterController::class, 'getAllPaymentMode']);
    Route::resource('narration-master', NarrationMasterController::class);
    Route::resource('cheque-printing-master', ChequePrintingFormatMasterController::class);
    Route::get('cheque-printing-format-lists', [ChequePrintingFormatMasterController::class, 'getChequePrintFormatList']);
    Route::POST('save-common-settings', [SettingsController::class, 'addUpdateSettings']);
    Route::get('get-settings-by-key', [SettingsController::class, 'getSettingsByKey']);
    Route::resource('chart-of-accounts-master', ChartOfAccountsController::class);
    Route::get('get-chart-of-accounts-options', [ChartOfAccountsController::class, 'getAllChartOfAccountsMode']);
    Route::get('get-sub-chart-of-accounts', [ChartOfAccountsController::class, 'getAllSubChartAccount']);
    Route::get('get-accounts-options', [ChartOfAccountsController::class, 'getAllChartOfAccounts']);
    Route::resource('item-main-sub-group', ItemMainSubGroupController::class);
    Route::post('item-main-sub-group-exist', [ItemMainSubGroupController::class, 'checkItemMainSubGroupExist']);
    Route::get('get-item-main-sub-group-options', [ItemMainSubGroupController::class, 'getAllItemMainSubGroup']);
    Route::resource('item-hsn-sac-code', ItemHsnSacMasterController::class);
    Route::post('item-hsn-sac-code-exist', [ItemHsnSacMasterController::class, 'checkItemHSNCodeExist']);
    Route::get('get-item-hsn-sac-code-options', [ItemHsnSacMasterController::class, 'getAllItemHsnSacMaster']);
    Route::resource('item-group-master', ItemGroupMasterController::class);
    Route::post('item-group-master-exist', [ItemGroupMasterController::class, 'checkItemGroupMasterExist']);
    Route::get('get-item-group-master-options', [ItemGroupMasterController::class, 'getAllItemGroupMaster']);
    Route::resource('item-addon-type', ItemAddonTypeController::class);
    Route::post('item-addon-type-exist', [ItemAddonTypeController::class, 'checkItemAddonTypeExist']);
    Route::get('get-item-addon-type-options', [ItemAddonTypeController::class, 'getAllItemAddonType']);
    Route::resource('item-addon-detail', ItemAddonDetailController::class);
    Route::get('get-item-addon-detail-options', [ItemAddonDetailController::class, 'getAllItemAddonDetail']);
    Route::resource('item-sales-target-group', ItemSaleTargetGroupController::class);
    Route::get('get-item-sales-target-group-options', [ItemSaleTargetGroupController::class, 'getAllItemSalesTargetGroup']);
    Route::resource('term-condition-group-master', TermsConditionGroupController::class);
    Route::get('get-term-condition-group-master-options', [TermsConditionGroupController::class, 'getAllTermsConditionGroup']);
    Route::resource('term-condition-detail-master', TermsConditionDetailsController::class);
    Route::get('get-term-condition-detail-master-options', [TermsConditionDetailsController::class, 'getAllTermsConditionDetails']);
    Route::get('get-term-condition-detail-with-group-options', [TermsConditionDetailsController::class, 'getTermAndConditionWithGroup']);
    Route::get('get-term-condition-detail-with-group-details/{id}', [TermsConditionDetailsController::class, 'getTermAndConditionWithGroupDetails']);
    Route::resource('default-term-condition-master', DefaultTermsConditionController::class);
    Route::post('get-term-condition-by-type', [DefaultTermsConditionController::class, 'getTermAndConditionOptions']);
    Route::get('get-default-term-template-by-type/{type}', [DefaultTermsConditionController::class, 'getDefaultTerm']);
    Route::resource('term-condition-template-master', TermsConditionTemplateController::class);
    Route::resource('tax-master', TaxMasterController::class);
    Route::post('tax-master-exist', [TaxMasterController::class, 'checkTaxMasterExist']);
    Route::get('get-tax-master-options', [TaxMasterController::class, 'getAllTaxMaster']);
    Route::resource('tax-forms-master', TaxFormsMasterController::class);
    Route::post('tax-forms-master-exist', [TaxFormsMasterController::class, 'checkTaxFormsMasterExist']);
    Route::get('get-tax-forms-master-options', [TaxFormsMasterController::class, 'getAllTaxMaster']);
    Route::resource('duty-drawback-master', DutyDrawbackMasterController::class);
    Route::resource('ios-api-doc-master', IsoApiDocMasterController::class);
    Route::post('ios-api-doc-master-exist', [IsoApiDocMasterController::class, 'checkIsoApiDocMasterExist']);
    Route::get('get-ios-api-doc-master-options', [IsoApiDocMasterController::class, 'getAllIsoApiDocMaster']);
    Route::resource('general-ledger-accounts', GeneralLedgerAccountsController::class);
    Route::get('get-account-ledger-options', [GeneralLedgerAccountsController::class, 'getAccountLedgerOptions']);
    Route::resource('budget-master', BudgetMasterController::class);
    Route::resource('task-master', TaskMasterController::class);
    Route::get('get-task-master-options', [TaskMasterController::class, 'getAllTaskMaster']);
    Route::resource('cost-center-master', CostCenterMasterController::class);
    Route::get('cost-center-list-tree', [CostCenterMasterController::class, 'costCenterOptionsList']);
    Route::resource('progress-stage-master', ProgressStageMasterController::class);
    Route::resource('billing-master', BillingMasterController::class);
    Route::get('get-billing-master-options', [BillingMasterController::class, 'getBillingMasterOptions']);
    Route::get('get-billing-details-master-options', [BillingMasterController::class, 'getBillingOptions']);
    Route::resource('billing-template-master', BillingTemplateMasterController::class);
    Route::resource('billing-template-items-master', BillingTemplateItemsMasterController::class);
    Route::get('get-billing-template-master-options', [BillingTemplateMasterController::class, 'getBillingTemplateMasterOptions']);
    Route::resource('default-billing-template-master', DefaultBillingTemplateController::class);
    Route::resource('sales-enquiry', SalesEnquiryController::class);
    Route::get('sales-enquiry-options', [SalesEnquiryController::class, 'getInquiryOptions']);
    Route::get('sales-enquiry-with-item-details/{id}', [SalesEnquiryController::class, 'getInquiryWithItems']);
    Route::resource('sales-item-details', SalesItemDetailsController::class);
    Route::get('get-sales-item-details/{id}', [SalesItemDetailsController::class, 'getSalesItemsDetails']);
    Route::resource('sales-history', SalesHistoryController::class);
    Route::post('get-sales-item-list', [SalesItemDetailsController::class, 'getSalesItemList']);
    Route::get('sales-history-iq-wise/{id}', [SalesHistoryController::class, 'getHistorySalesIqWise']);
    Route::resource('branch-master', BranchMasterController::class);
    Route::get('get-branch-master-options', [BranchMasterController::class, 'getAllBranchMaster']);
    Route::resource('sales-quotation', SalesQuotationController::class);
    Route::get('get-pending-sales-quotations', [SalesQuotationController::class, 'getPendingQuotations']);
    Route::get('get-party-quotations/{id}', [SalesQuotationController::class, 'getPartyQuotations']);
    Route::delete('remove-sales-item/{id}', [SalesQuotationController::class, 'deleteSalesQuotationItem']);
    Route::get('get-approve-quotation-list', [SalesQuotationController::class, 'getApproveQuotationList']);
    Route::get('get-approve-sales-quotation-list', [SalesQuotationController::class, 'getApproveSalesQuotationList']);
    Route::post('get-quotation-item-list', [SalesQuotationController::class, 'getQuotationItemList']);
    Route::resource('sales-order', SalesOrderController::class);
    Route::get('get-sales-order-options', [SalesOrderController::class, 'getSalesOrderListOptions']);
    Route::get('get-sales-order-by-item-options/{id}', [SalesOrderController::class, 'getSalesOrderListByItemIdOptions']);
    Route::get('get-party-items-from-orders/{id}', [SalesOrderController::class, 'getPartyItemsFromOrders']);
    Route::post('get-sales-order-kind-attn', [SalesOrderController::class, 'getSalesOrderKindAttn']);
    Route::post('update-sales-order-deviation', [SalesOrderController::class, 'updateSalesOrderDeviation']);
    Route::post('get-sales-order-filter-wise', [SalesOrderController::class, 'getSalesOrderFilterWise']);

    Route::resource('sales-order-items', SalesOrderItemsController::class);
    Route::get('get-sales-order-items/{id}', [SalesOrderItemsController::class, 'getSalesOrderItemDetails']);
    Route::post('get-sales-order-items-details', [SalesOrderItemsController::class, 'getSalesOrderItems']);
    Route::post('get-sales-order-items-details-filter', [SalesOrderItemsController::class, 'getSalesOrderListFilter']);
    Route::apiResource('sales-delivery-schedule', SalesDeliveryScheduleController::class);
    Route::get('get-sales-order-item-delivery/{id}', [SalesDeliveryScheduleController::class, 'getSalesOrderItemDelivery']);
    Route::apiResource('sales-order-agents', SalesOrderAgentController::class);
    Route::get('get-sales-order-agents/{id}', [SalesOrderAgentController::class, 'getSalesOrderAgents']);
    Route::resource('sales-order-billing-terms', SalesOrderBillingTermsController::class);
    Route::get('get-sales-order-billing-terms/{id}', [SalesOrderBillingTermsController::class, 'getSalesOrderBillingTermDetails']);
    Route::delete('delete-old-sales-order-billing-terms/{id}', [SalesOrderBillingTermsController::class, 'deleteOldBillingTerms']);
    Route::post('sales-order-bulk-insert-billing-term', [SalesOrderBillingTermsController::class, 'bulkInsertBillingTerm']);
    Route::resource('sales-order-term-condition', SalesOrderTermConditionController::class);
    Route::get('get-sales-order-term-condition/{id}', [SalesOrderTermConditionController::class, 'getSalesOrderTermConditionDetails']);
    Route::post('add-sales-order-term-condition-from-template', [SalesOrderTermConditionController::class, 'addTermConditionFromTemplate']);
    Route::post('copy-term-condition-default-template-sales-order', [SalesOrderTermConditionController::class, 'copyDefaultTermAndCondition']);
    Route::post('copy-term-condition-party-master-sales-order', [SalesOrderTermConditionController::class, 'getTermConditionFromPartyMaster']);
    Route::apiResource('sales-order-stage', SalesOrderStagesController::class);
    Route::get('get-sales-order-stage/{id}', [SalesOrderStagesController::class, 'getSalesOrderStages']);
    Route::apiResource('sales-order-history', SalesOrderHistoryController::class);
    Route::get('get-sales-order-history/{id}', [SalesOrderHistoryController::class, 'getSalesOrderHistory']);
    Route::apiResource('sales-order-checklist', SalesOrderChecklistController::class);
    Route::get('get-sales-order-checklist/{id}', [SalesOrderChecklistController::class, 'getSalesOrderChecklist']);
    Route::apiResource('sales-order-payment-schedule', SalesOrderPaymentScheduleController::class);
    Route::get('get-sales-order-payment-schedule/{id}', [SalesOrderPaymentScheduleController::class, 'getSalesOrderPaymentSchedule']);
    Route::get('get-sales-order-items-total-amount/{id}', [SalesOrderPaymentScheduleController::class, 'getSalesOrderItemsTotalAmount']);
    Route::resource('invoice-type-master', InvoiceTypeController::class);
    Route::get('get-invoice-type-options', [InvoiceTypeController::class, 'getAllInvoiceTypeMaster']);
    Route::get('check-invoice-prefix/{name}', [InvoiceTypeController::class, 'checkPrefixExist']);
    Route::resource('sales-order-type-master', SalesOrderTypeController::class);
    Route::get('get-sales-order-type-options', [SalesOrderTypeController::class, 'getAllSalesOrderTypeMaster']);
    Route::resource('proforma-invoices', ProformaInvoiceController::class);
    Route::resource('proforma-invoice-items', ProformaInvoiceItemsController::class);
    Route::get('get-proforma-invoice-items/{id}', [ProformaInvoiceItemsController::class, 'getPiItemDetails']);
    Route::resource('pi-billing-terms', PiBillingTermsController::class);
    Route::get('get-pi-billing-terms/{id}', [PiBillingTermsController::class, 'getPiBillingTermDetails']);
    Route::delete('delete-old-proforma-billing-terms/{id}', [PiBillingTermsController::class, 'deleteOldProformaBillingTerms']);
    Route::resource('pi-term-condition', PiTermConditionController::class);
    Route::get('get-pi-term-condition/{id}', [PiTermConditionController::class, 'getPiTermConditionDetails']);
    Route::resource('sales-return', SalesReturnController::class);
    Route::get('/get-sales-return-final-amount-items/{id}', [SalesReturnController::class, 'getFinalAmountAndItems']);
    Route::resource('sales-return-items', SalesReturnItemsController::class);
    Route::get('get-sales-return-items/{id}', [SalesReturnItemsController::class, 'getSRItemDetails']);
    Route::resource('sr-billing-terms', SrBillingTermsController::class);
    Route::get('get-sr-billing-terms/{id}', [SrBillingTermsController::class, 'getSRBillingTermDetails']);
    Route::delete('delete-current-billing-term/{id}', [SrBillingTermsController::class, 'deleteBillingTerms']);
    Route::apiResource('drawing-master', DrawingMasterController::class);
    Route::apiResource('bill-of-material', BillOfMaterialController::class);
    Route::get('get-bill-Of-material-options', [BillOfMaterialController::class, 'getBillOfMaterialOptions']);
    Route::get('is-bom-exist/{id}', [BillOfMaterialController::class, 'isBomExist']);
    Route::apiResource('bill-of-material-version', BillOfMaterialVersionController::class);
    Route::get('get-bom-version-from-item-code/{itemCode}', [BillOfMaterialVersionController::class,'getBomVersions']);
    Route::get('get-bom-versions-options', [BillOfMaterialVersionController::class, 'getBomVersionsOptions']);
    Route::get('get-bom-versions-item-wise-options/{itemId}', [BillOfMaterialVersionController::class, 'getBomVersionItemWiseOptions']);
    Route::post('get-bom-versions-item-wise-options', [BillOfMaterialVersionController::class, 'getBomVersionFromItems']);
    Route::get('get-bom-versions-list/{bomId}', [BillOfMaterialVersionController::class, 'getBomVersionDetails']);
    Route::apiResource('bom-version-items', BomVersionItemController::class);
    Route::get('get-bom-version-items-data/{bomId}/{versionId}', [BomVersionItemController::class, 'getBomVersionItemData']);
    Route::get('get-bom-version-assembly-items-data/{bomId}/{versionId}/{assemblyId}', [BomVersionItemController::class, 'getBomVersionAssemblyItemData']);
    Route::get('get-bom-items/{itemId}', [BomVersionItemController::class, 'getBomUsingItemId']);
    Route::apiResource('bom-version-process', BomVersionProcessController::class);
    Route::get('get-bom-version-process-data/{bomId}/{versionId}', [BomVersionProcessController::class, 'getBomVersionProcessData']);
    Route::get('get-bom-item-wise-process-option/{bomId}', [BomVersionProcessController::class, 'getBomItemWiseProcessList']);
    Route::apiResource('drawing-master-revision', DrawingRevisionController::class);
    Route::get('get-drawing-master-revision/{id}', [DrawingRevisionController::class, 'getDrawingRevision']);
    Route::post('replace-bom-items', \App\Actions\Bom\ReplaceBomItemAction::class);
    Route::apiResource('drawing-master-document', DrawingDocumentsController::class);
    Route::get('get-drawing-master-document-data/{id}', [DrawingDocumentsController::class, 'getDocumentData']);
    Route::post('get-sales-enquiry-list-with-filter', [SalesEnquiryController::class, 'getInquiryWithFilter']);
    Route::post('get-sales-quotation-list-with-filter', [SalesQuotationController::class, 'getQuotationWithFilter']);
    Route::apiResource('work-orders', WorkOrderController::class);
    Route::get('get-pending-work-orders', [WorkOrderController::class, 'getPendingOrders']);
    Route::get('get-pending-work-order-assembly-items/{id}', [WorkOrderController::class, 'getPendingWorkOrderWithAssemblyItem']);
    Route::get('get-pending-work-order-assembly-items-child/{id}', [WorkOrderController::class, 'getPendingWorkOrderWithAssemblyItemChild']);
    Route::post('generate-wo-from-so', [WorkOrderController::class, 'generateWoFromSo']);
    Route::get('get-work-order-option', [WorkOrderController::class, 'getWorkOrderOptions']);
    Route::get('get-work-order-from-item-option/{id}', [WorkOrderController::class, 'getWorkOrderFromItemOption']);
    Route::get('get-all-work-order-assembly-items/{id}', [WorkOrderController::class, 'getAllWorkOrderWithAssemblyItem']);
    Route::get('get-work-order-assembly-items/{id}', [WorkOrderController::class, 'getWorkOrderWithAssemblyItem']);
    Route::post('workorder/get-assembly-items', [WorkOrderController::class, 'getWorkOrderItemFromIds']);
    Route::post('get-work-order-list-with-party', [WorkOrderController::class, 'getWorkOrderListWithParty']);
    Route::post('material-issue-work-order-item', [WorkOrderController::class, 'materialIssueWorkOrderItem']);

    Route::apiResource('work-order-note', WorkOrderNoteController::class);
    Route::get('get-work-order-note/{id}', [WorkOrderNoteController::class, 'getWorkOrderNote']);
    Route::apiResource('work-order-item', WorkOrderItemController::class);
    Route::get('work-order-item-list/{woId}', [WorkOrderItemController::class, 'getWorkOrderItems']);
    Route::get('work-order-assembly-item-list/{woId}/{assemblyId}', [WorkOrderItemController::class, 'getWorkOrderAssemblyItems']);
    Route::get('get-work-order-item-list', [WorkOrderItemController::class, 'getWorkOrderItemList']);
    Route::get('get-work-order-item-list-with-id/{id}', [WorkOrderItemController::class, 'getWorkOrderItemWithId']);
    Route::get('get-wo-item-detail-manual/{id}', [WorkOrderItemController::class, 'getWorkOrderItemForManualPlanning']);
    Route::apiResource('work-order-item-assembly', WorkOrderItemAssemblyController::class);
    Route::get('get-work-order-item-assembly-list/{orderId}/{itemId}', [WorkOrderItemAssemblyController::class, 'getWorkOrderItemAssemblyList']);
    Route::post('get-sales-order-list-with-filter', [SalesOrderController::class, 'getSalesOrderWithFilter']);
    Route::apiResource('work-order-routing', WorkOrderRoutingController::class);
    Route::get('get-work-order-routing-list/{id}', [WorkOrderRoutingController::class, 'getWorkOrderRouting']);
    Route::apiResource('work-order-item-routing', WorkOrderItemRoutingController::class);
    Route::get('get-work-order-item-routing-list/{woId}/{itemId}', [WorkOrderItemRoutingController::class, 'getWoItemRoutingList']);
    Route::apiResource('process-sheet-master', ProcessSheetMasterController::class);
    Route::get('get-process-sheet-number-by-item/{itemId}', [ProcessSheetMasterController::class, 'getProcessNumberByItemId']);
    Route::get('get-process-sheet-by-number/{processNo}', function (Request $request) {
        return ProcessSheetMaster::with('itemDetails')->where('processSheetNo', $request->processNo)->first();
    });
    Route::apiResource('process-sheet-list', ProcessSheetListController::class);
    Route::get('get-process-sheet-list-data/{id}', [ProcessSheetListController::class, 'getProcessSheetList']);
    Route::apiResource('job-cards', JobCardsController::class);
    Route::get('get-job-card-options', [JobCardsController::class, 'getJobCardOptions']);
    Route::apiResource('job-cards-process-details', JobCardProcessDetailsController::class);
    Route::get('get-job-cards-process-details-list/{id}', [JobCardProcessDetailsController::class, 'getJobProcessDetails']);
    Route::post('get-sales-enquiry-list-with-filter', [SalesEnquiryController::class, 'getInquiryWithFilter']);
    Route::post('get-sales-quotation-list-with-filter', [SalesQuotationController::class, 'getQuotationWithFilter']);

    //Wo And Job Requisition
    Route::apiResource('wo-requisition', WoRequisitionController::class);
    Route::get('get-item-requisition-options', [WoRequisitionController::class, 'getItemRequisitionOption']);
    Route::get('get-item-requisition-details/{id}', [WoRequisitionController::class, 'getRequisitionDetailsWithJobCardWorkOrder']);

    //Wo And Job Items Requisition
    Route::apiResource('wo-requisition-items', WoRequisitionItemsController::class);
    Route::get('get-wo-requisition-items/{id}', [WoRequisitionItemsController::class, 'getItemList']);
    Route::post('material-issue-on-requisition-item', [WoRequisitionItemsController::class, 'issueMaterialOnItem']);

    Route::apiResource('job-card-return-shop', JobCardReturnShopController::class);
    Route::apiResource('job-card-return-shop-item', JobCardReturnShopItemController::class);
    Route::get('get-job-card-return-shop-items/{id}', [JobCardReturnShopItemController::class, 'returnShopItems']);

    Route::group(['prefix' => 'mrp'], function () {
        Route::apiResource('wo-purchase-items', WoPurchaseItemController::class);
        Route::apiResource('wo-assembly-component', WoAssemblyComponentController::class);
        Route::apiResource('wo-wise-purchase-items', WoWisePurchaseItemController::class);
        Route::apiResource('wo-wise-assembly-component', WoWiseAssemblyComponentController::class);
        Route::apiResource('minimum-level-shortage', MinimumLevelShortageController::class);
        Route::apiResource('manual-planning', ManualPlanningController::class);
        Route::apiResource('manual-planning-allocation', WoAllocationController::class);
        Route::get('manual-planning-allocation-list/{id}', [WoAllocationController::class, 'getWoAllocationList']);
        Route::apiResource('manual-planning-delivery', DeliveryScheduleController::class);
        Route::get('manual-planning-delivery-list/{id}', [DeliveryScheduleController::class, 'getDeliveryScheduleList']);
        Route::get('/pending-indent', [PendingIndentController::class, 'index']);
        Route::get('/pending-indent/{id}', [PendingIndentController::class, 'show']);
        Route::put('/pending-indent/{id}', [PendingIndentController::class, 'update']);
        Route::post('/get-indent-with-filter', [PendingIndentController::class, 'getIndentWithFilter']);
        Route::get('/indent-approval', [IndentApprovalController::class, 'index']);
        Route::get('/indent-approval/{id}', [IndentApprovalController::class, 'show']);
        Route::put('/indent-approval/{id}', [IndentApprovalController::class, 'update']);
    });

    Route::apiResource('purchase-enquiry', PurchaseEnquiryController::class);
    Route::apiResource('purchase-enquiry-vendor-detail', PurchaseEnquiryVendorDetailController::class);
    Route::get('purchase-enquiry-vendor-details/{referenceId}', [PurchaseEnquiryVendorDetailController::class, 'purchaseEnquiryVendorDetails']);
    Route::apiResource('purchase-enquiry-item-detail', PurchaseEnquiryItemDetailController::class);
    Route::get('purchase-enquiry-item-details/{referenceId}', [PurchaseEnquiryItemDetailController::class, 'getPurchaseEnquiryItemDetails']);
    Route::post('add-purchase-item-from-sales-order', [PurchaseEnquiryItemDetailController::class, 'addPurchaseItemFromSalesOrder']);
    Route::post('add-purchase-item-from-indent', [PurchaseEnquiryItemDetailController::class, 'addPurchaseItemFromIndent']);
    Route::apiResource('purchase-quotation', PurchaseQuotationController::class);
    Route::get('get-purchase-quotation-vendor-options', [PurchaseQuotationController::class, 'getVendorOptions']);
    Route::apiResource('purchase-quotation-item', PurchaseQuotationItemsController::class);
    Route::get('get-purchase-quotation-item/{id}', [PurchaseQuotationItemsController::class, 'getPurchaseQuotationItems']);
    Route::get('get-purchase-quotation-item-ref-wise/{refId}', [PurchaseQuotationItemsController::class, 'getRefWiseItems']);
    Route::apiResource('purchase-quotation-billing-term', PurchaseQuotationBillingController::class);
    Route::get('get-purchase-quotation-billing-terms/{id}', [PurchaseQuotationBillingController::class, 'getPurchaseQuotaionBillingTerms']);
    Route::delete('delete-purchase-quotation-billing-terms/{id}', [PurchaseQuotationBillingController::class, 'deletePurchaseBillingTerms']);
    Route::post('bulk-add-purchase-quotation-billing-terms', [PurchaseQuotationBillingController::class, 'bulkAddPurchaseBillingTerms']);
    Route::apiResource('purchase-quot-term-condition', PurchaseQuotationTermConditionController::class);
    Route::get('get-purchase-quotation-term-condition/{referenceId}', [PurchaseQuotationTermConditionController::class, 'getPurchaseQuotationTermCondition']);
    Route::apiResource('purchase-order', PurchaseOrderController::class);
    Route::get('get-purchase-order-by-party/{party}', [PurchaseOrderController::class, 'getPurchaseOrderByParty']);
    Route::get('generate-purchase-order-amd-number/{poId}', [PurchaseOrderController::class, 'generateAmdNumber']);
    Route::apiResource('purchase-order-item', PurchaseOrderItemController::class);
    Route::get('get-purchase-order-item/{id}', [PurchaseOrderItemController::class, 'getPurchaseOrderItems']);
    Route::post('add-purchase-order-items', [PurchaseOrderItemController::class, 'addPurchaseOrderMultipleItems']);
    Route::apiResource('purchase-order-billing-term', PurchaseOrderBillingTermController::class);
    Route::get('get-purchase-order-billing-terms/{id}', [PurchaseOrderBillingTermController::class, 'getPurchaseOrderBillingTerm']);
    Route::delete('delete-purchase-order-billing-terms/{id}', [PurchaseOrderBillingTermController::class, 'deletePurchaseBillingTerms']);
    Route::post('add-bulk-purchase-order-billing-terms', [PurchaseOrderBillingTermController::class, 'bulkAddBillingTerm']);
    Route::apiResource('purchase-order-term-condition', PurchaseOrderTermConditionController::class);
    Route::get('get-purchase-order-term-conditions/{referenceId}', [PurchaseOrderTermConditionController::class, 'getPurchaseOrderTermCondition']);

    Route::apiResource('purchase-costing', PurchaseCostingController::class);
    Route::apiResource('purchase-costing-item', PurchaseCostingItemsController::class);

    Route::apiResource('job-work-order', JobWorkOrderController::class);
    Route::apiResource('job-work-order-item', JobWorkOrderItemsController::class);
    Route::post('add-job-work-order-item', [JobWorkOrderItemsController::class, 'addJobWorkOrderItem']);
    Route::get('get-job-work-order-item/{id}', [JobWorkOrderItemsController::class, 'getJobWorkItems']);
    Route::get('get-item-job-order-option', [JobWorkOrderItemsController::class, 'getJobOrderOption']);
    Route::get('get-job-work-no-by-party/{partyId}', [JobWorkOrderController::class, 'getJobWorkNoByParty']);

    Route::apiResource('job-order-billing-term', JobWorkOrderBillingTermController::class);
    Route::get('get-job-work-order-billing-term/{id}', function (Request $request) {
        return JobWorkOrderBillingTerm::where(['jobWorkOrderId' => $request->id])->oldest('srNo')->get();
    });
    Route::delete('delete-job-work-order-billing-term/{id}', function (Request $request) {
        return JobWorkOrderBillingTerm::deleteData(['jobWorkOrderId' => $request->id]);
    });
    Route::apiResource('job-order-term-condition', JobWorkOrderTermConditionController::class);
    Route::get('get-job-order-term-condition/{id}', [JobWorkOrderTermConditionController::class, 'getTermAndConditions']);
    Route::apiResource('issue-job-work-challan', IssueJobWorkChallanController::class);
    Route::apiResource('issue-job-work-challan-item', IssueJobWorkChallanItemsController::class);
    Route::post('add-show-issue-item', [IssueJobWorkChallanItemsController::class, 'addShowIssueItem']);
    Route::get('get-job-work-challan-item/{id}', [IssueJobWorkChallanItemsController::class, 'getJobWorkChallanItems']);
    Route::get('get-purchase-costing-item/{id}', [PurchaseCostingItemsController::class, 'getPurchaseCostingItems']);

    /*
     |--------------------------------------------------------------------------|
     | Challan Invoice Routes
     |--------------------------------------------------------------------------|
    */
    Route::resource('new-challan-and-invoice', NewChallanInvoiceController::class);
    Route::get('get-challan-invoice-from-party/{id}', [NewChallanInvoiceController::class, 'getInvoiceFromParty']);
    Route::get('new-challan-and-invoice-list', [NewChallanInvoiceController::class, 'getAllInvoiceList']);
    Route::resource('new-challan-and-invoice-item', NewChallanInvoiceItemController::class);
    Route::post('add-multiple-new-challan-invoice-items', [NewChallanInvoiceItemController::class, 'saveItemsFromSalesOrder']);
    Route::get('get-challan-and-invoice-item/{id}', [NewChallanInvoiceItemController::class, 'getChallanInvoiceItem']);
    Route::get('get-challan-and-invoice-item-options/{id}', [NewChallanInvoiceItemController::class, 'getChallaInvoiceItemOptions']);
    Route::resource('new-challan-billing-term', NewChallanInvoiceBillingTermController::class);
    Route::get('get-challan-billing-term/{id}', [NewChallanInvoiceBillingTermController::class, 'getBillingTerm']);
    Route::delete('delete-challan-billing-term/{id}', [NewChallanInvoiceBillingTermController::class, 'deleteBillingTerm']);
    Route::post('bulk-add-challan-billing-term', [NewChallanInvoiceBillingTermController::class, 'bulkInsertChallanBillingTerm']);
    Route::resource('new-challan-term-condition', NewChallanInvoiceTermConditionController::class);
    Route::get('get-challan-and-invoice-term-condition/{id}', [NewChallanInvoiceTermConditionController::class, 'getTermAndCondition']);
    Route::apiResource('new-challan-invoice-packing', NewChallanInvoicePackingController::class);
    Route::get('new-challan-packing-list/{id}', [NewChallanInvoicePackingController::class, 'getNewChallanInvoicePackingList']);
    Route::apiResource('new-challan-invoice-shipping', NewChallanInvoiceShippingController::class);
    Route::get('get-new-challan-shipping-list/{id}', [NewChallanInvoiceShippingController::class, 'getShippingList']);

    Route::apiResource('serial-master', SerialMasterController::class);
    Route::post('manual-material-issue', MaterialIssueController::class);

    /*
     |--------------------------------------------------------------------------|
     | Administration Routes
     |--------------------------------------------------------------------------|
    */
    Route::group(['prefix' => 'administration'], function () {
        Route::resource('company', CompanyController::class);
        Route::get('get-company-options', [CompanyController::class, 'getCompanyOptions']);
    });


    /*
     |
     |--------------------------------------------------------------------------|
     | Master GST API Routes
     |--------------------------------------------------------------------------|
     |  Master GST API For submitting reports
     |  Governments API
     |  Using this api we can submit reports on the government portals
     |--------------------------------------------------------------------------|
    */

    Route::group(['prefix' => 'master-gst'], function () {
        Route::get('/get-items-and-final-amounts/{id}', GetChallanInvoiceItemAmountAction::class);
        Route::get('/get-purchase-return-items-and-final-amounts/{id}', [MasterGstController::class, 'getPurchaseReturnItemsAndAmount']);
        Route::post('generated-irn-save', [MasterGstController::class, 'saveIrnDetails']);
        Route::post('update-irn-ebill-details', [MasterGstController::class, 'updateIrnDetails']);
        Route::post('cancel-irn-ebill-details', [MasterGstController::class, 'cancelIrnDetails']);
    });

    Route::get('update-all-item-master-as-string', function () {
        $items = ItemMaster::all();

        $items->each(function ($item) {
            if (is_array($item->make)) {
                $item->make = $item->make[0] ?? null;
            }
            if (is_string($item->make)) {
                $item->make = $item->make;
            }
            $item->update();
        });

        return $items;
    });
});
