<?php

namespace Elegantly\Translator\Commands;

use Illuminate\Contracts\Console\PromptsForMissingInput;

use function Laravel\Prompts\intro;
use function Laravel\Prompts\note;
use function Laravel\Prompts\table;

/**
 * Display translations strings found in codebase but not in a locale
 */
class MissingCommand extends TranslatorCommand implements PromptsForMissingInput
{
    public $signature = 'translator:missing {source} {target} {--driver=}';

    public $description = 'Display all the translation keys not found in the codebase.';

    public function handle(): int
    {
        $source = (string) $this->argument('source');
        $target = (string) $this->argument('target');

        $translator = $this->getTranslator();

        $missing = $translator->getMissingTranslations($source, $target);

        intro('Using driver: '.$translator->driver::class);

        note(count($missing).' missing translations keys detected.');

        table(
            headers: ['Key', "Source {$source}", "Target {$target}"],
            rows: collect($missing)
                ->map(function ($value, $key) {
                    return [$key, $value];
                })->all()
        );

        return self::SUCCESS;
    }
}
