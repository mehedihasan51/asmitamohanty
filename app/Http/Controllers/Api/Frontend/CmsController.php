<?php
namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Enums\PageEnum;
use App\Enums\SectionEnum;
use App\Helpers\Helper;
use App\Models\CMS;
use App\Models\Setting;

class CmsController extends Controller
{
    public function term()
    {
        $data = [
            'terms' => CMS::select(['title', 'description'])->where('page', PageEnum::SETTING)->where('section', SectionEnum::TERMS)->where('status', 'active')->get()
        ];
        return Helper::jsonResponse(true, 'Home Page', 200, $data);
    }

    public function privacy()
    {
        $data = [
            'privacies' => CMS::select(['title', 'description'])->where('page', PageEnum::SETTING)->where('section', SectionEnum::PRIVACIES)->where('status', 'active')->get()
        ];
        return Helper::jsonResponse(true, 'Home Page', 200, $data);
    }
}