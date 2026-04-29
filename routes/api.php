<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConstructionAttachmentOrderController;
use App\Http\Controllers\ConstructionAttachmentOrderMatchController;
use App\Http\Controllers\ConstructionEquipmentOrderController;
use App\Http\Controllers\ConstructionEquipmentOrderMatchController;
use App\Http\Controllers\ConstructionVehicleOrderController;
use App\Http\Controllers\ConstructionVehicleOrderMatchController;
use App\Http\Controllers\EquipmentCategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SuccessfullyRentedConstructionAttachmentController;
use App\Http\Controllers\SuccessfullyRentedConstructionEquipmentController;
use App\Http\Controllers\SuccessfullyRentedConstructionVehicleController;
use App\Http\Controllers\SuccessfullyRentedTransportationVehicleController;
use App\Http\Controllers\TransportationVehicleOrderController;
use App\Http\Controllers\TransportationVehicleOrderMatchController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/user-info', [AuthController::class, 'user_info'])->middleware('auth:sanctum');
Route::post('/update-user', [AuthController::class, 'update_user'])->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'sign_up']);
    Route::post('/signin', [AuthController::class, 'sign_in']);
    Route::post('/signout', [AuthController::class, 'sign_out'])->middleware('auth:sanctum');
    Route::post('/email-verification-code/send', [AuthController::class, 'sendEmailVerificationCode']);
    Route::post('/email-verification-code/verify', [AuthController::class, 'verifyEmailCode']);
    Route::delete('/delete-account', [AuthController::class, 'delete_user'])->middleware('auth:sanctum');
    
    Route::post('/forgot-password-code/send', [AuthController::class, 'sendForgotPasswordCode']);
    Route::post('/forgot-password-code/verify', [AuthController::class, 'verifyForgotPasswordCode']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);

    Route::post('/password/update', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');
});

Route::post('/vehicles', [VehicleController::class, 'submitVehicle'])->middleware(['auth:sanctum', 'auth.provider']);
Route::get('/vehicles/{id}', [VehicleController::class, 'showVehicle'])->whereNumber('id')->middleware('auth:sanctum');
Route::put('/edit-vehicle-activity-status/{id}', [VehicleController::class, 'editActivityStatusOfVehicle'])->whereNumber('id')->middleware('auth:sanctum');

Route::post('/equipments', [EquipmentController::class, 'submitEquipment'])->middleware(['auth:sanctum', 'auth.provider']);
Route::get('/equipments/{id}', [EquipmentController::class, 'showEquipment'])->whereNumber('id')->middleware('auth:sanctum');
Route::put('/edit-equipment-activity-status/{id}', [EquipmentController::class, 'editActivityStatusOfEquipment'])->whereNumber('id')->middleware('auth:sanctum');

Route::post('/attachments', [AttachmentController::class, 'submitAttachment'])->middleware(['auth:sanctum', 'auth.provider']);
Route::get('/attachments/{id}', [AttachmentController::class, 'showAttachment'])->whereNumber('id')->middleware('auth:sanctum');
Route::put('/edit-attachment-activity-status/{id}', [AttachmentController::class, 'editActivityStatusOfAttachment'])->whereNumber('id')->middleware('auth:sanctum');

Route::get('/vehicle-categories', [VehicleCategoryController::class, 'showAllVehicleCategories']);
Route::get('/vehicle-categories/{id}', [VehicleCategoryController::class, 'showSubCategories'])->whereNumber('id');
Route::get('/vehicle-sub-categories/{id}', [VehicleCategoryController::class, 'showSubCategory'])->whereNumber('id');

Route::get('/equipment-categories', [EquipmentCategoryController::class, 'showAllEquipmentCategories']);
Route::get('/equipment-categories/{id}', [EquipmentCategoryController::class, 'showSubCategories'])->whereNumber('id');
Route::get('/equipment-sub-categories/{id}', [EquipmentCategoryController::class, 'showSubCategory'])->whereNumber('id');

