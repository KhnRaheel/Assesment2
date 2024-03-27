<?php

namespace App\Http\Controllers;

use App\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the timesheets.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->only(['task_name', 'date', 'hours', 'user_id', 'project_id']);
        $timesheets = Timesheet::filter($filters)->get();

        return response()->json($timesheets);
    }

    /**
     * Store a newly created timesheet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_name' => 'required',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:1',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        $timesheet = Timesheet::create($validatedData);

        return response()->json($timesheet, 201);
    }

    /**
     * Display the specified timesheet.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timesheet = Timesheet::findOrFail($id);

        return response()->json($timesheet);
    }

    /**
     * Update the specified timesheet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'task_name' => 'sometimes|required',
            'date' => 'sometimes|required|date',
            'hours' => 'sometimes|required|numeric|min:1',
            'user_id' => 'sometimes|required|exists:users,id',
            'project_id' => 'sometimes|required|exists:projects,id',
        ]);

        $timesheet = Timesheet::findOrFail($id);
        $timesheet->update($validatedData);

        return response()->json($timesheet);
    }

    /**
     * Remove the specified timesheet from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->delete();

        return response()->json(['message' => 'Timesheet deleted successfully']);
    }
}