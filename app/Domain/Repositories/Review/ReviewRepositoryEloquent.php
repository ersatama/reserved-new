<?php


namespace App\Domain\Repositories\Review;

use App\Domain\Contracts\MainContract;
use App\Models\Review;
use App\Domain\Contracts\ReviewContract;
use Illuminate\Support\Facades\DB;

class ReviewRepositoryEloquent implements ReviewRepositoryInterface
{
    private $take   =   15;
    public function create($data)
    {
        return Review::create($data);
    }

    public function update($id,$data)
    {
        return Review::where(ReviewContract::ID,$id)->update([
            ReviewContract::RATING  =>  $data[ReviewContract::RATING],
            ReviewContract::COMMENT =>  $data[ReviewContract::COMMENT],
        ]);
    }

    public function delete($id):void
    {
        Review::where(ReviewContract::ID,$id)->update([
            ReviewContract::STATUS  =>  ReviewContract::DISABLED
        ]);
    }

    public function getCountByOrganizationId($organizationId)
    {
        $reviews    =   Review::where([
            [ReviewContract::ORGANIZATION_ID,$organizationId],
            [ReviewContract::STATUS,ReviewContract::ENABLED],
        ])->orWhere([
            [ReviewContract::ORGANIZATION_ID,$organizationId],
            [ReviewContract::STATUS,ReviewContract::CHECKING],
        ])->get();
        return sizeof($reviews);
    }

    public function getByOrganizationId($id,$paginate)
    {
        return Review::with('organization','user')
            ->where(MainContract::ORGANIZATION_ID,$id)
            ->orderBy(MainContract::ID,MainContract::DESC)
            ->skip(--$paginate * $this->take)
            ->take($this->take)
            ->get();
    }

    public function getByUserId($id,$paginate)
    {
        return Review::with('organization','user')
            ->where(MainContract::USER_ID,$id)->skip(--$paginate * $this->take)->take($this->take)->get();
    }

    public function getGroupByOrganizationId($organizationId)
    {
        return DB::table(ReviewContract::TABLE)
            ->select(MainContract::RATING,DB::raw('count(*) as total'))
            ->where(MainContract::ORGANIZATION_ID,$organizationId)
            ->groupBy(MainContract::RATING)
            ->get();
    }

    public function getById($id)
    {
        return Review::with('organization','user')->where(ReviewContract::ID,$id)->first();
    }

    public function sumRating($id)
    {
        $reviews    =   Review::select(ReviewContract::RATING)->where([
            [ReviewContract::ORGANIZATION_ID,$id],
            [ReviewContract::STATUS,ReviewContract::ENABLED]
        ])->get();
        if (sizeof($reviews)>0) {
            $count      =   0;
            $sum        =   0;
            foreach ($reviews as &$review) {
                $sum    +=  $review->rating;
                $count++;
            }
            return round(($sum/$count),1);
        }
        return null;
    }
}
