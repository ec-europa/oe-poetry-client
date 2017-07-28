<?php

use EC\Poetry\Messages\Components as Component;
use EC\Poetry\Messages\Status;

$id = new Component\Identifier();
$id->setCode('DGT')
  ->setYear(2017)
  ->setNumber('00001')
  ->setVersion('01')
  ->setPart('00')
  ->setProduct('TRA');

$component = new Component\StatusComponent();
$component->setCode('OK');

$status = new Status($id);
$status->addStatus($component);
