<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

trait ResponseHandleTrait
{
    /**
     * @param $validator
     * @param bool $inModal
     * @return JsonResponse
     */
    public function validationResponse($validator, bool $inModal = false): JsonResponse
    {
        $validateMessage        = $validator->errors();
        $finalMessage           = [];

        foreach ($validateMessage as $key => $perMsg) {
            $finalMessage[]     = ["id" => $key, "content" => $perMsg[0]];
        }

        $responseParam          = [
            "success"           => false,
            "code"              => 422,
            "in_modal"          => $inModal,
            "data"              => [
                "has_paginate"  => 0,
                "results"       => [],
            ],
            "message"           => $finalMessage
        ];

        return response()->json($responseParam, 422);
    }

    /**
     * @param $message
     * @param int $code
     * @param bool $success
     * @param bool $inModal
     * @return JsonResponse
     */
    public function messageResponse($message, int $code = 406, bool $success = false , bool $inModal = false): JsonResponse
    {
        $finalMessage           = [
            "id"                => "all",
            "content"           => $message
        ];

        $responseParam          = [
            "success"           => $success,
            "code"              => $code,
            "in_modal"          => $inModal,
            "data"              => [
                "has_paginate"  => 0,
                "results"       => [],
            ],
            "message"           => [$finalMessage]
        ];

        return response()->json($responseParam, $code);
    }

