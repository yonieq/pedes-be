<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    public static $wrap = null;
    public $status;
    public $pid;
    public $message;

    public function __construct($resource, $pid, $status, $message)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
        $this->pid = $pid;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status'                => $this->status,
            'pid'                   => $this->pid,
            'complaint'             => $this->resource,
            'message'               => $this->message,
        ];
    }
}