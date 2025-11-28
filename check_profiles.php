<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

echo "Profile pictures in database:\n";
echo "============================\n";

$users = DB::table('users')->whereNotNull('profile_picture')->get();

foreach($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Profile Picture: {$user->profile_picture}\n";
    echo "Full Path: " . asset('storage/' . $user->profile_picture) . "\n";
    echo "File Exists: " . (file_exists(public_path('storage/' . $user->profile_picture)) ? 'YES' : 'NO') . "\n";
    echo "---\n";
}
