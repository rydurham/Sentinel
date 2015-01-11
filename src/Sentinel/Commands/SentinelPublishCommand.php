<?php namespace Sentinel\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Filesystem\Filesystem;
use ReflectionClass;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SentinelPublishCommand extends Command {

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
        $sentinelFilename = with(new ReflectionClass('Sentinel\SentinelServiceProvider'))->getFileName();
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
	public function fire()
	{
		// Don't allow this command to run in a production environment
        if ( ! $this->confirmToProceed()) return;

        // Gather options passed to the command
        $theme = strtolower($this->option('theme'));
        $list = $this->option('list');

        // Are they only asking for a list of themes?
        if ($list) {
            $this->info('Currently supported themes:');

            foreach($this->themes as $theme)
            {
                $this->info(' | ' . ucwords($theme));
            }

            return;
        }

        // Is the theme valid?
        if (! in_array($theme, $this->themes))
        {
            $this->info(ucwords($theme) . ' is not a supported theme.');
            return;
        }

        // Publish the config files
        $this->publishConfig();

        // Publish the theme views
        $this->publishViews($theme);

        // Publish the theme assets
        $this->publishAssets($theme);

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
		return array(
			array('theme', null, InputOption::VALUE_OPTIONAL, 'The name of the UI theme you want to use with Sentinel.', 'bootstrap'),
			array('list', null, InputOption::VALUE_NONE, 'Show a list of currently supported UI Themes.'),
		);
	}

    /**
     * Publish the Sentinel Config files
     */
    private function publishConfig()
    {
        // Prepare for copying files
        $source      = $this->packagePath . '/../config';
        $destination = $this->appPath . '/config/packages/rydurham/sentinel';

        // If there are already config files published, confirm that we want to overwrite them.
        if ($this->file->isDirectory($destination))
        {
            $answer = $this->confirm('Config files have already been published. Do you want to overwrite? (y/n)');

            if ( ! $answer) { return; }
        }

        // Copy the configuration files
        $this->file->copyDirectory($source, $destination);

        // Notify action completion
        $this->info('Sentinel Configuration Files Published.');
    }

    /**
     * Publish the sentinel Views for a specified theme
     * @param $theme
     */
    private function publishViews($theme)
    {
        // Prepare for copying files
        $source      = $this->packagePath . '/../views/' . $theme;
        $destination = $this->appPath . '/views/packages/rydurham/sentinel';

        // If there are already views published, confirm that we want to overwrite them.
        if ($this->file->isDirectory($destination))
        {
            $answer = $this->confirm('Views have already been published. Do you want to overwrite? (y/n)');

            if ( ! $answer) { return; }
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
        if ($this->file->isDirectory($destination))
        {
            $answer = $this->confirm('Theme assets have already been published. Do you want to overwrite? (y/n)');

            if ( ! $answer) { return; }
        }

        // Copy the asset files for the selected theme
        $this->file->copyDirectory($source, $destination);

        // Notify action completion
        $this->info('Sentinel ' . ucwords($theme) . ' assets published.');
    }


}
