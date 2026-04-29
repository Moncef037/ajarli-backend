<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\Attachment;
use App\Models\ConstructionAttachmentOrder;
use App\Models\ConstructionAttachmentOrderMatch;
use App\Models\ConstructionEquipmentOrder;
use App\Models\Equipment;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ConstructionEquipmentOrderMatch;
use App\Models\ConstructionVehicleOrder;
use App\Models\ConstructionVehicleOrderMatch;
use App\Models\TransportationVehicleOrder;
use App\Models\TransportationVehicleOrderMatch;

class AdminController extends Controller
{
    // /**
    //  * Create an admin user
    //  *
    //  * This endpoint lets you create an admin user.
    //  * @header Content-Type multipart/form-data
    //  * @unauthenticated
    //  */
    // public function admin_sign_up(Request $request) {
    //     $fields = $request->validate([
    //         'first_name' => ['required', 'string'],
    //         'last_name' => ['required', 'string'],
    //         'email' => ['required', 'string', 'email', 'unique:users,email'],
    //         'password' => ['required', 'string', 'min:8'],
    //         'phone' => ['required', 'string'],
    //         'user_type' => ['required', 'string', 'in:admin'],
    //         'receive_notifications_from' => ['required', 'string', 'in:none'],
    //         'profile_picture' => ['image'],
    //     ]);

    //     $user = User::create([
    //         'first_name' => $fields['first_name'],
    //         'last_name' => $fields['last_name'],
    //         'email' => $fields['email'],
    //         'phone' => $fields['phone'],
    //         'user_type' => $fields['user_type'],
    //         'receive_notifications_from' => $fields['receive_notifications_from'],
    //         'password' => Hash::make($fields['password']),
    //     ]);

    //     if ($request->hasFile('profile_picture')) {
    //         $profile_picture = $request->file('profile_picture');
    //         $path = $profile_picture->store('public/users/pfps');
    //         $user->profile_picture = $path;
    //         $user->save();
    //     }

    //     return response()->json($user, 201);
    // }

