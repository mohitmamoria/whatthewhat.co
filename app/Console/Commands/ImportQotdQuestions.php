<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ImportQotdQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:qotd-import {filepath : The path to the QOTD questions file in the resources directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import QOTD questions from a specified file located in the resources directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filepath = $this->argument('filepath');

        $fullPath = resource_path($filepath);

        if (!file_exists($fullPath)) {
            $this->error("File not found: {$fullPath}");
            return 1;
        }

        // read the csv file
        $file = fopen($fullPath, 'r');
        if ($file === false) {
            $this->error("Could not open file: {$fullPath}");
            return 1;
        }

        // for each row in the csv file
        while (($row = fgetcsv($file)) !== false) {
            // assuming the csv has two columns: question and answer
            $date = Carbon::parse($row[0], 'Asia/Kolkata')->startOfDay();

            if (Question::where('asked_on', $date)->exists()) {
                $this->error("Question for date {$date->toDateString()} already exists. Skipping.");
                return 1;
            }

            $question = str($row[1])->trim();

            $options = [];
            for ($i = 2; $i <= count($row) - 1; $i++) {
                $body = str($row[$i])->trim();

                $options[] = [
                    'is_correct' => $body->startsWith('::'),
                    'body' => $body->replaceFirst('::', ''), // remove the leading '::' if present
                ];
            }

            $question = Question::create([
                'asked_on' => $date,
                'body' => $question,
                'options' => $options,
            ]);

            $this->info(sprintf("Imported question for date %s: %s", $date->toDateString(), $question->name));
        }

        fclose($file);
    }
}