    /**
     * @param $message
     * @param $data
     * @param int $code
     * @param bool $inModal
     * @return JsonResponse
     */
    public function dataResponse($message, $data, int $code = 200 , bool $inModal = false): JsonResponse
    {
        if ($data instanceof ResourceCollection && $data->resource instanceof LengthAwarePaginator) {
            $data = $this->paginateDataResourceCollection($data);
        }

        else if (is_null($data)) {
            $data = [];
        } else {
            if ($data instanceof Collection) {
                $data = $data->toArray();
            } else {
                if (is_array($data)) {
                    if (! empty($data)) {
                        $data = [$data];
                    }
                } elseif ($data instanceof JsonResource){
                    $data = [$data];
                } else {
                    $data = [$data->toArray()];
                }
            }

            $data                   = [
                "has_paginate"      => 0,
                "results"           => $data,
            ];
        }

        $responseParam          = [
            "success"           => true,
            "code"              => $code,
            "in_modal"          => $inModal,
            "data"              => $data,
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => $message
                ]
            ]
        ];

        return response()->json($responseParam, $code);
    }

    /**
     * @param $message
     * @param $data
     * @param bool $inModal
     * @return JsonResponse
     */
    public function paginatedDataResponse($message, $data, bool $inModal =false): JsonResponse
    {
        $data                   = [
            "has_paginate"      => 1,
            "total_data"        => $data["total"],
            "current_page"      => $data["current_page"],
            "from"              => $data["from"],
            "to"                => $data["to"],
            "first_page_url"    => $data["first_page_url"],
            "last_page"         => $data["last_page"],
            "last_page_url"     => $data["last_page_url"],
            "next_page_url"     => is_null($data["next_page_url"]) ? "" : $data["next_page_url"],
            "prev_page_url"     => is_null($data["prev_page_url"]) ? "" : $data["prev_page_url"],
            "path"              => $data["path"],
            "per_page"          => $data["per_page"],
            "results"           => $data["data"]
        ];

        $responseParam          = [
            "success"           => true,
            "code"              => 200,
            // "in_modal"    => $inModal,
            "data"              => $data,
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => $message
                ]
            ]
        ];

        return response()->json($responseParam);
    }

    /**
     * @param $message
     * @param $title
     * @param $data
     * @param bool $inModal
     * @return JsonResponse
     */
    public function minimalPaginatedDataResponse($message, $title, $data, bool $inModal = false): JsonResponse
    {

        $data                   = [
            "total_data"        => $data["total"],
            "current_page"      => $data["current_page"],
            "from"              => $data["from"],
            "to"                => $data["to"],
            "last_page"         => $data["last_page"],
            "per_page"          => $data["per_page"],
            "results"           => $data["data"]
        ];

        $responseParam          = [
            "success"           => true,
            "code"              => 200,
            "in_modal"          => $inModal,
            "data"              => $data,
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => $message
                ]
            ]
        ];

        return response()->json($responseParam);
    }

    /**
     * @param $message
     * @param $data
     * @param bool $inModal
     * @return JsonResponse
     */
    public function loadMoreDataResponse($message, $data, bool $inModal = false): JsonResponse
    {
        $data                   = [
            "results"           => $data
        ];

        $responseParam          = [
            "success"           => true,
            "code"              => 200,
            "in_modal"          => $inModal,
            "data"              => $data,
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => $message
                ]
            ]
        ];

        return response()->json($responseParam);
    }

    /**
     * @param bool $inModal
     * @return JsonResponse
     */
    public function serverErrorResponse(bool $inModal = false): JsonResponse
    {
        $responseParam          = [
            "success"           => false,
            "code"              => 500,
            "in_modal"          => $inModal,
            "data"              => [
                "has_paginate"  => 0,
                "results"       => [],
            ],
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => __('messages.server_error')
                ]
            ]
        ];

        return response()->json($responseParam, 500);
    }

    /**
     * @param ResourceCollection $data
     * @param string $message
     * @param bool $inModal
     * @return JsonResponse
     */
    public function resourceCollectionResponse(ResourceCollection $data, string $message = '', bool $inModal = false): JsonResponse
    {
        $data                   = [
            "has_paginate"      => 0,
            "results"           => $data
        ];

        $responseParam          = [
            "success"           => true,
            "code"              => 200,
            "in_modal"          => $inModal,
            "data"              => $data,
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => $message
                ]
            ]
        ];

        return response()->json($responseParam);
    }

    /**
     * @param ResourceCollection $data
     * @param string $message
     * @param bool $inModal
     * @return JsonResponse
     */
    public function paginateForResourceCollection(ResourceCollection $data, string $message = '', bool $inModal = false): JsonResponse
    {
        $data                   = $data->response()->getData(true);

        $data                   = [
            "has_paginate"      => 1,
            "total_data"        => $data['meta']['total'],
            "current_page"      => $data['meta']['current_page'],
            "from"              => $data['meta']['from'],
            "to"                => $data['meta']['to'],
            "first_page_url"    => $data["links"]["first"],
            "last_page"         => $data['meta']['last_page'],
            "last_page_url"     => $data["links"]["last"],
            "next_page_url"     => is_null($data["links"]["next"]) ? "" : $data["links"]["next"],
            "prev_page_url"     => is_null($data["links"]["prev"]) ? "" : $data["links"]["prev"],
            "path"              => $data["meta"]["path"],
            "per_page"          => $data['meta']['per_page'],
            "results"           => $data["data"]
        ];

        $responseParam          = [
            "success"           => true,
            "code"              => 200,
            "in_modal"          => $inModal,
            "data"              => $data,
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => $message
                ]
            ]
        ];

        return response()->json($responseParam);
    }

    /**
     * @param ResourceCollection $data
     * @param string $message
     * @param bool $inModal
     * @return JsonResponse
     */
    public function minimalPaginateForResourceCollection(ResourceCollection $data, string $message = '', bool $inModal = false): JsonResponse
    {
        $data                   = $data->response()->getData(true);
        $data                   = [
            "has_paginate"      => 1,
            "current_page"      => $data['meta']['current_page'],
            "from"              => $data['meta']['from'],
            "to"                => $data['meta']['to'],
            "per_page"          => $data['meta']['per_page'],
            "results"           => $data['data']
        ];

        $responseParam          = [
            "success"           => true,
            "code"              => 200,
            "in_modal"          => $inModal,
            "data"              => $data,
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => $message
                ]
            ]
        ];

        return response()->json($responseParam);
    }

    /**
     * @param $data
     * @param string $message
     * @param bool $inModal
     * @return JsonResponse
     */
    public function successResponse($data = [], string $message = '' , bool $inModal = false): JsonResponse
    {
        $data                   = $this->parseData($data);

        $responseParam          = [
            "success"           => true,
            "code"              => 200,
            "in_modal"          => $inModal,
            "data"              => $data,
            "message"           => [
                [
                    "id"        => "all",
                    "content"   => $message
                ]
            ]
        ];

        return response()->json($responseParam);
    }

    /**
     * @param $data
     * @return array
     */
    private function parseData($data): array
    {
        if ($data instanceof ResourceCollection){
            $data               = $this->paginateDataResourceCollection($data);
        }

        elseif ($data instanceof LengthAwarePaginator) {
            $data               = $data->toArray();

            $data               = [
                "has_paginate"  => 1,
                "total_data"    => $data["total"],
                "current_page"  => $data["current_page"],
                "from"          => $data["from"],
                "to"            => $data["to"],
                "first_page_url"=> $data["first_page_url"],
                "last_page"     => $data["last_page"],
                "last_page_url" => $data["last_page_url"],
                "next_page_url" => is_null($data["next_page_url"]) ? "" : $data["next_page_url"],
                "prev_page_url" => is_null($data["prev_page_url"]) ? "" : $data["prev_page_url"],
                "path"          => $data["path"],
                "per_page"      => $data["per_page"],
                "results"       => $data["data"],
            ];

        } elseif ($data instanceof Paginator) {
            $data               = $data->toArray();
            $data               = [
                "has_paginate"  => 1,
                "current_page"  => $data["current_page"],
                "first_page_url"=> $data["first_page_url"],
                "next_page_url" => $data["next_page_url"]??"",
                "prev_page_url" => $data["prev_page_url"]??"",
                "path"          => $data["path"],
                "per_page"      => $data["per_page"],
                "from"          => $data["from"],
                "to"            => $data["to"],
                "results"       => $data["data"],
            ];
        } elseif (is_null($data)) {
            $data = [];
        } else {
            if ($data instanceof Collection) {
                $data = $data->toArray();
            } else {
                if (is_array($data)) {
                    if (! empty($data)) {
                        $data = [$data];
                    }
                } else if ($data instanceof JsonResource){
                    $data = [$data];
                } else {
                    $data = [$data->toArray()];
                }
            }
        }

        return $data;
    }

    /**
     * @param ResourceCollection $data
     * @return array
     */
    private function paginateDataResourceCollection(ResourceCollection $data): array
    {
        $data = $data->response()->getData(true);

        if (! isset($data['meta'])){
            return [
                "has_paginate"  => 0,
                "results"       => $data["data"],
            ];
        }

        if ($this->checkResourceCollectionPaginateIsMinimal($data)){
            return  [
                "has_paginate"      => 1,
                "current_page"      => $data['meta']["current_page"],
                "first_page_url"    => $data['links']["first"],
                "next_page_url"     => $data['links']["next"],
                "prev_page_url"     => $data['links']["prev"],
                "path"              => $data['meta']["path"],
                "per_page"          => $data['meta']['per_page'],
                "from"              => $data['meta']['from'],
                "to"                => $data['meta']['to'],
                "results"           => $data["data"],
            ];
        }

        return [
            "has_paginate"          => 1,
            "total_data"            => $data['meta']['total'],
            "current_page"          => $data['meta']['current_page'],
            "from"                  => $data['meta']['from'],
            "to"                    => $data['meta']['to'],
            "first_page_url"        => $data["links"]["first"],
            "last_page"             => $data['meta']['last_page'],
            "last_page_url"         => $data["links"]["last"],
            "next_page_url"         => is_null($data["links"]["next"]) ? "" : $data["links"]["next"],
            "prev_page_url"         => is_null($data["links"]["prev"]) ? "" : $data["links"]["prev"],
            "path"                  => $data["meta"]["path"],
            "per_page"              => $data['meta']['per_page'],
            "results"               => $data["data"]
        ];
    }

    /**
     * @param array $data
     * @return bool
     */
    private function checkResourceCollectionPaginateIsMinimal(array $data) : bool
    {
        if (isset($data['meta']['total'])) {
            return false;
        }

        return  true;
    }
}
