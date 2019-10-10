<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Notification extends Model
{
        protected $fillable = ['from_id', 'message'];

        public function user()
        {
            return $this->belongsTo(User::class,'from_id','id');
        }
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    public $timestamps = false;
    public function getDatedAttribute($timestamp) {
        return (new Carbon($timestamp))->format('d-M-Y h:i A');
    }

    public static function Notify($ToType = null,$ToID = 1, $Message, $Link, $FromID = null,$class,$icon) {

        $dates = new \DateTime;
        $FromID = (empty($FromID) ? auth()->user()->id : $FromID);
        $ToType = (empty($ToType) ? 1 : $ToType);
        $Nontification = new self();
        $Nontification->to_type = $ToType;
        $Nontification->from_type = 2;
        $Nontification->to_id = $ToID;
        $Nontification->from_id = $FromID;
        $Nontification->message = $Message;
        $Nontification->link = $Link;
        $Nontification->class = $class;
        $Nontification->icon = $icon;
        $Nontification->dated = $dates;
        $Nontification->save();



        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/Http/Controllers/sample-project-d89a3.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://sample-project-d89a3.firebaseio.com')
            ->create();

        $database = $firebase->getDatabase();
        $database
            ->getReference('notifications')
            ->push([
                'notification_id' => $Nontification->notification_id,
                'to_type' => $ToType,
                'from_type' => 2,
                'to_id' => $ToID,
                'from_id' => $FromID,
                // 'from_type' => 2,
                // 'to_type' => 1,
                // 'to_id' => $FromID,
                // 'from_id' => $ToID,
                'message' => $Message,
                'link' => $Link,
                'class' => $class,
                'icon' => $icon,
                'is_read' => 0,
                'is_sadmin_read' => 0,
                'dated' => $dates,

            ]);
    }
}
