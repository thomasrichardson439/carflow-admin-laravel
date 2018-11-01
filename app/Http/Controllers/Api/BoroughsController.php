<?php

namespace App\Http\Controllers\Api;

use App\Repositories\BoroughsRepository;
use Illuminate\Http\Request;

class BoroughsController extends BaseApiController
{
    /**
     * @var BoroughsRepository
     */
    private $boroughsRepository;

    public function __construct()
    {
        $this->boroughsRepository = new BoroughsRepository();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->success([
            'boroughs' => $this->boroughsRepository->all(),
        ]);
    }
}
