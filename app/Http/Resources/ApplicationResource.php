<?php
namespace App\Http\Resources;

use App\Models\Pic;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        $user = Auth::user();
        $companies = Company::whereIn('short_name', explode(', ', $this->company))->get();
        
        $baseData = [
            'id' => $this->id,
            'slug' => $this->slug,
            'short_name' => $this->short_name,
            'long_name' => $this->long_name,
            'url_prod' => $this->url_prod,
            'url_dev' => $this->url_dev,
            'description' => $this->description,
            'status' => $this->status,
            'image' => $this->image ? url($this->image) : null,
            'category' => $this->category,
            'tier' => $this->tier,
            'platform' => $this->platform,
            'user_login' => $this->user_login,
            'group_area' => new GroupAreaResource($this->groupArea),
            'company' => CompanyResource::collection($companies),
            'user_doc' => $this->user_doc,
            'reviews' => $this->whenLoaded('reviews', function () {
                return collect($this->reviews)->map(function($review){
                    return [
                        'id' => $review->id,
                        'review_text' => $review->review_text,
                        'user_id' => $review->user_id,
                        'rating' => $review->rating,
                        'created_at' => $review->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $review->updated_at->format('Y-m-d H:i:s'),
                        'reviewer' => [
                            'id' => $review->reviewer->id,
                            'name' => $review->reviewer->name,
                            'email' => $review->reviewer->email,
                        ],
                    ];
                });
            }),
            'total_review' => $this->whenLoaded('reviews', function() {
                return count($this->reviews);
            }),
            'total_rating' => $this->whenLoaded('reviews', function() {
                $totalReviews = count($this->reviews);
                if ($totalReviews > 0) {
                    $sumRating = collect($this->reviews)->sum('rating');
                    return $sumRating / $totalReviews;
                }
                return 0; 
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null
        ];

        if (is_null($user)){    
            return $baseData;   
        }

        switch ($user->role){
            case 'admin':
            case 'teknisi':
                $companies = Company::whereIn('short_name', explode(', ', $this->company))->get();
                return array_merge($baseData, [
                    'vm_prod' => $this->vm_prod,
                    'vm_dev' => $this->vm_dev,
                    'business_process' => $this->business_process,
                    'technical_doc' => $this->technical_doc,
                    'other_doc' => $this->other_doc,
                    'db_connection_path' => $this->db_connection_path,
                    'sap_connection_path' => $this->sap_connection_path,
                    'ad_connection_path' => $this->ad_connection_path,
                    'information' => $this->information,
                    'company' => CompanyResource::collection($companies),
                    'old_pics' => PicResource::collection($this->getPicByType('old_pic')),
                    'first_pics' => PicResource::collection($this->getPicByType('first_pic')),
                    'backup_pics' => PicResource::collection($this->getPicByType('backup_pic')),
                    'pic_icts' => PicResource::collection($this->getPicByType('pic_ict')),
                    'pic_users' => PicResource::collection($this->getPicByType('pic_user')),
                    'topology' => TopologyResource::collection($this->topologies),
                    'technology' => TechnologyResource::collection($this->technologies),
                    'virtual_machines' => VirtualMachineResource::collection($this->virtual_machines)
                ]);
            case 'reporter':
                $companies = Company::whereIn('short_name', explode(', ', $this->company))->get();
                return array_merge($baseData, [
                    'old_pics' => PicResource::collection($this->getPicByType('old_pic')),
                    'first_pics' => PicResource::collection($this->getPicByType('first_pic')),
                    'backup_pics' => PicResource::collection($this->getPicByType('backup_pic')),
                    'pic_icts' => PicResource::collection($this->getPicByType('pic_ict')),
                    'pic_users' => PicResource::collection($this->getPicByType('pic_user')),
                    'business_process' => $this->business_process,
                    'company' => CompanyResource::collection($companies)
                ]);
            case 'client':
            default:
                return $baseData;
        }
    }
}
