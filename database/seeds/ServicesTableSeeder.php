<?php

use Illuminate\Database\Seeder;
use App\Service;
use App\Enums\PriceType;
// use Faker\Generator as Faker;
use App\AdditionalService;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->get_services() as $name) {            
            $this->generate($name);            
        }
        $this->generate('Example of Per page writing service', PriceType::PerPage);
        $this->generate('Example of Per word writing service', PriceType::PerWord);
        $this->generate('Example of Fixed Price writing service', PriceType::Fixed);

    }

    private function generate($name, $price_type_id = null)
    {
        $faker = Faker\Factory::create();
        $price =  null;
        $single_spacing_price = null;
        $double_spacing_price = null;
        $minimum_order_quantity = null;

        if(is_null($price_type_id))
        {
            $price_type_id = $faker->randomElement([PriceType::Fixed, PriceType::PerPage, PriceType::PerWord]);
        }        

        if ($price_type_id == PriceType::Fixed) {
            $price = $faker->randomFloat(2, 10, 150);
            $minimum_order_quantity = 1;
        } elseif ($price_type_id == PriceType::PerPage) {
            $single_spacing_price = $faker->randomFloat(2, 30, 100);
            $double_spacing_price = $single_spacing_price + 10;
            $minimum_order_quantity = 1;
        } else {
            $price = $faker->randomFloat(2, 0.5, 5);
            $minimum_order_quantity = 500;
        }

        $service = Service::create([
            'name' => $name,
            'price_type_id' => $price_type_id,
            'price' => $price,
            'single_spacing_price' => $single_spacing_price,
            'double_spacing_price' =>  $double_spacing_price,
            'minimum_order_quantity' => $minimum_order_quantity
        ]);
        
        $additionalServices = AdditionalService::pluck('id');
        $count = $faker->randomElement([1,2,3]);
        $list = $faker->randomElements($additionalServices->toArray(), $count);
        $service->additionalServices()->attach($list); 
    }

    private function get_services()
    {
        return [
            'Tutoring',
            'Copywriting',
            'Argumentative Essay',
            'Admission/Application Essay',
            'Annotated Bibliography',
            'Article',
            'Assignment',
            'Book Report/Review',
            'Case Study',
            'Capstone Project',
            'Business Plan',
            'Coursework',
            'Dissertation',
            'Dissertation Chapter - Abstract',
            'Dissertation Chapter - Introduction Chapter',
            'Dissertation Chapter - Literature Review',
            'Dissertation Chapter - Methodology',
            'Dissertation Chapter - Results',
            'Dissertation Chapter - Discussion',
            'Editing',
            'Essay',
            'Formatting',
            'Lab Report',
            'Math Problem',
            'Movie Review',
            'Multiple Choice Questions',
            'Personal Statement',
            'Non-word assignment',
            'Outline',
            'PowerPoint Presentation Plain',
            'Poster / Map',
            'PowerPoint Presentation with Speaker Notes',
            'Proofreading',
            'Paraphrasing',
            'Report',
            'Research Paper',
            'Research Proposal',
            'Scholarship Essay',
            'Rewriting',
            'Speech',
            'Statistics Project',
            'Term Paper',
            'Thesis',
            'Thesis Proposal',
            'Resume Editing',
            'All Application Job Package',
            'Resume Writing',
            'Cover Letter Writing'
        ];
    }
}
