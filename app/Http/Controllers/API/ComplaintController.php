<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\ComplaintRequest;
use App\Repository\ComplaintRepository;
use App\Http\Resources\API\ComplaintResource;
use Symfony\Component\HttpFoundation\Response;

class ComplaintController extends Controller
{
    //
    protected $complaintRepository;
    public function __construct(ComplaintRepository $complaintRepository)
    {
        $this->middleware('auth:api');
        $this->complaintRepository = $complaintRepository;
    }

    public function index()
    {
        if ($this->complaintRepository->getComplaints()->isEmpty()) {
            return new ComplaintResource(null, 'Complaint', Response::HTTP_OK, 'You have not made a complaint');
        } else {
            $complaints = $this->complaintRepository->getComplaints();
            return new ComplaintResource($complaints, 'Complaint', Response::HTTP_OK, 'Data fetched successfully');
        }
    }

    public function store(ComplaintRequest $request)
    {
        try {
            $complaint = $this->complaintRepository->store($request);
            return new ComplaintResource($complaint, 'Complaint', Response::HTTP_CREATED, 'Data stored successfully');
        } catch (\Throwable $th) {
            return new ComplaintResource(null, 'Complaint', Response::HTTP_INTERNAL_SERVER_ERROR, 'Data stored failed');
        }
    }

    public function show($id)
    {
        $complaint = $this->complaintRepository->getComplaintWithId($id);
        return new ComplaintResource($complaint, 'Complaint', Response::HTTP_OK, 'Data fetched successfully');
    }
}