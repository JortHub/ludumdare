<?php
require_once __DIR__ . "/../../lib.php";
require_once __DIR__ . "/../../db.php";

// Love is Likes. If you like something, you give it a Love.
// Love either belongs to to a user, or an IP address (to allow more love).

// By design, all UIDs can give a Love an item, or if not logged in (UID=0), 1 per IP.

// Potential Exploits:
// - Multiple User Accounts
// - 2 Love (1 Love logged in, 1 Love logged out)

// The "2 Love" exploit can be avoided by setting the minimum Love that has an effect >2.
// The "Multiple Accounts" exploit is not easily avoided. One solution may be to introduce a 
//   "unique PC" cookie, but that can still be exploited with multiple devices or incogneto mode.
// There is value in giving an item a lot of Love, but what's equally important is keeping this
//   script extremely light-weight. 
// With some effort, it would possible to strengthen the impact of certain user accounts (i.e.
//   users that have participated, or that are well Loved themselves). So when it comes to scoring
//   things, the point value isn't 1:1 Love, but the sum of a number of factors including Love.
//   This will be called "Magic".
// To be clear: Scoring here is a sorting score, not a rating. It's how we decide to prioritize.

$response = api_newResponse();

// Retrieve action //
$action = api_parseActionURL();

// If no item is set, exit
if ( !isset($action[1]) ) {
	api_emitJSON(api_newError());
	exit();
}

// Store Item
$response['item'] = intval($action[1]);

// If the item has an invalid Id, exit
if ( $response['item'] === 0 ) {
	api_emitJSON(api_newError());
	exit();
}

// Retrieve session, store UID
user_start();
$response['uid'] = user_getId();

// Store IP
$response['ip'] = $_SERVER['REMOTE_ADDR'];


if ( $response['uid'] === 0 ) {
	// <3 By IP Address //
}
else {
	// <3 By UID //
}

// On Add Action, insert in to the database
if ( $action[0] === 'add' ) {
	// Connect to database
	db_connect();

	// if action == add
	//    add/overwrite the like for id,user,ip
	//    return success/failure
	
	$success = true;

	$response['success'] = $success;
}
// On Remove Action, remove from the database
else if ( $action[0] === 'remove' ) {
	// Connect to database
	db_connect();

	// if action == remove
	//    remove like for id,user,ip
	//    return success/failure

	$success = true;

	$response['success'] = $success;
}
else {
	api_emitJSON(api_newError());
	exit();
}

api_emitJSON($response);
?>
