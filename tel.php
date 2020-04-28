/* Readme:
   Disclaimer: This script can send a message to the user by his user name 
   Please note: This script uses legal methods to send message in Telegram
    allowed by Pavel Durov, e.g. chat bot will send messages if it would be
    added to specific chat room, while $username will be used to get attention 
    of specified user like @username <your_message>
   Required parameters:
     token - is bot token you have created using chat bot - see instructions below
     chatnumber - is chat id of the chat where you have added your bot - see instructions below - you may use chat number without '-' script will set it for you
     username - user name for the user you want to send a message to - user must be in one chat with the bot
      you can invite the user to chat in the same way you did with bot
     msg - message you want to send
   Each parameter should be sent with preliminary '--' characters and the value should be passed using '=' character_set_name
   like --token='<bot_token>'
   Example:
        php tel.php --token='<your_bot_token>' --chatnumber='<your_chat_id>' --username='<user_name_in_chat>' --msg='<your_message>'
   Please note that all parameters are required and if do not provide any of them the script will stop working and show error message
  
   Instructions on how to get the required data:
   1. Open your telegram app
   2. Search for @botfather - simply put @botfather to search widget
   3. You will see BotFather and 'I can help you create and m...' below
   4. Click on it and press start
   5. Command @BotFather a /newbot
   6. You will receive 'Alright, a new bot. How are we going to call it? Please choose a name for your bot.'
   7. Answer with the name of your bot
   8. The system asks for the user name of your bot
   9. Answer with something that ends with _bot
   10. You will receive token   
   11. Then telegram menu (three lines)->New Group
   12. Search for your bot using the name you have taken in point 9 click on your bot and click Create Group   
   13. Then /join @bot_username_from_point_9 - you need to paste your bot name after @ it should end with _bot - for example @superbot_bot
   14. Then in browser https://api.telegram.org/bot<bot_no>/getUpdates
		instead of <bot_no> it needs to use token from points 5-10
   15. You will see JSON response - you need to find a line looking like "chat":{"id":-some_number
	   you need to take this -some_number, if you so wish wihtout '-' sign - script will add it for you
   16. Just to be sure do /join @<your_telegram_username> in the group chat you have created
   17. Now you have all the values you need to use with the script:
		token - bot token from points 5-10
		chatnumber - some_number from points 15-16 you may use chat number without '-' script will set it for you
		username - your very own user name in telegram - needs to be created using Menu->Settings->username_widget
		msg - something that you wish to send
    */
<?php
print "\n";
$defaults = array("token" => "","chatnumber" => "","username" => "","msg" => "");
$params = getopt("", array("token:","chatnumber:","username:","msg:"));
$opts = array_merge($defaults, $params);
$token = $opts['token'];
$chatnumber = $opts['chatnumber'];
$username = $opts['username'];
$msg = $opts['msg'];
if (!$token) {
	exit("Please provide token for your message\n");
}
if (!$chatnumber) {
	exit("Please provide chat number for your message\n");
}
if (!$username) {
	exit("Please provide user name to deliver message to given user\n");
}
if (!$msg) {
	exit("Please provide set message you wish to send\n");
}
if ($chatnumber[0] != "-") {
	$chatnumber = "-" . $chatnumber;
}
if ($username[0] != "@") {
	$username = "@" . $username;
}
exit(deliverme($token,$chatnumber,$username,$msg));
function deliverme($token,$chatnumber,$username,$msg) {
	$text = $username . " your message is '" . $msg . "'";
	print "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatnumber}&parse_mode=html&text={$text}" . "\n\n";
	$postmsg = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatnumber}&parse_mode=html&text={$text}","r");
	if ($postmsg) {
		return "Message has been sent\n";
	} else {
		return "Error sending message\n";
	}
}
?>
