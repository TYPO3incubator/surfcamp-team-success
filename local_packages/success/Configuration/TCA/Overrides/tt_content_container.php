<?php

use B13\Container\Tca\ContainerConfiguration;
use B13\Container\Tca\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

GeneralUtility::makeInstance(Registry::class)->configureContainer(
    (new ContainerConfiguration(
        'ce_slider',
        'Content Element Slider',
        'Create a slider with multiple content elements',
        [
            [
                ['name' => 'Slides', 'colPos' => 555],
            ]
        ]
    ))->setIcon('content-carousel-item-textandimage')
);
