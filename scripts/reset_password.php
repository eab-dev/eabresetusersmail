#!/usr/bin/env php
<?php

require 'autoload.php';

$cli = eZCLI::instance();

$scriptSettings = array( 'description' => 'Change password for a user',
                         'use-session' => true,
                         'use-modules' => true,
                         'use-extensions' => true
                );
$script = eZScript::instance( $scriptSettings );
$script->startup();
$script->initialize();

$options = $script->getOptions( "[user:][password:]",
                                "",
                                array( 'user' => "Username to change password for",
                                       'password' => "New password" )
                            );

$userName = $options['user'];
$newPassword = $options['password'];

if ( !$userName || !$newPassword )
    $script->shutdown( 1, "Syntax: php extension/reset_password.php --user=username --password=password" );

$user = eZUser::fetchByName( $userName );
if ( !$user )
    $script->shutdown( 1, "No such user with username: " . $userName );

$userID = $user->ID();

$eZIni = eZINI::instance( 'site.ini' );
$minPasswordLength = $eZIni->variable( 'UserSettings', 'MinPasswordLength' );

if( strlen( $newPassword ) >= $minPasswordLength )
{
    // Change the user's password
    if ( eZOperationHandler::operationIsAvailable( 'user_password' ) )
        eZOperationHandler::execute( 'user', 'password', array( 'user_id' => $userID, 'new_password' => $newPassword ) );
    else
        eZUserOperationCollection::password( $userID, $newPassword );
}
else
    $script->shutdown( 1, "The new password is too short. It should be at least " . $minPasswordLength . " characters long." );

$script->shutdown();

?>
