<?php 

use Boardy\Services\Extension\Extension;

class SampleExtension extends Extension
{
    protected $name            = 'Sample Extension';
    protected $author          = 'Raphael Marco';
    protected $version         = '1.0';
    protected $boardyVersion   = '1.0';

    public function activate()
    {
        return true;
    }

    public function deactivate()
    {
        return true;
    }

    public function load()
    {

    }
}
