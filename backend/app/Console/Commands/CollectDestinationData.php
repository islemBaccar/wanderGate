<?php

namespace App\Console\Commands;

use App\Models\Destination;
use App\Services\DestinationDataCollector;
use Illuminate\Console\Command;

class CollectDestinationData extends Command
{
  protected $signature = 'destinations:collect {name : The name of the destination}';
  protected $description = 'Collect data for a new destination using external APIs';

  private $collector;

  public function __construct(DestinationDataCollector $collector)
  {
    parent::__construct();
    $this->collector = $collector;
  }

  public function handle()
  {
    $destinationName = $this->argument('name');

    $this->info("Collecting data for {$destinationName}...");

    try {
      $data = $this->collector->collectDestinationData($destinationName);

      // Create new destination
      $destination = Destination::create($data);

      $this->info("Successfully created destination: {$destination->name}");
      $this->table(
        ['Attribute', 'Value'],
        collect($data)->map(fn($value, $key) => [$key, is_array($value) ? json_encode($value) : $value])->toArray()
      );
    } catch (\Exception $e) {
      $this->error("Failed to collect data: {$e->getMessage()}");
      return 1;
    }

    return 0;
  }
}
