<?php

namespace TrueReviewer\Reviewer;

use App\Models\User;
use TrueReviewer\Reviewer\Models\Check;
use TrueReviewer\Reviewer\Models\Media;
use TrueReviewer\Reviewer\Models\Reaction;
use TrueReviewer\Reviewer\Models\Report;
use TrueReviewer\Reviewer\Models\Review;
use TrueReviewer\Reviewer\Models\ReviewStatistic;
use TrueReviewer\Reviewer\Policies\ReviewPolicy;

return [
    'models' => [
        'review_model' => [
            /**
             * @extends Review
             */
            'class' => Review::class,
            'table' => 'reviews',
        ],
        'review_statistic_model' => [
            /**
             * @extends ReviewStatistic
             */
            'class' => ReviewStatistic::class,
            'table' => 'review_statistics',
        ],
        'media_model' => [
            /**
             * @extends Media
             */
            'class' => Media::class,
            'table' => 'reviewer_media',
        ],
        'reaction_model' => [
            /**
             * @extends Reaction
             */
            'class' => Reaction::class,
            'table' => 'reactions',
        ],
        'report_model' => [
            /**
             * @extends Report
             */
            'class' => Report::class,
            'table' => 'reports',
        ],
        'check_model' => [
            /**
             * @extends Check
             */
            'class' => Check::class,
            'table' => 'checks',
        ],
    ],

    /**
     * API route prefix
     */
    'route_prefix' => 'reviewer',

    /**
     * @extends \Illuminate\Foundation\Auth\User
     */
    'user_model' => User::class,

    /**
     * Overall rating can be decimal number (one decimal number)
     */
    'enable_decimal_rating' => true,

    /**
     * Enable to rate for subtypes like Quality, Durability
     */
    'enable_sub_rating' => true,

    /**
     * Enable to rate for subtypes like Quality, Durability
     */
    'enable_media' => true,

    /**
     * Max uploadable media size limit in killobytes
     */
    'media_size' => 2048,

    /**
     * Allowed media types as describe in
     * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#accept
     */
    'media_types' => 'image/*,video/*',

    /**
     * Attachable no of media per review
     */
    'no_of_media_per_review' => 5,

    /**
     * Use when image is not found in media gallery
     */
    'fallback_image' => 'vendor/truereviewer/reviewer/images/image-not-found.png',

    /**
     * Use when image is loading
     */
    'loading_image' => 'vendor/truereviewer/reviewer/images/image-loading.png',

    /**
     * Available options, page, scroll
     */
    'pagination' => 'page',

    'show_verified_status' => false,

    'show_country' => true,

    /**
     * Database column or accessor to get name of the user in users table
     */
    'reviewer_name_column' => 'name',

    /**
     * Database column or accessor to get name of the user in users table
     */
    'reviewer_email_column' => 'email',

    'login_url_name' => 'login',

    'permissions' => [
        'create_review' => [ReviewPolicy::class, 'store'],
        'approve_review' => [ReviewPolicy::class, 'approve'],
        'verify_review' => [ReviewPolicy::class, 'verify'],
        'create_review_reaction' => [ReviewPolicy::class, 'storeReaction'],
        'create_review_report' => [ReviewPolicy::class, 'storeReport'],
        'update_review_report' => [ReviewPolicy::class, 'updateReport'],
        'delete_review_report' => [ReviewPolicy::class, 'deleteReport'],
    ],

    /**
     * When set to true only approved reviews are counted
     */
    'approval_required' => false,

    /**
     * Whether a product can be rated without a review
     */
    'empty_reviews' => false,

    /**
     * Whether user should provide recommendation or not
     */
    'force_recommendation' => false,

    'avatar' => [
        /**
         * Database column or model accessor name to
         * get the url of profile photo.
         * Leave null if profile photo is not supported
         */
        'column' => '',
        'default' => [
            /**
             * when profile photo url haven't been set
             * this url is used.
             */
            'url' => '',
            /**
             * if this is empty
             *  gravatar service (https://docs.gravatar.com/api/avatars/images/) is used
             * to generate an avatar.
             */
            'gravatar' => [
                'default' => 'mp',
            ],
        ],
    ],

    'LLM' => [
        /**
         * Must be a type of EchoLabs\Prism\Enums\Provider
         */
        'provider' => null,
        'model' => '',
    ],

    /**
     * Detect reviews' sentiment
     * Required to set LLM and manual installation of prism package https://prism.echolabs.dev/
     */
    'sentiment_detector' => [
        'queue' => 'default',
        'enabled' => false,
    ],

    /**
     * Perform checks to authenticate the integrity of the review
     * Required to set LLM and manual installation of prism package https://prism.echolabs.dev/
     */
    'checks' => [
        'queue' => 'default',

        'profanity' => [
            /**
             * Review will be rejected if it contains profanity
             */
            'enabled' => false,
            /**
             * Replace profanity with this approved word
             */
            'replace' => false,
            /**
             * Strictness level of the profanity check. 10 means most strict and 1 means least strict
             */
            'level' => 5,
        ],
        'harassment' => [
            /**
             * Review will be rejected if it implies harassment
             */
            'enabled' => false,
            /**
             * Strictness level of the harassment check. 10 means most strict and 1 means least strict
             */
            'level' => 5,
        ],
        'robot' => [
            /**
             * Review will be rejected if it implies harassment
             */
            'enabled' => false,
            /**
             * Strictness level of the harassment check. 10 means most strict and 1 means least strict
             */
            'level' => 5,
        ],
    ],

    'theme' => [
        /**
         * Available options: aura, lara, nora, material
         */
        'preset' => 'aura',

        /**
         * Available options: noir, emerald, green, lime, orange, amber, yellow, teal, cyan, sky,
         * blue, indigo, violet, purple, fuchsia, pink, rose
         *
         * @see https://github.com/truereviewer/reviewer/blob/main/resources/ts/components/ThemeSwitcher/primaryColors.ts
         *  to add custom primary colors
         */
        'primary_color' => 'emerald',

        'surface_color' => 'slate',

        'ripple' => true,

        'dark_mode_selector' => 'system',
    ],

    'show_theme_switcher' => false,
];
