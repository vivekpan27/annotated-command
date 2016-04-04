<?php
namespace Consolidation\AnnotationCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Manage named callback hooks
 */
class HookManager
{
    protected $hooks = [];

    public function __construct()
    {
    }

    /**
     * Add a hook
     *
     * @param string   $name     The name of the command to hook
     * @param string   $hook     The name of the hook to add
     * @param callable $callback The callback function to call
     */
    public function add($name, $hook, callable $callback)
    {
        $this->hooks[$name][$hook][] = $callback;
    }

    /**
     * Get a set of hooks
     *
     * @param string|array $names The name of the function being hooked.
     * @param string $hook The name of the hook (e.g. alter)
     *
     * @return callable[]
     */
    public function get($names, $hook)
    {
        $hooks = [];
        foreach ((array)$names as $name) {
            $hooks = array_merge($hooks, $this->getHook($name, $hook));
        }
        return $hooks;
    }

    protected function getHook($name, $hook)
    {
        if (isset($this->hooks[$name][$hook])) {
            return $this->hooks[$name][$hook];
        }
        return [];
    }
}
