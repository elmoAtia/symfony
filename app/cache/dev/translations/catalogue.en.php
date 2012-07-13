<?php

use Symfony\Component\Translation\MessageCatalogue;

$catalogue = new MessageCatalogue('en', array (
  'messages' => 
  array (
    'Your Facebook Poster' => 'Your Facebook Poster',
    'How it works' => 'How it works',
    'Choose your options.' => 'Choose your options.',
    'Modify the preview or press next.' => 'Modify the preview or press next.',
    'Select your poster size.' => 'Select your poster size.',
    'Generate poster now' => 'Generate poster now',
    'Return to Fanpage' => 'Return to Fanpage',
    'Logout' => 'Logout',
    'Please wait a moment. We are generating' => 'Please wait a moment. We are generating',
    'your personal Facebook Poster.' => 'your personal Facebook Poster.',
    'You do not have enough pictures for the chosen poster!' => 'You do not have enough pictures for the chosen poster!',
  ),
));



return $catalogue;
