<?php

namespace Boss\MasterSupervisorCommands;

use Boss\MasterSupervisor;
use Boss\SupervisorOptions;
use Boss\SupervisorProcess;
use Symfony\Component\Process\Process;

class AddSupervisor
{
    /**
     * Process the command.
     *
     * @param  \Boss\MasterSupervisor  $master
     * @param  array  $options
     * @return void
     */
    public function process(MasterSupervisor $master, array $options)
    {
        $options = SupervisorOptions::fromArray($options);

        $master->supervisors[] = new SupervisorProcess(
            $options, $this->createProcess($master, $options), function ($type, $line) use ($master) {
                $master->output($type, $line);
            }
        );
    }

    /**
     * Create the Symfony process instance.
     *
     * @param  \Boss\MasterSupervisor  $master
     * @param  \Boss\SupervisorOptions  $options
     * @return \Symfony\Component\Process\Process
     */
    protected function createProcess(MasterSupervisor $master, SupervisorOptions $options)
    {
        $command = $options->toSupervisorCommand();

        return Process::fromShellCommandline($command, $options->directory ?? base_path())
                    ->setTimeout(null)
                    ->disableOutput();
    }
}