    /**
     * Sign an admin user in
     *
     * This endpoint lets an admin user sign in.
     * @unauthenticated
     */
    public function admin_sign_in(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password) || !$user->isAdmin()) {
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $token,
            'message' => 'Login successful',
        ], 200);
    }
        
    /**
     * Edit approval status of a vehicle
     *
     * This endpoint changes the approval status of a vehicle.
     */
    public function editApprovalStatusOfVehicle(Request $request, string $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $fields = $request->validate([
            'approval_status' => ['required', 'in:approved,not_approved']
        ]);

        $vehicle->update(['approval_status' => $fields['approval_status']]);

        return response()->json([
            'message' => 'Approval status changed successfully'
        ]);
    }

    /**
     * Edit approval status of an equipment
     *
     * This endpoint changes the approval status of an equipment.
     */
    public function editApprovalStatusOfEquipment(Request $request, string $id)
    {
        $equipment = Equipment::findOrFail($id);

        $fields = $request->validate([
            'approval_status' => ['required', 'in:approved,not_approved']
        ]);

        $equipment->update(['approval_status' => $fields['approval_status']]);

        return response()->json([
            'message' => 'Approval status changed successfully'
        ]);
    }

    /**
     * Edit approval status of an attachment
     *
     * This endpoint changes the approval status of an attachment.
     */
    public function editApprovalStatusOfAttachment(Request $request, string $id)
    {
        $attachment = Attachment::findOrFail($id);

        $fields = $request->validate([
            'approval_status' => ['required', 'in:approved,not_approved']
        ]);

        $attachment->update(['approval_status' => $fields['approval_status']]);

        return response()->json([
            'message' => 'Approval status changed successfully'
        ]);
    }

    /**
     * Get all users
     *
     * This endpoint retrieves all non admin users.
     */
    public function listUsers()
    {
        $users = User::where("user_type", "!=", "admin")->get();

        return response()->json($users);
    }

    /**
     * Get a user by id
     * 
     * This endpoint retrieves a user by id.
     */
    public function getUserById(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        return response()->json($user->load('documents'));
    }

    /**
     * Get all vehicles
     * 
     * This endpoint retrieves all vehicles.
     */
    public function listVehicles()
    {
        $vehicles = Vehicle::all();

        return response()->json($vehicles);
    }

    /**
     * Get a vehicle by id
     * 
     * This endpoint retrieves a vehicle by id.
     */
    public function getVehicleById(Request $request, string $id)
    {
        $vehicle = Vehicle::with('category', 'subCategory', 'user', 'photos', 'documents', 'attachments', 'attachments.subCategory')->findOrFail($id);

        return response()->json($vehicle);
    }

    /**
     * Get a vehicle's user
     * 
     * This endpoint retrieves a vehicle's user.
     */
    public function getVehicleUser(Request $request, string $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $user = $vehicle->user;

        return response()->json($user->load('documents'));
    }

    /**
     * Get all equipments
     * 
     * This endpoint retrieves all equipments.
     */
    public function listEquipments()
    {
        $equipments = Equipment::all();

        return response()->json($equipments);
    }

    /**
     * Get an equipment by id
     * 
     * This endpoint retrieves an equipment by id.
     */
    public function getEquipmentById(Request $request, string $id)
    {
        $equipment = Equipment::with('category', 'subCategory', 'user', 'photos', 'documents')->findOrFail($id);

        return response()->json($equipment);
    }

    /**
     * Get an equipment's user
     * 
     * This endpoint retrieves an equipment's user.
     */
    public function getEquipmentUser(Request $request, string $id)
    {
        $equipment = Equipment::findOrFail($id);

        $user = $equipment->user;

        return response()->json($user->load('documents'));
    }

    /**
     * Get all attachments
     * 
     * This endpoint retrieves all attachments.
     */
    public function listAttachments()
    {
        $attachments = Attachment::all();

        return response()->json($attachments);
    }

    /**
     * Get an attachment by id
     * 
     * This endpoint retrieves an attachment by id.
     */
    public function getAttachmentById(Request $request, string $id)
    {
        $attachment = Attachment::with('subCategory', 'user', 'photos', 'documents')->findOrFail($id);

        return response()->json($attachment);
    }

    /**
     * Get an attachment's user
     * 
     * This endpoint retrieves an attachment's user.
     */
    public function getAttachmentUser(Request $request, string $id)
    {
        $attachment = Attachment::findOrFail($id);

        $user = $attachment->user;

        return response()->json($user->load('documents'));
    }

    /**
     * Get all construction vehicle orders
     * 
     * This endpoint retrieves all construction vehicle orders.
     */
    public function listConstructionVehicleOrders()
    {
        $constructionVehicleOrders = ConstructionVehicleOrder::with('subCategory', 'photos', 'attachments', 'attachments.subCategory', 'user')->get();

        return response()->json($constructionVehicleOrders);
    }

    /**
     * Get all construction equipment orders
     * 
     * This endpoint retrieves all construction equipment orders.
     */
    public function listConstructionEquipmentOrders()
    {
        $constructionEquipmentOrders = ConstructionEquipmentOrder::with('subCategory', 'photos', 'user')->get();

        return response()->json($constructionEquipmentOrders);
    }

    /**
     * Get all construction attachment orders
     * 
     * This endpoint retrieves all construction attachment orders.
     */
    public function listConstructionAttachmentOrders()
    {
        $constructionAttachmentOrders = ConstructionAttachmentOrder::with('subCategory', 'photos', 'user')->get();

        return response()->json($constructionAttachmentOrders);
    }

    /**
     * Get all transportation vehicle orders
     * 
     * This endpoint retrieves all transportation vehicle orders.
     */
    public function listTransportationVehicleOrders()
    {
        $transportationVehicleOrders = TransportationVehicleOrder::with('subCategory', 'photos', 'user')->get();

        return response()->json($transportationVehicleOrders);
    }
    
    /**
     * Get construction vehicle order by id
     * 
     * This endpoint retrieves a construction vehicle order by id.
     */
    public function getConstructionVehicleOrderById(Request $request, string $id)
    {
        $constructionVehicleOrder = ConstructionVehicleOrder::with('subCategory', 'photos', 'attachments', 'attachments.subCategory', 'user')->findOrFail($id);

        return response()->json($constructionVehicleOrder);
    }

    /**
     * Get construction equipment order by id
     * 
     * This endpoint retrieves a construction equipment order by id.
     */
    public function getConstructionEquipmentOrderById(Request $request, string $id)
    {
        $constructionEquipmentOrder = ConstructionEquipmentOrder::with('subCategory', 'photos', 'user')->findOrFail($id);

        return response()->json($constructionEquipmentOrder);
    }

    /**
     * Get construction attachment order by id
     * 
     * This endpoint retrieves a construction attachment order by id.
     */
    public function getConstructionAttachmentOrderById(Request $request, string $id)
    {
        $constructionAttachmentOrder = ConstructionAttachmentOrder::with('subCategory', 'photos', 'user')->findOrFail($id);

        return response()->json($constructionAttachmentOrder);
    }

    /**
     * Get transportation vehicle order by id
     * 
     * This endpoint retrieves a transportation vehicle order by id.
     */
    public function getTransportationVehicleOrderById(Request $request, string $id)
    {
        $transportationVehicleOrder = TransportationVehicleOrder::with('subCategory', 'photos', 'user')->findOrFail($id);

        return response()->json($transportationVehicleOrder);
    }

    /**
     * Get all construction vehicle matches
     * 
     * This endpoint retrieves all construction vehicle matches.
     */
    public function listConstructionVehicleMatches()
    {
        $constructionVehicleMatches = ConstructionVehicleOrderMatch::with('order.user', 'order.subCategory', 'provider')->get();

        return response()->json($constructionVehicleMatches);
    }

    /**
     * Get all construction equipment matches
     * 
     * This endpoint retrieves all construction equipment matches.
     */
    public function listConstructionEquipmentMatches()
    {
        $constructionEquipmentMatches = ConstructionEquipmentOrderMatch::with('order.user', 'order.subCategory', 'provider')->get();

        return response()->json($constructionEquipmentMatches);
    }

    /**
     * Get all construction attachment matches
     * 
     * This endpoint retrieves all construction attachment matches.
     */
    public function listConstructionAttachmentMatches()
    {
        $constructionAttachmentMatches = ConstructionAttachmentOrderMatch::with('order.user', 'order.subCategory', 'provider')->get();

        return response()->json($constructionAttachmentMatches);
    }

    /**
     * Get all transportation vehicle matches
     * 
     * This endpoint retrieves all transportation vehicle matches.
     */
    public function listTransportationVehicleMatches()
    {
        $transportationVehicleMatches = TransportationVehicleOrderMatch::with('order.user', 'order.subCategory', 'provider')->get();

        return response()->json($transportationVehicleMatches);
    }

    /**
     * Get construction vehicle order match by id
     * 
     * This endpoint retrieves a construction vehicle order match by its id.
     */
    public function getConstructionVehicleOrderMatchById(Request $request, string $id)
    {
        $match = ConstructionVehicleOrderMatch::with('order', 'order.user', 'order.photos', 'order.subCategory', 'order.attachments', 'order.attachments.subCategory', 'provider', 'attachments', 'attachments.attachment', 'attachments.attachment.subCategory')->findOrFail($id);

        return response()->json($match);
    }

    /**
     * Get construction equipment order match by id
     * 
     * This endpoint retrieves a construction equipment order match by its id.
     */
    public function getConstructionEquipmentOrderMatchById(Request $request, string $id)
    {
        $match = ConstructionEquipmentOrderMatch::with('order', 'order.user', 'order.photos', 'order.subCategory', 'provider', 'constructionEquipment')->findOrFail($id);

        return response()->json($match);
    }

    /**
     * Get construction attachment order match by id
     * 
     * This endpoint retrieves a construction attachment order match by its id.
     */
    public function getConstructionAttachmentOrderMatchById(Request $request, string $id)
    {
        $match = ConstructionAttachmentOrderMatch::with('order', 'order.user', 'order.photos', 'order.subCategory', 'provider', 'constructionAttachment')->findOrFail($id);

        return response()->json($match);
    }

    /**
     * Get transportation attachment order match by id
     * 
     * This endpoint retrieves a transportation attachment order match by its id.
     */
    public function getTransportationVehicleOrderMatchById(Request $request, string $id)
    {
        $match = TransportationVehicleOrderMatch::with('order', 'order.user', 'order.photos', 'order.subCategory', 'provider', 'transportationVehicle')->findOrFail($id);

        return response()->json($match);
    }
}