<?php

use Symfony\Component\Translation\MessageCatalogue;

$catalogue = new MessageCatalogue('bg_BG', array (
));

$catalogue->addFallbackCatalogue(new MessageCatalogue('bg', array (
  'messages' => 
  array (
    'Your Facebook Poster' => 'Твоят Facebook постер',
    'How it works' => 'Как работи',
    'Choose your options.' => 'Избери твоите опции.',
    'Modify the preview or press next.' => 'Промени първоначалния изглед или натисни продължи.',
    'Generate poster now' => 'Генерирай постер сега',
    'Select your poster size.' => 'Избери твоят собствен размер.',
    'Return to Fanpage' => 'Обратно към фен страницата',
    'Logout' => 'Изход',
    'Please wait a moment. We are generating' => 'Моля изчакайте. В момента се генерира',
    'your personal Facebook Poster.' => 'вашият личен Facebook Постер.',
    'You do not have enough pictures for the chosen layout!' => 'Вие нямате достатъчно снимки за избрания от вас постер!',
  ),
)));

return $catalogue;
