<?php

namespace OveD\Apm\Request;

use Carbon\Carbon;
use OveD\Apm\Filters\Filters;
use Ramsey\Uuid\Uuid;
use OveD\Apm\Sampling\SamplerInterface;

class ApmContext
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;
    /**
     * @var array
     */
    private $queries = [];
    /**
     * @var Carbon
     */
    private $startedAt;
    /**
     * @var SamplerInterface
     */
    private $sampler;
    /**
     * @var Filters
     */
    private $filters;

    public function __construct(Filters $filters)
    {
        $this->id = Uuid::uuid4();
        $this->startedAt = Carbon::now(config('apm.timezone', 'UTC'));
        $this->filters = $filters;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getStartedAt(): Carbon
    {
        return $this->startedAt;
    }

    public function addQuery(string $query, float $time, array $bindings, string $connectionName)
    {
        $query = $this->attachBindings($query, $bindings);

        $this->queries[] = [
            'query'      => $query,
            'time_ms'    => $time,
            'bindings'   => $bindings,
            'connection' => $connectionName
        ];
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return mixed|string
     */
    protected function attachBindings(string $query, array $bindings)
    {
        if (!config('apm.showBindings', false)) {
            return $query;
        }

        if (count($bindings) == 0) {
            return $query;
        }

        $sql = str_replace(['%', '?'], ['%%', "%s"], $query);

        $full_sql = vsprintf($sql, $bindings);

        return $full_sql;
    }

    public function getQueries(): array
    {
        return $this->queries;
    }

    /**
     * @return SamplerInterface
     */
    public function getSampler(): SamplerInterface
    {
        return $this->sampler;
    }

    /**
     * @return Filters
     */
    public function getFilters(): Filters
    {
        return $this->filters;
    }
}
