<?php
/**
 * Created by Jaymeen Darji.
 * User: jaymeen
 * Date: 3/17/23
 * Time: 4:52 PM
 */

namespace App\Traits;

use App\Actions\Reports\SalesEnquiryReportAction;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;

use function response;

trait ApiResponseHelpers
{
    private ?array $_api_helpers_defaultSuccessData = ['success' => true];

    /**
     * @param \Exception|string $message
     * @param  string|null  $key
     *
     * @return JsonResponse
     */
    public function respondNotFound(
        Exception|string $message,
        ?string          $key = 'error'
    ): JsonResponse {
        return $this->apiResponse(
            [$key => $this->morphMessage($message)],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @param array|JsonSerializable|Arrayable|null $contents
     */
    public function respondWithSuccess(array|JsonSerializable|Arrayable $contents = null): JsonResponse
    {
        $contents = $this->morphToArray($contents) ?? [];

        $data = [] === $contents
            ? $this->_api_helpers_defaultSuccessData
            : $contents;

        return $this->apiResponse($data);
    }

    /**
     * @param array|null $content
     * @return ApiResponseHelpers|SalesEnquiryReportAction
     */
    public function setDefaultSuccessResponse(?array $content = null): self
    {
        $this->_api_helpers_defaultSuccessData = $content ?? [];
        return $this;
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function respondOk(string $message): JsonResponse
    {
        return $this->respondWithSuccess(['success' => $message]);
    }

    /**
     * @param string|null $message
     * @return JsonResponse
     */
    public function respondUnAuthenticated(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            ['error' => $message ?? 'Unauthenticated'],
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @param string|null $message
     * @return JsonResponse
     */
    public function respondForbidden(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            ['error' => $message ?? 'Forbidden'],
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * @param string|null $message
     * @return JsonResponse
     */
    public function respondError(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            ['error' => $message ?? 'Error'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param array|JsonSerializable|Arrayable|null $data
     */
    public function respondCreated(array|JsonSerializable|Arrayable $data = null): JsonResponse
    {
        $data ??= [];
        return $this->apiResponse(
            $this->morphToArray($data),
            Response::HTTP_CREATED
        );
    }

    /**
     * @param \Exception|string $message
     * @param  string|null  $key
     *
     * @return JsonResponse
     */
    public function respondFailedValidation(
        Exception|string $message,
        ?string          $key = 'message'
    ): JsonResponse {
        return $this->apiResponse(
            [$key => $this->morphMessage($message)],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * @return JsonResponse
     */
    public function respondTeapot(): JsonResponse
    {
        return $this->apiResponse(
            ['message' => 'I\'m a teapot'],
            Response::HTTP_I_AM_A_TEAPOT
        );
    }

    /**
     * @param array|JsonSerializable|Arrayable|null $data
     */
    public function respondNoContent(array|JsonSerializable|Arrayable $data = null): JsonResponse
    {
        $data ??= [];
        $data = $this->morphToArray($data);

        return $this->apiResponse($data, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    private function apiResponse(array $data, int $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * @param array|JsonSerializable|Arrayable|null $data
     * @return array|JsonSerializable|Arrayable|null
     */
    private function morphToArray(array|JsonSerializable|Arrayable|null $data): array|JsonSerializable|Arrayable|null
    {
        if ($data instanceof Arrayable) {
            return $data->toArray();
        }

        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        }

        return $data;
    }

    /**
     * @param \Exception|string $message
     * @return string
     */
    private function morphMessage(Exception|string $message): string
    {
        return $message instanceof Exception
            ? $message->getMessage()
            : $message;
    }
}
