<?php

namespace Database\Seeders;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends CsvSeeder
{

    public function __construct()
	{

        // $table->dateTime('tx_finish');
        // $table->integer('amount');
        // $table->string('type'); //This can made to an enum type
        // $table->string('service');
        // $table->string('category');

        $this->table = 'transactions';
        $this->csv_delimiter = ',';
        $this->filename = base_path().'/database/seeders/csvs/sample_data.csv';
        $this->offset_rows = 1;
        $this->mapping = [
            0 => 'tx_finish',
            1 => 'amount',
            2 => 'type',
            3 => 'service',
            4 => 'category',
        ];



        $this->should_trim = true;
        $this->timestamps = true;
        $this->created_at =  \Carbon\Carbon::now();
        $this->updated_at =  \Carbon\Carbon::now();

	}

    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Recommended when importing larger CSVs
		DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		DB::table($this->table)->truncate();

		parent::run();
    }
}
