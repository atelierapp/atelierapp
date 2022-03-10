<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database Seeders.
     *
     * @return void
     */
    public function run()
    {
        Color::updateOrCreate([
            'hex' => '#F9F9F9',
        ], [
            'name' => 'Fresh Kicks',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Ffresh%2Dkicks&afftrack=Atelier%2DClare%2DFreshKicks',
        ]);

        Color::updateOrCreate([
            'hex' => '#F7F8F9',
        ], [
            'name' => 'Snow Day',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fsnow%2Dday&afftrack=Atelier%2DClare%2DSnowDay',
        ]);

        Color::updateOrCreate([
            'hex' => '#F8F7F3',
        ], [
            'name' => 'Whipped',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fwhipped&afftrack=Atelier%2DClare%2DWhipped',
        ]);

        Color::updateOrCreate([
            'hex' => '#F6F3EZ',
        ], [
            'name' => 'Timeless',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Ftimeless&afftrack=Atelier%2DClare%2DTimeless',
        ]);

        Color::updateOrCreate([
            'hex' => '#E6E3DC',
        ], [
            'name' => 'On Point',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fon%2Dpoint&afftrack=Atelier%2DClare%2DOnPoint',
        ]);

        Color::updateOrCreate([
            'hex' => '#E7E8E3',
        ], [
            'name' => 'Classic',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fclassic&afftrack=Atelier%2DClare%2DClassic',
        ]);

        Color::updateOrCreate([
            'hex' => '#D2CBC3',
        ], [
            'name' => 'Beigeing',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fbeigeing&afftrack=Atelier%2DClare%2DBeigeing',
        ]);

        Color::updateOrCreate([
            'hex' => '#D8C8B1',
        ], [
            'name' => 'Turbinado',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fturbinado&afftrack=Atelier%2DClare%2DTurbinado',
        ]);

        Color::updateOrCreate([
            'hex' => '#DEDBCA',
        ], [
            'name' => 'No Filter',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fno%2Dfilter&afftrack=Atelier%2DClare%2DNoFilter',
        ]);

        Color::updateOrCreate([
            'hex' => '#E3D4C1',
        ], [
            'name' => 'Neutral Territory',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fneutral%2Dterritory&afftrack=Atelier%2DClare%2DNeutralTerritory',
        ]);

        Color::updateOrCreate([
            'hex' => '#C1BEB7',
        ], [
            'name' => 'Windy City',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fwindy%2Dcity&afftrack=Atelier%2DClare%2DWindyCity',
        ]);

        Color::updateOrCreate([
            'hex' => '#D2CABD',
        ], [
            'name' => 'Flatiron',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fflatiron&afftrack=Atelier%2DClare%2DFlatiron',
        ]);

        Color::updateOrCreate([
            'hex' => '#E4E5E0',
        ], [
            'name' => 'Penthouse',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fpenthouse&afftrack=Atelier%2DClare%2DPenthouse',
        ]);

        Color::updateOrCreate([
            'hex' => '#B4B0A5',
        ], [
            'name' => 'Greige',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fgreige&afftrack=Atelier%2DClare%2DGreige',
        ]);

        Color::updateOrCreate([
            'hex' => '#898883',
        ], [
            'name' => 'Shade',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fshade&afftrack=Atelier%2DClare%2DShade',
        ]);

        Color::updateOrCreate([
            'hex' => '#CFD0CB',
        ], [
            'name' => 'Seize the Gray',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fseize%2Dthe%2Dgray&afftrack=Atelier%2DClare%2DSeizeTheGray',
        ]);

        Color::updateOrCreate([
            'hex' => '#D7D9D6',
        ], [
            'name' => 'Chill',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fchill&afftrack=Atelier%2DClare%2DChill',
        ]);

        Color::updateOrCreate([
            'hex' => '#BEC9C3',
        ], [
            'name' => 'Grayish',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fgrayish&afftrack=Atelier%2DClare%2DGrayish',
        ]);

        Color::updateOrCreate([
            'hex' => '#B7BCB8',
        ], [
            'name' => 'Motor City',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fmotor%2Dcity&afftrack=Atelier%2DClare%2DMotorCity',
        ]);

        Color::updateOrCreate([
            'hex' => '#92999F',
        ], [
            'name' => 'Set in Stone',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fset%2Din%2Dstone&afftrack=Atelier%2DClare%2DSetInStone',
        ]);

        Color::updateOrCreate([
            'hex' => '#666E71',
        ], [
            'name' => 'Irony',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Firony&afftrack=Atelier%2DClare%2DIrony',
        ]);

        Color::updateOrCreate([
            'hex' => '#F0D296',
        ], [
            'name' => 'Lemonade',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Flemonade&afftrack=Atelier%2DClare%2DLemonade',
        ]);

        Color::updateOrCreate([
            'hex' => '#F7C86E',
        ], [
            'name' => 'Golden Hour',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fgolden%2Dhour&afftrack=Atelier%2DClare%2DGoldenHour',
        ]);

        Color::updateOrCreate([
            'hex' => '#B6C7B7',
        ], [
            'name' => 'Two Scoops',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Ftwo%2Dscoops&afftrack=Atelier%2DClare%2DTwoScoops',
        ]);

        Color::updateOrCreate([
            'hex' => '#D3DFDB',
        ], [
            'name' => 'Headspace',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fheadspace&afftrack=Atelier%2DClare%2DHeadspace',
        ]);

        Color::updateOrCreate([
            'hex' => '#A7C0BA',
        ], [
            'name' => 'Views',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fviews&afftrack=Atelier%2DClare%2DViews',
        ]);

        Color::updateOrCreate([
            'hex' => '#ABB39C',
        ], [
            'name' => 'Money Moves',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fmoney%2Dmoves&afftrack=Atelier%2DClare%2DMoneyMoves',
        ]);

        Color::updateOrCreate([
            'hex' => '#C2CBBA',
        ], [
            'name' => 'Dirty Martini',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fdirty%2Dmartini&afftrack=Atelier%2DClare%2DDirtyMartini',
        ]);

        Color::updateOrCreate([
            'hex' => '#95AB84',
        ], [
            'name' => 'Avocado Toast',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Favocado%2Dtoast&afftrack=Atelier%2DClare%2DAvocadoToast',
        ]);

        Color::updateOrCreate([
            'hex' => '#71A29F',
        ], [
            'name' => 'Vacay',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fvacay&afftrack=Atelier%2DClare%2DVacay',
        ]);

        Color::updateOrCreate([
            'hex' => '#4A5B53',
        ], [
            'name' => 'Current Mood',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fcurrent%2Dmood&afftrack=Atelier%2DClare%2DCurrentMood',
        ]);

        Color::updateOrCreate([
            'hex' => '#8BA69D',
        ], [
            'name' => 'Make Waves',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fmake%2Dwaves&afftrack=Atelier%2DClare%2DMakeWaves',
        ]);

        Color::updateOrCreate([
            'hex' => '#00566D',
        ], [
            'name' => 'Sublime',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fsublime&afftrack=Atelier%2DClare%2DSublime',
        ]);

        Color::updateOrCreate([
            'hex' => '#7FAD86',
        ], [
            'name' => 'Matcha Latte',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fmatcha%2Dlatte&afftrack=Atelier%2DClare%2DMatchaLatte',
        ]);

        Color::updateOrCreate([
            'hex' => '#BDD9DC',
        ], [
            'name' => 'Nairobi Blue',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fnairobi%2Dblue&afftrack=Atelier%2DClare%2DNairobiBlue',
        ]);

        Color::updateOrCreate([
            'hex' => '#D6E5EA',
        ], [
            'name' => 'Frozen',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Ffrozen&afftrack=Atelier%2DClare%2DFrozen',
        ]);

        Color::updateOrCreate([
            'hex' => '#9EBABE',
        ], [
            'name' => 'Summer Friday',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fsummer%2Dfriday&afftrack=Atelier%2DClare%2DSummerFriday',
        ]);

        Color::updateOrCreate([
            'hex' => '#879EA6',
        ], [
            'name' => 'Good Jeans',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fgood%2Djeans&afftrack=Atelier%2DClare%2DGoodJeans',
        ]);

        Color::updateOrCreate([
            'hex' => '#5B8A9C',
        ], [
            'name' => 'Blue Ivy',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fblue%2Divy&afftrack=Atelier%2DClare%2DBlueIvy',
        ]);

        Color::updateOrCreate([
            'hex' => '#1A517A',
        ], [
            'name' => 'Hyperlink',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fhyperlink&afftrack=Atelier%2DClare%2DHyperlink',
        ]);

        Color::updateOrCreate([
            'hex' => '#2F5560',
        ], [
            'name' => 'Deep Dive',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fdeep%2Ddive&afftrack=Atelier%2DClare%2DDeepDive',
        ]);

        Color::updateOrCreate([
            'hex' => '#27313D',
        ], [
            'name' => 'Goodnight Moon',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fgoodnight%2Dmoon&afftrack=Atelier%2DClare%2DGoodnightMoon',
        ]);

        Color::updateOrCreate([
            'hex' => '#C2C5CA',
        ], [
            'name' => 'Wink',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fwink&afftrack=Atelier%2DClare%2DWink',
        ]);

        Color::updateOrCreate([
            'hex' => '#838695',
        ], [
            'name' => 'Cosmic Vibes',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fcosmic%2Dvibes&afftrack=Atelier%2DClare%2DCosmicVibes',
        ]);

        Color::updateOrCreate([
            'hex' => '#5B4E5F',
        ], [
            'name' => 'Prince',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fprince&afftrack=Atelier%2DClare%2DPrince',
        ]);

        Color::updateOrCreate([
            'hex' => '#F8EBE2',
        ], [
            'name' => 'Wing It',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fwing%2Dit&afftrack=Atelier%2DClare%2DWingIt',
        ]);

        Color::updateOrCreate([
            'hex' => '#ECD9D3',
        ], [
            'name' => 'Baby Soft',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fbaby%2Dsoft&afftrack=Atelier%2DClare%2DBabySoft',
        ]);

        Color::updateOrCreate([
            'hex' => '#FFCDB4',
        ], [
            'name' => 'Pop',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fpop&afftrack=Atelier%2DClare%2Dpop',
        ]);

        Color::updateOrCreate([
            'hex' => '#FFB5AA',
        ], [
            'name' => 'Rosé Season',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Frose%2Dseason&afftrack=Atelier%2DClare%2DRoseSeason',
        ]);

        Color::updateOrCreate([
            'hex' => '#CE7F78',
        ], [
            'name' => 'Pink Sky',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fpink%2Dsky&afftrack=Atelier%2DClare%2DPinkSky',
        ]);

        Color::updateOrCreate([
            'hex' => '#812F99',
        ], [
            'name' => 'Big Apple',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fbig%2Dapple&afftrack=Atelier%2DClare%2DBigApple',
        ]);

        Color::updateOrCreate([
            'hex' => '#BC4C41',
        ], [
            'name' => 'Sriracha',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fsriracha&afftrack=Atelier%2DClare%2DSriracha',
        ]);

        Color::updateOrCreate([
            'hex' => '#4D3D34',
        ], [
            'name' => 'Coffee Date',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fcoffee%2Ddate&afftrack=Atelier%2DClare%2DCoffeeDate',
        ]);

        Color::updateOrCreate([
            'hex' => '#867A6E',
        ], [
            'name' => 'Dirty Chai',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fdirty%2Dchai&afftrack=Atelier%2DClare%2DDirtyChai',
        ]);

        Color::updateOrCreate([
            'hex' => '#1E1E1E',
        ], [
            'name' => 'Blackest',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fblackest&afftrack=Atelier%2DClare%2DBlackest',
        ]);

        Color::updateOrCreate([
            'hex' => '#2B2A28',
        ], [
            'name' => 'Blackish',
            'url' => 'https://shareasale.com/r.cfm?b=1201463&u=2039654&m=80720&urllink=www%2Eclare%2Ecom%2Fpaint%2Fwall%2Fblackish&afftrack=Atelier%2DClare%2DBlackish',
        ]);
    }
}
