<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class NotificationController extends Controller
{

    public function index(){
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/sample-project-d89a3.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://sample-project-d89a3.firebaseio.com')
            ->create();

        $database = $firebase->getDatabase();
        $reference = $database->getReference('notification');
        $snapshot = $reference->getSnapshot();

        $value = $snapshot->getValue();

//        $database = $firebase->getDatabase();
        $newPost = $database
            ->getReference('notification')
            ->push([
                'title' => 'Post title',
                'body' => 'This should probably be longer.'
            ]);

//         dd($newPost->getvalue());

    }
}
