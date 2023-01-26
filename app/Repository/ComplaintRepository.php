<?php

namespace App\Repository;

use App\Models\Complaint;

class ComplaintRepository
{
    public function getComplaints()
    {
        $complaints = Complaint::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(10);

        return $complaints;
    }

    public function getComplaintWithId($id)
    {
        $complaint = Complaint::where('user_id', auth()->user()->id)->where('id', $id)->first();

        return $complaint;
    }

    public function store($request)
    {
        $complaint = Complaint::create([
            'user_id'               => auth()->user()->id,
            'category_complaint_id' => $request->category_complaint_id,
            'title'                 => $request->title,
            'description'           => $request->description,
            'status'                => 'Waiting',
            'latitude'              => $request->latitude,
            'longitude'             => $request->longitude,
        ]);

        return $complaint;
    }
}