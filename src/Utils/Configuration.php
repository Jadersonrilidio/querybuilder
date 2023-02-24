<?php

namespace Jayrods\QueryBuilder\Utils;

class Configuration
{
    /**
     * Enable use of queryBuilder constrained mode.
     *
     * @var bool
     */
    private bool $enableConstrainedMode;

    /**
     * Enable constrained mode to throw an exception on fail.
     *
     * @var bool
     */
    private bool $failOnWrongMethodCall;

    /**
     * Enable constrained mode to echo exception message information on fail.
     *
     * @var bool
     */
    private bool $echoWarningsOnWrongMethodCall;

    /**
     * Enable named BindParam if true or question mark if false.
     *
     * @var bool
     */
    private bool $namedBindParamMode;

    /**
     * Enable to throw an exception on fail.
     *
     * @var bool
     */
    private bool $namedBindParamFailMode;

    /**
     * Enable to echo exception message information on fail.
     *
     * @var bool
     */
    private bool $namedBindParamEchoWarningsMode;

    /**
     * Class constructor.
     *
     * @param ?string $configFilePath
     *
     * @return void
     */
    public function __construct(?string $configFilePath = null)
    {
        $this->setConfigParams(
            $this->loadConfigurationFile($configFilePath)
        );
    }

    /**
     * Return queryBuilder configuration file if exists or empty array.
     *
     * @param ?string $configFilePath
     *
     * @return mixed[]
     */
    private function loadConfigurationFile(?string $configFilePath = null): array
    {
        if (isset($configFilePath) and file_exists($configFilePath)) {
            return include $configFilePath;
        }

        if (file_exists($path = dirname(dirname(dirname(__DIR__))) . '/config/queryBuilderConfig.php')) {
            return include $path;
        }

        if (file_exists($path = dirname(dirname(__DIR__)) . '/config/queryBuilderConfig.php')) {
            return include $path;
        }

        return array();
    }

    /**
     * Set configuration parameters to class properties.
     *
     * @param mixed[] $configs
     *
     * @return void
     */
    private function setConfigParams(array $configs): void
    {
        $this->enableConstrainedMode = $configs['ENABLE_CONSTRAINED_MODE'] ?? true;
        $this->failOnWrongMethodCall = $configs['FAIL_ON_WRONG_METHOD_CALL'] ?? false;
        $this->echoWarningsOnWrongMethodCall = $configs['ECHO_WARNINGS_ON_WRONG_METHOD_CALL'] ?? true;
        $this->namedBindParamMode = $configs['NAMED_BIND_PARAM_MODE'] ?? true;
        $this->namedBindParamFailMode = $configs['NAMED_BIND_PARAM_FAIL_MODE'] ?? false;
        $this->namedBindParamEchoWarningsMode = $configs['NAMED_BIND_PARAM_ECHO_WARNINGS_MODE'] ?? true;
    }

    /**
     * Return constrained mode value.
     *
     * @return bool
     */
    public function enableConstrainedMode(): bool
    {
        return $this->enableConstrainedMode;
    }

    /**
     * Return fail on wrong method call value.
     *
     * @return bool
     */
    public function failOnWrongMethodCall(): bool
    {
        return $this->failOnWrongMethodCall;
    }

    /**
     * Return echo warning on wrong method call value.
     *
     * @return bool
     */
    public function echoWarningsOnWrongMethodCall(): bool
    {
        return $this->echoWarningsOnWrongMethodCall;
    }

    /**
     * Return named BindParam mode value.
     *
     * @return bool
     */
    public function namedBindParamMode(): bool
    {
        return $this->namedBindParamMode;
    }

    /**
     * Return fail mode value.
     *
     * @return bool
     */
    public function namedBindParamFailMode(): bool
    {
        return $this->namedBindParamFailMode;
    }

    /**
     * Return echo warning mode value.
     *
     * @return bool
     */
    public function namedBindParamEchoWarningsMode(): bool
    {
        return $this->namedBindParamEchoWarningsMode;
    }
}
