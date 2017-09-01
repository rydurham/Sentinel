<?php

namespace Sentinel\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Filesystem\Filesystem;
use ReflectionClass;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SentinelPublishCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sentinel:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish assets and config files for the Sentinel Package';

    /**
     * The UI themes supported by Sentinel
     *
     * @var string
     */
    private $themes = ['bootstrap', 'foundation', 'materialize', 'gumby', 'blank'];

    /**
     * The base path of the parent application
     *
     * @var string
     */
    private $appPath;

    /**
     * The path to the Sentinel's src directory
     *
     * @var string
     */
    private $packagePath;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $file
     */
    public function __construct(Filesystem $file)
    {
        parent::__construct();

        // DI Member Assignment
        $this->file = $file;

        // Set Application Path
        $this->appPath = app_path();

        // Set the path to the Sentinel Package namespace root
        $sentinelFilename  = with(new ReflectionClass('Sentinel\SentinelServiceProvider'))->getFileName();
        $this->packagePath = dirname($sentinelFilename);
    }

    /*
     * This trait allows us to easily check the current environment
     */
    use ConfirmableTrait;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Don't allow this command to run in a production environment
        if (!$this->confirmToProceed()) {
            return;
        }

        // Gather options passed to the command
        $theme = strtolower($this->option('theme'));
        $list  = $this->option('list');

        // Are they only asking for a list of themes?
        if ($list) {
            $this->info('Currently supported themes:');

            // Print the list of the current theme options
            foreach ($this->themes as $theme) {
                $this->info(' | ' . ucwords($theme));
            }

            return;
        }

        // Is the theme selection valid?
        if (!in_array($theme, $this->themes)) {
            $this->info(ucwords($theme) . ' is not a supported theme.');

            return;
        }

        // Publish the Sentinel Config
        $this->publishSentinelConfig();

        // Publish the Sentinel Config
        $this->publishSentryConfig();

        // Publish the Mitch/Hashids config files
        $this->publishHashidsConfig();

        // Publish the theme views
        $this->publishViews($theme);

        // Publish the theme assets
        $this->publishAssets($theme);

        // Optionally publish the migrations
        $this->publishMigrations();

        // All done!
        $this->info('Sentinel is now ready to use!');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['theme', null, InputOption::VALUE_OPTIONAL, 'The name of the UI theme you want to use with Sentinel.', 'bootstrap'],

            ['list', null, InputOption::VALUE_NONE, 'Show a list of currently supported UI Themes.'],

            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
        ];
    }

    /**
     * Publish the Sentinel Config file
     */
    private function publishSentinelConfig()
    {
        // Prepare for copying
        $source      = realpath($this->packagePath . '/../config/sentinel.php');
        $destination = base_path() . '/config/sentinel.php';

        // If this file has already been published, confirm that we want to overwrite.
        if ($this->file->isFile($destination)) {
            $answer = $this->confirm('Sentinel config has already been published. Do you want to overwrite?');

            if (!$answer) {
                return;
            }
        }

        // Copy the configuration files
        $this->file->copy($source, $destination);

        // Notify action completion
        $this->info('Sentinel configuration file published.');
    }

    /**
     * Publish the Sentry Config file
     */
    private function publishSentryConfig()
    {
        // Prepare for copying
        $source      = realpath($this->packagePath . '/../config/sentry.php');
        $destination = base_path() . '/config/sentry.php';

        // If this file has already been published, confirm that we want to overwrite.
        if ($this->file->isFile($destination)) {
            $answer = $this->confirm('Sentry config has already been published. Do you want to overwrite?');

            if (!$answer) {
                return;
            }
        }

        // Copy the configuration files
        $this->file->copy($source, $destination);

        // Notify action completion
        $this->info('Sentry configuration file published.');
    }


    /**
     * Publish the config file for Vinkla/Hashids
     */
    public function publishHashidsConfig()
    {
        // Prepare file paths
        $source            = realpath($this->packagePath . '/../config/hashids.php');
        $destination       = base_path() . '/config/hashids.php';

        // If there are already config files published, confirm that we want to overwrite them.
        if ($this->file->isFile($destination)) {
            $answer = $this->confirm('Hashid Config file has already been published. Do you want to overwrite?');

            if (!$answer) {
                return;
            }
        }

        // Copy the configuration files
        $this->file->copy($source, $destination);

        // Notify action completion
        $this->info('Vinkla/Hashids configuration file published.');
    }

    /**
     * Publish the sentinel Views for a specified theme
     * @param $theme
     */
    private function publishViews($theme)
    {
        // Prepare for copying files
        $source      = $this->packagePath . '/../views/' . $theme;
        $destination = base_path() . '/resources/views/sentinel';

        // If there are already views published, confirm that we want to overwrite them.
        if ($this->file->isDirectory($destination)) {
            $answer = $this->confirm('Views have already been published. Do you want to overwrite?');

            if (!$answer) {
                return;
            }
        }

        // Copy the view files for the selected theme
        $this->file->copyDirectory($source, $destination);

        // Notify action completion
        $this->info('Sentinel ' . ucwords($theme) . ' views published.');
    }

    /**
     * Publish the assets needed for a specified theme.
     * @param $theme
     */
    private function publishAssets($theme)
    {
        // Prepare for copying files
        $source      = $this->packagePath . '/../../public/' . $theme;
        $destination = $this->appPath . '/../public/packages/rydurham/sentinel';

        // If there are already assets published, confirm that we want to overwrite.
        if ($this->file->isDirectory($destination)) {
            $answer = $this->confirm('Theme assets have already been published. Do you want to overwrite?');

            if (!$answer) {
                return;
            }
        }

        // Copy the asset files for the selected theme
        $this->file->copyDirectory($source, $destination);

        // Notify action completion
        $this->info('Sentinel ' . ucwords($theme) . ' assets published.');
    }

    /**
     * Optionally copy the migration files to the main migration directory
     */
    private function publishMigrations()
    {
        if ($this->confirm('Would you like to publish the migration files?')) {

            // Prepare for copying files
            $source      = $this->packagePath . '/../../migrations/';
            $destination = $this->appPath . '/../database/migrations';

            // Copy the asset files for the selected theme
            $this->file->copyDirectory($source, $destination);

            // Notify action completion
            $this->info('Migration files have been published.');
        }
    }
}
