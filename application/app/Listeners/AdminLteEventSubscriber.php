<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use JeroenNoten\LaravelAdminLte\Events\DarkModeWasToggled;
use JeroenNoten\LaravelAdminLte\Events\ReadingDarkModePreference;

use App\Models\Preferencia;
use App\Models\User;

class AdminLteEventSubscriber
{
    protected $preferencia = null;
    protected $userID = 0;

    public function __construct(Preferencia $preferencia)
    {
       $this->preferencia = $preferencia;
    }

    /**
     * Handle the ReadingDarkModePreference AdminLTE event.
     *
     * @param ReadingDarkModePreference $event
     * @return void
     */
    public function handleReadingDarkModeEvt(ReadingDarkModePreference $event)
    {
        // TODO: Implement the next method to get the dark mode preference for the
        // current authenticated user. Usually this preference will be stored on a database,
        // it is your task to get it.

        $darkModeCfg = $this->getDarkModeSettingFromDB();


        // Setup initial dark mode preference.

        if ($darkModeCfg) {
            $event->darkMode->enable();
        } else {
            $event->darkMode->disable();
        }
    }

    /**
     * Handle the DarkModeWasToggled AdminLTE event.
     *
     * @param DarkModeWasToggled $event
     * @return void
     */
    public function handleDarkModeWasToggledEvt(DarkModeWasToggled $event)
    {
        // Get the new dark mode preference (enabled or not).

        $darkModeCfg = $event->darkMode->isEnabled();

        // Store the new dark mode preference on the database.

        $this->storeDarkModeSettingOnDB($darkModeCfg);

        // TODO: Implement previous method to store the new dark mode
        // preference for the authenticated user. Usually this preference will
        // be stored on a database, it is your task to store it.
    }

    private function getDarkModeSettingFromDB() : bool {
        // return Auth::check() && Auth::user()->dark_mode;
        $user = Preferencia::select('dark_mode')->find(Auth::user()->id);

    
        if (Auth::check() && Auth::user()) {
            // Obtém a preferência do modo escuro do usuário autenticado
            return $user->dark_mode;
        } else {
            // Caso o usuário não esteja autenticado, retorne um valor padrão (por exemplo, false)
            return false;
        }
        
        
    }

    private function storeDarkModeSettingOnDB(bool $darkModeCfg) : void {
        if(!Auth::check()){
            Log::debug('Can\'t update dark mode setting: there is no user authenticated!');
        }else{
            $user_id = Auth::user()->id;
            $user = Preferencia::select('*')->find($user_id);
            if(!$user){
                Log::debug('Can\'t update dark mode setting: there is no user found with id: '.$user_id);
            }else{
                $user->dark_mode = $darkModeCfg;
                $user->save();
            }
        }
    }
}