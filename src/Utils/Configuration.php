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
    private bool $parameterizedMode;

    /**
     * Enable to throw an exception on fail.
     *
     * @var bool
     */
    private bool $parameterizedModeFailOnError;

    /**
     * Enable to echo exception message information on fail.
     *
     * @var bool
     */
    private bool $parameterizedModeEchoWarningsOnError;

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
        $this->parameterizedMode = $configs['PARAMETERIZED_MODE'] ?? true;
        $this->parameterizedModeFailOnError = $configs['PARAMETERIZED_MODE_FAIL_ON_ERROR'] ?? false;
        $this->parameterizedModeEchoWarningsOnError = $configs['PARAMETERIZED_MODE_ECHO_WARNINGS_ON_ERROR'] ?? true;
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
    public function parameterizedMode(): bool
    {
        return $this->parameterizedMode;
    }

    /**
     * Return fail mode value.
     *
     * @return bool
     */
    public function parameterizedModeFailOnError(): bool
    {
        return $this->parameterizedModeFailOnError;
    }

    /**
     * Return echo warning mode value.
     *
     * @return bool
     */
    public function parameterizedModeEchoWarningsOnError(): bool
    {
        return $this->parameterizedModeEchoWarningsOnError;
    }
}
