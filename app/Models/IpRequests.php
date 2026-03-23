<?php

namespace App\Models;

use App\Services\ApiClient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IpRequests
{

    private ApiClient $_client;

    public function client(): ApiClient
    {
        return $this->_client ??= $this->_client = new ApiClient();
    }

    /**
     * @param string $ip
     * @return IpRequest
     */
    public function add(string $ip): IpRequest
    {
        $response = $this->client()->get( env('IP_API') . $ip);

        $ipRequest = new IpRequest();
        if(isset($response['data']['ip']))
        {
            $data = $response['data'];
            return $ipRequest::create([
                'ip' => $data['ip'],
                'rir' => $data['rir'] ?? null,
                'company_name' => $data['company']['name'] ?? null,
                'company_domain' => $data['company']['domain'] ?? null,
                'abuse_score' => $data['company']['abuser_score'] ?? null,
                'lat' => $data['location']['latitude'] ?? null,
                'lon' => $data['location']['longitude'] ?? null,
                'country' => $data['location']['country'] ?? null,
                'zipcode' => $data['location']['zip'] ?? null,
                'type' => $this->getIpType($ip) ?? null,
            ]);
        }

        return $ipRequest;
    }

    /**
     * @param int $perPage
     * @param string|null $query
     * @return LengthAwarePaginator
     */
    public function list(int $perPage = 10, ?string $query = null): LengthAwarePaginator
    {
        return IpRequest::query()
            ->when($query, function ($q) use ($query) {
                $q->where('ip', 'LIKE', "%{$query}%")
                    ->orWhere('company_name', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * @param string $id
     * @return IpRequest|null
     */
    public function find(string $id): ?IpRequest
    {
        return IpRequest::where('id', $id)->first();
    }

    /**
     * @param string $id
     */
    public function remove(string $id): void
    {
        $ipRequest = IpRequest::where('id', $id)->first();
        $ipRequest->delete();
    }

    /**
     *
     * @param string $ip
     * @return bool
     */
    public function exists(string $ip): bool
    {
        return IpRequest::where('ip', $ip)->exists();
    }

    private function getIpType($ip): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
        {
            return "IPv4";
        }
        elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
        {
            return "IPv6";
        }
        else
        {
            return '';
        }
    }





}
