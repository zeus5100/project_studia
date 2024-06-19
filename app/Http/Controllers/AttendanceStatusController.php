<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceStatusRequest;
use App\Models\AttendanceStatus;
use Inertia\Inertia;

class AttendanceStatusController extends Controller
{
    public function index()
    {
        return response()->json(AttendanceStatus::select('id', 'name', 'created_at', 'updated_at')
            ->paginate(10));
    }

    public function select()
    {
        return response()->json(AttendanceStatus::select('id', 'name')->get());
    }

    public function edit(AttendanceStatus $attendanceStatus)
    {
        return Inertia::render('Auth/AttendanceStatus/Edit', [
            'status' => $attendanceStatus,
        ]);
    }

    public function update(AttendanceStatusRequest $request, AttendanceStatus $attendanceStatus)
    {
        $attendanceStatus->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'attendanceStatuses'])->with('notification', 'stan frekwencji');
    }

    public function destroy(AttendanceStatus $attendanceStatus)
    {
        $attendanceStatus->delete();

        return response()->json(['message' => 'Stan frekwencji został pomyślnie usunięty']);
    }
}
