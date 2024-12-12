<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LakM\Reviewer\Data\ReviewData;
use LakM\Reviewer\ModelResolver;
use LakM\Reviewer\Models\Review;
use Lunar\Models\Product as LunarProduct;


class Reviewable extends LunarProduct
{
    public function currentUserHasReviewed(): bool
    {
        return $this
            ->reviews()
            ->whereMorphedTo('owner', Auth::user())
            ->exists();
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(ModelResolver::reviewClass(), 'reviewable');
    }

    public function reviewStats(): MorphOne
    {
        return $this->morphOne(ModelResolver::reviewStatsClass(), 'reviewable');
    }

//    public function media(): HasManyThrough
//    {
//        return $this->hasManyThrough(
//            ModelResolver::mediaClass(),
//            ModelResolver::reviewClass(),
//            'reviewable_id',
//            'model_id'
//        )
//            ->where('reviewable_type', $this->getMorphClass())
//            ->where('media.model_type', (new Review())->getMorphClass());
//    }

    /**
     * @param  array|ReviewData  $data
     * @return Review
     */
    public function createReview(array|ReviewData $data): Review
    {
        if (is_array($data)) {
            $data = ReviewData::fromArray($data);
        }

        return DB::transaction(function () use ($data) {
            $payload = $data->toArray();
            unset($payload['media']);
            unset($payload['id']);

            if (!$this->isSubRatingEnabled()) {
                unset($payload['sub_ratings']);
            }

            if (!$this->isShowCountryEnabled()) {
                unset($payload['country_code']);
            }

            /** @var Review $review */
            $review = $this->reviews()->create($payload);
            $review->load('reviewable');

            return $review;
        });
    }

    public function updateReview(array|ReviewData $data): Review
    {
        if (is_array($data)) {
            $data = ReviewData::fromArray($data);
        }

        $payload = $data->toArray();

        unset(
            $payload['media'],
            $payload['id'],
            $payload['reviewable_id'],
            $payload['reviewable_type']
        );

        if (!$this->isSubRatingEnabled()) {
            unset($payload['sub_ratings']);
        }

        if (!$this->isShowCountryEnabled()) {
            unset($payload['country_code']);
        }

        $review = $this->reviews()
            ->with('reviewable')
            ->where('owner_id', $data->owner_id)
            ->where('owner_type', $data->owner_type)
            ->firstOrFail();

        $review
            ->update($payload);

        return $review;
    }

    public function deleteReview(Review $review): void
    {
        $review->load('reviewable');
        $review->delete();
    }

    public function subRatingTypes(): array
    {
        return [];
    }

    public function isSubRatingEnabled(): bool
    {
        return config('reviewer.enable_sub_rating', true);
    }

    public function isShowCountryEnabled(): bool
    {
        return config('reviewer.show_country', true);
    }

}
