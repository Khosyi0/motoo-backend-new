<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {

        // $companies = explode(', ', $this->company);
        $companies = Company::whereIn('short_name', explode(', ', $this->company))->get();


        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'photo'         => $this->photo,
            'email'         => $this->email,
            'role'          => $this->role,
            'job'           => $this->job,

            //multi company
            'company' => CompanyResource::collection($companies),

            'team'          => $this->team,
            'phone'         => $this->phone,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'    => $this->updated_at->format('Y-m-d H:i:s'),
            'deleted_at'    => $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            // 'is_2fa_enabled' => $this->is_2fa_enabled,
            'status'        => $this->status,
        ];
    }
}
