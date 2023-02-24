<?php

namespace Jayrods\QueryBuilder;

use InvalidArgumentException;
use Jayrods\QueryBuilder\Builders\Constrained\ConstrainedQueryBuilder;
use Jayrods\QueryBuilder\Builders\QueryBuilderInterface;
use Jayrods\QueryBuilder\Builders\Simple\SimpleQueryBuilder;
use Jayrods\QueryBuilder\Factories\QueryBuilderFactoryInterface;
use Jayrods\QueryBuilder\Utils\{
    BindErrorHandler,
    BindParamHandler,
    Configuration,
    ConstraintErrorHandler,
    MethodRecordHelper,
    SingleConfig,
    StateMachine
};

class QueryBuilder implements QueryBuilderFactoryInterface
{
    /**
     * Representation of delete case constant.
     */
    public const DELETE = 'delete';

    /**
     * Representation of insert case constant.
     */
    public const INSERT = 'insert';

    /**
     * Representation of select case constant.
     */
    public const SELECT = 'select';

    /**
     * Representation of update case constant.
     */
    public const UPDATE = 'update';

    /**
     * Package configuration instance.
     *
     * @var Configuration
     */
    private Configuration $appConfig;

    /**
     * Class constructor.
     *
     * @param ?string $configFilePath User-defined config file path.
     *
     * @return void
     */
    public function __construct(?string $configFilePath = null)
    {
        $this->appConfig = (new SingleConfig($configFilePath))->appConfig();
    }

    /**
     * Creates an instance of QueryBuilderInterface according to given case.
     *
     * @param string $case
     *
     * @throws InvalidArgumentException
     *
     * @return QueryBuilderInterface
     */
    public function create(string $case): QueryBuilderInterface
    {
        if (!$this->validateCase($case)) {
            throw new InvalidArgumentException('Invalid case.');
        }

        $class = $this->buildClassName(
            $this->appConfig->enableConstrainedMode(),
            $case
        );

        return $this->appConfig->enableConstrainedMode()
            ? $this->buildConstrainedQueryBuilder($class)
            : $this->buildSimpleQueryBuilder($class);
    }

    /**
     * Construct the exact QueryBuilder class to be called.
     *
     * @param bool $mode
     * @param string $case
     *
     * @return string QueryBuilder class name with namespace.
     */
    private function buildClassName(bool $mode, string $case): string
    {
        $case = ucfirst($case);

        $class = "Jayrods\\QueryBuilder\\Builders";
        $class .= $mode ? "\\Constrained" : "\\Simple";
        $class .= "\\{$case}QueryBuilder";

        return $class;
    }

    /**
     * Create a ConstrainedQueryBuilder instance.
     *
     * @param string $class
     *
     * @return ConstrainedQueryBuilder
     */
    private function buildConstrainedQueryBuilder(string $class): ConstrainedQueryBuilder
    {
        $simpleQueryBuilderClass = str_replace('Constrained', 'Simple', $class);

        return new $class(
            new StateMachine(),
            new MethodRecordHelper(),
            new ConstraintErrorHandler($this->appConfig),
            $this->buildSimpleQueryBuilder($simpleQueryBuilderClass)
        );
    }

    /**
     * Create a SimpleQueryBuilder instance.
     *
     * @param string $class
     *
     * @return SimpleQueryBuilder
     */
    private function buildSimpleQueryBuilder(string $class): SimpleQueryBuilder
    {
        $bindErrorHandler = new BindErrorHandler($this->appConfig);
        $bindHandler = new BindParamHandler($this->appConfig, $bindErrorHandler);

        return new $class($bindHandler);
    }

    /**
     * Check whether the case passed as argument is valid or not.
     *
     * @param string $case
     *
     * @return bool
     */
    private function validateCase(string $case): bool
    {
        return in_array(
            $case,
            [self::DELETE, self::INSERT, self::SELECT, self::UPDATE],
            true
        );
    }
}
