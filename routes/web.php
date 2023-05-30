<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\FormulaController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/access-denied', function () {
    dd("Access Denied");
});

Route::post('Signupp', [UserController::class, 'Signupp'])->name('Signupp');
Route::group(['middleware' => 'auth'], function () {

    //Admin
    Route::post('change-password', [AdminController::class, 'changePassword'])->name('change-password');
    Route::post('change-password-admin', [AdminController::class, 'changePasswordAdmin'])->name('change-password-admin');
    Route::post('change-status-admin', [AdminController::class, 'changeStatusAdmin'])->name('change-status-admin');
    Route::get('user-profile', [AdminController::class, 'userProfile'])->name('user-profile');
    Route::get('master-data', [AdminController::class, 'masterData'])->name('master-data');
    Route::get('master-data-plc', [AdminController::class, 'masterDataPlc'])->name('master-data-plc');
    Route::post('store-profile', [UserController::class, 'storeProfile'])->name('store-profile');
    Route::post('add-department', [AdminController::class, 'addDepartment'])->name('add-department');
    Route::post('add-location', [AdminController::class, 'addLocation'])->name('add-location');
    Route::post('add-last', [AdminController::class, 'addLast'])->name('add-last');
    Route::post('add-shape', [AdminController::class, 'addShape'])->name('add-shape');
    Route::post('add-range', [AdminController::class, 'addRange'])->name('add-range');
    Route::post('add-sole', [AdminController::class, 'addSole'])->name('add-sole');
    Route::post('add-type', [AdminController::class, 'addType'])->name('add-type');
    Route::post('add-designer', [AdminController::class, 'addDesigner'])->name('add-designer');
    Route::post('add-purpose', [AdminController::class, 'addPurpose'])->name('add-purpose');
    Route::post('add-project', [AdminController::class, 'addProject'])->name('add-project');
    Route::post('add-category-plc', [AdminController::class, 'addCategory'])->name('add-category-plc');
    Route::post('add-sizerange-plc', [AdminController::class, 'addSizeRange'])->name('add-sizerange-plc');
    Route::post('add-division', [AdminController::class, 'addDivision'])->name('add-division');
    Route::post('add-sub-division', [AdminController::class, 'addSubDivision'])->name('add-sub-division');
    Route::post('add-sub-categoryy', [AdminController::class, 'addSubCategory'])->name('add-sub-categoryy');
    Route::post('last', [AdminController::class, 'Last'])->name('last');
    Route::post('location', [AdminController::class, 'Location'])->name('location');
    Route::post('shape', [AdminController::class, 'Shape'])->name('shape');
    Route::post('sole', [AdminController::class, 'Sole'])->name('sole');
    Route::post('range', [AdminController::class, 'Range'])->name('range');
    Route::post('sizerange', [AdminController::class, 'sizeRange'])->name('sizerange');
    Route::post('designer', [AdminController::class, 'Designer'])->name('designer');
    Route::post('project', [AdminController::class, 'Project'])->name('project');
    Route::get('export', [AdminController::class, 'exportData'])->name('export');
    Route::post('purpose', [AdminController::class, 'Purpose'])->name('purpose');
    Route::post('cat', [AdminController::class, 'Category'])->name('cat');
    Route::post('division', [AdminController::class, 'Division'])->name('division');
    Route::post('subdivision', [AdminController::class, 'SubDivision'])->name('subdivision');
    Route::post('subcategory', [AdminController::class, 'subCategory'])->name('subcategory');
    Route::get('lastdel/{id}', [AdminController::class, 'lastDel']);
    Route::get('locdel/{id}', [AdminController::class, 'locDel']);
    Route::get('shapedel/{id}', [AdminController::class, 'shapeDel']);
    Route::get('soledel/{id}', [AdminController::class, 'soleDel']);
    Route::get('rangedel/{id}', [AdminController::class, 'rangeDel']);
    Route::get('sizerangedel/{id}', [AdminController::class, 'sizerangeDel']);
    Route::get('projectdel/{id}', [AdminController::class, 'projectDel']);
    Route::get('purposedel/{id}', [AdminController::class, 'purposeDel']);
    Route::get('divisiondel/{id}', [AdminController::class, 'divisionDel']);
    Route::get('subdivisiondel/{id}', [AdminController::class, 'subdivisionDel']);
    Route::get('subcategorydel/{id}', [AdminController::class, 'subcategoryDel']);
    Route::get('UserAttendance', [AdminController::class, 'Attendance'])->name('UserAttendance');
    Route::post('get-attendance', [AdminController::class, 'GetAttendance'])->name('get-attendance');
    Route::post('get-user-attendance', [AdminController::class, 'GetUserAttendance'])->name('get-user-attendance');
    Route::post('get-dep-attendance', [AdminController::class, 'GetDepAttendance'])->name('get-dep-attendance');
    Route::get('user-attendance', [AdminController::class, 'UserAttendance'])->name('user-attendance');
    Route::get('dep-attendance', [AdminController::class, 'DepAttendance'])->name('dep-attendance');
    Route::get('weather', [AdminController::class, 'weather'])->name('weather');
    Route::get('updateJoborder', [AdminController::class, 'updateJoborder'])->name('updateJoborder');
    Route::get('login-logs', [AdminController::class, 'loginLogs'])->name('login-logs');

    //Complaint
    Route::get('manage-complaints', [ComplaintController::class, 'manageComplaints'])->name('manage-complaints');
    Route::get('manage-all-complaints', [ComplaintController::class, 'manageAllComplaints'])->name('manage-all-complaints');
    Route::get('master-settings', [ComplaintController::class, 'masterData1'])->name('master-settings');
    Route::post('add-category', [ComplaintController::class, 'addCategory'])->name('add-category');
    Route::post('add-sub-category', [ComplaintController::class, 'addSubCategory'])->name('add-sub-category');
    Route::get('new-support-case', [ComplaintController::class, 'supportCase'])->name('new-support-case');
    Route::post('support-case', [ComplaintController::class, 'Store'])->name('support-case');
    Route::post('support-case-edit', [ComplaintController::class, 'Update'])->name('support-case-edit');
    Route::get('complaints-view', [ComplaintController::class, 'Display'])->name('complaints-view');
    Route::get('complaints-view-user', [ComplaintController::class, 'DisplayUser'])->name('complaints-view-user');
    Route::get('complaints-edit-user', [ComplaintController::class, 'Edit'])->name('complaints-edit-user');
    Route::post('support', [ComplaintController::class, 'Support'])->name('support');
    Route::post('submit', [ComplaintController::class, 'Submit'])->name('submit');
    Route::post('submit-user', [ComplaintController::class, 'SubmitUser'])->name('submit-user');
    Route::get('manage-complaints-user', [ComplaintController::class, 'manageUsersComplaint'])->name('manage-complaints-user');
    Route::get('read_at/{id}', [ComplaintController::class, 'Read'])->name('read_at');
    Route::get('mark_all', [ComplaintController::class, 'MarkAll'])->name('mark_all');
    Route::get('count', [ComplaintController::class, 'countComplain'])->name('count');
    Route::get('counthome', [ComplaintController::class, 'countComplainHome'])->name('counthome');
    Route::get('category/{id}', [ComplaintController::class, 'Category'])->name('category');
    Route::get('deleteComplain/{id}', [ComplaintController::class, 'delete'])->name('deleteComplain');
    Route::get('all-activity', [ComplaintController::class, 'allActivity'])->name('all-activity');
    Route::get('completeComplaint/{id}', [ComplaintController::class, 'Complete']);
    Route::get('rejectComplaint/{id}', [ComplaintController::class, 'Reject']);
    Route::get('chat/{complaint}/{userid}', [ComplaintController::class, 'Chat']);
    Route::post('chats', [ComplaintController::class, 'Chats']);
    Route::get('chat1/{complaint}/{userid}', [ComplaintController::class, 'Chat1']);
    Route::post('chats1', [ComplaintController::class, 'Chats1']);
    
    //User
    Route::get('attendance', [UserController::class, 'attendance'])->name('attendance');
    Route::get('user-manage', [UserController::class, 'userManage'])->name('user-manage');
    Route::get('users-create', [UserController::class, 'create'])->name('users-create');
    Route::get('user-edit', [UserController::class, 'userEdit'])->name('user-edit');
    Route::post('user-create', [UserController::class, 'store'])->name('user-create');
    Route::get('delete/{id}', [UserController::class, 'delete'])->name('delete');
    Route::get('employee_detail/{id}', [UserController::class, 'employee_detail'])->name('employee_detail');
    Route::get('employee_detail1/{id}', [UserController::class, 'employee_detail1'])->name('employee_detail1');
    Route::get('username/{id}', [UserController::class, 'username'])->name('username');
    Route::post('edit-user', [UserController::class, 'Edituser'])->name('edit-user'); 
    Route::post('changeImage', [UserController::class, 'changeImage'])->name('changeImage'); 
    Route::get('changeImagee', function () {
        return view('user.update-profile');
    });
    Route::get('user-password', function () {
        return view('user.user-password');
    });

    Route::get('booksss', function () {
        return view('book.books');
    });

    Route::get('home1', function () {
        return view('home1');
    });

    //Book   
    Route::get('assign-book', [BookController::class, 'Index'])->name('assign-book');
    Route::post('add-book', [BookController::class, 'Store'])->name('add-book');
    Route::get('manage-book', [BookController::class, 'Manage'])->name('manage-book');
    Route::get('check/{id}', [BookController::class, 'Check']);
    Route::get('deleteBook/{id}', [BookController::class, 'Delete']);
    Route::get('book-edit', [BookController::class, 'Edit'])->name('book-edit');
    Route::post('update-book', [BookController::class, 'Update'])->name('update-book');    
    Route::get('updateorcreate', [BookController::class, 'Updateorcreate']);    

    //Formula
    Route::get('formula-sheet', [FormulaController::class, 'Formula'])->name('formula-sheet');
    Route::post('formula-sheet-create', [FormulaController::class, 'Create'])->name('formula-sheet-create');
    Route::get('formula-sheet-table', [FormulaController::class, 'All'])->name('formula-sheet-table');
    Route::get('formula-sheet-edit', [FormulaController::class, 'Edit'])->name('formula-sheet-edit');
    Route::get('formula-sheet-view', [FormulaController::class, 'View'])->name('formula-sheet-view');
    Route::post('formula-sheet-update', [FormulaController::class, 'Update'])->name('formula-sheet-update');
    Route::get('deleteformula/{id}', [FormulaController::class, 'Delete']);
    Route::get('formulasheetstatus/{id}/{status}', [FormulaController::class, 'Status']);

    //Pricing
    Route::get('pricing-sheet', [PricingController::class, 'Costing'])->name('pricing-sheet');
    Route::get('pricing-sheet-view', [PricingController::class, 'View'])->name('pricing-sheet-view');
    Route::get('pricing-sheet-print', [PricingController::class, 'Print'])->name('pricing-sheet-print');
    Route::get('pricing-sheet-edit', [PricingController::class, 'Edit'])->name('pricing-sheet-edit');
    Route::get('pricing-sheet-edit-costing', [PricingController::class, 'EditCosting'])->name('pricing-sheet-edit-costing');
    Route::get('pricing-sheet-edit-ie', [PricingController::class, 'EditIe'])->name('pricing-sheet-edit-ie');
    Route::get('pricing-sheet-update-costing', [PricingController::class, 'UpdateCosting'])->name('pricing-sheet-update-costing');
    Route::get('pricing-sheet-update-ie', [PricingController::class, 'UpdateIe'])->name('pricing-sheet-update-ie');
    Route::post('pricing-sheet-update', [PricingController::class, 'Update'])->name('pricing-sheet-update');
    Route::post('pricing-sheet-update-material', [PricingController::class, 'UpdateMaterial'])->name('pricing-sheet-update-material');
    Route::post('pricing-sheet-update-material-edit', [PricingController::class, 'UpdateEditMaterial'])->name('pricing-sheet-update-material-edit');
    Route::post('pricing-sheet-update-resource', [PricingController::class, 'UpdateResource'])->name('pricing-sheet-update-resource');
    Route::post('pricing-sheet-update-overhead', [PricingController::class, 'UpdateOverhead'])->name('pricing-sheet-update-overhead');
    Route::post('pricing-sheet-create', [PricingController::class, 'Create'])->name('pricing-sheet-create');
    Route::get('pricing-sheet-table', [PricingController::class, 'All'])->name('pricing-sheet-table');
    Route::get('deletejoborder/{id}', [PricingController::class, 'Delete']);
    Route::get('calculate/{id}/{value}/{over}', [PricingController::class, 'Calculate']);
    Route::get('pricing-sheet-code/{id}', [PricingController::class, 'Detail']);
    Route::get('itemcode/{id}', [PricingController::class, 'ItemCode']);
    Route::get('ArticleCode/{id}', [PricingController::class, 'ArticleCode']);
    Route::get('FetchUser', [PricingController::class, 'Users'])->name('FetchUser');
    Route::get('pricingsheetstatus/{id}/{status}/{remarks}', [PricingController::class, 'Status']);
    Route::get('remarks/{id}', [PricingController::class, 'Remarks']);
    Route::get('storesono/{value}/{id}', [PricingController::class, 'StoreSono']);
    Route::get('getSubDivision/{value}', [PricingController::class, 'GetSubDivision']);
    Route::get('getSubCategory/{value}', [PricingController::class, 'GetSubCategory']);
    Route::get('GetDivision', [PricingController::class, 'GetDivision']);

    //Specification
    Route::get('specification-sheet', [SpecificationController::class, 'Specification'])->name('specification-sheet');
    Route::post('specification-sheet-create', [SpecificationController::class, 'Create'])->name('specification-sheet-create');
    Route::get('specification-sheet-table', [SpecificationController::class, 'All'])->name('specification-sheet-table');
    Route::get('specification-sheet-edit', [SpecificationController::class, 'Edit'])->name('specification-sheet-edit');
    Route::post('specification-sheet-update', [SpecificationController::class, 'Update'])->name('specification-sheet-update');
    Route::get('specification-sheet-view', [SpecificationController::class, 'View'])->name('specification-sheet-view');
    Route::get('specification-sheet-print', [SpecificationController::class, 'Print'])->name('specification-sheet-print');
    Route::get('specificationsheetstatus/{id}/{status}/{remarks}', [SpecificationController::class, 'Status']);
    Route::get('specification-sheet-create-costing', [SpecificationController::class, 'CreateCosting'])->name('specification-sheet-create-costing');
    Route::post('specification-sheet-update-material', [SpecificationController::class, 'UpdateMaterial'])->name('specification-sheet-update-material');
    Route::post('specification-sheet-update-material-edit', [SpecificationController::class, 'UpdateEditMaterial'])->name('specification-sheet-update-material-edit');
    Route::post('specification-sheet-update-resource', [SpecificationController::class, 'UpdateResource'])->name('specification-sheet-update-resource');
    Route::post('specification-sheet-update-overhead', [SpecificationController::class, 'UpdateOverhead'])->name('specification-sheet-update-overhead');
    Route::get('deletespecificationsheet/{id}', [SpecificationController::class, 'Delete']);
    Route::get('calculateSpecification/{id}/{value}', [SpecificationController::class, 'Calculate']);
    Route::get('specification-sheet-update-costing', [SpecificationController::class, 'UpdateCosting'])->name('specification-sheet-update-costing');
    Route::post('specification-formula-sheet-update', [SpecificationController::class, 'UpdateFormula'])->name('specification-formula-sheet-update');
    Route::get('pricingsheetduplicate/{desgin}/{id}', [SpecificationController::class, 'Duplicate']);
    Route::get('GetColor', [SpecificationController::class, 'GetColor']);
    Route::post('duplicatePSS', [SpecificationController::class, 'duplicateSheet'])->name('duplicatePSS');
    Route::post('duplicatePSSEdit', [SpecificationController::class, 'duplicateSheetEdit'])->name('duplicatePSSEdit'); 
    Route::get('pricing-sheet-duplicate', [SpecificationController::class, 'DuplicateView'])->name('pricing-sheet-duplicate');
    Route::get('specification-sheet-color-edit', [SpecificationController::class, 'ColorEdit'])->name('specification-sheet-color-edit');
    Route::post('removeColors', [SpecificationController::class, 'removeColors'])->name('removeColors');
    Route::post('removeSpec', [SpecificationController::class, 'removeSpec'])->name('removeSpec');

    //Report    
    Route::get('transfer-ledger', [ReportController::class, 'TransferLedger'])->name('transfer-ledger');
    Route::post('transfer-ledger-report', [ReportController::class, 'TransferLedgerDisplay'])->name('transfer-ledger-report');
    Route::post('transfer-ledger-report-download', [ReportController::class, 'TransferLedgerDownload'])->name('transfer-ledger-report-download');
    Route::get('transfer', [ReportController::class, 'Transfer'])->name('transfer');
    Route::post('transfer-report', [ReportController::class, 'TransferReportDisplay'])->name('transfer-report');
    Route::post('transfer-report-download', [ReportController::class, 'TransferReportDownload'])->name('transfer-report-download');
    Route::get('adjustment', [ReportController::class, 'Adjustment'])->name('adjustment');
    Route::post('adjustment-report', [ReportController::class, 'AdjustmentReportDisplay'])->name('adjustment-report');
    Route::post('adjustment-report-download', [ReportController::class, 'AdjustmentReportDownload'])->name('adjustment-report-download');
    Route::get('workorder', [ReportController::class, 'Workorder'])->name('workorder');
    Route::post('workorder-report', [ReportController::class, 'WorkorderReportDisplay'])->name('workorder-report');
    Route::post('workorder-report-download', [ReportController::class, 'WorkorderReportDownload'])->name('workorder-report-download');
    Route::get('purchase', [ReportController::class, 'Purchase'])->name('purchase');
    Route::post('purchase-report', [ReportController::class, 'PurchaseReportDisplay'])->name('purchase-report');
    Route::post('purchase-report-download', [ReportController::class, 'PurchaseReportDownload'])->name('purchase-report-download');
    Route::get('purchase-order', [ReportController::class, 'PurchaseOrder'])->name('purchase-order');
    Route::post('purchase-order-report', [ReportController::class, 'PurchaseOrderReportDisplay'])->name('purchase-order-report');
    Route::post('purchase-order-report-download', [ReportController::class, 'PurchaseOrderReportDownload'])->name('purchase-order-report-download');
    Route::get('purchase-invoice', [ReportController::class, 'PurchaseInvoice'])->name('purchase-invoice');
    Route::post('purchase-invoice-report', [ReportController::class, 'PurchaseInvoiceDisplay'])->name('purchase-invoice-report');
    Route::post('purchase-invoice-download', [ReportController::class, 'PurchaseInvoiceDownload'])->name('purchase-invoice-download');
    Route::get('item-purchase', [ReportController::class, 'ItemPurchase'])->name('item-purchase');
    Route::post('item-purchase-report', [ReportController::class, 'ItemPurchaseDisplay'])->name('item-purchase-report');
    Route::post('item-purchase-download', [ReportController::class, 'ItemPurchaseDownload'])->name('item-purchase-download');
    Route::get('joborder', [ReportController::class, 'JobOrder'])->name('joborder');
    Route::post('joborder-report', [ReportController::class, 'JobOrderReportDisplay'])->name('joborder-report');
    Route::post('joborder-report-download', [ReportController::class, 'JobOrderReportDownload'])->name('joborder-report-download');
    Route::get('joborderjourney', [ReportController::class, 'JobOrderJourney'])->name('joborderjourney');
    Route::post('joborder-journey', [ReportController::class, 'JobOrderJourneyDisplay'])->name('joborder-journey');
    Route::post('joborder-journey-download', [ReportController::class, 'JobOrderJourneyDownload'])->name('joborder-journey-download');
    Route::get('transferagainst', [ReportController::class, 'TransferAgainstJO'])->name('transferagainst');
    Route::post('transferagainst-report', [ReportController::class, 'TransferAgainstJODisplay'])->name('transferagainst-report');
    Route::post('transferagainst-report-download', [ReportController::class, 'TransferAgainstJODownload'])->name('transferagainst-report-download');
    Route::get('transferagainstall', [ReportController::class, 'TransferAgainstallJO'])->name('transferagainstall');
    Route::post('transferagainstall-report', [ReportController::class, 'TransferAgainstallJODisplay'])->name('transferagainstall-report');
    Route::post('transferagainstall-report-download', [ReportController::class, 'TransferAgainstallJODownload'])->name('transferagainstall-report-download');
    Route::get('rma', [ReportController::class, 'RMA'])->name('rma');
    Route::post('rma-report', [ReportController::class, 'RMADisplay'])->name('rma-report');
    Route::post('rma-report-download', [ReportController::class, 'RMADownload'])->name('rma-report-download');
    Route::get('consumption', [ReportController::class, 'Consumption'])->name('consumption');
    Route::post('consumption-report', [ReportController::class, 'ConsumptionDisplay'])->name('consumption-report');
    Route::post('consumption-report-download', [ReportController::class, 'ConsumptionDownload'])->name('consumption-report-download');
    Route::get('comparison', [ReportController::class, 'Comparison'])->name('comparison');
    Route::post('comparison-report', [ReportController::class, 'ComparisonDisplay'])->name('comparison-report');
    Route::post('comparison-report-download', [ReportController::class, 'ComparisonDownload'])->name('comparison-report-download');
    Route::get('sales', [ReportController::class, 'Sales'])->name('sales');
    Route::post('sales-report', [ReportController::class, 'SalesReportDisplay'])->name('sales-report');
    Route::post('sales-report-download', [ReportController::class, 'SalesReportDownload'])->name('sales-report-download');
    Route::get('sales-order', [ReportController::class, 'SalesOrder'])->name('sales-order');
    Route::post('sales-order-report', [ReportController::class, 'SalesOrderReportDisplay'])->name('sales-order-report');
    Route::post('sales-order-report-download', [ReportController::class, 'SalesOrderReportDownload'])->name('sales-order-report-download');
    Route::get('material', [ReportController::class, 'Material'])->name('material');
    Route::post('material-report', [ReportController::class, 'MaterialReportDisplay'])->name('material-report');
    Route::post('material-report-download', [ReportController::class, 'MaterialReportDownload'])->name('material-report-download');
    Route::get('rmcode/', [ReportController::class, 'RmCode'])->name('rmcode');
    Route::get('sono', [ReportController::class, 'Sono'])->name('sono');
    Route::get('artcode', [ReportController::class, 'Artcode'])->name('artcode');
    Route::get('itemcode', [ReportController::class, 'ItemCode'])->name('itemcode');
    Route::get('itemcode2', [ReportController::class, 'ItemCode2'])->name('itemcode2');
    Route::get('pono', [ReportController::class, 'Pono'])->name('pono');
    Route::get('supplier', [ReportController::class, 'Supplier'])->name('supplier');
    Route::get('jobordernum', [ReportController::class, 'JobOrderNum'])->name('jobordernum');
    Route::get('jobordernums', [ReportController::class, 'JobOrderNums'])->name('jobordernums');
    Route::get('joborderno', [ReportController::class, 'JobOrderNo'])->name('joborderno');
    Route::get('purchaseorderno', [ReportController::class, 'PurchaseOrderNo'])->name('purchaseorderno');
    Route::get('salesorderno', [ReportController::class, 'SalesOrderNo'])->name('salesorderno');
    Route::get('articleno', [ReportController::class, 'ArticleNo'])->name('articleno');
    Route::get('sinno', [ReportController::class, 'Sinno'])->name('sinno');
    Route::get('workorderno', [ReportController::class, 'workorderNo'])->name('workorderno');
    Route::get('purchaseinvno', [ReportController::class, 'purchaseInvNo'])->name('purchaseinvno');    
    Route::get('customer', [ReportController::class, 'Customer'])->name('customer');
    Route::get('transferData', [ReportController::class, 'transferData'])->name('transferData');
    Route::get('helpdesk', [ReportController::class, 'Helpdesk'])->name('helpdesk');
    Route::post('helpdesk-report', [ReportController::class, 'HelpdeskReportDisplay'])->name('helpdesk-report');
    Route::post('helpdesk-report-download', [ReportController::class, 'HelpdeskReportDownload'])->name('helpdesk-report-download');
    Route::get('department/{id}', [ReportController::class, 'Department'])->name('department');

    //Job Order 
    Route::get('job-order-table', [JobOrderController::class, 'All'])->name('job-order-table');
    // Route::get('pricingsheetduplicate/{desgin}/{id}', [JobOrderController::class, 'Duplicate']);
    Route::get('job-order', [JobOrderController::class, 'jobOrder'])->name('job-order');
    Route::get('createJobOrder/{id}', [JobOrderController::class, 'Create'])->name('createJobOrder');    
    Route::get('create-job-order', [JobOrderController::class, 'CreateJobOrder'])->name('create-job-order');        
    Route::get('articleData/{id}/{company}/{sono}', [JobOrderController::class, 'articleData'])->name('articleData');        
    Route::get('joborderdata', [JobOrderController::class, 'joborderdata'])->name('joborderdata');
    Route::get('companydata/{id}', [JobOrderController::class, 'Companydata']);

    Route::get('job-order-view', [JobOrderController::class, 'Display'])->name('job-order-view');
    Route::get('job-order-print', [JobOrderController::class, 'Display1'])->name('job-order-print');
    Route::get('job-order-edit', [JobOrderController::class, 'Edit'])->name('job-order-edit');
    Route::post('job-order-update', [JobOrderController::class, 'Update'])->name('job-order-update');
    Route::post('job-order-create', [JobOrderController::class, 'Create'])->name('job-order-create');
    Route::get('job-order-qc', [JobOrderController::class, 'AllQC'])->name('job-order-qc');
    Route::get('deletejoborder/{id}', [JobOrderController::class, 'Delete']);
    Route::get('job-order-code/{id}', [JobOrderController::class, 'Detail']);
    Route::get('itemcode/{id}', [JobOrderController::class, 'ItemCode']);
    Route::get('ArticleCode/{id}', [JobOrderController::class, 'ArticleCode']);
    Route::get('FetchUser', [JobOrderController::class, 'Users'])->name('FetchUser');
    
    //Objective 
    Route::post('obj-department', [ObjectiveController::class, 'objDepartment'])->name('obj-department');
    Route::post('obj-department-1', [ObjectiveController::class, 'objDepartment1'])->name('obj-department-1');
    Route::get('all-objective', [ObjectiveController::class, 'allObjective'])->name('all-objective');
    Route::get('show-obj', [ObjectiveController::class, 'showAllObj'])->name('show-obj');
    Route::get('show-objective', [ObjectiveController::class, 'showObjective'])->name('show-objective');
    Route::get('create-user-obj', [ObjectiveController::class, 'createObjUser'])->name('create-user-obj');
    Route::post('create-obj-user', [ObjectiveController::class, 'createUserObj'])->name('create-obj-user');
    Route::get('changeStatus/{id}', [ObjectiveController::class, 'status']);
    Route::get('changeStatus21/{id}/{status}/{name}', [ObjectiveController::class, 'statusAdmin']);
    Route::get('changeStatusHr/{id}', [ObjectiveController::class, 'statusHr']);
    Route::get('approve', [ObjectiveController::class, 'statusHr2']);
    Route::get('changeStatusHrRej/{id}', [ObjectiveController::class, 'statusHrRej']);
    Route::get('revision', [ObjectiveController::class, 'statusHrRej2']); 
    Route::get('obj-edit', [ObjectiveController::class, 'EditObj'])->name('obj-edit');
    Route::get('showobj/{id}', [ObjectiveController::class, 'showId']);
    Route::get('feedback', [ObjectiveController::class, 'feedback']);
    Route::get('showobjuser/{id}', [ObjectiveController::class, 'showIdUser']);
    Route::get('deleteobj/{id}', [ObjectiveController::class, 'delete'])->name('deleteobj');
    Route::get('deleteobjuser/{id}', [ObjectiveController::class, 'deleteObj'])->name('deleteobjuser');
    Route::post('update-objective', [ObjectiveController::class, 'updateObjective'])->name('update-objective');
    Route::get('objective-manage', [ObjectiveController::class, 'objectiveManage'])->name('objective-manage');
    Route::get('objective-manage-new', [ObjectiveController::class, 'objectiveManageNew'])->name('objective-manage-new');
    Route::get('update-user-obj', [ObjectiveController::class, 'updateUserObj'])->name('update-user-obj');
    Route::get('objective-create', [ObjectiveController::class, 'create'])->name('objective-create');
    Route::post('store-form-objective', [ObjectiveController::class, 'storeObjective'])->name('store-form-objective');
    Route::post('rate', [ObjectiveController::class, 'Rate'])->name('rate');
    Route::get('rating/{id}/{dataid}/{Val}', [ObjectiveController::class, 'Rating'])->name('rating');
    Route::get('myproductsDeleteAll', [ObjectiveController::class, 'deleteAll'])->name('myproductsDeleteAll');
    
    //Role
    Route::get('role-create', [RoleController::class, 'roleCreate'])->name('role-create');
    Route::get('role-manage-new', [RoleController::class, 'roleManage'])->name('role-manage-new');
    Route::get('role-manage-neww', [RoleController::class, 'roleManagew'])->name('role-manage-neww');
    Route::post('roles-create', [RoleController::class, 'createRole'])->name('roles-create');
    Route::post('roles-manage-ajax', [RoleController::class, 'roleManageAjax'])->name('roles-manage-ajax');
    Route::get('/ajax/{id}', [RoleController::class, 'ajax'])->name('ajax');
    Route::get('role/{id}', [RoleController::class, 'role'])->name('role');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');