<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ScrapperAccounts;
use App\ScrapperTasks;
use App\Http\Controllers\PinterestController;

class ScheduledTaskController extends Controller
{
    /**
     * Process
     */
    public function index()
    {
        // $this->registerAccounts();
        $Pinterest = new PinterestController();

        $Accounts = ScrapperAccounts::where('origin_id', 1)
            ->where('status', 1)->get();

        foreach ($Accounts as $accs) {
            // echo "<pre>";

            $response = $Pinterest->scrappResource('board', $accs->username );
            // print_r($accs->tasks()->find(1)['interval']);
            // print_r($accs->tasks()->find(1)['type']);
            // echo "</pre>";
            // exit;
            if($response == true) {
                print_r('COMPLETADO::: '.$accs->username);
            }
        }

        // exit;
        echo "Hola";
    }

    public function registerTasks($account_id)
    {
        $Accounts = ScrapperAccounts::where('origin_id', 1)
            ->where('status', 1)->get();

        foreach ($Accounts as $account) {
            // echo "<pre>";
            // $this->registerTasks($account->id);
            // echo "</pre>";
            $igFeed = new ScrapperTasks();
            $igFeed->scheduled_at = \Carbon\Carbon::now();
            $igFeed->finished_at = \Carbon\Carbon::now()->addWeeks(10);
            $igFeed->account_id = $account_id;
            $igFeed->is_recurrent = 1;
            $igFeed->status = 1;
            $igFeed->interval = '3';
            $igFeed->unit = 'm';
            $igFeed->type = 'board';
            $igFeed->origin_id = 'pinterest';
            $igFeed->save();
        }
        
    }

    public function registerAccounts()
    {
        $accounts =[
            'gotravelplan/daily-outfit',
            'cabreradiana051/a-mi-gusto',
            'yarhed/atuendo-de-oficina',
            'lrt77/springsummer-fashion',
            'lrt77/fallwinter-fashion',
            'urbanoutfitters/looks-we-love',
            'outfits_hunter/fashion-blogger',
            'outfits_hunter/bohemians-style',
            'outfits_hunter/labels',
            'outfits_hunter/spring-style',
            'fanathjo/super-chic-y-fachion',
            'urbanoutfitters/dresses',
            'urbanoutfitters/femme',
            'iabarronla/moda',
            'gabbys7/outfita',
            'samanthaporras/all-things-fashion',
            'stefano2270/e-cosi-che-ti-voglio-ma-solo-per-me',
            'focusupnow/fashion',
            'jordanhayleyyy/fashion',
            'thelsd/fashion-streetstyle',
            'EmilySchuman/fall-winter-fashion',
            'ninagarcia/white-is-chic-all-year-round',
            'ninagarcia/style-is-on-the-streets',
            'stylewithclass/parisian-chic',
            'fairieieles/best-fashion-community',
            'gracenjoiner/passion-for-fashion',
            'jimenitabebe/outfits',
            'nataliiaverteletska/womens-fashion',
            'eatsleepwear/fashion',
            'feeforyou',
            'fashioncutt3r/trend-is-in-the-air',
            'fashioncutt3r/endless-summer',
            'juliannecarell/style-inspiration',
            'songofstyle/song-of-style',
            'Nadiasmassage/love-fashion',
            'aliciatenise/style-inspiration',
            'chistreetstyle/everyday-street-style',
            'winghead19/fashion-casual-wear-everyday',
            'altdawn/style',
            'stylewithclass/chic-on-the-streets',
            'ashleyjeanie/fashion',
            'lauragr58/outfits-con-ropa-q-tengo',
            'successdress/street-fashion',
            'fashionforlove/fashionistas',
        ];


        foreach ($accounts as $account) {

            $IgFeed = new ScrapperAccounts;
            
            $IgFeed->type = 'board';
            $IgFeed->origin_id = 1; // 'pinterest'
            $IgFeed->username = $account;
            $IgFeed->status = 1;

            $IgFeed->save();
            
        }
        
        echo "<pre>";
        print_r($accounts);
        echo "</pre>";
        exit;

    }
}
