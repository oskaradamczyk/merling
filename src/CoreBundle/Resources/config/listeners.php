<?php

// app/config/services.php
use Symfony\Component\DependencyInjection\Definition;
use CoreBundle\Listener\EventListener\MediaUrlEventListener;

// To use as default template
$definition = new Definition();

$definition
    ->setAutowired(true)
    ->setAutoconfigured(true)
    ->setPublic(false)
;

// $this is a reference to the current loader
$this->registerClasses($definition, 'CoreBundle\\', '../../../CoreBundle/*', '../../../CoreBundle/{Entity,Repository}');