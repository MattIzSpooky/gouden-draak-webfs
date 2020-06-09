<?php

namespace App\Console\Commands;

use App\Dish;
use Exception;
use App\DishType;
use App\MenuItem;
use ErrorException;
use Illuminate\Console\Command;

class MenuSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the hole menu into the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->jsonDecodeFile(base_path() . '/database/seeds/menu/menu.json');

        $bar = $this->output->createProgressBar(count($data));
        $bar->start();

        $dishTypes = DishType::all()->toArray();
        $menuItems = [];
        $dishes = [];

        for ($i = 0; $i < count($data); $i++) {
            $dishId = $i == 0 ? 1 : $i + 1;

            $key = array_search(ucfirst(strtolower($data[$i]->soortgerecht)), array_column($dishTypes, 'type'));

            array_push($dishes, [
                'id' => $dishId,
                'name' => $data[$i]->naam,
                'description' => $data[$i]->beschrijving,
                'price' => $data[$i]->price,
                'dish_type_id' => $dishTypes[$key]['id']
            ]);

            array_push($menuItems, [
                'menu_number' => $data[$i]->menunummer,
                'addition' => $data[$i]->menu_toevoeging,
                'dish_id' => $dishId
            ]);

            $bar->advance();
        }

        Dish::insert($dishes);
        MenuItem::insert($menuItems);

        $bar->finish();
    }

    /**
     * Decode the specified json file
     *
     * @param string $filePath
     * @return array
     */
    private function jsonDecodeFile(string $filePath)
    {
        $data = null;

        try {
            $data = file_get_contents($filePath);
        } catch (ErrorException $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return json_decode($data);
    }
}
