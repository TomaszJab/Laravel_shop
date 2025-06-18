<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Statute;

class StatuteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert your data here using the DB facade
        // For example:
        // DB::table('example_table')->insert([
        //     'column1' => 'value1',
        //     'column2' => 'value2',
        // ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Statute::factory()->create([
            "content" => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla est purus, ultrices in porttitor
            in, accumsan non quam. Nam consectetur porttitor rhoncus. Curabitur eu est et leo feugiat
            auctor vel quis lorem. Ut et ligula dolor, sit amet consequat lorem. Aliquam porta eros sed
            velit imperdiet egestas. Maecenas tempus eros ut diam ullamcorper id dictum libero
            tempor. Donec quis augue quis magna condimentum lobortis. Quisque imperdiet ipsum vel
            magna viverra rutrum. Cras viverra molestie urna, vitae vestibulum turpis varius id.
            Vestibulum mollis, arcu iaculis bibendum varius, velit sapien blandit metus, ac posuere lorem
            nulla ac dolor. Maecenas urna elit, tincidunt in dapibus nec, vehicula eu dui. Duis lacinia
            fringilla massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur
            ridiculus mus. Ut consequat ultricies est, non rhoncus mauris congue porta. Vivamus viverra
            suscipit felis eget condimentum. Cum sociis natoque penatibus et magnis dis parturient
            montes, nascetur ridiculus mus. Integer bibendum sagittis ligula, non faucibus nulla volutpat
            vitae. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.  
            In aliquet quam et velit bibendum accumsan. Cum sociis natoque penatibus et magnis dis
            parturient montes, nascetur ridiculus mus. Vestibulum vitae ipsum nec arcu semper
            adipiscing at ac lacus. Praesent id pellentesque orci. Morbi congue viverra nisl nec rhoncus.
            Integer mattis, ipsum a tincidunt commodo, lacus arcu elementum elit, at mollis eros ante ac
            risus. In volutpat, ante at pretium ultricies, velit magna suscipit enim, aliquet blandit massa
            orci nec lorem. Nulla facilisi. Duis eu vehicula arcu. Nulla facilisi. Maecenas pellentesque
            volutpat felis, quis tristique ligula luctus vel. Sed nec mi eros. Integer augue enim, sollicitudin
            ullamcorper mattis eget, aliquam in est. Morbi sollicitudin libero nec augue dignissim ut
            consectetur dui volutpat. Nulla facilisi. Mauris egestas vestibulum neque cursus tincidunt.
            Donec sit amet pulvinar orci.',
            'valid' => '1',
        ]);

        Statute::factory()->create([
            "content" => 'ABC',
            'valid' => '0',
        ]);

        Statute::factory()->create([
            "content" => 'CBA',
            'valid' => '0',
        ]);
    }
}