Route::post('/construction-vehicle-orders', [ConstructionVehicleOrderController::class, 'submitOrder'])->middleware(['auth:sanctum', 'auth.renter']);
Route::post('/construction-equipment-orders', [ConstructionEquipmentOrderController::class, 'submitOrder'])->middleware(['auth:sanctum', 'auth.renter']);
Route::post('/construction-attachment-orders', [ConstructionAttachmentOrderController::class, 'submitOrder'])->middleware(['auth:sanctum', 'auth.renter']);
Route::post('/transportation-vehicle-orders', [TransportationVehicleOrderController::class, 'submitOrder'])->middleware(['auth:sanctum', 'auth.renter']);

Route::post('construction-vehicle-order-matches/negotiate/{id}', [ConstructionVehicleOrderMatchController::class, 'negotiate'])->whereNumber('id')->middleware('auth:sanctum');
Route::post('construction-equipment-order-matches/negotiate/{id}', [ConstructionEquipmentOrderMatchController::class, 'negotiate'])->whereNumber('id')->middleware('auth:sanctum');
Route::post('construction-attachment-order-matches/negotiate/{id}', [ConstructionAttachmentOrderMatchController::class, 'negotiate'])->whereNumber('id')->middleware('auth:sanctum');
Route::post('transportation-vehicle-order-matches/negotiate/{id}', [TransportationVehicleOrderMatchController::class, 'negotiate'])->whereNumber('id')->middleware('auth:sanctum');

Route::put('construction-vehicle-order-matches/accept/{id}', [ConstructionVehicleOrderMatchController::class, 'accept'])->whereNumber('id')->middleware('auth:sanctum');
Route::put('construction-equipment-order-matches/accept/{id}', [ConstructionEquipmentOrderMatchController::class, 'accept'])->whereNumber('id')->middleware('auth:sanctum');
Route::put('construction-attachment-order-matches/accept/{id}', [ConstructionAttachmentOrderMatchController::class, 'accept'])->whereNumber('id')->middleware('auth:sanctum');
Route::put('transportation-vehicle-order-matches/accept/{id}', [TransportationVehicleOrderMatchController::class, 'accept'])->whereNumber('id')->middleware('auth:sanctum');

Route::delete('construction-vehicle-order-matches/cancel/{id}', [ConstructionVehicleOrderMatchController::class, 'cancel'])->whereNumber('id')->middleware('auth:sanctum');
Route::delete('construction-equipment-order-matches/cancel/{id}', [ConstructionEquipmentOrderMatchController::class, 'cancel'])->whereNumber('id')->middleware('auth:sanctum');
Route::delete('construction-attachment-order-matches/cancel/{id}', [ConstructionAttachmentOrderMatchController::class, 'cancel'])->whereNumber('id')->middleware('auth:sanctum');
Route::delete('transportation-vehicle-order-matches/cancel/{id}', [TransportationVehicleOrderMatchController::class, 'cancel'])->whereNumber('id')->middleware('auth:sanctum');

