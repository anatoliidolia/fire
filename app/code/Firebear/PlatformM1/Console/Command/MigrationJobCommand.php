<?php
/**
 * @copyright: Copyright © 2019 Firebear Studio. All rights reserved.
 * @author   : Firebear Studio <fbeardev@gmail.com>
 */

namespace Firebear\PlatformM1\Console\Command;

use Firebear\ImportExport\Model\Migration\AdditionalOptionsFactory;
use Firebear\ImportExport\Model\Migration\MigrationJobFactory;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationJobCommand extends ConsoleCommand
{
    const OPTION_ENTITY = 'entity';
    const OPTION_ENTITY_SHORTCUT = '-e';

    const OPTION_MIGRATE_FROM_DATA = 'migrate_from_date';
    const OPTION_MIGRATE_FROM_DATA_SHORTCUT = '-m';

    const OPTIONS_TEST_BUNCH_SIZE = 'test_bunch_size';
    const OPTIONS_TEST_BUNCH_SIZE_SHORTCUT = '-s';

    /**
     * @var MigrationJobFactory
     */
    protected $migrationJobFactory;

    /**
     * @var AdditionalOptionsFactory
     */
    protected $additionalOptionsFactory;

    /**
     * @param MigrationJobFactory $migrationJobFactory
     * @param AdditionalOptionsFactory $additionalOptionsFactory
     */
    public function __construct(
        MigrationJobFactory $migrationJobFactory,
        AdditionalOptionsFactory $additionalOptionsFactory
    ) {
        parent::__construct();
        $this->migrationJobFactory = $migrationJobFactory;
        $this->additionalOptionsFactory = $additionalOptionsFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('firebear:migrate')->setDescription('Firebear Migration add-on');

        $this->addOption(
            self::OPTION_ENTITY,
            self::OPTION_ENTITY_SHORTCUT,
            InputOption::VALUE_REQUIRED,
            'What entity do you want to migrate?'
        );

        $this->addOption(
            self::OPTION_MIGRATE_FROM_DATA,
            self::OPTION_MIGRATE_FROM_DATA_SHORTCUT,
            InputOption::VALUE_OPTIONAL,
            'Add date for migration from input date.'
        );

        $this->addOption(
            self::OPTIONS_TEST_BUNCH_SIZE,
            self::OPTIONS_TEST_BUNCH_SIZE_SHORTCUT,
            InputOption::VALUE_OPTIONAL,
            'Specify test bunch size for job.'
        );

        parent::configure();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = $input->getOption(self::OPTION_ENTITY);

        $job = $this->migrationJobFactory->create($entity);

        $additionalOptions = $this->additionalOptionsFactory->create();

        $testBunchSize = $input->getOption(self::OPTIONS_TEST_BUNCH_SIZE);

        if ($testBunchSize) {
            $additionalOptions->setBatchSize((int) $testBunchSize);
        }

        $migrateDateFrom = $input->getOption(self::OPTION_MIGRATE_FROM_DATA);
        $additionalOptions->setMigrateFromDate((string) $migrateDateFrom);

        $job->job($output, $additionalOptions);

        return 0;
    }
}
