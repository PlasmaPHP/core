<?php
/**
 * Plasma Core component
 * Copyright 2018 PlasmaPHP, All Rights Reserved
 *
 * Website: https://github.com/PlasmaPHP
 * License: https://github.com/PlasmaPHP/core/blob/master/LICENSE
*/

namespace Plasma;

/**
 * A query result stream. Used to get rows row by row, as sent by the DBMS.
 */
class StreamQueryResult implements StreamQueryResultInterface {
    /**
     * @var \Plasma\DriverInterface
     */
    protected $driver;
    
    /**
     * @var \Plasma\CommandInterface
     */
    protected $command;
    
    /**
     * @var bool
     */
    protected $started = false;
    
    /**
     * @var bool
     */
    protected $closed = false;
    
    /**
     * @var bool
     */
    protected $paused = false;
    
    /**
     * Constructor.
     * @param \Plasma\DriverInterface   $driver
     * @param \Plasma\CommandInterface  $command
     */
    function __construct(\Plasma\DriverInterface $driver, \Plasma\CommandInterface $command) {
        $this->driver = $driver;
        $this->command = $command;
        
        $command->on('data', function ($row) {
            if(!$this->started && $this->paused) {
                $this->driver->pauseStreamConsumption();
            }
            
            $this->started = true;
            $this->emit('data', array($row));
        });
        
        $command->on('end', function () {
            $this->emit('end');
            $this->close();
        });
        
        $command->on('error', function (\Throwable $error) {
            $this->emit('error', array($error));
            $this->close();
        });
    }
    
    /**
     * Whether the stream is readable.
     * @return bool
     */
    function isReadable() {
        return (!$this->closed);
    }
    
    /**
     * Pauses the connection, where this stream is coming from.
     * This operation halts ALL read activities.
     * @return void
     */
    function pause() {
        $this->paused = true;
        
        if($this->started && !$this->closed) {
            $this->driver->pauseStreamConsumption();
        }
    }
    
    /**
     * Resumes the connection, where this stream is coming from.
     * @return void
     */
    function resume() {
        $this->paused = false;
        
        if($this->started && !$this->closed) {
            $this->driver->resumeStreamConsumption();
        }
    }
    
    /**
     * Closes the stream. Resumes the connection stream.
     * @return void
     */
    function close() {
        if($this->closed) {
            return;
        }
        
        $this->closed = true;
        if($this->started && $this->paused) {
            $this->driver->resumeStreamConsumption();
        }
        
        $this->emit('close');
        $this->removeAllListeners();
    }
    
    /**
     * Pipes all the data from this readable source into the given writable destination.
     * Automatically sends all incoming data to the destination.
     * Automatically throttles the source based on what the destination can handle.
     * @param \React\Stream\WritableStreamInterface  $dest
     * @param array                                  $options
     * @return \React\Stream\WritableStreamInterface  $dest  Stream as-is
     */
    function pipe(\React\Stream\WritableStreamInterface $dest, array $options = array()) {
        return \React\Stream\Util::pipe($this, $dest, $options);
    }
}