Route::get('construction-vehicle-order-matches/{id}', [ConstructionVehicleOrderMatchController::class, 'getOrderMatchById'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('construction-equipment-order-matches/{id}', [ConstructionEquipmentOrderMatchController::class, 'getOrderMatchById'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('construction-attachment-order-matches/{id}', [ConstructionAttachmentOrderMatchController::class, 'getOrderMatchById'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('transportation-vehicle-order-matches/{id}', [TransportationVehicleOrderMatchController::class, 'getOrderMatchById'])->whereNumber('id')->middleware('auth:sanctum');

Route::get('successfully-rented-construction-vehicles/{id}', [SuccessfullyRentedConstructionVehicleController::class, 'getSuccessfullyRentedConstructionVehicleById'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('successfully-rented-construction-equipments/{id}', [SuccessfullyRentedConstructionEquipmentController::class, 'getSuccessfullyRentedConstructionEquipmentById'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('successfully-rented-construction-attachments/{id}', [SuccessfullyRentedConstructionAttachmentController::class, 'getSuccessfullyRentedConstructionAttachmentById'])->whereNumber('id')->middleware('auth:sanctum');
Route::get('successfully-rented-transportation-vehicles/{id}', [SuccessfullyRentedTransportationVehicleController::class, 'getSuccessfullyRentedTransportationVehicleById'])->whereNumber('id')->middleware('auth:sanctum');

Route::prefix('admin')->group(function () {
    // Route::post('/signup', [AdminController::class, 'admin_sign_up']);
    Route::post('/signin', [AdminController::class, 'admin_sign_in']);

    Route::middleware(['auth:sanctum', 'auth.admin'])->group(function () {
        Route::put('/edit-vehicle-approval-status/{id}', [AdminController::class, 'editApprovalStatusOfVehicle'])->whereNumber('id');
        Route::put('/edit-equipment-approval-status/{id}', [AdminController::class, 'editApprovalStatusOfEquipment'])->whereNumber('id');
        Route::put('/edit-attachment-approval-status/{id}', [AdminController::class, 'editApprovalStatusOfAttachment'])->whereNumber('id');

        Route::get('/users', [AdminController::class, 'listUsers']);
        Route::get('/users/{id}', [AdminController::class, 'getUserById'])->whereNumber('id');

        Route::get('/vehicles', [AdminController::class, 'listVehicles']);
        Route::get('/vehicles/{id}', [AdminController::class, 'getVehicleById'])->whereNumber('id');
        Route::get('/vehicles/{id}/user', [AdminController::class, 'getVehicleUser'])->whereNumber('id');

        Route::get('/equipments', [AdminController::class, 'listEquipments']);
        Route::get('/equipments/{id}', [AdminController::class, 'getEquipmentById'])->whereNumber('id');
        Route::get('/equipments/{id}/user', [AdminController::class, 'getEquipmentUser'])->whereNumber('id');

        Route::get('/attachments', [AdminController::class, 'listAttachments']);
        Route::get('/attachments/{id}', [AdminController::class, 'getAttachmentById'])->whereNumber('id');
        Route::get('/attachments/{id}/user', [AdminController::class, 'getAttachmentUser'])->whereNumber('id');

        Route::get('/vehicle-categories', [VehicleCategoryController::class, 'showAllVehicleCategories']);
        Route::get('/vehicle-sub-categories', [VehicleCategoryController::class, 'showAllVehicleSubCategories']);
        Route::get('/vehicle-categories/{id}', [VehicleCategoryController::class, 'showSubCategories'])->whereNumber('id');
        Route::get('/vehicle-sub-categories/{id}', [VehicleCategoryController::class, 'showSubCategory'])->whereNumber('id');
        Route::get('/vehicle-categories/{id}/category', [VehicleCategoryController::class, 'showCategory'])->whereNumber('id');
        Route::put('/vehicle-categories/{id}', [VehicleCategoryController::class, 'editCategory'])->whereNumber('id');
        Route::delete('/vehicle-categories/{id}', [VehicleCategoryController::class, 'deleteCategory'])->whereNumber('id');
        Route::post('/vehicle-categories', [VehicleCategoryController::class, 'addCategory']);
        Route::post('/vehicle-sub-categories', [VehicleCategoryController::class, 'addSubCategory']);
        Route::delete('/vehicle-sub-categories/{id}', [VehicleCategoryController::class, 'deleteSubCategory'])->whereNumber('id');
        Route::post('/vehicle-sub-categories/{id}', [VehicleCategoryController::class, 'editSubCategory'])->whereNumber('id');

        Route::get('/equipment-categories', [EquipmentCategoryController::class, 'showAllEquipmentCategories']);
        Route::get('/equipment-sub-categories', [EquipmentCategoryController::class, 'showAllEquipmentSubCategories']);
        Route::get('/equipment-categories/{id}', [EquipmentCategoryController::class, 'showSubCategories'])->whereNumber('id');
        Route::get('/equipment-sub-categories/{id}', [EquipmentCategoryController::class, 'showSubCategory'])->whereNumber('id');
        Route::get('/equipment-categories/{id}/category', [EquipmentCategoryController::class, 'showCategory'])->whereNumber('id');
        Route::put('/equipment-categories/{id}', [EquipmentCategoryController::class, 'editCategory'])->whereNumber('id');
        Route::delete('/equipment-categories/{id}', [EquipmentCategoryController::class, 'deleteCategory'])->whereNumber('id');
        Route::post('/equipment-categories', [EquipmentCategoryController::class, 'addCategory']);
        Route::post('/equipment-sub-categories', [EquipmentCategoryController::class, 'addSubCategory']);
        Route::delete('/equipment-sub-categories/{id}', [EquipmentCategoryController::class, 'deleteSubCategory'])->whereNumber('id');
        Route::post('/equipment-sub-categories/{id}', [EquipmentCategoryController::class, 'editSubCategory'])->whereNumber('id');

        Route::get('/construction-vehicle-orders', [AdminController::class, 'listConstructionVehicleOrders']);
        Route::get('/construction-equipment-orders', [AdminController::class, 'listConstructionEquipmentOrders']);
        Route::get('/construction-attachment-orders', [AdminController::class, 'listConstructionAttachmentOrders']);
        Route::get('/transportation-vehicle-orders', [AdminController::class, 'listTransportationVehicleOrders']);

        Route::get('/construction-vehicle-orders/{id}', [AdminController::class, 'getConstructionVehicleOrderById'])->whereNumber('id');
        Route::get('/construction-equipment-orders/{id}', [AdminController::class, 'getConstructionEquipmentOrderById'])->whereNumber('id');
        Route::get('/construction-attachment-orders/{id}', [AdminController::class, 'getConstructionAttachmentOrderById'])->whereNumber('id');
        Route::get('/transportation-vehicle-orders/{id}', [AdminController::class, 'getTransportationVehicleOrderById'])->whereNumber('id');

        Route::get('/construction-vehicle-order-matches', [AdminController::class, 'listConstructionVehicleMatches']);
        Route::get('/construction-equipment-order-matches', [AdminController::class, 'listConstructionEquipmentMatches']);
        Route::get('/construction-attachment-order-matches', [AdminController::class, 'listConstructionAttachmentMatches']);
        Route::get('/transportation-vehicle-order-matches', [AdminController::class, 'listTransportationVehicleMatches']);

        Route::get('construction-vehicle-order-matches/{id}', [AdminController::class, 'getConstructionVehicleOrderMatchById'])->whereNumber('id')->middleware('auth:sanctum');
        Route::get('construction-equipment-order-matches/{id}', [AdminController::class, 'getConstructionEquipmentOrderMatchById'])->whereNumber('id')->middleware('auth:sanctum');
        Route::get('construction-attachment-order-matches/{id}', [AdminController::class, 'getConstructionAttachmentOrderMatchById'])->whereNumber('id')->middleware('auth:sanctum');
        Route::get('transportation-vehicle-order-matches/{id}', [AdminController::class, 'getTransportationVehicleOrderMatchById'])->whereNumber('id')->middleware('auth:sanctum');
    });
});

Route::get('/provider-machines', [MachineController::class, 'providerMachines'])->middleware(['auth:sanctum', 'auth.provider']);
Route::get('/renter-machines', [MachineController::class, 'renterMachines'])->middleware(['auth:sanctum', 'auth.renter']);
Route::put('/change-activity-status', [MachineController::class, 'changeActivityStatus'])->middleware(['auth:sanctum', 'auth.provider']);

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'getNotifications'])->middleware('auth:sanctum');
    Route::get('/unread', [NotificationController::class, 'getUnreadNotifications'])->middleware('auth:sanctum');
    Route::put('/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->whereNumber('id')->middleware('auth:sanctum');
    Route::put('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->middleware('auth:sanctum');
});

Route::prefix('feedbacks')->group(function () {
    Route::get('/', [FeedbackController::class, 'index']);
    Route::post('/', [FeedbackController::class, 'submitFeedback'])->middleware('auth:sanctum');
    Route::get('/{id}', [FeedbackController::class, 'showFeedback'])->whereNumber('id');
    Route::put('/{id}', [FeedbackController::class, 'editFeedback'])->whereNumber('id')->middleware('auth:sanctum');
    Route::delete('/{id}', [FeedbackController::class, 'deleteFeedback'])->whereNumber('id')->middleware('auth:sanctum');
    Route::get('/recipient/{id}', [FeedbackController::class, 'recipientFeedbacks'])->whereNumber('id');
    Route::get('/author/{id}', [FeedbackController::class, 'authorFeedbacks'])->whereNumber('id');
    Route::get('/recipient/{id}/average-rating', [FeedbackController::class, 'getRecipientAverageRating'])->whereNumber('id');
});
