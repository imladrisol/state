<?php


class Context
{
    private $state;

    public function __construct(State $state)
    {
        $this->transitionTo($state);
    }

    public function transitionTo(State $state): void
    {
        echo "Context: Transition to " . get_class($state) . ".\n";
        $this->state = $state;
        $this->state->setContext($this);
    }

    public function switchToCold(): void
    {
        $this->state->handle(new ColdOwen);
    }

    public function switchToOverheat(): void
    {
        $this->state->handle(new Overheat);
    }

    public function switchToReadyToWork(): void
    {
        $this->state->handle(new ReadyToWork);
    }
}

abstract class State
{
    protected $context;

    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    public function handle($obj): void
    {
        echo "switched from ".static::class." to " . get_class($obj) . ".\n";
        $this->context->transitionTo($obj);
    }
}

class ColdOwen extends State
{

}

class ReadyToWork extends State
{

}

class Overheat extends State
{

}

$context = new Context(new ReadyToWork);
$context->switchToCold();
$context->switchToOverheat();
$context->switchToReadyToWork();