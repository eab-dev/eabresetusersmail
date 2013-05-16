<?php
/*

This file created is for reseting all user emails to one email which you want to be, you can run "php bin/php/ezexec.php extension/eabresetusersmail/scripts/reset_users_mail.php" in putty 
and you can set the email in  extension/eabresetusersmail/settings/resetusersmail.ini.append.php .
这个php 文件是用来重新设置所有user 用户的email 信息的，可以通过在putty 中执行   php bin/php/ezexec.php extension/eabresetusersmail/scripts/reset_users_mail.php  完成 
而且可以在extension/eabresetusersmail/settings/resetusersmail.ini.append.php  中设置你想要设置的email 值。

*/

$cli = eZCLI::instance(); // provide interface with CLI

$db = eZDB::instance();
$db->begin();
$ResetUsersMailIni = eZINI::instance( 'resetusersmail.ini' );
$ResetMailAddress = $ResetUsersMailIni->variable( 'Info', 'ResetMailAddress' );

if ( !$isQuiet )
    $cli->output( "Reset users email to ". $ResetMailAddress );

$dataTypeString = 'ezuser' ;
$ContainUserAccountClasseIDs = eZContentClass::fetchIDListContainingDatatype ( $dataTypeString );

foreach( $ContainUserAccountClasseIDs as $ContainUserAccountClasseID )
{
	$Attributes = eZContentClass::fetchAttributes ( $ContainUserAccountClasseID, true, eZContentClass::VERSION_STATUS_DEFINED );
	$ezuser_attributes = array();
	
	foreach( $Attributes as $Attribute )
	{
		if( $Attribute->attribute( 'data_type_string' ) == 'ezuser' )
		{
			$AttributeName = $Attribute->attribute( 'name' ) ;
			$AttributeIdentifier = $Attribute->attribute( 'identifier' ) ;
			
			$ezuser_attributes[] = $AttributeIdentifier;		
		}	
	}	
	
	$objects = eZContentObject::fetchSameClassList( $ContainUserAccountClasseID , true , false ,false );
	foreach ( $objects as $object )
	{
		$UserDataMap = $object->attribute('data_map');
	
		foreach ( $ezuser_attributes as $ezuser_attribute )
		{				
			$UserDataMap = $object->attribute('data_map');
						
			$UserContent = $UserDataMap[$ezuser_attribute]->attribute( 'content' );
			$UserEmail = $UserContent->attribute( 'email' );
						
			$UserContent->setAttribute( 'email', $ResetMailAddress );
			$UserContent->store();	
			
			$objectID = $object->attribute('id');
			$objectName = $object->attribute('name');
			$oldEmail = $UserEmail;
			$newEmail = $ResetMailAddress;
			$logmessage = "The user messages: user_id is ". $objectID ."; user_name is ". $objectName ."; old email is ". $oldEmail ."; new email is ". $newEmail ;
		}
		
		eZLog::write ( $logmessage, 'reset_user_email.log', 'var/log');	
	}		
//print_r("\n ".$UserEmail); 
}

$db->commit();
if ( !$isQuiet )
    $cli->output( "Done" );

//exit;

?>
