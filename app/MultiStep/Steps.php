<?php

namespace App\MultiStep;

use App\MultiStep\Store\Contracts\StepStorage;
use Illuminate\Http\Request;

class Steps
{
    protected $name;

    protected $step;

    protected $storage;

    public function __construct(StepStorage $storage)
    {
        $this->storage = $storage;
    }

    public function step($name, $step)
    {
        $this->name = $name;
        $this->step = $step;

        return $this;
    }

    public function store($data)
    {
        $this->storage->put($this->key() . ".{$this->step}.data", $data);

        return $this;
    }

    public function complete()
    {
        $this->storage->put($this->key() . ".{$this->step}.complete", true);

        return $this;
    }

    public function notCompleted(...$steps)
    {
        foreach ($steps as $step) {
            if (!$this->storage->get($this->key() . ".{$step}.complete")) {
                return true;
            }
        }

        return false;
    }

    public function data()
    {
        return collect($this->storage->get($this->key()))
            ->pluck('data')
            ->flatten()
            ->toArray();
    }

    public function clearAll()
    {
        $this->storage->forget($this->key());

        return $this;
    }

    protected function key()
    {
        return "multistep.{$this->name}";
    }

    public function __get($property)
    {
        return $this->storage->get("multistep.{$this->name}.{$this->step}.data.{$property}");
    }
}
