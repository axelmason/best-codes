<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModerateController extends Controller
{
    public function adminPage()
    {
        return view('dashboard.employees');
    }

    public function employeesList()
    {
        $employees = User::where('role_id', User::MODERATE_ROLE_ID)
            ->withCount(['moderate_codes AS new_count' => function ($query) {
                $query->where('moderate_status', 'new');
            },'moderate_codes AS in_work_count' => function ($query) {
                $query->where('moderate_status', 'in_work');
            }, 'moderate_codes AS accepted_count' => function ($query) {
                $query->where('moderate_status', 'accepted');
            }, 'moderate_codes AS rejected_count' => function ($query) {
                $query->where('moderate_status', 'rejected');
            }])->with('role')
            ->get(['id', 'name', 'email', 'new_count', 'in_work_count', 'accepted_count']);

        return response()->json($employees, 200);
    }

    public function moderatePage()
    {
        return view('dashboard.moderate_page');
    }

    public function list()
    {
        $codes = auth()->user()->moderate_codes;
        return response()->json($codes);
    }

    public function open($code_id)
    {
        $code = Code::find($code_id);
        return view('moderate.details', compact('code'));
    }

    public function update($code_id, Request $r) {
        $result = Code::find($code_id)->update([
            'moderate_status' => $r->input('moderate_status')
        ]);

        return response()->json($result);
    }

    public function setNewModerator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $user = User::where('email', $request->email)->first();

        $user->update(['role_id' => User::MODERATE_ROLE_ID]);
        return response()->json(['success' => true, 'message' => 'Moderator role assigned.']);
    }

    public function unsetModerator(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update(['role_id' => 1]);
        return response()->json(['success' => true, 'message' => 'Moderator role unassigned.']);
    }

}
