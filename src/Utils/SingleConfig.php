<?php

namespace Jayrods\QueryBuilder\Utils;

use Jayrods\QueryBuilder\Utils\Configuration;

class SingleConfig
{
    /**
     * Package configuration instance.
     *
     * @var Configuration
     */
    private static Configuration $appConfig;

    /**
     * Class constructor.
     *
     * @param ?string $configFilePath
     *
     * @return void
     */
    public function __construct(?string $configFilePath = null)
    {
        if (!isset(self::$appConfig)) {
            self::$appConfig = new Configuration($configFilePath);
        }
    }

    /**
     * Return package configuration object.
     *
     * @return Configuration
     */
    public function appConfig(): Configuration
    {
        return self::$appConfig;
    }
}
